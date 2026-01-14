<?php include APPPATH . 'Views/layouts/public_header.php'; ?>

<!-- ============================ Booking Success Page ================================== -->
<section class="pt-4 gray-simple position-relative">
    <div class="container">
        <!-- Success Header -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <div class="success-icon mb-4">
                    <i class="fas fa-check-circle fa-5x text-success"></i>
                </div>
                <h1 class="display-4 mb-3 text-success">Booking Confirmed!</h1>
                <p class="lead">Thank you for choosing My Fair Holidays. Your booking has been successfully confirmed.</p>
                <div class="order-id mt-4">
                    <h4>Booking Reference: <span class="text-warning"><?= $bookingComplete['booking_reference'] ?? $bookingComplete['order_id'] ?></span></h4>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Hotel Information -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-hotel me-2"></i>Hotel Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <?php if (!empty($bookingComplete['hotel']['featured_image'])): ?>
                                    <img src="<?= base_url('uploads/hotels/' . $bookingComplete['hotel']['featured_image']) ?>" 
                                         alt="<?= esc($bookingComplete['hotel']['name']) ?>" 
                                         class="img-fluid rounded">
                                <?php else: ?>
                                    <div class="placeholder-image bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-hotel fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <h4><?= esc($bookingComplete['hotel']['name']) ?></h4>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    <?= esc($bookingComplete['hotel']['location']) ?>
                                </p>
                                <div class="rating mb-2">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?= $i <= $bookingComplete['hotel']['rating'] ? 'text-warning' : 'text-muted' ?>"></i>
                                    <?php endfor; ?>
                                    <span class="ms-2"><?= $bookingComplete['hotel']['rating'] ?>/5</span>
                                </div>
                                <p><?= esc($bookingComplete['hotel']['short_description']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Booking Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="booking-info-item mb-3">
                                    <strong>Check-in Date:</strong><br>
                                    <span class="text-primary"><?= date('F j, Y', strtotime($bookingComplete['booking_data']['check_in_date'])) ?></span>
                                </div>
                                <div class="booking-info-item mb-3">
                                    <strong>Check-out Date:</strong><br>
                                    <span class="text-primary"><?= date('F j, Y', strtotime($bookingComplete['booking_data']['check_out_date'])) ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="booking-info-item mb-3">
                                    <strong>Guests:</strong><br>
                                    <?= $bookingComplete['booking_data']['adults'] ?> Adults
                                    <?php if ($bookingComplete['booking_data']['children'] > 0): ?>
                                        , <?= $bookingComplete['booking_data']['children'] ?> Children
                                    <?php endif; ?>
                                    <?php if ($bookingComplete['booking_data']['infants'] > 0): ?>
                                        , <?= $bookingComplete['booking_data']['infants'] ?> Infants
                                    <?php endif; ?>
                                </div>
                                <div class="booking-info-item mb-3">
                                    <strong>Rooms:</strong><br>
                                    <?= $bookingComplete['booking_data']['rooms'] ?> Room(s)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guest Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Guest Information</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($bookingComplete['guest_data'])): ?>
                            <div class="row">
                                <?php foreach ($bookingComplete['guest_data'] as $index => $guest): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="guest-card border rounded p-3">
                                            <h6 class="text-primary">Guest <?= $index + 1 ?></h6>
                                            <p class="mb-1"><strong>Name:</strong> <?= esc($guest['first_name'] . ' ' . $guest['last_name']) ?></p>
                                            <p class="mb-1"><strong>Date of Birth:</strong> <?= date('F j, Y', strtotime($guest['date_of_birth'])) ?></p>
                                            <?php if (!empty($guest['passport_number'])): ?>
                                                <p class="mb-0"><strong>Passport:</strong> <?= esc($guest['passport_number']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Booking Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="summary-item d-flex justify-content-between mb-2">
                            <span>Base Price:</span>
                            <span>₹<?= number_format($bookingComplete['payment_data']['amount'] / 1.08 + ($bookingComplete['hotel']['is_featured'] ? $bookingComplete['payment_data']['amount'] * 0.15 / 1.08 : 0), 2) ?></span>
                        </div>
                        <?php if ($bookingComplete['hotel']['is_featured']): ?>
                            <div class="summary-item d-flex justify-content-between mb-2 text-success">
                                <span>Discount (15%):</span>
                                <span>-₹<?= number_format($bookingComplete['payment_data']['amount'] * 0.15 / 1.08, 2) ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="summary-item d-flex justify-content-between mb-2">
                            <span>Taxes (8%):</span>
                            <span>₹<?= number_format($bookingComplete['payment_data']['amount'] * 0.08 / 1.08, 2) ?></span>
                        </div>
                        <hr>
                        <div class="summary-total d-flex justify-content-between mb-3">
                            <strong>Total Amount:</strong>
                            <strong class="text-success">₹<?= number_format($bookingComplete['payment_data']['amount'], 2) ?></strong>
                        </div>
                        
                        <div class="payment-info">
                            <h6 class="text-primary">Payment Information</h6>
                            <p class="mb-1"><strong>Payment Method:</strong> <?= ucfirst(str_replace('_', ' ', $bookingComplete['payment_data']['payment_method'])) ?></p>
                            <p class="mb-1"><strong>Status:</strong> <span class="badge bg-warning">Pending</span></p>
                            <p class="mb-0"><strong>Currency:</strong> <?= $bookingComplete['payment_data']['currency'] ?></p>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-phone me-2"></i>Need Help?</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Customer Support:</strong></p>
                        <p class="mb-1"><i class="fas fa-phone me-2"></i>+91 98765 43210</p>
                        <p class="mb-1"><i class="fas fa-envelope me-2"></i>support@myfairholidays.com</p>
                        <p class="mb-0"><i class="fas fa-clock me-2"></i>24/7 Support Available</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="<?= base_url('/') ?>" class="btn btn-primary btn-lg me-3">
                    <i class="fas fa-home me-2"></i>Back to Home
                </a>
                <a href="<?= base_url('/hotels') ?>" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-search me-2"></i>Book Another Hotel
                </a>
            </div>
        </div>

        <!-- Important Notes -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Important Information:</h6>
                    <ul class="mb-0">
                        <li>A confirmation email has been sent to <strong><?= esc($bookingComplete['payment_data']['customer_email']) ?></strong></li>
                        <li>Please carry a valid ID proof during check-in</li>
                        <li>Check-in time: 2:00 PM | Check-out time: 12:00 PM</li>
                        <li>For any changes or cancellations, please contact our support team</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.success-icon i {
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

.guest-card {
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}

.guest-card:hover {
    background-color: #e9ecef;
    transform: translateY(-2px);
}

.summary-item {
    font-size: 0.95rem;
}

.summary-total {
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .display-4 {
        font-size: 2rem;
    }
    
    .success-icon i {
        font-size: 3rem !important;
    }
}
</style>

<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>