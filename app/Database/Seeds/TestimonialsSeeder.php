<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestimonialsSeeder extends Seeder
{
    public function run()
    {
        // Get category and destination IDs
        $domesticCatId = $this->db->table('testimonial_categories')->where('slug', 'domestic-tours')->get()->getRow()->id ?? 1;
        $internationalCatId = $this->db->table('testimonial_categories')->where('slug', 'international-tours')->get()->getRow()->id ?? 2;
        $adventureCatId = $this->db->table('testimonial_categories')->where('slug', 'adventure-tours')->get()->getRow()->id ?? 3;
        $honeymoonCatId = $this->db->table('testimonial_categories')->where('slug', 'honeymoon-packages')->get()->getRow()->id ?? 4;
        $familyCatId = $this->db->table('testimonial_categories')->where('slug', 'family-tours')->get()->getRow()->id ?? 5;

        // Get some destination IDs
        $goaId = $this->db->table('destinations')->where('slug', 'goa')->get()->getRow()->id ?? null;
        $keralaId = $this->db->table('destinations')->where('slug', 'kerala')->get()->getRow()->id ?? null;
        $rajasthanId = $this->db->table('destinations')->where('slug', 'rajasthan')->get()->getRow()->id ?? null;
        $dubaiId = $this->db->table('destinations')->where('slug', 'dubai-uae')->get()->getRow()->id ?? null;
        $baliId = $this->db->table('destinations')->where('slug', 'bali-indonesia')->get()->getRow()->id ?? null;

        $data = [
            [
                'customer_name' => 'Priya Sharma',
                'customer_email' => 'priya.sharma@email.com',
                'customer_city' => 'Mumbai',
                'rating' => 5,
                'testimonial_text' => 'Amazing experience with MyFair Holidays! The Goa package was perfectly planned. Beautiful beaches, comfortable accommodation, and excellent service throughout the trip. Highly recommended for beach lovers!',
                'category_id' => $domesticCatId,
                'destination_id' => $goaId,
                'package_name' => 'Goa Beach Paradise - 4 Days',
                'travel_date' => '2024-12-15',
                'status' => 'approved',
                'is_featured' => 1,
                'sort_order' => 1
            ],
            [
                'customer_name' => 'Rajesh Kumar',
                'customer_email' => 'rajesh.kumar@email.com',
                'customer_city' => 'Delhi',
                'rating' => 5,
                'testimonial_text' => 'Kerala backwaters tour was absolutely magical! The houseboat experience, Ayurvedic treatments, and local cuisine were outstanding. MyFair Holidays made our honeymoon unforgettable.',
                'category_id' => $honeymoonCatId,
                'destination_id' => $keralaId,
                'package_name' => 'Kerala Honeymoon Special - 6 Days',
                'travel_date' => '2024-11-20',
                'status' => 'approved',
                'is_featured' => 1,
                'sort_order' => 2
            ],
            [
                'customer_name' => 'Amit Patel',
                'customer_email' => 'amit.patel@email.com',
                'customer_city' => 'Ahmedabad',
                'rating' => 4,
                'testimonial_text' => 'Rajasthan royal tour exceeded our expectations! The palaces, forts, and desert safari were incredible. Great organization and knowledgeable guides. A perfect family vacation.',
                'category_id' => $familyCatId,
                'destination_id' => $rajasthanId,
                'package_name' => 'Royal Rajasthan - 8 Days',
                'travel_date' => '2024-10-10',
                'status' => 'approved',
                'is_featured' => 0,
                'sort_order' => 3
            ],
            [
                'customer_name' => 'Sneha Gupta',
                'customer_email' => 'sneha.gupta@email.com',
                'customer_city' => 'Bangalore',
                'rating' => 5,
                'testimonial_text' => 'Dubai was a dream come true! From Burj Khalifa to desert safari, everything was perfectly arranged. The hotel was luxurious and the itinerary was well-planned. Thank you MyFair Holidays!',
                'category_id' => $internationalCatId,
                'destination_id' => $dubaiId,
                'package_name' => 'Dubai Luxury Experience - 5 Days',
                'travel_date' => '2024-12-01',
                'status' => 'approved',
                'is_featured' => 1,
                'sort_order' => 4
            ],
            [
                'customer_name' => 'Vikram Singh',
                'customer_email' => 'vikram.singh@email.com',
                'customer_city' => 'Pune',
                'rating' => 5,
                'testimonial_text' => 'Bali honeymoon package was absolutely perfect! Beautiful beaches, romantic dinners, and amazing spa treatments. The team took care of every detail. Highly recommend for couples!',
                'category_id' => $honeymoonCatId,
                'destination_id' => $baliId,
                'package_name' => 'Bali Romantic Getaway - 7 Days',
                'travel_date' => '2024-11-05',
                'status' => 'approved',
                'is_featured' => 1,
                'sort_order' => 5
            ],
            [
                'customer_name' => 'Meera Joshi',
                'customer_email' => 'meera.joshi@email.com',
                'customer_city' => 'Chennai',
                'rating' => 4,
                'testimonial_text' => 'Leh Ladakh adventure tour was thrilling! The landscapes were breathtaking and the adventure activities were well-organized. Great experience for adventure enthusiasts.',
                'category_id' => $adventureCatId,
                'destination_id' => null,
                'package_name' => 'Leh Ladakh Adventure - 10 Days',
                'travel_date' => '2024-09-15',
                'status' => 'approved',
                'is_featured' => 0,
                'sort_order' => 6
            ],
            [
                'customer_name' => 'Rohit Agarwal',
                'customer_email' => 'rohit.agarwal@email.com',
                'customer_city' => 'Kolkata',
                'rating' => 5,
                'testimonial_text' => 'Thailand tour was amazing! Bangkok, Phuket, and Pattaya - each destination was unique and beautiful. Excellent coordination and friendly guides throughout the journey.',
                'category_id' => $internationalCatId,
                'destination_id' => null,
                'package_name' => 'Thailand Explorer - 8 Days',
                'travel_date' => '2024-10-25',
                'status' => 'approved',
                'is_featured' => 0,
                'sort_order' => 7
            ],
            [
                'customer_name' => 'Kavya Reddy',
                'customer_email' => 'kavya.reddy@email.com',
                'customer_city' => 'Hyderabad',
                'rating' => 5,
                'testimonial_text' => 'Kashmir family tour was absolutely wonderful! The Dal Lake, Gulmarg, and Pahalgam were mesmerizing. Kids enjoyed every moment. Perfect family bonding experience.',
                'category_id' => $familyCatId,
                'destination_id' => null,
                'package_name' => 'Kashmir Paradise - 6 Days',
                'travel_date' => '2024-08-20',
                'status' => 'approved',
                'is_featured' => 0,
                'sort_order' => 8
            ],
            [
                'customer_name' => 'Arjun Malhotra',
                'customer_email' => 'arjun.malhotra@email.com',
                'customer_city' => 'Jaipur',
                'rating' => 4,
                'testimonial_text' => 'Singapore Malaysia combo was fantastic! Clean cities, great food, and amazing attractions. Universal Studios and Petronas Towers were highlights of the trip.',
                'category_id' => $internationalCatId,
                'destination_id' => null,
                'package_name' => 'Singapore Malaysia Combo - 7 Days',
                'travel_date' => '2024-12-10',
                'status' => 'approved',
                'is_featured' => 0,
                'sort_order' => 9
            ],
            [
                'customer_name' => 'Pooja Verma',
                'customer_email' => 'pooja.verma@email.com',
                'customer_city' => 'Lucknow',
                'rating' => 5,
                'testimonial_text' => 'Himachal Pradesh tour was refreshing! Manali, Shimla, and Dharamshala were beautiful. Perfect weather, scenic views, and comfortable stay. Great for nature lovers!',
                'category_id' => $domesticCatId,
                'destination_id' => null,
                'package_name' => 'Himachal Hill Stations - 7 Days',
                'travel_date' => '2024-09-05',
                'status' => 'approved',
                'is_featured' => 0,
                'sort_order' => 10
            ]
        ];

        $this->db->table('testimonials')->insertBatch($data);
    }
}
