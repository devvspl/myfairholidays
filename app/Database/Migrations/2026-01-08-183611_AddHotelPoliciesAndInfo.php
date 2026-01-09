<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHotelPoliciesAndInfo extends Migration
{
    public function up()
    {
        $this->forge->addColumn('hotels', [
            'check_in_time' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'default' => '2:00 PM',
                'after' => 'website'
            ],
            'check_out_time' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'default' => '12:00 PM',
                'after' => 'check_in_time'
            ],
            'cancellation_policy' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'check_out_time'
            ],
            'hotel_policies' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'cancellation_policy'
            ],
            'nearby_attractions' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'hotel_policies'
            ],
            'transportation_info' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'nearby_attractions'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('hotels', [
            'check_in_time',
            'check_out_time', 
            'cancellation_policy',
            'hotel_policies',
            'nearby_attractions',
            'transportation_info'
        ]);
    }
}
