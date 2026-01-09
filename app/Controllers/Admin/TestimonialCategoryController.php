<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TestimonialCategoryModel;

/**
 * Admin Testimonial Category Controller
 * 
 * Handles testimonial category management in admin panel
 * 
 * @package App\Controllers\Admin
 * @author  Senior PHP Architect
 */
class TestimonialCategoryController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new TestimonialCategoryModel();
    }

    /**
     * Display list of testimonial categories
     */
    public function index()
    {
        $pager = \Config\Services::pager();
        
        $data = [
            'title' => 'Testimonial Categories Management',
            'categories' => $this->categoryModel->getAdminCategoriesList(10),
            'pager' => $this->categoryModel->pager,
            'stats' => $this->categoryModel->getCategoryStats()
        ];

        return view('admin/testimonial_categories/index', $data);
    }

    /**
     * Show create category form
     */
    public function create()
    {
        $data = [
            'title' => 'Add New Testimonial Category'
        ];

        return view('admin/testimonial_categories/create', $data);
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
            'sort_order' => 0
        ];

        if ($this->categoryModel->insert($data)) {
            return redirect()->to('/admin/testimonial-categories')->with('success', 'Testimonial category created successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create testimonial category');
    }

    /**
     * Show edit category form
     */
    public function edit($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Testimonial category not found');
        }

        $data = [
            'title' => 'Edit Testimonial Category',
            'category' => $category
        ];

        return view('admin/testimonial_categories/edit', $data);
    }

    /**
     * Update category
     */
    public function update($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Testimonial category not found');
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
            'status' => $this->request->getPost('status')
        ];

        if ($this->categoryModel->update($id, $data)) {
            return redirect()->to('/admin/testimonial-categories')->with('success', 'Testimonial category updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update testimonial category');
    }

    /**
     * Delete category
     */
    public function delete($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to('/admin/testimonial-categories')->with('error', 'Testimonial category not found');
        }

        // Check if category has testimonials
        $testimonialModel = new \App\Models\TestimonialModel();
        $hasTestimonials = $testimonialModel->where('category_id', $id)->countAllResults() > 0;
        
        if ($hasTestimonials) {
            return redirect()->to('/admin/testimonial-categories')->with('error', 'Cannot delete category with existing testimonials');
        }

        if ($this->categoryModel->delete($id)) {
            return redirect()->to('/admin/testimonial-categories')->with('success', 'Testimonial category deleted successfully');
        }

        return redirect()->to('/admin/testimonial-categories')->with('error', 'Failed to delete testimonial category');
    }

    /**
     * Toggle category status
     */
    public function toggleStatus($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return $this->response->setJSON(['success' => false, 'message' => 'Testimonial category not found']);
        }

        $newStatus = $category['status'] === 'active' ? 'inactive' : 'active';
        
        if ($this->categoryModel->update($id, ['status' => $newStatus])) {
            return $this->response->setJSON(['success' => true, 'status' => $newStatus]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
    }

    /**
     * Bulk actions
     */
    public function bulkAction()
    {
        $action = $this->request->getPost('bulk_action');
        $categoryIds = $this->request->getPost('category_ids');

        if (empty($action) || empty($categoryIds)) {
            return redirect()->back()->with('error', 'Please select categories and action');
        }

        $count = 0;
        foreach ($categoryIds as $categoryId) {
            switch ($action) {
                case 'activate':
                    if ($this->categoryModel->update($categoryId, ['status' => 'active'])) {
                        $count++;
                    }
                    break;
                case 'deactivate':
                    if ($this->categoryModel->update($categoryId, ['status' => 'inactive'])) {
                        $count++;
                    }
                    break;
                case 'delete':
                    // Check if category has testimonials before deleting
                    $testimonialModel = new \App\Models\TestimonialModel();
                    $hasTestimonials = $testimonialModel->where('category_id', $categoryId)->countAllResults() > 0;
                    
                    if (!$hasTestimonials && $this->categoryModel->delete($categoryId)) {
                        $count++;
                    }
                    break;
            }
        }

        $message = $count > 0 ? "{$count} testimonial categories updated successfully" : "No testimonial categories were updated";
        return redirect()->back()->with('success', $message);
    }
}