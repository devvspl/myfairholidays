<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DestinationTypeModel;

/**
 * Admin Destination Type Controller
 * 
 * Handles destination type management in admin panel
 * 
 * @package App\Controllers\Admin
 * @author  Senior PHP Architect
 */
class DestinationTypeController extends BaseController
{
    protected $destinationTypeModel;

    public function __construct()
    {
        $this->destinationTypeModel = new DestinationTypeModel();
    }

    /**
     * Display list of destination types
     */
    public function index()
    {
        $pager = \Config\Services::pager();
        
        $data = [
            'title' => 'Destination Types Management',
            'types' => $this->destinationTypeModel->getAdminTypesList(10),
            'pager' => $this->destinationTypeModel->pager,
            'stats' => $this->destinationTypeModel->getTypeStats()
        ];

        return view('admin/destination_types/index', $data);
    }

    /**
     * Show create destination type form
     */
    public function create()
    {
        $data = [
            'title' => 'Add New Destination Type'
        ];

        return view('admin/destination_types/create', $data);
    }

    /**
     * Store new destination type
     */
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => 'required|min_length[2]|max_length[255]',
            'description' => 'permit_empty|min_length[10]',
            'content' => 'permit_empty|min_length[10]',
            'status' => 'required|in_list[active,inactive]',
            'icon' => 'permit_empty|max_length[100]',
            'color' => 'permit_empty|max_length[7]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'content' => $this->request->getPost('content'),
            'status' => $this->request->getPost('status'),
            'icon' => $this->request->getPost('icon'),
            'color' => $this->request->getPost('color'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'sort_order' => 0
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $uploadPath = FCPATH . 'uploads/destination-types/';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            if ($image->move($uploadPath, $newName)) {
                $data['image'] = 'uploads/destination-types/' . $newName;
            }
        }

        if ($this->destinationTypeModel->insert($data)) {
            return redirect()->to('/admin/destination-types')->with('success', 'Destination type created successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create destination type');
    }

    /**
     * Show edit destination type form
     */
    public function edit($id)
    {
        $type = $this->destinationTypeModel->find($id);
        
        if (!$type) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Destination type not found');
        }

        $data = [
            'title' => 'Edit Destination Type',
            'type' => $type
        ];

        return view('admin/destination_types/edit', $data);
    }

    /**
     * Update destination type
     */
    public function update($id)
    {
        $type = $this->destinationTypeModel->find($id);
        
        if (!$type) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Destination type not found');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => 'required|min_length[2]|max_length[255]',
            'description' => 'permit_empty|min_length[10]',
            'content' => 'permit_empty|min_length[10]',
            'status' => 'required|in_list[active,inactive]',
            'icon' => 'permit_empty|max_length[100]',
            'color' => 'permit_empty|max_length[7]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'content' => $this->request->getPost('content'),
            'status' => $this->request->getPost('status'),
            'icon' => $this->request->getPost('icon'),
            'color' => $this->request->getPost('color'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description')
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Delete old image if exists
            if ($type['image'] && file_exists(FCPATH . $type['image'])) {
                unlink(FCPATH . $type['image']);
            }
            
            $newName = $image->getRandomName();
            $uploadPath = FCPATH . 'uploads/destination-types/';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            if ($image->move($uploadPath, $newName)) {
                $data['image'] = 'uploads/destination-types/' . $newName;
            }
        }

        // Handle image removal
        if ($this->request->getPost('remove_image')) {
            if ($type['image'] && file_exists(FCPATH . $type['image'])) {
                unlink(FCPATH . $type['image']);
            }
            $data['image'] = null;
        }

        if ($this->destinationTypeModel->update($id, $data)) {
            return redirect()->to('/admin/destination-types')->with('success', 'Destination type updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update destination type');
    }

    /**
     * Delete destination type
     */
    public function delete($id)
    {
        $type = $this->destinationTypeModel->find($id);
        
        if (!$type) {
            return redirect()->to('/admin/destination-types')->with('error', 'Destination type not found');
        }

        if ($this->destinationTypeModel->delete($id)) {
            return redirect()->to('/admin/destination-types')->with('success', 'Destination type deleted successfully');
        }

        return redirect()->to('/admin/destination-types')->with('error', 'Failed to delete destination type');
    }

    /**
     * Toggle destination type status
     */
    public function toggleStatus($id)
    {
        $type = $this->destinationTypeModel->find($id);
        
        if (!$type) {
            return $this->response->setJSON(['success' => false, 'message' => 'Destination type not found']);
        }

        $newStatus = $type['status'] === 'active' ? 'inactive' : 'active';
        
        if ($this->destinationTypeModel->update($id, ['status' => $newStatus])) {
            return $this->response->setJSON(['success' => true, 'status' => $newStatus]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
    }

    /**
     * Update sort order
     */
    public function updateSortOrder()
    {
        $sortData = $this->request->getPost('sort_data');
        
        if (!$sortData) {
            return $this->response->setJSON(['success' => false, 'message' => 'No sort data provided']);
        }

        if ($this->destinationTypeModel->updateSortOrder($sortData)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Sort order updated successfully']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update sort order']);
    }

    /**
     * Bulk actions
     */
    public function bulkAction()
    {
        $action = $this->request->getPost('bulk_action');
        $typeIds = $this->request->getPost('type_ids');

        if (empty($action) || empty($typeIds)) {
            return redirect()->back()->with('error', 'Please select destination types and action');
        }

        $count = 0;
        foreach ($typeIds as $typeId) {
            switch ($action) {
                case 'activate':
                    if ($this->destinationTypeModel->update($typeId, ['status' => 'active'])) {
                        $count++;
                    }
                    break;
                case 'deactivate':
                    if ($this->destinationTypeModel->update($typeId, ['status' => 'inactive'])) {
                        $count++;
                    }
                    break;
                case 'delete':
                    if ($this->destinationTypeModel->delete($typeId)) {
                        $count++;
                    }
                    break;
            }
        }

        $message = $count > 0 ? "{$count} destination types updated successfully" : "No destination types were updated";
        return redirect()->back()->with('success', $message);
    }

    /**
     * API: Get active destination types
     */
    public function getActiveTypes()
    {
        $types = $this->destinationTypeModel->select('id, name')
                                           ->where('status', 'active')
                                           ->orderBy('sort_order', 'ASC')
                                           ->orderBy('name', 'ASC')
                                           ->findAll();

        return $this->response->setJSON($types);
    }
}