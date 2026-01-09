<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Video Gallery Model
 * 
 * Handles video gallery management with YouTube/MP4 support
 * 
 * @package App\Models
 * @author  Senior PHP Architect
 */
class VideoGalleryModel extends Model
{
    protected $table            = 'video_gallery';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title', 'description', 'video_type', 'video_url', 'video_id', 
        'thumbnail', 'duration', 'sort_order', 'is_homepage', 'status'
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
        'video_url'  => 'required|valid_url',
        'video_type' => 'required|in_list[youtube,mp4,vimeo]',
        'status'     => 'required|in_list[active,inactive]',
        'sort_order' => 'integer'
    ];

    protected $validationMessages = [
        'title' => [
            'required'    => 'Video title is required',
            'min_length'  => 'Title must be at least 3 characters',
            'max_length'  => 'Title cannot exceed 255 characters'
        ],
        'video_url' => [
            'required'   => 'Video URL is required',
            'valid_url'  => 'Please enter a valid URL'
        ],
        'video_type' => [
            'required' => 'Video type is required',
            'in_list'  => 'Invalid video type selected'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['extractVideoId'];
    protected $beforeUpdate   = ['extractVideoId'];

    /**
     * Extract video ID from URL based on type
     */
    protected function extractVideoId(array $data): array
    {
        if (isset($data['data']['video_url']) && isset($data['data']['video_type'])) {
            $url = $data['data']['video_url'];
            $type = $data['data']['video_type'];

            switch ($type) {
                case 'youtube':
                    $data['data']['video_id'] = $this->extractYouTubeId($url);
                    break;
                case 'vimeo':
                    $data['data']['video_id'] = $this->extractVimeoId($url);
                    break;
                case 'mp4':
                    $data['data']['video_id'] = basename($url);
                    break;
            }
        }
        return $data;
    }

    /**
     * Extract YouTube video ID from URL
     */
    private function extractYouTubeId(string $url): ?string
    {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Extract Vimeo video ID from URL
     */
    private function extractVimeoId(string $url): ?string
    {
        preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/', $url, $matches);
        return $matches[3] ?? null;
    }

    /**
     * Get active videos ordered by sort_order
     */
    public function getActiveVideos(int $limit = null): array
    {
        $builder = $this->where('status', 'active')
                       ->orderBy('sort_order', 'ASC')
                       ->orderBy('created_at', 'DESC');
        
        return $limit ? $builder->findAll($limit) : $builder->findAll();
    }

    /**
     * Get homepage videos
     */
    public function getHomepageVideos(int $limit = 6): array
    {
        return $this->where('status', 'active')
                    ->where('is_homepage', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll($limit);
    }

    /**
     * Get all videos for admin with pagination
     */
    public function getAdminVideosList(int $perPage = 20): array
    {
        return $this->orderBy('sort_order', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->paginate($perPage);
    }

    /**
     * Update sort order for multiple videos
     */
    public function updateSortOrder(array $videoOrders): bool
    {
        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($videoOrders as $videoId => $sortOrder) {
            $this->update($videoId, ['sort_order' => $sortOrder]);
        }

        $db->transComplete();
        return $db->transStatus();
    }

    /**
     * Toggle homepage status
     */
    public function toggleHomepage(int $id): bool
    {
        $video = $this->find($id);
        if (!$video) return false;

        $newStatus = $video['is_homepage'] ? 0 : 1;
        return $this->update($id, ['is_homepage' => $newStatus]);
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(int $id): bool
    {
        $video = $this->find($id);
        if (!$video) return false;

        $newStatus = $video['status'] === 'active' ? 'inactive' : 'active';
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
     * Get video statistics
     */
    public function getVideoStats(): array
    {
        return [
            'total' => $this->countAllResults(),
            'active' => $this->where('status', 'active')->countAllResults(),
            'inactive' => $this->where('status', 'inactive')->countAllResults(),
            'homepage' => $this->where('is_homepage', 1)->countAllResults(),
            'youtube' => $this->where('video_type', 'youtube')->countAllResults(),
            'mp4' => $this->where('video_type', 'mp4')->countAllResults(),
            'vimeo' => $this->where('video_type', 'vimeo')->countAllResults(),
            'trashed' => $this->onlyDeleted()->countAllResults()
        ];
    }

    /**
     * Get trashed videos
     */
    public function getTrashedVideos(): array
    {
        return $this->onlyDeleted()
                    ->orderBy('deleted_at', 'DESC')
                    ->findAll();
    }

    /**
     * Restore soft deleted video
     */
    public function restoreVideo(int $id): bool
    {
        return $this->update($id, ['deleted_at' => null]);
    }

    /**
     * Generate thumbnail URL for video
     */
    public function generateThumbnailUrl(array $video): string
    {
        switch ($video['video_type']) {
            case 'youtube':
                return "https://img.youtube.com/vi/{$video['video_id']}/maxresdefault.jpg";
            case 'vimeo':
                // For Vimeo, you'd need to make an API call to get thumbnail
                return $video['thumbnail'] ?? '/assets/images/video-placeholder.jpg';
            case 'mp4':
                return $video['thumbnail'] ?? '/assets/images/video-placeholder.jpg';
            default:
                return '/assets/images/video-placeholder.jpg';
        }
    }
}