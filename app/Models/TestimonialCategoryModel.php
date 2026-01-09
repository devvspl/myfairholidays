<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Testimonial Category Model
 * 
 * Handles testimonial categories data operations
 * 
 * @package App\Models
 * @author  Senior PHP Architect
 */
class TestimonialCategoryModel extends Model
{
    protected $table            = 'testimonial_categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'slug', 'description', 'status', 'sort_order'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[255]',
        'status' => 'required|in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Category name is required',
            'min_length' => 'Category name must be at least 2 characters',
            'max_length' => 'Category name cannot exceed 255 characters'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Invalid status'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateSlug'];
    protected $beforeUpdate   = ['generateSlug'];

    /**
     * Generate slug before insert/update
     * 
     * @param array $data
     * @return array
     */
    protected function generateSlug(array $data): array
    {
        if (isset($data['data']['name']) && !isset($data['data']['slug'])) {
            $data['data']['slug'] = url_title($data['data']['name'], '-', true);
        }
        return $data;
    }

    /**
     * Get active categories for dropdown
     * 
     * @return array
     */
    public function getActiveCategoriesDropdown(): array
    {
        $categories = $this->select('id, name')
                          ->where('status', 'active')
                          ->orderBy('sort_order', 'ASC')
                          ->orderBy('name', 'ASC')
                          ->findAll();

        $dropdown = [];
        foreach ($categories as $category) {
            $dropdown[$category['id']] = $category['name'];
        }

        return $dropdown;
    }

    /**
     * Get categories with testimonial count
     * 
     * @return array
     */
    public function getCategoriesWithTestimonialCount(): array
    {
        return $this->select('testimonial_categories.*, COUNT(testimonials.id) as testimonial_count')
                    ->join('testimonials', 'testimonials.category_id = testimonial_categories.id', 'left')
                    ->groupBy('testimonial_categories.id')
                    ->orderBy('testimonial_categories.sort_order', 'ASC')
                    ->orderBy('testimonial_categories.name', 'ASC')
                    ->findAll();
    }

    /**
     * Get categories with testimonial count and pagination for admin panel
     * 
     * @param int $perPage
     * @return array
     */
    public function getAdminCategoriesList(int $perPage = 20): array
    {
        return $this->select('testimonial_categories.*, COUNT(testimonials.id) as testimonial_count')
                    ->join('testimonials', 'testimonials.category_id = testimonial_categories.id', 'left')
                    ->groupBy('testimonial_categories.id')
                    ->orderBy('testimonial_categories.sort_order', 'ASC')
                    ->orderBy('testimonial_categories.name', 'ASC')
                    ->paginate($perPage);
    }

    /**
     * Get category statistics
     * 
     * @return array
     */
    public function getCategoryStats(): array
    {
        return [
            'total' => $this->countAllResults(),
            'active' => $this->where('status', 'active')->countAllResults(),
            'inactive' => $this->where('status', 'inactive')->countAllResults(),
            'with_testimonials' => $this->select('testimonial_categories.id')
                                       ->join('testimonials', 'testimonials.category_id = testimonial_categories.id')
                                       ->groupBy('testimonial_categories.id')
                                       ->countAllResults()
        ];
    }
}