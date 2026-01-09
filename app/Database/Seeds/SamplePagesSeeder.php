<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SamplePagesSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            [
                'title' => 'Welcome to Our Travel Agency',
                'slug' => 'home',
                'content' => '<h1>Welcome to Our Travel Agency</h1>
                <p>Discover amazing destinations and create unforgettable memories with our expertly crafted travel packages.</p>
                <h2>Why Choose Us?</h2>
                <ul>
                    <li>Expert travel consultants</li>
                    <li>Customized itineraries</li>
                    <li>24/7 customer support</li>
                    <li>Best price guarantee</li>
                </ul>',
                'excerpt' => 'Discover amazing destinations and create unforgettable memories with our expertly crafted travel packages.',
                'template' => 'default',
                'status' => 'published',
                'is_homepage' => 1,
                'show_in_menu' => 1,
                'menu_order' => 1,
                'meta_title' => 'Welcome to Our Travel Agency - Best Travel Deals',
                'meta_description' => 'Discover amazing destinations with our travel agency. Expert consultants, customized itineraries, and best price guarantee.',
                'meta_keywords' => 'travel, vacation, destinations, travel agency, tours',
                'author_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'About Us',
                'slug' => 'about',
                'content' => '<h1>About Our Travel Agency</h1>
                <p>With over 20 years of experience in the travel industry, we have been helping travelers explore the world and create lasting memories.</p>
                <h2>Our Mission</h2>
                <p>To provide exceptional travel experiences that exceed our customers\' expectations while ensuring their safety and comfort throughout their journey.</p>
                <h2>Our Team</h2>
                <p>Our team consists of experienced travel professionals who are passionate about helping you discover new destinations and cultures.</p>',
                'excerpt' => 'Learn about our 20+ years of experience in creating exceptional travel experiences.',
                'template' => 'default',
                'status' => 'published',
                'is_homepage' => 0,
                'show_in_menu' => 1,
                'menu_order' => 2,
                'meta_title' => 'About Us - Your Trusted Travel Partner',
                'meta_description' => 'Learn about our travel agency with 20+ years of experience in creating exceptional travel experiences.',
                'meta_keywords' => 'about, travel agency, experience, team, mission',
                'author_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Our Services',
                'slug' => 'services',
                'content' => '<h1>Our Travel Services</h1>
                <div class="row">
                    <div class="col-md-6">
                        <h3>Package Tours</h3>
                        <p>Pre-designed tours to popular destinations with everything included.</p>
                    </div>
                    <div class="col-md-6">
                        <h3>Custom Itineraries</h3>
                        <p>Personalized travel plans tailored to your preferences and budget.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h3>Hotel Bookings</h3>
                        <p>Access to exclusive rates at hotels worldwide.</p>
                    </div>
                    <div class="col-md-6">
                        <h3>Travel Insurance</h3>
                        <p>Comprehensive coverage for peace of mind during your travels.</p>
                    </div>
                </div>',
                'excerpt' => 'Explore our comprehensive travel services including package tours, custom itineraries, and more.',
                'template' => 'default',
                'status' => 'published',
                'is_homepage' => 0,
                'show_in_menu' => 1,
                'menu_order' => 3,
                'meta_title' => 'Our Travel Services - Package Tours & Custom Itineraries',
                'meta_description' => 'Explore our comprehensive travel services including package tours, custom itineraries, hotel bookings, and travel insurance.',
                'meta_keywords' => 'services, package tours, custom itineraries, hotel bookings, travel insurance',
                'author_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'content' => '<h1>Contact Us</h1>
                <div class="row">
                    <div class="col-md-6">
                        <h3>Get in Touch</h3>
                        <p>Ready to plan your next adventure? Contact our travel experts today!</p>
                        <ul class="list-unstyled">
                            <li><strong>Phone:</strong> +1 (555) 123-4567</li>
                            <li><strong>Email:</strong> info@travelagency.com</li>
                            <li><strong>Address:</strong> 123 Travel Street, City, State 12345</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h3>Office Hours</h3>
                        <ul class="list-unstyled">
                            <li><strong>Monday - Friday:</strong> 9:00 AM - 6:00 PM</li>
                            <li><strong>Saturday:</strong> 10:00 AM - 4:00 PM</li>
                            <li><strong>Sunday:</strong> Closed</li>
                        </ul>
                    </div>
                </div>',
                'excerpt' => 'Get in touch with our travel experts to plan your next adventure.',
                'template' => 'contact',
                'status' => 'published',
                'is_homepage' => 0,
                'show_in_menu' => 1,
                'menu_order' => 4,
                'meta_title' => 'Contact Us - Plan Your Next Adventure',
                'meta_description' => 'Contact our travel experts to plan your next adventure. Phone, email, and office hours information.',
                'meta_keywords' => 'contact, travel experts, phone, email, office hours',
                'author_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h1>Privacy Policy</h1>
                <p><em>Last updated: ' . date('F j, Y') . '</em></p>
                <h2>Information We Collect</h2>
                <p>We collect information you provide directly to us, such as when you create an account, make a booking, or contact us.</p>
                <h2>How We Use Your Information</h2>
                <p>We use the information we collect to provide, maintain, and improve our services, process transactions, and communicate with you.</p>
                <h2>Information Sharing</h2>
                <p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy.</p>
                <h2>Contact Us</h2>
                <p>If you have any questions about this Privacy Policy, please contact us at privacy@travelagency.com.</p>',
                'excerpt' => 'Learn about how we collect, use, and protect your personal information.',
                'template' => 'default',
                'status' => 'published',
                'is_homepage' => 0,
                'show_in_menu' => 0,
                'menu_order' => 0,
                'meta_title' => 'Privacy Policy - How We Protect Your Information',
                'meta_description' => 'Learn about how we collect, use, and protect your personal information in our privacy policy.',
                'meta_keywords' => 'privacy policy, personal information, data protection',
                'author_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert pages
        foreach ($pages as $page) {
            $this->db->table('pages')->insert($page);
        }
    }
}