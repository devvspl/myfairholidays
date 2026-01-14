<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TestimonialModel;
use App\Models\TestimonialCategoryModel;
use App\Models\DestinationModel;

/**
 * Admin Testimonial Controller
 * 
 * Handles testimonial management in admin panel
 * 
 * @package App\Controllers\Admin
 * @author  Senior PHP Architect
 */
class TestimonialController extends BaseController
{
    protected $testimonialModel;
    protected $categoryModel;
    protected $destinationModel;

    public function __construct()
    {
        $this->testimonialModel = new TestimonialModel();
        $this->categoryModel = new TestimonialCategoryModel();
        $this->destinationModel = new DestinationModel();
    }

    /**
     * Display list of testimonials
     */
    public function index()
    {
        $pager = \Config\Services::pager();
        
        $data = [
            'title' => 'Testimonials Management',
            'testimonials' => $this->testimonialModel->getAdminTestimonialsList(10),
            'pager' => $this->testimonialModel->pager,
            'stats' => $this->testimonialModel->getTestimonialStats()
        ];

        return view('admin/testimonials/index', $data);
    }

    /**
     * Show create testimonial form
     */
    public function create()
    {
        $data = [
            'title' => 'Add New Testimonial',
            'categories' => $this->categoryModel->where('status', 'active')->findAll(),
            'destinations' => $this->destinationModel->where('status', 'active')->findAll()
        ];

        return view('admin/testimonials/create', $data);
    }

    /**
     * Store new testimonial
     */
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'customer_name' => 'required|min_length[3]|max_length[255]',
            'customer_email' => 'required|valid_email',
            'customer_city' => 'permit_empty|max_length[100]',
            'rating' => 'required|integer|greater_than[0]|less_than[6]',
            'testimonial_text' => 'required|min_length[10]',
            'category_id' => 'permit_empty|integer',
            'destination_id' => 'permit_empty|integer',
            'package_name' => 'permit_empty|max_length[255]',
            'travel_date' => 'permit_empty|valid_date',
            'status' => 'required|in_list[pending,approved,rejected]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'customer_name' => $this->request->getPost('customer_name'),
            'customer_email' => $this->request->getPost('customer_email'),
            'customer_city' => $this->request->getPost('customer_city'),
            'rating' => $this->request->getPost('rating'),
            'testimonial_text' => $this->request->getPost('testimonial_text'),
            'category_id' => $this->request->getPost('category_id') ?: null,
            'destination_id' => $this->request->getPost('destination_id') ?: null,
            'package_name' => $this->request->getPost('package_name'),
            'travel_date' => $this->request->getPost('travel_date') ?: null,
            'status' => $this->request->getPost('status'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'sort_order' => 0
        ];

