<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;

/**
 * Admin User Management Controller
 * 
 * Handles user management in admin panel
 * 
 * @package App\Controllers\Admin
 */
class UserManagementController extends BaseController
{
    protected $userModel;
    protected $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    /**
     * Display list of users
     */
    public function index()
    {
        $data = [
            'title' => 'User Management',
            'users' => $this->userModel->getUsersWithRoles()
        ];

        return view('admin/users/index', $data);
    }

    /**
     * Show create user form
     */
    public function create()
    {
        $data = [
            'title' => 'Add New User',
            'roles' => $this->roleModel->findAll()
        ];

        return view('admin/users/create', $data);
    }

    /**
     * Store new user
     */
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
            'role_id' => 'required|integer',
            'status' => 'required|in_list[active,inactive]',
            'bio' => 'max_length[1000]',
            'phone' => 'max_length[20]',
            'department' => 'max_length[100]',
            'profile_image' => 'if_exist|is_image[profile_image]|max_size[profile_image,2048]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'), // Will be hashed by model
            'role_id' => $this->request->getPost('role_id'),
            'status' => $this->request->getPost('status'),
            'bio' => $this->request->getPost('bio'),
            'phone' => $this->request->getPost('phone'),
            'department' => $this->request->getPost('department'),
            'email_verified' => $this->request->getPost('email_verified') ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Handle profile image upload
        $profileImage = $this->request->getFile('profile_image');
        if ($profileImage && $profileImage->isValid() && !$profileImage->hasMoved()) {
            $newName = $profileImage->getRandomName();
            if (!is_dir(FCPATH . 'uploads/profiles')) {
                mkdir(FCPATH . 'uploads/profiles', 0755, true);
            }
            $profileImage->move(FCPATH . 'uploads/profiles', $newName);
            $data['profile_image'] = 'uploads/profiles/' . $newName;
        }

        if ($data['email_verified']) {
            $data['email_verified_at'] = date('Y-m-d H:i:s');
        }

        if ($this->userModel->insert($data)) {
            return redirect()->to('/admin/user-management')->with('success', 'User created successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create user');
    }

    /**
     * Show edit user form
     */
    public function edit($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => $this->roleModel->findAll()
        ];

        return view('admin/users/edit', $data);
    }

    /**
     * Update user
     */
    public function update($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        $validation = \Config\Services::validation();
        
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role_id' => 'required|integer',
            'status' => 'required|in_list[active,inactive]',
            'bio' => 'max_length[1000]',
            'phone' => 'max_length[20]',
            'department' => 'max_length[100]'
        ];

        // Only validate password if it's being changed
        if (!empty($this->request->getPost('password'))) {
            $rules['password'] = 'required|min_length[8]';
            $rules['confirm_password'] = 'required|matches[password]';
        }

        // Only validate image if uploaded
        $profileImage = $this->request->getFile('profile_image');
        if ($profileImage && $profileImage->isValid()) {
            $rules['profile_image'] = 'is_image[profile_image]|max_size[profile_image,2048]';
        }

        $validation->setRules($rules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'role_id' => $this->request->getPost('role_id'),
            'status' => $this->request->getPost('status'),
            'bio' => $this->request->getPost('bio'),
            'phone' => $this->request->getPost('phone'),
            'department' => $this->request->getPost('department'),
            'email_verified' => $this->request->getPost('email_verified') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Update password if provided
        if (!empty($this->request->getPost('password'))) {
            $data['password'] = $this->request->getPost('password'); // Will be hashed by model
        }

        // Handle profile image upload
        if ($profileImage && $profileImage->isValid() && !$profileImage->hasMoved()) {
            // Remove old image if exists
            if (!empty($user['profile_image']) && file_exists(FCPATH . $user['profile_image'])) {
                unlink(FCPATH . $user['profile_image']);
            }
            
            $newName = $profileImage->getRandomName();
            if (!is_dir(FCPATH . 'uploads/profiles')) {
                mkdir(FCPATH . 'uploads/profiles', 0755, true);
            }
            $profileImage->move(FCPATH . 'uploads/profiles', $newName);
            $data['profile_image'] = 'uploads/profiles/' . $newName;
        }

        // Handle image removal
        if ($this->request->getPost('remove_profile_image')) {
            if (!empty($user['profile_image']) && file_exists(FCPATH . $user['profile_image'])) {
                unlink(FCPATH . $user['profile_image']);
            }
            $data['profile_image'] = null;
        }

        // Update email verification timestamp
        if ($data['email_verified'] && !$user['email_verified']) {
            $data['email_verified_at'] = date('Y-m-d H:i:s');
        } elseif (!$data['email_verified']) {
            $data['email_verified_at'] = null;
        }

        if ($this->userModel->update($id, $data)) {
            return redirect()->to('/admin/user-management')->with('success', 'User updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update user');
    }

    /**
     * Delete user
     */
    public function delete($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/user-management')->with('error', 'User not found');
        }

        // Prevent deletion of current admin user
        if ($user['id'] == session()->get('user_id')) {
            return redirect()->to('/admin/user-management')->with('error', 'Cannot delete your own account');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to('/admin/user-management')->with('success', 'User deleted successfully');
        }

        return redirect()->to('/admin/user-management')->with('error', 'Failed to delete user');
    }

    /**
     * Toggle user status
     */
    public function toggleStatus($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not found']);
        }

        // Prevent deactivating current admin user
        if ($user['id'] == session()->get('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cannot deactivate your own account']);
        }

        $newStatus = $user['status'] === 'active' ? 'inactive' : 'active';
        
        if ($this->userModel->update($id, ['status' => $newStatus])) {
            return $this->response->setJSON(['success' => true, 'status' => $newStatus]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
    }

    /**
     * Show user profile
     */
    public function show($id)
    {
        $user = $this->userModel->getUserWithDetails($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        $data = [
            'title' => 'User Profile',
            'user' => $user
        ];

        return view('admin/users/show', $data);
    }

    /**
     * Reset user password
     */
    public function resetPassword($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not found']);
        }

        // Generate random password
        $newPassword = $this->generateRandomPassword();
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        if ($this->userModel->update($id, ['password' => $hashedPassword])) {
            // In a real application, you would send this password via email
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Password reset successfully',
                'new_password' => $newPassword
            ]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to reset password']);
    }

    /**
     * Bulk actions for users
     */
    public function bulkAction()
    {
        $action = $this->request->getPost('action');
        $userIds = $this->request->getPost('user_ids');

        if (empty($userIds) || !is_array($userIds)) {
            return redirect()->back()->with('error', 'No users selected');
        }

        $processed = 0;
        $currentUserId = session()->get('user_id');

        switch ($action) {
            case 'activate':
                foreach ($userIds as $id) {
                    if ($id != $currentUserId) {
                        $this->userModel->update($id, ['status' => 'active']);
                        $processed++;
                    }
                }
                break;

            case 'deactivate':
                foreach ($userIds as $id) {
                    if ($id != $currentUserId) {
                        $this->userModel->update($id, ['status' => 'inactive']);
                        $processed++;
                    }
                }
                break;

            case 'delete':
                foreach ($userIds as $id) {
                    if ($id != $currentUserId) {
                        $this->userModel->delete($id);
                        $processed++;
                    }
                }
                break;

            default:
                return redirect()->back()->with('error', 'Invalid action');
        }

        return redirect()->back()->with('success', "Processed {$processed} users successfully");
    }

    /**
     * Export users to CSV
     */
    public function export()
    {
        $users = $this->userModel->getUsersForExport();
        
        $filename = 'users_' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, [
            'ID', 'Name', 'Email', 'Role', 'Status', 'Created At'
        ]);
        
        foreach ($users as $user) {
            fputcsv($output, [
                $user['id'],
                $user['name'],
                $user['email'],
                $user['role_name'] ?? 'N/A',
                $user['status'],
                $user['created_at']
            ]);
        }
        
        fclose($output);
        exit;
    }

    /**
     * Generate random password
     */
    private function generateRandomPassword($length = 12): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        return substr(str_shuffle($chars), 0, $length);
    }

    /**
     * Debug method to check file existence
     */
    public function checkFile($filename = null)
    {
        if (!$filename) {
            return $this->response->setJSON(['error' => 'No filename provided']);
        }
        
        $publicPath = FCPATH . 'uploads/profiles/' . $filename;
        $exists = file_exists($publicPath);
        
        return $this->response->setJSON([
            'filename' => $filename,
            'public_path' => $publicPath,
            'exists' => $exists,
            'files_in_directory' => array_diff(scandir(FCPATH . 'uploads/profiles/'), ['.', '..'])
        ]);
    }
}