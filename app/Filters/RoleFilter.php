<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/auth/login')->with('error', 'Please login to access this page.');
        }

        $userRole = $session->get('user_role');
        $allowedRoles = $arguments ?? [];

        if (!in_array($userRole, $allowedRoles)) {
            return redirect()->to($this->getDashboardUrl($userRole))
                           ->with('error', 'You do not have permission to access this page.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
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