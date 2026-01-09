<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VideoGallerySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Incredible India Tourism Video',
                'description' => 'Official tourism video showcasing the diverse beauty and culture of India.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=Uy7rrrCQh2w',
                'video_id' => 'Uy7rrrCQh2w',
                'sort_order' => 1,
                'is_homepage' => true,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Kerala Backwaters Experience',
                'description' => 'A peaceful journey through the serene backwaters of Kerala with traditional houseboats.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'video_id' => 'dQw4w9WgXcQ',
                'sort_order' => 2,
                'is_homepage' => true,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Rajasthan Desert Safari Adventure',
                'description' => 'Experience the golden sands of Rajasthan with camel safaris and desert camping.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
                'video_id' => '9bZkp7q19f0',
                'sort_order' => 3,
                'is_homepage' => true,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Himalayan Trekking Experience',
                'description' => 'Breathtaking views and challenging treks in the majestic Himalayan mountains.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk',
                'video_id' => 'kJQP7kiw5Fk',
                'sort_order' => 4,
                'is_homepage' => true,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Goa Beach Paradise',
                'description' => 'Stunning beaches, vibrant nightlife, and Portuguese heritage in Goa.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=L_jWHffIx5E',
                'video_id' => 'L_jWHffIx5E',
                'sort_order' => 5,
                'is_homepage' => true,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Andaman Islands Underwater World',
                'description' => 'Explore the crystal clear waters and marine life of Andaman Islands.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=ZZ5LpwO-An4',
                'video_id' => 'ZZ5LpwO-An4',
                'sort_order' => 6,
                'is_homepage' => false,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Kashmir Valley Beauty',
                'description' => 'The paradise on earth - Kashmir with its snow-capped mountains and valleys.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=HEXWRTEbj1I',
                'video_id' => 'HEXWRTEbj1I',
                'sort_order' => 7,
                'is_homepage' => false,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Dubai City Tour',
                'description' => 'Modern architecture, luxury shopping, and desert adventures in Dubai.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=SoccF0xXduI',
                'video_id' => 'SoccF0xXduI',
                'sort_order' => 8,
                'is_homepage' => false,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Thailand Cultural Experience',
                'description' => 'Temples, floating markets, and tropical beaches in beautiful Thailand.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=ctDjnG8J9cY',
                'video_id' => 'ctDjnG8J9cY',
                'sort_order' => 9,
                'is_homepage' => false,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Bali Temple and Nature Tour',
                'description' => 'Ancient temples, rice terraces, and volcanic landscapes in Bali.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=YQHsXMglC9A',
                'video_id' => 'YQHsXMglC9A',
                'sort_order' => 10,
                'is_homepage' => false,
                'status' => 'inactive',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert data
        $this->db->table('video_gallery')->insertBatch($data);
        
        echo "Video Gallery seeder completed. Added " . count($data) . " sample videos.\n";
    }
}