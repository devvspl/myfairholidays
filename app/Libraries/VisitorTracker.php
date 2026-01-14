<?php

namespace App\Libraries;

use App\Models\VisitorModel;

class VisitorTracker
{
    protected $visitorModel;
    protected $request;

    public function __construct()
    {
        $this->visitorModel = new VisitorModel();
        $this->request = \Config\Services::request();
    }

    /**
     * Track the current page visit
     */
    public function track($pageTitle = null)
    {
        try {
            // Don't track admin pages or AJAX requests
            if ($this->shouldSkipTracking()) {
                return false;
            }

            $agent = $this->request->getUserAgent();
            
            $visitorData = [
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $agent->getAgentString(),
                'browser' => $agent->getBrowser(),
                'platform' => $agent->getPlatform(),
                'device_type' => $this->getDeviceType($agent),
                'page_url' => current_url(),
                'page_title' => $pageTitle,
                'referrer' => $this->request->getServer('HTTP_REFERER'),
                'session_id' => session_id(),
                'user_id' => session()->get('user_id'),
            ];

            return $this->visitorModel->trackVisit($visitorData);
        } catch (\Exception $e) {
            // Log error but don't break the page
            log_message('error', 'Visitor tracking error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Determine if tracking should be skipped
     */
    protected function shouldSkipTracking()
    {
        $uri = $this->request->getUri();
        $path = $uri->getPath();

        // Skip admin pages
        if (strpos($path, '/admin') === 0) {
            return true;
        }

        // Skip AJAX requests
        if ($this->request->isAJAX()) {
            return true;
        }

        // Skip API endpoints
        if (strpos($path, '/api') === 0) {
            return true;
        }

        // Skip auth pages
        if (strpos($path, '/auth') === 0) {
            return true;
        }

        // Skip static assets
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $skipExtensions = ['css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'eot'];
        if (in_array(strtolower($extension), $skipExtensions)) {
            return true;
        }

        return false;
    }

    /**
     * Determine device type from user agent
     */
    protected function getDeviceType($agent)
    {
        if ($agent->isMobile()) {
            // Check if it's a tablet by looking at user agent string
            $userAgentString = strtolower($agent->getAgentString());
            if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobile))/i', $userAgentString)) {
                return 'tablet';
            }
            return 'mobile';
        } else {
            return 'desktop';
        }
    }

    /**
     * Get visitor statistics
     */
    public function getStatistics($days = 30)
    {
        return $this->visitorModel->getStatistics($days);
    }

    /**
     * Get top pages
     */
    public function getTopPages($limit = 10, $days = 30)
    {
        return $this->visitorModel->getTopPages($limit, $days);
    }

    /**
     * Get visitor trends
     */
    public function getVisitorTrends($days = 30)
    {
        return $this->visitorModel->getVisitorTrends($days);
    }
}
