<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Bookings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-3">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-primary-subtle text-primary rounded">
                                    <i data-lucide="calendar" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Total Bookings</p>
                            <h4 class="mb-0"><?= $stats['total'] ?? 0 ?></h4>
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
                            <h4 class="mb-0"><?= $stats['pending'] ?? 0 ?></h4>
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
                            <p class="text-muted mb-1">Confirmed</p>
                            <h4 class="mb-0"><?= $stats['confirmed'] ?? 0 ?></h4>
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
                                    <i data-lucide="check-square" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Completed</p>
                            <h4 class="mb-0"><?= $stats['completed'] ?? 0 ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Filters -->
                    <form method="get" action="<?= base_url('/admin/bookings') ?>" class="mb-3">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="search" placeholder="Search by reference, name, email..." value="<?= esc($filters['search'] ?? '') ?>">
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="status">
                                    <option value="">All Status</option>
                                    <option value="pending" <?= ($filters['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="confirmed" <?= ($filters['status'] ?? '') === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                    <option value="cancelled" <?= ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    <option value="completed" <?= ($filters['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="payment_status">
                                    <option value="">All Payment Status</option>
                                    <option value="pending" <?= ($filters['payment_status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="paid" <?= ($filters['payment_status'] ?? '') === 'paid' ? 'selected' : '' ?>>Paid</option>
                                    <option value="failed" <?= ($filters['payment_status'] ?? '') === 'failed' ? 'selected' : '' ?>>Failed</option>
                                    <option value="refunded" <?= ($filters['payment_status'] ?? '') === 'refunded' ? 'selected' : '' ?>>Refunded</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="date_from" placeholder="From Date" value="<?= esc($filters['date_from'] ?? '') ?>">
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="date_to" placeholder="To Date" value="<?= esc($filters['date_to'] ?? '') ?>">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i data-lucide="search" class="icon-xs"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <?php if (session()->has('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <!-- Bookings Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Reference</th>
                                    <th>Hotel</th>
                                    <th>Customer</th>
                                    <th>Check-In</th>
                                    <th>Check-Out</th>
                                    <th>Guests</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($bookings)): ?>
                                    <?php foreach ($bookings as $booking): ?>
                                    <tr>
                                        <td>
                                            <a href="<?= base_url('/admin/bookings/' . $booking['id']) ?>" class="text-primary fw-semibold">
                                                <?= esc($booking['booking_reference']) ?>
                                            </a>
                                        </td>
                                        <td><?= esc($booking['hotel_name']) ?></td>
                                        <td>
                                            <div><?= esc($booking['customer_name']) ?></div>
                                            <small class="text-muted"><?= esc($booking['customer_email']) ?></small>
                                        </td>
                                        <td><?= date('d M Y', strtotime($booking['check_in_date'])) ?></td>
                                        <td><?= date('d M Y', strtotime($booking['check_out_date'])) ?></td>
                                        <td>
                                            <?= $booking['adults'] ?> Adult<?= $booking['adults'] > 1 ? 's' : '' ?>
                                            <?php if ($booking['children'] > 0): ?>
                                                <br><small class="text-muted"><?= $booking['children'] ?> Child<?= $booking['children'] > 1 ? 'ren' : '' ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>₹<?= number_format($booking['total_amount'], 2) ?></td>
                                        <td>
                                            <?php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'confirmed' => 'success',
                                                'cancelled' => 'danger',
                                                'completed' => 'info'
                                            ];
                                            $color = $statusColors[$booking['booking_status']] ?? 'secondary';
                                            ?>
                                            <span class="badge bg-<?= $color ?>-subtle text-<?= $color ?>">
                                                <?= ucfirst($booking['booking_status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                            $paymentColors = [
                                                'pending' => 'warning',
                                                'paid' => 'success',
                                                'failed' => 'danger',
                                                'refunded' => 'info'
                                            ];
                                            $payColor = $paymentColors[$booking['payment_status']] ?? 'secondary';
                                            ?>
                                            <span class="badge bg-<?= $payColor ?>-subtle text-<?= $payColor ?>">
                                                <?= ucfirst($booking['payment_status']) ?>
                                            </span>
                                        </td>
                                        <td><?= date('d M Y', strtotime($booking['created_at'])) ?></td>
                                        <td>
                                            <a href="<?= base_url('/admin/bookings/' . $booking['id']) ?>" class="btn btn-sm btn-light" title="View Details">
                                                <i data-lucide="eye" class="icon-xs"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="11" class="text-center py-4">
                                            <div class="text-muted">
                                                <i data-lucide="inbox" class="icon-lg mb-2"></i>
                                                <p>No bookings found</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if (!empty($bookings)): ?>
                    <div class="mt-3">
                        <?= $pager->links() ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layouts/dashboard_footer') ?>
