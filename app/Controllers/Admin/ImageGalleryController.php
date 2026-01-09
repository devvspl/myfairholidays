<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ImageGalleryModel;

/**
 * Admin Image Gallery Controller
 * 
 * Handles image gallery management in admin panel
 * 
 * @package App\Controllers\Admin
 * @author  Senior PHP Architect
 */
class ImageGalleryController extends BaseController
{
    protected $imageModel;

    public function __construct()
    {
        $this->imageModel = new ImageGalleryModel();
    }

    /**
     * Image gallery listing page
     * 
     * @return string
     */
    public function index(): string
    {
        $data = [
            'title' => 'Manage Image Gallery',
            'images' => $this->imageModel->getAdminImagesList(12),
            'pager' => $this->imageModel->pager,
            'stats' => $this->imageModel->getImageStats()
        ];

        return view('admin/gallery/images/index', $data);
    }

    /**
     * Create image form
     * 
     * @return string
     */
    public function create(): string
    {
        $data = [
            'title' => 'Upload Images',
            'image' => null,
            'validation' => session()->getFlashdata('validation')
        ];

        return view('admin/gallery/images/form', $data);
    }

    /**
     * Store new images
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function store()
    {
        // Validate basic fields first
        $basicRules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'status' => 'required|in_list[active,inactive]'
        ];

        if (!$this->validate($basicRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Check if files are uploaded
        $images = $this->request->getFiles();
        if (!isset($images['images']) || empty($images['images'])) {
            return redirect()->back()->withInput()->with('error', 'Please select at least one image to upload');
        }

        // Validate each file
        foreach ($images['images'] as $image) {
            if (!$image->isValid()) {
                return redirect()->back()->withInput()->with('error', 'One or more files are invalid');
            }
            if ($image->getSize() > 2048 * 1024) { // 2MB in bytes
                return redirect()->back()->withInput()->with('error', 'File size must be less than 2MB');
            }
            if (!in_array($image->getMimeType(), ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'])) {
                return redirect()->back()->withInput()->with('error', 'Only image files are allowed (JPEG, PNG, GIF, WebP)');
            }
        }

        $images = $this->request->getFiles();
        $uploadedCount = 0;

        if (isset($images['images'])) {
            foreach ($images['images'] as $image) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getRandomName();
                    $image->move(FCPATH . 'uploads/gallery/', $newName);

                    $data = [
                        'title' => $this->request->getPost('title'),
                        'alt_text' => $this->request->getPost('alt_text'),
                        'image_path' => 'uploads/gallery/' . $newName,
                        'status' => $this->request->getPost('status'),
                        'is_homepage' => $this->request->getPost('is_homepage') ? 1 : 0,
                        'sort_order' => $this->request->getPost('sort_order') ?: 0
                    ];

                    if ($this->imageModel->insert($data)) {
                        $uploadedCount++;
                    }
                }
            }
        }

        if ($uploadedCount > 0) {
            return redirect()->to('/admin/images')->with('success', "$uploadedCount image(s) uploaded successfully");
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to upload images');
        }
    }

    /**
     * Edit image form
     * 
     * @param int $id
     * @return string
     */
    public function edit(int $id): string
    {
        $image = $this->imageModel->find($id);
        
        if (!$image) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Image not found');
        }

        $data = [
            'title' => 'Edit Image',
            'image' => $image,
            'validation' => session()->getFlashdata('validation')
        ];

