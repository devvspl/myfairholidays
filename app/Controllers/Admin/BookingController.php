<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\HotelModel;

class BookingController extends BaseController
{
    protected $bookingModel;
    protected $hotelModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->hotelModel = new HotelModel();
    }

    /**
     * Display bookings list
     */
    public function index()
    {
        $perPage = 20;
        $page = $this->request->getVar('page') ?? 1;
        
        // Get filters
        $filters = [
            'status' => $this->request->getVar('status'),
            'payment_status' => $this->request->getVar('payment_status'),
            'search' => $this->request->getVar('search'),
            'date_from' => $this->request->getVar('date_from'),
            'date_to' => $this->request->getVar('date_to')
        ];

        // Build query
        $builder = $this->bookingModel->select('bookings.*, hotels.name as hotel_name')
                                     ->join('hotels', 'hotels.id = bookings.hotel_id');

        // Apply filters
        if (!empty($filters['status'])) {
            $builder->where('bookings.booking_status', $filters['status']);
        }

        if (!empty($filters['payment_status'])) {
            $builder->where('bookings.payment_status', $filters['payment_status']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart()
                   ->like('bookings.booking_reference', $filters['search'])
                   ->orLike('bookings.customer_name', $filters['search'])
                   ->orLike('bookings.customer_email', $filters['search'])
                   ->orLike('hotels.name', $filters['search'])
                   ->groupEnd();
        }

        if (!empty($filters['date_from'])) {
            $builder->where('bookings.created_at >=', $filters['date_from'] . ' 00:00:00');
        }

        if (!empty($filters['date_to'])) {
            $builder->where('bookings.created_at <=', $filters['date_to'] . ' 23:59:59');
        }

        // Get paginated results
        $bookings = $builder->orderBy('bookings.created_at', 'DESC')
                           ->paginate($perPage);

        $pager = $this->bookingModel->pager;

        // Get statistics
        $stats = [
            'total' => $this->bookingModel->countAll(),
            'pending' => $this->bookingModel->where('booking_status', 'pending')->countAllResults(false),
            'confirmed' => $this->bookingModel->where('booking_status', 'confirmed')->countAllResults(false),
            'cancelled' => $this->bookingModel->where('booking_status', 'cancelled')->countAllResults(false),
            'completed' => $this->bookingModel->where('booking_status', 'completed')->countAllResults(false)
        ];

        $data = [
            'title' => 'Booking Management',
            'bookings' => $bookings,
            'pager' => $pager,
            'filters' => $filters,
            'stats' => $stats
        ];

        return view('admin/bookings/index', $data);
    }

    /**
     * Show booking details
     */
    public function show($id)
    {
        $booking = $this->bookingModel->getBookingWithHotel($id);
        
        if (!$booking) {
            return redirect()->to('/admin/bookings')->with('error', 'Booking not found.');
        }

        // Decode JSON fields
        $booking['guest_details'] = json_decode($booking['guest_details'], true);
        $booking['billing_details'] = json_decode($booking['billing_details'], true);

        $data = [
            'title' => 'Booking Details - ' . $booking['booking_reference'],
            'booking' => $booking
        ];

        return view('admin/bookings/show', $data);
    }

    /**
     * Update booking status
     */
    public function updateStatus($id)
    {
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->back();
        }

        $status = $this->request->getPost('status');
        $notes = $this->request->getPost('notes');

        if (!in_array($status, ['pending', 'confirmed', 'cancelled', 'completed'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        try {
            $this->bookingModel->updateBookingStatus($id, $status, $notes);
            return redirect()->back()->with('success', 'Booking status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update booking status.');
        }
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus($id)
    {
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->back();
        }

        $paymentStatus = $this->request->getPost('payment_status');
        $paymentReference = $this->request->getPost('payment_reference');

        if (!in_array($paymentStatus, ['pending', 'paid', 'failed', 'refunded'])) {
            return redirect()->back()->with('error', 'Invalid payment status.');
        }

        try {
            $this->bookingModel->updatePaymentStatus($id, $paymentStatus, $paymentReference);
            return redirect()->back()->with('success', 'Payment status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update payment status.');
        }
    }
}
