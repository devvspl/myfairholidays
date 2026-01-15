<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TermsOfServiceModel;

class TermsOfServiceController extends BaseController
{
    protected $termsModel;

    public function __construct()
    {
        $this->termsModel = new TermsOfServiceModel();
    }

    /**
     * Display and edit Terms of Service
     */
    public function index()
    {
        $terms = $this->termsModel->getTerms();

        $data = [
            'title' => 'Terms of Service Management',
            'terms' => $terms
        ];

        return view('admin/legal/terms_of_service', $data);
    }

    /**
     * Update Terms of Service
     */
    public function update()
    {
        $validation = \Config\Services::validation();
        $validation->setRules($this->termsModel->getFormValidationRules());

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'banner_image' => $this->request->getPost('banner_image'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'status' => $this->request->getPost('status') ?: 'active'
        ];

        // Handle banner image file upload
        $bannerFile = $this->request->getFile('banner_image_file');
        if ($bannerFile && $bannerFile->isValid() && !$bannerFile->hasMoved()) {
            $uploadPath = $this->handleImageUpload($bannerFile);
            if ($uploadPath) {
                $data['banner_image'] = $uploadPath;
            }
        }

        if ($this->termsModel->updateTerms($data)) {
            return redirect()->to('/admin/terms-of-service')->with('success', 'Terms of Service updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update Terms of Service');
        }
    }

    /**
     * Toggle status
     */
    public function toggleStatus()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/terms-of-service');
        }

        if ($this->termsModel->toggleStatus()) {
            $terms = $this->termsModel->getTerms();
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status updated successfully',
                'new_status' => $terms['status']
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update status'
            ]);
        }
    }

    /**
     * Preview Terms of Service
     */
    public function preview()
    {
        $terms = $this->termsModel->getTerms();

        if (!$terms) {
            return redirect()->to('/admin/terms-of-service')->with('error', 'No Terms of Service found');
        }

        $data = [
            'title' => 'Preview: ' . $terms['title'],
            'page' => $terms
        ];

        return view('public/terms_of_service', $data);
    }

    /**
     * Handle image upload
     */
    private function handleImageUpload($file)
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
            $uploadPath = FCPATH . 'uploads/legal/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate unique filename
            $extension = $file->getClientExtension();
            $filename = 'banner_' . time() . '_' . uniqid() . '.' . $extension;

            // Move file
            if ($file->move($uploadPath, $filename)) {
                return 'uploads/legal/' . $filename;
            }

            return false;
        } catch (\Exception $e) {
            log_message('error', 'Image upload error: ' . $e->getMessage());
            return false;
        }
    }
}
