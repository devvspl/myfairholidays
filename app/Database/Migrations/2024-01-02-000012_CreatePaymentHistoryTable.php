<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentHistoryTable extends Migration
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
            'order_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'transaction_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'customer_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'customer_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'customer_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'itinerary_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'itinerary_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
            ],
            'currency' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'default'    => 'USD',
            ],
            'payment_gateway' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'payment_method' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'completed', 'failed', 'cancelled', 'refunded'],
                'default'    => 'pending',
            ],
            'gateway_response' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'payment_date' => [
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
        $this->forge->addUniqueKey('order_id');
        $this->forge->addKey('transaction_id');
        $this->forge->addKey('status');
        $this->forge->addKey('payment_date');
        $this->forge->addForeignKey('itinerary_id', 'itineraries', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('payment_history');
    }

    public function down()
    {
        $this->forge->dropTable('payment_history');
    }
}