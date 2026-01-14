<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public Routes
$routes->get('/', 'PublicController::index');
$routes->get('/about', 'PublicController::about');
$routes->get('/contact', 'PublicController::contact');
$routes->post('/contact/submit', 'PublicController::submitContact');
$routes->get('/testimonials', 'PublicController::testimonials');
$routes->post('/testimonials/submit', 'PublicController::submitTestimonial');
$routes->get('/quote', 'PublicController::quote');
$routes->post('/quote/submit', 'PublicController::submitQuote');

// Public Destination Routes
$routes->get('/destinations', 'PublicController::destinations');
$routes->get('/destinations/type/(:segment)', 'PublicController::destinationsByType/$1');
$routes->get('/destinations/(:segment)', 'PublicController::destinationDetail/$1');
$routes->get('/spiritual-tours', 'PublicController::spiritualTours');

// Public Hotel Routes
$routes->get('/hotels', 'PublicController::destinations'); 
$routes->get('/hotels/(:segment)', 'PublicController::hotelDetail/$1'); 

// Booking Routes - 3-Step Process
$routes->get('/booking', 'BookingController::index'); 
$routes->get('/booking/step2', 'BookingController::step2'); 
$routes->post('/booking/step2', 'BookingController::processStep2'); 
$routes->get('/booking/step3', 'BookingController::step3'); 
$routes->post('/booking/payment', 'BookingController::processPayment'); 
$routes->get('/booking/success', 'BookingController::success'); 

// Public Blog Routes
$routes->get('/blog', 'PublicController::blog');
$routes->get('/blog/(:segment)', 'PublicController::blogDetail/$1');

// Authentication Routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::loginPost');
    $routes->get('register', 'AuthController::register');
    $routes->post('register', 'AuthController::registerPost');
    $routes->get('logout', 'AuthController::logout', ['filter' => 'auth']);
});

// Admin login redirect
$routes->get('/admin/login', 'AuthController::login');
$routes->post('/admin/login', 'AuthController::loginPost');

