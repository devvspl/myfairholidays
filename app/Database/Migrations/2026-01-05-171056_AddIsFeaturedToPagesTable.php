<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsFeaturedToPagesTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pages', [
            'is_featured' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null' => false,
                'after' => 'status'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pages', 'is_featured');
    }
}
