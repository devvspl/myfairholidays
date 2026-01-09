<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ItineraryCategoriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Honeymoon Packages',
                'slug' => 'honeymoon-packages',
                'description' => 'Romantic getaways and intimate experiences for newlyweds and couples seeking memorable moments together.',
                'image' => 'uploads/categories/honeymoon.jpg',
                'status' => 'active',
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Family Tours',
                'slug' => 'family-tours',
                'description' => 'Fun-filled family vacations with activities suitable for all ages, creating lasting memories for the whole family.',
                'image' => 'uploads/categories/family.jpg',
                'status' => 'active',
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Adventure Tours',
                'slug' => 'adventure-tours',
                'description' => 'Thrilling adventures for adrenaline seekers including trekking, rafting, mountaineering, and extreme sports.',
                'image' => 'uploads/categories/adventure.jpg',
                'status' => 'active',
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Spiritual Tours',
                'slug' => 'spiritual-tours',
                'description' => 'Sacred journeys and pilgrimage tours to holy destinations for spiritual awakening and inner peace.',
                'image' => 'uploads/categories/spiritual.jpg',
                'status' => 'active',
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Beach Holidays',
                'slug' => 'beach-holidays',
                'description' => 'Relaxing beach vacations with sun, sand, and sea for the perfect tropical getaway experience.',
                'image' => 'uploads/categories/beach.jpg',
                'status' => 'active',
                'sort_order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Hill Station Tours',
                'slug' => 'hill-station-tours',
                'description' => 'Scenic mountain retreats and hill station getaways for cool weather and breathtaking landscapes.',
                'image' => 'uploads/categories/hills.jpg',
                'status' => 'active',
                'sort_order' => 6,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Wildlife Safari',
                'slug' => 'wildlife-safari',
                'description' => 'Exciting wildlife experiences and jungle safaris to observe animals in their natural habitat.',
                'image' => 'uploads/categories/wildlife.jpg',
                'status' => 'active',
                'sort_order' => 7,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Cultural Tours',
                'slug' => 'cultural-tours',
                'description' => 'Immersive cultural experiences exploring heritage, traditions, arts, and local customs.',
                'image' => 'uploads/categories/cultural.jpg',
                'status' => 'active',
                'sort_order' => 8,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Luxury Tours',
                'slug' => 'luxury-tours',
                'description' => 'Premium luxury travel experiences with finest accommodations, dining, and exclusive services.',
                'image' => 'uploads/categories/luxury.jpg',
                'status' => 'active',
                'sort_order' => 9,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Budget Tours',
                'slug' => 'budget-tours',
                'description' => 'Affordable travel packages offering great value without compromising on experience and quality.',
                'image' => 'uploads/categories/budget.jpg',
                'status' => 'active',
                'sort_order' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Group Tours',
                'slug' => 'group-tours',
                'description' => 'Social travel experiences for groups, corporate outings, and community trips with shared adventures.',
                'image' => 'uploads/categories/group.jpg',
                'status' => 'active',
                'sort_order' => 11,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Solo Travel',
                'slug' => 'solo-travel',
                'description' => 'Independent travel packages designed for solo travelers seeking self-discovery and personal adventures.',
                'image' => 'uploads/categories/solo.jpg',
                'status' => 'active',
                'sort_order' => 12,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('itinerary_categories')->insertBatch($data);
    }
}