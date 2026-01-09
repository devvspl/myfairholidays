<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ImageGallerySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Beautiful Sunset at Goa Beach',
                'description' => 'A stunning sunset view captured at one of Goa\'s pristine beaches during golden hour.',
                'image_path' => 'assets/images/small/img-1.jpg',
                'alt_text' => 'Golden sunset over Goa beach with palm trees silhouette',
                'sort_order' => 1,
                'is_homepage' => true,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Himalayan Mountain Range',
                'description' => 'Majestic snow-capped peaks of the Himalayas captured during a trekking expedition.',
                'image_path' => 'assets/images/small/img-2.jpg',
                'alt_text' => 'Snow-covered Himalayan mountain peaks against blue sky',
                'sort_order' => 2,
                'is_homepage' => true,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Kerala Backwaters',
                'description' => 'Serene backwaters of Kerala with traditional houseboats floating peacefully.',
                'image_path' => 'assets/images/small/img-3.jpg',
                'alt_text' => 'Traditional houseboat on Kerala backwaters surrounded by palm trees',
                'sort_order' => 3,
                'is_homepage' => true,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Rajasthan Desert Safari',
                'description' => 'Camel safari experience in the golden sands of Rajasthan\'s Thar Desert.',
                'image_path' => 'assets/images/small/img-4.jpg',
                'alt_text' => 'Camel caravan crossing sand dunes in Rajasthan desert',
                'sort_order' => 4,
                'is_homepage' => true,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Taj Mahal at Sunrise',
                'description' => 'The iconic Taj Mahal illuminated by the soft morning light at sunrise.',
                'image_path' => 'assets/images/small/img-5.jpg',
                'alt_text' => 'Taj Mahal monument at sunrise with reflection in water',
                'sort_order' => 5,
                'is_homepage' => true,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Ladakh Landscape',
                'description' => 'Breathtaking landscape of Ladakh with its unique terrain and Buddhist monasteries.',
                'image_path' => 'assets/images/small/img-6.jpg',
                'alt_text' => 'Ladakh mountain landscape with Buddhist monastery',
                'sort_order' => 6,
                'is_homepage' => false,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Andaman Islands Beach',
                'description' => 'Crystal clear turquoise waters and white sandy beaches of Andaman Islands.',
                'image_path' => 'assets/images/small/img-7.jpg',
                'alt_text' => 'Pristine white sand beach with turquoise water in Andaman Islands',
                'sort_order' => 7,
                'is_homepage' => false,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Kashmir Valley',
                'description' => 'Lush green valleys and snow-capped mountains of Kashmir, often called Paradise on Earth.',
                'image_path' => 'assets/images/small/img-8.jpg',
                'alt_text' => 'Green Kashmir valley with snow-capped mountains in background',
                'sort_order' => 8,
                'is_homepage' => false,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Bali Temple Complex',
                'description' => 'Ancient Hindu temple complex in Bali surrounded by tropical vegetation.',
                'image_path' => 'assets/images/small/img-9.jpg',
                'alt_text' => 'Traditional Balinese Hindu temple with ornate architecture',
                'sort_order' => 9,
                'is_homepage' => false,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Dubai Skyline',
                'description' => 'Modern Dubai skyline featuring the iconic Burj Khalifa and other skyscrapers.',
                'image_path' => 'assets/images/small/img-10.jpg',
                'alt_text' => 'Dubai city skyline with Burj Khalifa and modern skyscrapers',
                'sort_order' => 10,
                'is_homepage' => false,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Thailand Floating Market',
                'description' => 'Traditional floating market in Thailand with vendors selling fresh fruits and local goods.',
                'image_path' => 'assets/images/small/img-11.jpg',
                'alt_text' => 'Colorful floating market in Thailand with boats and vendors',
                'sort_order' => 11,
                'is_homepage' => false,
                'status' => 'inactive',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Singapore Marina Bay',
                'description' => 'Iconic Marina Bay Sands and Singapore skyline reflected in the bay waters.',
                'image_path' => 'assets/images/small/img-12.jpg',
                'alt_text' => 'Singapore Marina Bay Sands hotel and city skyline at night',
                'sort_order' => 12,
                'is_homepage' => false,
                'status' => 'inactive',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert data
        $this->db->table('image_gallery')->insertBatch($data);
        
        echo "Image Gallery seeder completed. Added " . count($data) . " sample images.\n";
    }
}