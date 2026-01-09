<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HotelModel;
use App\Models\DestinationModel;
use App\Models\HotelImageModel;
use App\Models\HotelFaqModel;

/**
 * Admin Hotel Controller
 * 
 * Handles hotel management in admin panel
 * 
 * @package App\Controllers\Admin
 */
class HotelController extends BaseController
{
    protected $hotelModel;
    protected $destinationModel;
    protected $hotelImageModel;
    protected $hotelFaqModel;

    public function __construct()
    {
        $this->hotelModel = new HotelModel();
        $this->destinationModel = new DestinationModel();
        $this->hotelImageModel = new HotelImageModel();
        $this->hotelFaqModel = new HotelFaqModel();
    }

    /**
     * Display list of hotels
     */
    public function index()
    {
        $perPage = 20;
        
        // Get search and filter parameters
        $search = $this->request->getVar('search');
        $destinationId = $this->request->getVar('destination_id');
        $starRating = $this->request->getVar('star_rating');
        $status = $this->request->getVar('status');
        
        // Build query
        $builder = $this->hotelModel
            ->select('hotels.*, destinations.name as destination_name')
            ->join('destinations', 'destinations.id = hotels.destination_id', 'left');
        
        // Apply search filter
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('hotels.name', $search)
                    ->orLike('hotels.description', $search)
                    ->orLike('destinations.name', $search)
                    ->orLike('hotels.address', $search)
                    ->groupEnd();
        }
        
        // Apply destination filter
        if (!empty($destinationId)) {
            $builder->where('hotels.destination_id', $destinationId);
        }
        
        // Apply star rating filter
        if (!empty($starRating)) {
            $builder->where('hotels.star_rating', $starRating);
        }
        
        // Apply status filter
        if (!empty($status)) {
            $builder->where('hotels.status', $status);
        }
        
        $hotels = $builder->orderBy('hotels.created_at', 'DESC')
                         ->paginate($perPage);

        $data = [
            'title' => 'Hotels Management',
            'hotels' => $hotels,
            'destinations' => $this->destinationModel->where('status', 'active')->findAll(),
            'stats' => $this->hotelModel->getHotelStats(),
            'pager' => $this->hotelModel->pager,
            'currentFilters' => [
                'search' => $search,
                'destination_id' => $destinationId,
                'star_rating' => $starRating,
                'status' => $status
            ]
        ];

