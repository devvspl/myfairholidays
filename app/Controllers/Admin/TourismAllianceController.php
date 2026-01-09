<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TourismAllianceModel;

/**
 * Admin Tourism Alliance Controller
 * 
 * Handles tourism alliance management in admin panel
 * 
 * @package App\Controllers\Admin
 * @author  Senior PHP Architect
 */
class TourismAllianceController extends BaseController
{
    protected $allianceModel;

    public function __construct()
    {
        $this->allianceModel = new TourismAllianceModel();
    }

    /**
     * Display list of tourism alliances
     */
    public function index()
    {
        $searchTerm = $this->request->getGet('search');
        
        $data = [
            'title' => 'Tourism Alliances Management',
            'alliances' => $this->allianceModel->getAdminAlliancesList(15, $searchTerm),
            'pager' => $this->allianceModel->pager,
            'stats' => $this->allianceModel->getAllianceStats(),
            'searchTerm' => $searchTerm
        ];

        return view('admin/tourism_alliances/index', $data);
    }

    /**
     * Show create alliance form
     */
    public function create()
    {
        $data = [
            'title' => 'Add New Tourism Alliance',
            'alliance' => null,
            'allianceTypes' => $this->allianceModel->getAllianceTypes(),
            'validation' => session()->getFlashdata('validation')
        ];

        return view('admin/tourism_alliances/form', $data);
    }

