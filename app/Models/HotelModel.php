<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Hotel Model
 * 
 * Handles hotel data operations
 * 
 * @package App\Models
 * @author  Senior PHP Architect
 */
class HotelModel extends Model
{
    protected $table            = 'hotels';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'slug', 'description', 'short_description', 'featured_image',
        'destination_id', 'address', 'latitude', 'longitude', 'star_rating',
        'price_per_night', 'discount_type', 'discount_value', 'discount_start_date', 'discount_end_date',
        'amenities', 'contact_phone', 'contact_email',
        'website', 'is_featured', 'status', 'sort_order', 'meta_title', 'meta_description', 'meta_keywords',
        'check_in_time', 'check_out_time', 'cancellation_policy', 'hotel_policies',
        'nearby_attractions', 'transportation_info', 'dining_entertainment'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'star_rating' => 'required|integer|greater_than[0]|less_than_equal_to[5]',
        'price_per_night' => 'required|decimal|greater_than_equal_to[0]',
        'contact_email' => 'permit_empty|valid_email',
        'website' => 'permit_empty|valid_url',
        'status' => 'required|in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Hotel name is required',
            'min_length' => 'Hotel name must be at least 3 characters',
            'max_length' => 'Hotel name cannot exceed 255 characters'
        ],
        'star_rating' => [
            'required' => 'Star rating is required',
            'integer' => 'Star rating must be a valid number',
            'greater_than' => 'Star rating must be between 1 and 5',
            'less_than_equal_to' => 'Star rating must be between 1 and 5'
        ],
        'price_per_night' => [
            'required' => 'Price per night is required',
            'decimal' => 'Price must be a valid decimal number',
            'greater_than_equal_to' => 'Price cannot be negative'
        ],
        'contact_email' => [
            'valid_email' => 'Please enter a valid email address'
        ],
        'website' => [
            'valid_url' => 'Please enter a valid website URL'
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
     * Get hotels for admin listing with pagination
     * 
     * @param int $perPage
     * @return array
     */
    public function getAdminHotelsList(int $perPage = 20): array
    {
        return $this->select('hotels.id, hotels.name, hotels.slug, hotels.description, hotels.short_description, hotels.featured_image, hotels.destination_id, hotels.address, hotels.latitude, hotels.longitude, hotels.star_rating, hotels.price_per_night, hotels.amenities, hotels.contact_phone, hotels.contact_email, hotels.website, hotels.is_featured, hotels.status, hotels.sort_order, hotels.created_at, hotels.updated_at, destinations.name as destination_name')
                    ->join('destinations', 'destinations.id = hotels.destination_id', 'left')
                    ->orderBy('hotels.created_at', 'DESC')
                    ->paginate($perPage);
    }

    /**
     * Get active hotels for frontend
     * 
     * @param int $limit
     * @param int $destinationId
     * @param int $starRating
     * @return array
     */
    public function getActiveHotels(int $limit = 12, int $destinationId = null, int $starRating = null): array
    {
        $builder = $this->select('hotels.*, destinations.name as destination_name')
                        ->join('destinations', 'destinations.id = hotels.destination_id', 'left')
                        ->where('hotels.status', 'active');

        if ($destinationId) {
            $builder->where('hotels.destination_id', $destinationId);
        }

        if ($starRating) {
            $builder->where('hotels.star_rating', $starRating);
        }

        return $builder->orderBy('hotels.sort_order', 'ASC')
                       ->orderBy('hotels.star_rating', 'DESC')
                       ->orderBy('hotels.name', 'ASC')
                       ->limit($limit)
                       ->findAll();
    }

    /**
     * Get featured hotels
     * 
     * @param int $limit
     * @return array
     */
    public function getFeaturedHotels(int $limit = 6): array
    {
        return $this->select('hotels.*, destinations.name as destination_name')
                    ->join('destinations', 'destinations.id = hotels.destination_id', 'left')
                    ->where('hotels.is_featured', 1)
                    ->where('hotels.status', 'active')
                    ->orderBy('hotels.sort_order', 'ASC')
                    ->orderBy('hotels.star_rating', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get hotel by slug with full details
     * 
     * @param string $slug
     * @return array|null
     */
    public function getBySlug(string $slug): ?array
    {
        return $this->select('hotels.*, destinations.name as destination_name, destinations.type as destination_type')
                    ->join('destinations', 'destinations.id = hotels.destination_id', 'left')
                    ->where('hotels.slug', $slug)
                    ->where('hotels.status', 'active')
                    ->first();
    }

    /**
     * Get hotels by destination
     * 
     * @param int $destinationId
     * @param int $limit
     * @return array
     */
    public function getHotelsByDestination(int $destinationId, int $limit = 10): array
    {
        return $this->where('destination_id', $destinationId)
                    ->where('status', 'active')
                    ->orderBy('star_rating', 'DESC')
                    ->orderBy('sort_order', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get hotels by star rating
     * 
     * @param int $starRating
     * @param int $limit
     * @return array
     */
    public function getHotelsByStarRating(int $starRating, int $limit = 10): array
    {
        return $this->select('hotels.*, destinations.name as destination_name')
                    ->join('destinations', 'destinations.id = hotels.destination_id', 'left')
                    ->where('hotels.star_rating', $starRating)
                    ->where('hotels.status', 'active')
                    ->orderBy('hotels.sort_order', 'ASC')
                    ->orderBy('hotels.name', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Search hotels
     * 
     * @param string $keyword
     * @param array $filters
     * @param int $limit
     * @return array
     */
    public function searchHotels(string $keyword, array $filters = [], int $limit = 20): array
    {
        $builder = $this->select('hotels.*, destinations.name as destination_name')
                        ->join('destinations', 'destinations.id = hotels.destination_id', 'left')
                        ->where('hotels.status', 'active');

        // Keyword search
        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('hotels.name', $keyword)
                    ->orLike('hotels.description', $keyword)
                    ->orLike('destinations.name', $keyword)
                    ->orLike('hotels.address', $keyword)
                    ->groupEnd();
        }

        // Apply filters
        if (isset($filters['destination_id']) && $filters['destination_id']) {
            $builder->where('hotels.destination_id', $filters['destination_id']);
        }

        if (isset($filters['star_rating']) && $filters['star_rating']) {
            $builder->where('hotels.star_rating', $filters['star_rating']);
        }

        if (isset($filters['min_price']) && $filters['min_price']) {
            $builder->where('hotels.price_per_night >=', $filters['min_price']);
        }

        if (isset($filters['max_price']) && $filters['max_price']) {
            $builder->where('hotels.price_per_night <=', $filters['max_price']);
        }

        return $builder->orderBy('hotels.is_featured', 'DESC')
                       ->orderBy('hotels.star_rating', 'DESC')
                       ->orderBy('hotels.name', 'ASC')
                       ->limit($limit)
                       ->findAll();
    }

    /**
     * Get hotels statistics
     * 
     * @return array
     */
    public function getHotelStats(): array
    {
        return [
            'total' => $this->countAllResults(),
            'active' => $this->where('status', 'active')->countAllResults(),
            'inactive' => $this->where('status', 'inactive')->countAllResults(),
            'featured' => $this->where('is_featured', 1)->countAllResults(),
            'five_star' => $this->where('star_rating', 5)->countAllResults(),
            'four_star' => $this->where('star_rating', 4)->countAllResults(),
            'three_star' => $this->where('star_rating', 3)->countAllResults(),
            'two_star' => $this->where('star_rating', 2)->countAllResults(),
            'one_star' => $this->where('star_rating', 1)->countAllResults(),
            'avg_price' => $this->selectAvg('price_per_night')->where('status', 'active')->first()['price_per_night'] ?? 0,
            'min_price' => $this->selectMin('price_per_night')->where('status', 'active')->first()['price_per_night'] ?? 0,
            'max_price' => $this->selectMax('price_per_night')->where('status', 'active')->first()['price_per_night'] ?? 0
        ];
    }

    /**
     * Get trashed hotels
     * 
     * @return array
     */
    public function getTrashedHotels(): array
    {
        return $this->onlyDeleted()
                    ->select('hotels.*, destinations.name as destination_name')
                    ->join('destinations', 'destinations.id = hotels.destination_id', 'left')
                    ->orderBy('hotels.deleted_at', 'DESC')
                    ->findAll();
    }

    /**
     * Restore hotel from trash
     * 
     * @param int $id
     * @return bool
     */
    public function restoreHotel(int $id): bool
    {
        return $this->update($id, ['deleted_at' => null]);
    }

    /**
     * Get hotel with full details for admin
     * 
     * @param int $id
     * @return array|null
     */
    public function getHotelWithDetails(int $id): ?array
    {
        return $this->select('hotels.*, destinations.name as destination_name')
                    ->join('destinations', 'destinations.id = hotels.destination_id', 'left')
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
        $result = $this->select('MIN(price_per_night) as min_price, MAX(price_per_night) as max_price')
                       ->where('status', 'active')
                       ->first();

        return [
            'min' => $result['min_price'] ?? 0,
            'max' => $result['max_price'] ?? 0
        ];
    }

    /**
     * Get popular destinations from hotels
     * 
     * @param int $limit
     * @return array
     */
    public function getPopularDestinationsFromHotels(int $limit = 10): array
    {
        return $this->select('destinations.id, destinations.name, destinations.image, COUNT(hotels.id) as hotel_count')
                    ->join('destinations', 'destinations.id = hotels.destination_id')
                    ->where('hotels.status', 'active')
                    ->groupBy('destinations.id')
                    ->orderBy('hotel_count', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get nearby hotels
     * 
     * @param float $latitude
     * @param float $longitude
     * @param float $radius (in kilometers)
     * @param int $limit
     * @return array
     */
    public function getNearbyHotels(float $latitude, float $longitude, float $radius = 10, int $limit = 10): array
    {
        // Using Haversine formula for distance calculation
        $sql = "SELECT hotels.*, destinations.name as destination_name,
                (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * 
                cos(radians(longitude) - radians(?)) + sin(radians(?)) * 
                sin(radians(latitude)))) AS distance
                FROM hotels 
                LEFT JOIN destinations ON destinations.id = hotels.destination_id
                WHERE hotels.status = 'active' 
                AND hotels.latitude IS NOT NULL 
                AND hotels.longitude IS NOT NULL
                HAVING distance < ?
                ORDER BY distance ASC
                LIMIT ?";

        return $this->db->query($sql, [$latitude, $longitude, $latitude, $radius, $limit])->getResultArray();
    }

    /**
     * Get amenities list from all hotels
     * 
     * @return array
     */
    public function getAllAmenities(): array
    {
        $hotels = $this->select('amenities')
                       ->where('amenities IS NOT NULL')
                       ->where('amenities !=', '')
                       ->findAll();

        $amenities = [];
        foreach ($hotels as $hotel) {
            if (!empty($hotel['amenities'])) {
                $hotelAmenities = explode(',', $hotel['amenities']);
                foreach ($hotelAmenities as $amenity) {
                    $amenity = trim($amenity);
                    if (!empty($amenity) && !in_array($amenity, $amenities)) {
                        $amenities[] = $amenity;
                    }
                }
            }
        }

        sort($amenities);
        return $amenities;
    }

    /**
     * Calculate discounted price for a hotel
     * 
     * @param array $hotel Hotel data array
     * @return array Array with 'original_price', 'discount_amount', 'final_price', 'has_discount', 'discount_percentage'
     */
    public function calculateDiscountedPrice(array $hotel): array
    {
        $originalPrice = (float) ($hotel['price_per_night'] ?? 0);
        $discountType = $hotel['discount_type'] ?? 'none';
        $discountValue = (float) ($hotel['discount_value'] ?? 0);
        $discountStartDate = $hotel['discount_start_date'] ?? null;
        $discountEndDate = $hotel['discount_end_date'] ?? null;
        
        $result = [
            'original_price' => $originalPrice,
            'discount_amount' => 0,
            'final_price' => $originalPrice,
            'has_discount' => false,
            'discount_percentage' => 0,
            'discount_type' => $discountType
        ];
        
        // Check if discount is active
        if ($discountType === 'none' || $discountValue <= 0) {
            return $result;
        }
        
        // Check date validity
        $today = date('Y-m-d');
        if ($discountStartDate && $today < $discountStartDate) {
            return $result;
        }
        if ($discountEndDate && $today > $discountEndDate) {
            return $result;
        }
        
        // Calculate discount
        $discountAmount = 0;
        if ($discountType === 'percentage') {
            $discountAmount = ($originalPrice * $discountValue) / 100;
            $result['discount_percentage'] = $discountValue;
        } elseif ($discountType === 'fixed') {
            $discountAmount = min($discountValue, $originalPrice); // Don't exceed original price
            $result['discount_percentage'] = ($discountAmount / $originalPrice) * 100;
        }
        
        $result['discount_amount'] = $discountAmount;
        $result['final_price'] = max(0, $originalPrice - $discountAmount);
        $result['has_discount'] = true;
        
        return $result;
    }

    /**
     * Get hotel with calculated discount
     * 
     * @param int $id Hotel ID
     * @return array|null
     */
    public function getHotelWithDiscount(int $id): ?array
    {
        $hotel = $this->find($id);
        if (!$hotel) {
            return null;
        }
        
        $discountInfo = $this->calculateDiscountedPrice($hotel);
        return array_merge($hotel, $discountInfo);
    }
}
