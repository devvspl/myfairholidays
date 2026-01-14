<?php

namespace App\Controllers;

use App\Models\HotelModel;
use App\Models\HotelImageModel;
use App\Models\HotelFaqModel;
use App\Models\PaymentHistoryModel;
use App\Models\BookingModel;
use App\Models\DestinationModel;
use App\Models\DestinationTypeModel;
use CodeIgniter\Controller;

/**
 * Booking Controller
 * 
 * Handles hotel booking process
 * 
 * @package App\Controllers
 * @author  Senior PHP Architect
 */
class BookingController extends Controller
{
    protected $hotelModel;
    protected $hotelImageModel;
    protected $hotelFaqModel;
    protected $paymentHistoryModel;
    protected $bookingModel;
    protected $destinationModel;
    protected $destinationTypeModel;
    protected $commonData;

    public function __construct()
    {
        $this->hotelModel = new HotelModel();
        $this->hotelImageModel = new HotelImageModel();
        $this->hotelFaqModel = new HotelFaqModel();
        $this->paymentHistoryModel = new PaymentHistoryModel();
        $this->bookingModel = new BookingModel();
        $this->destinationModel = new DestinationModel();
        $this->destinationTypeModel = new DestinationTypeModel();
        
        // Get destinations and destination types for all views
        $destinations = $this->destinationModel
            ->where('status', 'active')
            ->orderBy('name', 'ASC')
            ->findAll();
            
        $destinationTypes = $this->destinationTypeModel
            ->where('status', 'active')
            ->orderBy('sort_order', 'ASC')
            ->orderBy('name', 'ASC')
            ->findAll();
        
        // Common data for all views
        $this->commonData = [
            'site_name' => 'My Fair Holidays',
            'site_url' => base_url(),
            'current_url' => current_url(),
            'destinations' => $destinations,
            'destinationTypes' => $destinationTypes
        ];
    }

    /**
     * Step 1: Tour Review - Display booking summary
     */
    public function index()
    {
        $hotelId = $this->request->getVar('hotel_id');
        $bookingData = session()->get('booking_data');

        // If URL parameters are provided, store them in session
        if ($hotelId || $this->request->getVar('check_in_date')) {
            $urlBookingData = [
                'hotel_id' => $hotelId ?: ($bookingData['hotel_id'] ?? null),
                'check_in_date' => $this->request->getVar('check_in_date') ?: ($bookingData['check_in_date'] ?? date('Y-m-d', strtotime('+1 day'))),
                'check_out_date' => $this->request->getVar('check_out_date') ?: ($bookingData['check_out_date'] ?? date('Y-m-d', strtotime('+2 days'))),
                'rooms' => $this->request->getVar('rooms') ?: ($bookingData['rooms'] ?? 1),
                'adults' => $this->request->getVar('adults') ?: ($bookingData['adults'] ?? 2),
                'children' => $this->request->getVar('children') ?: ($bookingData['children'] ?? 0),
                'infants' => $this->request->getVar('infants') ?: ($bookingData['infants'] ?? 0),
                'special_requests' => $this->request->getVar('special_requests') ?: ($bookingData['special_requests'] ?? '')
            ];
            
            // Store in session
            session()->set('booking_data', $urlBookingData);
            $bookingData = $urlBookingData;
        }

        if (!$bookingData || !$bookingData['hotel_id']) {
            return redirect()->to('/hotels')->with('error', 'Please select a hotel to continue booking.');
        }

        // Get hotel details
        $hotel = $this->hotelModel->find($bookingData['hotel_id']);
        if (!$hotel) {
            return redirect()->to('/hotels')->with('error', 'Hotel not found.');
        }

        // Get hotel images
        $images = $this->hotelImageModel->where('hotel_id', $hotel['id'])
                                       ->orderBy('is_featured', 'DESC')
                                       ->orderBy('sort_order', 'ASC')
                                       ->findAll();

        // Get hotel FAQs
        $faqs = $this->hotelFaqModel->where('hotel_id', $hotel['id'])
                                   ->where('is_active', 1)
                                   ->orderBy('sort_order', 'ASC')
                                   ->findAll();

        // Ensure we have arrays even if empty
        $images = $images ?: [];
        $faqs = $faqs ?: [];

        // Calculate booking details
        $checkIn = new \DateTime($bookingData['check_in_date']);
        $checkOut = new \DateTime($bookingData['check_out_date']);
        $nights = $checkIn->diff($checkOut)->days;
        
        $rooms = $bookingData['rooms'];
        $adults = $bookingData['adults'];
        $children = $bookingData['children'];
        $infants = $bookingData['infants'];

        // Calculate pricing
        $basePrice = $hotel['price_per_night'] * $nights * $rooms;
        $discount = $hotel['is_featured'] ? ($basePrice * 0.15) : 0; // 15% discount for featured hotels
        $taxes = ($basePrice - $discount) * 0.08; // 8% taxes
        $totalPrice = $basePrice - $discount + $taxes;

        $data = array_merge($this->commonData, [
            'title' => 'Complete Your Booking - Step 1',
            'meta_description' => 'Review your hotel booking details and proceed to guest information.',
            'hotel' => $hotel,
            'images' => $images,
            'faqs' => $faqs,
            'bookingData' => $bookingData,
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'nights' => $nights,
            'rooms' => $rooms,
            'adults' => $adults,
            'children' => $children,
            'infants' => $infants,
            'basePrice' => $basePrice,
            'discount' => $discount,
            'taxes' => $taxes,
            'totalPrice' => $totalPrice,
            'currentStep' => 1
        ]);

        return view('public/booking/step1', $data);
    }

