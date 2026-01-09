<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSampleHotelImages extends Migration
{
    public function up()
    {
        // Add sample images for hotel ID 8 (Burj Al Arab)
        $data = [
            [
                'hotel_id' => 8,
                'image_path' => 'uploads/hotels/gallery/sample1.jpg',
                'alt_text' => 'Burj Al Arab Exterior View',
                'caption' => 'Iconic sail-shaped architecture of Burj Al Arab',
                'sort_order' => 1,
                'is_featured' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'hotel_id' => 8,
                'image_path' => 'uploads/hotels/gallery/sample2.jpg',
                'alt_text' => 'Luxury Suite Interior',
                'caption' => 'Opulent suite with panoramic views',
                'sort_order' => 2,
                'is_featured' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'hotel_id' => 8,
                'image_path' => 'uploads/hotels/gallery/sample3.jpg',
                'alt_text' => 'Royal Suite Living Room',
                'caption' => 'Lavish living area with gold accents',
                'sort_order' => 3,
                'is_featured' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'hotel_id' => 8,
                'image_path' => 'uploads/hotels/gallery/sample4.jpg',
                'alt_text' => 'Spa and Wellness Center',
                'caption' => 'World-class spa facilities',
                'sort_order' => 4,
                'is_featured' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'hotel_id' => 8,
                'image_path' => 'uploads/hotels/gallery/sample5.jpg',
                'alt_text' => 'Fine Dining Restaurant',
                'caption' => 'Michelin-starred dining experience',
                'sort_order' => 5,
                'is_featured' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('hotel_images')->insertBatch($data);
    }

    public function down()
    {
        // Remove sample images for hotel ID 8
        $this->db->table('hotel_images')->where('hotel_id', 8)->delete();
    }
}
