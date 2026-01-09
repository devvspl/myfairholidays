<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class ManagerController extends Controller
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Manager Dashboard
     */
    public function dashboard()
    {
        $data = [
            'title' => 'Manager Dashboard',
            'user' => [
                'name' => $this->session->get('user_name'),
                'email' => $this->session->get('user_email'),
                'role' => $this->session->get('user_role')
            ],
            'stats' => [
                'total_users' => $this->userModel->getUsersByRole('user'),
                'user_count' => count($this->userModel->getUsersByRole('user'))
            ]
        ];

        return view('dashboard/manager', $data);
    }

    /**
     * View Users (Manager can only view regular users)
     */
    public function users()
    {
        $users = $this->userModel->getUsersByRole('user');

        $data = [
            'title' => 'View Users',
            'users' => $users
        ];

        return view('manager/users', $data);
    }
}