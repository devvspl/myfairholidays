<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDiscountFieldsToHotels extends Migration
{
    public function up()
    {
        $this->forge->addColumn('hotels', [
            'discount_type' => [
                'type' => 'ENUM',
                'constraint' => ['none', 'percentage', 'fixed'],
                'default' => 'none',
                'null' => false,
                'after' => 'price_per_night'
            ],
            'discount_value' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
                'null' => false,
                'after' => 'discount_type'
            ],
            'discount_start_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'discount_value'
            ],
            'discount_end_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'discount_start_date'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('hotels', [
            'discount_type',
            'discount_value',
            'discount_start_date',
            'discount_end_date'
        ]);
    }
}
