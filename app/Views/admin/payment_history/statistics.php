<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/payment-history') ?>">Payment History</a></li>
                        <li class="breadcrumb-item active">Statistics</li>
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

    <!-- Revenue Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-success-subtle text-success rounded">
                                    <i data-lucide="dollar-sign" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Today's Revenue</p>
                            <h4 class="mb-0">$<?= number_format($stats['today_revenue'] ?? 0, 2) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-info-subtle text-info rounded">
                                    <i data-lucide="calendar-days" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">This Week</p>
                            <h4 class="mb-0">$<?= number_format($stats['week_revenue'] ?? 0, 2) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-warning-subtle text-warning rounded">
                                    <i data-lucide="calendar" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">This Month</p>
                            <h4 class="mb-0">$<?= number_format($stats['month_revenue'] ?? 0, 2) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-primary-subtle text-primary rounded">
                                    <i data-lucide="trending-up" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">This Year</p>
                            <h4 class="mb-0">$<?= number_format($stats['year_revenue'] ?? 0, 2) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-primary-subtle text-primary rounded">
                                    <i data-lucide="credit-card" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Total Transactions</p>
                            <h4 class="mb-0"><?= number_format($stats['total_transactions'] ?? 0) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-success-subtle text-success rounded">
                                    <i data-lucide="check-circle" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Completed</p>
                            <h4 class="mb-0"><?= number_format($stats['completed'] ?? 0) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-warning-subtle text-warning rounded">
                                    <i data-lucide="clock" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Pending</p>
                            <h4 class="mb-0"><?= number_format($stats['pending'] ?? 0) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-danger-subtle text-danger rounded">
                                    <i data-lucide="x-circle" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Failed</p>
                            <h4 class="mb-0"><?= number_format($stats['failed'] ?? 0) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Overview -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-success-subtle text-success rounded">
                                    <i data-lucide="banknote" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Total Revenue</p>
                            <h4 class="mb-0">$<?= number_format($stats['total_revenue'] ?? 0, 2) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-warning-subtle text-warning rounded">
                                    <i data-lucide="hourglass" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Pending Amount</p>
                            <h4 class="mb-0">$<?= number_format($stats['pending_amount'] ?? 0, 2) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-info-subtle text-info rounded">
                                    <i data-lucide="rotate-ccw" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Refunded Amount</p>
                            <h4 class="mb-0">$<?= number_format($stats['refunded_amount'] ?? 0, 2) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-primary-subtle text-primary rounded">
                                    <i data-lucide="bar-chart-3" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Average Transaction</p>
                            <h4 class="mb-0">$<?= number_format($stats['avg_transaction'] ?? 0, 2) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Payment Gateway Statistics -->
        <?php if (!empty($stats['gateway_stats'])): ?>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Payment Gateway Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Gateway</th>
                                    <th>Transactions</th>
                                    <th>Revenue</th>
                                    <th>Success Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stats['gateway_stats'] as $gateway): ?>
                                    <tr>
                                        <td>
                                            <strong><?= esc($gateway['gateway']) ?></strong>
                                        </td>
                                        <td><?= number_format($gateway['total_transactions']) ?></td>
                                        <td>$<?= number_format($gateway['total_revenue'], 2) ?></td>
                                        <td>
                                            <?php 
                                            $successRate = $gateway['total_transactions'] > 0 
                                                ? ($gateway['successful_transactions'] / $gateway['total_transactions']) * 100 
                                                : 0;
                                            ?>
                                            <span class="badge bg-<?= $successRate >= 90 ? 'success' : ($successRate >= 70 ? 'warning' : 'danger') ?>">
                                                <?= number_format($successRate, 1) ?>%
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Top Customers -->
        <?php if (!empty($stats['top_customers'])): ?>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Top Customers</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Transactions</th>
                                    <th>Total Spent</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stats['top_customers'] as $customer): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                                        <?= strtoupper(substr($customer['customer_name'], 0, 1)) ?>
                                                    </div>
                                                </div>
                                                <div>
                                                    <strong><?= esc($customer['customer_name']) ?></strong>
                                                    <br><small class="text-muted"><?= esc($customer['customer_email']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= number_format($customer['transaction_count']) ?></td>
                                        <td>$<?= number_format($customer['total_amount'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Popular Itineraries -->
    <?php if (!empty($stats['popular_itineraries'])): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Most Popular Itineraries</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Itinerary</th>
                                    <th>Bookings</th>
                                    <th>Revenue</th>
                                    <th>Average Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stats['popular_itineraries'] as $itinerary): ?>
                                    <tr>
                                        <td>
                                            <strong><?= esc($itinerary['itinerary_name']) ?></strong>
                                            <?php if (!empty($itinerary['destination'])): ?>
                                                <br><small class="text-muted"><?= esc($itinerary['destination']) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= number_format($itinerary['booking_count']) ?></td>
                                        <td>$<?= number_format($itinerary['total_revenue'], 2) ?></td>
                                        <td>$<?= number_format($itinerary['avg_price'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Back Button -->
    <div class="row">
        <div class="col-12">
            <div class="text-center mt-4">
                <a href="<?= base_url('/admin/payment-history') ?>" class="btn btn-secondary">
                    <i data-lucide="arrow-left" class="me-1"></i> Back to Payment History
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layouts/dashboard_footer') ?>