<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ItineraryCategoryModel;

/**
 * Admin Itinerary Category Controller
 * 
 * Handles itinerary category management in admin panel
 * 
 * @package App\Controllers\Admin
 */
class ItineraryCategoryController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new ItineraryCategoryModel();
    }

    /**
     * Display list of categories
     */
    public function index()
    {
        $stats = $this->categoryModel->getCategoryStats();
        
        // Get most popular category
        $popularCategories = $this->categoryModel->getPopularCategories(1);
        $stats['most_popular'] = !empty($popularCategories) ? $popularCategories[0]['name'] : 'N/A';

        $data = [
            'title' => 'Itinerary Categories Management',
            'categories' => $this->categoryModel->getAdminCategoriesList(),
            'stats' => $stats,
            'pager' => $this->categoryModel->pager
        ];

        return view('admin/itinerary_categories/index', $data);
    }

    /**
     * Show create category form
     */
    public function create()
    {
        $data = [
            'title' => 'Add New Itinerary Category'
        ];

        return view('admin/itinerary_categories/create', $data);
    }

    /**
     * Store new category
     */
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[255]',
            'description' => 'permit_empty|min_length[10]',
            'status' => 'required|in_list[active,inactive]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->categoryModel->insert($data)) {
            return redirect()->to('/admin/itinerary-categories')->with('success', 'Category created successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create category');
    }

    /**
     * Show edit category form
     */
    public function edit($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Category not found');
        }

        $data = [
            'title' => 'Edit Itinerary Category',
            'category' => $category
        ];

        return view('admin/itinerary_categories/edit', $data);
    }

    /**
     * Update category
     */
    public function update($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Category not found');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[255]',
            'description' => 'permit_empty|min_length[10]',
            'status' => 'required|in_list[active,inactive]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->categoryModel->update($id, $data)) {
            return redirect()->to('/admin/itinerary-categories')->with('success', 'Category updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update category');
    }

    /**
     * Delete category
     */
    public function delete($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to('/admin/itinerary-categories')->with('error', 'Category not found');
        }

        // Check if category has itineraries
        $itineraryModel = new \App\Models\ItineraryModel();
        $hasItineraries = $itineraryModel->where('category_id', $id)->countAllResults() > 0;
        
        if ($hasItineraries) {
            return redirect()->to('/admin/itinerary-categories')->with('error', 'Cannot delete category with existing itineraries');
        }

        if ($this->categoryModel->delete($id)) {
            return redirect()->to('/admin/itinerary-categories')->with('success', 'Category deleted successfully');
        }

        return redirect()->to('/admin/itinerary-categories')->with('error', 'Failed to delete category');
    }

    /**
     * Toggle category status
     */
    public function toggleStatus($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return $this->response->setJSON(['success' => false, 'message' => 'Category not found']);
        }

        $newStatus = $category['status'] === 'active' ? 'inactive' : 'active';
        
        if ($this->categoryModel->update($id, ['status' => $newStatus])) {
            return $this->response->setJSON(['success' => true, 'status' => $newStatus]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
    }

    /**
     * Handle bulk actions
     */
    public function bulkAction()
    {
        $action = $this->request->getPost('bulk_action');
        $categoryIds = $this->request->getPost('category_ids');

        if (empty($action) || empty($categoryIds)) {
            return redirect()->back()->with('error', 'Please select categories and an action');
        }

        $count = 0;
        foreach ($categoryIds as $id) {
            switch ($action) {
                case 'activate':
                    if ($this->categoryModel->update($id, ['status' => 'active'])) $count++;
                    break;
                case 'deactivate':
                    if ($this->categoryModel->update($id, ['status' => 'inactive'])) $count++;
                    break;
                case 'delete':
                    // Check if category has itineraries before deleting
                    if (!$this->categoryModel->hasItineraries($id)) {
                        if ($this->categoryModel->delete($id)) $count++;
                    }
                    break;
            }
        }

        $message = "Successfully applied '{$action}' to {$count} category(s)";
        return redirect()->to('/admin/itinerary-categories')->with('success', $message);
    }
}