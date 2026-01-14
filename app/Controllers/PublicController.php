<?php

namespace App\Controllers;

use App\Models\DestinationModel;
use App\Models\ItineraryModel;
use App\Models\TestimonialModel;
use App\Models\HotelModel;
use App\Models\HotelImageModel;
use App\Models\HotelFaqModel;
use App\Models\ImageGalleryModel;
use App\Models\PageModel;
use App\Models\TourismAllianceModel;

class PublicController extends BaseController
{
    protected $testimonialModel;
    protected $destinationModel;
    protected $itineraryModel;
    protected $hotelModel;
    protected $hotelImageModel;
    protected $hotelFaqModel;
    protected $imageGalleryModel;
    protected $pageModel;
    protected $tourismAllianceModel;
    protected $contactModel;
    protected $aboutSectionModel;
    protected $contactSectionModel;

    public function __construct()
    {
        $this->testimonialModel = new TestimonialModel();
        $this->destinationModel = new DestinationModel();
        $this->itineraryModel = new ItineraryModel();
        $this->hotelModel = new HotelModel();
        $this->hotelImageModel = new HotelImageModel();
        $this->hotelFaqModel = new HotelFaqModel();
        $this->imageGalleryModel = new ImageGalleryModel();
        $this->pageModel = new PageModel();
        $this->tourismAllianceModel = new TourismAllianceModel();
        $this->contactModel = new \App\Models\ContactModel();
        $this->aboutSectionModel = new \App\Models\AboutSectionModel();
        $this->contactSectionModel = new \App\Models\ContactSectionModel();
    }

    /**
     * Home Page
     */
    public function index()
    {
        // Track visitor
        $this->trackVisit('Home - My Fair Holidays');
        
        // Get international destinations (destination_type_id = 2)
        $internationalDestinations = $this->destinationModel
            ->select('destinations.*, destination_types.name as type_name')
            ->join('destination_types', 'destination_types.id = destinations.type_id', 'left')
            ->where('destinations.type_id', 2) // International destinations
            ->where('destinations.status', 'active')
            ->orderBy('destinations.is_popular', 'DESC')
            ->orderBy('destinations.name', 'ASC')
            ->limit(12)
            ->findAll();

        // Get domestic destinations (destination_type_id = 1)
        $domesticDestinations = $this->destinationModel
            ->select('destinations.*, destination_types.name as type_name')
            ->join('destination_types', 'destination_types.id = destinations.type_id', 'left')
            ->where('destinations.type_id', 1) // Domestic destinations
            ->where('destinations.status', 'active')
            ->orderBy('destinations.is_popular', 'DESC')
            ->orderBy('destinations.name', 'ASC')
            ->limit(12)
            ->findAll();

        // Get featured hotels for international section
        $internationalHotels = $this->hotelModel
            ->select('hotels.*, destinations.name as destination_name, destinations.type_id')
            ->join('destinations', 'destinations.id = hotels.destination_id', 'left')
            ->where('destinations.type_id', 2) // International
            ->where('hotels.status', 'active')
            ->orderBy('hotels.is_featured', 'DESC')
            ->orderBy('hotels.star_rating', 'DESC')
            ->limit(8)
            ->findAll();

        // Get featured hotels for domestic section
        $domesticHotels = $this->hotelModel
            ->select('hotels.*, destinations.name as destination_name, destinations.type_id')
            ->join('destinations', 'destinations.id = hotels.destination_id', 'left')
            ->where('destinations.type_id', 1) // Domestic
            ->where('hotels.status', 'active')
            ->orderBy('hotels.is_featured', 'DESC')
            ->orderBy('hotels.star_rating', 'DESC')
            ->limit(8)
            ->findAll();

        // Get all destinations for search dropdown
        $allDestinations = $this->destinationModel
            ->where('status', 'active')
            ->orderBy('name', 'ASC')
            ->findAll();

        // Get testimonials for reviews section
        $testimonials = $this->testimonialModel
            ->where('status', 'active')
            ->orderBy('created_at', 'DESC')
            ->limit(6)
            ->findAll();

        // Get gallery images from ImageGalleryModel
        $galleryImages = $this->imageGalleryModel->getHomepageImages(12);

        // Get default image from ImageGalleryModel
        $defaultImageUrl = $this->imageGalleryModel->getDefaultImageUrl();

        // Get recent blog posts for homepage
        $blogPosts = $this->pageModel->getRecentPosts(3);

        // Get tourism alliances for homepage
        $tourismAlliances = $this->tourismAllianceModel->getActiveAlliances(6);
        
        $data = array_merge($this->commonData, [
            'title' => 'My Fair Holidays - Best Travel Agency in Noida',
            'meta_description' => 'My Fair Holidays - Leading travel agency in Noida offering best domestic and international tour packages. Book your dream vacation with us.',
            'meta_keywords' => 'travel agency noida, tour packages, domestic tours, international tours, my fair holidays',
            'internationalDestinations' => $internationalDestinations,
            'domesticDestinations' => $domesticDestinations,
            'internationalHotels' => $internationalHotels,
            'domesticHotels' => $domesticHotels,
            'allDestinations' => $allDestinations,
            'testimonials' => $testimonials,
            'galleryImages' => $galleryImages,
            'defaultImageUrl' => $defaultImageUrl,
            'blogPosts' => $blogPosts,
            'tourismAlliances' => $tourismAlliances
        ]);

        return view('public/home', $data);
    }