    /**
     * Step 2: Traveler Info - Collect guest details
     */
    public function step2()
    {
        $bookingData = session()->get('booking_data');
        if (!$bookingData) {
            return redirect()->to('/booking')->with('error', 'Please start the booking process again.');
        }

        // Get hotel details for summary
        $hotel = $this->hotelModel->find($bookingData['hotel_id']);
        if (!$hotel) {
            return redirect()->to('/hotels')->with('error', 'Hotel not found.');
        }

        // Calculate booking details
        $checkIn = new \DateTime($bookingData['check_in_date']);
        $checkOut = new \DateTime($bookingData['check_out_date']);
        $nights = $checkIn->diff($checkOut)->days;
        
        $rooms = $bookingData['rooms'];
        $adults = $bookingData['adults'];
        $children = $bookingData['children'] ?? 0;
        $infants = $bookingData['infants'] ?? 0;

        // Calculate pricing
        $basePrice = $hotel['price_per_night'] * $nights * $rooms;
        $discount = $hotel['is_featured'] ? ($basePrice * 0.15) : 0;
        $taxes = ($basePrice - $discount) * 0.08;
        $totalPrice = $basePrice - $discount + $taxes;

        $data = array_merge($this->commonData, [
            'title' => 'Guest Information - Step 2',
            'meta_description' => 'Enter guest details for your hotel booking.',
            'hotel' => $hotel,
            'bookingData' => $bookingData,
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'nights' => $nights,
            'rooms' => $rooms,
            'adults' => $adults,
            'children' => $children,
            'infants' => $infants,
            'basePrice' => $basePrice,
            'discount' => $discount,
            'taxes' => $taxes,
            'totalPrice' => $totalPrice,
            'currentStep' => 2
        ]);

        return view('public/booking/step2', $data);
    }

