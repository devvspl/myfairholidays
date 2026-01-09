<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HotelsSeeder extends Seeder
{
    public function run()
    {
        // Get destination IDs for proper relationships
        $destinations = $this->db->table('destinations')->select('id, name, slug')->get()->getResultArray();
        $destinationMap = [];
        foreach ($destinations as $dest) {
            $destinationMap[$dest['slug']] = $dest['id'];
        }

        $data = [
            // Goa Hotels
            [
                'name' => 'The Leela Goa',
                'slug' => 'the-leela-goa',
                'description' => 'Luxury beachfront resort offering world-class amenities, pristine beaches, and exceptional hospitality in South Goa.',
                'short_description' => 'Luxury beachfront resort in South Goa with world-class amenities.',
                'featured_image' => 'uploads/hotels/leela-goa.jpg',
                'destination_id' => $destinationMap['goa'] ?? 1,
                'address' => 'Mobor Beach, Cavelossim, South Goa, Goa 403731',
                'latitude' => 15.1394,
                'longitude' => 73.9442,
                'star_rating' => 5,
                'price_per_night' => 15000.00,
                'amenities' => 'Swimming Pool,Spa,Beach Access,WiFi,Restaurant,Bar,Gym,Room Service,Concierge,Valet Parking',
                'contact_phone' => '+91-832-287-1234',
                'contact_email' => 'reservations.goa@theleela.com',
                'website' => 'https://www.theleela.com/goa',
                'is_featured' => 1,
                'status' => 'active',
                'sort_order' => 1,
                'meta_title' => 'The Leela Goa - Luxury Beach Resort',
                'meta_description' => 'Experience luxury at The Leela Goa, a premium beachfront resort offering world-class amenities and pristine beaches.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Taj Exotica Resort & Spa Goa',
                'slug' => 'taj-exotica-goa',
                'description' => 'Sprawling luxury resort set amidst 56 acres of lush gardens, offering Mediterranean villa-style accommodations.',
                'short_description' => 'Luxury resort with Mediterranean villa-style accommodations in lush gardens.',
                'featured_image' => 'uploads/hotels/taj-exotica-goa.jpg',
                'destination_id' => $destinationMap['goa'] ?? 1,
                'address' => 'Benaulim, Goa 403716',
                'latitude' => 15.2551,
                'longitude' => 73.9442,
                'star_rating' => 5,
                'price_per_night' => 12000.00,
                'amenities' => 'Swimming Pool,Spa,Beach Access,WiFi,Multiple Restaurants,Bar,Gym,Kids Club,Tennis Court',
                'contact_phone' => '+91-832-277-1234',
                'contact_email' => 'exotica.goa@tajhotels.com',
                'website' => 'https://www.tajhotels.com/taj/taj-exotica-goa',
                'is_featured' => 1,
                'status' => 'active',
                'sort_order' => 2,
                'meta_title' => 'Taj Exotica Resort & Spa Goa - Luxury Beach Resort',
                'meta_description' => 'Discover luxury at Taj Exotica Goa, a sprawling resort with Mediterranean villas and pristine beaches.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Kashmir Hotels
            [
                'name' => 'The Lalit Grand Palace Srinagar',
                'slug' => 'lalit-grand-palace-srinagar',
                'description' => 'Heritage palace hotel on the banks of Dal Lake, offering royal luxury with traditional Kashmiri hospitality.',
                'short_description' => 'Heritage palace hotel on Dal Lake with royal luxury and Kashmiri hospitality.',
                'featured_image' => 'uploads/hotels/lalit-srinagar.jpg',
                'destination_id' => $destinationMap['kashmir'] ?? 2,
                'address' => 'Gupkar Road, Srinagar, Jammu and Kashmir 190001',
                'latitude' => 34.0837,
                'longitude' => 74.7973,
                'star_rating' => 5,
                'price_per_night' => 8000.00,
                'amenities' => 'Lake View,Spa,WiFi,Restaurant,Bar,Gym,Room Service,Concierge,Garden,Heritage Architecture',
                'contact_phone' => '+91-194-250-1001',
                'contact_email' => 'reservations.srinagar@thelalit.com',
                'website' => 'https://www.thelalit.com/srinagar',
                'is_featured' => 1,
                'status' => 'active',
                'sort_order' => 3,
                'meta_title' => 'The Lalit Grand Palace Srinagar - Heritage Luxury Hotel',
                'meta_description' => 'Experience royal luxury at The Lalit Grand Palace Srinagar, a heritage hotel on the banks of Dal Lake.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Kerala Hotels
            [
                'name' => 'Kumarakom Lake Resort',
                'slug' => 'kumarakom-lake-resort',
                'description' => 'Luxury heritage resort on Vembanad Lake offering traditional Kerala architecture and Ayurvedic treatments.',
                'short_description' => 'Luxury heritage resort on Vembanad Lake with traditional Kerala architecture.',
                'featured_image' => 'uploads/hotels/kumarakom-lake-resort.jpg',
                'destination_id' => $destinationMap['kerala'] ?? 3,
                'address' => 'Kumarakom, Kottayam, Kerala 686563',
                'latitude' => 9.6177,
                'longitude' => 76.4274,
                'star_rating' => 5,
                'price_per_night' => 10000.00,
                'amenities' => 'Lake View,Spa,Ayurveda,WiFi,Restaurant,Bar,Swimming Pool,Backwater Cruise,Heritage Architecture',
                'contact_phone' => '+91-481-252-4900',
                'contact_email' => 'reservations@kumarakomlakeresort.in',
                'website' => 'https://www.kumarakomlakeresort.in',
                'is_featured' => 1,
                'status' => 'active',
                'sort_order' => 4,
                'meta_title' => 'Kumarakom Lake Resort - Luxury Heritage Resort Kerala',
                'meta_description' => 'Experience luxury at Kumarakom Lake Resort, a heritage property on Vembanad Lake with traditional Kerala charm.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Rajasthan Hotels
            [
                'name' => 'Umaid Bhawan Palace Jodhpur',
                'slug' => 'umaid-bhawan-palace-jodhpur',
                'description' => 'One of the world\'s largest private residences, now a luxury palace hotel offering royal experiences.',
                'short_description' => 'World\'s largest private residence turned luxury palace hotel.',
                'featured_image' => 'uploads/hotels/umaid-bhawan-palace.jpg',
                'destination_id' => $destinationMap['rajasthan'] ?? 4,
                'address' => 'Umaid Bhawan Palace, Jodhpur, Rajasthan 342006',
                'latitude' => 26.2389,
                'longitude' => 73.0243,
                'star_rating' => 5,
                'price_per_night' => 25000.00,
                'amenities' => 'Palace Architecture,Spa,WiFi,Multiple Restaurants,Bar,Swimming Pool,Museum,Royal Suites,Butler Service',
                'contact_phone' => '+91-291-251-0101',
                'contact_email' => 'reservations.jodhpur@tajhotels.com',
                'website' => 'https://www.tajhotels.com/taj/umaid-bhawan-palace-jodhpur',
                'is_featured' => 1,
                'status' => 'active',
                'sort_order' => 5,
                'meta_title' => 'Umaid Bhawan Palace Jodhpur - Royal Palace Hotel',
                'meta_description' => 'Experience royalty at Umaid Bhawan Palace Jodhpur, one of the world\'s largest private residences.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Himachal Pradesh Hotels
            [
                'name' => 'Wildflower Hall Shimla',
                'slug' => 'wildflower-hall-shimla',
                'description' => 'Luxury mountain resort in the Himalayas offering breathtaking views and world-class amenities.',
                'short_description' => 'Luxury mountain resort in the Himalayas with breathtaking views.',
                'featured_image' => 'uploads/hotels/wildflower-hall.jpg',
                'destination_id' => $destinationMap['himachal-pradesh'] ?? 5,
                'address' => 'Chharabra, Shimla, Himachal Pradesh 171012',
                'latitude' => 31.1048,
                'longitude' => 77.1734,
                'star_rating' => 5,
                'price_per_night' => 18000.00,
                'amenities' => 'Mountain View,Spa,WiFi,Restaurant,Bar,Gym,Indoor Pool,Adventure Activities,Himalayan Views',
                'contact_phone' => '+91-177-264-8585',
                'contact_email' => 'wildflowerhall.shimla@oberoihotels.com',
                'website' => 'https://www.oberoihotels.com/wildflower-hall-shimla',
                'is_featured' => 1,
                'status' => 'active',
                'sort_order' => 6,
                'meta_title' => 'Wildflower Hall Shimla - Luxury Mountain Resort',
                'meta_description' => 'Experience luxury in the Himalayas at Wildflower Hall Shimla, offering breathtaking mountain views.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Leh Ladakh Hotels
            [
                'name' => 'The Grand Dragon Ladakh',
                'slug' => 'grand-dragon-ladakh',
                'description' => 'Luxury hotel in Leh offering modern amenities with traditional Ladakhi architecture and mountain views.',
                'short_description' => 'Luxury hotel in Leh with traditional Ladakhi architecture and mountain views.',
                'featured_image' => 'uploads/hotels/grand-dragon-ladakh.jpg',
                'destination_id' => $destinationMap['leh-ladakh'] ?? 6,
                'address' => 'Old Road, Sheynam, Leh, Ladakh 194101',
                'latitude' => 34.1526,
                'longitude' => 77.5771,
                'star_rating' => 4,
                'price_per_night' => 6000.00,
                'amenities' => 'Mountain View,WiFi,Restaurant,Bar,Spa,Garden,Traditional Architecture,Oxygen Support',
                'contact_phone' => '+91-982-250-0039',
                'contact_email' => 'reservations@granddragonladakh.com',
                'website' => 'https://www.granddragonladakh.com',
                'is_featured' => 0,
                'status' => 'active',
                'sort_order' => 7,
                'meta_title' => 'The Grand Dragon Ladakh - Luxury Hotel in Leh',
                'meta_description' => 'Stay at The Grand Dragon Ladakh, a luxury hotel offering traditional architecture and stunning mountain views.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // International Hotels - Dubai
            [
                'name' => 'Burj Al Arab Jumeirah',
                'slug' => 'burj-al-arab-jumeirah',
                'description' => 'World\'s most luxurious hotel, an iconic sail-shaped structure offering unparalleled luxury and service.',
                'short_description' => 'World\'s most luxurious hotel with iconic sail-shaped architecture.',
                'featured_image' => 'uploads/hotels/burj-al-arab.jpg',
                'destination_id' => $destinationMap['dubai-uae'] ?? 7,
                'address' => 'Jumeirah Beach Road, Dubai, UAE',
                'latitude' => 25.1413,
                'longitude' => 55.1853,
                'star_rating' => 5,
                'price_per_night' => 50000.00,
                'amenities' => 'Private Beach,Spa,WiFi,Multiple Restaurants,Bars,Butler Service,Helicopter Pad,Rolls Royce Fleet',
                'contact_phone' => '+971-4-301-7777',
                'contact_email' => 'baainfo@jumeirah.com',
                'website' => 'https://www.jumeirah.com/burj-al-arab',
                'is_featured' => 1,
                'status' => 'active',
                'sort_order' => 8,
                'meta_title' => 'Burj Al Arab Jumeirah - World\'s Most Luxurious Hotel',
                'meta_description' => 'Experience ultimate luxury at Burj Al Arab Jumeirah, the world\'s most luxurious hotel in Dubai.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Thailand Hotels
            [
                'name' => 'The Oriental Bangkok',
                'slug' => 'oriental-bangkok',
                'description' => 'Legendary luxury hotel on the Chao Phraya River, offering timeless elegance and exceptional service.',
                'short_description' => 'Legendary luxury hotel on Chao Phraya River with timeless elegance.',
                'featured_image' => 'uploads/hotels/oriental-bangkok.jpg',
                'destination_id' => $destinationMap['thailand'] ?? 8,
                'address' => '48 Oriental Avenue, Bangkok 10500, Thailand',
                'latitude' => 13.7248,
                'longitude' => 100.5135,
                'star_rating' => 5,
                'price_per_night' => 20000.00,
                'amenities' => 'River View,Spa,WiFi,Multiple Restaurants,Bar,Swimming Pool,Butler Service,Cultural Center',
                'contact_phone' => '+66-2-659-9000',
                'contact_email' => 'mobkk-reservations@mohg.com',
                'website' => 'https://www.mandarinoriental.com/bangkok',
                'is_featured' => 1,
                'status' => 'active',
                'sort_order' => 9,
                'meta_title' => 'The Oriental Bangkok - Legendary Luxury Hotel',
                'meta_description' => 'Stay at The Oriental Bangkok, a legendary luxury hotel offering timeless elegance on the Chao Phraya River.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Singapore Hotels
            [
                'name' => 'Marina Bay Sands',
                'slug' => 'marina-bay-sands',
                'description' => 'Iconic integrated resort featuring the world\'s largest rooftop infinity pool and stunning city views.',
                'short_description' => 'Iconic resort with world\'s largest rooftop infinity pool and city views.',
                'featured_image' => 'uploads/hotels/marina-bay-sands.jpg',
                'destination_id' => $destinationMap['singapore'] ?? 9,
                'address' => '10 Bayfront Avenue, Singapore 018956',
                'latitude' => 1.2834,
                'longitude' => 103.8607,
                'star_rating' => 5,
                'price_per_night' => 30000.00,
                'amenities' => 'Infinity Pool,Spa,WiFi,Multiple Restaurants,Casino,Shopping Mall,Observation Deck,Convention Center',
                'contact_phone' => '+65-6688-8888',
                'contact_email' => 'reservations@marinabaysands.com',
                'website' => 'https://www.marinabaysands.com',
                'is_featured' => 1,
                'status' => 'active',
                'sort_order' => 10,
                'meta_title' => 'Marina Bay Sands Singapore - Iconic Luxury Resort',
                'meta_description' => 'Experience luxury at Marina Bay Sands Singapore, featuring the world\'s largest rooftop infinity pool.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Budget Hotels
            [
                'name' => 'OYO Premium Goa Beach Resort',
                'slug' => 'oyo-premium-goa-beach',
                'description' => 'Comfortable budget accommodation near Goa beaches with modern amenities and friendly service.',
                'short_description' => 'Comfortable budget accommodation near Goa beaches with modern amenities.',
                'featured_image' => 'uploads/hotels/oyo-goa.jpg',
                'destination_id' => $destinationMap['goa'] ?? 1,
                'address' => 'Calangute Beach Road, North Goa, Goa 403516',
                'latitude' => 15.5438,
                'longitude' => 73.7553,
                'star_rating' => 3,
                'price_per_night' => 2500.00,
                'amenities' => 'WiFi,AC,Restaurant,Room Service,Beach Access,Parking',
                'contact_phone' => '+91-832-227-8899',
                'contact_email' => 'goa@oyohotels.com',
                'website' => 'https://www.oyorooms.com',
                'is_featured' => 0,
                'status' => 'active',
                'sort_order' => 11,
                'meta_title' => 'OYO Premium Goa Beach Resort - Budget Beach Hotel',
                'meta_description' => 'Stay at OYO Premium Goa Beach Resort, offering comfortable budget accommodation near beautiful beaches.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Hotel Himalaya Shimla',
                'slug' => 'hotel-himalaya-shimla',
                'description' => 'Budget-friendly hotel in Shimla offering comfortable rooms with mountain views and basic amenities.',
                'short_description' => 'Budget-friendly hotel in Shimla with mountain views and basic amenities.',
                'featured_image' => 'uploads/hotels/himalaya-shimla.jpg',
                'destination_id' => $destinationMap['himachal-pradesh'] ?? 5,
                'address' => 'The Mall Road, Shimla, Himachal Pradesh 171001',
                'latitude' => 31.1048,
                'longitude' => 77.1734,
                'star_rating' => 2,
                'price_per_night' => 1500.00,
                'amenities' => 'Mountain View,WiFi,Restaurant,Room Service,Parking,Heating',
                'contact_phone' => '+91-177-265-4321',
                'contact_email' => 'info@hotelhimalayashimla.com',
                'website' => 'https://www.hotelhimalayashimla.com',
                'is_featured' => 0,
                'status' => 'active',
                'sort_order' => 12,
                'meta_title' => 'Hotel Himalaya Shimla - Budget Mountain Hotel',
                'meta_description' => 'Stay at Hotel Himalaya Shimla, a budget-friendly hotel offering comfortable rooms with mountain views.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('hotels')->insertBatch($data);
    }
}