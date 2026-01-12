<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AboutSectionModel;

class AboutSectionController extends BaseController
{
    protected $aboutSectionModel;

    public function __construct()
    {
        $this->aboutSectionModel = new AboutSectionModel();
    }

    /**
     * Display about sections
     */
    public function index()
    {
        $perPage = 20;
        
        // Get filter parameters
        $filters = [
            'section_type' => $this->request->getVar('section_type'),
            'status' => $this->request->getVar('status'),
            'search' => $this->request->getVar('search')
        ];

        // Get sections with filters
        $sections = $this->aboutSectionModel->getSectionsWithFilters($filters, $perPage);

        $data = [
            'title' => 'About Page Sections',
            'sections' => $sections,
            'filters' => $filters,
            'pager' => $this->aboutSectionModel->pager
        ];

        return view('admin/about_sections/index', $data);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $data = [
            'title' => 'Create About Section',
            'section' => null
        ];

        return view('admin/about_sections/form', $data);
    }

    /**
     * Store new section
     */
    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules($this->aboutSectionModel->getValidationRules());

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'section_type' => $this->request->getPost('section_type'),
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'content' => $this->request->getPost('content'),
            'image_path' => $this->request->getPost('image_path'),
            'background_image' => $this->request->getPost('background_image'),
            'icon' => $this->request->getPost('icon'),
            'stat_value' => $this->request->getPost('stat_value'),
            'stat_label' => $this->request->getPost('stat_label'),
            'sort_order' => $this->request->getPost('sort_order') ?: $this->aboutSectionModel->getNextSortOrder($this->request->getPost('section_type')),
            'status' => $this->request->getPost('status') ?: 'active'
        ];

        // Handle image file upload
        $imageFile = $this->request->getFile('image_file');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $uploadPath = $this->handleImageUpload($imageFile, 'images');
            if ($uploadPath) {
                $data['image_path'] = $uploadPath;
            }
        }

        // Handle background image file upload
        $backgroundImageFile = $this->request->getFile('background_image_file');
        if ($backgroundImageFile && $backgroundImageFile->isValid() && !$backgroundImageFile->hasMoved()) {
            $uploadPath = $this->handleImageUpload($backgroundImageFile, 'backgrounds');
            if ($uploadPath) {
                $data['background_image'] = $uploadPath;
            }
        }

        if ($this->aboutSectionModel->insert($data)) {
            return redirect()->to('/admin/about-sections')->with('success', 'About section created successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create about section');
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $section = $this->aboutSectionModel->find($id);
        
        if (!$section) {
            return redirect()->to('/admin/about-sections')->with('error', 'About section not found');
        }

        $data = [
            'title' => 'Edit About Section',
            'section' => $section
        ];

        return view('admin/about_sections/form', $data);
    }

    /**
     * Update section
     */
    public function update($id)
    {
        $section = $this->aboutSectionModel->find($id);
        
        if (!$section) {
            return redirect()->to('/admin/about-sections')->with('error', 'About section not found');
        }

        $validation = \Config\Services::validation();
        $validation->setRules($this->aboutSectionModel->getValidationRules());

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'section_type' => $this->request->getPost('section_type'),
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'content' => $this->request->getPost('content'),
            'image_path' => $this->request->getPost('image_path'),
            'background_image' => $this->request->getPost('background_image'),
            'icon' => $this->request->getPost('icon'),
            'stat_value' => $this->request->getPost('stat_value'),
            'stat_label' => $this->request->getPost('stat_label'),
            'sort_order' => $this->request->getPost('sort_order'),
            'status' => $this->request->getPost('status')
        ];

        // Handle image file upload
        $imageFile = $this->request->getFile('image_file');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Delete old image if exists
            if (!empty($section['image_path']) && file_exists(FCPATH . $section['image_path'])) {
                unlink(FCPATH . $section['image_path']);
            }
            
            $uploadPath = $this->handleImageUpload($imageFile, 'images');
            if ($uploadPath) {
                $data['image_path'] = $uploadPath;
            }
        }

        // Handle background image file upload
        $backgroundImageFile = $this->request->getFile('background_image_file');
        if ($backgroundImageFile && $backgroundImageFile->isValid() && !$backgroundImageFile->hasMoved()) {
            // Delete old background image if exists
            if (!empty($section['background_image']) && file_exists(FCPATH . $section['background_image'])) {
                unlink(FCPATH . $section['background_image']);
            }
            
            $uploadPath = $this->handleImageUpload($backgroundImageFile, 'backgrounds');
            if ($uploadPath) {
                $data['background_image'] = $uploadPath;
            }
        }

        if ($this->aboutSectionModel->update($id, $data)) {
            return redirect()->to('/admin/about-sections')->with('success', 'About section updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update about section');
        }
    }

    /**
     * Delete section
     */
    public function delete($id)
    {
        $section = $this->aboutSectionModel->find($id);
        
        if (!$section) {
            return redirect()->to('/admin/about-sections')->with('error', 'About section not found');
        }

        if ($this->aboutSectionModel->delete($id)) {
            return redirect()->to('/admin/about-sections')->with('success', 'About section deleted successfully');
        } else {
            return redirect()->to('/admin/about-sections')->with('error', 'Failed to delete about section');
        }
    }

    /**
     * Toggle status
     */
    public function toggleStatus($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/about-sections');
        }

        $section = $this->aboutSectionModel->find($id);
        if (!$section) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'About section not found'
            ]);
        }

        if ($this->aboutSectionModel->toggleStatus($id)) {
            $newStatus = $section['status'] === 'active' ? 'inactive' : 'active';
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status updated successfully',
                'new_status' => $newStatus
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update status'
            ]);
        }
    }

    /**
     * Update sort order
     */
    public function updateSortOrder()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/about-sections');
        }

        $items = $this->request->getPost('items');
        
        if (empty($items) || !is_array($items)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid data'
            ]);
        }

        if ($this->aboutSectionModel->updateSortOrder($items)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Sort order updated successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update sort order'
            ]);
        }
    }

    /**
     * Handle image upload
     */
    private function handleImageUpload($file, $subfolder = 'about')
    {
        try {
            // Validate file
            if (!$file->isValid()) {
                return false;
            }

            // Check file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return false;
            }

            // Check file size (5MB max)
            if ($file->getSize() > 5 * 1024 * 1024) {
                return false;
            }

            // Create upload directory if it doesn't exist
            $uploadPath = FCPATH . 'uploads/about/' . $subfolder;
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate unique filename
            $extension = $file->getClientExtension();
            $filename = 'about_' . time() . '_' . uniqid() . '.' . $extension;

            // Move file
            if ($file->move($uploadPath, $filename)) {
                return 'uploads/about/' . $subfolder . '/' . $filename;
            }

            return false;
        } catch (\Exception $e) {
            log_message('error', 'Image upload error: ' . $e->getMessage());
            return false;
        }
    }
}