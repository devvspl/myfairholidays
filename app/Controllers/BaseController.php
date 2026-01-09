<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    protected $session;
    protected $helpers = ['form', 'url'];
    protected $commonData = [];

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load helpers for all controllers
        $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->session = service('session');
        
        // Set common view data for all public pages
        $this->setCommonViewData();
    }
    
    /**
     * Set common data for all views
     */
    protected function setCommonViewData()
    {
        // Initialize with basic data
        $this->commonData = [
            'site_name' => 'My Fair Holidays',
            'site_tagline' => 'Best Domestic & International Travel Agency in Noida',
            'contact_email' => 'info@myfairholidays.com',
            'contact_phone' => '+91 9999999999',
            'contact_address' => 'Gaur City Center, Greater Noida Uttar Pradesh 201307',
            'social_facebook' => '#',
            'social_instagram' => '#',
            'social_twitter' => '#',
            'social_linkedin' => '#',
            'destinationTypes' => [],
            'popularDestinations' => []
        ];

        // Try to load navigation data for public pages
        try {
            $destinationTypeModel = new \App\Models\DestinationTypeModel();
            $destinationModel = new \App\Models\DestinationModel();
            
            $this->commonData['destinationTypes'] = $destinationTypeModel->getActiveTypesWithDestinations();
            $this->commonData['popularDestinations'] = $destinationModel->getPopularDestinations(10);
        } catch (\Exception $e) {
            // Log the error but don't break the page
            log_message('error', 'Failed to load navigation data: ' . $e->getMessage());
        }
    }
}
