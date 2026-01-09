<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // User Management
            [
                'name' => 'users.view',
                'display_name' => 'View Users',
                'description' => 'Can view user listings and profiles',
                'category' => 'users'
            ],
            [
                'name' => 'users.create',
                'display_name' => 'Create Users',
                'description' => 'Can create new user accounts',
                'category' => 'users'
            ],
            [
                'name' => 'users.edit',
                'display_name' => 'Edit Users',
                'description' => 'Can edit user information and profiles',
                'category' => 'users'
            ],
            [
                'name' => 'users.delete',
                'display_name' => 'Delete Users',
                'description' => 'Can delete user accounts',
                'category' => 'users'
            ],
            [
                'name' => 'users.manage_status',
                'display_name' => 'Manage User Status',
                'description' => 'Can activate/deactivate user accounts',
                'category' => 'users'
            ],

            // Role Management
            [
                'name' => 'roles.view',
                'display_name' => 'View Roles',
                'description' => 'Can view role listings',
                'category' => 'roles'
            ],
            [
                'name' => 'roles.create',
                'display_name' => 'Create Roles',
                'description' => 'Can create new roles',
                'category' => 'roles'
            ],
            [
                'name' => 'roles.edit',
                'display_name' => 'Edit Roles',
                'description' => 'Can edit role information',
                'category' => 'roles'
            ],
            [
                'name' => 'roles.delete',
                'display_name' => 'Delete Roles',
                'description' => 'Can delete roles',
                'category' => 'roles'
            ],
            [
                'name' => 'roles.assign_permissions',
                'display_name' => 'Assign Permissions',
                'description' => 'Can assign permissions to roles',
                'category' => 'roles'
            ],

            // Destinations Management
            [
                'name' => 'destinations.view',
                'display_name' => 'View Destinations',
                'description' => 'Can view destination listings',
                'category' => 'destinations'
            ],
            [
                'name' => 'destinations.create',
                'display_name' => 'Create Destinations',
                'description' => 'Can create new destinations',
                'category' => 'destinations'
            ],
            [
                'name' => 'destinations.edit',
                'display_name' => 'Edit Destinations',
                'description' => 'Can edit destination information',
                'category' => 'destinations'
            ],
            [
                'name' => 'destinations.delete',
                'display_name' => 'Delete Destinations',
                'description' => 'Can delete destinations',
                'category' => 'destinations'
            ],

            // Hotels Management
            [
                'name' => 'hotels.view',
                'display_name' => 'View Hotels',
                'description' => 'Can view hotel listings',
                'category' => 'hotels'
            ],
            [
                'name' => 'hotels.create',
                'display_name' => 'Create Hotels',
                'description' => 'Can create new hotels',
                'category' => 'hotels'
            ],
            [
                'name' => 'hotels.edit',
                'display_name' => 'Edit Hotels',
                'description' => 'Can edit hotel information',
                'category' => 'hotels'
            ],
            [
                'name' => 'hotels.delete',
                'display_name' => 'Delete Hotels',
                'description' => 'Can delete hotels',
                'category' => 'hotels'
            ],

            // Itineraries Management
            [
                'name' => 'itineraries.view',
                'display_name' => 'View Itineraries',
                'description' => 'Can view itinerary listings',
                'category' => 'itineraries'
            ],
            [
                'name' => 'itineraries.create',
                'display_name' => 'Create Itineraries',
                'description' => 'Can create new itineraries',
                'category' => 'itineraries'
            ],
            [
                'name' => 'itineraries.edit',
                'display_name' => 'Edit Itineraries',
                'description' => 'Can edit itinerary information',
                'category' => 'itineraries'
            ],
            [
                'name' => 'itineraries.delete',
                'display_name' => 'Delete Itineraries',
                'description' => 'Can delete itineraries',
                'category' => 'itineraries'
            ],

            // Reviews Management
            [
                'name' => 'reviews.view',
                'display_name' => 'View Reviews',
                'description' => 'Can view review listings',
                'category' => 'reviews'
            ],
            [
                'name' => 'reviews.create',
                'display_name' => 'Create Reviews',
                'description' => 'Can create new reviews',
                'category' => 'reviews'
            ],
            [
                'name' => 'reviews.edit',
                'display_name' => 'Edit Reviews',
                'description' => 'Can edit review information',
                'category' => 'reviews'
            ],
            [
                'name' => 'reviews.delete',
                'display_name' => 'Delete Reviews',
                'description' => 'Can delete reviews',
                'category' => 'reviews'
            ],
            [
                'name' => 'reviews.approve',
                'display_name' => 'Approve Reviews',
                'description' => 'Can approve or reject reviews',
                'category' => 'reviews'
            ],

            // Content Management
            [
                'name' => 'pages.view',
                'display_name' => 'View Pages',
                'description' => 'Can view page listings',
                'category' => 'content'
            ],
            [
                'name' => 'pages.create',
                'display_name' => 'Create Pages',
                'description' => 'Can create new pages',
                'category' => 'content'
            ],
            [
                'name' => 'pages.edit',
                'display_name' => 'Edit Pages',
                'description' => 'Can edit page content',
                'category' => 'content'
            ],
            [
                'name' => 'pages.delete',
                'display_name' => 'Delete Pages',
                'description' => 'Can delete pages',
                'category' => 'content'
            ],
            [
                'name' => 'news.view',
                'display_name' => 'View News',
                'description' => 'Can view news listings',
                'category' => 'content'
            ],
            [
                'name' => 'news.create',
                'display_name' => 'Create News',
                'description' => 'Can create new news articles',
                'category' => 'content'
            ],
            [
                'name' => 'news.edit',
                'display_name' => 'Edit News',
                'description' => 'Can edit news articles',
                'category' => 'content'
            ],
            [
                'name' => 'news.delete',
                'display_name' => 'Delete News',
                'description' => 'Can delete news articles',
                'category' => 'content'
            ],

            // Media Management
            [
                'name' => 'galleries.view',
                'display_name' => 'View Galleries',
                'description' => 'Can view media galleries',
                'category' => 'media'
            ],
            [
                'name' => 'galleries.create',
                'display_name' => 'Create Galleries',
                'description' => 'Can create new galleries',
                'category' => 'media'
            ],
            [
                'name' => 'galleries.edit',
                'display_name' => 'Edit Galleries',
                'description' => 'Can edit gallery content',
                'category' => 'media'
            ],
            [
                'name' => 'galleries.delete',
                'display_name' => 'Delete Galleries',
                'description' => 'Can delete galleries',
                'category' => 'media'
            ],

            // SEO Management
            [
                'name' => 'seo.view',
                'display_name' => 'View SEO Settings',
                'description' => 'Can view SEO meta tags and settings',
                'category' => 'seo'
            ],
            [
                'name' => 'seo.manage',
                'display_name' => 'Manage SEO',
                'description' => 'Can manage SEO meta tags and settings',
                'category' => 'seo'
            ],

            // Payment Management
            [
                'name' => 'payments.view',
                'display_name' => 'View Payments',
                'description' => 'Can view payment history and transactions',
                'category' => 'payments'
            ],
            [
                'name' => 'payments.manage',
                'display_name' => 'Manage Payments',
                'description' => 'Can process refunds and manage payments',
                'category' => 'payments'
            ],

            // System Settings
            [
                'name' => 'settings.view',
                'display_name' => 'View Settings',
                'description' => 'Can view system settings',
                'category' => 'system'
            ],
            [
                'name' => 'settings.edit',
                'display_name' => 'Edit Settings',
                'description' => 'Can edit system settings',
                'category' => 'system'
            ],
            [
                'name' => 'logs.view',
                'display_name' => 'View Logs',
                'description' => 'Can view system activity logs',
                'category' => 'system'
            ],

            // Dashboard
            [
                'name' => 'dashboard.view',
                'display_name' => 'View Dashboard',
                'description' => 'Can access admin dashboard',
                'category' => 'dashboard'
            ],
        ];

        // Insert permissions
        foreach ($permissions as $permission) {
            $permission['created_at'] = date('Y-m-d H:i:s');
            $this->db->table('permissions')->insert($permission);
        }
    }
}
