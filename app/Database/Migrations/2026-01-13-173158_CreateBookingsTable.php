<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBookingsTable extends Migration
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
            'booking_reference' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,
            ],
            'hotel_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'customer_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'customer_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'customer_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'check_in_date' => [
                'type' => 'DATE',
            ],
            'check_out_date' => [
                'type' => 'DATE',
            ],
            'nights' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
            ],
            'rooms' => [
                'type'       => 'INT',
                'constraint' => 2,
                'unsigned'   => true,
                'default'    => 1,
            ],
            'adults' => [
                'type'       => 'INT',
                'constraint' => 2,
                'unsigned'   => true,
                'default'    => 1,
            ],
            'children' => [
                'type'       => 'INT',
                'constraint' => 2,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'infants' => [
                'type'       => 'INT',
                'constraint' => 2,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'guest_details' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'special_requests' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'base_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'unsigned'   => true,
            ],
            'discount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'unsigned'   => true,
                'default'    => 0.00,
            ],
            'taxes' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'unsigned'   => true,
                'default'    => 0.00,
            ],
            'total_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'unsigned'   => true,
            ],
            'payment_status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'paid', 'failed', 'refunded'],
                'default'    => 'pending',
            ],
            'booking_status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'confirmed', 'cancelled', 'completed'],
                'default'    => 'pending',
            ],
            'billing_details' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'payment_method' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'payment_reference' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'confirmed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'cancelled_at' => [
                'type' => 'DATETIME',
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
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('booking_reference');
        $this->forge->addKey('hotel_id');
        $this->forge->addKey('customer_email');
        $this->forge->addKey('booking_status');
        $this->forge->addKey('payment_status');
        $this->forge->addKey('created_at');

        // Foreign key constraint
        $this->forge->addForeignKey('hotel_id', 'hotels', 'id', 'CASCADE', 'RESTRICT');

        $this->forge->createTable('bookings');
    }

    public function down()
    {
        $this->forge->dropTable('bookings');
    }
}
