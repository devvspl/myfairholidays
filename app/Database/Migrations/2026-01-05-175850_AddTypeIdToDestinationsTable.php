<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTypeIdToDestinationsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('destinations', [
            'type_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'type'
            ],
            'content' => [
                'type' => 'LONGTEXT',
                'null' => true,
                'after' => 'description'
            ]
        ]);

        // Add foreign key constraint
        $this->forge->addForeignKey('type_id', 'destination_types', 'id', 'CASCADE', 'SET NULL');
    }

    public function down()
    {
        $this->forge->dropForeignKey('destinations', 'destinations_type_id_foreign');
        $this->forge->dropColumn('destinations', ['type_id', 'content']);
    }
}
