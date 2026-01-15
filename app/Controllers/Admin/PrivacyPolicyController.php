<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PrivacyPolicyModel;

class PrivacyPolicyController extends BaseController
{
    protected $policyModel;

    public function __construct()
    {
        $this->policyModel = new PrivacyPolicyModel();
    }

    /**
     * Display and edit Privacy Policy
     */
    public function index()
    {
        $policy = $this->policyModel->getPolicy();

        $data = [
            'title' => 'Privacy Policy Management',
            'policy' => $policy
        ];

        return view('admin/legal/privacy_policy', $data);
    }

    /**
     * Update Privacy Policy
     */
    public function update()
    {
        $validation = \Config\Services::validation();
        $validation->setRules($this->policyModel->getFormValidationRules());

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

        if ($this->policyModel->updatePolicy($data)) {
            return redirect()->to('/admin/privacy-policy')->with('success', 'Privacy Policy updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update Privacy Policy');
        }
    }

    /**
     * Toggle status
     */
    public function toggleStatus()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/privacy-policy');
        }

        if ($this->policyModel->toggleStatus()) {
            $policy = $this->policyModel->getPolicy();
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status updated successfully',
                'new_status' => $policy['status']
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update status'
            ]);
        }
    }

    /**
     * Preview Privacy Policy
     */
    public function preview()
    {
        $policy = $this->policyModel->getPolicy();

        if (!$policy) {
            return redirect()->to('/admin/privacy-policy')->with('error', 'No Privacy Policy found');
        }

        $data = [
            'title' => 'Preview: ' . $policy['title'],
            'page' => $policy
        ];

        return view('public/privacy_policy', $data);
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
