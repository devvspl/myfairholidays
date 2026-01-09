<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PaymentHistoryModel;

/**
 * Admin Payment History Controller
 * 
 * Handles payment history management in admin panel
 * 
 * @package App\Controllers\Admin
 */
class PaymentHistoryController extends BaseController
{
    protected $paymentModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentHistoryModel();
    }

    /**
     * Display list of payment history
     */
    public function index()
    {
        $data = [
            'title' => 'Payment History Management',
            'payments' => $this->paymentModel->getPaymentsWithUserDetails()
        ];

        return view('admin/payment_history/index', $data);
    }

    /**
     * Show payment details
     */
    public function show($id)
    {
        $payment = $this->paymentModel->getPaymentWithDetails($id);
        
        if (!$payment) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Payment not found');
        }

        $data = [
            'title' => 'Payment Details',
            'payment' => $payment
        ];

        return view('admin/payment_history/show', $data);
    }

    /**
     * Update payment status
     */
    public function updateStatus($id)
    {
        $payment = $this->paymentModel->find($id);
        
        if (!$payment) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Payment not found');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'status' => 'required|in_list[pending,completed,failed,refunded,cancelled]',
            'admin_notes' => 'permit_empty|max_length[500]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'status' => $this->request->getPost('status'),
            'admin_notes' => $this->request->getPost('admin_notes'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->paymentModel->update($id, $data)) {
            return redirect()->to('/admin/payment-history')->with('success', 'Payment status updated successfully');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to update payment status');
    }

    /**
     * Process refund
     */
    public function processRefund($id)
    {
        $payment = $this->paymentModel->find($id);
        
        if (!$payment) {
            return $this->response->setJSON(['success' => false, 'message' => 'Payment not found']);
        }

        if ($payment['status'] !== 'completed') {
            return $this->response->setJSON(['success' => false, 'message' => 'Only completed payments can be refunded']);
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'refund_amount' => 'required|decimal|greater_than[0]',
            'refund_reason' => 'required|min_length[10]|max_length[500]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }

        $refundAmount = $this->request->getPost('refund_amount');
        $refundReason = $this->request->getPost('refund_reason');

        if ($refundAmount > $payment['amount']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Refund amount cannot exceed payment amount']);
        }

        $data = [
            'status' => 'refunded',
            'refund_amount' => $refundAmount,
            'refund_reason' => $refundReason,
            'refund_date' => date('Y-m-d H:i:s'),
            'admin_notes' => 'Refund processed by admin',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->paymentModel->update($id, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Refund processed successfully']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to process refund']);
    }

    /**
     * Export payment history
     */
    public function export()
    {
        $format = $this->request->getGet('format') ?? 'csv';
        $dateFrom = $this->request->getGet('date_from');
        $dateTo = $this->request->getGet('date_to');
        $status = $this->request->getGet('status');

        $payments = $this->paymentModel->getPaymentsForExport($dateFrom, $dateTo, $status);

        if ($format === 'csv') {
            return $this->exportToCsv($payments);
        } elseif ($format === 'excel') {
            return $this->exportToExcel($payments);
        }

        return redirect()->back()->with('error', 'Invalid export format');
    }

    /**
     * Get payment statistics
     */
    public function statistics()
    {
        $stats = $this->paymentModel->getPaymentStatistics();
        
        $data = [
            'title' => 'Payment Statistics',
            'stats' => $stats
        ];

        return view('admin/payment_history/statistics', $data);
    }

    /**
     * Export payments to CSV
     */
    private function exportToCsv($payments)
    {
        $filename = 'payment_history_' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // CSV headers
        fputcsv($output, [
            'ID', 'User', 'Amount', 'Currency', 'Payment Method', 
            'Transaction ID', 'Status', 'Payment Date', 'Notes'
        ]);
        
        foreach ($payments as $payment) {
            fputcsv($output, [
                $payment['id'],
                $payment['user_name'] ?? 'N/A',
                $payment['amount'],
                $payment['currency'],
                $payment['payment_method'],
                $payment['transaction_id'],
                $payment['status'],
                $payment['created_at'],
                $payment['admin_notes']
            ]);
        }
        
        fclose($output);
        exit;
    }

    /**
     * Delete payment record (soft delete)
     */
    public function delete($id)
    {
        $payment = $this->paymentModel->find($id);
        
        if (!$payment) {
            return redirect()->to('/admin/payment-history')->with('error', 'Payment not found');
        }

        if ($payment['status'] === 'completed') {
            return redirect()->to('/admin/payment-history')->with('error', 'Cannot delete completed payments');
        }

        if ($this->paymentModel->delete($id)) {
            return redirect()->to('/admin/payment-history')->with('success', 'Payment record deleted successfully');
        }

        return redirect()->to('/admin/payment-history')->with('error', 'Failed to delete payment record');
    }
}