<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateItinerariesTable extends Migration
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
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'LONGTEXT',
            ],
            'short_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'featured_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'destination_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'duration_days' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
            ],
            'duration_nights' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
            ],
            'discounted_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'inclusions' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'exclusions' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'itinerary_details' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'is_featured' => [
                'type'    => 'BOOLEAN',
                'default' => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['draft', 'published'],
                'default'    => 'draft',
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
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
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey('category_id');
        $this->forge->addKey('destination_id');
        $this->forge->addKey('status');
        $this->forge->addForeignKey('destination_id', 'destinations', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('itineraries');
    }

    public function down()
    {
        $this->forge->dropTable('itineraries');
    }
}