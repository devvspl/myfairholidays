<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemovePermissionsFromRolesTable extends Migration
{
    public function up()
    {
        // Remove the permissions column from roles table
        $this->forge->dropColumn('roles', 'permissions');
    }

    public function down()
    {
        // Add back the permissions column if needed
        $fields = [
            'permissions' => [
                'type' => 'JSON',
                'null' => true,
                'after' => 'description'
            ]
        ];
        
        $this->forge->addColumn('roles', $fields);
    }
}
