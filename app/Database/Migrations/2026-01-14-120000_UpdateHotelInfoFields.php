<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateHotelInfoFields extends Migration
{
    public function up()
    {
        // Add new dining_entertainment field
        $this->forge->addColumn('hotels', [
            'dining_entertainment' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'transportation_info'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('hotels', 'dining_entertainment');
    }
}
