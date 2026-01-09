<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PageModel;
use App\Models\DestinationModel;
use App\Models\ItineraryModel;
use App\Models\TestimonialModel;
use App\Models\PaymentHistoryModel;

/**
 * Admin Dashboard Controller
 * 
 * Main admin dashboard with statistics and overview
 * 
 * @package App\Controllers\Admin
 * @author  Senior PHP Architect
 */
class DashboardController extends BaseController
{
    protected $pageModel;
    protected $destinationModel;
    protected $itineraryModel;
    protected $testimonialModel;
    protected $paymentModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
        $this->destinationModel = new DestinationModel();
        $this->itineraryModel = new ItineraryModel();
        $this->testimonialModel = new TestimonialModel();
        $this->paymentModel = new PaymentHistoryModel();
    }

    /**
     * Admin Dashboard Index
     * 
     * @return string
     */
    public function index(): string
    {
        // Check if user is admin
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Access denied');
        }

        // Get statistics for all modules
        $data = [
            'title' => 'Admin Dashboard',
            'stats' => $this->getDashboardStats(),
            'recent_activities' => $this->getRecentActivities(),
            'quick_stats' => $this->getQuickStats()
        ];

        return view('admin/dashboard/index', $data);
    }

    /**
     * Get comprehensive dashboard statistics
     * 
     * @return array
     */
    private function getDashboardStats(): array
    {
        return [
            'blogs' => [
                'total' => $this->pageModel->countAllResults(),
                'published' => $this->pageModel->where('status', 'published')->countAllResults(),
                'draft' => $this->pageModel->where('status', 'draft')->countAllResults(),
                'featured' => $this->pageModel->where('is_featured', 1)->countAllResults()
            ],
            'destinations' => [
                'total' => $this->destinationModel->countAllResults(),
                'active' => $this->destinationModel->where('status', 'active')->countAllResults(),
                'countries' => $this->destinationModel->where('type', 'country')->countAllResults(),
                'cities' => $this->destinationModel->where('type', 'city')->countAllResults()
            ],
            'itineraries' => [
                'total' => $this->itineraryModel->countAllResults(),
                'published' => $this->itineraryModel->where('status', 'published')->countAllResults(),
                'featured' => $this->itineraryModel->where('is_featured', 1)->countAllResults()
            ],
            'testimonials' => [
                'total' => $this->testimonialModel->countAllResults(),
                'approved' => $this->testimonialModel->where('status', 'approved')->countAllResults(),
                'pending' => $this->testimonialModel->where('status', 'pending')->countAllResults(),
                'featured' => $this->testimonialModel->where('is_featured', 1)->countAllResults()
            ],
            'payments' => [
                'total' => $this->paymentModel->countAllResults(),
                'completed' => $this->paymentModel->where('status', 'completed')->countAllResults(),
                'pending' => $this->paymentModel->where('status', 'pending')->countAllResults(),
                'total_amount' => $this->paymentModel->selectSum('amount')->where('status', 'completed')->first()['amount'] ?? 0
            ]
        ];
    }

    /**
     * Get recent activities across all modules
     * 
     * @return array
     */
    private function getRecentActivities(): array
    {
        $activities = [];

        // Recent blog posts
        $recentBlogs = $this->pageModel->orderBy('created_at', 'DESC')->findAll(5);
        foreach ($recentBlogs as $blog) {
            $activities[] = [
                'type' => 'blog',
                'title' => $blog['title'],
                'action' => 'created',
                'date' => $blog['created_at'],
                'status' => $blog['status']
            ];
        }

        // Recent itineraries
        $recentItineraries = $this->itineraryModel->orderBy('created_at', 'DESC')->findAll(5);
        foreach ($recentItineraries as $itinerary) {
            $activities[] = [
                'type' => 'itinerary',
                'title' => $itinerary['title'],
                'action' => 'created',
                'date' => $itinerary['created_at'],
                'status' => $itinerary['status']
            ];
        }

        // Recent testimonials
        $recentTestimonials = $this->testimonialModel->orderBy('created_at', 'DESC')->findAll(5);
        foreach ($recentTestimonials as $testimonial) {
            $activities[] = [
                'type' => 'testimonial',
                'title' => substr($testimonial['testimonial_text'], 0, 50) . '...',
                'action' => 'submitted by ' . $testimonial['customer_name'],
                'date' => $testimonial['created_at'],
                'status' => $testimonial['status']
            ];
        }

        // Sort by date
        usort($activities, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return array_slice($activities, 0, 10);
    }

    /**
     * Get quick statistics for dashboard cards
     * 
     * @return array
     */
    private function getQuickStats(): array
    {
        return [
            'total_content' => $this->pageModel->countAllResults(),
            'total_destinations' => $this->destinationModel->countAllResults(),
            'total_bookings' => $this->paymentModel->where('status', 'completed')->countAllResults(),
            'pending_testimonials' => $this->testimonialModel->where('status', 'pending')->countAllResults()
        ];
    }
}