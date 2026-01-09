<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ItinerariesSeeder extends Seeder
{
    public function run()
    {
        // Get destination and category IDs for proper relationships
        $destinations = $this->db->table('destinations')->select('id, name, slug')->get()->getResultArray();
        $destinationMap = [];
        foreach ($destinations as $dest) {
            $destinationMap[$dest['slug']] = $dest['id'];
        }

        $categories = $this->db->table('itinerary_categories')->select('id, name, slug')->get()->getResultArray();
        $categoryMap = [];
        foreach ($categories as $cat) {
            $categoryMap[$cat['slug']] = $cat['id'];
        }

        $data = [
            // Honeymoon Packages
            [
                'title' => 'Romantic Goa Honeymoon Package - 5 Days',
                'slug' => 'romantic-goa-honeymoon-5-days',
                'description' => 'Experience the perfect romantic getaway in Goa with pristine beaches, candlelight dinners, and luxury accommodations. This 5-day honeymoon package includes beachside resorts, romantic dinners, sunset cruises, and couple spa treatments.',
                'short_description' => 'Perfect romantic getaway in Goa with beaches, dinners, and luxury stays.',
                'featured_image' => 'uploads/itineraries/goa-honeymoon.jpg',
                'category_id' => $categoryMap['honeymoon-packages'] ?? 1,
                'destination_id' => $destinationMap['goa'] ?? 1,
                'duration_days' => 5,
                'duration_nights' => 4,
                'price' => 45000.00,
                'discounted_price' => 38000.00,
                'inclusions' => 'Accommodation,Breakfast,Airport Transfers,Sunset Cruise,Couple Spa,Candlelight Dinner,Sightseeing',
                'exclusions' => 'Airfare,Lunch & Dinner (except mentioned),Personal Expenses,Travel Insurance',
                'itinerary_details' => json_encode([
                    'Day 1' => 'Arrival in Goa, Check-in to beach resort, Welcome drink, Evening at leisure on beach',
                    'Day 2' => 'North Goa sightseeing - Calangute, Baga, Anjuna beaches, Fort Aguada, Evening sunset cruise',
                    'Day 3' => 'South Goa tour - Colva beach, Basilica of Bom Jesus, Se Cathedral, Couple spa session',
                    'Day 4' => 'Day at leisure, Water sports (optional), Romantic candlelight dinner on beach',
                    'Day 5' => 'Check-out, Departure transfer to airport'
                ]),
                'is_featured' => 1,
                'status' => 'published',
                'sort_order' => 1,
                'meta_title' => 'Romantic Goa Honeymoon Package 5 Days - Beach Romance',
                'meta_description' => 'Book romantic Goa honeymoon package for 5 days with beaches, luxury stays, sunset cruise, and candlelight dinners.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Kashmir Honeymoon Paradise - 6 Days',
                'slug' => 'kashmir-honeymoon-paradise-6-days',
                'description' => 'Discover the paradise on earth with your loved one in Kashmir. This 6-day honeymoon package includes houseboat stays, Shikara rides, Mughal gardens, and snow-capped mountain views.',
                'short_description' => 'Paradise on earth honeymoon in Kashmir with houseboats and mountain views.',
                'featured_image' => 'uploads/itineraries/kashmir-honeymoon.jpg',
                'category_id' => $categoryMap['honeymoon-packages'] ?? 1,
                'destination_id' => $destinationMap['kashmir'] ?? 2,
                'duration_days' => 6,
                'duration_nights' => 5,
                'price' => 55000.00,
                'discounted_price' => 48000.00,
                'inclusions' => 'Accommodation,All Meals,Airport Transfers,Houseboat Stay,Shikara Ride,Sightseeing,Guide',
                'exclusions' => 'Airfare,Personal Expenses,Travel Insurance,Pony Rides,Shopping',
                'itinerary_details' => json_encode([
                    'Day 1' => 'Arrival Srinagar, Check-in houseboat, Shikara ride on Dal Lake, Floating gardens visit',
                    'Day 2' => 'Srinagar local sightseeing - Mughal Gardens (Nishat, Shalimar), Chashme Shahi, Shankaracharya Temple',
                    'Day 3' => 'Srinagar to Gulmarg (50km), Cable car ride, Snow activities, Overnight in Gulmarg',
                    'Day 4' => 'Gulmarg to Pahalgam (140km), Betaab Valley, Aru Valley, Chandanwari, Overnight Pahalgam',
                    'Day 5' => 'Pahalgam to Srinagar, Shopping at Lal Chowk, Handicrafts market, Overnight houseboat',
                    'Day 6' => 'Check-out, Departure transfer to Srinagar airport'
                ]),
                'is_featured' => 1,
                'status' => 'published',
                'sort_order' => 2,
                'meta_title' => 'Kashmir Honeymoon Paradise 6 Days - Houseboat Romance',
                'meta_description' => 'Experience Kashmir honeymoon paradise with houseboat stays, Shikara rides, and breathtaking mountain views.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Family Tours
            [
                'title' => 'Kerala Family Adventure - 7 Days',
                'slug' => 'kerala-family-adventure-7-days',
                'description' => 'Perfect family vacation in God\'s Own Country covering backwaters, hill stations, wildlife, and beaches. This comprehensive 7-day tour includes Munnar, Thekkady, Alleppey, and Cochin.',
                'short_description' => 'Perfect family vacation in Kerala covering backwaters, hills, and wildlife.',
                'featured_image' => 'uploads/itineraries/kerala-family.jpg',
                'category_id' => $categoryMap['family-tours'] ?? 2,
                'destination_id' => $destinationMap['kerala'] ?? 3,
                'duration_days' => 7,
                'duration_nights' => 6,
                'price' => 65000.00,
                'discounted_price' => 58000.00,
                'inclusions' => 'Accommodation,Breakfast,Airport Transfers,Houseboat Stay,Sightseeing,Entry Fees,Guide',
                'exclusions' => 'Airfare,Lunch & Dinner,Personal Expenses,Travel Insurance,Ayurvedic Treatments',
                'itinerary_details' => json_encode([
                    'Day 1' => 'Arrival Cochin, City tour - Chinese Fishing Nets, St. Francis Church, Jewish Synagogue',
                    'Day 2' => 'Cochin to Munnar (130km), En-route spice plantations, Check-in hill resort',
                    'Day 3' => 'Munnar sightseeing - Tea Museum, Mattupetty Dam, Echo Point, Top Station',
                    'Day 4' => 'Munnar to Thekkady (90km), Periyar Wildlife Sanctuary, Spice plantation tour',
                    'Day 5' => 'Thekkady to Alleppey (140km), Check-in houseboat, Backwater cruise',
                    'Day 6' => 'Alleppey to Cochin (60km), Beach visit, Shopping, Cultural show',
                    'Day 7' => 'Check-out, Departure transfer to Cochin airport'
                ]),
                'is_featured' => 1,
                'status' => 'published',
                'sort_order' => 3,
                'meta_title' => 'Kerala Family Adventure 7 Days - Backwaters & Hills',
                'meta_description' => 'Book Kerala family adventure covering Munnar hills, Thekkady wildlife, Alleppey backwaters, and Cochin culture.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Rajasthan Royal Family Tour - 8 Days',
                'slug' => 'rajasthan-royal-family-tour-8-days',
                'description' => 'Explore the royal heritage of Rajasthan with your family. Visit magnificent palaces, forts, and experience the rich culture of the Land of Kings across Jaipur, Udaipur, and Jodhpur.',
                'short_description' => 'Royal heritage tour of Rajasthan with palaces, forts, and rich culture.',
                'featured_image' => 'uploads/itineraries/rajasthan-family.jpg',
                'category_id' => $categoryMap['family-tours'] ?? 2,
                'destination_id' => $destinationMap['rajasthan'] ?? 4,
                'duration_days' => 8,
                'duration_nights' => 7,
                'price' => 85000.00,
                'discounted_price' => 75000.00,
                'inclusions' => 'Accommodation,Breakfast,Airport Transfers,Sightseeing,Entry Fees,Guide,Cultural Shows',
                'exclusions' => 'Airfare,Lunch & Dinner,Personal Expenses,Travel Insurance,Camel Safari,Shopping',
                'itinerary_details' => json_encode([
                    'Day 1' => 'Arrival Jaipur, Check-in heritage hotel, Evening at leisure',
                    'Day 2' => 'Jaipur sightseeing - Amber Fort, City Palace, Hawa Mahal, Jantar Mantar',
                    'Day 3' => 'Jaipur to Jodhpur (340km), Check-in, Evening visit Jaswant Thada',
                    'Day 4' => 'Jodhpur sightseeing - Mehrangarh Fort, Umaid Bhawan Palace, Clock Tower Market',
                    'Day 5' => 'Jodhpur to Udaipur (250km), Check-in lake palace hotel, Sunset boat ride',
                    'Day 6' => 'Udaipur sightseeing - City Palace, Jagdish Temple, Saheliyon ki Bari, Cultural show',
                    'Day 7' => 'Udaipur local tour - Eklingji Temple, Nagda ruins, Fateh Sagar Lake',
                    'Day 8' => 'Check-out, Departure transfer to Udaipur airport'
                ]),
                'is_featured' => 1,
                'status' => 'published',
                'sort_order' => 4,
                'meta_title' => 'Rajasthan Royal Family Tour 8 Days - Palaces & Forts',
                'meta_description' => 'Explore Rajasthan royal heritage with family tour covering Jaipur, Jodhpur, Udaipur palaces and forts.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Adventure Tours
            [
                'title' => 'Leh Ladakh Adventure Expedition - 10 Days',
                'slug' => 'leh-ladakh-adventure-expedition-10-days',
                'description' => 'Ultimate adventure expedition to the Land of High Passes. Experience high-altitude trekking, monastery visits, and breathtaking landscapes of Ladakh including Nubra Valley and Pangong Lake.',
                'short_description' => 'Ultimate adventure in Ladakh with high-altitude trekking and breathtaking landscapes.',
                'featured_image' => 'uploads/itineraries/ladakh-adventure.jpg',
                'category_id' => $categoryMap['adventure-tours'] ?? 3,
                'destination_id' => $destinationMap['leh-ladakh'] ?? 6,
                'duration_days' => 10,
                'duration_nights' => 9,
                'price' => 95000.00,
                'discounted_price' => 85000.00,
                'inclusions' => 'Accommodation,All Meals,Airport Transfers,Permits,Sightseeing,Guide,Oxygen Support',
                'exclusions' => 'Airfare,Personal Expenses,Travel Insurance,Adventure Gear,Medical Kit',
                'itinerary_details' => json_encode([
                    'Day 1' => 'Arrival Leh, Rest for acclimatization, Light local market visit',
                    'Day 2' => 'Leh local sightseeing - Leh Palace, Shanti Stupa, Leh Market',
                    'Day 3' => 'Leh to Nubra Valley via Khardung La Pass (18,380 ft), Camel safari at Hunder',
                    'Day 4' => 'Nubra Valley exploration - Diskit Monastery, Sand dunes, Local villages',
                    'Day 5' => 'Nubra to Pangong Lake (280km), World\'s highest saltwater lake',
                    'Day 6' => 'Pangong Lake to Leh via Chang La Pass (17,590 ft), Photography stops',
                    'Day 7' => 'Leh to Alchi - Alchi Monastery, Likir Monastery, Return to Leh',
                    'Day 8' => 'Day trek to Shey Palace and Thiksey Monastery, Sunset at Shey',
                    'Day 9' => 'Adventure activities - River rafting on Indus, Mountain biking (optional)',
                    'Day 10' => 'Check-out, Departure transfer to Leh airport'
                ]),
                'is_featured' => 1,
                'status' => 'published',
                'sort_order' => 5,
                'meta_title' => 'Leh Ladakh Adventure Expedition 10 Days - High Altitude Trek',
                'meta_description' => 'Book Leh Ladakh adventure expedition with high-altitude trekking, Nubra Valley, and Pangong Lake exploration.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Himachal Adventure Trek - 8 Days',
                'slug' => 'himachal-adventure-trek-8-days',
                'description' => 'Thrilling adventure in the Himalayas covering Manali, Solang Valley, and Rohtang Pass. Includes paragliding, river rafting, trekking, and mountain biking in the scenic valleys of Himachal.',
                'short_description' => 'Thrilling Himalayan adventure with paragliding, rafting, and trekking.',
                'featured_image' => 'uploads/itineraries/himachal-adventure.jpg',
                'category_id' => $categoryMap['adventure-tours'] ?? 3,
                'destination_id' => $destinationMap['himachal-pradesh'] ?? 5,
                'duration_days' => 8,
                'duration_nights' => 7,
                'price' => 55000.00,
                'discounted_price' => 48000.00,
                'inclusions' => 'Accommodation,Breakfast,Airport Transfers,Adventure Activities,Safety Gear,Guide',
                'exclusions' => 'Airfare,Lunch & Dinner,Personal Expenses,Travel Insurance,Extra Activities',
                'itinerary_details' => json_encode([
                    'Day 1' => 'Arrival Manali, Check-in, Evening walk on Mall Road',
                    'Day 2' => 'Manali local sightseeing - Hadimba Temple, Vashisht Hot Springs, Tibetan Monastery',
                    'Day 3' => 'Solang Valley adventure - Paragliding, Zorbing, Cable car ride',
                    'Day 4' => 'Rohtang Pass excursion (subject to permit), Snow activities, Photography',
                    'Day 5' => 'River rafting on Beas River, Mountain biking in Kullu Valley',
                    'Day 6' => 'Trek to Jogini Falls, Rock climbing, Rappelling activities',
                    'Day 7' => 'Day trip to Kasol and Malana village, Local culture experience',
                    'Day 8' => 'Check-out, Departure transfer to Kullu airport'
                ]),
                'is_featured' => 1,
                'status' => 'published',
                'sort_order' => 6,
                'meta_title' => 'Himachal Adventure Trek 8 Days - Manali Thrills',
                'meta_description' => 'Experience Himachal adventure with paragliding, river rafting, trekking, and mountain biking in Manali.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Spiritual Tours
            [
                'title' => 'Char Dham Yatra - 12 Days',
                'slug' => 'char-dham-yatra-12-days',
                'description' => 'Sacred pilgrimage to the four holy shrines of Uttarakhand - Yamunotri, Gangotri, Kedarnath, and Badrinath. Complete spiritual journey with helicopter services and comfortable accommodations.',
                'short_description' => 'Sacred pilgrimage to four holy shrines with helicopter services.',
                'featured_image' => 'uploads/itineraries/char-dham.jpg',
                'category_id' => $categoryMap['spiritual-tours'] ?? 4,
                'destination_id' => $destinationMap['dham-char-dham'] ?? 7,
                'duration_days' => 12,
                'duration_nights' => 11,
                'price' => 125000.00,
                'discounted_price' => 110000.00,
                'inclusions' => 'Accommodation,All Meals,Helicopter Services,VIP Darshan,Guide,Medical Support',
                'exclusions' => 'Airfare,Personal Expenses,Travel Insurance,Donations,Extra Helicopter Rides',
                'itinerary_details' => json_encode([
                    'Day 1' => 'Arrival Dehradun, Drive to Haridwar, Ganga Aarti at Har ki Pauri',
                    'Day 2' => 'Haridwar to Barkot (210km), En-route Kempty Falls, Overnight Barkot',
                    'Day 3' => 'Barkot to Yamunotri by helicopter, Darshan, Return to Barkot',
                    'Day 4' => 'Barkot to Uttarkashi (100km), Visit Vishwanath Temple, Overnight Uttarkashi',
                    'Day 5' => 'Uttarkashi to Gangotri by helicopter, Darshan, Return to Uttarkashi',
                    'Day 6' => 'Uttarkashi to Guptkashi (220km), En-route Tehri Dam, Overnight Guptkashi',
                    'Day 7' => 'Guptkashi to Kedarnath by helicopter, Darshan, Overnight Kedarnath',
                    'Day 8' => 'Morning darshan, Helicopter to Guptkashi, Drive to Pipalkoti',
                    'Day 9' => 'Pipalkoti to Badrinath (45km), Darshan, Mana Village visit',
                    'Day 10' => 'Morning darshan, Badrinath to Joshimath, Overnight Joshimath',
                    'Day 11' => 'Joshimath to Haridwar (280km), Evening Ganga Aarti',
                    'Day 12' => 'Haridwar to Dehradun, Departure transfer to airport'
                ]),
                'is_featured' => 1,
                'status' => 'published',
                'sort_order' => 7,
                'meta_title' => 'Char Dham Yatra 12 Days - Sacred Pilgrimage by Helicopter',
                'meta_description' => 'Book Char Dham Yatra pilgrimage to Yamunotri, Gangotri, Kedarnath, Badrinath with helicopter services.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Beach Holidays
            [
                'title' => 'Andaman Beach Paradise - 6 Days',
                'slug' => 'andaman-beach-paradise-6-days',
                'description' => 'Tropical paradise experience in Andaman Islands with pristine beaches, water sports, and marine life. Includes Port Blair, Havelock Island, and Neil Island with scuba diving and snorkeling.',
                'short_description' => 'Tropical paradise in Andaman with pristine beaches and water sports.',
                'featured_image' => 'uploads/itineraries/andaman-beach.jpg',
                'category_id' => $categoryMap['beach-holidays'] ?? 5,
                'destination_id' => $destinationMap['andaman-nicobar-islands'] ?? 8,
                'duration_days' => 6,
                'duration_nights' => 5,
                'price' => 75000.00,
                'discounted_price' => 65000.00,
                'inclusions' => 'Accommodation,Breakfast,Airport Transfers,Ferry Tickets,Water Sports,Sightseeing',
                'exclusions' => 'Airfare,Lunch & Dinner,Personal Expenses,Travel Insurance,Scuba Diving,Extra Activities',
                'itinerary_details' => json_encode([
                    'Day 1' => 'Arrival Port Blair, Cellular Jail visit, Light & Sound Show',
                    'Day 2' => 'Port Blair to Havelock Island by ferry, Radhanagar Beach, Sunset viewing',
                    'Day 3' => 'Elephant Beach water sports - Snorkeling, Sea walking, Jet skiing',
                    'Day 4' => 'Havelock to Neil Island, Natural Bridge, Laxmanpur Beach, Bharatpur Beach',
                    'Day 5' => 'Neil Island to Port Blair, Ross Island, North Bay Island, Coral viewing',
                    'Day 6' => 'Check-out, Shopping at Aberdeen Bazaar, Departure transfer'
                ]),
                'is_featured' => 1,
                'status' => 'published',
                'sort_order' => 8,
                'meta_title' => 'Andaman Beach Paradise 6 Days - Tropical Island Holiday',
                'meta_description' => 'Experience Andaman beach paradise with pristine beaches, water sports, and marine life exploration.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // International Tours
            [
                'title' => 'Dubai Luxury Experience - 5 Days',
                'slug' => 'dubai-luxury-experience-5-days',
                'description' => 'Ultimate luxury experience in Dubai with world-class shopping, fine dining, desert safari, and iconic attractions. Stay in 5-star hotels and enjoy VIP experiences across the city.',
                'short_description' => 'Ultimate luxury experience in Dubai with shopping, dining, and VIP attractions.',
                'featured_image' => 'uploads/itineraries/dubai-luxury.jpg',
                'category_id' => $categoryMap['luxury-tours'] ?? 9,
                'destination_id' => $destinationMap['dubai-uae'] ?? 9,
                'duration_days' => 5,
                'duration_nights' => 4,
                'price' => 150000.00,
                'discounted_price' => 135000.00,
                'inclusions' => 'Luxury Accommodation,Breakfast,Airport Transfers,City Tour,Desert Safari,Burj Khalifa,Dubai Mall',
                'exclusions' => 'Airfare,Lunch & Dinner,Personal Expenses,Travel Insurance,Shopping,Extra Tours',
                'itinerary_details' => json_encode([
                    'Day 1' => 'Arrival Dubai, Check-in luxury hotel, Evening Dubai Fountain show',
                    'Day 2' => 'Dubai city tour - Burj Al Arab, Palm Jumeirah, Dubai Marina, Gold Souk',
                    'Day 3' => 'Burj Khalifa visit, Dubai Mall shopping, Aquarium visit, Luxury spa',
                    'Day 4' => 'Desert safari with BBQ dinner, Camel riding, Dune bashing, Cultural show',
                    'Day 5' => 'Check-out, Last minute shopping, Departure transfer to airport'
                ]),
                'is_featured' => 1,
                'status' => 'published',
                'sort_order' => 9,
                'meta_title' => 'Dubai Luxury Experience 5 Days - VIP City Tour',
                'meta_description' => 'Experience Dubai luxury with 5-star hotels, VIP attractions, desert safari, and world-class shopping.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Thailand Beach & Culture - 7 Days',
                'slug' => 'thailand-beach-culture-7-days',
                'description' => 'Perfect blend of Thai culture and beach relaxation covering Bangkok temples, floating markets, and Phuket beaches. Experience authentic Thai cuisine, traditional massages, and island hopping.',
                'short_description' => 'Perfect blend of Thai culture and beach relaxation in Bangkok and Phuket.',
                'featured_image' => 'uploads/itineraries/thailand-culture.jpg',
                'category_id' => $categoryMap['cultural-tours'] ?? 8,
                'destination_id' => $destinationMap['thailand'] ?? 10,
                'duration_days' => 7,
                'duration_nights' => 6,
                'price' => 85000.00,
                'discounted_price' => 75000.00,
                'inclusions' => 'Accommodation,Breakfast,Airport Transfers,Sightseeing,Island Tour,Cultural Shows',
                'exclusions' => 'Airfare,Lunch & Dinner,Personal Expenses,Travel Insurance,Spa Treatments,Shopping',
                'itinerary_details' => json_encode([
                    'Day 1' => 'Arrival Bangkok, Check-in, Evening Chao Phraya River cruise',
                    'Day 2' => 'Bangkok temples tour - Grand Palace, Wat Pho, Wat Arun, Floating market',
                    'Day 3' => 'Bangkok to Phuket flight, Check-in beach resort, Patong Beach evening',
                    'Day 4' => 'Phi Phi Island tour by speedboat, Maya Bay, Snorkeling, Lunch on island',
                    'Day 5' => 'James Bond Island tour, Phang Nga Bay, Sea canoeing, Local village visit',
                    'Day 6' => 'Phuket city tour - Big Buddha, Chalong Temple, Old Town, Thai massage',
                    'Day 7' => 'Check-out, Shopping at Central Festival, Departure transfer to airport'
                ]),
                'is_featured' => 1,
                'status' => 'published',
                'sort_order' => 10,
                'meta_title' => 'Thailand Beach & Culture 7 Days - Bangkok to Phuket',
                'meta_description' => 'Explore Thailand culture and beaches with Bangkok temples, floating markets, and Phuket island tours.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Budget Tours
            [
                'title' => 'Budget Himachal Tour - 6 Days',
                'slug' => 'budget-himachal-tour-6-days',
                'description' => 'Affordable Himachal Pradesh tour covering Shimla and Manali with budget accommodations and local transport. Perfect for students and budget travelers seeking mountain experiences.',
                'short_description' => 'Affordable Himachal tour covering Shimla and Manali with budget stays.',
                'featured_image' => 'uploads/itineraries/budget-himachal.jpg',
                'category_id' => $categoryMap['budget-tours'] ?? 10,
                'destination_id' => $destinationMap['himachal-pradesh'] ?? 5,
                'duration_days' => 6,
                'duration_nights' => 5,
                'price' => 25000.00,
                'discounted_price' => 22000.00,
                'inclusions' => 'Budget Accommodation,Breakfast,Local Transport,Sightseeing,Guide',
                'exclusions' => 'Airfare,Lunch & Dinner,Personal Expenses,Travel Insurance,Adventure Activities',
                'itinerary_details' => json_encode([
                    'Day 1' => 'Arrival Shimla by bus, Check-in budget hotel, Mall Road evening walk',
                    'Day 2' => 'Shimla local sightseeing - Christ Church, Jakhu Temple, Ridge, Scandal Point',
                    'Day 3' => 'Shimla to Manali by bus (280km), Check-in budget hotel, Rest',
                    'Day 4' => 'Manali local tour - Hadimba Temple, Vashisht, Tibetan Monastery, Mall Road',
                    'Day 5' => 'Solang Valley day trip, Basic adventure activities, Photography',
                    'Day 6' => 'Check-out, Departure by bus to Delhi'
                ]),
                'is_featured' => 0,
                'status' => 'published',
                'sort_order' => 11,
                'meta_title' => 'Budget Himachal Tour 6 Days - Affordable Mountain Holiday',
                'meta_description' => 'Book budget Himachal tour covering Shimla and Manali with affordable accommodations and local transport.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Wildlife Safari
            [
                'title' => 'Jim Corbett Wildlife Safari - 4 Days',
                'slug' => 'jim-corbett-wildlife-safari-4-days',
                'description' => 'Exciting wildlife safari in India\'s oldest national park. Experience tiger sightings, elephant safari, bird watching, and nature walks in the pristine wilderness of Jim Corbett.',
                'short_description' => 'Exciting wildlife safari in Jim Corbett with tiger sightings and nature walks.',
                'featured_image' => 'uploads/itineraries/corbett-safari.jpg',
                'category_id' => $categoryMap['wildlife-safari'] ?? 7,
                'destination_id' => $destinationMap['jim-corbett-national-park'] ?? 11,
                'duration_days' => 4,
                'duration_nights' => 3,
                'price' => 35000.00,
                'discounted_price' => 30000.00,
                'inclusions' => 'Accommodation,All Meals,Safari Permits,Jeep Safari,Elephant Safari,Guide,Entry Fees',
                'exclusions' => 'Airfare,Personal Expenses,Travel Insurance,Camera Fees,Extra Safaris',
                'itinerary_details' => json_encode([
                    'Day 1' => 'Arrival Jim Corbett, Check-in jungle resort, Evening nature walk',
                    'Day 2' => 'Early morning jeep safari, Breakfast, Afternoon elephant safari, Wildlife photography',
                    'Day 3' => 'Dawn bird watching, Corbett Museum visit, Evening jeep safari, Bonfire',
                    'Day 4' => 'Check-out, Departure transfer to Kathgodam railway station'
                ]),
                'is_featured' => 1,
                'status' => 'published',
                'sort_order' => 12,
                'meta_title' => 'Jim Corbett Wildlife Safari 4 Days - Tiger Reserve Adventure',
                'meta_description' => 'Experience Jim Corbett wildlife safari with tiger sightings, elephant rides, and bird watching in pristine wilderness.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('itineraries')->insertBatch($data);
    }
}