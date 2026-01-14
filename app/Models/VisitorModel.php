<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitorModel extends Model
{
    protected $table = 'visitors';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'ip_address',
        'user_agent',
        'browser',
        'platform',
        'device_type',
        'page_url',
        'page_title',
        'referrer',
        'country',
        'city',
        'session_id',
        'user_id',
        'visit_duration'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Track a page visit
     */
    public function trackVisit($data)
    {
        return $this->insert($data, false);
    }

    /**
     * Get visitor statistics
     */
    public function getStatistics($days = 30)
    {
        $startDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        
        return [
            'total_visits' => $this->where('created_at >=', $startDate)->countAllResults(),
            'unique_visitors' => $this->select('COUNT(DISTINCT ip_address) as count')
                                     ->where('created_at >=', $startDate)
                                     ->get()
                                     ->getRow()
                                     ->count,
            'mobile_visits' => $this->where('device_type', 'mobile')
                                   ->where('created_at >=', $startDate)
                                   ->countAllResults(),
            'desktop_visits' => $this->where('device_type', 'desktop')
                                    ->where('created_at >=', $startDate)
                                    ->countAllResults(),
        ];
    }

    /**
     * Get top pages
     */
    public function getTopPages($limit = 10, $days = 30)
    {
        $startDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        
        return $this->select('page_url, page_title, COUNT(*) as visit_count')
                    ->where('created_at >=', $startDate)
                    ->groupBy('page_url')
                    ->orderBy('visit_count', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get visitor trends by date
     */
    public function getVisitorTrends($days = 30)
    {
        $startDate = date('Y-m-d', strtotime("-{$days} days"));
        
        return $this->select('DATE(created_at) as date, COUNT(*) as visits')
                    ->where('DATE(created_at) >=', $startDate)
                    ->groupBy('DATE(created_at)')
                    ->orderBy('date', 'ASC')
                    ->findAll();
    }

    /**
     * Get browser statistics
     */
    public function getBrowserStats($days = 30)
    {
        $startDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        
        return $this->select('browser, COUNT(*) as count')
                    ->where('created_at >=', $startDate)
                    ->where('browser IS NOT NULL')
                    ->groupBy('browser')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }

    /**
     * Get platform statistics
     */
    public function getPlatformStats($days = 30)
    {
        $startDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        
        return $this->select('platform, COUNT(*) as count')
                    ->where('created_at >=', $startDate)
                    ->where('platform IS NOT NULL')
                    ->groupBy('platform')
                    ->orderBy('count', 'DESC')
                    ->findAll();
    }

    /**
     * Get recent visitors
     */
    public function getRecentVisitors($limit = 50)
    {
        return $this->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Clean old visitor data
     */
    public function cleanOldData($days = 90)
    {
        $cutoffDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        return $this->where('created_at <', $cutoffDate)->delete();
    }
}
