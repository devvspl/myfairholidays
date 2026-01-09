<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Hotel FAQ Model
 * 
 * Handles hotel FAQ data operations
 * 
 * @package App\Models
 */
class HotelFaqModel extends Model
{
    protected $table            = 'hotel_faqs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'hotel_id', 'question', 'answer', 'sort_order', 'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'hotel_id' => 'required|integer',
        'question' => 'required|min_length[10]|max_length[500]',
        'answer' => 'required|min_length[10]',
        'sort_order' => 'permit_empty|integer',
        'is_active' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [
        'hotel_id' => [
            'required' => 'Hotel ID is required',
            'integer' => 'Hotel ID must be a valid number'
        ],
        'question' => [
            'required' => 'Question is required',
            'min_length' => 'Question must be at least 10 characters',
            'max_length' => 'Question cannot exceed 500 characters'
        ],
        'answer' => [
            'required' => 'Answer is required',
            'min_length' => 'Answer must be at least 10 characters'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    /**
     * Get active FAQs for a hotel
     * 
     * @param int $hotelId
     * @return array
     */
    public function getHotelFaqs(int $hotelId): array
    {
        return $this->where('hotel_id', $hotelId)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }

    /**
     * Get all FAQs for a hotel (including inactive for admin)
     * 
     * @param int $hotelId
     * @return array
     */
    public function getAllHotelFaqs(int $hotelId): array
    {
        return $this->where('hotel_id', $hotelId)
                    ->orderBy('sort_order', 'ASC')
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }

    /**
     * Update sort order for FAQs
     * 
     * @param array $sortData
     * @return bool
     */
    public function updateSortOrder(array $sortData): bool
    {
        $this->db->transStart();

        foreach ($sortData as $id => $order) {
            $this->update($id, ['sort_order' => $order]);
        }

        $this->db->transComplete();
        return $this->db->transStatus();
    }

    /**
     * Get default FAQs for new hotels
     * 
     * @return array
     */
    public function getDefaultFaqs(): array
    {
        return [
            [
                'question' => 'How to book this hotel?',
                'answer' => 'You can book this hotel by clicking the "Check Availability" button above and selecting your preferred dates. You can also contact us directly for personalized assistance with your booking.',
                'sort_order' => 1
            ],
            [
                'question' => 'What are the check-in and check-out times?',
                'answer' => 'Standard check-in time is 2:00 PM and check-out time is 12:00 PM. Early check-in and late check-out may be available upon request and subject to availability.',
                'sort_order' => 2
            ],
            [
                'question' => 'Is parking available?',
                'answer' => 'Yes, parking facilities are available. Please contact the hotel directly for specific parking arrangements and any associated fees.',
                'sort_order' => 3
            ],
            [
                'question' => 'What amenities are included?',
                'answer' => 'The hotel offers various amenities including WiFi, air conditioning, room service, and 24-hour front desk. Please see the amenities section above for a complete list.',
                'sort_order' => 4
            ],
            [
                'question' => 'Can I cancel my booking?',
                'answer' => 'Cancellation policies vary depending on the rate and booking conditions. Please review the specific cancellation terms during booking or contact us for more information about your reservation.',
                'sort_order' => 5
            ]
        ];
    }

    /**
     * Create default FAQs for a hotel
     * 
     * @param int $hotelId
     * @return bool
     */
    public function createDefaultFaqs(int $hotelId): bool
    {
        $defaultFaqs = $this->getDefaultFaqs();
        
        foreach ($defaultFaqs as $faq) {
            $faq['hotel_id'] = $hotelId;
            $faq['is_active'] = 1;
            $this->insert($faq);
        }
        
        return true;
    }
}