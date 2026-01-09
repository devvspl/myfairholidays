<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Get admin role ID
        $adminRole = $this->db->table('roles')->where('name', 'admin')->get()->getRowArray();
        $userRole = $this->db->table('roles')->where('name', 'user')->get()->getRowArray();
        
        if (!$adminRole || !$userRole) {
            echo "Roles not found. Please run RoleSeeder first.\n";
            return;
        }

        $data = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role_id' => $adminRole['id'],
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Test User',
                'email' => 'user@example.com',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'role_id' => $userRole['id'],
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Check if users already exist
        foreach ($data as $user) {
            $existing = $this->db->table('users')->where('email', $user['email'])->get()->getRowArray();
            if (!$existing) {
                $this->db->table('users')->insert($user);
                echo "Created user: " . $user['email'] . "\n";
            } else {
                echo "User already exists: " . $user['email'] . "\n";
            }
        }
    }
}