<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DestinationTypesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Domestic Destinations',
                'slug' => 'domestic-destinations',
                'description' => 'Explore the incredible diversity of India with our domestic travel packages',
                'content' => '<h2>Discover India\'s Hidden Gems</h2><p>From the snow-capped peaks of the Himalayas to the pristine beaches of the south, India offers an unparalleled variety of destinations. Our domestic packages are carefully crafted to showcase the rich cultural heritage, natural beauty, and spiritual essence of incredible India.</p>',
                'icon' => 'fas fa-flag',
                'color' => '#FF6B35',
                'status' => 'active',
                'sort_order' => 1,
                'meta_title' => 'Domestic India Travel Packages | Explore Incredible India',
                'meta_description' => 'Discover amazing domestic destinations across India. From Kashmir to Kerala, experience the diversity of Indian culture, cuisine, and landscapes.'
            ],
            [
                'name' => 'International Destinations',
                'slug' => 'international-destinations',
                'description' => 'Discover amazing international destinations across the globe',
                'content' => '<h2>Explore the World Beyond Borders</h2><p>Embark on extraordinary journeys to some of the world\'s most captivating destinations. From the tropical paradise of Bali to the modern marvels of Dubai, our international packages offer unforgettable experiences across continents.</p>',
                'icon' => 'fas fa-globe-asia',
                'color' => '#4ECDC4',
                'status' => 'active',
                'sort_order' => 2,
                'meta_title' => 'International Travel Packages | World Destinations',
                'meta_description' => 'Explore international destinations with our curated travel packages. Visit Europe, Asia, and more with expert guidance and premium services.'
            ],
            [
                'name' => 'Adventure Tourism',
                'slug' => 'adventure-tourism',
                'description' => 'Thrilling adventure experiences for adrenaline seekers',
                'content' => '<h2>Adventure Awaits</h2><p>For those who seek excitement and challenge, our adventure tourism packages offer heart-pumping experiences. From trekking in the Himalayas to white-water rafting, create memories that will last a lifetime.</p>',
                'icon' => 'fas fa-mountain',
                'color' => '#45B7D1',
                'status' => 'active',
                'sort_order' => 3,
                'meta_title' => 'Adventure Tourism Packages | Thrilling Experiences',
                'meta_description' => 'Experience adventure tourism with our exciting packages. Trekking, rafting, mountaineering, and more adventure activities await.'
            ],
            [
                'name' => 'Spiritual Tourism',
                'slug' => 'spiritual-tourism',
                'description' => 'Sacred journeys and spiritual experiences across holy destinations',
                'content' => '<h2>Journey to Spiritual Enlightenment</h2><p>Discover inner peace and spiritual awakening through our carefully curated pilgrimage and spiritual tourism packages. Visit ancient temples, sacred sites, and experience the divine essence of spirituality.</p>',
                'icon' => 'fas fa-om',
                'color' => '#F7931E',
                'status' => 'active',
                'sort_order' => 4,
                'meta_title' => 'Spiritual Tourism | Pilgrimage Packages India',
                'meta_description' => 'Embark on spiritual journeys to sacred destinations. Visit Jyotirlingas, holy temples, and experience divine spirituality.'
            ],
            [
                'name' => 'Beach Destinations',
                'slug' => 'beach-destinations',
                'description' => 'Pristine beaches and coastal paradises for relaxation',
                'content' => '<h2>Tropical Paradise Awaits</h2><p>Escape to pristine beaches and coastal havens where crystal-clear waters meet golden sands. Our beach destination packages offer the perfect blend of relaxation, water sports, and tropical luxury.</p>',
                'icon' => 'fas fa-umbrella-beach',
                'color' => '#00D4AA',
                'status' => 'active',
                'sort_order' => 5,
                'meta_title' => 'Beach Destinations | Coastal Tourism Packages',
                'meta_description' => 'Relax at beautiful beach destinations. From Goa to Andaman, enjoy pristine beaches, water sports, and coastal luxury.'
            ],
            [
                'name' => 'Hill Stations',
                'slug' => 'hill-stations',
                'description' => 'Serene hill stations and mountain retreats for peaceful getaways',
                'content' => '<h2>Mountain Serenity</h2><p>Escape to the cool, refreshing air of hill stations where misty mountains and lush valleys create the perfect backdrop for a peaceful retreat. Experience nature\'s tranquility in these scenic mountain destinations.</p>',
                'icon' => 'fas fa-mountain',
                'color' => '#96CEB4',
                'status' => 'active',
                'sort_order' => 6,
                'meta_title' => 'Hill Station Packages | Mountain Tourism',
                'meta_description' => 'Discover serene hill stations and mountain retreats. From Himachal to Uttarakhand, enjoy cool climate and scenic beauty.'
            ]
        ];

        $this->db->table('destination_types')->insertBatch($data);
    }
}
