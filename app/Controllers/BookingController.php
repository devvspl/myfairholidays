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

        // Calculate pricing with hotel discount
        $pricePerNight = $hotel['price_per_night'];
        $basePrice = $pricePerNight * $nights * $rooms;
        
        // Calculate discount using hotel's discount settings
        $discountInfo = $this->hotelModel->calculateDiscountedPrice($hotel);
        $discountPerNight = $discountInfo['discount_amount'];
        $discount = $discountPerNight * $nights * $rooms;
        
        // Calculate taxes on discounted price
        $priceAfterDiscount = $basePrice - $discount;
        $taxes = $priceAfterDiscount * 0.08; // 8% taxes
        $totalPrice = $priceAfterDiscount + $taxes;

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
            'pricePerNight' => $pricePerNight,
            'basePrice' => $basePrice,
            'discount' => $discount,
            'discountInfo' => $discountInfo,
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

        // Calculate pricing with hotel discount
        $pricePerNight = $hotel['price_per_night'];
        $basePrice = $pricePerNight * $nights * $rooms;
        
        // Calculate discount using hotel's discount settings
        $discountInfo = $this->hotelModel->calculateDiscountedPrice($hotel);
        $discountPerNight = $discountInfo['discount_amount'];
        $discount = $discountPerNight * $nights * $rooms;
        
        // Calculate taxes on discounted price
        $priceAfterDiscount = $basePrice - $discount;
        $taxes = $priceAfterDiscount * 0.08; // 8% taxes
        $totalPrice = $priceAfterDiscount + $taxes;

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
            'pricePerNight' => $pricePerNight,
            'basePrice' => $basePrice,
            'discount' => $discount,
            'discountInfo' => $discountInfo,
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
            'customer_name' => 'required|min_length[3]|max_length[100]',
            'customer_email' => 'required|valid_email',
            'customer_phone' => 'required|min_length[10]|max_length[20]',
            'customer_country' => 'required|min_length[2]|max_length[100]',
            'special_requests' => 'permit_empty|max_length[1000]',
            'check_in_date' => 'permit_empty|valid_date',
            'check_out_date' => 'permit_empty|valid_date',
            'rooms' => 'permit_empty|integer|greater_than[0]',
            'adults' => 'permit_empty|integer|greater_than[0]',
            'children' => 'permit_empty|integer',
            'infants' => 'permit_empty|integer'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        try {
            $bookingData = session()->get('booking_data');
            if (!$bookingData) {
                return redirect()->to('/booking')->with('error', 'Please start the booking process again.');
            }

            // Check if dates were modified
            $checkInDate = $this->request->getPost('check_in_date');
            $checkOutDate = $this->request->getPost('check_out_date');
            
            if (!empty($checkInDate) && !empty($checkOutDate)) {
                // Validate dates
                $checkIn = new \DateTime($checkInDate);
                $checkOut = new \DateTime($checkOutDate);
                $today = new \DateTime('today');
                
                if ($checkIn < $today) {
                    return redirect()->back()->withInput()->with('error', 'Check-in date cannot be in the past.');
                }
                
                if ($checkOut <= $checkIn) {
                    return redirect()->back()->withInput()->with('error', 'Check-out date must be after check-in date.');
                }
                
                // Update booking data with new dates
                $bookingData['check_in_date'] = $checkInDate;
                $bookingData['check_out_date'] = $checkOutDate;
            }
            
            // Check if rooms and guests were modified
            $rooms = $this->request->getPost('rooms');
            $adults = $this->request->getPost('adults');
            $children = $this->request->getPost('children');
            $infants = $this->request->getPost('infants');
            
            if (!empty($rooms)) {
                $bookingData['rooms'] = (int)$rooms;
            }
            if (!empty($adults)) {
                $bookingData['adults'] = (int)$adults;
            }
            if (isset($children)) {
                $bookingData['children'] = (int)$children;
            }
            if (isset($infants)) {
                $bookingData['infants'] = (int)$infants;
            }
            
            // Update session with modified booking data
            session()->set('booking_data', $bookingData);

            // Get customer information
            $customerName = $this->request->getPost('customer_name');
            $customerEmail = $this->request->getPost('customer_email');
            $customerPhone = $this->request->getPost('customer_phone');
            $customerCountry = $this->request->getPost('customer_country');
            $specialRequests = $this->request->getPost('special_requests');
            
            // Get hotel details for pricing calculation
            $hotel = $this->hotelModel->find($bookingData['hotel_id']);
            if (!$hotel) {
                return redirect()->to('/hotels')->with('error', 'Hotel not found.');
            }

            // Calculate booking details
            $checkIn = new \DateTime($bookingData['check_in_date']);
            $checkOut = new \DateTime($bookingData['check_out_date']);
            $nights = $checkIn->diff($checkOut)->days;
            
            // Calculate pricing with hotel discount
            $pricePerNight = $hotel['price_per_night'];
            $basePrice = $pricePerNight * $nights * $bookingData['rooms'];
            
            // Calculate discount using hotel's discount settings
            $discountInfo = $this->hotelModel->calculateDiscountedPrice($hotel);
            $discountPerNight = $discountInfo['discount_amount'];
            $discount = $discountPerNight * $nights * $bookingData['rooms'];
            
            // Calculate taxes on discounted price
            $priceAfterDiscount = $basePrice - $discount;
            $taxes = $priceAfterDiscount * 0.08; // 8% taxes
            $totalAmount = $priceAfterDiscount + $taxes;

            // Prepare booking data for database
            $bookingDbData = [
                'hotel_id' => $bookingData['hotel_id'],
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'customer_phone' => $customerPhone,
                'check_in_date' => $bookingData['check_in_date'],
                'check_out_date' => $bookingData['check_out_date'],
                'nights' => $nights,
                'rooms' => $bookingData['rooms'],
                'adults' => $bookingData['adults'],
                'children' => $bookingData['children'] ?? 0,
                'infants' => $bookingData['infants'] ?? 0,
                'guest_details' => json_encode([
                    'name' => $customerName,
                    'email' => $customerEmail,
                    'phone' => $customerPhone,
                    'country' => $customerCountry
                ]),
                'special_requests' => $specialRequests,
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

            // Save customer information to session for step 3
            session()->set('customer_data', [
                'name' => $customerName,
                'email' => $customerEmail,
                'phone' => $customerPhone,
                'country' => $customerCountry
            ]);

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
        $customerData = session()->get('customer_data');
        
        if (!$bookingData || !$customerData) {
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

        // Calculate pricing with hotel discount
        $pricePerNight = $hotel['price_per_night'];
        $basePrice = $pricePerNight * $nights * $rooms;
        
        // Calculate discount using hotel's discount settings
        $discountInfo = $this->hotelModel->calculateDiscountedPrice($hotel);
        $discountPerNight = $discountInfo['discount_amount'];
        $discount = $discountPerNight * $nights * $rooms;
        
        // Calculate taxes on discounted price
        $priceAfterDiscount = $basePrice - $discount;
        $taxes = $priceAfterDiscount * 0.08; // 8% taxes
        $totalPrice = $priceAfterDiscount + $taxes;

        $data = array_merge($this->commonData, [
            'title' => 'Payment & Billing - Step 3',
            'meta_description' => 'Complete your hotel booking payment.',
            'hotel' => $hotel,
            'bookingData' => $bookingData,
            'customerData' => $customerData,
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'nights' => $nights,
            'rooms' => $rooms,
            'adults' => $adults,
            'children' => $children,
            'infants' => $infants,
            'pricePerNight' => $pricePerNight,
            'basePrice' => $basePrice,
            'discount' => $discount,
            'discountInfo' => $discountInfo,
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

            $customerData = session()->get('customer_data');
            $paymentMethod = $this->request->getPost('payment_method');
            
            // Generate payment reference
            $paymentReference = 'PAY-' . date('Ymd') . '-' . strtoupper(uniqid());

            // Update booking with payment details
            $updateData = [
                'payment_method' => $paymentMethod,
                'payment_reference' => $paymentReference,
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
                'billing_data' => [
                    'name' => $booking['customer_name'],
                    'email' => $booking['customer_email'],
                    'phone' => $booking['customer_phone']
                ],
                'payment_data' => [
                    'amount' => $booking['total_amount'],
                    'currency' => 'INR',
                    'payment_method' => $booking['payment_method'],
                    'payment_reference' => $booking['payment_reference'],
                    'status' => $booking['payment_status'],
                    'customer_email' => $booking['customer_email']
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
        session()->remove(['booking_data', 'customer_data', 'booking_id']);

        return view('public/booking/success', $data);
    }
}