<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Image Gallery Model
 * 
 * Handles image gallery management with ordering and homepage features
 * 
 * @package App\Models
 * @author  Senior PHP Architect
 */
class ImageGalleryModel extends Model
{
    protected $table            = 'image_gallery';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title', 'description', 'image_path', 'alt_text', 'sort_order', 
        'is_homepage', 'status', 'file_size', 'dimensions'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'title'      => 'required|min_length[3]|max_length[255]',
        'image_path' => 'required|max_length[255]',
        'status'     => 'required|in_list[active,inactive]',
        'sort_order' => 'integer'
    ];

    protected $validationMessages = [
        'title' => [
            'required'    => 'Image title is required',
            'min_length'  => 'Title must be at least 3 characters',
            'max_length'  => 'Title cannot exceed 255 characters'
        ],
        'image_path' => [
            'required' => 'Image path is required'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Get active images ordered by sort_order
     */
    public function getActiveImages(int $limit = null): array
    {
        $builder = $this->where('status', 'active')
                       ->orderBy('sort_order', 'ASC')
                       ->orderBy('created_at', 'DESC');
        
        return $limit ? $builder->findAll($limit) : $builder->findAll();
    }

    /**
     * Get homepage images
     */
    public function getHomepageImages(int $limit = 10): array
    {
        return $this->where('status', 'active')
                    ->where('is_homepage', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll($limit);
    }

    /**
     * Get all images for admin with pagination
     */
    public function getAdminImagesList(int $perPage = 20): array
    {
        return $this->orderBy('sort_order', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->paginate($perPage);
    }

    /**
     * Update sort order for multiple images
     */
    public function updateSortOrder(array $imageOrders): bool
    {
        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($imageOrders as $imageId => $sortOrder) {
            $this->update($imageId, ['sort_order' => $sortOrder]);
        }

        $db->transComplete();
        return $db->transStatus();
    }

    /**
     * Toggle homepage status
     */
    public function toggleHomepage(int $id): bool
    {
        $image = $this->find($id);
        if (!$image) return false;

        $newStatus = $image['is_homepage'] ? 0 : 1;
        return $this->update($id, ['is_homepage' => $newStatus]);
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(int $id): bool
    {
        $image = $this->find($id);
        if (!$image) return false;

        $newStatus = $image['status'] === 'active' ? 'inactive' : 'active';
        return $this->update($id, ['status' => $newStatus]);
    }

    /**
     * Get next sort order
     */
    public function getNextSortOrder(): int
    {
        $maxOrder = $this->selectMax('sort_order')->first();
        return ($maxOrder['sort_order'] ?? 0) + 1;
    }

    /**
     * Get image statistics
     */
    public function getImageStats(): array
    {
        return [
            'total' => $this->countAllResults(),
            'active' => $this->where('status', 'active')->countAllResults(),
            'inactive' => $this->where('status', 'inactive')->countAllResults(),
            'homepage' => $this->where('is_homepage', 1)->countAllResults(),
            'trashed' => $this->onlyDeleted()->countAllResults()
        ];
    }

    /**
     * Get trashed images
     */
    public function getTrashedImages(): array
    {
        return $this->onlyDeleted()
                    ->orderBy('deleted_at', 'DESC')
                    ->findAll();
    }

    /**
     * Restore soft deleted image
     */
    public function restoreImage(int $id): bool
    {
        return $this->update($id, ['deleted_at' => null]);
    }

    /**
     * Bulk update status
     */
    public function bulkUpdateStatus(array $imageIds, string $status): bool
    {
        if (empty($imageIds) || !in_array($status, ['active', 'inactive'])) {
            return false;
        }

        return $this->whereIn('id', $imageIds)
                    ->set(['status' => $status])
                    ->update();
    }

    /**
     * Get default image path
     * Returns the default image path for when no image is available
     */
    public function getDefaultImagePath(): string
    {
        return 'custom/default_image.png';
    }

    /**
     * Get default image with full URL
     */
    public function getDefaultImageUrl(): string
    {
        return base_url($this->getDefaultImagePath());
    }
}