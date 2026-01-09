<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Meta Tag Model
 * 
 * Handles SEO meta tags data operations
 * 
 * @package App\Models
 * @author  Senior PHP Architect
 */
class MetaTagModel extends Model
{
    protected $table            = 'meta_tags';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'page_name', 'page_url', 'meta_title', 'meta_description', 'meta_keywords',
        'og_title', 'og_description', 'og_image', 'twitter_title', 'twitter_description',
        'twitter_image', 'canonical_url', 'robots', 'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'page_name' => 'required|min_length[3]|max_length[255]',
        'page_url' => 'required|max_length[255]',
        'meta_title' => 'permit_empty|max_length[255]',
        'meta_description' => 'permit_empty|max_length[500]',
        'og_title' => 'permit_empty|max_length[255]',
        'twitter_title' => 'permit_empty|max_length[255]',
        'canonical_url' => 'permit_empty|valid_url',
        'status' => 'required|in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'page_name' => [
            'required' => 'Page name is required',
            'min_length' => 'Page name must be at least 3 characters',
            'max_length' => 'Page name cannot exceed 255 characters'
        ],
        'page_url' => [
            'required' => 'Page URL is required',
            'max_length' => 'Page URL cannot exceed 255 characters'
        ],
        'meta_title' => [
            'max_length' => 'Meta title cannot exceed 255 characters'
        ],
        'meta_description' => [
            'max_length' => 'Meta description cannot exceed 500 characters'
        ],
        'og_title' => [
            'max_length' => 'OG title cannot exceed 255 characters'
        ],
        'twitter_title' => [
            'max_length' => 'Twitter title cannot exceed 255 characters'
        ],
        'canonical_url' => [
            'valid_url' => 'Please enter a valid canonical URL'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Invalid status'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get meta tags for admin listing with pagination
     * 
     * @param int $perPage
     * @return array
     */
    public function getAdminMetaTagsList(int $perPage = 20): array
    {
        return $this->orderBy('page_name', 'ASC')
                    ->paginate($perPage);
    }

    /**
     * Get meta tags by page URL
     * 
     * @param string $pageUrl
     * @return array|null
     */
    public function getByPageUrl(string $pageUrl): ?array
    {
        return $this->where('page_url', $pageUrl)
                    ->where('status', 'active')
                    ->first();
    }

    /**
     * Get meta tags by page URL pattern (for dynamic pages)
     * 
     * @param string $pageUrl
     * @return array|null
     */
    public function getByPageUrlPattern(string $pageUrl): ?array
    {
        // First try exact match
        $metaTags = $this->getByPageUrl($pageUrl);
        
        if ($metaTags) {
            return $metaTags;
        }

        // Try pattern matching for dynamic URLs
        $patterns = $this->select('*')
                         ->where('status', 'active')
                         ->where('page_url LIKE', '%*%')
                         ->findAll();

        foreach ($patterns as $pattern) {
            $regex = str_replace('*', '.*', preg_quote($pattern['page_url'], '/'));
            if (preg_match('/^' . $regex . '$/', $pageUrl)) {
                return $pattern;
            }
        }

        return null;
    }

    /**
     * Get default meta tags (fallback)
     * 
     * @return array|null
     */
    public function getDefaultMetaTags(): ?array
    {
        return $this->where('page_url', 'default')
                    ->where('status', 'active')
                    ->first();
    }

    /**
     * Get all active meta tags for sitemap
     * 
     * @return array
     */
    public function getActiveMetaTags(): array
    {
        return $this->where('status', 'active')
                    ->where('page_url !=', 'default')
                    ->orderBy('page_name', 'ASC')
                    ->findAll();
    }

    /**
     * Get meta tags statistics
     * 
     * @return array
     */
    public function getMetaTagStats(): array
    {
        return [
            'total' => $this->countAllResults(),
            'active' => $this->where('status', 'active')->countAllResults(),
            'inactive' => $this->where('status', 'inactive')->countAllResults(),
            'with_og_tags' => $this->where('og_title IS NOT NULL')
                                   ->where('og_title !=', '')
                                   ->countAllResults(),
            'with_twitter_tags' => $this->where('twitter_title IS NOT NULL')
                                        ->where('twitter_title !=', '')
                                        ->countAllResults(),
            'with_canonical' => $this->where('canonical_url IS NOT NULL')
                                     ->where('canonical_url !=', '')
                                     ->countAllResults()
        ];
    }

    /**
     * Check if page URL already exists
     * 
     * @param string $pageUrl
     * @param int $excludeId
     * @return bool
     */
    public function pageUrlExists(string $pageUrl, int $excludeId = null): bool
    {
        $builder = $this->where('page_url', $pageUrl);
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->countAllResults() > 0;
    }

    /**
     * Generate meta tags for dynamic content
     * 
     * @param string $pageUrl
     * @param string $title
     * @param string $description
     * @param string $image
     * @return array
     */
    public function generateDynamicMetaTags(string $pageUrl, string $title, string $description = '', string $image = ''): array
    {
        // Get existing meta tags for this URL
        $existingMeta = $this->getByPageUrlPattern($pageUrl);
        
        if ($existingMeta) {
            // Use existing meta tags as base and override with dynamic content
            $metaTags = $existingMeta;
            
            // Override with dynamic content if provided
            if (!empty($title)) {
                $metaTags['meta_title'] = $title;
                $metaTags['og_title'] = $title;
                $metaTags['twitter_title'] = $title;
            }
            
            if (!empty($description)) {
                $metaTags['meta_description'] = $description;
                $metaTags['og_description'] = $description;
                $metaTags['twitter_description'] = $description;
            }
            
            if (!empty($image)) {
                $metaTags['og_image'] = $image;
                $metaTags['twitter_image'] = $image;
            }
        } else {
            // Create new meta tags
            $metaTags = [
                'meta_title' => $title,
                'meta_description' => $description,
                'og_title' => $title,
                'og_description' => $description,
                'og_image' => $image,
                'twitter_title' => $title,
                'twitter_description' => $description,
                'twitter_image' => $image,
                'canonical_url' => base_url($pageUrl),
                'robots' => 'index,follow'
            ];
        }

        return $metaTags;
    }

    /**
     * Bulk update meta tags
     * 
     * @param array $metaTagsData
     * @return bool
     */
    public function bulkUpdateMetaTags(array $metaTagsData): bool
    {
        $this->db->transStart();

        foreach ($metaTagsData as $data) {
            if (isset($data['id'])) {
                $this->update($data['id'], $data);
            } else {
                $this->insert($data);
            }
        }

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    /**
     * Get pages without meta tags
     * 
     * @param array $pageUrls
     * @return array
     */
    public function getPagesWithoutMetaTags(array $pageUrls): array
    {
        $existingUrls = $this->select('page_url')
                             ->whereIn('page_url', $pageUrls)
                             ->findColumn('page_url');

        return array_diff($pageUrls, $existingUrls);
    }

    /**
     * Auto-generate meta tags for missing pages
     * 
     * @param array $pages
     * @return bool
     */
    public function autoGenerateMetaTags(array $pages): bool
    {
        $this->db->transStart();

        foreach ($pages as $page) {
            $data = [
                'page_name' => $page['name'],
                'page_url' => $page['url'],
                'meta_title' => $page['title'] ?? $page['name'],
                'meta_description' => $page['description'] ?? '',
                'og_title' => $page['title'] ?? $page['name'],
                'og_description' => $page['description'] ?? '',
                'twitter_title' => $page['title'] ?? $page['name'],
                'twitter_description' => $page['description'] ?? '',
                'canonical_url' => base_url($page['url']),
                'robots' => 'index,follow',
                'status' => 'active'
            ];

            $this->insert($data);
        }

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    /**
     * Get meta tags for specific content types
     * 
     * @param string $contentType (news, itinerary, hotel, etc.)
     * @return array
     */
    public function getMetaTagsByContentType(string $contentType): array
    {
        return $this->like('page_url', $contentType)
                    ->where('status', 'active')
                    ->orderBy('page_name', 'ASC')
                    ->findAll();
    }

    /**
     * Validate meta tag lengths and content
     * 
     * @param array $data
     * @return array
     */
    public function validateMetaTagContent(array $data): array
    {
        $errors = [];

        // Check meta title length (recommended: 50-60 characters)
        if (isset($data['meta_title']) && strlen($data['meta_title']) > 60) {
            $errors['meta_title'] = 'Meta title should be under 60 characters for better SEO';
        }

        // Check meta description length (recommended: 150-160 characters)
        if (isset($data['meta_description']) && strlen($data['meta_description']) > 160) {
            $errors['meta_description'] = 'Meta description should be under 160 characters for better SEO';
        }

        // Check OG title length (recommended: under 95 characters)
        if (isset($data['og_title']) && strlen($data['og_title']) > 95) {
            $errors['og_title'] = 'OG title should be under 95 characters for better social sharing';
        }

        // Check OG description length (recommended: under 300 characters)
        if (isset($data['og_description']) && strlen($data['og_description']) > 300) {
            $errors['og_description'] = 'OG description should be under 300 characters for better social sharing';
        }

        return $errors;
    }
}