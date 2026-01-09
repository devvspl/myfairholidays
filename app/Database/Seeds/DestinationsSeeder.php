<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DestinationsSeeder extends Seeder
{
    public function run()
    {
        // First, get the destination type IDs
        $domesticTypeId = $this->db->table('destination_types')->where('slug', 'domestic-destinations')->get()->getRow()->id ?? 1;
        $internationalTypeId = $this->db->table('destination_types')->where('slug', 'international-destinations')->get()->getRow()->id ?? 2;
        $adventureTypeId = $this->db->table('destination_types')->where('slug', 'adventure-tourism')->get()->getRow()->id ?? 3;
        $spiritualTypeId = $this->db->table('destination_types')->where('slug', 'spiritual-tourism')->get()->getRow()->id ?? 4;
        $beachTypeId = $this->db->table('destination_types')->where('slug', 'beach-destinations')->get()->getRow()->id ?? 5;
        $hillTypeId = $this->db->table('destination_types')->where('slug', 'hill-stations')->get()->getRow()->id ?? 6;

        $data = [
            // Domestic Destinations
            [
                'name' => 'Andaman & Nicobar Islands',
                'slug' => 'andaman-nicobar-islands',
                'type' => 'destination',
                'type_id' => $beachTypeId,
                'description' => 'Pristine beaches, crystal clear waters, and rich marine life in India\'s tropical paradise',
                'content' => '<h2>Andaman & Nicobar Islands - Tropical Paradise</h2><p>Experience the untouched beauty of Andaman & Nicobar Islands with pristine beaches, crystal-clear waters, and vibrant coral reefs. Perfect for water sports, scuba diving, and peaceful beach holidays.</p>',
                'latitude' => 11.7401,
                'longitude' => 92.6586,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 1
            ],
            [
                'name' => 'Dham (Char Dham)',
                'slug' => 'char-dham',
                'type' => 'destination',
                'type_id' => $spiritualTypeId,
                'description' => 'Sacred pilgrimage to the four holy shrines of Uttarakhand',
                'content' => '<h2>Char Dham Yatra - Sacred Journey</h2><p>Embark on the most sacred pilgrimage in Hinduism visiting Yamunotri, Gangotri, Kedarnath, and Badrinath. Experience spiritual awakening in the lap of the Himalayas.</p>',
                'latitude' => 30.0668,
                'longitude' => 79.0193,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 2
            ],
            [
                'name' => 'Goa',
                'slug' => 'goa',
                'type' => 'state',
                'type_id' => $beachTypeId,
                'description' => 'India\'s beach capital with golden sands, vibrant nightlife, and Portuguese heritage',
                'content' => '<h2>Goa - Beach Capital of India</h2><p>Discover the perfect blend of sun, sand, and sea in Goa. From pristine beaches to vibrant nightlife, Portuguese architecture to delicious seafood, Goa offers an unforgettable coastal experience.</p>',
                'latitude' => 15.2993,
                'longitude' => 74.1240,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 3
            ],
            [
                'name' => 'Himachal Pradesh',
                'slug' => 'himachal-pradesh',
                'type' => 'state',
                'type_id' => $hillTypeId,
                'description' => 'Land of snow-capped mountains, hill stations, and adventure activities',
                'content' => '<h2>Himachal Pradesh - Dev Bhoomi</h2><p>Experience the divine beauty of Himachal Pradesh with its snow-capped peaks, lush valleys, and charming hill stations. Perfect for adventure enthusiasts and nature lovers.</p>',
                'latitude' => 31.1048,
                'longitude' => 77.1734,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 4
            ],
            [
                'name' => 'Jim Corbett National Park',
                'slug' => 'jim-corbett-national-park',
                'type' => 'destination',
                'type_id' => $adventureTypeId,
                'description' => 'India\'s oldest national park famous for Bengal tigers and wildlife safari',
                'content' => '<h2>Jim Corbett National Park - Wildlife Paradise</h2><p>Explore India\'s first national park, home to the majestic Bengal tiger. Experience thrilling wildlife safaris, bird watching, and nature walks in this pristine wilderness.</p>',
                'latitude' => 29.5316,
                'longitude' => 78.9463,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 5
            ],
            [
                'name' => 'Jyotirlinga Temples',
                'slug' => 'jyotirlinga-temples',
                'type' => 'destination',
                'type_id' => $spiritualTypeId,
                'description' => 'Sacred pilgrimage to the 12 Jyotirlinga temples across India',
                'content' => '<h2>Jyotirlinga Darshan - Divine Journey</h2><p>Visit the 12 sacred Jyotirlinga temples dedicated to Lord Shiva. Each temple has its unique significance and offers a deeply spiritual experience for devotees.</p>',
                'latitude' => 23.0225,
                'longitude' => 72.5714,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 6
            ],
            [
                'name' => 'Kashmir',
                'slug' => 'kashmir',
                'type' => 'state',
                'type_id' => $hillTypeId,
                'description' => 'Paradise on Earth with stunning valleys, lakes, and snow-capped mountains',
                'content' => '<h2>Kashmir - Paradise on Earth</h2><p>Experience the breathtaking beauty of Kashmir with its pristine lakes, lush valleys, and snow-capped mountains. From Dal Lake to Gulmarg, Kashmir offers unparalleled natural beauty.</p>',
                'latitude' => 34.0837,
                'longitude' => 74.7973,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 7
            ],
            [
                'name' => 'Kerala',
                'slug' => 'kerala',
                'type' => 'state',
                'type_id' => $domesticTypeId,
                'description' => 'God\'s Own Country with backwaters, hill stations, and Ayurvedic treatments',
                'content' => '<h2>Kerala - God\'s Own Country</h2><p>Discover the enchanting beauty of Kerala with its serene backwaters, lush hill stations, pristine beaches, and rich cultural heritage. Experience authentic Ayurvedic treatments and traditional cuisine.</p>',
                'latitude' => 10.8505,
                'longitude' => 76.2711,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 8
            ],
            [
                'name' => 'Lahaul Spiti',
                'slug' => 'lahaul-spiti',
                'type' => 'destination',
                'type_id' => $adventureTypeId,
                'description' => 'High-altitude desert valley with ancient monasteries and stunning landscapes',
                'content' => '<h2>Lahaul Spiti - Land of Lamas</h2><p>Explore the mystical high-altitude desert of Lahaul Spiti with its ancient Buddhist monasteries, barren landscapes, and unique culture. Perfect for adventure seekers and spiritual travelers.</p>',
                'latitude' => 32.2432,
                'longitude' => 78.0414,
                'is_popular' => 0,
                'status' => 'active',
                'sort_order' => 9
            ],
            [
                'name' => 'Leh Ladakh',
                'slug' => 'leh-ladakh',
                'type' => 'destination',
                'type_id' => $adventureTypeId,
                'description' => 'Land of high passes with Buddhist culture and breathtaking landscapes',
                'content' => '<h2>Leh Ladakh - Land of High Passes</h2><p>Experience the rugged beauty of Leh Ladakh with its high-altitude passes, pristine lakes, ancient monasteries, and unique Tibetan culture. A paradise for adventure enthusiasts and motorcycle riders.</p>',
                'latitude' => 34.1526,
                'longitude' => 77.5771,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 10
            ],
            [
                'name' => 'North East India',
                'slug' => 'north-east-india',
                'type' => 'destination',
                'type_id' => $domesticTypeId,
                'description' => 'Seven sister states with diverse cultures, pristine nature, and unique traditions',
                'content' => '<h2>North East India - Seven Sisters</h2><p>Discover the unexplored beauty of North East India with its diverse tribal cultures, pristine forests, cascading waterfalls, and unique traditions. Experience the untouched natural beauty of the seven sister states.</p>',
                'latitude' => 26.2006,
                'longitude' => 92.9376,
                'is_popular' => 0,
                'status' => 'active',
                'sort_order' => 11
            ],
            [
                'name' => 'Rajasthan',
                'slug' => 'rajasthan',
                'type' => 'state',
                'type_id' => $domesticTypeId,
                'description' => 'Land of kings with majestic palaces, forts, and desert landscapes',
                'content' => '<h2>Rajasthan - Land of Kings</h2><p>Step into the royal heritage of Rajasthan with its magnificent palaces, imposing forts, colorful culture, and golden desert landscapes. Experience the grandeur of maharajas and rich Rajasthani traditions.</p>',
                'latitude' => 27.0238,
                'longitude' => 74.2179,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 12
            ],
            [
                'name' => 'South India',
                'slug' => 'south-india',
                'type' => 'destination',
                'type_id' => $domesticTypeId,
                'description' => 'Rich cultural heritage with ancient temples, classical arts, and diverse landscapes',
                'content' => '<h2>South India - Cultural Heritage</h2><p>Explore the rich cultural tapestry of South India with its ancient temples, classical dance forms, traditional cuisine, and diverse landscapes from beaches to hill stations.</p>',
                'latitude' => 12.9716,
                'longitude' => 77.5946,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 13
            ],
            [
                'name' => 'Uttar Pradesh',
                'slug' => 'uttar-pradesh',
                'type' => 'state',
                'type_id' => $spiritualTypeId,
                'description' => 'Spiritual heartland with Taj Mahal, Varanasi, and sacred pilgrimage sites',
                'content' => '<h2>Uttar Pradesh - Spiritual Heartland</h2><p>Discover the spiritual and cultural richness of Uttar Pradesh, home to the iconic Taj Mahal, sacred city of Varanasi, and numerous pilgrimage sites that define India\'s spiritual heritage.</p>',
                'latitude' => 26.8467,
                'longitude' => 80.9462,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 14
            ],
            [
                'name' => 'Uttarakhand',
                'slug' => 'uttarakhand',
                'type' => 'state',
                'type_id' => $spiritualTypeId,
                'description' => 'Dev Bhoomi with sacred temples, yoga capital Rishikesh, and Himalayan beauty',
                'content' => '<h2>Uttarakhand - Dev Bhoomi</h2><p>Experience the divine beauty of Uttarakhand, known as Dev Bhoomi (Land of Gods). From the yoga capital Rishikesh to the sacred Char Dham, discover spiritual awakening amidst Himalayan splendor.</p>',
                'latitude' => 30.0668,
                'longitude' => 79.0193,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 15
            ],

            // International Destinations
            [
                'name' => 'Bali, Indonesia',
                'slug' => 'bali-indonesia',
                'type' => 'destination',
                'type_id' => $internationalTypeId,
                'description' => 'Tropical paradise with beautiful beaches, temples, and vibrant culture',
                'content' => '<h2>Bali - Island of Gods</h2><p>Experience the magical island of Bali with its stunning beaches, ancient temples, lush rice terraces, and vibrant Hindu culture. Perfect for relaxation, adventure, and cultural exploration.</p>',
                'latitude' => -8.3405,
                'longitude' => 115.0920,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 16
            ],
            [
                'name' => 'Dubai, UAE',
                'slug' => 'dubai-uae',
                'type' => 'city',
                'type_id' => $internationalTypeId,
                'description' => 'Modern metropolis with luxury shopping, futuristic architecture, and desert adventures',
                'content' => '<h2>Dubai - City of Gold</h2><p>Discover the futuristic city of Dubai with its iconic skyscrapers, luxury shopping malls, pristine beaches, and thrilling desert safaris. Experience the perfect blend of modern luxury and traditional Arabian culture.</p>',
                'latitude' => 25.2048,
                'longitude' => 55.2708,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 17
            ],
            [
                'name' => 'Europe',
                'slug' => 'europe',
                'type' => 'destination',
                'type_id' => $internationalTypeId,
                'description' => 'Rich history, diverse cultures, and stunning architecture across European countries',
                'content' => '<h2>Europe - Continental Grandeur</h2><p>Explore the diverse beauty of Europe with its rich history, magnificent architecture, world-class museums, and varied landscapes. From romantic Paris to historic Rome, experience European grandeur.</p>',
                'latitude' => 54.5260,
                'longitude' => 15.2551,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 18
            ],
            [
                'name' => 'Japan',
                'slug' => 'japan',
                'type' => 'country',
                'type_id' => $internationalTypeId,
                'description' => 'Land of rising sun with unique culture, technology, and natural beauty',
                'content' => '<h2>Japan - Land of Rising Sun</h2><p>Discover the fascinating blend of ancient traditions and modern technology in Japan. From cherry blossoms to bullet trains, experience the unique Japanese culture and hospitality.</p>',
                'latitude' => 36.2048,
                'longitude' => 138.2529,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 19
            ],
            [
                'name' => 'Malaysia',
                'slug' => 'malaysia',
                'type' => 'country',
                'type_id' => $internationalTypeId,
                'description' => 'Multicultural nation with modern cities, tropical islands, and diverse cuisine',
                'content' => '<h2>Malaysia - Truly Asia</h2><p>Experience the multicultural beauty of Malaysia with its modern cities, pristine islands, diverse cuisine, and rich cultural heritage. From Kuala Lumpur to Langkawi, discover Malaysian hospitality.</p>',
                'latitude' => 4.2105,
                'longitude' => 101.9758,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 20
            ],
            [
                'name' => 'Singapore',
                'slug' => 'singapore',
                'type' => 'country',
                'type_id' => $internationalTypeId,
                'description' => 'Garden city with modern attractions, diverse food culture, and efficient infrastructure',
                'content' => '<h2>Singapore - Garden City</h2><p>Explore the modern marvel of Singapore with its futuristic gardens, world-class attractions, diverse food scene, and efficient infrastructure. Experience the perfect city-state in Southeast Asia.</p>',
                'latitude' => 1.3521,
                'longitude' => 103.8198,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 21
            ],
            [
                'name' => 'Thailand',
                'slug' => 'thailand',
                'type' => 'country',
                'type_id' => $internationalTypeId,
                'description' => 'Land of smiles with beautiful beaches, ancient temples, and vibrant street life',
                'content' => '<h2>Thailand - Land of Smiles</h2><p>Discover the enchanting beauty of Thailand with its pristine beaches, golden temples, bustling markets, and warm hospitality. From Bangkok to Phuket, experience Thai culture and cuisine.</p>',
                'latitude' => 15.8700,
                'longitude' => 100.9925,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 22
            ],
            [
                'name' => 'Turkey',
                'slug' => 'turkey',
                'type' => 'country',
                'type_id' => $internationalTypeId,
                'description' => 'Bridge between Europe and Asia with rich history and stunning landscapes',
                'content' => '<h2>Turkey - Bridge of Continents</h2><p>Explore the fascinating country of Turkey, bridging Europe and Asia. Discover ancient ruins, stunning coastlines, unique rock formations of Cappadocia, and rich Ottoman heritage.</p>',
                'latitude' => 38.9637,
                'longitude' => 35.2433,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 23
            ],
            [
                'name' => 'Vietnam',
                'slug' => 'vietnam',
                'type' => 'country',
                'type_id' => $internationalTypeId,
                'description' => 'Southeast Asian gem with stunning landscapes, rich history, and delicious cuisine',
                'content' => '<h2>Vietnam - Hidden Gem of Southeast Asia</h2><p>Discover the natural beauty and rich culture of Vietnam with its stunning landscapes, from Ha Long Bay to Mekong Delta. Experience Vietnamese hospitality, delicious cuisine, and fascinating history.</p>',
                'latitude' => 14.0583,
                'longitude' => 108.2772,
                'is_popular' => 1,
                'status' => 'active',
                'sort_order' => 24
            ]
        ];

        $this->db->table('destinations')->insertBatch($data);
    }
}
