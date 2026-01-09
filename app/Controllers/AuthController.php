<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    protected $userModel;
    protected $roleModel;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    /**
     * Show login form
     */
    public function login()
    {
        // Redirect if already logged in
        if ($this->session->get('isLoggedIn')) {
            return $this->redirectToDashboard();
        }

        $data = [
            'title' => 'Login',
            'validation' => $this->validation
        ];

        return view('auth/login', $data);
    }

    /**
     * Process login
     */
    public function loginPost()
    {
        // Validation rules
        $rules = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please enter a valid email address'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password must be at least 6 characters'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Get user by email
        $user = $this->userModel->getUserByEmail($email);

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password');
        }

        // Verify password
        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password');
        }

        // Check if user is active
        if ($user['status'] !== 'active') {
            return redirect()->back()->withInput()->with('error', 'Your account is inactive. Please contact administrator.');
        }

        // Set session data
        $sessionData = [
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'user_email' => $user['email'],
            'user_role' => $user['role_name'],
            'role_id' => $user['role_id'],
            'isLoggedIn' => true
        ];

        $this->session->set($sessionData);
        $this->session->regenerate();

        return redirect()->to($this->getDashboardUrl($user['role_name']))
                        ->with('success', 'Welcome back, ' . $user['name'] . '!');
    }

    /**
     * Show register form
     */
    public function register()
    {
        // Redirect if already logged in
        if ($this->session->get('isLoggedIn')) {
            return $this->redirectToDashboard();
        }

        $data = [
            'title' => 'Register',
            'roles' => $this->roleModel->where('name !=', 'admin')->findAll(),
            'validation' => $this->validation
        ];

        return view('auth/register', $data);
    }

    /**
     * Process registration
     */
    public function registerPost()
    {
        // Validation rules
        $rules = [
            'name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Name is required',
                    'min_length' => 'Name must be at least 3 characters',
                    'max_length' => 'Name cannot exceed 100 characters'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please enter a valid email address',
                    'is_unique' => 'Email already exists'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password must be at least 6 characters'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Confirm password is required',
                    'matches' => 'Passwords do not match'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Get default user role
        $userRole = $this->roleModel->getRoleByName('user');
        if (!$userRole) {
            return redirect()->back()->withInput()->with('error', 'System error: Default role not found');
        }

        // Prepare user data
        $userData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role_id' => $userRole['id'],
            'status' => 'active'
        ];

        // Insert user
        if ($this->userModel->insert($userData)) {
            return redirect()->to('/auth/login')->with('success', 'Registration successful! Please login.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Registration failed. Please try again.');
        }
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/auth/login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Redirect to appropriate dashboard based on role
     */
    private function redirectToDashboard()
    {
        $role = $this->session->get('user_role');
        return redirect()->to($this->getDashboardUrl($role));
    }

    /**
     * Get dashboard URL based on role
     */
    private function getDashboardUrl(string $role): string
    {
        switch ($role) {
            case 'admin':
                return '/admin/dashboard';
            case 'manager':
                return '/manager/dashboard';
            case 'user':
                return '/user/dashboard';
            default:
                return '/auth/login';
        }
    }
}