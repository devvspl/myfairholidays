<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TourismAlliancesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Incredible India',
                'logo' => 'main/images/Incredible_India_campaign_logo.png',
                'website_url' => 'https://www.incredibleindia.org',
                'type' => 'tourism_board',
                'is_circle_frame' => 1,
                'status' => 'active',
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'SpiceJet Airlines',
                'logo' => 'main/images/SpiceJet_logo.png',
                'website_url' => 'https://www.spicejet.com',
                'type' => 'airline',
                'is_circle_frame' => 0,
                'status' => 'active',
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Kerala Tourism',
                'logo' => 'main/images/logo-kerala.png',
                'website_url' => 'https://www.keralatourism.org',
                'type' => 'tourism_board',
                'is_circle_frame' => 0,
                'status' => 'active',
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Japan National Tourism Organization',
                'logo' => 'main/images/default-logo.png',
                'website_url' => 'https://www.jnto.go.jp',
                'type' => 'tourism_board',
                'is_circle_frame' => 0,
                'status' => 'active',
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Dubai Tourism',
                'logo' => 'main/images/images.jpg',
                'website_url' => 'https://www.visitdubai.com',
                'type' => 'tourism_board',
                'is_circle_frame' => 1,
                'status' => 'active',
                'sort_order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Travel Partner Network',
                'logo' => 'main/images/logo (1).png',
                'website_url' => 'https://www.travelpartners.com',
                'type' => 'travel_agency',
                'is_circle_frame' => 0,
                'status' => 'active',
                'sort_order' => 6,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Check if data already exists
        foreach ($data as $alliance) {
            $existing = $this->db->table('tourism_alliances')->where('name', $alliance['name'])->get()->getRowArray();
            if (!$existing) {
                $this->db->table('tourism_alliances')->insert($alliance);
                echo "Created tourism alliance: " . $alliance['name'] . "\n";
            } else {
                echo "Tourism alliance already exists: " . $alliance['name'] . "\n";
            }
        }
    }
}