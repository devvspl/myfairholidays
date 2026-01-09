<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Payment History</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Statistics Cards -->
    <div class="row mb-1">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 card-title">Total Payments</p>
                            <h4 class="fw-bold text-primary mb-0">
                                <?= count($payments ?? []) ?>
                            </h4>
                        </div>
                        <div>
                            <i data-lucide="credit-card" class="fs-32 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 card-title">Completed</p>
                            <h4 class="fw-bold text-success mb-0">
                                <?= count(array_filter($payments ?? [], fn($p) => $p['status'] === 'completed')) ?>
                            </h4>
                        </div>
                        <div>
                            <i data-lucide="check-circle" class="fs-32 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 card-title">Pending</p>
                            <h4 class="fw-bold text-warning mb-0">
                                <?= count(array_filter($payments ?? [], fn($p) => $p['status'] === 'pending')) ?>
                            </h4>
                        </div>
                        <div>
                            <i data-lucide="clock" class="fs-32 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 card-title">Total Revenue</p>
                            <h4 class="fw-bold text-info mb-0">
                                $<?= number_format(array_sum(array_map(fn($p) => $p['status'] === 'completed' ? $p['amount'] : 0, $payments ?? [])), 2) ?>
                            </h4>
                        </div>
                        <div>
                            <i data-lucide="dollar-sign" class="fs-32 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Payment Transactions</h4>
                    <div class="btn-group">
                        <a href="<?= base_url('/admin/payment-history/statistics') ?>" class="btn btn-outline-info btn-sm">
                            <i data-lucide="bar-chart-3" class="me-1"></i> Statistics
                        </a>
                        <a href="<?= base_url('/admin/payment-history/export') ?>" class="btn btn-outline-success btn-sm">
                            <i data-lucide="download" class="me-1"></i> Export
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Options -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="failed">Failed</option>
                                <option value="refunded">Refunded</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="methodFilter">
                                <option value="">All Methods</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="stripe">Stripe</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Search by transaction ID, user, or email...">
                                <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                                    <i data-lucide="search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Transaction ID</th>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($payments)): ?>
                                    <?php foreach ($payments as $payment): ?>
                                        <tr>
                                            <td><?= $payment['id'] ?></td>
                                            <td>
                                                <code><?= esc($payment['transaction_id']) ?></code>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?= esc($payment['user_name'] ?? 'Unknown User') ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?= esc($payment['user_email'] ?? 'N/A') ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>$<?= number_format($payment['amount'], 2) ?></strong>
                                                <br>
                                                <small class="text-muted"><?= strtoupper($payment['currency'] ?? 'USD') ?></small>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-info">
                                                    <?= ucwords(str_replace('_', ' ', $payment['payment_method'])) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-<?= 
                                                    $payment['status'] === 'completed' ? 'success' : 
                                                    ($payment['status'] === 'pending' ? 'warning' : 
                                                    ($payment['status'] === 'failed' ? 'danger' : 
                                                    ($payment['status'] === 'refunded' ? 'info' : 'secondary'))) ?>">
                                                    <?= ucfirst($payment['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?= date('M d, Y', strtotime($payment['created_at'])) ?>
                                                <br>
                                                <small class="text-muted"><?= date('g:i A', strtotime($payment['created_at'])) ?></small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('/admin/payment-history/show/' . $payment['id']) ?>" 
                                                       class="btn btn-sm btn-outline-info" title="View Details">
                                                        <i data-lucide="eye"></i>
                                                    </a>
                                                    <?php if ($payment['status'] === 'completed'): ?>
                                                        <button type="button" class="btn btn-sm btn-outline-warning process-refund" 
                                                                data-id="<?= $payment['id'] ?>" 
                                                                data-amount="<?= $payment['amount'] ?>" title="Process Refund">
                                                            <i data-lucide="rotate-ccw"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                    <?php if (in_array($payment['status'], ['pending', 'failed'])): ?>
                                                        <a href="<?= base_url('/admin/payment-history/delete/' . $payment['id']) ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           onclick="return confirm('Are you sure you want to delete this payment record?')" title="Delete">
                                                            <i data-lucide="trash-2"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No payment records found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Refund Modal -->
<div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="refundModalLabel">Process Refund</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="refundForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="refundAmount" class="form-label">Refund Amount ($)</label>
                        <input type="number" step="0.01" class="form-control" id="refundAmount" name="refund_amount" required>
                        <div class="form-text">Maximum refundable amount: $<span id="maxAmount"></span></div>
                    </div>
                    <div class="mb-3">
                        <label for="refundReason" class="form-label">Refund Reason</label>
                        <textarea class="form-control" id="refundReason" name="refund_reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Process Refund</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPaymentId = null;

    // Process refund functionality
    document.querySelectorAll('.process-refund').forEach(button => {
        button.addEventListener('click', function() {
            currentPaymentId = this.dataset.id;
            const maxAmount = this.dataset.amount;
            
            document.getElementById('refundAmount').max = maxAmount;
            document.getElementById('refundAmount').value = maxAmount;
            document.getElementById('maxAmount').textContent = maxAmount;
            
            new bootstrap.Modal(document.getElementById('refundModal')).show();
        });
    });

    // Refund form submission
    document.getElementById('refundForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        
        fetch(`<?= base_url('/admin/payment-history/process-refund/') ?>${currentPaymentId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('refundModal')).hide();
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to process refund'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while processing the refund');
        });
    });

    // Filter functionality
    document.getElementById('statusFilter').addEventListener('change', filterTable);
    document.getElementById('methodFilter').addEventListener('change', filterTable);
    document.getElementById('searchInput').addEventListener('input', filterTable);

    function filterTable() {
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        const methodFilter = document.getElementById('methodFilter').value.toLowerCase();
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length < 8) return; // Skip empty rows
            
            const status = cells[5].textContent.toLowerCase().trim();
            const method = cells[4].textContent.toLowerCase().trim();
            const searchableText = [
                cells[1].textContent, // Transaction ID
                cells[2].textContent, // User info
            ].join(' ').toLowerCase();
            
            const statusMatch = !statusFilter || status.includes(statusFilter);
            const methodMatch = !methodFilter || method.includes(methodFilter.replace('_', ' '));
            const searchMatch = !searchTerm || searchableText.includes(searchTerm);
            
            row.style.display = statusMatch && methodMatch && searchMatch ? '' : 'none';
        });
    }
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>