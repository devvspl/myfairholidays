<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnsToRolesTable extends Migration
{
    public function up()
    {
        // Add missing columns to roles table
        $fields = [
            'description' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'name'
            ],
            'permissions' => [
                'type' => 'JSON',
                'null' => true,
                'after' => 'description'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active',
                'after' => 'permissions'
            ]
        ];
        
        $this->forge->addColumn('roles', $fields);
    }

    public function down()
    {
        // Remove the added columns
        $this->forge->dropColumn('roles', ['description', 'permissions', 'status']);
    }
}
