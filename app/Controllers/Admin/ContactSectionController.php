<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContactSectionModel;

class ContactSectionController extends BaseController
{
    protected $contactSectionModel;

    public function __construct()
    {
        $this->contactSectionModel = new ContactSectionModel();
    }

    /**
     * Display contact sections
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
        $sections = $this->contactSectionModel->getSectionsWithFilters($filters, $perPage);

        $data = [
            'title' => 'Contact Page Sections',
            'sections' => $sections,
            'filters' => $filters,
            'pager' => $this->contactSectionModel->pager
        ];

        return view('admin/contact_sections/index', $data);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $data = [
            'title' => 'Create Contact Section',
            'section' => null
        ];

        return view('admin/contact_sections/form', $data);
    }

    /**
     * Store new section
     */
    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules($this->contactSectionModel->getValidationRules());

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'section_type' => $this->request->getPost('section_type'),
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'content' => $this->request->getPost('content'),
            'icon' => $this->request->getPost('icon'),
            'contact_type' => $this->request->getPost('contact_type'),
            'contact_value' => $this->request->getPost('contact_value'),
            'contact_link' => $this->request->getPost('contact_link'),
            'background_image' => $this->request->getPost('background_image'),
            'map_embed_code' => $this->request->getPost('map_embed_code'),
            'sort_order' => $this->request->getPost('sort_order') ?: $this->contactSectionModel->getNextSortOrder($this->request->getPost('section_type')),
            'status' => $this->request->getPost('status') ?: 'active'
        ];

        // Handle background image file upload
        $backgroundImageFile = $this->request->getFile('background_image_file');
        if ($backgroundImageFile && $backgroundImageFile->isValid() && !$backgroundImageFile->hasMoved()) {
            $uploadPath = $this->handleImageUpload($backgroundImageFile, 'backgrounds');
            if ($uploadPath) {
                $data['background_image'] = $uploadPath;
            }
        }

        if ($this->contactSectionModel->insert($data)) {
            return redirect()->to('/admin/contact-sections')->with('success', 'Contact section created successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create contact section');
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $section = $this->contactSectionModel->find($id);
        
        if (!$section) {
            return redirect()->to('/admin/contact-sections')->with('error', 'Contact section not found');
        }

        $data = [
            'title' => 'Edit Contact Section',
            'section' => $section
        ];

        return view('admin/contact_sections/form', $data);
    }

    /**
     * Update section
     */
    public function update($id)
    {
        $section = $this->contactSectionModel->find($id);
        
        if (!$section) {
            return redirect()->to('/admin/contact-sections')->with('error', 'Contact section not found');
        }

        $validation = \Config\Services::validation();
        $validation->setRules($this->contactSectionModel->getValidationRules());

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'section_type' => $this->request->getPost('section_type'),
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'content' => $this->request->getPost('content'),
            'icon' => $this->request->getPost('icon'),
            'contact_type' => $this->request->getPost('contact_type'),
            'contact_value' => $this->request->getPost('contact_value'),
            'contact_link' => $this->request->getPost('contact_link'),
            'background_image' => $this->request->getPost('background_image'),
            'map_embed_code' => $this->request->getPost('map_embed_code'),
            'sort_order' => $this->request->getPost('sort_order'),
            'status' => $this->request->getPost('status')
        ];

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

        if ($this->contactSectionModel->update($id, $data)) {
            return redirect()->to('/admin/contact-sections')->with('success', 'Contact section updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update contact section');
        }
    }

    /**
     * Delete section
     */
    public function delete($id)
    {
        $section = $this->contactSectionModel->find($id);
        
        if (!$section) {
            return redirect()->to('/admin/contact-sections')->with('error', 'Contact section not found');
        }

        // Delete associated image if exists
        if (!empty($section['background_image']) && file_exists(FCPATH . $section['background_image'])) {
            unlink(FCPATH . $section['background_image']);
        }

        if ($this->contactSectionModel->delete($id)) {
            return redirect()->to('/admin/contact-sections')->with('success', 'Contact section deleted successfully');
        } else {
            return redirect()->to('/admin/contact-sections')->with('error', 'Failed to delete contact section');
        }
    }

    /**
     * Toggle status
     */
    public function toggleStatus($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/contact-sections');
        }

        $section = $this->contactSectionModel->find($id);
        if (!$section) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Contact section not found'
            ]);
        }

        if ($this->contactSectionModel->toggleStatus($id)) {
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
            return redirect()->to('/admin/contact-sections');
        }

        $items = $this->request->getPost('items');
        
        if (empty($items) || !is_array($items)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid data'
            ]);
        }

        if ($this->contactSectionModel->updateSortOrder($items)) {
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
    private function handleImageUpload($file, $subfolder = 'contact')
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
            $uploadPath = FCPATH . 'uploads/contact/' . $subfolder;
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate unique filename
            $extension = $file->getClientExtension();
            $filename = 'contact_' . time() . '_' . uniqid() . '.' . $extension;

            // Move file
            if ($file->move($uploadPath, $filename)) {
                return 'uploads/contact/' . $subfolder . '/' . $filename;
            }

            return false;
        } catch (\Exception $e) {
            log_message('error', 'Image upload error: ' . $e->getMessage());
            return false;
        }
    }
}