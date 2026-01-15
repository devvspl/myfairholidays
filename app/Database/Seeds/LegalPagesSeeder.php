<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LegalPagesSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Create Terms of Service table
        $this->createTermsOfServiceTable($db);
        
        // Create Privacy Policy table
        $this->createPrivacyPolicyTable($db);
        
        echo "Legal pages tables created and seeded successfully!\n";
    }
    
    private function createTermsOfServiceTable($db)
    {
        // Drop table if exists
        $db->query("DROP TABLE IF EXISTS terms_of_service");
        
        // Create table
        $sql = "CREATE TABLE terms_of_service (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            title VARCHAR(255) DEFAULT 'Terms of Service',
            content LONGTEXT NOT NULL,
            meta_title VARCHAR(255) NULL,
            meta_description TEXT NULL,
            meta_keywords TEXT NULL,
            status ENUM('active', 'inactive') DEFAULT 'active',
            created_at DATETIME NULL,
            updated_at DATETIME NULL,
            PRIMARY KEY (id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
        
        $db->query($sql);
        
        // Insert default content
        $content = '<div class="terms-content">
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
        
        $db->table('terms_of_service')->insert([
            'title' => 'Terms of Service',
            'content' => $content,
            'meta_title' => 'Terms of Service - My Fair Holidays',
            'meta_description' => 'Read the terms of service for My Fair Holidays - Best Travel Agency in Noida. Understand our policies and guidelines.',
            'meta_keywords' => 'terms of service, terms and conditions, policies, my fair holidays',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        echo "Terms of Service table created and seeded.\n";
    }
    
    private function createPrivacyPolicyTable($db)
    {
        // Drop table if exists
        $db->query("DROP TABLE IF EXISTS privacy_policy");
        
        // Create table
        $sql = "CREATE TABLE privacy_policy (
            id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            title VARCHAR(255) DEFAULT 'Privacy Policy',
            content LONGTEXT NOT NULL,
            meta_title VARCHAR(255) NULL,
            meta_description TEXT NULL,
            meta_keywords TEXT NULL,
            status ENUM('active', 'inactive') DEFAULT 'active',
            created_at DATETIME NULL,
            updated_at DATETIME NULL,
            PRIMARY KEY (id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
        
        $db->query($sql);
        
        // Insert default content
        $content = '<div class="privacy-content">
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
        
        $db->table('privacy_policy')->insert([
            'title' => 'Privacy Policy',
            'content' => $content,
            'meta_title' => 'Privacy Policy - My Fair Holidays',
            'meta_description' => 'Read the privacy policy of My Fair Holidays - Best Travel Agency in Noida. Learn how we protect your personal information.',
            'meta_keywords' => 'privacy policy, data protection, personal information, my fair holidays',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        echo "Privacy Policy table created and seeded.\n";
    }
}
