<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Itinerary Category Model
 * 
 * Handles itinerary categories data operations
 * 
 * @package App\Models
 * @author  Senior PHP Architect
 */
class ItineraryCategoryModel extends Model
{
    protected $table            = 'itinerary_categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'slug', 'description', 'image', 'status', 'sort_order'
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
     * Get categories for admin listing with pagination
     * 
     * @param int $perPage
     * @return array
     */
    public function getAdminCategoriesList(int $perPage = 20): array
    {
        return $this->select('itinerary_categories.id, itinerary_categories.name, itinerary_categories.slug, itinerary_categories.description, itinerary_categories.image, itinerary_categories.status, itinerary_categories.sort_order, itinerary_categories.created_at, itinerary_categories.updated_at, COUNT(itineraries.id) as itinerary_count')
                    ->join('itineraries', 'itineraries.category_id = itinerary_categories.id', 'left')
                    ->groupBy('itinerary_categories.id')
                    ->orderBy('itinerary_categories.sort_order', 'ASC')
                    ->orderBy('itinerary_categories.name', 'ASC')
                    ->paginate($perPage);
    }

    /**
     * Get active categories for dropdown
     * 
     * @return array
     */
    public function getCategoriesDropdown(): array
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
     * Get active categories for frontend
     * 
     * @param bool $withCount
     * @return array
     */
    public function getActiveCategories(bool $withCount = false): array
    {
        $builder = $this->where('status', 'active');

        if ($withCount) {
            $builder->select('itinerary_categories.id, itinerary_categories.name, itinerary_categories.slug, itinerary_categories.description, itinerary_categories.image, itinerary_categories.status, itinerary_categories.sort_order, itinerary_categories.created_at, itinerary_categories.updated_at, COUNT(itineraries.id) as itinerary_count')
                    ->join('itineraries', 'itineraries.category_id = itinerary_categories.id AND itineraries.status = "published"', 'left')
                    ->groupBy('itinerary_categories.id');
        }

        return $builder->orderBy('sort_order', 'ASC')
                       ->orderBy('name', 'ASC')
                       ->findAll();
    }

    /**
     * Get category by slug
     * 
     * @param string $slug
     * @return array|null
     */
    public function getBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)
                    ->where('status', 'active')
                    ->first();
    }

    /**
     * Get category with itinerary count
     * 
     * @param int $id
     * @return array|null
     */
    public function getCategoryWithCount(int $id): ?array
    {
        return $this->select('itinerary_categories.id, itinerary_categories.name, itinerary_categories.slug, itinerary_categories.description, itinerary_categories.image, itinerary_categories.status, itinerary_categories.sort_order, itinerary_categories.created_at, itinerary_categories.updated_at, COUNT(itineraries.id) as itinerary_count')
                    ->join('itineraries', 'itineraries.category_id = itinerary_categories.id', 'left')
                    ->where('itinerary_categories.id', $id)
                    ->groupBy('itinerary_categories.id')
                    ->first();
    }

    /**
     * Get categories statistics
     * 
     * @return array
     */
    public function getCategoryStats(): array
    {
        // Use raw queries to avoid query builder state issues
        $db = \Config\Database::connect();
        
        $total = $db->table('itinerary_categories')->countAllResults();
        $active = $db->table('itinerary_categories')->where('status', 'active')->countAllResults();
        $inactive = $db->table('itinerary_categories')->where('status', 'inactive')->countAllResults();
        
        // Count categories that have at least one itinerary
        $withItinerariesQuery = $db->query("
            SELECT COUNT(DISTINCT ic.id) as count 
            FROM itinerary_categories ic 
            INNER JOIN itineraries i ON i.category_id = ic.id
        ");
        $withItineraries = $withItinerariesQuery->getRow()->count ?? 0;
        
        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
            'with_itineraries' => $withItineraries
        ];
    }

    /**
     * Get trashed categories
     * 
     * @return array
     */
    public function getTrashedCategories(): array
    {
        return $this->onlyDeleted()
                    ->select('itinerary_categories.id, itinerary_categories.name, itinerary_categories.slug, itinerary_categories.description, itinerary_categories.image, itinerary_categories.status, itinerary_categories.sort_order, itinerary_categories.created_at, itinerary_categories.updated_at, itinerary_categories.deleted_at, COUNT(itineraries.id) as itinerary_count')
                    ->join('itineraries', 'itineraries.category_id = itinerary_categories.id', 'left')
                    ->groupBy('itinerary_categories.id')
                    ->orderBy('itinerary_categories.deleted_at', 'DESC')
                    ->findAll();
    }

    /**
     * Restore category from trash
     * 
     * @param int $id
     * @return bool
     */
    public function restoreCategory(int $id): bool
    {
        return $this->update($id, ['deleted_at' => null]);
    }

    /**
     * Check if category has itineraries
     * 
     * @param int $id
     * @return bool
     */
    public function hasItineraries(int $id): bool
    {
        $itineraryModel = new \App\Models\ItineraryModel();
        return $itineraryModel->where('category_id', $id)->countAllResults() > 0;
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
     * Get popular categories based on itinerary count
     * 
     * @param int $limit
     * @return array
     */
    public function getPopularCategories(int $limit = 6): array
    {
        return $this->select('itinerary_categories.id, itinerary_categories.name, itinerary_categories.slug, itinerary_categories.description, itinerary_categories.image, itinerary_categories.status, itinerary_categories.sort_order, itinerary_categories.created_at, itinerary_categories.updated_at, COUNT(itineraries.id) as itinerary_count')
                    ->join('itineraries', 'itineraries.category_id = itinerary_categories.id AND itineraries.status = "published"')
                    ->where('itinerary_categories.status', 'active')
                    ->groupBy('itinerary_categories.id')
                    ->having('itinerary_count >', 0)
                    ->orderBy('itinerary_count', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get categories with featured itineraries
     * 
     * @param int $limit
     * @return array
     */
    public function getCategoriesWithFeaturedItineraries(int $limit = 5): array
    {
        return $this->select('itinerary_categories.id, itinerary_categories.name, itinerary_categories.slug, itinerary_categories.description, itinerary_categories.image, itinerary_categories.status, itinerary_categories.sort_order, itinerary_categories.created_at, itinerary_categories.updated_at, COUNT(itineraries.id) as featured_count')
                    ->join('itineraries', 'itineraries.category_id = itinerary_categories.id AND itineraries.status = "published" AND itineraries.is_featured = 1')
                    ->where('itinerary_categories.status', 'active')
                    ->groupBy('itinerary_categories.id')
                    ->having('featured_count >', 0)
                    ->orderBy('featured_count', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}