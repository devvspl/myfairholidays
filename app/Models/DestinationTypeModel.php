<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Destination Type Model
 * 
 * Handles destination types (categories) data operations
 * 
 * @package App\Models
 * @author  Senior PHP Architect
 */
class DestinationTypeModel extends Model
{
    protected $table            = 'destination_types';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'slug', 'description', 'content', 'icon', 'color',
        'image', 'meta_title', 'meta_description', 'status', 'sort_order'
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
            'required' => 'Destination type name is required',
            'min_length' => 'Destination type name must be at least 2 characters',
            'max_length' => 'Destination type name cannot exceed 255 characters'
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
     * Get active destination types for dropdown
     * 
     * @return array
     */
    public function getActiveTypesDropdown(): array
    {
        $types = $this->select('id, name')
                      ->where('status', 'active')
                      ->orderBy('sort_order', 'ASC')
                      ->orderBy('name', 'ASC')
                      ->findAll();

        $dropdown = [];
        foreach ($types as $type) {
            $dropdown[$type['id']] = $type['name'];
        }

        return $dropdown;
    }

    /**
     * Get destination types with destination count
     * 
     * @return array
     */
    public function getTypesWithDestinationCount(): array
    {
        return $this->select('destination_types.*, COUNT(destinations.id) as destination_count')
                    ->join('destinations', 'destinations.type_id = destination_types.id', 'left')
                    ->groupBy('destination_types.id')
                    ->orderBy('destination_types.sort_order', 'ASC')
                    ->orderBy('destination_types.name', 'ASC')
                    ->findAll();
    }

    /**
     * Get destination types with destination count and pagination for admin panel
     * 
     * @param int $perPage
     * @return array
     */
    public function getAdminTypesList(int $perPage = 20): array
    {
        return $this->select('destination_types.*, COUNT(destinations.id) as destination_count')
                    ->join('destinations', 'destinations.type_id = destination_types.id', 'left')
                    ->groupBy('destination_types.id')
                    ->orderBy('destination_types.sort_order', 'ASC')
                    ->orderBy('destination_types.name', 'ASC')
                    ->paginate($perPage);
    }

    /**
     * Get destination type statistics
     * 
     * @return array
     */
    public function getTypeStats(): array
    {
        return [
            'total' => $this->countAllResults(),
            'active' => $this->where('status', 'active')->countAllResults(),
            'inactive' => $this->where('status', 'inactive')->countAllResults(),
            'with_destinations' => $this->select('destination_types.id')
                                       ->join('destinations', 'destinations.type_id = destination_types.id')
                                       ->groupBy('destination_types.id')
                                       ->countAllResults()
        ];
    }

    /**
     * Get active destination types with their destinations for navigation
     * 
     * @return array
     */
    public function getActiveTypesWithDestinations(): array
    {
        $db = \Config\Database::connect();
        
        // Get active destination types
        $types = $this->select('id, name, slug')
                      ->where('status', 'active')
                      ->orderBy('sort_order', 'ASC')
                      ->orderBy('name', 'ASC')
                      ->findAll();

        // Get destinations for each type
        foreach ($types as &$type) {
            $destinations = $db->table('destinations')
                              ->select('id, name, slug')
                              ->where('type_id', $type['id'])
                              ->where('status', 'active')
                              ->orderBy('sort_order', 'ASC')
                              ->orderBy('name', 'ASC')
                              ->limit(10) // Limit to prevent too many menu items
                              ->get()
                              ->getResultArray();
            
            $type['destinations'] = $destinations;
        }

        return $types;
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
}