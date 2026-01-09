<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserProfileFields extends Migration
{
    public function up()
    {
        $fields = [
            'bio' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'password'
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'bio'
            ],
            'department' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'phone'
            ],
            'profile_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'department'
            ],
            'email_verified' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'profile_image'
            ],
            'email_verified_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'email_verified'
            ],
            'last_login_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'email_verified_at'
            ]
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', [
            'bio',
            'phone', 
            'department',
            'profile_image',
            'email_verified',
            'email_verified_at',
            'last_login_at'
        ]);
    }
}