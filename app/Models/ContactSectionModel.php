<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactSectionModel extends Model
{
    protected $table = 'contact_sections';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'section_type',
        'title',
        'subtitle',
        'content',
        'icon',
        'contact_type',
        'contact_value',
        'contact_link',
        'background_image',
        'map_embed_code',
        'sort_order',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'section_type' => 'required|in_list[hero,contact_info,form_settings]',
        'title' => 'required|min_length[3]|max_length[255]',
        'subtitle' => 'max_length[255]',
        'content' => 'max_length[2000]',
        'icon' => 'max_length[100]',
        'contact_type' => 'permit_empty|in_list[email,phone,address,website,social]',
        'contact_value' => 'max_length[255]',
        'contact_link' => 'max_length[255]',
        'background_image' => 'max_length[255]',
        'map_embed_code' => 'max_length[2000]',
        'sort_order' => 'integer',
        'status' => 'in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'section_type' => [
            'required' => 'Section type is required',
            'in_list' => 'Section type must be one of: hero, contact_info, form_settings'
        ],
        'title' => [
            'required' => 'Title is required',
            'min_length' => 'Title must be at least 3 characters long',
            'max_length' => 'Title cannot exceed 255 characters'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get sections by type
     */
    public function getSectionsByType($type, $activeOnly = true)
    {
        $builder = $this->builder();
        
        if ($activeOnly) {
            $builder->where('status', 'active');
        }
        
        return $builder->where('section_type', $type)
                      ->orderBy('sort_order', 'ASC')
                      ->get()
                      ->getResultArray();
    }

    /**
     * Get all sections grouped by type
     */
    public function getAllSectionsGrouped($activeOnly = true)
    {
        $builder = $this->builder();
        
        if ($activeOnly) {
            $builder->where('status', 'active');
        }
        
        $sections = $builder->orderBy('section_type', 'ASC')
                           ->orderBy('sort_order', 'ASC')
                           ->get()
                           ->getResultArray();

        $grouped = [];
        foreach ($sections as $section) {
            $grouped[$section['section_type']][] = $section;
        }

        return $grouped;
    }

    /**
     * Get hero section
     */
    public function getHeroSection()
    {
        return $this->where('section_type', 'hero')
                   ->where('status', 'active')
                   ->first();
    }

    /**
     * Get contact info sections
     */
    public function getContactInfoSections()
    {
        return $this->getSectionsByType('contact_info');
    }

    /**
     * Get form settings section
     */
    public function getFormSettingsSection()
    {
        return $this->where('section_type', 'form_settings')
                   ->where('status', 'active')
                   ->first();
    }

    /**
     * Update sort order
     */
    public function updateSortOrder($items)
    {
        foreach ($items as $item) {
            $this->update($item['id'], ['sort_order' => $item['sort_order']]);
        }
        return true;
    }

    /**
     * Get next sort order for a section type
     */
    public function getNextSortOrder($sectionType)
    {
        $maxOrder = $this->selectMax('sort_order')
                        ->where('section_type', $sectionType)
                        ->get()
                        ->getRow();
        
        return ($maxOrder->sort_order ?? 0) + 1;
    }

    /**
     * Toggle status
     */
    public function toggleStatus($id)
    {
        $section = $this->find($id);
        if (!$section) {
            return false;
        }

        $newStatus = $section['status'] === 'active' ? 'inactive' : 'active';
        return $this->update($id, ['status' => $newStatus]);
    }

    /**
     * Get sections with pagination and filters
     */
    public function getSectionsWithFilters($filters = [], $perPage = 20)
    {
        $builder = $this->builder();
        
        // Apply filters
        if (!empty($filters['section_type'])) {
            $builder->where('section_type', $filters['section_type']);
        }

        if (!empty($filters['status'])) {
            $builder->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart()
                    ->like('title', $filters['search'])
                    ->orLike('subtitle', $filters['search'])
                    ->orLike('content', $filters['search'])
                    ->orLike('contact_value', $filters['search'])
                    ->groupEnd();
        }

        return $builder->orderBy('section_type', 'ASC')
                       ->orderBy('sort_order', 'ASC')
                       ->paginate($perPage);
    }
}