        // Handle customer image upload
        $image = $this->request->getFile('customer_image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $uploadPath = FCPATH . 'uploads/testimonials/';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            if ($image->move($uploadPath, $newName)) {
                $data['customer_image'] = 'uploads/testimonials/' . $newName;
            }
        }

        if ($this->testimonialModel->insert($data)) {
            return redirect()->to('/admin/testimonials')->with('success', 'Testimonial created successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create testimonial');
    }

    /**
     * Show edit testimonial form
     */
    public function edit($id)
    {
        $testimonial = $this->testimonialModel->find($id);
        
        if (!$testimonial) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Testimonial not found');
        }

        $data = [
            'title' => 'Edit Testimonial',
            'testimonial' => $testimonial,
            'categories' => $this->categoryModel->where('status', 'active')->findAll(),
            'destinations' => $this->destinationModel->where('status', 'active')->findAll()
        ];

        return view('admin/testimonials/edit', $data);
    }

    /**
     * Update testimonial
     */
    public function update($id)
    {
        $testimonial = $this->testimonialModel->find($id);
        
        if (!$testimonial) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Testimonial not found');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'customer_name' => 'required|min_length[3]|max_length[255]',
            'customer_email' => 'required|valid_email',
            'customer_city' => 'permit_empty|max_length[100]',
            'rating' => 'required|integer|greater_than[0]|less_than[6]',
            'testimonial_text' => 'required|min_length[10]',
            'category_id' => 'permit_empty|integer',
            'destination_id' => 'permit_empty|integer',
            'package_name' => 'permit_empty|max_length[255]',
            'travel_date' => 'permit_empty|valid_date',
            'status' => 'required|in_list[pending,approved,rejected]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'customer_name' => $this->request->getPost('customer_name'),
            'customer_email' => $this->request->getPost('customer_email'),
            'customer_city' => $this->request->getPost('customer_city'),
            'rating' => $this->request->getPost('rating'),
            'testimonial_text' => $this->request->getPost('testimonial_text'),
            'category_id' => $this->request->getPost('category_id') ?: null,
            'destination_id' => $this->request->getPost('destination_id') ?: null,
            'package_name' => $this->request->getPost('package_name'),
            'travel_date' => $this->request->getPost('travel_date') ?: null,
            'status' => $this->request->getPost('status'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
        ];

        // Handle customer image upload
        $image = $this->request->getFile('customer_image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Delete old image if exists
            if ($testimonial['customer_image'] && file_exists(FCPATH . $testimonial['customer_image'])) {
                unlink(FCPATH . $testimonial['customer_image']);
            }
            
            $newName = $image->getRandomName();
            $uploadPath = FCPATH . 'uploads/testimonials/';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            if ($image->move($uploadPath, $newName)) {
                $data['customer_image'] = 'uploads/testimonials/' . $newName;
            }
        }

        // Handle image removal
        if ($this->request->getPost('remove_image')) {
            if ($testimonial['customer_image'] && file_exists(FCPATH . $testimonial['customer_image'])) {
                unlink(FCPATH . $testimonial['customer_image']);
            }
            $data['customer_image'] = null;
        }

        if ($this->testimonialModel->update($id, $data)) {
            return redirect()->to('/admin/testimonials')->with('success', 'Testimonial updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update testimonial');
    }

    /**
     * Delete testimonial
     */
    public function delete($id)
    {
        $testimonial = $this->testimonialModel->find($id);
        
        if (!$testimonial) {
            return redirect()->to('/admin/testimonials')->with('error', 'Testimonial not found');
        }

        // Delete associated image
        if ($testimonial['customer_image'] && file_exists(FCPATH . $testimonial['customer_image'])) {
            unlink(FCPATH . $testimonial['customer_image']);
        }

        if ($this->testimonialModel->delete($id)) {
            return redirect()->to('/admin/testimonials')->with('success', 'Testimonial deleted successfully');
        }

        return redirect()->to('/admin/testimonials')->with('error', 'Failed to delete testimonial');
    }

    /**
     * Approve testimonial
     */
    public function approve($id)
    {
        $testimonial = $this->testimonialModel->find($id);
        
        if (!$testimonial) {
            return $this->response->setJSON(['success' => false, 'message' => 'Testimonial not found']);
        }

        if ($this->testimonialModel->update($id, ['status' => 'approved'])) {
            return $this->response->setJSON(['success' => true, 'message' => 'Testimonial approved successfully']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to approve testimonial']);
    }

    /**
     * Reject testimonial
     */
    public function reject($id)
    {
        $testimonial = $this->testimonialModel->find($id);
        
        if (!$testimonial) {
            return $this->response->setJSON(['success' => false, 'message' => 'Testimonial not found']);
        }

        if ($this->testimonialModel->update($id, ['status' => 'rejected'])) {
            return $this->response->setJSON(['success' => true, 'message' => 'Testimonial rejected successfully']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to reject testimonial']);
    }

    /**
     * Handle bulk actions
     */
    public function bulkAction()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/testimonials');
        }

        $action = $this->request->getPost('action');
        $testimonialIds = $this->request->getPost('testimonial_ids');

        // Debug logging
        log_message('info', 'Bulk action request - Action: ' . $action . ', IDs: ' . json_encode($testimonialIds));

        if (empty($action) || empty($testimonialIds) || !is_array($testimonialIds)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request data. Action: ' . $action . ', IDs: ' . json_encode($testimonialIds)
            ]);
        }

        $successCount = 0;
        $totalCount = count($testimonialIds);
        $errors = [];

        foreach ($testimonialIds as $id) {
            $testimonial = $this->testimonialModel->find($id);
            if (!$testimonial) {
                $errors[] = "Testimonial ID {$id} not found";
                continue;
            }

            try {
                switch ($action) {
                    case 'approve':
                        if ($this->testimonialModel->update($id, ['status' => 'approved'])) {
                            $successCount++;
                        } else {
                            $errors[] = "Failed to approve testimonial ID {$id}";
                        }
                        break;

                    case 'reject':
                        if ($this->testimonialModel->update($id, ['status' => 'rejected'])) {
                            $successCount++;
                        } else {
                            $errors[] = "Failed to reject testimonial ID {$id}";
                        }
                        break;

                    case 'feature':
                        if ($this->testimonialModel->update($id, ['is_featured' => 1])) {
                            $successCount++;
                        } else {
                            $errors[] = "Failed to feature testimonial ID {$id}";
                        }
                        break;

                    case 'unfeature':
                        if ($this->testimonialModel->update($id, ['is_featured' => 0])) {
                            $successCount++;
                        } else {
                            $errors[] = "Failed to unfeature testimonial ID {$id}";
                        }
                        break;

                    case 'delete':
                        // Delete associated image
                        if ($testimonial['customer_image'] && file_exists(FCPATH . $testimonial['customer_image'])) {
                            unlink(FCPATH . $testimonial['customer_image']);
                        }
                        
                        if ($this->testimonialModel->delete($id)) {
                            $successCount++;
                        } else {
                            $errors[] = "Failed to delete testimonial ID {$id}";
                        }
                        break;

                    default:
                        return $this->response->setJSON([
                            'success' => false,
                            'message' => 'Invalid action: ' . $action
                        ]);
                }
            } catch (\Exception $e) {
                $errors[] = "Error processing testimonial ID {$id}: " . $e->getMessage();
                log_message('error', 'Bulk action error for ID ' . $id . ': ' . $e->getMessage());
            }
        }

        $message = "Successfully processed {$successCount} out of {$totalCount} testimonial(s)";
        if (!empty($errors)) {
            $message .= ". Errors: " . implode(', ', $errors);
        }

        return $this->response->setJSON([
            'success' => $successCount > 0,
            'message' => $message,
            'processed' => $successCount,
            'total' => $totalCount,
            'errors' => $errors
        ]);
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured($id)
    {
        $testimonial = $this->testimonialModel->find($id);
        
        if (!$testimonial) {
            return $this->response->setJSON(['success' => false, 'message' => 'Testimonial not found']);
        }

        $newFeatured = $testimonial['is_featured'] ? 0 : 1;
        
        if ($this->testimonialModel->update($id, ['is_featured' => $newFeatured])) {
            return $this->response->setJSON(['success' => true, 'featured' => $newFeatured]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update featured status']);
    }
}