    /**
     * Testimonials Page
     */
    public function testimonials()
    {
        // Track visitor
        $this->trackVisit('Customer Testimonials');
        
        $perPage = 12;
        $page = $this->request->getVar('page') ?? 1;

        $testimonials = $this
            ->testimonialModel
            ->where('status', 'approved')
            ->orderBy('is_featured', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);

        // Get categories and destinations for the form (same as admin)
        $categoryModel = new \App\Models\TestimonialCategoryModel();
        $categories = $categoryModel->where('status', 'active')->findAll();
        
        $destinations = $this->destinationModel->where('status', 'active')->findAll();

        $data = array_merge($this->commonData, [
            'title' => 'Customer Testimonials',
            'meta_description' => 'Read what our satisfied customers say about their travel experiences with My Fair Holidays - Best Travel Agency in Noida.',
            'meta_keywords' => 'testimonials, reviews, customer feedback, travel experiences, my fair holidays reviews',
            'testimonials' => $testimonials,
            'categories' => $categories,
            'destinations' => $destinations,
            'pager' => $this->testimonialModel->pager
        ]);

        return view('public/testimonials', $data);
    }

    /**
     * Handle Testimonial Submission
     */
    public function submitTestimonial()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/testimonials');
        }

        $validation = \Config\Services::validation();
        
        // Use the same validation rules as admin form
        $validation->setRules([
            'customer_name' => 'required|min_length[3]|max_length[255]',
            'customer_email' => 'required|valid_email',
            'customer_city' => 'permit_empty|max_length[100]',
            'rating' => 'required|integer|greater_than[0]|less_than[6]',
            'testimonial_text' => 'required|min_length[10]',
            'category_id' => 'permit_empty|integer',
            'destination_id' => 'permit_empty|integer',
            'package_name' => 'permit_empty|max_length[255]',
            'travel_date' => 'permit_empty|valid_date'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please check your input and try again.',
                'errors' => $validation->getErrors()
            ]);
        }

        try {
            // Use the same data structure as admin form
            $data = [
                'customer_name' => $this->request->getPost('customer_name'),
                'customer_email' => $this->request->getPost('customer_email'),
                'customer_city' => $this->request->getPost('customer_city'),
                'rating' => $this->request->getPost('rating'),
                'testimonial_text' => $this->request->getPost('testimonial_text'),
                'category_id' => $this->request->getPost('category_id') ?: null,
                'destination_id' => $this->request->getPost('destination_id') ?: null,
                'package_name' => $this->request->getPost('package_name'),
                'travel_date' => $this->request->getPost('travel_date') ?: null,
                'status' => 'pending', // Public submissions are pending approval
                'is_featured' => 0,
                'sort_order' => 0
            ];

            // Handle customer image upload (same as admin)
            $image = $this->request->getFile('customer_image');
            if ($image && $image->isValid() && !$image->hasMoved()) {
                $newName = $image->getRandomName();
                $uploadPath = FCPATH . 'uploads/testimonials/';
                
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                if ($image->move($uploadPath, $newName)) {
                    $data['customer_image'] = 'uploads/testimonials/' . $newName;
                }
            }

            if ($this->testimonialModel->insert($data)) {
                // Log the testimonial submission
                log_message('info', 'Public testimonial submission saved: ' . $data['customer_email']);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Thank you for sharing your experience! Your testimonial will be reviewed and published within 24-48 hours.'
                ]);
            } else {
                throw new \Exception('Failed to save testimonial');
            }

        } catch (\Exception $e) {
            log_message('error', 'Testimonial submission error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Sorry, there was an error processing your testimonial. Please try again or contact us directly.'
            ]);
        }
    }

    public function about()
    {
        // Track visitor
        $this->trackVisit('About Us - My Fair Holidays');
        
        // Get all about sections grouped by type
        $sections = $this->aboutSectionModel->getAllSectionsGrouped();

        $data = array_merge($this->commonData, [
            'title' => 'About Us - My Fair Holidays',
            'meta_description' => 'Learn about My Fair Holidays - Leading travel agency in Noida offering best domestic and international tour packages with 25+ years of experience.',
            'meta_keywords' => 'about us, travel agency, my fair holidays, travel company, tour operator, travel services',
            'heroSection' => $this->aboutSectionModel->getHeroSection(),
            'missionSection' => $this->aboutSectionModel->getMissionSection(),
            'statsSection' => $this->aboutSectionModel->getStatsSection(),
            'featuresSection' => $this->aboutSectionModel->getFeaturesSection(),
            'sections' => $sections
        ]);

        return view('public/about', $data);
    }

    /**
     * Contact Us Page
     */
    public function contact()
    {
        // Track visitor
        $this->trackVisit('Contact Us');
        
        // Get all contact sections grouped by type
        $sections = $this->contactSectionModel->getAllSectionsGrouped();

        $data = array_merge($this->commonData, [
            'title' => 'Contact Us',
            'meta_description' => 'Get in touch with My Fair Holidays travel experts in Noida. We are here to help you plan your perfect domestic and international trips.',
            'meta_keywords' => 'contact, travel support, customer service, travel consultation, noida travel agency',
            'heroSection' => $this->contactSectionModel->getHeroSection(),
            'contactInfoSections' => $this->contactSectionModel->getContactInfoSections(),
            'formSettingsSection' => $this->contactSectionModel->getFormSettingsSection(),
            'sections' => $sections
        ]);

        return view('public/contact', $data);
    }

    /**
     * Handle Contact Form Submission
     */
    public function submitContact()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/contact');
        }

        // Validate the form data with public validation rules
        $validation = \Config\Services::validation();
        $validation->setRules($this->contactModel->getPublicValidationRules(), $this->contactModel->getPublicValidationMessages());

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please check your input and try again.',
                'errors' => $validation->getErrors()
            ]);
        }

        try {
            // Prepare contact data
            $contactData = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'subject' => $this->request->getPost('subject'),
                'message' => $this->request->getPost('message'),
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
                'status' => 'new'
            ];

            // Save to database (skip validation since we already validated)
            $contactId = $this->contactModel->insert($contactData, false);

            if ($contactId) {
                // Log the contact submission
                log_message('info', 'Contact form submission saved with ID: ' . $contactId);

                // Here you can add email notification logic
                // $this->sendContactNotification($contactData, $contactId);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Thank you for your message! We will get back to you within 24 hours.'
                ]);
            } else {
                throw new \Exception('Failed to save contact form data');
            }

        } catch (\Exception $e) {
            log_message('error', 'Contact form submission error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Sorry, there was an error processing your request. Please try again or contact us directly.'
            ]);
        }
    }

    /**
     * Request Quote Page
     */
    public function quote()
    {
        // Get destinations for dropdown
        $destinations = $this
            ->destinationModel
            ->where('status', 'active')
            ->orderBy('name', 'ASC')
            ->findAll();

        $data = array_merge($this->commonData, [
            'title' => 'Request a Quote',
            'meta_description' => 'Get a personalized travel quote from My Fair Holidays - Best Travel Agency in Noida. Free consultation and competitive prices for domestic and international tours.',
            'meta_keywords' => 'travel quote, travel pricing, custom itinerary, travel consultation, noida travel packages',
            'destinations' => $destinations
        ]);

        return view('public/quote', $data);
    }

    /**
     * Handle Quote Form Submission
     */
    public function submitQuote()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/quote');
        }

        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[10]|max_length[20]',
            'destination_id' => 'required|integer',
            'travel_date' => 'required|valid_date',
            'return_date' => 'required|valid_date',
            'adults' => 'required|integer|greater_than[0]',
            'children' => 'integer',
            'budget_range' => 'required',
            'special_requirements' => 'max_length[1000]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please check your input and try again.',
                'errors' => $validation->getErrors()
            ]);
        }

        // Here you would typically save to database and/or send email
        // For now, we'll just return success

        $quoteData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'destination_id' => $this->request->getPost('destination_id'),
            'travel_date' => $this->request->getPost('travel_date'),
            'return_date' => $this->request->getPost('return_date'),
            'adults' => $this->request->getPost('adults'),
            'children' => $this->request->getPost('children') ?: 0,
            'budget_range' => $this->request->getPost('budget_range'),
            'special_requirements' => $this->request->getPost('special_requirements'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Log the quote request (you can save to database here)
        log_message('info', 'Quote request submission: ' . json_encode($quoteData));

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Thank you for your quote request! Our team will contact you within 24 hours with a personalized quote.'
        ]);
    }

    /**
     * All Hotels Page (converted from destinations)
     */
    public function destinations()
    {
        // Track visitor
        $this->trackVisit('Hotels - Find Your Perfect Stay');
        
        $perPage = 5;
        
        // Get all filter parameters from URL
        $search = $this->request->getVar('search');
        $destinationId = $this->request->getVar('destination_id');
        $destinationSearch = $this->request->getVar('destination_search'); // New autocomplete search
        $destinationType = $this->request->getVar('destination_type'); // New filter for domestic/international
        $starRating = $this->request->getVar('star_rating');
        $sidebarStars = $this->request->getVar('sidebar_stars'); // Array of star ratings from sidebar
        $isFeatured = $this->request->getVar('is_featured');
        $amenities = $this->request->getVar('amenities'); // Array of amenities
        $minPrice = $this->request->getVar('min_price');
        $maxPrice = $this->request->getVar('max_price');
        $dates = $this->request->getVar('dates');
        $guests = $this->request->getVar('guests');
        $sort = $this->request->getVar('sort') ?? 'featured';
        
        // New filters based on table structure
        $hasCoordinates = $this->request->getVar('has_coordinates');
        $locationSearch = $this->request->getVar('location_search');
        $hasContact = $this->request->getVar('has_contact');
        $hasWebsite = $this->request->getVar('has_website');
        $hasDescription = $this->request->getVar('has_description');
        
        // Build query for hotels
        $builder = $this->hotelModel
            ->select('hotels.*, destinations.name as destination_name, destination_types.name as destination_type_name')
            ->join('destinations', 'destinations.id = hotels.destination_id', 'left')
            ->join('destination_types', 'destination_types.id = destinations.type_id', 'left')
            ->where('hotels.status', 'active');
        
        // Apply search filter
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('hotels.name', $search)
                    ->orLike('hotels.description', $search)
                    ->orLike('destinations.name', $search)
                    ->orLike('hotels.address', $search)
                    ->groupEnd();
        }
        
        // Apply destination filter (from search bar)
        if (!empty($destinationId)) {
            $builder->where('hotels.destination_id', $destinationId);
        }
        
        // Apply destination search filter (from autocomplete)
        if (!empty($destinationSearch) && empty($destinationId)) {
            $builder->like('destinations.name', $destinationSearch);
        }
        
        // Apply destination type filter (domestic/international)
        if (!empty($destinationType)) {
            if ($destinationType === 'domestic') {
                $builder->where('destinations.type_id', 1); // Assuming 1 is domestic
            } elseif ($destinationType === 'international') {
                $builder->where('destinations.type_id', 2); // Assuming 2 is international
            }
        }
        
        // Apply star rating filter (from search bar dropdown)
        if (!empty($starRating)) {
            $builder->where('hotels.star_rating', $starRating);
        }
        
        // Apply star rating filter (from sidebar checkboxes)
        if (!empty($sidebarStars)) {
            if (is_array($sidebarStars)) {
                $builder->whereIn('hotels.star_rating', $sidebarStars);
            } else {
                // Handle single value or comma-separated string
                $starsArray = is_string($sidebarStars) ? explode(',', $sidebarStars) : [$sidebarStars];
                $starsArray = array_filter($starsArray); // Remove empty values
                if (!empty($starsArray)) {
                    $builder->whereIn('hotels.star_rating', $starsArray);
                }
            }
        }
        
        // Apply featured filter
        if (!empty($isFeatured)) {
            $builder->where('hotels.is_featured', 1);
        }
        
        // Apply amenities filter
        if (!empty($amenities)) {
            if (is_array($amenities)) {
                $builder->groupStart();
                foreach ($amenities as $amenity) {
                    if (!empty($amenity)) {
                        $builder->orLike('hotels.amenities', $amenity);
                    }
                }
                $builder->groupEnd();
            } else {
                // Handle single value or comma-separated string
                $amenitiesArray = is_string($amenities) ? explode(',', $amenities) : [$amenities];
                $amenitiesArray = array_filter($amenitiesArray); // Remove empty values
                if (!empty($amenitiesArray)) {
                    $builder->groupStart();
                    foreach ($amenitiesArray as $amenity) {
                        if (!empty(trim($amenity))) {
                            $builder->orLike('hotels.amenities', trim($amenity));
                        }
                    }
                    $builder->groupEnd();
                }
            }
        }
        
        // Apply price range filters
        if (!empty($minPrice) && is_numeric($minPrice)) {
            $builder->where('hotels.price_per_night >=', $minPrice);
        }
        if (!empty($maxPrice) && is_numeric($maxPrice)) {
            $builder->where('hotels.price_per_night <=', $maxPrice);
        }
        
        // Apply location filters
        if (!empty($hasCoordinates)) {
            $builder->where('hotels.latitude IS NOT NULL')
                   ->where('hotels.longitude IS NOT NULL')
                   ->where('hotels.latitude !=', 0)
                   ->where('hotels.longitude !=', 0);
        }
        
        if (!empty($locationSearch)) {
            $builder->like('hotels.address', $locationSearch);
        }
        
        // Apply feature filters
        if (!empty($hasContact)) {
            $builder->groupStart()
                   ->where('hotels.contact_phone IS NOT NULL')
                   ->orWhere('hotels.contact_email IS NOT NULL')
                   ->groupEnd()
                   ->where('hotels.contact_phone !=', '')
                   ->where('hotels.contact_email !=', '');
        }
        
        if (!empty($hasWebsite)) {
            $builder->where('hotels.website IS NOT NULL')
                   ->where('hotels.website !=', '');
        }
        
        if (!empty($hasDescription)) {
            $builder->groupStart()
                   ->where('hotels.description IS NOT NULL')
                   ->orWhere('hotels.short_description IS NOT NULL')
                   ->groupEnd()
                   ->where('hotels.description !=', '')
                   ->where('hotels.short_description !=', '');
        }
        
        // Apply sorting
        switch ($sort) {
            case 'featured':
                $builder->orderBy('hotels.is_featured', 'DESC')
                       ->orderBy('hotels.star_rating', 'DESC');
                break;
            case 'rating':
                $builder->orderBy('hotels.star_rating', 'DESC')
                       ->orderBy('hotels.is_featured', 'DESC');
                break;
            case 'price_low':
                $builder->orderBy('hotels.price_per_night', 'ASC');
                break;
            case 'price_high':
                $builder->orderBy('hotels.price_per_night', 'DESC');
                break;
            default:
                $builder->orderBy('hotels.is_featured', 'DESC')
                       ->orderBy('hotels.star_rating', 'DESC');
        }
        
        // Add final ordering
        $builder->orderBy('hotels.name', 'ASC');
        
        // Get hotels with pagination
        $hotels = $builder->paginate($perPage);
        
        // Get total count for display (without pagination)
        $totalHotels = $builder->countAllResults(false); // false to not reset the query

        // Get destinations for filter dropdown
        $destinations = $this->destinationModel
            ->where('status', 'active')
            ->orderBy('name', 'ASC')
            ->findAll();
            
        // Get price range for reference
        $priceRange = $this->hotelModel->getPriceRange();

        // Prepare current filters for view
        $currentFilters = [
            'search' => $search,
            'destination_id' => $destinationId,
            'destination_search' => $destinationSearch,
            'destination_type' => $destinationType,
            'star_rating' => $starRating,
            'sidebar_stars' => is_array($sidebarStars) ? implode(',', $sidebarStars) : ($sidebarStars ?? ''),
            'is_featured' => $isFeatured,
            'amenities' => is_array($amenities) ? implode(',', $amenities) : ($amenities ?? ''),
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'dates' => $dates,
            'guests' => $guests,
            'sort' => $sort,
            'has_coordinates' => $hasCoordinates,
            'location_search' => $locationSearch,
            'has_contact' => $hasContact,
            'has_website' => $hasWebsite,
            'has_description' => $hasDescription
        ];

        // Set page title based on filters
        $pageTitle = 'Hotels - Find Your Perfect Stay';
        if (!empty($destinationType)) {
            if ($destinationType === 'domestic') {
                $pageTitle = 'Domestic Hotels - Find Your Perfect Stay in India';
            } elseif ($destinationType === 'international') {
                $pageTitle = 'International Hotels - Find Your Perfect Stay Worldwide';
            }
        }

        $data = array_merge($this->commonData, [
            'title' => $pageTitle,
            'meta_description' => 'Discover the best hotels with My Fair Holidays - Best Travel Agency in Noida. Book luxury and budget-friendly accommodations.',
            'meta_keywords' => 'hotels, accommodations, luxury hotels, budget hotels, hotel booking, my fair holidays',
            'hotels' => $hotels,
            'destinations' => $destinations,
            'priceRange' => $priceRange,
            'pager' => $this->hotelModel->pager,
            'currentFilters' => $currentFilters,
            'totalHotels' => $totalHotels
        ]);

        return view('public/destinations', $data);
    }

    /**
     * Destinations by Type Page
     */
    public function destinationsByType($typeSlug)
    {
        // Get destination type
        $destinationTypeModel = new \App\Models\DestinationTypeModel();
        $destinationType = $destinationTypeModel->where('slug', $typeSlug)->first();
        
        if (!$destinationType) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Destination type not found');
        }

        $perPage = 12;
        
        // Get destinations by type
        $destinations = $this->destinationModel
            ->where('type_id', $destinationType['id'])
            ->where('status', 'active')
            ->orderBy('is_popular', 'DESC')
            ->orderBy('name', 'ASC')
            ->paginate($perPage);

        $data = array_merge($this->commonData, [
            'title' => $destinationType['name'] . ' - Destinations',
            'meta_description' => 'Explore ' . $destinationType['name'] . ' with My Fair Holidays - Best Travel Agency in Noida. ' . ($destinationType['description'] ?? ''),
            'meta_keywords' => $destinationType['name'] . ', destinations, tour packages, travel',
            'destinationType' => $destinationType,
            'destinations' => $destinations,
            'pager' => $this->destinationModel->pager
        ]);

        return view('public/destinations_by_type', $data);
    }

    /**
     * Destination Detail Page
     */
    public function destinationDetail($slug)
    {
        // Get destination with details
        $destination = $this->destinationModel
            ->select('destinations.*, destination_types.name as type_name, parent.name as parent_name')
            ->join('destination_types', 'destination_types.id = destinations.type_id', 'left')
            ->join('destinations as parent', 'parent.id = destinations.parent_id', 'left')
            ->where('destinations.slug', $slug)
            ->where('destinations.status', 'active')
            ->first();
        
        if (!$destination) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Destination not found');
        }

        // Debug: Log the destination data to see what we're getting
        log_message('debug', 'Destination data: ' . json_encode($destination));

        // Get related destinations (same type)
        $relatedDestinations = [];
        if (!empty($destination['type_id'])) {
            $relatedDestinations = $this->destinationModel
                ->where('type_id', $destination['type_id'])
                ->where('id !=', $destination['id'])
                ->where('status', 'active')
                ->orderBy('is_popular', 'DESC')
                ->limit(6)
                ->findAll();
        }

        $data = array_merge($this->commonData, [
            'title' => $destination['name'] . ' - ' . (!empty($destination['type_name']) ? $destination['type_name'] : 'Destination'),
            'meta_description' => !empty($destination['meta_description']) ? $destination['meta_description'] : substr(strip_tags($destination['description']), 0, 160),
            'meta_keywords' => $destination['name'] . ', ' . (!empty($destination['type_name']) ? $destination['type_name'] : '') . ', tour packages, travel',
            'destination' => $destination,
            'relatedDestinations' => $relatedDestinations
        ]);
 

        return view('public/destination_detail', $data);
    }

    /**
     * Spiritual Tours Page
     */
    public function spiritualTours()
    {
        // Get spiritual destinations (you can filter by a specific type or tag)
        $destinations = $this->destinationModel
            ->select('destinations.*, destination_types.name as type_name')
            ->join('destination_types', 'destination_types.id = destinations.type_id', 'left')
            ->where('destinations.status', 'active')
            ->groupStart()
                ->like('destinations.name', 'spiritual')
                ->orLike('destinations.description', 'spiritual')
                ->orLike('destinations.name', 'temple')
                ->orLike('destinations.name', 'pilgrimage')
            ->groupEnd()
            ->orderBy('destinations.is_popular', 'DESC')
            ->orderBy('destinations.name', 'ASC')
            ->findAll();

        $data = array_merge($this->commonData, [
            'title' => 'Spiritual Tours',
            'meta_description' => 'Discover spiritual destinations and pilgrimage tours with My Fair Holidays - Best Travel Agency in Noida.',
            'meta_keywords' => 'spiritual tours, pilgrimage, temple tours, religious tours, spiritual destinations',
            'destinations' => $destinations
        ]);

        return view('public/spiritual_tours', $data);
    }

    /**
     * Hotel Detail Page
     */
    public function hotelDetail($slug)
    {
        // Get hotel with details
        $hotel = $this->hotelModel->getBySlug($slug);
        
        if (!$hotel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Hotel not found');
        }

        // Track visitor
        $this->trackVisit($hotel['name'] . ' - Hotel Details');
        
        // Get hotel images
        $images = $this->hotelImageModel->getHotelImages($hotel['id']);

        // Get hotel FAQs
        $faqs = $this->hotelFaqModel->getHotelFaqs($hotel['id']);

        // Get related hotels (same destination)
        $relatedHotels = [];
        if (!empty($hotel['destination_id'])) {
            $relatedHotels = $this->hotelModel
                ->select('hotels.*, destinations.name as destination_name')
                ->join('destinations', 'destinations.id = hotels.destination_id', 'left')
                ->where('hotels.destination_id', $hotel['destination_id'])
                ->where('hotels.id !=', $hotel['id'])
                ->where('hotels.status', 'active')
                ->orderBy('hotels.star_rating', 'DESC')
                ->limit(6)
                ->findAll();
        }

        $data = array_merge($this->commonData, [
            'title' => $hotel['name'] . ' - ' . (!empty($hotel['destination_name']) ? $hotel['destination_name'] : 'Hotel'),
            'meta_description' => !empty($hotel['meta_description']) ? $hotel['meta_description'] : substr(strip_tags($hotel['description']), 0, 160),
            'meta_keywords' => !empty($hotel['meta_keywords']) ? $hotel['meta_keywords'] : $hotel['name'] . ', ' . (!empty($hotel['destination_name']) ? $hotel['destination_name'] : '') . ', hotel booking, accommodation',
            'hotel' => $hotel,
            'images' => $images,
            'faqs' => $faqs,
            'relatedHotels' => $relatedHotels
        ]);

        return view('public/hotel_detail', $data);
    }

    /**
     * Blog List Page
     */
    public function blog()
    {
        $perPage = 9;
        $page = $this->request->getVar('page') ?? 1;

        // Get published blog posts
        $posts = $this->pageModel
            ->select('pages.*, users.name as author_name')
            ->join('users', 'users.id = pages.author_id', 'left')
            ->where('pages.status', 'published')
            ->orderBy('pages.created_at', 'DESC')
            ->paginate($perPage);

        // Get featured posts for sidebar
        $featuredPosts = $this->pageModel->getFeaturedPosts(5);

        $data = array_merge($this->commonData, [
            'title' => 'Travel Blog - News, Tips & Guides',
            'meta_description' => 'Read the latest travel news, tips, and guides from My Fair Holidays. Discover amazing destinations and travel insights.',
            'meta_keywords' => 'travel blog, travel tips, travel guides, travel news, destinations, my fair holidays blog',
            'posts' => $posts,
            'featuredPosts' => $featuredPosts,
            'pager' => $this->pageModel->pager
        ]);

        return view('public/blog', $data);
    }

    /**
     * Blog Detail Page
     */
    public function blogDetail($slug)
    {
        // Get blog post by slug
        $post = $this->pageModel->getPageBySlug($slug);
        
        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Blog post not found');
        }

        // Get related posts (recent posts excluding current)
        $relatedPosts = $this->pageModel
            ->select('pages.*, users.name as author_name')
            ->join('users', 'users.id = pages.author_id', 'left')
            ->where('pages.status', 'published')
            ->where('pages.id !=', $post['id'])
            ->orderBy('pages.created_at', 'DESC')
            ->limit(3)
            ->findAll();

        // Get featured posts for sidebar
        $featuredPosts = $this->pageModel->getFeaturedPosts(5);

        $data = array_merge($this->commonData, [
            'title' => $post['title'] . ' - My Fair Holidays Blog',
            'meta_description' => !empty($post['meta_description']) ? $post['meta_description'] : substr(strip_tags($post['excerpt'] ?: $post['content']), 0, 160),
            'meta_keywords' => !empty($post['meta_keywords']) ? $post['meta_keywords'] : 'travel blog, ' . $post['title'] . ', my fair holidays',
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'featuredPosts' => $featuredPosts
        ]);

        return view('public/blog_detail', $data);
    }

    /**
     * Check Hotel Availability
     */
    public function checkAvailability()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/hotels');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'hotel_id' => 'required|integer',
            'check_in_date' => 'required|valid_date',
            'check_out_date' => 'required|valid_date',
            'rooms' => 'required|integer|greater_than[0]',
            'adults' => 'required|integer|greater_than[0]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please check your input and try again.',
                'errors' => $validation->getErrors()
            ]);
        }

        try {
            $hotelId = $this->request->getPost('hotel_id');
            $checkInDate = $this->request->getPost('check_in_date');
            $checkOutDate = $this->request->getPost('check_out_date');
            $rooms = $this->request->getPost('rooms');
            $adults = $this->request->getPost('adults');
            $children = $this->request->getPost('children') ?? 0;
            $infants = $this->request->getPost('infants') ?? 0;

            // Get hotel details
            $hotel = $this->hotelModel->find($hotelId);
            if (!$hotel) {
                throw new \Exception('Hotel not found');
            }

            // For now, we'll assume availability and redirect to booking page
            // In a real system, you'd check actual availability here
            $bookingData = [
                'hotel_id' => $hotelId,
                'check_in_date' => $checkInDate,
                'check_out_date' => $checkOutDate,
                'rooms' => $rooms,
                'adults' => $adults,
                'children' => $children,
                'infants' => $infants
            ];

            // Store booking data in session for the booking page
            session()->set('booking_data', $bookingData);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Hotel is available for your selected dates!',
                'redirect' => base_url('/booking?hotel_id=' . $hotelId)
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Availability check error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unable to check availability. Please try again or contact us directly.'
            ]);
        }
    }

    /**
     * Quick Booking Request
     */
    public function quickBookingRequest()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/hotels');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'hotel_id' => 'required|integer',
            'check_in_date' => 'required|valid_date',
            'check_out_date' => 'required|valid_date',
            'rooms' => 'required|integer|greater_than[0]',
            'guests' => 'required|integer|greater_than[0]',
            'guest_name' => 'required|min_length[2]|max_length[100]',
            'guest_email' => 'required|valid_email',
            'guest_phone' => 'required|min_length[10]|max_length[20]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please check your input and try again.',
                'errors' => $validation->getErrors()
            ]);
        }

        try {
            $bookingData = [
                'hotel_id' => $this->request->getPost('hotel_id'),
                'check_in_date' => $this->request->getPost('check_in_date'),
                'check_out_date' => $this->request->getPost('check_out_date'),
                'rooms' => $this->request->getPost('rooms'),
                'guests' => $this->request->getPost('guests'),
                'guest_name' => $this->request->getPost('guest_name'),
                'guest_email' => $this->request->getPost('guest_email'),
                'guest_phone' => $this->request->getPost('guest_phone'),
                'special_requests' => $this->request->getPost('special_requests'),
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s'),
                'ip_address' => $this->request->getIPAddress()
            ];

            // Here you would typically save to a booking_requests table
            // For now, we'll just log it and return success
            log_message('info', 'Quick booking request: ' . json_encode($bookingData));

            // You could also send an email notification here
            // $this->sendBookingNotification($bookingData);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Booking request submitted successfully! We will contact you within 24 hours to confirm your reservation.'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Quick booking request error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unable to submit booking request. Please try again or contact us directly.'
            ]);
        }
    }

    /**
     * Booking Page
     */
    public function booking()
    {
        $hotelId = $this->request->getVar('hotel_id');
        $bookingData = session()->get('booking_data');

        $hotel = null;
        if ($hotelId) {
            $hotel = $this->hotelModel->find($hotelId);
        }

        $data = array_merge($this->commonData, [
            'title' => 'Complete Your Booking',
            'meta_description' => 'Complete your hotel booking with My Fair Holidays - Best Travel Agency in Noida.',
            'meta_keywords' => 'hotel booking, reservation, my fair holidays',
            'hotel' => $hotel,
            'bookingData' => $bookingData
        ]);

        return view('public/booking', $data);
    }
}
