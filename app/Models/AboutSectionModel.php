<?php

namespace App\Models;

use CodeIgniter\Model;

class AboutSectionModel extends Model
{
    protected $table = 'about_sections';
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
        'image_path',
        'background_image',
        'icon',
        'stat_value',
        'stat_label',
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
        'section_type' => 'required|in_list[hero,mission,stats,features]',
        'title' => 'required|min_length[3]|max_length[255]',
        'subtitle' => 'max_length[255]',
        'content' => 'max_length[2000]',
        'image_path' => 'max_length[255]',
        'background_image' => 'max_length[255]',
        'icon' => 'max_length[100]',
        'stat_value' => 'max_length[50]',
        'stat_label' => 'max_length[100]',
        'sort_order' => 'integer',
        'status' => 'in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'section_type' => [
            'required' => 'Section type is required',
            'in_list' => 'Section type must be one of: hero, mission, stats, features'
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
     * Get mission section
     */
    public function getMissionSection()
    {
        return $this->where('section_type', 'mission')
                   ->where('status', 'active')
                   ->first();
    }

    /**
     * Get stats sections
     */
    public function getStatsSection()
    {
        return $this->getSectionsByType('stats');
    }

    /**
     * Get features sections
     */
    public function getFeaturesSection()
    {
        return $this->getSectionsByType('features');
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
        // Apply filters
        if (!empty($filters['section_type'])) {
            $this->where('section_type', $filters['section_type']);
        }

        if (!empty($filters['status'])) {
            $this->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $this->groupStart()
                 ->like('title', $filters['search'])
                 ->orLike('subtitle', $filters['search'])
                 ->orLike('content', $filters['search'])
                 ->groupEnd();
        }

        return $this->orderBy('section_type', 'ASC')
                    ->orderBy('sort_order', 'ASC')
                    ->paginate($perPage);
    }
}