    /**
     * Store new alliance
     */
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => 'required|min_length[2]|max_length[255]',
            'type' => 'required|in_list[tourism_board,airline,hotel_chain,travel_agency,other]',
            'status' => 'required|in_list[active,inactive]',
            'website_url' => 'permit_empty|valid_url',
            'logo' => 'permit_empty|is_image[logo]|max_size[logo,2048]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // Handle file upload for logo
        $logoPath = null;
        $file = $this->request->getFile('logo');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/alliances';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $newName = $file->getRandomName();
            if ($file->move($uploadPath, $newName)) {
                $logoPath = 'uploads/alliances/' . $newName;
            }
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'logo' => $logoPath,
            'website_url' => $this->request->getPost('website_url'),
            'type' => $this->request->getPost('type'),
            'is_circle_frame' => $this->request->getPost('is_circle_frame') ? 1 : 0,
            'status' => $this->request->getPost('status'),
            'sort_order' => $this->request->getPost('sort_order') ?: $this->allianceModel->getNextSortOrder()
        ];

        if ($this->allianceModel->insert($data)) {
            return redirect()->to('/admin/tourism-alliances')->with('success', 'Tourism alliance created successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create tourism alliance');
    }

    /**
     * Show alliance details
     */
    public function show($id)
    {
        $alliance = $this->allianceModel->find($id);
        
        if (!$alliance) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tourism alliance not found');
        }

        $data = [
            'title' => 'Tourism Alliance Details',
            'alliance' => $alliance,
            'allianceTypes' => $this->allianceModel->getAllianceTypes()
        ];

        return view('admin/tourism_alliances/show', $data);
    }

    /**
     * Show edit alliance form
     */
    public function edit($id)
    {
        $alliance = $this->allianceModel->find($id);
        
        if (!$alliance) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tourism alliance not found');
        }

        $data = [
            'title' => 'Edit Tourism Alliance',
            'alliance' => $alliance,
            'allianceTypes' => $this->allianceModel->getAllianceTypes(),
            'validation' => session()->getFlashdata('validation')
        ];

        return view('admin/tourism_alliances/form', $data);
    }

    /**
     * Update alliance
     */
    public function update($id)
    {
        $alliance = $this->allianceModel->find($id);
        
        if (!$alliance) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tourism alliance not found');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => 'required|min_length[2]|max_length[255]',
            'type' => 'required|in_list[tourism_board,airline,hotel_chain,travel_agency,other]',
            'status' => 'required|in_list[active,inactive]',
            'website_url' => 'permit_empty|valid_url',
            'logo' => 'permit_empty|is_image[logo]|max_size[logo,2048]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // Handle file upload for logo
        $logoPath = $alliance['logo']; // Keep existing logo by default
        $file = $this->request->getFile('logo');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/alliances';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Delete old logo if exists
            if ($logoPath && file_exists(FCPATH . $logoPath)) {
                unlink(FCPATH . $logoPath);
            }
            
            $newName = $file->getRandomName();
            if ($file->move($uploadPath, $newName)) {
                $logoPath = 'uploads/alliances/' . $newName;
            }
        }

        // Handle logo removal if requested
        if ($this->request->getPost('remove_logo') === '1') {
            if ($logoPath && file_exists(FCPATH . $logoPath)) {
                unlink(FCPATH . $logoPath);
            }
            $logoPath = null;
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'logo' => $logoPath,
            'website_url' => $this->request->getPost('website_url'),
            'type' => $this->request->getPost('type'),
            'is_circle_frame' => $this->request->getPost('is_circle_frame') ? 1 : 0,
            'status' => $this->request->getPost('status'),
            'sort_order' => $this->request->getPost('sort_order') ?: $alliance['sort_order']
        ];

        if ($this->allianceModel->update($id, $data)) {
            return redirect()->to('/admin/tourism-alliances')->with('success', 'Tourism alliance updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update tourism alliance');
    }

    /**
     * Delete alliance (soft delete)
     */
    public function delete($id)
    {
        $alliance = $this->allianceModel->find($id);
        
        if (!$alliance) {
            return redirect()->to('/admin/tourism-alliances')->with('error', 'Tourism alliance not found');
        }

        if ($this->allianceModel->delete($id)) {
            return redirect()->to('/admin/tourism-alliances')->with('success', 'Tourism alliance moved to trash');
        }

        return redirect()->to('/admin/tourism-alliances')->with('error', 'Failed to delete tourism alliance');
    }

    /**
     * Toggle alliance status
     */
    public function toggleStatus($id)
    {
        $alliance = $this->allianceModel->find($id);
        
        if (!$alliance) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tourism alliance not found']);
        }

        $newStatus = $alliance['status'] === 'active' ? 'inactive' : 'active';
        
        if ($this->allianceModel->update($id, ['status' => $newStatus])) {
            return $this->response->setJSON(['success' => true, 'status' => $newStatus]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
    }

    /**
     * Show trashed alliances
     */
    public function trash()
    {
        $data = [
            'title' => 'Trashed Tourism Alliances',
            'alliances' => $this->allianceModel->getTrashedAlliances()
        ];

        return view('admin/tourism_alliances/trash', $data);
    }

    /**
     * Restore alliance from trash
     */
    public function restore($id)
    {
        if ($this->allianceModel->restoreAlliance($id)) {
            return redirect()->to('/admin/tourism-alliances/trash')->with('success', 'Tourism alliance restored successfully');
        }

        return redirect()->to('/admin/tourism-alliances/trash')->with('error', 'Failed to restore tourism alliance');
    }

    /**
     * Permanently delete alliance
     */
    public function forceDelete($id)
    {
        $alliance = $this->allianceModel->onlyDeleted()->find($id);
        
        if (!$alliance) {
            return redirect()->to('/admin/tourism-alliances/trash')->with('error', 'Tourism alliance not found');
        }

        // Delete logo file if exists
        if ($alliance['logo'] && file_exists(FCPATH . $alliance['logo'])) {
            unlink(FCPATH . $alliance['logo']);
        }

        if ($this->allianceModel->delete($id, true)) {
            return redirect()->to('/admin/tourism-alliances/trash')->with('success', 'Tourism alliance permanently deleted');
        }

        return redirect()->to('/admin/tourism-alliances/trash')->with('error', 'Failed to delete tourism alliance');
    }

    /**
     * Update sort order via AJAX
     */
    public function updateSortOrder()
    {
        $sortData = $this->request->getPost('sort_data');
        
        if ($this->allianceModel->updateSortOrder($sortData)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Sort order updated']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update sort order']);
    }

    /**
     * Bulk actions
     */
    public function bulkAction()
    {
        $action = $this->request->getPost('bulk_action');
        $allianceIds = $this->request->getPost('alliance_ids');

        if (empty($action) || empty($allianceIds)) {
            return redirect()->back()->with('error', 'Please select alliances and action');
        }

        $count = 0;
        foreach ($allianceIds as $allianceId) {
            switch ($action) {
                case 'activate':
                    if ($this->allianceModel->update($allianceId, ['status' => 'active'])) {
                        $count++;
                    }
                    break;
                case 'deactivate':
                    if ($this->allianceModel->update($allianceId, ['status' => 'inactive'])) {
                        $count++;
                    }
                    break;
                case 'delete':
                    if ($this->allianceModel->delete($allianceId)) {
                        $count++;
                    }
                    break;
            }
        }

        $message = $count > 0 ? "{$count} tourism alliances updated successfully" : "No tourism alliances were updated";
        return redirect()->back()->with('success', $message);
    }
}