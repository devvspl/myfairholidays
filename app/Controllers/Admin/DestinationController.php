<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DestinationModel;

/**
 * Admin Destinations Controller
 * 
 * Handles destination management in admin panel
 * 
 * @package App\Controllers\Admin
 */
class DestinationController extends BaseController
{
    protected $destinationModel;

    public function __construct()
    {
        $this->destinationModel = new DestinationModel();
    }

    /**
     * Display list of destinations
     */
    public function index()
    {
        $pager = \Config\Services::pager();
        $typeFilter = $this->request->getGet('type');
        
        $data = [
            'title' => 'Destinations Management',
            'destinations' => $this->destinationModel->getAdminDestinationsList(10, $typeFilter),
            'pager' => $this->destinationModel->pager,
            'stats' => $this->destinationModel->getDestinationStats(),
            'selectedType' => $typeFilter,
            'destinationTypes' => $this->destinationModel->getDestinationTypes()
        ];
         return view('admin/destinations/index', $data);
    }

    /**
     * Show create destination form
     */
    public function create()
    {
        $data = [
            'title' => 'Add New Destination'
        ];

        return view('admin/destinations/create', $data);
    }

    /**
     * Store new destination
     */
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[10]',
            'type' => 'required|in_list[country,state,city,destination]',
            'status' => 'required|in_list[active,inactive]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'type' => $this->request->getPost('type'),
            'type_id' => $this->request->getPost('type_id') ?: null,
            'parent_id' => $this->request->getPost('parent_id') ?: null,
            'content' => $this->request->getPost('content'),
            'latitude' => $this->request->getPost('latitude') ?: null,
            'longitude' => $this->request->getPost('longitude') ?: null,
            'is_popular' => $this->request->getPost('is_popular') ? 1 : 0,
            'status' => $this->request->getPost('status'),
            'sort_order' => 0,
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description')
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $uploadPath = FCPATH . 'uploads/destinations/';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            if ($image->move($uploadPath, $newName)) {
                $data['image'] = 'uploads/destinations/' . $newName;
            }
        }

        if ($this->destinationModel->insert($data)) {
            return redirect()->to('/admin/destinations')->with('success', 'Destination created successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create destination');
    }

    /**
     * Show edit destination form
     */
    public function edit($id)
    {
        $destination = $this->destinationModel->find($id);
        
        if (!$destination) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Destination not found');
        }

        $data = [
            'title' => 'Edit Destination',
            'destination' => $destination
        ];

        return view('admin/destinations/edit', $data);
    }

    /**
     * Update destination
     */
    public function update($id)
    {
        $destination = $this->destinationModel->find($id);
        
        if (!$destination) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Destination not found');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[10]',
            'type' => 'required|in_list[country,state,city,destination]',
            'status' => 'required|in_list[active,inactive]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'type' => $this->request->getPost('type'),
            'type_id' => $this->request->getPost('type_id') ?: null,
            'parent_id' => $this->request->getPost('parent_id') ?: null,
            'content' => $this->request->getPost('content'),
            'latitude' => $this->request->getPost('latitude') ?: null,
            'longitude' => $this->request->getPost('longitude') ?: null,
            'is_popular' => $this->request->getPost('is_popular') ? 1 : 0,
            'status' => $this->request->getPost('status'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description')
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Delete old image if exists
            if ($destination['image'] && file_exists(FCPATH . $destination['image'])) {
                unlink(FCPATH . $destination['image']);
            }
            
            $newName = $image->getRandomName();
            $uploadPath = FCPATH . 'uploads/destinations/';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            if ($image->move($uploadPath, $newName)) {
                $data['image'] = 'uploads/destinations/' . $newName;
            }
        }

        // Handle image removal
        if ($this->request->getPost('remove_image')) {
            if ($destination['image'] && file_exists(FCPATH . $destination['image'])) {
                unlink(FCPATH . $destination['image']);
            }
            $data['image'] = null;
        }

        if ($this->destinationModel->update($id, $data)) {
            return redirect()->to('/admin/destinations')->with('success', 'Destination updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update destination');
    }

    /**
     * Delete destination
     */
    public function delete($id)
    {
        $destination = $this->destinationModel->find($id);
        
        if (!$destination) {
            return redirect()->to('/admin/destinations')->with('error', 'Destination not found');
        }

        // Check if destination has children
        if ($this->destinationModel->hasChildren($id)) {
            return redirect()->to('/admin/destinations')->with('error', 'Cannot delete destination with child destinations');
        }

        if ($this->destinationModel->delete($id)) {
            return redirect()->to('/admin/destinations')->with('success', 'Destination deleted successfully');
        }

        return redirect()->to('/admin/destinations')->with('error', 'Failed to delete destination');
    }

    /**
     * Toggle destination status
     */
    public function toggleStatus($id)
    {
        $destination = $this->destinationModel->find($id);
        
        if (!$destination) {
            return $this->response->setJSON(['success' => false, 'message' => 'Destination not found']);
        }

        $newStatus = $destination['status'] === 'active' ? 'inactive' : 'active';
        
        if ($this->destinationModel->update($id, ['status' => $newStatus])) {
            return $this->response->setJSON(['success' => true, 'status' => $newStatus]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
    }

    /**
     * Toggle popular status
     */
    public function togglePopular($id)
    {
        $destination = $this->destinationModel->find($id);
        
        if (!$destination) {
            return $this->response->setJSON(['success' => false, 'message' => 'Destination not found']);
        }

        $newPopular = $destination['is_popular'] ? 0 : 1;
        
        if ($this->destinationModel->update($id, ['is_popular' => $newPopular])) {
            return $this->response->setJSON(['success' => true, 'is_popular' => $newPopular]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update popular status']);
    }

    /**
     * Show trashed destinations
     */
    public function trash()
    {
        $data = [
            'title' => 'Trashed Destinations',
            'destinations' => $this->destinationModel->getTrashedDestinations()
        ];

        return view('admin/destinations/trash', $data);
    }

    /**
     * Restore destination from trash
     */
    public function restore($id)
    {
        if ($this->destinationModel->restoreDestination($id)) {
            return redirect()->to('/admin/destinations/trash')->with('success', 'Destination restored successfully');
        }

        return redirect()->to('/admin/destinations/trash')->with('error', 'Failed to restore destination');
    }

    /**
     * Permanently delete destination
     */
    public function forceDelete($id)
    {
        $destination = $this->destinationModel->onlyDeleted()->find($id);
        
        if (!$destination) {
            return redirect()->to('/admin/destinations/trash')->with('error', 'Destination not found');
        }

        // Delete image if exists
        if ($destination['image'] && file_exists(FCPATH . $destination['image'])) {
            unlink(FCPATH . $destination['image']);
        }

        if ($this->destinationModel->delete($id, true)) {
            return redirect()->to('/admin/destinations/trash')->with('success', 'Destination permanently deleted');
        }

        return redirect()->to('/admin/destinations/trash')->with('error', 'Failed to delete destination');
    }

    /**
     * Bulk actions
     */
    public function bulkAction()
    {
        $action = $this->request->getPost('bulk_action');
        $destinationIds = $this->request->getPost('destination_ids');

        if (empty($action) || empty($destinationIds)) {
            return redirect()->back()->with('error', 'Please select destinations and action');
        }

        $count = 0;
        foreach ($destinationIds as $destinationId) {
            switch ($action) {
                case 'activate':
                    if ($this->destinationModel->update($destinationId, ['status' => 'active'])) {
                        $count++;
                    }
                    break;
                case 'deactivate':
                    if ($this->destinationModel->update($destinationId, ['status' => 'inactive'])) {
                        $count++;
                    }
                    break;
                case 'popular':
                    if ($this->destinationModel->update($destinationId, ['is_popular' => 1])) {
                        $count++;
                    }
                    break;
                case 'unpopular':
                    if ($this->destinationModel->update($destinationId, ['is_popular' => 0])) {
                        $count++;
                    }
                    break;
                case 'delete':
                    if ($this->destinationModel->delete($destinationId)) {
                        $count++;
                    }
                    break;
            }
        }

        $message = $count > 0 ? "{$count} destinations updated successfully" : "No destinations were updated";
        return redirect()->back()->with('success', $message);
    }
}