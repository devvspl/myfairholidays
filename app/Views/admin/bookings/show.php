<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/bookings') ?>">Bookings</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

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

    <div class="row">
        <!-- Booking Information -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Booking Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Booking Reference</p>
                            <h5><?= esc($booking['booking_reference']) ?></h5>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Booking Date</p>
                            <h5><?= date('d M Y, h:i A', strtotime($booking['created_at'])) ?></h5>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Hotel</p>
                            <h5><?= esc($booking['hotel_name']) ?></h5>
                            <p class="text-muted mb-0"><?= esc($booking['hotel_address']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Payment Reference</p>
                            <h5><?= esc($booking['payment_reference'] ?? 'N/A') ?></h5>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <p class="text-muted mb-1">Check-In</p>
                            <h6><?= date('d M Y', strtotime($booking['check_in_date'])) ?></h6>
                        </div>
                        <div class="col-md-3">
                            <p class="text-muted mb-1">Check-Out</p>
                            <h6><?= date('d M Y', strtotime($booking['check_out_date'])) ?></h6>
                        </div>
                        <div class="col-md-3">
                            <p class="text-muted mb-1">Nights</p>
                            <h6><?= $booking['nights'] ?> Night<?= $booking['nights'] > 1 ? 's' : '' ?></h6>
                        </div>
                        <div class="col-md-3">
                            <p class="text-muted mb-1">Rooms</p>
                            <h6><?= $booking['rooms'] ?> Room<?= $booking['rooms'] > 1 ? 's' : '' ?></h6>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <p class="text-muted mb-1">Adults</p>
                            <h6><?= $booking['adults'] ?> Adult<?= $booking['adults'] > 1 ? 's' : '' ?></h6>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1">Children</p>
                            <h6><?= $booking['children'] ?> Child<?= $booking['children'] != 1 ? 'ren' : '' ?></h6>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1">Infants</p>
                            <h6><?= $booking['infants'] ?? 0 ?> Infant<?= ($booking['infants'] ?? 0) > 1 ? 's' : '' ?></h6>
                        </div>
                    </div>

                    <?php if (!empty($booking['special_requests'])): ?>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <p class="text-muted mb-1">Special Requests</p>
                            <p><?= nl2br(esc($booking['special_requests'])) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <?php 
                    $guestDetails = $booking['guest_details'] ?? [];
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Name</p>
                            <h6><?= esc($booking['customer_name']) ?></h6>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Email</p>
                            <h6><?= esc($booking['customer_email']) ?></h6>
                        </div>
                        <div class="col-md-6 mt-3">
                            <p class="text-muted mb-1">Phone</p>
                            <h6><?= esc($booking['customer_phone']) ?></h6>
                        </div>
                        <?php if (!empty($guestDetails['country'])): ?>
                        <div class="col-md-6 mt-3">
                            <p class="text-muted mb-1">Country</p>
                            <h6><?= esc($guestDetails['country']) ?></h6>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Pricing Details -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pricing Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td>Base Price</td>
                                <td class="text-end">₹<?= number_format($booking['base_price'], 2) ?></td>
                            </tr>
                            <?php if ($booking['discount'] > 0): ?>
                            <tr>
                                <td>Discount</td>
                                <td class="text-end text-success">-₹<?= number_format($booking['discount'], 2) ?></td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td>Taxes & Fees</td>
                                <td class="text-end">₹<?= number_format($booking['taxes'], 2) ?></td>
                            </tr>
                            <tr class="table-active">
                                <td><strong>Total Amount</strong></td>
                                <td class="text-end"><strong>₹<?= number_format($booking['total_amount'], 2) ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Status Management -->
        <div class="col-lg-4">
            <!-- Booking Status -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Booking Status</h5>
                </div>
                <div class="card-body">
                    <?php
                    $statusColors = [
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'info'
                    ];
                    $color = $statusColors[$booking['booking_status']] ?? 'secondary';
                    ?>
                    <div class="mb-3">
                        <span class="badge bg-<?= $color ?>-subtle text-<?= $color ?> fs-5 px-3 py-2">
                            <?= ucfirst($booking['booking_status']) ?>
                        </span>
                    </div>

                    <form method="post" action="<?= base_url('/admin/bookings/' . $booking['id'] . '/update-status') ?>">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Update Status</label>
                            <select class="form-select" name="status" required>
                                <option value="pending" <?= $booking['booking_status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="confirmed" <?= $booking['booking_status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                <option value="cancelled" <?= $booking['booking_status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                <option value="completed" <?= $booking['booking_status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes (Optional)</label>
                            <textarea class="form-control" name="notes" rows="3" placeholder="Add any notes..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Payment Status</h5>
                </div>
                <div class="card-body">
                    <?php
                    $paymentColors = [
                        'pending' => 'warning',
                        'paid' => 'success',
                        'failed' => 'danger',
                        'refunded' => 'info'
                    ];
                    $payColor = $paymentColors[$booking['payment_status']] ?? 'secondary';
                    ?>
                    <div class="mb-3">
                        <span class="badge bg-<?= $payColor ?>-subtle text-<?= $payColor ?> fs-5 px-3 py-2">
                            <?= ucfirst($booking['payment_status']) ?>
                        </span>
                    </div>

                    <form method="post" action="<?= base_url('/admin/bookings/' . $booking['id'] . '/update-payment-status') ?>">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Update Payment Status</label>
                            <select class="form-select" name="payment_status" required>
                                <option value="pending" <?= $booking['payment_status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="paid" <?= $booking['payment_status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
                                <option value="failed" <?= $booking['payment_status'] === 'failed' ? 'selected' : '' ?>>Failed</option>
                                <option value="refunded" <?= $booking['payment_status'] === 'refunded' ? 'selected' : '' ?>>Refunded</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Reference</label>
                            <input type="text" class="form-control" name="payment_reference" value="<?= esc($booking['payment_reference'] ?? '') ?>" placeholder="Payment reference number">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Payment</button>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <a href="<?= base_url('/admin/bookings') ?>" class="btn btn-light w-100 mb-2">
                        <i data-lucide="arrow-left" class="icon-xs me-1"></i> Back to List
                    </a>
                    <button onclick="window.print()" class="btn btn-outline-primary w-100">
                        <i data-lucide="printer" class="icon-xs me-1"></i> Print Details
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layouts/dashboard_footer') ?>
