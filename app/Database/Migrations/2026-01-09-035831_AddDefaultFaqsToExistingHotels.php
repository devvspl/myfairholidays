<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDefaultFaqsToExistingHotels extends Migration
{
    public function up()
    {
        // Get all existing hotels
        $hotels = $this->db->table('hotels')->select('id')->get()->getResultArray();
        
        if (empty($hotels)) {
            return; // No hotels to process
        }

        // Default FAQs template
        $defaultFaqs = [
            [
                'question' => 'How to book this hotel?',
                'answer' => 'You can book this hotel by clicking the "Check Availability" button above and selecting your preferred dates. You can also contact us directly for personalized assistance with your booking.',
                'sort_order' => 1,
                'is_active' => 1
            ],
            [
                'question' => 'What are the check-in and check-out times?',
                'answer' => 'Standard check-in time is 2:00 PM and check-out time is 12:00 PM. Early check-in and late check-out may be available upon request and subject to availability.',
                'sort_order' => 2,
                'is_active' => 1
            ],
            [
                'question' => 'Is parking available?',
                'answer' => 'Yes, parking facilities are available. Please contact the hotel directly for specific parking arrangements and any associated fees.',
                'sort_order' => 3,
                'is_active' => 1
            ],
            [
                'question' => 'What amenities are included?',
                'answer' => 'The hotel offers various amenities including WiFi, air conditioning, room service, and 24-hour front desk. Please see the amenities section above for a complete list.',
                'sort_order' => 4,
                'is_active' => 1
            ],
            [
                'question' => 'Can I cancel my booking?',
                'answer' => 'Cancellation policies vary depending on the rate and booking conditions. Please review the specific cancellation terms during booking or contact us for more information about your reservation.',
                'sort_order' => 5,
                'is_active' => 1
            ]
        ];

        // Add FAQs for each hotel
        foreach ($hotels as $hotel) {
            // Check if hotel already has FAQs
            $existingFaqs = $this->db->table('hotel_faqs')
                                   ->where('hotel_id', $hotel['id'])
                                   ->countAllResults();
            
            if ($existingFaqs == 0) {
                // Add default FAQs for this hotel
                foreach ($defaultFaqs as $faq) {
                    $faq['hotel_id'] = $hotel['id'];
                    $faq['created_at'] = date('Y-m-d H:i:s');
                    $faq['updated_at'] = date('Y-m-d H:i:s');
                    
                    $this->db->table('hotel_faqs')->insert($faq);
                }
            }
        }
    }

    public function down()
    {
        // Remove all default FAQs (optional - you might want to keep them)
        $this->db->table('hotel_faqs')->truncate();
    }
}