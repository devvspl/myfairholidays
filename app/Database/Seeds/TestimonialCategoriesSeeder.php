<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestimonialCategoriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Domestic Tours',
                'slug' => 'domestic-tours',
                'description' => 'Testimonials from customers who traveled within India',
                'status' => 'active',
                'sort_order' => 1
            ],
            [
                'name' => 'International Tours',
                'slug' => 'international-tours',
                'description' => 'Testimonials from customers who traveled internationally',
                'status' => 'active',
                'sort_order' => 2
            ],
            [
                'name' => 'Adventure Tours',
                'slug' => 'adventure-tours',
                'description' => 'Testimonials from adventure and trekking experiences',
                'status' => 'active',
                'sort_order' => 3
            ],
            [
                'name' => 'Honeymoon Packages',
                'slug' => 'honeymoon-packages',
                'description' => 'Testimonials from couples on their honeymoon trips',
                'status' => 'active',
                'sort_order' => 4
            ],
            [
                'name' => 'Family Tours',
                'slug' => 'family-tours',
                'description' => 'Testimonials from families who traveled together',
                'status' => 'active',
                'sort_order' => 5
            ],
            [
                'name' => 'Corporate Tours',
                'slug' => 'corporate-tours',
                'description' => 'Testimonials from corporate and business travel',
                'status' => 'active',
                'sort_order' => 6
            ]
        ];

        $this->db->table('testimonial_categories')->insertBatch($data);
    }
}
