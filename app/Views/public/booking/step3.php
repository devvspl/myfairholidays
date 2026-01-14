<?php include APPPATH . 'Views/layouts/public_header.php'; ?>

<!-- ============================ Booking Page Step 3 ================================== -->
<section class="pt-4 gray-simple position-relative">
    <div class="container">

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div id="stepper" class="bs-stepper stepper-outline mb-5">
                    <div class="bs-stepper-header">
                        <!-- Step 1 -->
                        <div class="step completed" data-target="#step-1">
                            <div class="text-center">
                                <button type="button" class="step-trigger mb-0" id="steppertrigger1">
                                    <span class="bs-stepper-circle"><i class="fa-solid fa-check"></i></span>
                                </button>
                                <h6 class="bs-stepper-label d-none d-md-block">Tour Review</h6>
                            </div>
                        </div>
                        <div class="line"></div>

                        <!-- Step 2 -->
                        <div class="step completed" data-target="#step-2">
                            <div class="text-center">
                                <button type="button" class="step-trigger mb-0" id="steppertrigger2">
                                    <span class="bs-stepper-circle"><i class="fa-solid fa-check"></i></span>
                                </button>
                                <h6 class="bs-stepper-label d-none d-md-block">Traveler Info</h6>
                            </div>
                        </div>
                        <div class="line"></div>

                        <!-- Step 3 -->
                        <div class="step active" data-target="#step-3">
                            <div class="text-center">
                                <button type="button" class="step-trigger mb-0" id="steppertrigger3">
                                    <span class="bs-stepper-circle">3</span>
                                </button>
                                <h6 class="bs-stepper-label d-none d-md-block">Make Payment</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-start">
            <div class="col-xl-12 col-lg-12 col-md-12">
                
                <?php if (session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i><?= session('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <div class="div-title d-flex align-items-center mb-3">
                    <h4>Payment Method</h4>
                    <p class="text-muted ms-3 mb-0">Choose how you'd like to pay</p>
                </div>
                
                <form action="<?= base_url('/booking/payment') ?>" method="post" id="paymentForm">
                    <?= csrf_field() ?>
                    
                    <div class="row align-items-start">
                        <div class="col-xl-8 col-lg-8 col-md-12">

                            <!-- Payment Method -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4>Select Payment Method</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="payment-options">
                                                    <div class="form-check mb-3 p-3 border rounded">
                                                        <input class="form-check-input" type="radio" name="payment_method" id="visa" value="visa" required>
                                                        <label class="form-check-label w-100" for="visa">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa-brands fa-cc-visa text-primary fs-2 me-3"></i>
                                                                <div>
                                                                    <strong>Visa Card</strong>
                                                                    <p class="mb-0 text-muted small">Pay securely with your Visa card</p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3 p-3 border rounded">
                                                        <input class="form-check-input" type="radio" name="payment_method" id="mastercard" value="mastercard">
                                                        <label class="form-check-label w-100" for="mastercard">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa-brands fa-cc-mastercard text-danger fs-2 me-3"></i>
                                                                <div>
                                                                    <strong>Mastercard</strong>
                                                                    <p class="mb-0 text-muted small">Pay securely with your Mastercard</p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3 p-3 border rounded">
                                                        <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                                                        <label class="form-check-label w-100" for="paypal">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa-brands fa-cc-paypal text-info fs-2 me-3"></i>
                                                                <div>
                                                                    <strong>PayPal</strong>
                                                                    <p class="mb-0 text-muted small">Fast and secure payment with PayPal</p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3 p-3 border rounded">
                                                        <input class="form-check-input" type="radio" name="payment_method" id="amazon_pay" value="amazon_pay">
                                                        <label class="form-check-label w-100" for="amazon_pay">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa-brands fa-amazon-pay text-warning fs-2 me-3"></i>
                                                                <div>
                                                                    <strong>Amazon Pay</strong>
                                                                    <p class="mb-0 text-muted small">Use your Amazon account to pay</p>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#" class="text-primary">Terms & Conditions</a> and <a href="#" class="text-primary">Privacy Policy</a>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('/booking/step2') ?>" class="btn btn-outline-primary">
                                    <i class="fa-solid fa-arrow-left me-2"></i>Back
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fa-solid fa-lock me-2"></i>Complete Booking
                                </button>
                            </div>

                        </div>

                        <!-- Booking Summary Sidebar -->
                        <div class="col-xl-4 col-lg-4 col-md-12">
                            <div class="side-block card rounded-2 p-3 sticky-top" style="top: 100px;">
                                <h5 class="fw-semibold fs-6">Booking Summary</h5>
                                
                                <!-- Hotel Info -->
                                <div class="mid-block rounded-2 border br-dashed p-2 mb-3">
                                    <h6 class="fw-semibold mb-2"><?= esc($hotel['name']) ?></h6>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="d-inline-block">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fa fa-star <?= $i <= ($hotel['star_rating'] ?? 0) ? 'text-warning' : 'text-muted' ?> text-xs"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <span class="text-muted text-sm ms-2"><?= $hotel['star_rating'] ?? 0 ?> Star Hotel</span>
                                    </div>
                                    <?php if (!empty($hotel['address'])): ?>
                                    <p class="text-muted text-sm mb-0"><i class="fa-solid fa-location-dot me-1"></i><?= esc($hotel['address']) ?></p>
                                    <?php endif; ?>
                                </div>

                                <!-- Booking Details -->
                                <div class="mid-block rounded-2 border br-dashed p-2 mb-3">
                                    <div class="row align-items-center justify-content-between g-2 mb-3">
                                        <div class="col-6">
                                            <div class="gray rounded-2 p-2">
                                                <span class="d-block text-muted-3 text-sm fw-medium text-uppercase mb-1">Check-In</span>
                                                <p class="text-dark fw-semibold lh-base text-md mb-0"><?= $checkIn->format('d M Y') ?></p>
                                                <span class="text-dark text-sm"><?= $hotel['check_in_time'] ?? '2:00 PM' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="gray rounded-2 p-2">
                                                <span class="d-block text-muted-3 text-sm fw-medium text-uppercase mb-1">Check-Out</span>
                                                <p class="text-dark fw-semibold lh-base text-md mb-0"><?= $checkOut->format('d M Y') ?></p>
                                                <span class="text-dark text-sm"><?= $hotel['check_out_time'] ?? '11:00 AM' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted-2 text-sm">Length of Stay:</span>
                                                <span class="text-dark fw-medium text-sm"><?= $nights ?> Night<?= $nights > 1 ? 's' : '' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted-2 text-sm">Rooms:</span>
                                                <span class="text-dark fw-medium text-sm"><?= $rooms ?> Room<?= $rooms > 1 ? 's' : '' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted-2 text-sm">Guests:</span>
                                                <span class="text-dark fw-medium text-sm"><?= $adults ?> Adult<?= $adults > 1 ? 's' : '' ?><?= $children > 0 ? ', ' . $children . ' Child' . ($children > 1 ? 'ren' : '') : '' ?><?= $infants > 0 ? ', ' . $infants . ' Infant' . ($infants > 1 ? 's' : '') : '' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price Breakdown -->
                                <div class="bott-block d-block mb-3">
                                    <h6 class="fw-semibold mb-2">Price Breakdown</h6>
                                    <ul class="list-group list-group-borderless">
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            <span class="fw-medium mb-0 text-sm">Base Price</span>
                                            <span class="fw-medium text-sm">₹<?= number_format($pricePerNight, 2) ?> × <?= $nights ?> × <?= $rooms ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            <span class="fw-medium mb-0">Subtotal</span>
                                            <span class="fw-semibold">₹<?= number_format($basePrice, 2) ?></span>
                                        </li>
                                        <?php if ($discountInfo['has_discount']): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-light-success">
                                            <span class="fw-medium mb-0">
                                                Hotel Discount
                                                <span class="badge rounded-1 text-bg-danger smaller mb-0 ms-1">
                                                    <?php if ($discountInfo['discount_type'] === 'percentage'): ?>
                                                        <?= number_format($discountInfo['discount_percentage'], 0) ?>% OFF
                                                    <?php else: ?>
                                                        ₹<?= number_format($hotel['discount_value'], 0) ?> OFF
                                                    <?php endif; ?>
                                                </span>
                                            </span>
                                            <span class="fw-semibold text-success">-₹<?= number_format($discount, 2) ?></span>
                                        </li>
                                        <?php endif; ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            <span class="fw-medium mb-0">Taxes & Fees (8%)</span>
                                            <span class="fw-semibold">₹<?= number_format($taxes, 2) ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-top pt-3 px-0">
                                            <span class="fw-bold text-success mb-0 fs-5">Total Amount</span>
                                            <span class="fw-bold text-success fs-5">₹<?= number_format($totalPrice, 2) ?></span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Security Badge -->
                                <div class="alert alert-info mb-0">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-shield-halved fs-4 me-2"></i>
                                        <div>
                                            <small class="fw-semibold d-block">Secure Payment</small>
                                            <small class="text-muted">Your payment information is encrypted and secure</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- ============================ Booking Page Step 3 End ================================== -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentForm = document.getElementById('paymentForm');
    
    // Payment form validation
    paymentForm.addEventListener('submit', function(e) {
        const termsCheckbox = document.getElementById('terms');
        if (!termsCheckbox.checked) {
            e.preventDefault();
            alert('Please accept the Terms & Conditions to proceed.');
            return false;
        }
        
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!paymentMethod) {
            e.preventDefault();
            alert('Please select a payment method.');
            return false;
        }
    });
});
</script>

<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>
    