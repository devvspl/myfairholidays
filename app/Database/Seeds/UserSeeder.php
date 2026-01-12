<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Get role IDs
        $adminRole = $this->db->table('roles')->where('name', 'admin')->get()->getRowArray();
        $managerRole = $this->db->table('roles')->where('name', 'manager')->get()->getRowArray();
        $userRole = $this->db->table('roles')->where('name', 'user')->get()->getRowArray();
        $agentRole = $this->db->table('roles')->where('name', 'agent')->get()->getRowArray();
        
        if (!$adminRole) {
            echo "Admin role not found. Please run RoleSeeder first.\n";
            return;
        }

        // Use agent role if user role doesn't exist
        $defaultUserRole = $userRole ?: $agentRole;
        
        if (!$defaultUserRole) {
            echo "No user or agent role found. Please run RoleSeeder first.\n";
            return;
        }

        $data = [
            [
                'name' => 'Admin User',
                'email' => 'admin@myfairholidays.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role_id' => $adminRole['id'],
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Add manager if role exists
        if ($managerRole) {
            $data[] = [
                'name' => 'Manager User',
                'email' => 'manager@myfairholidays.com',
                'password' => password_hash('manager123', PASSWORD_DEFAULT),
                'role_id' => $managerRole['id'],
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        // Add regular user/agent
        $data[] = [
            'name' => 'Test User',
            'email' => 'user@myfairholidays.com',
            'password' => password_hash('user123', PASSWORD_DEFAULT),
            'role_id' => $defaultUserRole['id'],
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Check if users already exist and insert if they don't
        foreach ($data as $user) {
            $existing = $this->db->table('users')->where('email', $user['email'])->get()->getRowArray();
            if (!$existing) {
                $this->db->table('users')->insert($user);
                echo "Created user: " . $user['email'] . " (Role: " . $this->getRoleName($user['role_id']) . ")\n";
            } else {
                echo "User already exists: " . $user['email'] . "\n";
            }
        }
        
        echo "UserSeeder completed successfully!\n";
    }
    
    private function getRoleName($roleId)
    {
        $role = $this->db->table('roles')->where('id', $roleId)->get()->getRowArray();
        return $role ? $role['name'] : 'unknown';
    }
}