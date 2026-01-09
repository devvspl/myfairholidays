<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ItineraryModel;
use App\Models\ItineraryCategoryModel;
use App\Models\DestinationModel;

/**
 * Admin Itinerary Controller
 * 
 * Handles itinerary management in admin panel
 * 
 * @package App\Controllers\Admin
 */
class ItineraryController extends BaseController
{
    protected $itineraryModel;
    protected $categoryModel;
    protected $destinationModel;

    public function __construct()
    {
        $this->itineraryModel = new ItineraryModel();
        $this->categoryModel = new ItineraryCategoryModel();
        $this->destinationModel = new DestinationModel();
    }

    /**
     * Display list of itineraries
     */
    public function index()
    {
        $data = [
            'title' => 'Itineraries Management',
            'itineraries' => $this->itineraryModel->getAdminItinerariesList(),
            'stats' => $this->itineraryModel->getItineraryStats(),
            'pager' => $this->itineraryModel->pager
        ];

        return view('admin/itineraries/index', $data);
    }

    /**
     * Show create itinerary form
     */
    public function create()
    {
        $data = [
            'title' => 'Add New Itinerary',
            'categories' => $this->categoryModel->where('status', 'active')->findAll(),
            'destinations' => $this->destinationModel->where('status', 'active')->findAll()
        ];

        return view('admin/itineraries/create', $data);
    }

    /**
     * Store new itinerary
     */
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[10]',
            'category_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'duration_days' => 'required|integer|greater_than[0]',
            'duration_nights' => 'required|integer|greater_than_equal_to[0]',
            'price' => 'required|decimal',
            'status' => 'required|in_list[draft,published]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'short_description' => $this->request->getPost('short_description'),
            'category_id' => $this->request->getPost('category_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'duration_days' => $this->request->getPost('duration_days'),
            'duration_nights' => $this->request->getPost('duration_nights'),
            'price' => $this->request->getPost('price'),
            'discounted_price' => $this->request->getPost('discounted_price'),
            'inclusions' => $this->request->getPost('inclusions'),
            'exclusions' => $this->request->getPost('exclusions'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->itineraryModel->insert($data)) {
            return redirect()->to('/admin/itineraries')->with('success', 'Itinerary created successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create itinerary');
    }

    /**
     * Show edit itinerary form
     */
    public function edit($id)
    {
        $itinerary = $this->itineraryModel->find($id);
        
        if (!$itinerary) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Itinerary not found');
        }

        $data = [
            'title' => 'Edit Itinerary',
            'itinerary' => $itinerary,
            'categories' => $this->categoryModel->where('status', 'active')->findAll(),
            'destinations' => $this->destinationModel->where('status', 'active')->findAll()
        ];

        return view('admin/itineraries/edit', $data);
    }

    /**
     * Update itinerary
     */
    public function update($id)
    {
        $itinerary = $this->itineraryModel->find($id);
        
        if (!$itinerary) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Itinerary not found');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[10]',
            'category_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'duration_days' => 'required|integer|greater_than[0]',
            'duration_nights' => 'required|integer|greater_than_equal_to[0]',
            'price' => 'required|decimal',
            'status' => 'required|in_list[draft,published]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'short_description' => $this->request->getPost('short_description'),
            'category_id' => $this->request->getPost('category_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'duration_days' => $this->request->getPost('duration_days'),
            'duration_nights' => $this->request->getPost('duration_nights'),
            'price' => $this->request->getPost('price'),
            'discounted_price' => $this->request->getPost('discounted_price'),
            'inclusions' => $this->request->getPost('inclusions'),
            'exclusions' => $this->request->getPost('exclusions'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->itineraryModel->update($id, $data)) {
            return redirect()->to('/admin/itineraries')->with('success', 'Itinerary updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update itinerary');
    }

    /**
     * Delete itinerary
     */
    public function delete($id)
    {
        $itinerary = $this->itineraryModel->find($id);
        
        if (!$itinerary) {
            return redirect()->to('/admin/itineraries')->with('error', 'Itinerary not found');
        }

        if ($this->itineraryModel->delete($id)) {
            return redirect()->to('/admin/itineraries')->with('success', 'Itinerary deleted successfully');
        }

        return redirect()->to('/admin/itineraries')->with('error', 'Failed to delete itinerary');
    }

    /**
     * Toggle itinerary status
     */
    public function toggleStatus($id)
    {
        $itinerary = $this->itineraryModel->find($id);
        
        if (!$itinerary) {
            return $this->response->setJSON(['success' => false, 'message' => 'Itinerary not found']);
        }

        $newStatus = $itinerary['status'] === 'published' ? 'draft' : 'published';
        
        if ($this->itineraryModel->update($id, ['status' => $newStatus])) {
            return $this->response->setJSON(['success' => true, 'status' => $newStatus]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
    }

    /**
     * Toggle itinerary featured status
     */
    public function toggleFeatured($id)
    {
        $itinerary = $this->itineraryModel->find($id);
        
        if (!$itinerary) {
            return $this->response->setJSON(['success' => false, 'message' => 'Itinerary not found']);
        }

        $newFeatured = $itinerary['is_featured'] ? 0 : 1;
        
        if ($this->itineraryModel->update($id, ['is_featured' => $newFeatured])) {
            return $this->response->setJSON(['success' => true, 'is_featured' => $newFeatured]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update featured status']);
    }

    /**
     * Handle bulk actions
     */
    public function bulkAction()
    {
        $action = $this->request->getPost('bulk_action');
        $itineraryIds = $this->request->getPost('itinerary_ids');

        if (empty($action) || empty($itineraryIds)) {
            return redirect()->back()->with('error', 'Please select itineraries and an action');
        }

        $count = 0;
        foreach ($itineraryIds as $id) {
            switch ($action) {
                case 'publish':
                    if ($this->itineraryModel->update($id, ['status' => 'published'])) $count++;
                    break;
                case 'draft':
                    if ($this->itineraryModel->update($id, ['status' => 'draft'])) $count++;
                    break;
                case 'feature':
                    if ($this->itineraryModel->update($id, ['is_featured' => 1])) $count++;
                    break;
                case 'unfeature':
                    if ($this->itineraryModel->update($id, ['is_featured' => 0])) $count++;
                    break;
                case 'delete':
                    if ($this->itineraryModel->delete($id)) $count++;
                    break;
            }
        }

        $message = "Successfully applied '{$action}' to {$count} itinerary(s)";
        return redirect()->to('/admin/itineraries')->with('success', $message);
    }
}