    /**
     * Process Step 2 - Save guest information
     */
    public function processStep2()
    {
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('/booking/step2');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'guests.*.first_name' => 'required|min_length[2]|max_length[50]',
            'guests.*.last_name' => 'required|min_length[2]|max_length[50]',
            'guests.*.date_of_birth' => 'required|valid_date',
            'guests.*.passport_number' => 'permit_empty|min_length[6]|max_length[20]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        try {
            $bookingData = session()->get('booking_data');
            if (!$bookingData) {
                return redirect()->to('/booking')->with('error', 'Please start the booking process again.');
            }

            // Get guest information
            $guestData = $this->request->getPost('guests');
            
            // Get hotel details for pricing calculation
            $hotel = $this->hotelModel->find($bookingData['hotel_id']);
            if (!$hotel) {
                return redirect()->to('/hotels')->with('error', 'Hotel not found.');
            }

            // Calculate booking details
            $checkIn = new \DateTime($bookingData['check_in_date']);
            $checkOut = new \DateTime($bookingData['check_out_date']);
            $nights = $checkIn->diff($checkOut)->days;
            
            // Calculate pricing
            $basePrice = $hotel['price_per_night'] * $nights * $bookingData['rooms'];
            $discount = $hotel['is_featured'] ? ($basePrice * 0.15) : 0;
            $taxes = ($basePrice - $discount) * 0.08;
            $totalAmount = $basePrice - $discount + $taxes;

            // Prepare booking data for database
            $bookingDbData = [
                'hotel_id' => $bookingData['hotel_id'],
                'customer_name' => $guestData[0]['first_name'] . ' ' . $guestData[0]['last_name'], // Primary guest
                'customer_email' => session()->get('temp_customer_email') ?: 'guest@example.com', // Will be updated in step 3
                'customer_phone' => session()->get('temp_customer_phone') ?: '0000000000', // Will be updated in step 3
                'check_in_date' => $bookingData['check_in_date'],
                'check_out_date' => $bookingData['check_out_date'],
                'nights' => $nights,
                'rooms' => $bookingData['rooms'],
                'adults' => $bookingData['adults'],
                'children' => $bookingData['children'],
                'infants' => $bookingData['infants'],
                'guest_details' => json_encode($guestData),
                'special_requests' => $bookingData['special_requests'] ?? null,
                'base_price' => $basePrice,
                'discount' => $discount,
                'taxes' => $taxes,
                'total_amount' => $totalAmount,
                'payment_status' => 'pending',
                'booking_status' => 'pending'
            ];

            // Check if booking already exists in session
            $bookingId = session()->get('booking_id');
            
            if ($bookingId) {
                // Update existing booking
                $this->bookingModel->update($bookingId, $bookingDbData);
            } else {
                // Create new booking
                $bookingId = $this->bookingModel->insert($bookingDbData);
                session()->set('booking_id', $bookingId);
            }

            // Save guest information to session for step 3
            session()->set('guest_data', $guestData);

            return redirect()->to('/booking/step3');

        } catch (\Exception $e) {
            log_message('error', 'Booking Step 2 error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'An error occurred while processing your information. Please try again.');
        }
    }

    /**
     * Step 3: Payment - Billing details and payment
     */
    public function step3()
    {
        $bookingData = session()->get('booking_data');
        $guestData = session()->get('guest_data');
        
        if (!$bookingData || !$guestData) {
            return redirect()->to('/booking')->with('error', 'Please complete all previous steps.');
        }

        // Get hotel details
        $hotel = $this->hotelModel->find($bookingData['hotel_id']);
        if (!$hotel) {
            return redirect()->to('/hotels')->with('error', 'Hotel not found.');
        }

        // Calculate booking details
        $checkIn = new \DateTime($bookingData['check_in_date']);
        $checkOut = new \DateTime($bookingData['check_out_date']);
        $nights = $checkIn->diff($checkOut)->days;
        
        $rooms = $bookingData['rooms'];
        $adults = $bookingData['adults'];
        $children = $bookingData['children'] ?? 0;
        $infants = $bookingData['infants'] ?? 0;

        // Calculate pricing
        $basePrice = $hotel['price_per_night'] * $nights * $rooms;
        $discount = $hotel['is_featured'] ? ($basePrice * 0.15) : 0;
        $taxes = ($basePrice - $discount) * 0.08;
        $totalPrice = $basePrice - $discount + $taxes;

        $data = array_merge($this->commonData, [
            'title' => 'Payment & Billing - Step 3',
            'meta_description' => 'Complete your hotel booking payment.',
            'hotel' => $hotel,
            'bookingData' => $bookingData,
            'guestData' => $guestData,
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'nights' => $nights,
            'rooms' => $rooms,
            'adults' => $adults,
            'children' => $children,
            'infants' => $infants,
            'basePrice' => $basePrice,
            'discount' => $discount,
            'taxes' => $taxes,
            'totalPrice' => $totalPrice,
            'currentStep' => 3
        ]);

        return view('public/booking/step3', $data);
    }

