<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MetaTagModel;

/**
 * Admin Meta Tag Controller
 * 
 * Handles meta tag management in admin panel
 * 
 * @package App\Controllers\Admin
 */
class MetaTagController extends BaseController
{
    protected $metaTagModel;

    public function __construct()
    {
        $this->metaTagModel = new MetaTagModel();
    }

    /**
     * Display list of meta tags
     */
    public function index()
    {
        $data = [
            'title' => 'Meta Tags Management',
            'metaTags' => $this->metaTagModel->findAll()
        ];

        return view('admin/meta_tags/index', $data);
    }

    /**
     * Show create meta tag form
     */
    public function create()
    {
        $data = [
            'title' => 'Add New Meta Tag'
        ];

        return view('admin/meta_tags/create', $data);
    }

    /**
     * Store new meta tag
     */
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'page_url' => 'required|min_length[1]|max_length[255]',
            'meta_title' => 'required|min_length[10]|max_length[255]',
            'meta_description' => 'required|min_length[50]|max_length[500]',
            'meta_keywords' => 'permit_empty|max_length[255]',
            'status' => 'required|in_list[active,inactive]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'page_url' => $this->request->getPost('page_url'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'og_title' => $this->request->getPost('og_title'),
            'og_description' => $this->request->getPost('og_description'),
            'og_image' => $this->request->getPost('og_image'),
            'twitter_title' => $this->request->getPost('twitter_title'),
            'twitter_description' => $this->request->getPost('twitter_description'),
            'twitter_image' => $this->request->getPost('twitter_image'),
            'canonical_url' => $this->request->getPost('canonical_url'),
            'robots' => $this->request->getPost('robots'),
            'status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->metaTagModel->insert($data)) {
            return redirect()->to('/admin/meta-tags')->with('success', 'Meta tag created successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create meta tag');
    }

    /**
     * Show edit meta tag form
     */
    public function edit($id)
    {
        $metaTag = $this->metaTagModel->find($id);
        
        if (!$metaTag) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Meta tag not found');
        }

        $data = [
            'title' => 'Edit Meta Tag',
            'metaTag' => $metaTag
        ];

        return view('admin/meta_tags/edit', $data);
    }

    /**
     * Update meta tag
     */
    public function update($id)
    {
        $metaTag = $this->metaTagModel->find($id);
        
        if (!$metaTag) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Meta tag not found');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'page_url' => 'required|min_length[1]|max_length[255]',
            'meta_title' => 'required|min_length[10]|max_length[255]',
            'meta_description' => 'required|min_length[50]|max_length[500]',
            'meta_keywords' => 'permit_empty|max_length[255]',
            'status' => 'required|in_list[active,inactive]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'page_url' => $this->request->getPost('page_url'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'og_title' => $this->request->getPost('og_title'),
            'og_description' => $this->request->getPost('og_description'),
            'og_image' => $this->request->getPost('og_image'),
            'twitter_title' => $this->request->getPost('twitter_title'),
            'twitter_description' => $this->request->getPost('twitter_description'),
            'twitter_image' => $this->request->getPost('twitter_image'),
            'canonical_url' => $this->request->getPost('canonical_url'),
            'robots' => $this->request->getPost('robots'),
            'status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->metaTagModel->update($id, $data)) {
            return redirect()->to('/admin/meta-tags')->with('success', 'Meta tag updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update meta tag');
    }

    /**
     * Delete meta tag
     */
    public function delete($id)
    {
        $metaTag = $this->metaTagModel->find($id);
        
        if (!$metaTag) {
            return redirect()->to('/admin/meta-tags')->with('error', 'Meta tag not found');
        }

        if ($this->metaTagModel->delete($id)) {
            return redirect()->to('/admin/meta-tags')->with('success', 'Meta tag deleted successfully');
        }

        return redirect()->to('/admin/meta-tags')->with('error', 'Failed to delete meta tag');
    }

    /**
     * Toggle meta tag status
     */
    public function toggleStatus($id)
    {
        $metaTag = $this->metaTagModel->find($id);
        
        if (!$metaTag) {
            return $this->response->setJSON(['success' => false, 'message' => 'Meta tag not found']);
        }

        $newStatus = $metaTag['status'] === 'active' ? 'inactive' : 'active';
        
        if ($this->metaTagModel->update($id, ['status' => $newStatus])) {
            return $this->response->setJSON(['success' => true, 'status' => $newStatus]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
    }

    /**
     * Bulk import meta tags from CSV
     */
    public function bulkImport()
    {
        if ($this->request->getMethod() === 'POST') {
            $file = $this->request->getFile('csv_file');
            
            if (!$file->isValid()) {
                return redirect()->back()->with('error', 'Please select a valid CSV file');
            }

            $csvData = array_map('str_getcsv', file($file->getTempName()));
            $header = array_shift($csvData);
            
            $imported = 0;
            $errors = [];

            foreach ($csvData as $row) {
                $data = array_combine($header, $row);
                
                // Validate required fields
                if (empty($data['page_url']) || empty($data['meta_title']) || empty($data['meta_description'])) {
                    $errors[] = "Row skipped: Missing required fields";
                    continue;
                }

                $insertData = [
                    'page_url' => $data['page_url'],
                    'meta_title' => $data['meta_title'],
                    'meta_description' => $data['meta_description'],
                    'meta_keywords' => $data['meta_keywords'] ?? '',
                    'status' => $data['status'] ?? 'active',
                    'created_at' => date('Y-m-d H:i:s')
                ];

                if ($this->metaTagModel->insert($insertData)) {
                    $imported++;
                } else {
                    $errors[] = "Failed to import: " . $data['page_url'];
                }
            }

            $message = "Imported {$imported} meta tags successfully";
            if (!empty($errors)) {
                $message .= ". Errors: " . implode(', ', $errors);
            }

            return redirect()->to('/admin/meta-tags')->with('success', $message);
        }

        $data = [
            'title' => 'Bulk Import Meta Tags'
        ];

        return view('admin/meta_tags/bulk_import', $data);
    }

    /**
     * Export meta tags to CSV
     */
    public function export()
    {
        $metaTags = $this->metaTagModel->findAll();
        
        $filename = 'meta_tags_' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, [
            'page_url', 'meta_title', 'meta_description', 'meta_keywords',
            'og_title', 'og_description', 'twitter_title', 'twitter_description',
            'canonical_url', 'robots', 'status', 'created_at'
        ]);
        
        foreach ($metaTags as $tag) {
            fputcsv($output, [
                $tag['page_url'],
                $tag['meta_title'],
                $tag['meta_description'],
                $tag['meta_keywords'],
                $tag['og_title'],
                $tag['og_description'],
                $tag['twitter_title'],
                $tag['twitter_description'],
                $tag['canonical_url'],
                $tag['robots'],
                $tag['status'],
                $tag['created_at']
            ]);
        }
        
        fclose($output);
        exit;
    }
}