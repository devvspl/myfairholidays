<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Tourism Alliance Model
 * 
 * Handles tourism alliance partners data operations
 * 
 * @package App\Models
 * @author  Senior PHP Architect
 */
class TourismAllianceModel extends Model
{
    protected $table            = 'tourism_alliances';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'logo', 'website_url', 'type', 'is_circle_frame', 'status', 'sort_order'
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
        'type' => 'required|in_list[tourism_board,airline,hotel_chain,travel_agency,other]',
        'status' => 'required|in_list[active,inactive]',
        'website_url' => 'permit_empty|valid_url',
        'logo' => 'permit_empty|max_length[255]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Alliance name is required',
            'min_length' => 'Alliance name must be at least 2 characters',
            'max_length' => 'Alliance name cannot exceed 255 characters'
        ],
        'type' => [
            'required' => 'Alliance type is required',
            'in_list' => 'Invalid alliance type'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Invalid status'
        ],
        'website_url' => [
            'valid_url' => 'Please enter a valid website URL'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    /**
     * Get active alliances for homepage display
     * 
     * @param int $limit
     * @return array
     */
    public function getActiveAlliances(int $limit = 10): array
    {
        return $this->where('status', 'active')
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get alliances by type
     * 
     * @param string $type
     * @param int $limit
     * @return array
     */
    public function getAlliancesByType(string $type, int $limit = null): array
    {
        $builder = $this->where('status', 'active')
                        ->where('type', $type)
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('name', 'ASC');
        
        return $limit ? $builder->limit($limit)->findAll() : $builder->findAll();
    }

    /**
     * Get alliances with pagination for admin panel
     * 
     * @param int $perPage
     * @param string|null $searchTerm
     * @return array
     */
    public function getAdminAlliancesList(int $perPage = 20, ?string $searchTerm = null): array
    {
        $builder = $this->orderBy('sort_order', 'ASC')
                        ->orderBy('name', 'ASC');
        
        if (!empty($searchTerm)) {
            $builder->groupStart()
                   ->like('name', $searchTerm)
                   ->orLike('website_url', $searchTerm)
                   ->orLike('type', $searchTerm)
                   ->groupEnd();
        }
        
        return $builder->paginate($perPage);
    }

    /**
     * Get alliance statistics
     * 
     * @return array
     */
    public function getAllianceStats(): array
    {
        return [
            'total' => $this->countAllResults(),
            'active' => $this->where('status', 'active')->countAllResults(),
            'inactive' => $this->where('status', 'inactive')->countAllResults(),
            'tourism_boards' => $this->where('type', 'tourism_board')->countAllResults(),
            'airlines' => $this->where('type', 'airline')->countAllResults(),
            'hotel_chains' => $this->where('type', 'hotel_chain')->countAllResults(),
            'travel_agencies' => $this->where('type', 'travel_agency')->countAllResults(),
            'others' => $this->where('type', 'other')->countAllResults(),
            'trashed' => $this->onlyDeleted()->countAllResults()
        ];
    }

    /**
     * Get available alliance types
     * 
     * @return array
     */
    public function getAllianceTypes(): array
    {
        return [
            'tourism_board' => 'Tourism Board',
            'airline' => 'Airline',
            'hotel_chain' => 'Hotel Chain',
            'travel_agency' => 'Travel Agency',
            'other' => 'Other'
        ];
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
     * Get trashed alliances
     * 
     * @return array
     */
    public function getTrashedAlliances(): array
    {
        return $this->onlyDeleted()
                    ->orderBy('deleted_at', 'DESC')
                    ->findAll();
    }

    /**
     * Restore soft deleted alliance
     * 
     * @param int $id
     * @return bool
     */
    public function restoreAlliance(int $id): bool
    {
        $db = \Config\Database::connect();
        
        $builder = $db->table($this->table);
        $result = $builder->where('id', $id)
                         ->where('deleted_at IS NOT NULL')
                         ->update(['deleted_at' => null, 'updated_at' => date('Y-m-d H:i:s')]);
        
        return $result > 0;
    }

    /**
     * Get next sort order
     * 
     * @return int
     */
    public function getNextSortOrder(): int
    {
        $maxOrder = $this->selectMax('sort_order')->first();
        return ($maxOrder['sort_order'] ?? 0) + 1;
    }

    /**
     * Get default logo path
     * 
     * @return string
     */
    public function getDefaultLogoPath(): string
    {
        return 'main/images/default-logo.png';
    }

    /**
     * Get default logo with full URL
     * 
     * @return string
     */
    public function getDefaultLogoUrl(): string
    {
        return base_url($this->getDefaultLogoPath());
    }
}