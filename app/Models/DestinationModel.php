<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Destination Model
 *
 * Handles destinations (countries, states, cities) data operations
 *
 * @package App\Models
 * @author  Senior PHP Architect
 */
class DestinationModel extends Model
{
    protected $table = 'destinations';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;

    protected $allowedFields = [
        'name', 'slug', 'type', 'type_id', 'parent_id', 'description', 'content', 'image',
        'latitude', 'longitude', 'is_popular', 'status', 'sort_order',
        'meta_title', 'meta_description'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[255]',
        'type' => 'required|in_list[country,state,city,destination]',
        'status' => 'required|in_list[active,inactive]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Destination name is required',
            'min_length' => 'Destination name must be at least 2 characters',
            'max_length' => 'Destination name cannot exceed 255 characters'
        ],
        'type' => [
            'required' => 'Destination type is required',
            'in_list' => 'Invalid destination type'
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
    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

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
     * Get destinations for admin listing with pagination
     *
     * @param int $perPage
     * @param string|null $typeFilter
     * @return array
     */
    public function getAdminDestinationsList(int $perPage = 20, ?string $typeFilter = null)
    {
        $builder = $this
            ->select([
                'destinations.*',
                'parent.name as parent_name',
                'type.name as destination_type'
            ])
            ->join('destinations as parent', 'parent.id = destinations.parent_id', 'left')
            ->join('destination_types as type', 'type.id = destinations.type_id', 'left');

        if ($typeFilter && $typeFilter !== 'all') {
            $builder->where('destinations.type_id', $typeFilter);
        }

        return $builder
            ->orderBy('destinations.type', 'ASC')
            ->orderBy('destinations.sort_order', 'ASC')
            ->orderBy('destinations.name', 'ASC')
            ->paginate($perPage);
    }

    /**
     * Get destinations by type
     *
     * @param string $type
     * @param string $status
     * @return array
     */
    public function getByType(string $type, string $status = 'active'): array
    {
        return $this
            ->where('type', $type)
            ->where('status', $status)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('name', 'ASC')
            ->findAll();
    }

    /**
     * Get countries for dropdown
     *
     * @return array
     */
    public function getCountriesDropdown(): array
    {
        $countries = $this
            ->select('id, name')
            ->where('type', 'country')
            ->where('status', 'active')
            ->orderBy('name', 'ASC')
            ->findAll();

        $dropdown = [];
        foreach ($countries as $country) {
            $dropdown[$country['id']] = $country['name'];
        }

        return $dropdown;
    }

    /**
     * Get states by country
     *
     * @param int $countryId
     * @return array
     */
    public function getStatesByCountry(int $countryId): array
    {
        return $this
            ->where('type', 'state')
            ->where('parent_id', $countryId)
            ->where('status', 'active')
            ->orderBy('name', 'ASC')
            ->findAll();
    }

    /**
     * Get cities by state
     *
     * @param int $stateId
     * @return array
     */
    public function getCitiesByState(int $stateId): array
    {
        return $this
            ->where('type', 'city')
            ->where('parent_id', $stateId)
            ->where('status', 'active')
            ->orderBy('name', 'ASC')
            ->findAll();
    }

    /**
     * Get popular destinations
     *
     * @param int $limit
     * @return array
     */
    public function getPopularDestinations(int $limit = 10): array
    {
        return $this
            ->where('is_popular', 1)
            ->where('status', 'active')
            ->orderBy('sort_order', 'ASC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Get destination hierarchy (breadcrumb)
     *
     * @param int $destinationId
     * @return array
     */
    public function getDestinationHierarchy(int $destinationId): array
    {
        $destination = $this->find($destinationId);
        if (!$destination) {
            return [];
        }

        $hierarchy = [$destination];

        // Get parent hierarchy
        $parentId = $destination['parent_id'];
        while ($parentId) {
            $parent = $this->find($parentId);
            if ($parent) {
                array_unshift($hierarchy, $parent);
                $parentId = $parent['parent_id'];
            } else {
                break;
            }
        }

        return $hierarchy;
    }

    /**
     * Get destinations statistics
     *
     * @return array
     */
    public function getDestinationStats(): array
    {
        return [
            'total' => $this->countAllResults(),
            'active' => $this->where('status', 'active')->countAllResults(),
            'inactive' => $this->where('status', 'inactive')->countAllResults(),
            'countries' => $this->where('type', 'country')->countAllResults(),
            'states' => $this->where('type', 'state')->countAllResults(),
            'cities' => $this->where('type', 'city')->countAllResults(),
            'popular' => $this->where('is_popular', 1)->countAllResults()
        ];
    }

    /**
     * Get trashed destinations
     *
     * @return array
     */
    public function getTrashedDestinations(): array
    {
        return $this
            ->onlyDeleted()
            ->select('destinations.*, parent.name as parent_name')
            ->join('destinations as parent', 'parent.id = destinations.parent_id', 'left')
            ->orderBy('destinations.deleted_at', 'DESC')
            ->findAll();
    }

    /**
     * Restore destination from trash
     *
     * @param int $id
     * @return bool
     */
    public function restoreDestination(int $id): bool
    {
        return $this->update($id, ['deleted_at' => null]);
    }

    /**
     * Check if destination has children
     *
     * @param int $id
     * @return bool
     */
    public function hasChildren(int $id): bool
    {
        return $this->where('parent_id', $id)->countAllResults() > 0;
    }

    /**
     * Get destination with full details including parent info
     *
     * @param int $id
     * @return array|null
     */
    public function getDestinationWithDetails(int $id): ?array
    {
        return $this
            ->select('destinations.*, parent.name as parent_name, parent.type as parent_type')
            ->join('destinations as parent', 'parent.id = destinations.parent_id', 'left')
            ->find($id);
    }

    /**
     * Get destination types for filter dropdown
     *
     * @return array
     */
    public function getDestinationTypes(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('destination_types');
        
        $types = $builder
            ->select('id, name')
            ->where('status', 'active')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();

        $dropdown = ['all' => 'All Types'];
        foreach ($types as $type) {
            $dropdown[$type['id']] = $type['name'];
        }

        return $dropdown;
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
