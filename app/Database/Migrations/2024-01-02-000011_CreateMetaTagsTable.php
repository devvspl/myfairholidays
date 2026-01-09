<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMetaTagsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'page_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'page_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'meta_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'meta_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'meta_keywords' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'og_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'og_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'og_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'twitter_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'twitter_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'twitter_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'canonical_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'robots' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'index,follow',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
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
        $this->forge->addUniqueKey('page_url');
        $this->forge->addKey('status');
        $this->forge->createTable('meta_tags');
    }

    public function down()
    {
        $this->forge->dropTable('meta_tags');
    }
}