        return view('admin/gallery/images/form', $data);
    }

    /**
     * Update image
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function update(int $id)
    {
        $image = $this->imageModel->find($id);
        
        if (!$image) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Image not found');
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'status' => 'required|in_list[active,inactive]',
            'image' => 'if_exist|uploaded[image]|is_image[image]|max_size[image,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'alt_text' => $this->request->getPost('alt_text'),
            'status' => $this->request->getPost('status'),
            'is_homepage' => $this->request->getPost('is_homepage') ? 1 : 0,
            'sort_order' => $this->request->getPost('sort_order') ?: 0
        ];

        // Handle file upload
        $newImage = $this->request->getFile('image');
        if ($newImage && $newImage->isValid() && !$newImage->hasMoved()) {
            // Delete old image
            if ($image['image_path'] && file_exists(FCPATH . $image['image_path'])) {
                unlink(FCPATH . $image['image_path']);
            }
            
            $newName = $newImage->getRandomName();
            $newImage->move(FCPATH . 'uploads/gallery/', $newName);
            $data['image_path'] = 'uploads/gallery/' . $newName;
        }

        if ($this->imageModel->update($id, $data)) {
            return redirect()->to('/admin/images')->with('success', 'Image updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update image');
        }
    }

    /**
     * Delete image (soft delete)
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete(int $id)
    {
        $image = $this->imageModel->find($id);
        
        if (!$image) {
            return redirect()->back()->with('error', 'Image not found');
        }

        if ($this->imageModel->delete($id)) {
            return redirect()->back()->with('success', 'Image moved to trash');
        } else {
            return redirect()->back()->with('error', 'Failed to delete image');
        }
    }

    /**
     * Recycle bin - show trashed images
     * 
     * @return string
     */
    public function trash(): string
    {
        $data = [
            'title' => 'Image Gallery Recycle Bin',
            'images' => $this->imageModel->getTrashedImages()
        ];

        return view('admin/gallery/images/trash', $data);
    }

    /**
     * Restore image from trash
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function restore(int $id)
    {
        if ($this->imageModel->restoreImage($id)) {
            return redirect()->back()->with('success', 'Image restored successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to restore image');
        }
    }

    /**
     * Permanently delete image
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function forceDelete(int $id)
    {
        $image = $this->imageModel->onlyDeleted()->find($id);
        
        if (!$image) {
            return redirect()->back()->with('error', 'Image not found');
        }

        // Delete associated file
        if ($image['image_path'] && file_exists(FCPATH . $image['image_path'])) {
            unlink(FCPATH . $image['image_path']);
        }

        if ($this->imageModel->delete($id, true)) {
            return redirect()->back()->with('success', 'Image permanently deleted');
        } else {
            return redirect()->back()->with('error', 'Failed to delete image');
        }
    }

    /**
     * Toggle homepage status
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function toggleHomepage(int $id)
    {
        $image = $this->imageModel->find($id);
        
        if (!$image) {
            return redirect()->back()->with('error', 'Image not found');
        }

        $newStatus = $image['is_homepage'] ? 0 : 1;
        
        if ($this->imageModel->update($id, ['is_homepage' => $newStatus])) {
            $message = $newStatus ? 'Image added to homepage' : 'Image removed from homepage';
            return redirect()->back()->with('success', $message);
        } else {
            return redirect()->back()->with('error', 'Failed to update homepage status');
        }
    }

    /**
     * Toggle active status
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function toggleStatus(int $id)
    {
        $image = $this->imageModel->find($id);
        
        if (!$image) {
            return redirect()->back()->with('error', 'Image not found');
        }

        $newStatus = $image['status'] === 'active' ? 'inactive' : 'active';

        if ($this->imageModel->update($id, ['status' => $newStatus])) {
            $message = $newStatus === 'active' ? 'Image activated' : 'Image deactivated';
            return redirect()->back()->with('success', $message);
        } else {
            return redirect()->back()->with('error', 'Failed to update status');
        }
    }

    /**
     * Update sort order via AJAX
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function updateSortOrder()
    {
        $sortData = $this->request->getPost('sort_data');
        
        if ($this->imageModel->updateSortOrder($sortData)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Sort order updated']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update sort order']);
        }
    }

    /**
     * Bulk actions
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function bulkAction()
    {
        $action = $this->request->getPost('bulk_action');
        $selectedIds = $this->request->getPost('selected_ids');

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'No images selected');
        }

        $count = 0;
        switch ($action) {
            case 'activate':
                $count = $this->imageModel->whereIn('id', $selectedIds)->set(['status' => 'active'])->update();
                $message = "$count image(s) activated";
                break;
            case 'deactivate':
                $count = $this->imageModel->whereIn('id', $selectedIds)->set(['status' => 'inactive'])->update();
                $message = "$count image(s) deactivated";
                break;
            case 'delete':
                foreach ($selectedIds as $id) {
                    if ($this->imageModel->delete($id)) {
                        $count++;
                    }
                }
                $message = "$count image(s) moved to trash";
                break;
            default:
                return redirect()->back()->with('error', 'Invalid action');
        }

        return redirect()->back()->with('success', $message);
    }
}