<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Testimonial Model
 * 
 * Handles testimonials data operations
 * 
 * @package App\Models
 * @author  Senior PHP Architect
 */
class TestimonialModel extends Model
{
    protected $table            = 'testimonials';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'customer_name', 'customer_email', 'customer_city', 'customer_image',
        'rating', 'testimonial_text', 'category_id', 'destination_id', 
        'package_name', 'travel_date', 'status', 'is_featured', 'sort_order'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'customer_name' => 'required|min_length[2]|max_length[255]',
        'customer_email' => 'required|valid_email',
        'rating' => 'required|integer|greater_than[0]|less_than[6]',
        'testimonial_text' => 'required|min_length[10]',
        'status' => 'required|in_list[pending,approved,rejected]'
    ];

    protected $validationMessages = [
        'customer_name' => [
            'required' => 'Customer name is required',
            'min_length' => 'Customer name must be at least 2 characters',
            'max_length' => 'Customer name cannot exceed 255 characters'
        ],
        'customer_email' => [
            'required' => 'Customer email is required',
            'valid_email' => 'Please provide a valid email address'
        ],
        'rating' => [
            'required' => 'Rating is required',
            'integer' => 'Rating must be a number',
            'greater_than' => 'Rating must be between 1 and 5',
            'less_than' => 'Rating must be between 1 and 5'
        ],
        'testimonial_text' => [
            'required' => 'Testimonial text is required',
            'min_length' => 'Testimonial must be at least 10 characters'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Invalid status'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get testimonials with category and destination details
     * 
     * @return array
     */
    public function getTestimonialsWithDetails(): array
    {
        return $this->select('testimonials.*, 
                             testimonial_categories.name as category_name,
                             destinations.name as destination_name')
                    ->join('testimonial_categories', 'testimonial_categories.id = testimonials.category_id', 'left')
                    ->join('destinations', 'destinations.id = testimonials.destination_id', 'left')
                    ->orderBy('testimonials.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get testimonials with pagination for admin panel
     * 
     * @param int $perPage
     * @return array
     */
    public function getAdminTestimonialsList(int $perPage = 20): array
    {
        return $this->select('testimonials.*, 
                             testimonial_categories.name as category_name,
                             destinations.name as destination_name')
                    ->join('testimonial_categories', 'testimonial_categories.id = testimonials.category_id', 'left')
                    ->join('destinations', 'destinations.id = testimonials.destination_id', 'left')
                    ->orderBy('testimonials.created_at', 'DESC')
                    ->paginate($perPage);
    }

    /**
     * Get approved testimonials for public display
     * 
     * @param int $limit
     * @return array
     */
    public function getApprovedTestimonials(int $limit = 10): array
    {
        return $this->select('testimonials.*, 
                             testimonial_categories.name as category_name,
                             destinations.name as destination_name')
                    ->join('testimonial_categories', 'testimonial_categories.id = testimonials.category_id', 'left')
                    ->join('destinations', 'destinations.id = testimonials.destination_id', 'left')
                    ->where('testimonials.status', 'approved')
                    ->orderBy('testimonials.is_featured', 'DESC')
                    ->orderBy('testimonials.sort_order', 'ASC')
                    ->orderBy('testimonials.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get featured testimonials
     * 
     * @param int $limit
     * @return array
     */
    public function getFeaturedTestimonials(int $limit = 5): array
    {
        return $this->select('testimonials.*, 
                             testimonial_categories.name as category_name,
                             destinations.name as destination_name')
                    ->join('testimonial_categories', 'testimonial_categories.id = testimonials.category_id', 'left')
                    ->join('destinations', 'destinations.id = testimonials.destination_id', 'left')
                    ->where('testimonials.status', 'approved')
                    ->where('testimonials.is_featured', 1)
                    ->orderBy('testimonials.sort_order', 'ASC')
                    ->orderBy('testimonials.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get testimonials by category
     * 
     * @param int $categoryId
     * @param int $limit
     * @return array
     */
    public function getTestimonialsByCategory(int $categoryId, int $limit = 10): array
    {
        return $this->select('testimonials.*, 
                             testimonial_categories.name as category_name,
                             destinations.name as destination_name')
                    ->join('testimonial_categories', 'testimonial_categories.id = testimonials.category_id', 'left')
                    ->join('destinations', 'destinations.id = testimonials.destination_id', 'left')
                    ->where('testimonials.category_id', $categoryId)
                    ->where('testimonials.status', 'approved')
                    ->orderBy('testimonials.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get testimonials statistics
     * 
     * @return array
     */
    public function getTestimonialStats(): array
    {
        return [
            'total' => $this->countAllResults(),
            'approved' => $this->where('status', 'approved')->countAllResults(),
            'pending' => $this->where('status', 'pending')->countAllResults(),
            'rejected' => $this->where('status', 'rejected')->countAllResults(),
            'featured' => $this->where('is_featured', 1)->countAllResults(),
            'average_rating' => $this->selectAvg('rating')->where('status', 'approved')->get()->getRow()->rating ?? 0
        ];
    }

    /**
     * Get testimonials by destination
     * 
     * @param int $destinationId
     * @param int $limit
     * @return array
     */
    public function getTestimonialsByDestination(int $destinationId, int $limit = 5): array
    {
        return $this->select('testimonials.*, 
                             testimonial_categories.name as category_name')
                    ->join('testimonial_categories', 'testimonial_categories.id = testimonials.category_id', 'left')
                    ->where('testimonials.destination_id', $destinationId)
                    ->where('testimonials.status', 'approved')
                    ->orderBy('testimonials.rating', 'DESC')
                    ->orderBy('testimonials.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}