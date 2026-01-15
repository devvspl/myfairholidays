<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrivacyPolicyTable extends Migration
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
                'default'    => 'Privacy Policy',
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
        $this->forge->createTable('privacy_policy');

        // Insert default content
        $this->db->table('privacy_policy')->insert([
            'title' => 'Privacy Policy',
            'content' => $this->getDefaultContent(),
            'meta_title' => 'Privacy Policy - My Fair Holidays',
            'meta_description' => 'Read the privacy policy of My Fair Holidays - Best Travel Agency in Noida. Learn how we protect your personal information.',
            'meta_keywords' => 'privacy policy, data protection, personal information, my fair holidays',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('privacy_policy');
    }

    private function getDefaultContent()
    {
        return '<div class="privacy-content">
            <h2>1. Information We Collect</h2>
            <p>We collect information you provide directly to us, including name, email address, phone number, and payment information when you make a booking.</p>
            
            <h2>2. How We Use Your Information</h2>
            <p>We use the information we collect to:</p>
            <ul>
                <li>Process your bookings and payments</li>
                <li>Communicate with you about your travel arrangements</li>
                <li>Send you promotional materials (with your consent)</li>
                <li>Improve our services</li>
            </ul>
            
            <h2>3. Information Sharing</h2>
            <p>We share your information with service providers (hotels, airlines, etc.) necessary to fulfill your booking. We do not sell your personal information to third parties.</p>
            
            <h2>4. Data Security</h2>
            <p>We implement appropriate security measures to protect your personal information. However, no method of transmission over the internet is 100% secure.</p>
            
            <h2>5. Cookies</h2>
            <p>We use cookies to enhance your browsing experience and analyze site traffic. You can control cookie preferences through your browser settings.</p>
            
            <h2>6. Your Rights</h2>
            <p>You have the right to access, correct, or delete your personal information. Contact us to exercise these rights.</p>
            
            <h2>7. Changes to Privacy Policy</h2>
            <p>We may update this privacy policy from time to time. We will notify you of any changes by posting the new policy on this page.</p>
            
            <h2>8. Contact Us</h2>
            <p>If you have questions about this privacy policy, please contact us at info@myfairholidays.com or call +91-9971124567.</p>
        </div>';
    }
}