// Admin Routes
$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    $routes->get('dashboard', 'Admin\DashboardController::index');
    $routes->get('dashboard/visitor-analytics', 'Admin\DashboardController::getVisitorAnalytics');
    $routes->get('users', 'AdminController::users');
    $routes->get('users/toggle/(:num)', 'AdminController::toggleUserStatus/$1');
    
    // User Management
    $routes->get('user-management', 'Admin\UserManagementController::index');
    $routes->get('user-management/create', 'Admin\UserManagementController::create');
    $routes->post('user-management/store', 'Admin\UserManagementController::store');
    $routes->get('user-management/edit/(:num)', 'Admin\UserManagementController::edit/$1');
    $routes->post('user-management/update/(:num)', 'Admin\UserManagementController::update/$1');
    $routes->get('user-management/delete/(:num)', 'Admin\UserManagementController::delete/$1');
    $routes->post('user-management/toggle-status/(:num)', 'Admin\UserManagementController::toggleStatus/$1');
    $routes->get('user-management/show/(:num)', 'Admin\UserManagementController::show/$1');
    $routes->post('user-management/reset-password/(:num)', 'Admin\UserManagementController::resetPassword/$1');
    $routes->post('user-management/bulk-action', 'Admin\UserManagementController::bulkAction');
    $routes->get('user-management/export', 'Admin\UserManagementController::export');
    
    // Role Management
    $routes->get('roles', 'Admin\RoleController::index');
    $routes->get('roles/create', 'Admin\RoleController::create');
    $routes->post('roles/store', 'Admin\RoleController::store');
    $routes->get('roles/edit/(:num)', 'Admin\RoleController::edit/$1');
    $routes->post('roles/update/(:num)', 'Admin\RoleController::update/$1');
    $routes->get('roles/delete/(:num)', 'Admin\RoleController::delete/$1');
    $routes->post('roles/toggle-status/(:num)', 'Admin\RoleController::toggleStatus/$1');
    $routes->post('roles/assign-permissions/(:num)', 'Admin\RoleController::assignPermissions/$1');

    // Pages Management
    $routes->get('pages', 'Admin\PagesController::index');
    $routes->get('pages/create', 'Admin\PagesController::create');
    $routes->post('pages/store', 'Admin\PagesController::store');
    $routes->get('pages/show/(:num)', 'Admin\PagesController::show/$1');
    $routes->get('pages/edit/(:num)', 'Admin\PagesController::edit/$1');
    $routes->post('pages/update/(:num)', 'Admin\PagesController::update/$1');
    $routes->get('pages/delete/(:num)', 'Admin\PagesController::delete/$1');
    $routes->post('pages/toggle-status/(:num)', 'Admin\PagesController::toggleStatus/$1');
    $routes->post('pages/set-homepage/(:num)', 'Admin\PagesController::setHomepage/$1');
    $routes->get('pages/trash', 'Admin\PagesController::trash');
    $routes->get('pages/restore/(:num)', 'Admin\PagesController::restore/$1');
    $routes->get('pages/force-delete/(:num)', 'Admin\PagesController::forceDelete/$1');
    $routes->post('pages/bulk-action', 'Admin\PagesController::bulkAction');

    // Blog/News Management
    $routes->get('blogs', 'Admin\BlogController::index');
    $routes->get('blogs/create', 'Admin\BlogController::create');
    $routes->post('blogs/store', 'Admin\BlogController::store');
    $routes->get('blogs/show/(:num)', 'Admin\BlogController::show/$1');
    $routes->get('blogs/edit/(:num)', 'Admin\BlogController::edit/$1');
    $routes->post('blogs/update/(:num)', 'Admin\BlogController::update/$1');
    $routes->get('blogs/delete/(:num)', 'Admin\BlogController::delete/$1');
    $routes->post('blogs/toggle-status/(:num)', 'Admin\BlogController::toggleStatus/$1');
    $routes->post('blogs/toggle-featured/(:num)', 'Admin\BlogController::toggleFeatured/$1');
    $routes->get('blogs/trash', 'Admin\BlogController::trash');
    $routes->get('blogs/restore/(:num)', 'Admin\BlogController::restore/$1');
    $routes->get('blogs/force-delete/(:num)', 'Admin\BlogController::forceDelete/$1');
    $routes->post('blogs/bulk-action', 'Admin\BlogController::bulkAction');
    
    
    // Destination Management
    $routes->get('destinations', 'Admin\DestinationController::index');
    $routes->get('destinations/create', 'Admin\DestinationController::create');
    $routes->post('destinations/store', 'Admin\DestinationController::store');
    $routes->get('destinations/edit/(:num)', 'Admin\DestinationController::edit/$1');
    $routes->post('destinations/update/(:num)', 'Admin\DestinationController::update/$1');
    $routes->get('destinations/delete/(:num)', 'Admin\DestinationController::delete/$1');
    $routes->post('destinations/toggle-status/(:num)', 'Admin\DestinationController::toggleStatus/$1');
    $routes->post('destinations/toggle-popular/(:num)', 'Admin\DestinationController::togglePopular/$1');
    $routes->get('destinations/trash', 'Admin\DestinationController::trash');
    $routes->get('destinations/restore/(:num)', 'Admin\DestinationController::restore/$1');
    $routes->get('destinations/force-delete/(:num)', 'Admin\DestinationController::forceDelete/$1');
    $routes->post('destinations/bulk-action', 'Admin\DestinationController::bulkAction');

    // Destination Types Management
    $routes->get('destination-types', 'Admin\DestinationTypeController::index');
    $routes->get('destination-types/create', 'Admin\DestinationTypeController::create');
    $routes->post('destination-types/store', 'Admin\DestinationTypeController::store');
    $routes->get('destination-types/edit/(:num)', 'Admin\DestinationTypeController::edit/$1');
    $routes->post('destination-types/update/(:num)', 'Admin\DestinationTypeController::update/$1');
    $routes->get('destination-types/delete/(:num)', 'Admin\DestinationTypeController::delete/$1');
    $routes->post('destination-types/toggle-status/(:num)', 'Admin\DestinationTypeController::toggleStatus/$1');
    $routes->post('destination-types/update-sort-order', 'Admin\DestinationTypeController::updateSortOrder');
    $routes->post('destination-types/bulk-action', 'Admin\DestinationTypeController::bulkAction');
    $routes->get('destination-types/api/active', 'Admin\DestinationTypeController::getActiveTypes');

    // Testimonial Categories Management
    $routes->get('testimonial-categories', 'Admin\TestimonialCategoryController::index');
    $routes->get('testimonial-categories/create', 'Admin\TestimonialCategoryController::create');
    $routes->post('testimonial-categories/store', 'Admin\TestimonialCategoryController::store');
    $routes->get('testimonial-categories/edit/(:num)', 'Admin\TestimonialCategoryController::edit/$1');
    $routes->post('testimonial-categories/update/(:num)', 'Admin\TestimonialCategoryController::update/$1');
    $routes->get('testimonial-categories/delete/(:num)', 'Admin\TestimonialCategoryController::delete/$1');
    $routes->post('testimonial-categories/toggle-status/(:num)', 'Admin\TestimonialCategoryController::toggleStatus/$1');
    $routes->post('testimonial-categories/bulk-action', 'Admin\TestimonialCategoryController::bulkAction');

    // Testimonials Management
    $routes->get('testimonials', 'Admin\TestimonialController::index');
    $routes->get('testimonials/create', 'Admin\TestimonialController::create');
    $routes->post('testimonials/store', 'Admin\TestimonialController::store');
    $routes->get('testimonials/edit/(:num)', 'Admin\TestimonialController::edit/$1');
    $routes->post('testimonials/update/(:num)', 'Admin\TestimonialController::update/$1');
    $routes->get('testimonials/delete/(:num)', 'Admin\TestimonialController::delete/$1');
    $routes->post('testimonials/approve/(:num)', 'Admin\TestimonialController::approve/$1');
    $routes->post('testimonials/reject/(:num)', 'Admin\TestimonialController::reject/$1');
    $routes->post('testimonials/toggle-featured/(:num)', 'Admin\TestimonialController::toggleFeatured/$1');
    $routes->post('testimonials/bulk-action', 'Admin\TestimonialController::bulkAction');
    
    // Hotel Management
    $routes->get('hotels', 'Admin\HotelController::index');
    $routes->get('hotels/create', 'Admin\HotelController::create');
    $routes->post('hotels/store', 'Admin\HotelController::store');
    $routes->get('hotels/show/(:num)', 'Admin\HotelController::show/$1');
    $routes->get('hotels/edit/(:num)', 'Admin\HotelController::edit/$1');
    $routes->post('hotels/update/(:num)', 'Admin\HotelController::update/$1');
    $routes->get('hotels/delete/(:num)', 'Admin\HotelController::delete/$1');
    $routes->post('hotels/toggle-status/(:num)', 'Admin\HotelController::toggleStatus/$1');
    $routes->post('hotels/toggle-featured/(:num)', 'Admin\HotelController::toggleFeatured/$1');
    $routes->post('hotels/bulk-action', 'Admin\HotelController::bulkAction');
    $routes->post('hotels/delete-image/(:num)', 'Admin\HotelController::deleteImage/$1');
    $routes->post('hotels/set-featured-image/(:num)/(:num)', 'Admin\HotelController::setFeaturedImage/$1/$2');
    $routes->post('hotels/update-image-order', 'Admin\HotelController::updateImageOrder');
    
    // Hotel FAQ routes
    $routes->get('hotels/faqs/(:num)', 'Admin\HotelController::manageFaqs/$1');
    $routes->post('hotels/faqs/(:num)/store', 'Admin\HotelController::storeFaq/$1');
    $routes->post('hotels/faqs/(:num)/update/(:num)', 'Admin\HotelController::updateFaq/$1/$2');
    $routes->post('hotels/faqs/(:num)/delete/(:num)', 'Admin\HotelController::deleteFaq/$1/$2');
    $routes->post('hotels/faqs/(:num)/update-order', 'Admin\HotelController::updateFaqOrder/$1');
    
    // Itinerary Management
    $routes->get('itineraries', 'Admin\ItineraryController::index');
    $routes->get('itineraries/create', 'Admin\ItineraryController::create');
    $routes->post('itineraries/store', 'Admin\ItineraryController::store');
    $routes->get('itineraries/edit/(:num)', 'Admin\ItineraryController::edit/$1');
    $routes->post('itineraries/update/(:num)', 'Admin\ItineraryController::update/$1');
    $routes->get('itineraries/delete/(:num)', 'Admin\ItineraryController::delete/$1');
    $routes->post('itineraries/toggle-status/(:num)', 'Admin\ItineraryController::toggleStatus/$1');
    
    // Itinerary Category Management
    $routes->get('itinerary-categories', 'Admin\ItineraryCategoryController::index');
    $routes->get('itinerary-categories/create', 'Admin\ItineraryCategoryController::create');
    $routes->post('itinerary-categories/store', 'Admin\ItineraryCategoryController::store');
    $routes->get('itinerary-categories/edit/(:num)', 'Admin\ItineraryCategoryController::edit/$1');
    $routes->post('itinerary-categories/update/(:num)', 'Admin\ItineraryCategoryController::update/$1');
    $routes->get('itinerary-categories/delete/(:num)', 'Admin\ItineraryCategoryController::delete/$1');
    $routes->post('itinerary-categories/toggle-status/(:num)', 'Admin\ItineraryCategoryController::toggleStatus/$1');
    
    // Review Management
    $routes->get('reviews', 'Admin\ReviewController::index');
    $routes->get('reviews/create', 'Admin\ReviewController::create');
    $routes->post('reviews/store', 'Admin\ReviewController::store');
    $routes->get('reviews/edit/(:num)', 'Admin\ReviewController::edit/$1');
    $routes->post('reviews/update/(:num)', 'Admin\ReviewController::update/$1');
    $routes->get('reviews/delete/(:num)', 'Admin\ReviewController::delete/$1');
    $routes->post('reviews/approve/(:num)', 'Admin\ReviewController::approve/$1');
    $routes->post('reviews/reject/(:num)', 'Admin\ReviewController::reject/$1');
    
    // Review Category Management
    $routes->get('review-categories', 'Admin\ReviewCategoryController::index');
    $routes->get('review-categories/create', 'Admin\ReviewCategoryController::create');
    $routes->post('review-categories/store', 'Admin\ReviewCategoryController::store');
    $routes->get('review-categories/edit/(:num)', 'Admin\ReviewCategoryController::edit/$1');
    $routes->post('review-categories/update/(:num)', 'Admin\ReviewCategoryController::update/$1');
    $routes->get('review-categories/delete/(:num)', 'Admin\ReviewCategoryController::delete/$1');
    $routes->post('review-categories/toggle-status/(:num)', 'Admin\ReviewCategoryController::toggleStatus/$1');
    
    // Payment History Management
    $routes->get('payment-history', 'Admin\PaymentHistoryController::index');
    $routes->get('payment-history/show/(:num)', 'Admin\PaymentHistoryController::show/$1');
    $routes->post('payment-history/update-status/(:num)', 'Admin\PaymentHistoryController::updateStatus/$1');
    $routes->post('payment-history/process-refund/(:num)', 'Admin\PaymentHistoryController::processRefund/$1');
    $routes->get('payment-history/export', 'Admin\PaymentHistoryController::export');
    $routes->get('payment-history/statistics', 'Admin\PaymentHistoryController::statistics');
    $routes->get('payment-history/delete/(:num)', 'Admin\PaymentHistoryController::delete/$1');
    
    // Meta Tag Management
    $routes->get('meta-tags', 'Admin\MetaTagController::index');
    $routes->get('meta-tags/create', 'Admin\MetaTagController::create');
    $routes->post('meta-tags/store', 'Admin\MetaTagController::store');
    $routes->get('meta-tags/edit/(:num)', 'Admin\MetaTagController::edit/$1');
    $routes->post('meta-tags/update/(:num)', 'Admin\MetaTagController::update/$1');
    $routes->get('meta-tags/delete/(:num)', 'Admin\MetaTagController::delete/$1');
    $routes->post('meta-tags/toggle-status/(:num)', 'Admin\MetaTagController::toggleStatus/$1');
    $routes->match(['get', 'post'], 'meta-tags/bulk-import', 'Admin\MetaTagController::bulkImport');
    $routes->get('meta-tags/export', 'Admin\MetaTagController::export');
      
    // Video Gallery Management
    $routes->get('videos', 'Admin\VideoGalleryController::index');
    $routes->get('videos/create', 'Admin\VideoGalleryController::create');
    $routes->post('videos/store', 'Admin\VideoGalleryController::store');
    $routes->get('videos/edit/(:num)', 'Admin\VideoGalleryController::edit/$1');
    $routes->post('videos/update/(:num)', 'Admin\VideoGalleryController::update/$1');
    $routes->get('videos/delete/(:num)', 'Admin\VideoGalleryController::delete/$1');
    $routes->get('videos/trash', 'Admin\VideoGalleryController::trash');
    $routes->get('videos/restore/(:num)', 'Admin\VideoGalleryController::restore/$1');
    $routes->get('videos/force-delete/(:num)', 'Admin\VideoGalleryController::forceDelete/$1');
    $routes->get('videos/toggle-homepage/(:num)', 'Admin\VideoGalleryController::toggleHomepage/$1');
    $routes->get('videos/toggle-status/(:num)', 'Admin\VideoGalleryController::toggleStatus/$1');
    $routes->post('videos/bulk-action', 'Admin\VideoGalleryController::bulkAction');
    $routes->post('videos/update-sort-order', 'Admin\VideoGalleryController::updateSortOrder');
    
    // Image Gallery Management
    $routes->get('images', 'Admin\ImageGalleryController::index');
    $routes->get('images/create', 'Admin\ImageGalleryController::create');
    $routes->post('images/store', 'Admin\ImageGalleryController::store');
    $routes->get('images/edit/(:num)', 'Admin\ImageGalleryController::edit/$1');
    $routes->post('images/update/(:num)', 'Admin\ImageGalleryController::update/$1');
    $routes->get('images/delete/(:num)', 'Admin\ImageGalleryController::delete/$1');
    $routes->get('images/trash', 'Admin\ImageGalleryController::trash');
    $routes->get('images/restore/(:num)', 'Admin\ImageGalleryController::restore/$1');
    $routes->get('images/force-delete/(:num)', 'Admin\ImageGalleryController::forceDelete/$1');
    $routes->get('images/toggle-homepage/(:num)', 'Admin\ImageGalleryController::toggleHomepage/$1');
    $routes->get('images/toggle-status/(:num)', 'Admin\ImageGalleryController::toggleStatus/$1');
    $routes->post('images/bulk-action', 'Admin\ImageGalleryController::bulkAction');
    $routes->post('images/update-sort-order', 'Admin\ImageGalleryController::updateSortOrder');
    
    // Tourism Alliance Management
    $routes->get('tourism-alliances', 'Admin\TourismAllianceController::index');
    $routes->get('tourism-alliances/create', 'Admin\TourismAllianceController::create');
    $routes->post('tourism-alliances/store', 'Admin\TourismAllianceController::store');
    $routes->get('tourism-alliances/show/(:num)', 'Admin\TourismAllianceController::show/$1');
    $routes->get('tourism-alliances/edit/(:num)', 'Admin\TourismAllianceController::edit/$1');
    $routes->post('tourism-alliances/update/(:num)', 'Admin\TourismAllianceController::update/$1');
    $routes->get('tourism-alliances/delete/(:num)', 'Admin\TourismAllianceController::delete/$1');
    $routes->post('tourism-alliances/toggle-status/(:num)', 'Admin\TourismAllianceController::toggleStatus/$1');
    $routes->get('tourism-alliances/trash', 'Admin\TourismAllianceController::trash');
    $routes->get('tourism-alliances/restore/(:num)', 'Admin\TourismAllianceController::restore/$1');
    $routes->get('tourism-alliances/force-delete/(:num)', 'Admin\TourismAllianceController::forceDelete/$1');
    $routes->post('tourism-alliances/bulk-action', 'Admin\TourismAllianceController::bulkAction');
    $routes->post('tourism-alliances/update-sort-order', 'Admin\TourismAllianceController::updateSortOrder');
    
    // Booking Management
    $routes->get('bookings', 'Admin\BookingController::index');
    $routes->get('bookings/(:num)', 'Admin\BookingController::show/$1');
    $routes->get('bookings/show/(:num)', 'Admin\BookingController::show/$1');
    $routes->post('bookings/(:num)/update-status', 'Admin\BookingController::updateStatus/$1');
    $routes->post('bookings/(:num)/update-payment-status', 'Admin\BookingController::updatePaymentStatus/$1');
    
    // Contact Management
    $routes->get('contacts', 'Admin\ContactController::index');
    $routes->get('contacts/show/(:num)', 'Admin\ContactController::show/$1');
    $routes->post('contacts/update-status/(:num)', 'Admin\ContactController::updateStatus/$1');
    $routes->get('contacts/delete/(:num)', 'Admin\ContactController::delete/$1');
    $routes->post('contacts/bulk-action', 'Admin\ContactController::bulkAction');
    $routes->get('contacts/export', 'Admin\ContactController::export');
    
    // About Sections Management
    $routes->get('about-sections', 'Admin\AboutSectionController::index');
    $routes->get('about-sections/create', 'Admin\AboutSectionController::create');
    $routes->post('about-sections/store', 'Admin\AboutSectionController::store');
    $routes->get('about-sections/edit/(:num)', 'Admin\AboutSectionController::edit/$1');
    $routes->post('about-sections/update/(:num)', 'Admin\AboutSectionController::update/$1');
    $routes->get('about-sections/delete/(:num)', 'Admin\AboutSectionController::delete/$1');
    $routes->post('about-sections/toggle-status/(:num)', 'Admin\AboutSectionController::toggleStatus/$1');
    $routes->post('about-sections/update-sort-order', 'Admin\AboutSectionController::updateSortOrder');
    
    // Contact Sections Management
    $routes->get('contact-sections', 'Admin\ContactSectionController::index');
    $routes->get('contact-sections/create', 'Admin\ContactSectionController::create');
    $routes->post('contact-sections/store', 'Admin\ContactSectionController::store');
    $routes->get('contact-sections/edit/(:num)', 'Admin\ContactSectionController::edit/$1');
    $routes->post('contact-sections/update/(:num)', 'Admin\ContactSectionController::update/$1');
    $routes->get('contact-sections/delete/(:num)', 'Admin\ContactSectionController::delete/$1');
    $routes->post('contact-sections/toggle-status/(:num)', 'Admin\ContactSectionController::toggleStatus/$1');
    $routes->post('contact-sections/update-sort-order', 'Admin\ContactSectionController::updateSortOrder');
    
    // Page Management
    $routes->get('pages', 'Admin\PagesController::index');
    $routes->get('pages/create', 'Admin\PagesController::create');
    $routes->post('pages/store', 'Admin\PagesController::store');
    $routes->get('pages/edit/(:num)', 'Admin\PagesController::edit/$1');
    $routes->post('pages/update/(:num)', 'Admin\PagesController::update/$1');
    $routes->get('pages/delete/(:num)', 'Admin\PagesController::delete/$1');
});

// Manager Routes
$routes->group('manager', ['filter' => 'role:manager'], function($routes) {
    $routes->get('dashboard', 'ManagerController::dashboard');
    $routes->get('users', 'ManagerController::users');
});

// User Routes
$routes->group('user', ['filter' => 'role:user'], function($routes) {
    $routes->get('dashboard', 'UserController::dashboard');
    $routes->get('profile', 'UserController::profile');
    $routes->post('profile', 'UserController::updateProfile');
});

// Public Blog Routes
$routes->get('blog', 'BlogController::index');
$routes->get('blog/(:segment)', 'BlogController::show/$1');