    /**
     * Process Payment
     */
    public function processPayment()
    {
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('/booking/step3');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'billing_name' => 'required|min_length[2]|max_length[100]',
            'billing_email' => 'required|valid_email',
            'billing_phone' => 'required|min_length[10]|max_length[20]',
            'billing_address1' => 'required|min_length[5]|max_length[255]',
            'billing_city' => 'required|min_length[2]|max_length[100]',
            'billing_country' => 'required|min_length[2]|max_length[100]',
            'billing_postal_code' => 'required|min_length[3]|max_length[20]',
            'payment_method' => 'required|in_list[visa,mastercard,paypal,amazon_pay]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        try {
            $bookingId = session()->get('booking_id');
            if (!$bookingId) {
                return redirect()->to('/booking')->with('error', 'Please start the booking process again.');
            }

            $billingData = $this->request->getPost();
            
            // Generate payment reference
            $paymentReference = 'PAY-' . date('Ymd') . '-' . strtoupper(uniqid());

            // Update booking with billing information and payment details
            $updateData = [
                'customer_name' => $billingData['billing_name'],
                'customer_email' => $billingData['billing_email'],
                'customer_phone' => $billingData['billing_phone'],
                'billing_details' => json_encode([
                    'name' => $billingData['billing_name'],
                    'email' => $billingData['billing_email'],
                    'phone' => $billingData['billing_phone'],
                    'address1' => $billingData['billing_address1'],
                    'address2' => $billingData['billing_address2'] ?? '',
                    'city' => $billingData['billing_city'],
                    'state' => $billingData['billing_state'] ?? '',
                    'country' => $billingData['billing_country'],
                    'postal_code' => $billingData['billing_postal_code']
                ]),
                'payment_method' => $billingData['payment_method'],
                'payment_reference' => $paymentReference,
                'notes' => $billingData['special_notes'] ?? null,
                'booking_status' => 'confirmed',
                'payment_status' => 'paid', // In real implementation, this would be 'pending' until payment gateway confirms
                'confirmed_at' => date('Y-m-d H:i:s')
            ];

            // Update the booking
            $this->bookingModel->update($bookingId, $updateData);

            // Get complete booking data for confirmation
            $booking = $this->bookingModel->getBookingWithHotel($bookingId);
            
            // Store complete booking data for success page
            session()->set('booking_complete', [
                'booking_id' => $bookingId,
                'booking_reference' => $booking['booking_reference'],
                'hotel' => [
                    'id' => $booking['hotel_id'],
                    'name' => $booking['hotel_name'],
                    'address' => $booking['hotel_address'],
                    'star_rating' => $booking['star_rating']
                ],
                'booking_data' => [
                    'check_in_date' => $booking['check_in_date'],
                    'check_out_date' => $booking['check_out_date'],
                    'nights' => $booking['nights'],
                    'rooms' => $booking['rooms'],
                    'adults' => $booking['adults'],
                    'children' => $booking['children'],
                    'infants' => $booking['infants']
                ],
                'guest_data' => json_decode($booking['guest_details'], true),
                'billing_data' => json_decode($booking['billing_details'], true),
                'payment_data' => [
                    'amount' => $booking['total_amount'],
                    'currency' => 'INR',
                    'payment_method' => $booking['payment_method'],
                    'payment_reference' => $booking['payment_reference'],
                    'status' => $booking['payment_status']
                ],
                'pricing' => [
                    'base_price' => $booking['base_price'],
                    'discount' => $booking['discount'],
                    'taxes' => $booking['taxes'],
                    'total_amount' => $booking['total_amount']
                ]
            ]);

            // In a real implementation, you would:
            // 1. Process payment with payment gateway
            // 2. Send confirmation emails
            // 3. Update payment status based on gateway response

            return redirect()->to('/booking/success');

        } catch (\Exception $e) {
            log_message('error', 'Payment processing error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Payment processing failed. Please try again.');
        }
    }

    /**
     * Booking Success Page
     */
    public function success()
    {
        $bookingComplete = session()->get('booking_complete');
        if (!$bookingComplete) {
            return redirect()->to('/hotels')->with('error', 'No booking found.');
        }

        $data = array_merge($this->commonData, [
            'title' => 'Booking Confirmed!',
            'meta_description' => 'Your hotel booking has been confirmed successfully.',
            'bookingComplete' => $bookingComplete
        ]);

        // Clear booking session data but keep booking_complete for the success page
        session()->remove(['booking_data', 'guest_data', 'booking_id']);

        return view('public/booking/success', $data);
    }
}