<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTermsOfServiceTable extends Migration
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
                'constraint' => '255',
                'default'    => 'Terms of Service',
            ],
            'content' => [
                'type' => 'LONGTEXT',
                'null' => false,
            ],
            'meta_title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'meta_description' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'meta_keywords' => [
                'type'       => 'TEXT',
                'null'       => true,
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
        $this->forge->createTable('terms_of_service');

        // Insert default content
        $this->db->table('terms_of_service')->insert([
            'title' => 'Terms of Service',
            'content' => $this->getDefaultContent(),
            'meta_title' => 'Terms of Service - My Fair Holidays',
            'meta_description' => 'Read the terms of service for My Fair Holidays - Best Travel Agency in Noida. Understand our policies and guidelines.',
            'meta_keywords' => 'terms of service, terms and conditions, policies, my fair holidays',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('terms_of_service');
    }

    private function getDefaultContent()
    {
        return '<div class="terms-content">
            <h2>1. Acceptance of Terms</h2>
            <p>By accessing and using My Fair Holidays services, you accept and agree to be bound by the terms and provision of this agreement.</p>
            
            <h2>2. Booking and Payment</h2>
            <p>All bookings are subject to availability and confirmation. Payment terms will be communicated at the time of booking.</p>
            
            <h2>3. Cancellation Policy</h2>
            <p>Cancellation policies vary by service provider and will be clearly communicated at the time of booking. Please review the specific cancellation terms for your booking.</p>
            
            <h2>4. Travel Documents</h2>
            <p>It is the responsibility of the traveler to ensure all necessary travel documents (passport, visa, etc.) are valid and in order.</p>
            
            <h2>5. Liability</h2>
            <p>My Fair Holidays acts as an intermediary between travelers and service providers. We are not liable for any loss, damage, or injury arising from services provided by third parties.</p>
            
            <h2>6. Changes to Terms</h2>
            <p>We reserve the right to modify these terms at any time. Continued use of our services constitutes acceptance of modified terms.</p>
            
            <h2>7. Contact Information</h2>
            <p>For questions about these terms, please contact us at info@myfairholidays.com or call +91-9971124567.</p>
        </div>';
    }
}
