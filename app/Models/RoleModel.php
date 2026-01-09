<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table            = 'roles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description', 'permissions', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'name' => 'required|min_length[3]|max_length[50]|is_unique[roles.name]',
        'description' => 'permit_empty|max_length[500]',
        'status' => 'permit_empty|in_list[active,inactive]'
    ];
    protected $validationMessages   = [
        'name' => [
            'required'    => 'Role name is required',
            'min_length'  => 'Role name must be at least 3 characters',
            'max_length'  => 'Role name cannot exceed 50 characters',
            'is_unique'   => 'Role name already exists'
        ],
        'description' => [
            'max_length'  => 'Description cannot exceed 500 characters'
        ],
        'status' => [
            'in_list'     => 'Status must be either active or inactive'
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
     * Get role by name
     */
    public function getRoleByName(string $name): ?array
    {
        return $this->where('name', $name)->first();
    }

    /**
     * Get all active roles
     */
    public function getActiveRoles(): array
    {
        return $this->findAll();
    }
}