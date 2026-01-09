<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'email', 'password', 'role_id', 'status', 
        'bio', 'phone', 'department', 'profile_image', 
        'email_verified', 'email_verified_at', 'last_login_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'name'     => 'required|min_length[2]|max_length[100]',
        'email'    => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[8]',
        'role_id'  => 'required|integer',
        'status'   => 'required|in_list[active,inactive]',
        'bio'      => 'max_length[1000]',
        'phone'    => 'max_length[20]',
        'department' => 'max_length[100]',
        'profile_image' => 'max_length[255]',
        'email_verified' => 'in_list[0,1]'
    ];
    protected $validationMessages   = [
        'name' => [
            'required'    => 'Name is required',
            'min_length'  => 'Name must be at least 2 characters',
            'max_length'  => 'Name cannot exceed 100 characters'
        ],
        'email' => [
            'required'    => 'Email is required',
            'valid_email' => 'Please enter a valid email address',
            'is_unique'   => 'Email already exists'
        ],
        'password' => [
            'required'    => 'Password is required',
            'min_length'  => 'Password must be at least 8 characters'
        ],
        'role_id' => [
            'required' => 'Role is required',
            'integer'  => 'Invalid role selected'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list'  => 'Invalid status selected'
        ],
        'bio' => [
            'max_length' => 'Bio cannot exceed 1000 characters'
        ],
        'phone' => [
            'max_length' => 'Phone number cannot exceed 20 characters'
        ],
        'department' => [
            'max_length' => 'Department cannot exceed 100 characters'
        ],
        'profile_image' => [
            'max_length' => 'Profile image path is too long'
        ],
        'email_verified' => [
            'in_list' => 'Invalid email verification status'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['hashPassword'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Hash password before insert/update
     */
    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    /**
     * Get user by email
     */
    public function getUserByEmail(string $email): ?array
    {
        return $this->select('users.*, roles.name as role_name')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->where('users.email', $email)
                    ->where('users.status', 'active')
                    ->first();
    }

    /**
     * Get user with role
     */
    public function getUserWithRole(int $id): ?array
    {
        return $this->select('users.*, roles.name as role_name')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->where('users.id', $id)
                    ->first();
    }

    /**
     * Verify user password
     */
    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Get users by role
     */
    public function getUsersByRole(string $roleName): array
    {
        return $this->select('users.*, roles.name as role_name')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->where('roles.name', $roleName)
                    ->where('users.status', 'active')
                    ->findAll();
    }

    /**
     * Update user status
     */
    public function updateStatus(int $id, string $status): bool
    {
        return $this->update($id, ['status' => $status]);
    }

    /**
     * Get users with roles for admin listing
     */
    public function getUsersWithRoles(): array
    {
        return $this->select('users.*, roles.name as role_name')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->orderBy('users.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get user with detailed information
     */
    public function getUserWithDetails(int $id): ?array
    {
        return $this->select('users.*, roles.name as role_name, roles.id as role_id_name')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->where('users.id', $id)
                    ->first();
    }

    /**
     * Get user by username (using name field)
     */
    public function getUserByUsername(string $username): ?array
    {
        return $this->where('name', $username)
                    ->where('status', 'active')
                    ->first();
    }

    /**
     * Get user statistics
     */
    public function getUserStats(): array
    {
        return [
            'total' => $this->countAllResults(),
            'active' => $this->where('status', 'active')->countAllResults(),
            'inactive' => $this->where('status', 'inactive')->countAllResults(),
            'admins' => $this->join('roles', 'roles.id = users.role_id')->where('roles.name', 'admin')->countAllResults(),
            'managers' => $this->join('roles', 'roles.id = users.role_id')->where('roles.name', 'manager')->countAllResults(),
            'users' => $this->join('roles', 'roles.id = users.role_id')->where('roles.name', 'user')->countAllResults()
        ];
    }

    /**
     * Search users
     */
    public function searchUsers(string $term): array
    {
        return $this->select('users.*, roles.name as role_name')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->groupStart()
                        ->like('users.name', $term)
                        ->orLike('users.email', $term)
                    ->groupEnd()
                    ->orderBy('users.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Update last login time (add column if needed)
     */
    public function updateLastLogin(int $id): bool
    {
        // Since last_login column doesn't exist in migration, we'll skip this for now
        // or you can add the column to the users table migration
        return true;
    }

    /**
     * Get users for export
     */
    public function getUsersForExport(): array
    {
        return $this->select('users.id, users.name, users.email, users.status, users.created_at, roles.name as role_name')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->orderBy('users.created_at', 'DESC')
                    ->findAll();
    }
}