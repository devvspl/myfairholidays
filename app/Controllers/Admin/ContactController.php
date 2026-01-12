<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContactModel;

class ContactController extends BaseController
{
    protected $contactModel;

    public function __construct()
    {
        $this->contactModel = new ContactModel();
    }

    /**
     * Display contact messages
     */
    public function index()
    {
        $perPage = 20;
        
        // Get filter parameters
        $filters = [
            'status' => $this->request->getVar('status'),
            'search' => $this->request->getVar('search'),
            'date_from' => $this->request->getVar('date_from'),
            'date_to' => $this->request->getVar('date_to')
        ];

        // Get contacts with filters
        $contacts = $this->contactModel->getContacts($filters, $perPage);
        
        // Get statistics
        $stats = $this->contactModel->getStats();

        $data = [
            'title' => 'Contact Messages',
            'contacts' => $contacts,
            'stats' => $stats,
            'filters' => $filters,
            'pager' => $this->contactModel->pager
        ];

        return view('admin/contacts/index', $data);
    }

    /**
     * Show contact message details
     */
    public function show($id)
    {
        $contact = $this->contactModel->find($id);
        
        if (!$contact) {
            return redirect()->to('/admin/contacts')->with('error', 'Contact message not found');
        }

        // Mark as read if it's new
        if ($contact['status'] === 'new') {
            $this->contactModel->markAsRead($id);
        }

        $data = [
            'title' => 'Contact Message Details',
            'contact' => $contact
        ];

        return view('admin/contacts/show', $data);
    }

    /**
     * Update contact status
     */
    public function updateStatus($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/contacts');
        }

        $status = $this->request->getPost('status');
        $validStatuses = ['new', 'read', 'replied', 'closed'];

        if (!in_array($status, $validStatuses)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid status'
            ]);
        }

        $contact = $this->contactModel->find($id);
        if (!$contact) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Contact message not found'
            ]);
        }

        if ($this->contactModel->update($id, ['status' => $status])) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update status'
            ]);
        }
    }

    /**
     * Delete contact message
     */
    public function delete($id)
    {
        $contact = $this->contactModel->find($id);
        
        if (!$contact) {
            return redirect()->to('/admin/contacts')->with('error', 'Contact message not found');
        }

        if ($this->contactModel->delete($id)) {
            return redirect()->to('/admin/contacts')->with('success', 'Contact message deleted successfully');
        } else {
            return redirect()->to('/admin/contacts')->with('error', 'Failed to delete contact message');
        }
    }

    /**
     * Bulk actions
     */
    public function bulkAction()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/contacts');
        }

        $action = $this->request->getPost('action');
        $ids = $this->request->getPost('ids');

        // Handle both array format and single values
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        // Remove empty values
        $ids = array_filter($ids);

        if (empty($ids)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No items selected'
            ]);
        }

        if (empty($action)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No action selected'
            ]);
        }

        $count = 0;
        
        try {
            switch ($action) {
                case 'mark_read':
                    foreach ($ids as $id) {
                        if ($this->contactModel->update($id, ['status' => 'read'])) {
                            $count++;
                        }
                    }
                    $message = $count . ' contact(s) marked as read';
                    break;
                    
                case 'mark_replied':
                    foreach ($ids as $id) {
                        if ($this->contactModel->update($id, ['status' => 'replied'])) {
                            $count++;
                        }
                    }
                    $message = $count . ' contact(s) marked as replied';
                    break;
                    
                case 'mark_closed':
                    foreach ($ids as $id) {
                        if ($this->contactModel->update($id, ['status' => 'closed'])) {
                            $count++;
                        }
                    }
                    $message = $count . ' contact(s) marked as closed';
                    break;
                    
                case 'delete':
                    foreach ($ids as $id) {
                        if ($this->contactModel->delete($id)) {
                            $count++;
                        }
                    }
                    $message = $count . ' contact(s) deleted';
                    break;
                    
                default:
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Invalid action'
                    ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Bulk action error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while processing the bulk action'
            ]);
        }
    }

    /**
     * Export contacts to CSV
     */
    public function export()
    {
        // Get filter parameters
        $filters = [
            'status' => $this->request->getVar('status'),
            'search' => $this->request->getVar('search'),
            'date_from' => $this->request->getVar('date_from'),
            'date_to' => $this->request->getVar('date_to')
        ];

        // Get all contacts with filters (no pagination)
        $builder = $this->contactModel->builder();
        
        // Apply same filters as index method
        if (!empty($filters['status'])) {
            $builder->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart()
                   ->like('name', $filters['search'])
                   ->orLike('email', $filters['search'])
                   ->orLike('subject', $filters['search'])
                   ->orLike('message', $filters['search'])
                   ->groupEnd();
        }

        if (!empty($filters['date_from'])) {
            $builder->where('created_at >=', $filters['date_from'] . ' 00:00:00');
        }

        if (!empty($filters['date_to'])) {
            $builder->where('created_at <=', $filters['date_to'] . ' 23:59:59');
        }

        $contacts = $builder->orderBy('created_at', 'DESC')->get()->getResultArray();

        // Set headers for CSV download
        $filename = 'contacts_' . date('Y-m-d_H-i-s') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');

        // Open output stream
        $output = fopen('php://output', 'w');

        // Add CSV headers
        fputcsv($output, [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Subject',
            'Message',
            'Status',
            'IP Address',
            'Created At'
        ]);

        // Add data rows
        foreach ($contacts as $contact) {
            fputcsv($output, [
                $contact['id'],
                $contact['name'],
                $contact['email'],
                $contact['phone'],
                $contact['subject'],
                $contact['message'],
                ucfirst($contact['status']),
                $contact['ip_address'],
                $contact['created_at']
            ]);
        }

        fclose($output);
        exit;
    }
}