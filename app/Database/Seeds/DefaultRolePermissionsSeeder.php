<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DefaultRolePermissionsSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Get roles and permissions
        $adminRole = $db->table('roles')->where('name', 'admin')->get()->getRowArray();
        $managerRole = $db->table('roles')->where('name', 'manager')->get()->getRowArray();
        $userRole = $db->table('roles')->where('name', 'user')->get()->getRowArray();
        
        $permissions = $db->table('permissions')->get()->getResultArray();
        $permissionMap = [];
        foreach ($permissions as $permission) {
            $permissionMap[$permission['name']] = $permission['id'];
        }
        
        // Admin gets all permissions
        if ($adminRole) {
            $adminPermissions = [];
            foreach ($permissions as $permission) {
                $adminPermissions[] = [
                    'role_id' => $adminRole['id'],
                    'permission_id' => $permission['id'],
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
            $db->table('role_permissions')->insertBatch($adminPermissions);
        }
        
        // Manager gets limited permissions
        if ($managerRole) {
            $managerPermissionNames = [
                'dashboard.view',
                'users.view',
                'users.edit',
                'destinations.view',
                'destinations.edit',
                'hotels.view',
                'hotels.edit',
                'itineraries.view',
                'itineraries.create',
                'itineraries.edit',
                'reviews.view',
                'reviews.approve',
                'pages.view',
                'pages.edit',
                'news.view',
                'news.create',
                'news.edit',
                'galleries.view',
                'galleries.create',
                'galleries.edit'
            ];
            
            $managerPermissions = [];
            foreach ($managerPermissionNames as $permissionName) {
                if (isset($permissionMap[$permissionName])) {
                    $managerPermissions[] = [
                        'role_id' => $managerRole['id'],
                        'permission_id' => $permissionMap[$permissionName],
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
            }
            
            if (!empty($managerPermissions)) {
                $db->table('role_permissions')->insertBatch($managerPermissions);
            }
        }
        
        // User gets basic permissions
        if ($userRole) {
            $userPermissionNames = [
                'dashboard.view',
                'reviews.create'
            ];
            
            $userPermissions = [];
            foreach ($userPermissionNames as $permissionName) {
                if (isset($permissionMap[$permissionName])) {
                    $userPermissions[] = [
                        'role_id' => $userRole['id'],
                        'permission_id' => $permissionMap[$permissionName],
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
            }
            
            if (!empty($userPermissions)) {
                $db->table('role_permissions')->insertBatch($userPermissions);
            }
        }
    }
}
