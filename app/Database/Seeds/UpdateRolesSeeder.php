<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateRolesSeeder extends Seeder
{
    public function run()
    {
        $roleModel = new \App\Models\RoleModel();
        
        // Update existing roles with descriptions and permissions
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Full system administrator with complete access to all features',
                'permissions' => json_encode([
                    'users.view', 'users.create', 'users.edit', 'users.delete',
                    'destinations.view', 'destinations.create', 'destinations.edit', 'destinations.delete',
                    'hotels.view', 'hotels.create', 'hotels.edit', 'hotels.delete',
                    'itineraries.view', 'itineraries.create', 'itineraries.edit', 'itineraries.delete',
                    'reviews.view', 'reviews.create', 'reviews.edit', 'reviews.delete', 'reviews.approve',
                    'pages.view', 'pages.create', 'pages.edit', 'pages.delete',
                    'news.view', 'news.create', 'news.edit', 'news.delete',
                    'galleries.view', 'galleries.create', 'galleries.edit', 'galleries.delete',
                    'roles.view', 'roles.create', 'roles.edit', 'roles.delete',
                    'settings.view', 'settings.edit',
                    'payments.view', 'payments.manage'
                ]),
                'status' => 'active'
            ],
            [
                'name' => 'manager',
                'description' => 'Content manager with limited administrative access',
                'permissions' => json_encode([
                    'users.view', 'users.edit',
                    'destinations.view', 'destinations.edit',
                    'hotels.view', 'hotels.edit',
                    'itineraries.view', 'itineraries.create', 'itineraries.edit',
                    'reviews.view', 'reviews.approve',
                    'pages.view', 'pages.edit',
                    'news.view', 'news.create', 'news.edit',
                    'galleries.view', 'galleries.create', 'galleries.edit'
                ]),
                'status' => 'active'
            ],
            [
                'name' => 'user',
                'description' => 'Regular user with basic access to personal features',
                'permissions' => json_encode([
                    'reviews.create'
                ]),
                'status' => 'active'
            ]
        ];

        foreach ($roles as $roleData) {
            $existingRole = $roleModel->where('name', $roleData['name'])->first();
            if ($existingRole) {
                $roleModel->update($existingRole['id'], [
                    'description' => $roleData['description'],
                    'permissions' => $roleData['permissions'],
                    'status' => $roleData['status']
                ]);
            }
        }
    }
}
