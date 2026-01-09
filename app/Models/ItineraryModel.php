<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Itinerary Model
 * 
 * Handles itinerary data operations
 * 
 * @package App\Models
 * @author  Senior PHP Architect
 */
class ItineraryModel extends Model
{
    protected $table            = 'itineraries';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title', 'slug', 'description', 'short_description', 'featured_image',
        'category_id', 'destination_id', 'duration_days', 'duration_nights',
        'price', 'discounted_price', 'inclusions', 'exclusions', 'itinerary_details',
        'is_featured', 'status', 'sort_order', 'meta_title', 'meta_description'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'description' => 'required|min_length[10]',
        'duration_days' => 'required|integer|greater_than[0]',
        'price' => 'required|decimal|greater_than_equal_to[0]',
        'status' => 'required|in_list[draft,published]'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Itinerary title is required',
            'min_length' => 'Title must be at least 3 characters',
            'max_length' => 'Title cannot exceed 255 characters'
        ],
        'description' => [
            'required' => 'Description is required',
            'min_length' => 'Description must be at least 10 characters'
        ],
        'duration_days' => [
            'required' => 'Duration in days is required',
            'integer' => 'Duration must be a valid number',
            'greater_than' => 'Duration must be greater than 0'
        ],
        'price' => [
            'required' => 'Price is required',
            'decimal' => 'Price must be a valid decimal number',
            'greater_than_equal_to' => 'Price cannot be negative'
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
        if (isset($data['data']['title']) && !isset($data['data']['slug'])) {
            $data['data']['slug'] = url_title($data['data']['title'], '-', true);
        }
        return $data;
    }

    /**
     * Get itineraries for admin listing with pagination
     * 
     * @param int $perPage
     * @return array
     */
    public function getAdminItinerariesList(int $perPage = 20): array
    {
        return $this->select('itineraries.id, itineraries.title, itineraries.slug, itineraries.description, itineraries.short_description, itineraries.featured_image, itineraries.category_id, itineraries.destination_id, itineraries.duration_days, itineraries.duration_nights, itineraries.price, itineraries.discounted_price, itineraries.inclusions, itineraries.exclusions, itineraries.itinerary_details, itineraries.is_featured, itineraries.status, itineraries.sort_order, itineraries.created_at, itineraries.updated_at, destinations.name as destination_name, itinerary_categories.name as category_name')
                    ->join('destinations', 'destinations.id = itineraries.destination_id', 'left')
                    ->join('itinerary_categories', 'itinerary_categories.id = itineraries.category_id', 'left')
                    ->orderBy('itineraries.created_at', 'DESC')
                    ->paginate($perPage);
    }

    /**
     * Get published itineraries for frontend
     * 
     * @param int $limit
     * @param int $categoryId
     * @param int $destinationId
     * @return array
     */
    public function getPublishedItineraries(int $limit = 12, int $categoryId = null, int $destinationId = null): array
    {
        $builder = $this->select('itineraries.*, destinations.name as destination_name, itinerary_categories.name as category_name')
                        ->join('destinations', 'destinations.id = itineraries.destination_id', 'left')
                        ->join('itinerary_categories', 'itinerary_categories.id = itineraries.category_id', 'left')
                        ->where('itineraries.status', 'published');

        if ($categoryId) {
            $builder->where('itineraries.category_id', $categoryId);
        }

        if ($destinationId) {
            $builder->where('itineraries.destination_id', $destinationId);
        }

        return $builder->orderBy('itineraries.sort_order', 'ASC')
                       ->orderBy('itineraries.created_at', 'DESC')
                       ->limit($limit)
                       ->findAll();
    }

    /**
     * Get featured itineraries
     * 
     * @param int $limit
     * @return array
     */
    public function getFeaturedItineraries(int $limit = 6): array
    {
        return $this->select('itineraries.*, destinations.name as destination_name')
                    ->join('destinations', 'destinations.id = itineraries.destination_id', 'left')
                    ->where('itineraries.is_featured', 1)
                    ->where('itineraries.status', 'published')
                    ->orderBy('itineraries.sort_order', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get itinerary by slug with full details
     * 
     * @param string $slug
     * @return array|null
     */
    public function getBySlug(string $slug): ?array
    {
        return $this->select('itineraries.*, destinations.name as destination_name, destinations.type as destination_type, itinerary_categories.name as category_name')
                    ->join('destinations', 'destinations.id = itineraries.destination_id', 'left')
                    ->join('itinerary_categories', 'itinerary_categories.id = itineraries.category_id', 'left')
                    ->where('itineraries.slug', $slug)
                    ->where('itineraries.status', 'published')
                    ->first();
    }

    /**
     * Get related itineraries
     * 
     * @param int $itineraryId
     * @param int $destinationId
     * @param int $categoryId
     * @param int $limit
     * @return array
     */
    public function getRelatedItineraries(int $itineraryId, int $destinationId = null, int $categoryId = null, int $limit = 4): array
    {
        $builder = $this->select('itineraries.*, destinations.name as destination_name')
                        ->join('destinations', 'destinations.id = itineraries.destination_id', 'left')
                        ->where('itineraries.id !=', $itineraryId)
                        ->where('itineraries.status', 'published');

        // Prioritize same destination, then same category
        if ($destinationId) {
            $builder->where('itineraries.destination_id', $destinationId);
        } elseif ($categoryId) {
            $builder->where('itineraries.category_id', $categoryId);
        }

        return $builder->orderBy('itineraries.is_featured', 'DESC')
                       ->orderBy('itineraries.created_at', 'DESC')
                       ->limit($limit)
                       ->findAll();
    }

    /**
     * Search itineraries
     * 
     * @param string $keyword
     * @param array $filters
     * @param int $limit
     * @return array
     */
    public function searchItineraries(string $keyword, array $filters = [], int $limit = 20): array
    {
        $builder = $this->select('itineraries.*, destinations.name as destination_name, itinerary_categories.name as category_name')
                        ->join('destinations', 'destinations.id = itineraries.destination_id', 'left')
                        ->join('itinerary_categories', 'itinerary_categories.id = itineraries.category_id', 'left')
                        ->where('itineraries.status', 'published');

        // Keyword search
        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('itineraries.title', $keyword)
                    ->orLike('itineraries.description', $keyword)
                    ->orLike('destinations.name', $keyword)
                    ->groupEnd();
        }

        // Apply filters
        if (isset($filters['category_id']) && $filters['category_id']) {
            $builder->where('itineraries.category_id', $filters['category_id']);
        }

        if (isset($filters['destination_id']) && $filters['destination_id']) {
            $builder->where('itineraries.destination_id', $filters['destination_id']);
        }

        if (isset($filters['min_price']) && $filters['min_price']) {
            $builder->where('itineraries.price >=', $filters['min_price']);
        }

        if (isset($filters['max_price']) && $filters['max_price']) {
            $builder->where('itineraries.price <=', $filters['max_price']);
        }

        if (isset($filters['duration']) && $filters['duration']) {
            $builder->where('itineraries.duration_days', $filters['duration']);
        }

        return $builder->orderBy('itineraries.is_featured', 'DESC')
                       ->orderBy('itineraries.created_at', 'DESC')
                       ->limit($limit)
                       ->findAll();
    }

    /**
     * Get itineraries statistics
     * 
     * @return array
     */
    public function getItineraryStats(): array
    {
        return [
            'total' => $this->countAllResults(),
            'published' => $this->where('status', 'published')->countAllResults(),
            'draft' => $this->where('status', 'draft')->countAllResults(),
            'featured' => $this->where('is_featured', 1)->countAllResults(),
            'avg_price' => $this->selectAvg('price')->where('status', 'published')->first()['price'] ?? 0,
            'min_price' => $this->selectMin('price')->where('status', 'published')->first()['price'] ?? 0,
            'max_price' => $this->selectMax('price')->where('status', 'published')->first()['price'] ?? 0
        ];
    }

    /**
     * Get trashed itineraries
     * 
     * @return array
     */
    public function getTrashedItineraries(): array
    {
        return $this->onlyDeleted()
                    ->select('itineraries.*, destinations.name as destination_name, itinerary_categories.name as category_name')
                    ->join('destinations', 'destinations.id = itineraries.destination_id', 'left')
                    ->join('itinerary_categories', 'itinerary_categories.id = itineraries.category_id', 'left')
                    ->orderBy('itineraries.deleted_at', 'DESC')
                    ->findAll();
    }

    /**
     * Restore itinerary from trash
     * 
     * @param int $id
     * @return bool
     */
    public function restoreItinerary(int $id): bool
    {
        return $this->update($id, ['deleted_at' => null]);
    }

    /**
     * Get itinerary with full details for admin
     * 
     * @param int $id
     * @return array|null
     */
    public function getItineraryWithDetails(int $id): ?array
    {
        return $this->select('itineraries.*, destinations.name as destination_name, itinerary_categories.name as category_name')
                    ->join('destinations', 'destinations.id = itineraries.destination_id', 'left')
                    ->join('itinerary_categories', 'itinerary_categories.id = itineraries.category_id', 'left')
                    ->find($id);
    }

    /**
     * Update sort order
     * 
     * @param array $sortData
     * @return bool
     */
    public function updateSortOrder(array $sortData): bool
    {
        $this->db->transStart();

        foreach ($sortData as $id => $order) {
            $this->update($id, ['sort_order' => $order]);
        }

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    /**
     * Get price range for filters
     * 
     * @return array
     */
    public function getPriceRange(): array
    {
        $result = $this->select('MIN(price) as min_price, MAX(price) as max_price')
                       ->where('status', 'published')
                       ->first();

        return [
            'min' => $result['min_price'] ?? 0,
            'max' => $result['max_price'] ?? 0
        ];
    }

    /**
     * Get popular destinations from itineraries
     * 
     * @param int $limit
     * @return array
     */
    public function getPopularDestinationsFromItineraries(int $limit = 10): array
    {
        return $this->select('destinations.id, destinations.name, destinations.image, COUNT(itineraries.id) as itinerary_count')
                    ->join('destinations', 'destinations.id = itineraries.destination_id')
                    ->where('itineraries.status', 'published')
                    ->groupBy('destinations.id')
                    ->orderBy('itinerary_count', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get itineraries with categories for admin listing
     * 
     * @param int $perPage
     * @return array
     */
    public function getItinerariesWithCategories(int $perPage = 20): array
    {
        return $this->select('itineraries.*, itinerary_categories.name as category_name, destinations.name as destination_name')
                    ->join('itinerary_categories', 'itinerary_categories.id = itineraries.category_id', 'left')
                    ->join('destinations', 'destinations.id = itineraries.destination_id', 'left')
                    ->orderBy('itineraries.created_at', 'DESC')
                    ->paginate($perPage);
    }
}