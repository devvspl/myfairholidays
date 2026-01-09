<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Hotel Image Model
 * 
 * Handles hotel image data operations
 * 
 * @package App\Models
 */
class HotelImageModel extends Model
{
    protected $table            = 'hotel_images';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'hotel_id', 'image_path', 'alt_text', 'caption', 'sort_order', 'is_featured'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'hotel_id' => 'required|integer',
        'image_path' => 'required|max_length[255]',
        'alt_text' => 'permit_empty|max_length[255]',
        'sort_order' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'hotel_id' => [
            'required' => 'Hotel ID is required',
            'integer' => 'Hotel ID must be a valid number'
        ],
        'image_path' => [
            'required' => 'Image path is required',
            'max_length' => 'Image path cannot exceed 255 characters'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    /**
     * Get images for a specific hotel
     * 
     * @param int $hotelId
     * @return array
     */
    public function getHotelImages(int $hotelId): array
    {
        return $this->where('hotel_id', $hotelId)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    /**
     * Get featured image for a hotel
     * 
     * @param int $hotelId
     * @return array|null
     */
    public function getFeaturedImage(int $hotelId): ?array
    {
        return $this->where('hotel_id', $hotelId)
                    ->where('is_featured', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->first();
    }

    /**
     * Set featured image for a hotel
     * 
     * @param int $hotelId
     * @param int $imageId
     * @return bool
     */
    public function setFeaturedImage(int $hotelId, int $imageId): bool
    {
        $this->db->transStart();

        // Remove featured status from all images of this hotel
        $this->where('hotel_id', $hotelId)->set('is_featured', 0)->update();

        // Set the selected image as featured
        $this->update($imageId, ['is_featured' => 1]);

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    /**
     * Update sort order for hotel images
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
     * Delete image and file
     * 
     * @param int $id
     * @return bool
     */
    public function deleteImage(int $id): bool
    {
        $image = $this->find($id);
        if (!$image) {
            return false;
        }

        // Delete physical file
        $filePath = ROOTPATH . 'public/' . $image['image_path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        return $this->delete($id);
    }

    /**
     * Delete all images for a hotel
     * 
     * @param int $hotelId
     * @return bool
     */
    public function deleteHotelImages(int $hotelId): bool
    {
        $images = $this->getHotelImages($hotelId);
        
        foreach ($images as $image) {
            $this->deleteImage($image['id']);
        }

        return true;
    }

    /**
     * Get image count for a hotel
     * 
     * @param int $hotelId
     * @return int
     */
    public function getImageCount(int $hotelId): int
    {
        return $this->where('hotel_id', $hotelId)->countAllResults();
    }
}