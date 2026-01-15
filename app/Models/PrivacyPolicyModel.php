<?php

namespace App\Models;

use CodeIgniter\Model;

class PrivacyPolicyModel extends Model
{
    protected $table            = 'privacy_policy';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'content',
        'banner_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'title'   => 'required|min_length[3]|max_length[255]',
        'content' => 'required|min_length[10]',
        'status'  => 'required|in_list[active,inactive]',
    ];

    protected $validationMessages = [
        'title' => [
            'required'    => 'Title is required',
            'min_length'  => 'Title must be at least 3 characters',
            'max_length'  => 'Title cannot exceed 255 characters'
        ],
        'content' => [
            'required'    => 'Content is required',
            'min_length'  => 'Content must be at least 10 characters'
        ],
        'status' => [
            'required'  => 'Status is required',
            'in_list'   => 'Status must be either active or inactive'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['preventMultipleRows'];
    protected $beforeUpdate   = [];

    /**
     * Prevent multiple rows - only one Privacy Policy allowed
     */
    protected function preventMultipleRows(array $data): array
    {
        $count = $this->countAllResults();
        if ($count > 0) {
            throw new \RuntimeException('Only one Privacy Policy record is allowed. Please update the existing record instead.');
        }
        return $data;
    }

    /**
     * Get the Privacy Policy (always returns the single row)
     */
    public function getPolicy(): ?array
    {
        return $this->first();
    }

    /**
     * Update Privacy Policy
     */
    public function updatePolicy(array $data): bool
    {
        $policy = $this->first();
        if (!$policy) {
            // If no record exists, insert it
            return $this->insert($data) !== false;
        }
        return $this->update($policy['id'], $data);
    }

    /**
     * Get validation rules for admin form
     */
    public function getFormValidationRules(): array
    {
        return $this->validationRules;
    }

    /**
     * Get validation messages for admin form
     */
    public function getFormValidationMessages(): array
    {
        return $this->validationMessages;
    }

    /**
     * Toggle status
     */
    public function toggleStatus(): bool
    {
        $policy = $this->first();
        if (!$policy) {
            return false;
        }

        $newStatus = $policy['status'] === 'active' ? 'inactive' : 'active';
        return $this->update($policy['id'], ['status' => $newStatus]);
    }
}
