<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    protected $userModel;
    protected $roleModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->session = \Config\Services::session();
    }

    /**
     * User Dashboard
     */
    public function dashboard()
    {
        $userId = $this->session->get('user_id');
        $user = $this->userModel->getUserWithRole($userId);

        $data = [
            'title' => 'User Dashboard',
            'user' => $user
        ];

        return view('dashboard/user', $data);
    }

    /**
     * User Profile
     */
    public function profile()
    {
        $userId = $this->session->get('user_id');
        $user = $this->userModel->getUserWithRole($userId);

        $data = [
            'title' => 'My Profile',
            'user' => $user
        ];

        return view('user/profile', $data);
    }

    /**
     * Update Profile
     */
    public function updateProfile()
    {
        $userId = $this->session->get('user_id');
        
        $rules = [
            'name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Name is required',
                    'min_length' => 'Name must be at least 3 characters',
                    'max_length' => 'Name cannot exceed 100 characters'
                ]
            ],
            'bio' => 'max_length[1000]',
            'phone' => 'max_length[20]',
            'department' => 'max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $userData = [
            'name' => $this->request->getPost('name'),
            'bio' => $this->request->getPost('bio'),
            'phone' => $this->request->getPost('phone'),
            'department' => $this->request->getPost('department')
        ];

        // Handle profile image upload
        $profileImage = $this->request->getFile('profile_image');
        if ($profileImage && $profileImage->isValid() && !$profileImage->hasMoved()) {
            $newName = $profileImage->getRandomName();
            if (!is_dir(FCPATH . 'uploads/profiles')) {
                mkdir(FCPATH . 'uploads/profiles', 0755, true);
            }
            $profileImage->move(FCPATH . 'uploads/profiles', $newName);
            $userData['profile_image'] = 'uploads/profiles/' . $newName;
        }

        if ($this->userModel->update($userId, $userData)) {
            // Update session data
            $this->session->set('user_name', $userData['name']);
            return redirect()->back()->with('success', 'Profile updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update profile');
        }
    }
}