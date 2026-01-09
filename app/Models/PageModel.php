<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Page Model
 * 
 * Handles CMS page management with SEO meta fields
 * 
 * @package App\Models
 * @author  Senior PHP Architect
 */
class PageModel extends Model
{
    protected $table            = 'pages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title', 'slug', 'content', 'excerpt', 'featured_image', 'template', 
        'status', 'is_homepage', 'show_in_menu', 'menu_order', 'meta_title', 
        'meta_description', 'meta_keywords', 'author_id', 'is_featured'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'title'   => 'required|min_length[3]|max_length[255]',
        'slug'    => 'required|min_length[3]|max_length[255]',
        'content' => 'required|min_length[10]',
        'status'  => 'required|in_list[draft,published]',
        'author_id' => 'required|integer'
    ];

    protected $validationMessages = [
        'title' => [
            'required'    => 'Page title is required',
            'min_length'  => 'Title must be at least 3 characters',
            'max_length'  => 'Title cannot exceed 255 characters'
        ],
        'slug' => [
            'required'    => 'URL slug is required',
            'is_unique'   => 'This slug already exists'
        ],
        'content' => [
            'required'    => 'Page content is required',
            'min_length'  => 'Content must be at least 10 characters'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateSlug'];
    protected $beforeUpdate   = ['generateSlug'];

    /**
     * Generate slug from title if not provided
     */
    protected function generateSlug(array $data): array
    {
        if (isset($data['data']['title']) && empty($data['data']['slug'])) {
            $data['data']['slug'] = url_title($data['data']['title'], '-', true);
        }
        return $data;
    }

    /**
     * Get published pages
     */
    public function getPublishedPages(): array
    {
        return $this->select('pages.*, users.name as author_name')
                    ->join('users', 'users.id = pages.author_id')
                    ->where('pages.status', 'published')
                    ->orderBy('pages.menu_order', 'ASC')
                    ->orderBy('pages.title', 'ASC')
                    ->findAll();
    }

    /**
     * Get menu pages
     */
    public function getMenuPages(): array
    {
        return $this->where('status', 'published')
                    ->where('show_in_menu', 1)
                    ->orderBy('menu_order', 'ASC')
                    ->orderBy('title', 'ASC')
                    ->findAll();
    }

    /**
     * Get page by slug
     */
    public function getPageBySlug(string $slug): ?array
    {
        return $this->select('pages.*, users.name as author_name')
                    ->join('users', 'users.id = pages.author_id')
                    ->where('pages.slug', $slug)
                    ->where('pages.status', 'published')
                    ->first();
    }

    /**
     * Get homepage
     */
    public function getHomepage(): ?array
    {
        return $this->select('pages.*, users.name as author_name')
                    ->join('users', 'users.id = pages.author_id')
                    ->where('pages.is_homepage', 1)
                    ->where('pages.status', 'published')
                    ->first();
    }

    /**
     * Set homepage
     */
    public function setHomepage(int $pageId): bool
    {
        $db = \Config\Database::connect();
        $db->transStart();

        // Remove current homepage
        $this->set('is_homepage', 0)->where('is_homepage', 1)->update();
        
        // Set new homepage
        $this->update($pageId, ['is_homepage' => 1]);

        $db->transComplete();
        return $db->transStatus();
    }

    /**
     * Get admin pages list with pagination
     */
    public function getAdminPagesList(int $perPage = 20): array
    {
        return $this->select('pages.*, users.name as author_name')
                    ->join('users', 'users.id = pages.author_id')
                    ->orderBy('pages.created_at', 'DESC')
                    ->paginate($perPage);
    }

    /**
     * Get trashed pages
     */
    public function getTrashedPages(): array
    {
        return $this->select('pages.*, users.name as author_name')
                    ->join('users', 'users.id = pages.author_id')
                    ->onlyDeleted()
                    ->orderBy('pages.deleted_at', 'DESC')
                    ->findAll();
    }

    /**
     * Restore soft deleted page
     */
    public function restorePage(int $id): bool
    {
        $db = \Config\Database::connect();
        
        // Use direct database query to update soft-deleted records
        $builder = $db->table($this->table);
        $result = $builder->where('id', $id)
                         ->where('deleted_at IS NOT NULL')
                         ->update(['deleted_at' => null, 'updated_at' => date('Y-m-d H:i:s')]);
        
        return $result > 0;
    }

    /**
     * Get page statistics
     */
    public function getPageStats(): array
    {
        return [
            'total' => $this->countAllResults(),
            'published' => $this->where('status', 'published')->countAllResults(),
            'draft' => $this->where('status', 'draft')->countAllResults(),
            'homepage' => $this->where('is_homepage', 1)->countAllResults(),
            'menu_pages' => $this->where('show_in_menu', 1)->countAllResults(),
            'featured' => $this->where('is_featured', 1)->countAllResults(),
            'trashed' => $this->onlyDeleted()->countAllResults()
        ];
    }

    /**
     * Get featured blog posts
     */
    public function getFeaturedPosts(int $limit = 5): array
    {
        return $this->select('pages.*, users.name as author_name')
                    ->join('users', 'users.id = pages.author_id')
                    ->where('pages.status', 'published')
                    ->where('pages.is_featured', 1)
                    ->orderBy('pages.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get recent blog posts
     */
    public function getRecentPosts(int $limit = 10): array
    {
        return $this->select('pages.*, users.name as author_name')
                    ->join('users', 'users.id = pages.author_id')
                    ->where('pages.status', 'published')
                    ->orderBy('pages.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Update menu order for multiple pages
     */
    public function updateMenuOrder(array $pageOrders): bool
    {
        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($pageOrders as $pageId => $menuOrder) {
            $this->update($pageId, ['menu_order' => $menuOrder]);
        }

        $db->transComplete();
        return $db->transStatus();
    }

    /**
     * Get available templates
     */
    public function getAvailableTemplates(): array
    {
        return [
            'default' => 'Default Template',
            'full-width' => 'Full Width Template',
            'sidebar' => 'Sidebar Template',
            'landing' => 'Landing Page Template',
            'contact' => 'Contact Page Template'
        ];
    }
}