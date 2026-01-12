<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContactSectionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'section_type' => [
                'type' => 'ENUM',
                'constraint' => ['hero', 'contact_info', 'form_settings'],
                'default' => 'contact_info',
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'subtitle' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'contact_type' => [
                'type' => 'ENUM',
                'constraint' => ['email', 'phone', 'address', 'website', 'social'],
                'null' => true,
            ],
            'contact_value' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'contact_link' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'background_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'map_embed_code' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('section_type');
        $this->forge->addKey('status');
        $this->forge->addKey('sort_order');
        $this->forge->createTable('contact_sections');
    }

    public function down()
    {
        $this->forge->dropTable('contact_sections');
    }
}