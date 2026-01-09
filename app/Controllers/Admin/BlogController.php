<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PageModel;
use App\Models\UserModel;

/**
 * Admin Blog Posts Controller
 * 
 * Handles blog post management in admin panel
 * 
 * @package App\Controllers\Admin
 */
class BlogController extends BaseController
{
    protected $pageModel;
    protected $userModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
        $this->userModel = new UserModel();
    }

    /**
     * Display list of blog posts
     */
    public function index()
    {
        $pager = \Config\Services::pager();
        
        $data = [
            'title' => 'Blog Posts Management',
            'posts' => $this->pageModel->getAdminPagesList(10),
            'pager' => $this->pageModel->pager,
            'stats' => $this->pageModel->getPageStats()
        ];

        return view('admin/blog/index', $data);
    }

    /**
     * Show create blog post form
     */
    public function create()
    {
        $data = [
            'title' => 'Create New Blog Post',
            'authors' => $this->userModel->findAll()
        ];

        return view('admin/blog/create', $data);
    }

    /**
     * Store new blog post
     */
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'title' => 'required|min_length[3]|max_length[255]',
            'slug' => 'permit_empty|min_length[3]|max_length[255]|is_unique[pages.slug]',
            'content' => 'required|min_length[10]',
            'status' => 'required|in_list[draft,published]',
            'excerpt' => 'permit_empty|max_length[500]',
            'featured_image' => 'permit_empty|is_image[featured_image]|max_size[featured_image,2048]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle file upload for featured image
        $featuredImage = null;
        $file = $this->request->getFile('featured_image');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Create directory if it doesn't exist
            $uploadPath = FCPATH . 'uploads/blog';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $newName = $file->getRandomName();
            
            if ($file->move($uploadPath, $newName)) {
                $featuredImage = 'uploads/blog/' . $newName;
            } else {
                log_message('error', 'Failed to move uploaded file: ' . $file->getErrorString());
            }
        } elseif ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            // Log upload error for debugging
            log_message('error', 'File upload error: ' . $file->getErrorString());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug') ?: url_title($this->request->getPost('title'), '-', true),
            'content' => $this->request->getPost('content'),
            'excerpt' => $this->request->getPost('excerpt'),
            'featured_image' => $featuredImage,
            'template' => 'default',
            'status' => $this->request->getPost('status'),
            'is_homepage' => 0,
            'show_in_menu' => 0,
            'menu_order' => 0,
            'meta_title' => null,
            'meta_description' => null,
            'meta_keywords' => null,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'author_id' => session()->get('user_id') ?? 1
        ];

        if ($this->pageModel->skipValidation(true)->insert($data)) {
            $this->pageModel->skipValidation(false);
            return redirect()->to('/admin/blogs')->with('success', 'Blog post created successfully');
        }

        $this->pageModel->skipValidation(false);
        return redirect()->back()->withInput()->with('error', 'Failed to create blog post');
    }

    /**
     * Show blog post details
     */
    public function show($id)
    {
        $post = $this->pageModel->select('pages.*, users.name as author_name')
                                ->join('users', 'users.id = pages.author_id')
                                ->find($id);
        
        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Blog post not found');
        }

        $data = [
            'title' => 'Blog Post Details',
            'post' => $post
        ];

        return view('admin/blog/show', $data);
    }

    /**
     * Show edit blog post form
     */
    public function edit($id)
    {
        $post = $this->pageModel->find($id);
        
        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Blog post not found');
        }
        $data = [
            'title' => 'Edit Blog Post',
            'post' => $post,
            'authors' => $this->userModel->findAll()
        ];

        return view('admin/blog/edit', $data);
    }

    /**
     * Update blog post
     */
    public function update($id)
    {
        $post = $this->pageModel->find($id);
        
        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Blog post not found');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'title' => 'required|min_length[3]|max_length[255]',
            'slug' => "permit_empty|min_length[3]|max_length[255]|is_unique[pages.slug,id,{$id}]",
            'content' => 'required|min_length[10]',
            'status' => 'required|in_list[draft,published]',
            'excerpt' => 'permit_empty|max_length[500]',
            'featured_image' => 'permit_empty|is_image[featured_image]|max_size[featured_image,2048]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle file upload for featured image
        $featuredImage = $post['featured_image']; // Keep existing image by default
        $file = $this->request->getFile('featured_image');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Create directory if it doesn't exist
            $uploadPath = FCPATH . 'uploads/blog';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Delete old image if exists
            if ($featuredImage && file_exists(FCPATH . $featuredImage)) {
                unlink(FCPATH . $featuredImage);
            }
            
            $newName = $file->getRandomName();
            
            if ($file->move($uploadPath, $newName)) {
                $featuredImage = 'uploads/blog/' . $newName;
            } else {
                // If file move failed, keep the existing image
                log_message('error', 'Failed to move uploaded file: ' . $file->getErrorString());
            }
        } elseif ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            // Log upload error for debugging
            log_message('error', 'File upload error: ' . $file->getErrorString());
        }
        
        // Handle image removal if requested
        if ($this->request->getPost('remove_featured_image') === '1') {
            // Delete existing image file
            if ($featuredImage && file_exists(FCPATH . $featuredImage)) {
                unlink(FCPATH . $featuredImage);
            }
            $featuredImage = null;
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug') ?: url_title($this->request->getPost('title'), '-', true),
            'content' => $this->request->getPost('content'),
            'excerpt' => $this->request->getPost('excerpt'),
            'featured_image' => $featuredImage,
            'status' => $this->request->getPost('status'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'author_id' => $post['author_id'] // Keep existing author
        ];

        try {
            // Temporarily disable model validation since we handled it in controller
            $this->pageModel->skipValidation(true);
            $result = $this->pageModel->update($id, $data);
            $this->pageModel->skipValidation(false);
            
            if ($result) {
                return redirect()->to('/admin/blogs')->with('success', 'Blog post updated successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update blog post');
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception during blog post update ID: ' . $id . '. Exception: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update blog post: ' . $e->getMessage());
        }
    }

    /**
     * Delete blog post (soft delete)
     */
    public function delete($id)
    {
        $post = $this->pageModel->find($id);
        
        if (!$post) {
            return redirect()->to('/admin/blogs')->with('error', 'Blog post not found');
        }

        if ($this->pageModel->delete($id)) {
            return redirect()->to('/admin/blogs')->with('success', 'Blog post moved to trash');
        }

        return redirect()->to('/admin/blogs')->with('error', 'Failed to delete blog post');
    }

    /**
     * Toggle blog post status
     */
    public function toggleStatus($id)
    {
        $post = $this->pageModel->find($id);
        
        if (!$post) {
            return $this->response->setJSON(['success' => false, 'message' => 'Blog post not found']);
        }

        $newStatus = $post['status'] === 'published' ? 'draft' : 'published';
        
        if ($this->pageModel->update($id, ['status' => $newStatus])) {
            return $this->response->setJSON(['success' => true, 'status' => $newStatus]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
    }

    /**
     * Toggle blog post featured status
     */
    public function toggleFeatured($id)
    {
        $post = $this->pageModel->find($id);
        
        if (!$post) {
            return $this->response->setJSON(['success' => false, 'message' => 'Blog post not found']);
        }

        $newFeatured = $post['is_featured'] ? 0 : 1;
        
        if ($this->pageModel->update($id, ['is_featured' => $newFeatured])) {
            return $this->response->setJSON(['success' => true, 'is_featured' => $newFeatured]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update featured status']);
    }

    /**
     * Show trashed blog posts
     */
    public function trash()
    {
        $data = [
            'title' => 'Trashed Blog Posts',
            'posts' => $this->pageModel->getTrashedPages()
        ];

        return view('admin/blog/trash', $data);
    }

    /**
     * Restore blog post from trash
     */
    public function restore($id)
    {
        if ($this->pageModel->restorePage($id)) {
            return redirect()->to('/admin/blogs/trash')->with('success', 'Blog post restored successfully');
        }

        return redirect()->to('/admin/blogs/trash')->with('error', 'Failed to restore blog post');
    }

    /**
     * Permanently delete blog post
     */
    public function forceDelete($id)
    {
        $post = $this->pageModel->onlyDeleted()->find($id);
        
        if (!$post) {
            return redirect()->to('/admin/blogs/trash')->with('error', 'Blog post not found');
        }

        // Delete featured image if exists
        if ($post['featured_image'] && file_exists(FCPATH . $post['featured_image'])) {
            unlink(FCPATH . $post['featured_image']);
        }

        if ($this->pageModel->delete($id, true)) {
            return redirect()->to('/admin/blogs/trash')->with('success', 'Blog post permanently deleted');
        }

        return redirect()->to('/admin/blogs/trash')->with('error', 'Failed to delete blog post');
    }

    /**
     * Bulk actions
     */
    public function bulkAction()
    {
        $action = $this->request->getPost('bulk_action');
        $postIds = $this->request->getPost('post_ids');

        if (empty($action) || empty($postIds)) {
            return redirect()->back()->with('error', 'Please select posts and action');
        }

        $count = 0;
        foreach ($postIds as $postId) {
            switch ($action) {
                case 'publish':
                    if ($this->pageModel->update($postId, ['status' => 'published'])) {
                        $count++;
                    }
                    break;
                case 'draft':
                    if ($this->pageModel->update($postId, ['status' => 'draft'])) {
                        $count++;
                    }
                    break;
                case 'feature':
                    if ($this->pageModel->update($postId, ['is_featured' => 1])) {
                        $count++;
                    }
                    break;
                case 'unfeature':
                    if ($this->pageModel->update($postId, ['is_featured' => 0])) {
                        $count++;
                    }
                    break;
                case 'delete':
                    if ($this->pageModel->delete($postId)) {
                        $count++;
                    }
                    break;
            }
        }

        $message = $count > 0 ? "{$count} blog posts updated successfully" : "No blog posts were updated";
        return redirect()->back()->with('success', $message);
    }
}