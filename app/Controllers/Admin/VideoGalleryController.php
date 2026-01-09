<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\VideoGalleryModel;

/**
 * Admin Video Gallery Controller
 * 
 * Handles video gallery management in admin panel
 * 
 * @package App\Controllers\Admin
 * @author  Senior PHP Architect
 */
class VideoGalleryController extends BaseController
{
    protected $videoModel;

    public function __construct()
    {
        $this->videoModel = new VideoGalleryModel();
    }

    /**
     * Video gallery listing page
     * 
     * @return string
     */
    public function index(): string
    {
        $data = [
            'title' => 'Manage Video Gallery',
            'videos' => $this->videoModel->getAdminVideosList(10),
            'pager' => $this->videoModel->pager,
            'stats' => $this->videoModel->getVideoStats()
        ];

        return view('admin/gallery/videos/index', $data);
    }

    /**
     * Create video form
     * 
     * @return string
     */
    public function create(): string
    {
        $data = [
            'title' => 'Add Video',
            'video' => null,
            'validation' => session()->getFlashdata('validation')
        ];

        return view('admin/gallery/videos/form', $data);
    }

    /**
     * Store new video
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function store()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'video_type' => 'required|in_list[youtube,mp4]',
            'status' => 'required|in_list[active,inactive]'
        ];

        // Add conditional validation based on video type
        $videoType = $this->request->getPost('video_type');
        if ($videoType === 'youtube') {
            $rules['video_url'] = 'required|valid_url';
        } else {
            $rules['video_file'] = 'uploaded[video_file]|max_size[video_file,51200]'; // 50MB max
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'video_type' => $videoType,
            'status' => $this->request->getPost('status'),
            'is_homepage' => $this->request->getPost('is_homepage') ? 1 : 0,
            'sort_order' => $this->request->getPost('sort_order') ?: 0
        ];

        if ($videoType === 'youtube') {
            $videoUrl = $this->request->getPost('video_url');
            $data['video_url'] = $videoUrl;
        } else {
            // Handle MP4 file upload
            $videoFile = $this->request->getFile('video_file');
            if ($videoFile && $videoFile->isValid() && !$videoFile->hasMoved()) {
                $newName = $videoFile->getRandomName();
                $videoFile->move(FCPATH . 'uploads/videos/', $newName);
                $data['video_url'] = base_url('uploads/videos/' . $newName);
            }
        }

        // Handle thumbnail upload
        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail && $thumbnail->isValid() && !$thumbnail->hasMoved()) {
            $newName = $thumbnail->getRandomName();
            $thumbnail->move(FCPATH . 'uploads/video-thumbnails/', $newName);
            $data['thumbnail'] = 'uploads/video-thumbnails/' . $newName;
        }

        if ($this->videoModel->insert($data)) {
            return redirect()->to('/admin/videos')->with('success', 'Video added successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add video');
        }
    }

    /**
     * Edit video form
     * 
     * @param int $id
     * @return string
     */
    public function edit(int $id): string
    {
        $video = $this->videoModel->find($id);
        
        if (!$video) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Video not found');
        }

        $data = [
            'title' => 'Edit Video',
            'video' => $video,
            'validation' => session()->getFlashdata('validation')
        ];

