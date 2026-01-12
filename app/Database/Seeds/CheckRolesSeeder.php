<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CheckRolesSeeder extends Seeder
{
    public function run()
    {
        // Check if roles table exists and has data
        $roles = $this->db->table('roles')->get()->getResultArray();
        
        echo "Found " . count($roles) . " roles:\n";
        foreach ($roles as $role) {
            echo "- ID: {$role['id']}, Name: {$role['name']}\n";
        }
        
        // If no roles exist, create them
        if (empty($roles)) {
            echo "Creating default roles...\n";
            $defaultRoles = [
                [
                    'name' => 'admin',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'manager',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'user',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ];
            
            $this->db->table('roles')->insertBatch($defaultRoles);
            echo "Default roles created successfully!\n";
        }
    }
}