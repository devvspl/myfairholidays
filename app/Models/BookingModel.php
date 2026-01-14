<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Booking Model
 * 
 * Handles booking data operations
 * 
 * @package App\Models
 */
class BookingModel extends Model
{
    protected $table            = 'bookings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'booking_reference', 'hotel_id', 'customer_name', 'customer_email', 'customer_phone',
        'check_in_date', 'check_out_date', 'nights', 'rooms', 'adults', 'children', 'infants',
        'guest_details', 'special_requests', 'base_price', 'discount', 'taxes', 'total_amount',
        'payment_status', 'booking_status', 'billing_details', 'payment_method', 'payment_reference',
        'notes', 'created_by', 'confirmed_at', 'cancelled_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'booking_reference' => 'permit_empty|max_length[50]|is_unique[bookings.booking_reference,id,{id}]',
        'hotel_id' => 'required|integer',
        'customer_name' => 'required|min_length[2]|max_length[100]',
        'customer_email' => 'required|valid_email|max_length[100]',
        'customer_phone' => 'required|min_length[10]|max_length[20]',
        'check_in_date' => 'required|valid_date',
        'check_out_date' => 'required|valid_date',
        'nights' => 'required|integer|greater_than[0]',
        'rooms' => 'required|integer|greater_than[0]',
        'adults' => 'required|integer|greater_than[0]',
        'children' => 'permit_empty|integer',
        'infants' => 'permit_empty|integer',
        'total_amount' => 'required|decimal',
        'payment_status' => 'required|in_list[pending,paid,failed,refunded]',
        'booking_status' => 'required|in_list[pending,confirmed,cancelled,completed]'
    ];

    protected $validationMessages = [
        'booking_reference' => [
            'required' => 'Booking reference is required',
            'is_unique' => 'Booking reference must be unique'
        ],
        'hotel_id' => [
            'required' => 'Hotel ID is required',
            'integer' => 'Hotel ID must be a valid number'
        ],
        'customer_name' => [
            'required' => 'Customer name is required',
            'min_length' => 'Customer name must be at least 2 characters',
            'max_length' => 'Customer name cannot exceed 100 characters'
        ],
        'customer_email' => [
            'required' => 'Customer email is required',
            'valid_email' => 'Please provide a valid email address'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['generateBookingReference'];

    /**
     * Generate unique booking reference
     */
    protected function generateBookingReference(array $data)
    {
        if (!isset($data['data']['booking_reference'])) {
            $data['data']['booking_reference'] = 'BK-' . date('Ymd') . '-' . strtoupper(uniqid());
        }
        return $data;
    }

    /**
     * Get booking with hotel details
     */
    public function getBookingWithHotel($bookingId)
    {
        return $this->select('bookings.*, hotels.name as hotel_name, hotels.address as hotel_address, hotels.star_rating')
                    ->join('hotels', 'hotels.id = bookings.hotel_id')
                    ->where('bookings.id', $bookingId)
                    ->first();
    }

    /**
     * Get bookings by customer email
     */
    public function getCustomerBookings($email, $limit = 10)
    {
        return $this->select('bookings.*, hotels.name as hotel_name')
                    ->join('hotels', 'hotels.id = bookings.hotel_id')
                    ->where('bookings.customer_email', $email)
                    ->orderBy('bookings.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Update booking status
     */
    public function updateBookingStatus($bookingId, $status, $notes = null)
    {
        $updateData = ['booking_status' => $status];
        
        if ($status === 'confirmed') {
            $updateData['confirmed_at'] = date('Y-m-d H:i:s');
        } elseif ($status === 'cancelled') {
            $updateData['cancelled_at'] = date('Y-m-d H:i:s');
        }
        
        if ($notes) {
            $updateData['notes'] = $notes;
        }
        
        return $this->update($bookingId, $updateData);
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus($bookingId, $paymentStatus, $paymentReference = null)
    {
        $updateData = ['payment_status' => $paymentStatus];
        
        if ($paymentReference) {
            $updateData['payment_reference'] = $paymentReference;
        }
        
        return $this->update($bookingId, $updateData);
    }
}