        return view('admin/hotels/index', $data);
    }

    /**
     * Show create hotel form
     */
    public function create()
    {
        $data = [
            'title' => 'Add New Hotel',
            'destinations' => $this->destinationModel->where('status', 'active')->findAll()
        ];

        return view('admin/hotels/create', $data);
    }

    /**
     * Store new hotel
     */
    public function store()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[10]',
            'destination_id' => 'required|integer',
            'address' => 'required|min_length[10]',
            'star_rating' => 'required|integer|greater_than[0]|less_than[6]',
            'price_per_night' => 'required|decimal',
            'status' => 'required|in_list[active,inactive]',
            'featured_image' => 'if_exist|uploaded[featured_image]|is_image[featured_image]|max_size[featured_image,2048]',
            'contact_email' => 'permit_empty|valid_email',
            'website' => 'permit_empty|valid_url'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle file upload
        $featuredImagePath = null;
        $featuredImage = $this->request->getFile('featured_image');
        
        if ($featuredImage && $featuredImage->isValid() && !$featuredImage->hasMoved()) {
            // Create uploads directory if it doesn't exist
            $uploadPath = ROOTPATH . 'public/uploads/hotels';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $newName = $featuredImage->getRandomName();
            $featuredImage->move($uploadPath, $newName);
            $featuredImagePath = 'uploads/hotels/' . $newName;
        }

        // Generate slug
        $slug = url_title($this->request->getPost('name'), '-', true);
        
        // Check if slug exists and make it unique
        $existingSlug = $this->hotelModel->where('slug', $slug)->first();
        if ($existingSlug) {
            $slug = $slug . '-' . time();
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => $slug,
            'description' => $this->sanitizeHtml($this->request->getPost('description')),
            'short_description' => $this->request->getPost('short_description'),
            'featured_image' => $featuredImagePath,
            'destination_id' => $this->request->getPost('destination_id'),
            'address' => $this->request->getPost('address'),
            'latitude' => $this->request->getPost('latitude') ?: null,
            'longitude' => $this->request->getPost('longitude') ?: null,
            'star_rating' => $this->request->getPost('star_rating'),
            'price_per_night' => $this->request->getPost('price_per_night'),
            'amenities' => $this->request->getPost('amenities'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'contact_email' => $this->request->getPost('contact_email'),
            'website' => $this->request->getPost('website'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'status' => $this->request->getPost('status'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'check_in_time' => $this->request->getPost('check_in_time') ?: '2:00 PM',
            'check_out_time' => $this->request->getPost('check_out_time') ?: '12:00 PM',
            'cancellation_policy' => $this->sanitizeHtml($this->request->getPost('cancellation_policy')),
            'hotel_policies' => $this->sanitizeHtml($this->request->getPost('hotel_policies')),
            'nearby_attractions' => $this->sanitizeHtml($this->request->getPost('nearby_attractions')),
            'transportation_info' => $this->sanitizeHtml($this->request->getPost('transportation_info')),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->hotelModel->insert($data)) {
            $hotelId = $this->hotelModel->getInsertID();
            
            // Handle multiple image uploads
            $this->handleImageUploads($hotelId);
            
            // Create default FAQs for the hotel
            $this->hotelFaqModel->createDefaultFaqs($hotelId);
            
            return redirect()->to('/admin/hotels')->with('success', 'Hotel created successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to create hotel');
    }

    /**
     * Show edit hotel form
     */
    public function edit($id)
    {
        $hotel = $this->hotelModel->find($id);
        
        if (!$hotel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Hotel not found');
        }

        // Get hotel images
        $images = $this->hotelImageModel->getHotelImages($id);
        
        // Get hotel FAQs
        $faqs = $this->hotelFaqModel->getAllHotelFaqs($id);

        $data = [
            'title' => 'Edit Hotel',
            'hotel' => $hotel,
            'images' => $images,
            'faqs' => $faqs,
            'destinations' => $this->destinationModel->where('status', 'active')->findAll()
        ];

        return view('admin/hotels/edit', $data);
    }

    /**
     * Show hotel details
     */
    public function show($id)
    {
        $hotel = $this->hotelModel->getHotelWithDetails($id);
        
        if (!$hotel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Hotel not found');
        }

        // Get hotel images
        $images = $this->hotelImageModel->getHotelImages($id);

        $data = [
            'title' => 'Hotel Details - ' . $hotel['name'],
            'hotel' => $hotel,
            'images' => $images
        ];

        return view('admin/hotels/show', $data);
    }

    /**
     * Handle multiple image uploads
     * 
     * @param int $hotelId
     * @return void
     */
    private function handleImageUploads(int $hotelId): void
    {
        $images = $this->request->getFiles();
        
        if (!isset($images['hotel_images']) || empty($images['hotel_images'])) {
            return;
        }

        // Create uploads directory if it doesn't exist
        $uploadPath = ROOTPATH . 'public/uploads/hotels/gallery';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $altTexts = $this->request->getPost('image_alt_texts') ?? [];
        $captions = $this->request->getPost('image_captions') ?? [];
        $sortOrder = 0;

        foreach ($images['hotel_images'] as $index => $image) {
            if ($image->isValid() && !$image->hasMoved()) {
                $newName = $image->getRandomName();
                $image->move($uploadPath, $newName);
                
                $imageData = [
                    'hotel_id' => $hotelId,
                    'image_path' => 'uploads/hotels/gallery/' . $newName,
                    'alt_text' => $altTexts[$index] ?? '',
                    'caption' => $captions[$index] ?? '',
                    'sort_order' => $sortOrder++,
                    'is_featured' => 0 // First image can be set as featured later
                ];

                $this->hotelImageModel->insert($imageData);
            }
        }
    }

    /**
     * Delete hotel image
     */
    public function deleteImage($imageId)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back()->with('error', 'Invalid request');
        }

        $image = $this->hotelImageModel->find($imageId);
        
        if (!$image) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Image not found'
            ]);
        }

        if ($this->hotelImageModel->deleteImage($imageId)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to delete image'
        ]);
    }

    /**
     * Set featured image
     */
    public function setFeaturedImage($hotelId, $imageId)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back()->with('error', 'Invalid request');
        }

        if ($this->hotelImageModel->setFeaturedImage($hotelId, $imageId)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Featured image updated successfully'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update featured image'
        ]);
    }

    /**
     * Update image sort order
     */
    public function updateImageOrder()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back()->with('error', 'Invalid request');
        }

        $sortData = $this->request->getPost('sort_data');
        
        if (!$sortData) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No sort data provided'
            ]);
        }

        if ($this->hotelImageModel->updateSortOrder($sortData)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Image order updated successfully'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update image order'
        ]);
    }

    /**
     * Update hotel
     */
    public function update($id)
    {
        $hotel = $this->hotelModel->find($id);
        
        if (!$hotel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Hotel not found');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[10]',
            'destination_id' => 'required|integer',
            'address' => 'required|min_length[10]',
            'star_rating' => 'required|integer|greater_than[0]|less_than[6]',
            'price_per_night' => 'required|decimal',
            'status' => 'required|in_list[active,inactive]',
            'featured_image' => 'if_exist|uploaded[featured_image]|is_image[featured_image]|max_size[featured_image,2048]',
            'contact_email' => 'permit_empty|valid_email',
            'website' => 'permit_empty|valid_url'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle file upload
        $featuredImagePath = $hotel['featured_image']; // Keep existing image by default
        
        // Check if user wants to remove current image
        if ($this->request->getPost('remove_featured_image')) {
            if ($hotel['featured_image'] && file_exists(ROOTPATH . 'public/' . $hotel['featured_image'])) {
                unlink(ROOTPATH . 'public/' . $hotel['featured_image']);
            }
            $featuredImagePath = null;
        }
        
        $featuredImage = $this->request->getFile('featured_image');
        
        if ($featuredImage && $featuredImage->isValid() && !$featuredImage->hasMoved()) {
            // Delete old image if exists
            if ($hotel['featured_image'] && file_exists(ROOTPATH . 'public/' . $hotel['featured_image'])) {
                unlink(ROOTPATH . 'public/' . $hotel['featured_image']);
            }
            
            // Create uploads directory if it doesn't exist
            $uploadPath = ROOTPATH . 'public/uploads/hotels';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $newName = $featuredImage->getRandomName();
            $featuredImage->move($uploadPath, $newName);
            $featuredImagePath = 'uploads/hotels/' . $newName;
        }

        // Generate slug if name changed
        $slug = $hotel['slug'];
        if ($this->request->getPost('name') !== $hotel['name']) {
            $newSlug = url_title($this->request->getPost('name'), '-', true);
            
            // Check if slug exists and make it unique
            $existingSlug = $this->hotelModel->where('slug', $newSlug)->where('id !=', $id)->first();
            if (!$existingSlug) {
                $slug = $newSlug;
            } else {
                $slug = $newSlug . '-' . time();
            }
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => $slug,
            'description' => $this->sanitizeHtml($this->request->getPost('description')),
            'short_description' => $this->request->getPost('short_description'),
            'featured_image' => $featuredImagePath,
            'destination_id' => $this->request->getPost('destination_id'),
            'address' => $this->request->getPost('address'),
            'latitude' => $this->request->getPost('latitude') ?: null,
            'longitude' => $this->request->getPost('longitude') ?: null,
            'star_rating' => $this->request->getPost('star_rating'),
            'price_per_night' => $this->request->getPost('price_per_night'),
            'amenities' => $this->request->getPost('amenities'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'contact_email' => $this->request->getPost('contact_email'),
            'website' => $this->request->getPost('website'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'status' => $this->request->getPost('status'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'check_in_time' => $this->request->getPost('check_in_time') ?: '2:00 PM',
            'check_out_time' => $this->request->getPost('check_out_time') ?: '12:00 PM',
            'cancellation_policy' => $this->sanitizeHtml($this->request->getPost('cancellation_policy')),
            'hotel_policies' => $this->sanitizeHtml($this->request->getPost('hotel_policies')),
            'nearby_attractions' => $this->sanitizeHtml($this->request->getPost('nearby_attractions')),
            'transportation_info' => $this->sanitizeHtml($this->request->getPost('transportation_info')),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->hotelModel->update($id, $data)) {
            // Handle multiple image uploads
            $this->handleImageUploads($id);
            
            return redirect()->to('/admin/hotels')->with('success', 'Hotel updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update hotel');
    }

    /**
     * Delete hotel
     */
    public function delete($id)
    {
        $hotel = $this->hotelModel->find($id);
        
        if (!$hotel) {
            return redirect()->to('/admin/hotels')->with('error', 'Hotel not found');
        }

        if ($this->hotelModel->delete($id)) {
            return redirect()->to('/admin/hotels')->with('success', 'Hotel deleted successfully');
        }

        return redirect()->to('/admin/hotels')->with('error', 'Failed to delete hotel');
    }

    /**
     * Toggle hotel status
     */
    public function toggleStatus($id)
    {
        $hotel = $this->hotelModel->find($id);
        
        if (!$hotel) {
            return $this->response->setJSON(['success' => false, 'message' => 'Hotel not found']);
        }

        $newStatus = $hotel['status'] === 'active' ? 'inactive' : 'active';
        
        if ($this->hotelModel->update($id, ['status' => $newStatus])) {
            return $this->response->setJSON(['success' => true, 'status' => $newStatus]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status']);
    }

    /**
     * Toggle hotel featured status
     */
    public function toggleFeatured($id)
    {
        $hotel = $this->hotelModel->find($id);
        
        if (!$hotel) {
            return $this->response->setJSON(['success' => false, 'message' => 'Hotel not found']);
        }

        $newFeatured = $hotel['is_featured'] ? 0 : 1;
        
        if ($this->hotelModel->update($id, ['is_featured' => $newFeatured])) {
            return $this->response->setJSON(['success' => true, 'is_featured' => $newFeatured]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update featured status']);
    }

    /**
     * Handle bulk actions
     */
    public function bulkAction()
    {
        $action = $this->request->getPost('bulk_action');
        $hotelIds = $this->request->getPost('hotel_ids');

        if (empty($action) || empty($hotelIds)) {
            return redirect()->back()->with('error', 'Please select hotels and an action');
        }

        $count = 0;
        foreach ($hotelIds as $id) {
            switch ($action) {
                case 'activate':
                    if ($this->hotelModel->update($id, ['status' => 'active'])) $count++;
                    break;
                case 'deactivate':
                    if ($this->hotelModel->update($id, ['status' => 'inactive'])) $count++;
                    break;
                case 'feature':
                    if ($this->hotelModel->update($id, ['is_featured' => 1])) $count++;
                    break;
                case 'unfeature':
                    if ($this->hotelModel->update($id, ['is_featured' => 0])) $count++;
                    break;
                case 'delete':
                    if ($this->hotelModel->delete($id)) $count++;
                    break;
            }
        }

        $message = "Successfully applied '{$action}' to {$count} hotel(s)";
        return redirect()->to('/admin/hotels')->with('success', $message);
    }

    /**
     * Manage hotel FAQs
     */
    public function manageFaqs($hotelId)
    {
        $hotel = $this->hotelModel->find($hotelId);
        
        if (!$hotel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Hotel not found');
        }

        $faqs = $this->hotelFaqModel->getAllHotelFaqs($hotelId);

        $data = [
            'title' => 'Manage FAQs - ' . $hotel['name'],
            'hotel' => $hotel,
            'faqs' => $faqs
        ];

        return view('admin/hotels/faqs', $data);
    }

    /**
     * Store hotel FAQ
     */
    public function storeFaq($hotelId)
    {
        $hotel = $this->hotelModel->find($hotelId);
        
        if (!$hotel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Hotel not found');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'question' => 'required|min_length[10]|max_length[500]',
            'answer' => 'required|min_length[10]',
            'sort_order' => 'permit_empty|integer',
            'is_active' => 'permit_empty|in_list[0,1]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'hotel_id' => $hotelId,
            'question' => $this->request->getPost('question'),
            'answer' => $this->request->getPost('answer'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($this->hotelFaqModel->insert($data)) {
            return redirect()->to("/admin/hotels/faqs/{$hotelId}")->with('success', 'FAQ added successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to add FAQ');
    }

    /**
     * Update hotel FAQ
     */
    public function updateFaq($hotelId, $faqId)
    {
        $hotel = $this->hotelModel->find($hotelId);
        $faq = $this->hotelFaqModel->find($faqId);
        
        if (!$hotel || !$faq || $faq['hotel_id'] != $hotelId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('FAQ not found');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'question' => 'required|min_length[10]|max_length[500]',
            'answer' => 'required|min_length[10]',
            'sort_order' => 'permit_empty|integer',
            'is_active' => 'permit_empty|in_list[0,1]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'question' => $this->request->getPost('question'),
            'answer' => $this->request->getPost('answer'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($this->hotelFaqModel->update($faqId, $data)) {
            return redirect()->to("/admin/hotels/faqs/{$hotelId}")->with('success', 'FAQ updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update FAQ');
    }

    /**
     * Delete hotel FAQ
     */
    public function deleteFaq($hotelId, $faqId)
    {
        $hotel = $this->hotelModel->find($hotelId);
        $faq = $this->hotelFaqModel->find($faqId);
        
        if (!$hotel || !$faq || $faq['hotel_id'] != $hotelId) {
            return $this->response->setJSON(['success' => false, 'message' => 'FAQ not found']);
        }

        if ($this->hotelFaqModel->delete($faqId)) {
            return $this->response->setJSON(['success' => true, 'message' => 'FAQ deleted successfully']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete FAQ']);
    }

    /**
     * Update FAQ sort order
     */
    public function updateFaqOrder($hotelId)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back()->with('error', 'Invalid request');
        }

        $sortData = $this->request->getPost('sort_data');
        
        if (!$sortData) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No sort data provided'
            ]);
        }

        if ($this->hotelFaqModel->updateSortOrder($sortData)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'FAQ order updated successfully'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update FAQ order'
        ]);
    }

    /**
     * Sanitize HTML content from rich text editor
     * 
     * @param string $html
     * @return string
     */
    private function sanitizeHtml(string $html): string
    {
        // Allow basic HTML tags that Quill generates
        $allowedTags = '<p><br><strong><em><u><s><h1><h2><h3><h4><h5><h6><ul><ol><li><a><img><blockquote><span><div>';
        
        // Strip unwanted tags but keep allowed ones
        $cleaned = strip_tags($html, $allowedTags);
        
        // Remove potentially dangerous attributes but keep safe ones
        $cleaned = preg_replace('/(<[^>]+) (on\w+|javascript:|vbscript:|data:)[^>]*>/i', '$1>', $cleaned);
        
        return $cleaned;
    }
}