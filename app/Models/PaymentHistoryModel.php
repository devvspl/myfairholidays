<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Payment History Model
 * 
 * Handles payment transaction data operations (Read-only)
 * 
 * @package App\Models
 * @author  Senior PHP Architect
 */
class PaymentHistoryModel extends Model
{
    protected $table            = 'payment_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'order_id', 'transaction_id', 'customer_name', 'customer_email', 'customer_phone',
        'itinerary_id', 'itinerary_title', 'amount', 'currency', 'payment_gateway',
        'payment_method', 'status', 'gateway_response', 'notes', 'payment_date'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'order_id' => 'required|max_length[100]',
        'customer_name' => 'required|min_length[2]|max_length[255]',
        'customer_email' => 'required|valid_email',
        'amount' => 'required|decimal|greater_than[0]',
        'currency' => 'required|max_length[10]',
        'payment_gateway' => 'required|max_length[50]',
        'status' => 'required|in_list[pending,completed,failed,cancelled,refunded]'
    ];

    protected $validationMessages = [
        'order_id' => [
            'required' => 'Order ID is required',
            'max_length' => 'Order ID cannot exceed 100 characters'
        ],
        'customer_name' => [
            'required' => 'Customer name is required',
            'min_length' => 'Customer name must be at least 2 characters',
            'max_length' => 'Customer name cannot exceed 255 characters'
        ],
        'customer_email' => [
            'required' => 'Customer email is required',
            'valid_email' => 'Please enter a valid email address'
        ],
        'amount' => [
            'required' => 'Amount is required',
            'decimal' => 'Amount must be a valid decimal number',
            'greater_than' => 'Amount must be greater than 0'
        ],
        'currency' => [
            'required' => 'Currency is required',
            'max_length' => 'Currency cannot exceed 10 characters'
        ],
        'payment_gateway' => [
            'required' => 'Payment gateway is required',
            'max_length' => 'Payment gateway cannot exceed 50 characters'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Invalid payment status'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get payments for admin listing with pagination
     * 
     * @param int $perPage
     * @return array
     */
    public function getAdminPaymentsList(int $perPage = 20): array
    {
        return $this->select('payment_history.*, itineraries.title as itinerary_title')
                    ->join('itineraries', 'itineraries.id = payment_history.itinerary_id', 'left')
                    ->orderBy('payment_history.created_at', 'DESC')
                    ->paginate($perPage);
    }

    /**
     * Get payment by order ID
     * 
     * @param string $orderId
     * @return array|null
     */
    public function getByOrderId(string $orderId): ?array
    {
        return $this->select('payment_history.*, itineraries.title as itinerary_title')
                    ->join('itineraries', 'itineraries.id = payment_history.itinerary_id', 'left')
                    ->where('payment_history.order_id', $orderId)
                    ->first();
    }

    /**
     * Get payment by transaction ID
     * 
     * @param string $transactionId
     * @return array|null
     */
    public function getByTransactionId(string $transactionId): ?array
    {
        return $this->select('payment_history.*, itineraries.title as itinerary_title')
                    ->join('itineraries', 'itineraries.id = payment_history.itinerary_id', 'left')
                    ->where('payment_history.transaction_id', $transactionId)
                    ->first();
    }

    /**
     * Get payments by status
     * 
     * @param string $status
     * @param int $limit
     * @return array
     */
    public function getPaymentsByStatus(string $status, int $limit = 50): array
    {
        return $this->select('payment_history.*, itineraries.title as itinerary_title')
                    ->join('itineraries', 'itineraries.id = payment_history.itinerary_id', 'left')
                    ->where('payment_history.status', $status)
                    ->orderBy('payment_history.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get payments by customer email
     * 
     * @param string $email
     * @param int $limit
     * @return array
     */
    public function getPaymentsByCustomer(string $email, int $limit = 20): array
    {
        return $this->select('payment_history.*, itineraries.title as itinerary_title')
                    ->join('itineraries', 'itineraries.id = payment_history.itinerary_id', 'left')
                    ->where('payment_history.customer_email', $email)
                    ->orderBy('payment_history.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get payments by date range
     * 
     * @param string $startDate
     * @param string $endDate
     * @param int $limit
     * @return array
     */
    public function getPaymentsByDateRange(string $startDate, string $endDate, int $limit = 100): array
    {
        return $this->select('payment_history.*, itineraries.title as itinerary_title')
                    ->join('itineraries', 'itineraries.id = payment_history.itinerary_id', 'left')
                    ->where('payment_history.payment_date >=', $startDate)
                    ->where('payment_history.payment_date <=', $endDate)
                    ->orderBy('payment_history.payment_date', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get payment statistics
     * 
     * @return array
     */
    public function getPaymentStats(): array
    {
        return [
            'total_transactions' => $this->countAllResults(),
            'completed' => $this->where('status', 'completed')->countAllResults(),
            'pending' => $this->where('status', 'pending')->countAllResults(),
            'failed' => $this->where('status', 'failed')->countAllResults(),
            'cancelled' => $this->where('status', 'cancelled')->countAllResults(),
            'refunded' => $this->where('status', 'refunded')->countAllResults(),
            'total_revenue' => $this->selectSum('amount')->where('status', 'completed')->first()['amount'] ?? 0,
            'pending_amount' => $this->selectSum('amount')->where('status', 'pending')->first()['amount'] ?? 0,
            'refunded_amount' => $this->selectSum('amount')->where('status', 'refunded')->first()['amount'] ?? 0,
            'avg_transaction' => $this->selectAvg('amount')->where('status', 'completed')->first()['amount'] ?? 0
        ];
    }

    /**
     * Get revenue statistics by period
     * 
     * @param string $period (today, week, month, year)
     * @return array
     */
    public function getRevenueByPeriod(string $period = 'month'): array
    {
        $builder = $this->where('status', 'completed');

        switch ($period) {
            case 'today':
                $builder->where('DATE(payment_date)', date('Y-m-d'));
                break;
            case 'week':
                $builder->where('payment_date >=', date('Y-m-d', strtotime('-7 days')));
                break;
            case 'month':
                $builder->where('payment_date >=', date('Y-m-d', strtotime('-30 days')));
                break;
            case 'year':
                $builder->where('payment_date >=', date('Y-m-d', strtotime('-365 days')));
                break;
        }

        $result = $builder->selectSum('amount')->first();
        return [
            'period' => $period,
            'revenue' => $result['amount'] ?? 0,
            'count' => $builder->countAllResults()
        ];
    }

    /**
     * Get monthly revenue report
     * 
     * @param int $year
     * @return array
     */
    public function getMonthlyRevenue(int $year = null): array
    {
        if (!$year) {
            $year = date('Y');
        }

        $sql = "SELECT 
                    MONTH(payment_date) as month,
                    MONTHNAME(payment_date) as month_name,
                    COUNT(*) as transaction_count,
                    SUM(amount) as total_revenue
                FROM payment_history 
                WHERE YEAR(payment_date) = ? 
                AND status = 'completed'
                GROUP BY MONTH(payment_date)
                ORDER BY MONTH(payment_date)";

        return $this->db->query($sql, [$year])->getResultArray();
    }

    /**
     * Get payment gateway statistics
     * 
     * @return array
     */
    public function getGatewayStats(): array
    {
        return $this->select('payment_gateway, COUNT(*) as transaction_count, SUM(amount) as total_amount')
                    ->where('status', 'completed')
                    ->groupBy('payment_gateway')
                    ->orderBy('total_amount', 'DESC')
                    ->findAll();
    }

    /**
     * Get top customers by transaction value
     * 
     * @param int $limit
     * @return array
     */
    public function getTopCustomers(int $limit = 10): array
    {
        return $this->select('customer_name, customer_email, COUNT(*) as transaction_count, SUM(amount) as total_spent')
                    ->where('status', 'completed')
                    ->groupBy('customer_email')
                    ->orderBy('total_spent', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get popular itineraries by bookings
     * 
     * @param int $limit
     * @return array
     */
    public function getPopularItineraries(int $limit = 10): array
    {
        return $this->select('payment_history.itinerary_id, itineraries.title, COUNT(*) as booking_count, SUM(payment_history.amount) as total_revenue')
                    ->join('itineraries', 'itineraries.id = payment_history.itinerary_id')
                    ->where('payment_history.status', 'completed')
                    ->groupBy('payment_history.itinerary_id')
                    ->orderBy('booking_count', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Search payments
     * 
     * @param string $keyword
     * @param array $filters
     * @param int $limit
     * @return array
     */
    public function searchPayments(string $keyword, array $filters = [], int $limit = 50): array
    {
        $builder = $this->select('payment_history.*, itineraries.title as itinerary_title')
                        ->join('itineraries', 'itineraries.id = payment_history.itinerary_id', 'left');

        // Keyword search
        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('payment_history.order_id', $keyword)
                    ->orLike('payment_history.transaction_id', $keyword)
                    ->orLike('payment_history.customer_name', $keyword)
                    ->orLike('payment_history.customer_email', $keyword)
                    ->orLike('itineraries.title', $keyword)
                    ->groupEnd();
        }

        // Apply filters
        if (isset($filters['status']) && $filters['status']) {
            $builder->where('payment_history.status', $filters['status']);
        }

        if (isset($filters['gateway']) && $filters['gateway']) {
            $builder->where('payment_history.payment_gateway', $filters['gateway']);
        }

        if (isset($filters['start_date']) && $filters['start_date']) {
            $builder->where('payment_history.payment_date >=', $filters['start_date']);
        }

        if (isset($filters['end_date']) && $filters['end_date']) {
            $builder->where('payment_history.payment_date <=', $filters['end_date']);
        }

        if (isset($filters['min_amount']) && $filters['min_amount']) {
            $builder->where('payment_history.amount >=', $filters['min_amount']);
        }

        if (isset($filters['max_amount']) && $filters['max_amount']) {
            $builder->where('payment_history.amount <=', $filters['max_amount']);
        }

        return $builder->orderBy('payment_history.created_at', 'DESC')
                       ->limit($limit)
                       ->findAll();
    }

    /**
     * Get recent transactions for dashboard
     * 
     * @param int $limit
     * @return array
     */
    public function getRecentTransactions(int $limit = 10): array
    {
        return $this->select('payment_history.*, itineraries.title as itinerary_title')
                    ->join('itineraries', 'itineraries.id = payment_history.itinerary_id', 'left')
                    ->orderBy('payment_history.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get failed transactions for review
     * 
     * @param int $limit
     * @return array
     */
    public function getFailedTransactions(int $limit = 20): array
    {
        return $this->select('payment_history.*, itineraries.title as itinerary_title')
                    ->join('itineraries', 'itineraries.id = payment_history.itinerary_id', 'left')
                    ->where('payment_history.status', 'failed')
                    ->orderBy('payment_history.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Export payments data
     * 
     * @param array $filters
     * @return array
     */
    public function exportPayments(array $filters = []): array
    {
        $builder = $this->select('payment_history.*, itineraries.title as itinerary_title')
                        ->join('itineraries', 'itineraries.id = payment_history.itinerary_id', 'left');

        // Apply filters
        if (isset($filters['status']) && $filters['status']) {
            $builder->where('payment_history.status', $filters['status']);
        }

        if (isset($filters['start_date']) && $filters['start_date']) {
            $builder->where('payment_history.payment_date >=', $filters['start_date']);
        }

        if (isset($filters['end_date']) && $filters['end_date']) {
            $builder->where('payment_history.payment_date <=', $filters['end_date']);
        }

        return $builder->orderBy('payment_history.payment_date', 'DESC')
                       ->findAll();
    }

    /**
     * Get payments with user details for admin listing
     * 
     * @param int $perPage
     * @return array
     */
    public function getPaymentsWithUserDetails(int $perPage = 20): array
    {
        return $this->select('payment_history.*, itineraries.title as itinerary_title, users.name as user_name')
                    ->join('itineraries', 'itineraries.id = payment_history.itinerary_id', 'left')
                    ->join('users', 'users.email = payment_history.customer_email', 'left')
                    ->orderBy('payment_history.created_at', 'DESC')
                    ->paginate($perPage);
    }

    /**
     * Get payment with full details
     * 
     * @param int $id
     * @return array|null
     */
    public function getPaymentWithDetails(int $id): ?array
    {
        return $this->select('payment_history.*, itineraries.title as itinerary_title, users.name as user_name')
                    ->join('itineraries', 'itineraries.id = payment_history.itinerary_id', 'left')
                    ->join('users', 'users.email = payment_history.customer_email', 'left')
                    ->find($id);
    }

    /**
     * Get payments for export with filters
     * 
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @param string|null $status
     * @return array
     */
    public function getPaymentsForExport(?string $dateFrom = null, ?string $dateTo = null, ?string $status = null): array
    {
        $builder = $this->select('payment_history.*, itineraries.title as itinerary_title, users.name as user_name')
                        ->join('itineraries', 'itineraries.id = payment_history.itinerary_id', 'left')
                        ->join('users', 'users.email = payment_history.customer_email', 'left');

        if ($dateFrom) {
            $builder->where('payment_history.payment_date >=', $dateFrom);
        }

        if ($dateTo) {
            $builder->where('payment_history.payment_date <=', $dateTo);
        }

        if ($status) {
            $builder->where('payment_history.status', $status);
        }

        return $builder->orderBy('payment_history.payment_date', 'DESC')
                       ->findAll();
    }

    /**
     * Get comprehensive payment statistics
     * 
     * @return array
     */
    public function getPaymentStatistics(): array
    {
        $stats = $this->getPaymentStats();
        
        // Add additional statistics
        $stats['today_revenue'] = $this->getRevenueByPeriod('today')['revenue'];
        $stats['week_revenue'] = $this->getRevenueByPeriod('week')['revenue'];
        $stats['month_revenue'] = $this->getRevenueByPeriod('month')['revenue'];
        $stats['year_revenue'] = $this->getRevenueByPeriod('year')['revenue'];
        
        $stats['gateway_stats'] = $this->getGatewayStats();
        $stats['top_customers'] = $this->getTopCustomers(5);
        $stats['popular_itineraries'] = $this->getPopularItineraries(5);
        
        return $stats;
    }

    /**
     * Note: This model is primarily read-only for payment history
     * Payments are typically created by payment gateway webhooks or API callbacks
     * Direct insertion should be handled by payment processing services
     */
}