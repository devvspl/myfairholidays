<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table            = 'permissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'display_name', 'description', 'category'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'name'         => 'required|min_length[3]|max_length[100]|is_unique[permissions.name]',
        'display_name' => 'required|min_length[3]|max_length[150]',
        'category'     => 'required|max_length[50]'
    ];
    protected $validationMessages   = [
        'name' => [
            'required'    => 'Permission name is required',
            'min_length'  => 'Permission name must be at least 3 characters',
            'max_length'  => 'Permission name cannot exceed 100 characters',
            'is_unique'   => 'Permission name already exists'
        ],
        'display_name' => [
            'required'    => 'Display name is required',
            'min_length'  => 'Display name must be at least 3 characters',
            'max_length'  => 'Display name cannot exceed 150 characters'
        ],
        'category' => [
            'required'   => 'Category is required',
            'max_length' => 'Category cannot exceed 50 characters'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get permissions by category
     */
    public function getByCategory(string $category): array
    {
        return $this->where('category', $category)->findAll();
    }

    /**
     * Get all permissions grouped by category
     */
    public function getAllGroupedByCategory(): array
    {
        $permissions = $this->orderBy('category, display_name')->findAll();
        $grouped = [];
        
        foreach ($permissions as $permission) {
            $grouped[$permission['category']][] = $permission;
        }
        
        return $grouped;
    }

    /**
     * Get permission by name
     */
    public function getByName(string $name): ?array
    {
        return $this->where('name', $name)->first();
    }

    /**
     * Get permissions for a role
     */
    public function getForRole(int $roleId): array
    {
        return $this->select('permissions.*')
                    ->join('role_permissions', 'role_permissions.permission_id = permissions.id')
                    ->where('role_permissions.role_id', $roleId)
                    ->findAll();
    }

    /**
     * Check if permission exists
     */
    public function exists(string $name): bool
    {
        return $this->where('name', $name)->countAllResults() > 0;
    }
}