        return view('admin/gallery/videos/form', $data);
    }

    /**
     * Update video
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function update(int $id)
    {
        $video = $this->videoModel->find($id);
        
        if (!$video) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Video not found');
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'video_type' => 'required|in_list[youtube,mp4]',
            'status' => 'required|in_list[active,inactive]'
        ];

        // Add conditional validation based on video type
        $videoType = $this->request->getPost('video_type');
        if ($videoType === 'youtube') {
            $rules['video_url'] = 'required|valid_url';
        } else {
            $rules['video_file'] = 'if_exist|uploaded[video_file]|max_size[video_file,51200]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'video_type' => $videoType,
            'status' => $this->request->getPost('status'),
            'is_homepage' => $this->request->getPost('is_homepage') ? 1 : 0,
            'sort_order' => $this->request->getPost('sort_order') ?: 0
        ];

        if ($videoType === 'youtube') {
            $videoUrl = $this->request->getPost('video_url');
            $data['video_url'] = $videoUrl;
        } else {
            // Handle MP4 file upload
            $videoFile = $this->request->getFile('video_file');
            if ($videoFile && $videoFile->isValid() && !$videoFile->hasMoved()) {
                // Delete old video file if exists
                if (isset($video['video_url']) && strpos($video['video_url'], 'uploads/videos/') !== false) {
                    $oldPath = FCPATH . str_replace(base_url(), '', $video['video_url']);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                
                $newName = $videoFile->getRandomName();
                $videoFile->move(FCPATH . 'uploads/videos/', $newName);
                $data['video_url'] = base_url('uploads/videos/' . $newName);
            }
        }

        // Handle thumbnail upload
        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail && $thumbnail->isValid() && !$thumbnail->hasMoved()) {
            // Delete old thumbnail if exists
            if (isset($video['thumbnail']) && $video['thumbnail']) {
                $oldPath = FCPATH . $video['thumbnail'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            
            $newName = $thumbnail->getRandomName();
            $thumbnail->move(FCPATH . 'uploads/video-thumbnails/', $newName);
            $data['thumbnail'] = 'uploads/video-thumbnails/' . $newName;
        }

        if ($this->videoModel->update($id, $data)) {
            return redirect()->to('/admin/videos')->with('success', 'Video updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update video');
        }
    }

    /**
     * Delete video (soft delete)
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete(int $id)
    {
        $video = $this->videoModel->find($id);
        
        if (!$video) {
            return redirect()->back()->with('error', 'Video not found');
        }

        if ($this->videoModel->delete($id)) {
            return redirect()->back()->with('success', 'Video moved to trash');
        } else {
            return redirect()->back()->with('error', 'Failed to delete video');
        }
    }

    /**
     * Recycle bin - show trashed videos
     * 
     * @return string
     */
    public function trash(): string
    {
        $data = [
            'title' => 'Video Gallery Recycle Bin',
            'videos' => $this->videoModel->getTrashedVideos()
        ];

        return view('admin/gallery/videos/trash', $data);
    }

    /**
     * Restore video from trash
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function restore(int $id)
    {
        if ($this->videoModel->restoreVideo($id)) {
            return redirect()->back()->with('success', 'Video restored successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to restore video');
        }
    }

    /**
     * Permanently delete video
     * 
     * @param int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function forceDelete(int $id)
    {
        $video = $this->videoModel->onlyDeleted()->find($id);
        
        if (!$video) {
            return redirect()->back()->with('error', 'Video not found');
        }

        // Delete associated files
        if (isset($video['video_url']) && strpos($video['video_url'], 'uploads/videos/') !== false) {
            $videoPath = FCPATH . str_replace(base_url(), '', $video['video_url']);
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }
        }
        if ($video['thumbnail'] && file_exists(FCPATH . $video['thumbnail'])) {
            unlink(FCPATH . $video['thumbnail']);
        }

        if ($this->videoModel->delete($id, true)) {
            return redirect()->back()->with('success', 'Video permanently deleted');
        } else {
            return redirect()->back()->with('error', 'Failed to delete video');
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
        $video = $this->videoModel->find($id);
        
        if (!$video) {
            return redirect()->back()->with('error', 'Video not found');
        }

        $newStatus = $video['is_homepage'] ? 0 : 1;
        
        if ($this->videoModel->update($id, ['is_homepage' => $newStatus])) {
            $message = $newStatus ? 'Video added to homepage' : 'Video removed from homepage';
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
        $video = $this->videoModel->find($id);
        
        if (!$video) {
            return redirect()->back()->with('error', 'Video not found');
        }

        $newStatus = $video['status'] === 'active' ? 'inactive' : 'active';

        if ($this->videoModel->update($id, ['status' => $newStatus])) {
            $message = $newStatus === 'active' ? 'Video activated' : 'Video deactivated';
            return redirect()->back()->with('success', $message);
        } else {
            return redirect()->back()->with('error', 'Failed to update status');
        }
    }

    /**
     * Extract YouTube video ID from URL
     * 
     * @param string $url
     * @return string|null
     */
    private function extractYouTubeId(string $url): ?string
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        preg_match($pattern, $url, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }

    /**
     * Update sort order via AJAX
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function updateSortOrder()
    {
        $sortData = $this->request->getPost('sort_data');
        
        if ($this->videoModel->updateSortOrder($sortData)) {
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
            return redirect()->back()->with('error', 'No videos selected');
        }

        $count = 0;
        switch ($action) {
            case 'activate':
                $count = $this->videoModel->whereIn('id', $selectedIds)->set(['status' => 'active'])->update();
                $message = "$count video(s) activated";
                break;
            case 'deactivate':
                $count = $this->videoModel->whereIn('id', $selectedIds)->set(['status' => 'inactive'])->update();
                $message = "$count video(s) deactivated";
                break;
            case 'delete':
                foreach ($selectedIds as $id) {
                    if ($this->videoModel->delete($id)) {
                        $count++;
                    }
                }
                $message = "$count video(s) moved to trash";
                break;
            default:
                return redirect()->back()->with('error', 'Invalid action');
        }

        return redirect()->back()->with('success', $message);
    }
}