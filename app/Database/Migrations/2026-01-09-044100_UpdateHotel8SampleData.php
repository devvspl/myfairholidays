<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateHotel8SampleData extends Migration
{
    public function up()
    {
        // Update Hotel ID 8 with comprehensive sample data
        $data = [
            'name' => 'Grand Palace Resort & Spa',
            'slug' => 'grand-palace-resort-spa',
            'description' => '<h2>Welcome to Grand Palace Resort & Spa</h2>
<p>Experience luxury redefined at the <strong>Grand Palace Resort & Spa</strong>, where traditional elegance meets modern sophistication. Nestled in the heart of paradise, our resort offers an unparalleled escape from the ordinary.</p>

<h3>Luxurious Accommodations</h3>
<p>Our meticulously designed rooms and suites feature:</p>
<ul>
<li>Premium Egyptian cotton linens and plush bedding</li>
<li>Marble bathrooms with rainfall showers and soaking tubs</li>
<li>Private balconies with breathtaking views</li>
<li>State-of-the-art entertainment systems</li>
<li>Complimentary high-speed Wi-Fi throughout</li>
</ul>

<h3>World-Class Dining</h3>
<p>Indulge your senses at our award-winning restaurants:</p>
<ul>
<li><strong>The Royal Terrace</strong> - Fine dining with panoramic city views</li>
<li><strong>Spice Garden</strong> - Authentic local cuisine and international favorites</li>
<li><strong>Sunset Lounge</strong> - Craft cocktails and light bites</li>
<li><strong>Pool Bar & Grill</strong> - Casual dining by the infinity pool</li>
</ul>

<h3>Wellness & Recreation</h3>
<p>Rejuvenate your mind, body, and soul with our comprehensive wellness facilities:</p>
<ul>
<li>Full-service spa with traditional and modern treatments</li>
<li>State-of-the-art fitness center with personal trainers</li>
<li>Infinity pool overlooking the ocean</li>
<li>Tennis court and water sports equipment</li>
<li>Yoga pavilion for morning and sunset sessions</li>
</ul>

<blockquote>
<p>"A sanctuary of luxury where every detail is crafted to create unforgettable memories."</p>
</blockquote>',
            'short_description' => 'Experience luxury redefined at Grand Palace Resort & Spa, where traditional elegance meets modern sophistication in the heart of paradise.',
            'destination_id' => 1,
            'address' => '123 Paradise Boulevard, Luxury District, Dream City 12345',
            'latitude' => 25.2048493,
            'longitude' => 55.2707828,
            'star_rating' => 5,
            'price_per_night' => 450.00,
            'amenities' => 'Free Wi-Fi,Swimming Pool,Spa & Wellness Center,Fitness Center,Restaurant,Room Service,Concierge,Valet Parking,Business Center,Conference Rooms,Airport Shuttle,Laundry Service,Pet Friendly,Air Conditioning,Mini Bar,Safe,Balcony,Ocean View,Tennis Court,Water Sports',
            'contact_phone' => '+1 (555) 123-4567',
            'contact_email' => 'reservations@grandpalaceresort.com',
            'website' => 'https://www.grandpalaceresort.com',
            'is_featured' => 1,
            'status' => 'active',
            'sort_order' => 1,
            'meta_title' => 'Grand Palace Resort & Spa - Luxury 5-Star Hotel | Premium Accommodations',
            'meta_description' => 'Book your stay at Grand Palace Resort & Spa, a luxury 5-star hotel featuring world-class amenities, spa services, fine dining, and breathtaking ocean views. Experience unparalleled hospitality.',
            'meta_keywords' => 'luxury hotel, 5-star resort, spa hotel, ocean view, fine dining, premium accommodations, wellness center, infinity pool, concierge service, valet parking, business center, conference facilities',
            'check_in_time' => '3:00 PM',
            'check_out_time' => '12:00 PM',
            'cancellation_policy' => '<h4>Flexible Cancellation Policy</h4>
<p><strong>Standard Reservations:</strong></p>
<ul>
<li>Free cancellation up to 48 hours before arrival</li>
<li>Cancellations within 48 hours: 1 night charge</li>
<li>No-show: Full stay charge</li>
</ul>

<p><strong>Peak Season & Special Events:</strong></p>
<ul>
<li>Free cancellation up to 7 days before arrival</li>
<li>Cancellations within 7 days: 50% of total stay</li>
<li>Cancellations within 48 hours: Full stay charge</li>
</ul>

<p><strong>Group Bookings (10+ rooms):</strong></p>
<ul>
<li>Custom cancellation terms apply</li>
<li>Contact our group reservations team for details</li>
</ul>

<p><em>All cancellations must be made by 6:00 PM hotel time on the cancellation date. Refunds will be processed within 5-7 business days.</em></p>',
            'hotel_policies' => '<h4>Hotel Policies & Guidelines</h4>

<p><strong>Age Requirements:</strong></p>
<ul>
<li>Minimum check-in age: 21 years</li>
<li>Children under 12 stay free with existing bedding</li>
<li>Maximum occupancy: 4 guests per room</li>
</ul>

<p><strong>Pet Policy:</strong></p>
<ul>
<li>Pet-friendly accommodations available</li>
<li>Pet fee: $75 per night, per pet</li>
<li>Maximum 2 pets per room (under 50 lbs each)</li>
<li>Pets must be leashed in public areas</li>
</ul>

<p><strong>Smoking Policy:</strong></p>
<ul>
<li>100% non-smoking property</li>
<li>Designated outdoor smoking areas available</li>
<li>Smoking violation fee: $250</li>
</ul>

<p><strong>Additional Policies:</strong></p>
<ul>
<li>Valid photo ID and credit card required at check-in</li>
<li>Resort fee: $35 per night (includes Wi-Fi, fitness center, pool access)</li>
<li>Parking: Complimentary valet parking for registered guests</li>
<li>Quiet hours: 10:00 PM - 7:00 AM</li>
<li>Pool hours: 6:00 AM - 11:00 PM</li>
<li>Spa reservations recommended 24 hours in advance</li>
</ul>',
            'nearby_attractions' => '<h4>Discover Local Attractions</h4>

<p><strong>Cultural & Historical Sites (Within 5 miles):</strong></p>
<ul>
<li><strong>Royal Palace Museum</strong> - 0.8 miles | Explore centuries of royal heritage</li>
<li><strong>Ancient Temple Complex</strong> - 1.2 miles | Sacred grounds with stunning architecture</li>
<li><strong>Heritage Art Gallery</strong> - 1.5 miles | Local and international art collections</li>
<li><strong>Old Town Market</strong> - 2.1 miles | Traditional crafts and local delicacies</li>
</ul>

<p><strong>Natural Attractions:</strong></p>
<ul>
<li><strong>Paradise Beach</strong> - 0.3 miles | Pristine white sand beach</li>
<li><strong>Coral Reef Snorkeling</strong> - 0.5 miles | World-class diving and snorkeling</li>
<li><strong>Tropical Gardens</strong> - 1.8 miles | Botanical paradise with rare species</li>
<li><strong>Sunset Point Lookout</strong> - 3.2 miles | Panoramic views and hiking trails</li>
</ul>

<p><strong>Entertainment & Shopping:</strong></p>
<ul>
<li><strong>Marina District</strong> - 1.0 mile | Upscale shopping and waterfront dining</li>
<li><strong>Grand Casino Resort</strong> - 2.5 miles | Gaming, shows, and nightlife</li>
<li><strong>Adventure Water Park</strong> - 4.1 miles | Family-friendly water attractions</li>
<li><strong>Championship Golf Course</strong> - 3.8 miles | 18-hole oceanfront course</li>
</ul>

<p><strong>Day Trip Destinations:</strong></p>
<ul>
<li><strong>Mountain Village</strong> - 25 miles | Traditional culture and scenic views</li>
<li><strong>National Wildlife Reserve</strong> - 35 miles | Guided safari tours available</li>
<li><strong>Historic Lighthouse</strong> - 18 miles | Coastal views and maritime history</li>
</ul>',
            'transportation_info' => '<h4>Transportation & Accessibility</h4>

<p><strong>Airport Transportation:</strong></p>
<ul>
<li><strong>Distance:</strong> 12 miles from International Airport</li>
<li><strong>Complimentary Shuttle:</strong> Available every 30 minutes (6 AM - 11 PM)</li>
<li><strong>Private Transfer:</strong> Luxury sedan service available ($85 each way)</li>
<li><strong>Helicopter Service:</strong> VIP helicopter transfers ($450 per person)</li>
<li><strong>Travel Time:</strong> 25-35 minutes by car, 8 minutes by helicopter</li>
</ul>

<p><strong>Local Transportation:</strong></p>
<ul>
<li><strong>Complimentary Hotel Shuttle:</strong> To Marina District and Beach (every 15 minutes)</li>
<li><strong>Taxi Service:</strong> Available 24/7 through concierge</li>
<li><strong>Car Rental:</strong> On-site Hertz and Avis counters</li>
<li><strong>Bicycle Rental:</strong> Complimentary for guests (subject to availability)</li>
<li><strong>Electric Scooters:</strong> Available for rent ($25/day)</li>
</ul>

<p><strong>Public Transportation:</strong></p>
<ul>
<li><strong>Metro Station:</strong> Paradise Central - 0.7 miles (10-minute walk)</li>
<li><strong>Bus Stop:</strong> Resort Boulevard - 0.2 miles</li>
<li><strong>Ferry Terminal:</strong> Marina Pier - 1.1 miles (island hopping tours)</li>
</ul>

<p><strong>Parking Information:</strong></p>
<ul>
<li><strong>Valet Parking:</strong> Complimentary for registered guests</li>
<li><strong>Self-Parking:</strong> Available ($15/day for non-guests)</li>
<li><strong>Electric Vehicle Charging:</strong> Tesla Supercharger and universal stations</li>
<li><strong>Oversized Vehicle Parking:</strong> Available with advance notice</li>
</ul>

<p><strong>Accessibility Features:</strong></p>
<ul>
<li>Wheelchair accessible entrances and elevators</li>
<li>ADA compliant rooms available</li>
<li>Accessible parking spaces</li>
<li>Hearing impaired assistance available</li>
<li>Service animal friendly</li>
</ul>',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('hotels')->where('id', 8)->update($data);
    }

    public function down()
    {
        // Optionally restore original data if needed
        // This is just a placeholder - in real scenarios you might want to backup original data
    }
}