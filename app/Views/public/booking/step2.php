<?php include APPPATH . 'Views/layouts/public_header.php'; ?>

<!-- ============================ Booking Page Step 2 ================================== -->
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
                        <div class="step active" data-target="#step-2">
                            <div class="text-center">
                                <button type="button" class="step-trigger mb-0" id="steppertrigger2">
                                    <span class="bs-stepper-circle">2</span>
                                </button>
                                <h6 class="bs-stepper-label d-none d-md-block">Traveler Info</h6>
                            </div>
                        </div>
                        <div class="line"></div>

                        <!-- Step 3 -->
                        <div class="step" data-target="#step-3">
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
                    <h4>Contact Information</h4>
                    <p class="text-muted ms-3 mb-0">We'll send your booking confirmation here</p>
                </div>
                
                <form action="<?= base_url('/booking/step2') ?>" method="post" id="guestDetailsForm">
                    <?= csrf_field() ?>
                    
                    <div class="row align-items-start">
                        <div class="col-xl-8 col-lg-8 col-md-12">
                            
                            <!-- Booking Details Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4>Modify Booking Details (Optional)</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Check-In Date</label>
                                                <input type="date" class="form-control" name="check_in_date" value="<?= esc($bookingData['check_in_date']) ?>" min="<?= date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Check-Out Date</label>
                                                <input type="date" class="form-control" name="check_out_date" value="<?= esc($bookingData['check_out_date']) ?>" min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Rooms</label>
                                                <select class="form-control" name="rooms">
                                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                                    <option value="<?= $i ?>" <?= $bookingData['rooms'] == $i ? 'selected' : '' ?>><?= $i ?> Room<?= $i > 1 ? 's' : '' ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Adults</label>
                                                <select class="form-control" name="adults">
                                                    <?php for ($i = 1; $i <= 20; $i++): ?>
                                                    <option value="<?= $i ?>" <?= $bookingData['adults'] == $i ? 'selected' : '' ?>><?= $i ?> Adult<?= $i > 1 ? 's' : '' ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Children</label>
                                                <select class="form-control" name="children">
                                                    <?php for ($i = 0; $i <= 10; $i++): ?>
                                                    <option value="<?= $i ?>" <?= ($bookingData['children'] ?? 0) == $i ? 'selected' : '' ?>><?= $i ?> Child<?= $i != 1 ? 'ren' : '' ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Infants</label>
                                                <select class="form-control" name="infants">
                                                    <?php for ($i = 0; $i <= 5; $i++): ?>
                                                    <option value="<?= $i ?>" <?= ($bookingData['infants'] ?? 0) == $i ? 'selected' : '' ?>><?= $i ?> Infant<?= $i > 1 ? 's' : '' ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-muted"><i class="fa-solid fa-info-circle me-1"></i>You can modify your booking dates, rooms, and guest count here</small>
                                </div>
                            </div>
                            
                            <!-- Primary Contact Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4>Your Contact Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="customer_name" placeholder="Enter your full name" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" name="customer_email" placeholder="your@email.com" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                <input type="tel" class="form-control" name="customer_phone" placeholder="+91 98765 43210" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Country <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="customer_country" placeholder="India" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Special Requests -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4>Special Requests (Optional)</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Any special requests?</label>
                                        <textarea class="form-control" name="special_requests" rows="3" placeholder="Early check-in, airport pickup, dietary requirements, etc."></textarea>
                                        <small class="form-text text-muted">We'll do our best to accommodate your requests</small>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-12">
                            <div class="side-block card rounded-2 p-3">
                                <h5 class="fw-semibold fs-6">Reservation Summary</h5>
                                <div class="mid-block rounded-2 border br-dashed p-2 mb-3">
                                    <div class="row align-items-center justify-content-between g-2 mb-4">
                                        <div class="col-6">
                                            <div class="gray rounded-2 p-2">
                                                <span class="d-block text-muted-3 text-sm fw-medium text-uppercase mb-2">Check-In</span>
                                                <p class="text-dark fw-semibold lh-base text-md mb-0"><?= $checkIn->format('d M Y') ?></p>
                                                <span class="text-dark text-md">From <?= $hotel['check_in_time'] ?? '2:00 PM' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="gray rounded-2 p-2">
                                                <span class="d-block text-muted-3 text-sm fw-medium text-uppercase mb-2">Check-Out</span>
                                                <p class="text-dark fw-semibold lh-base text-md mb-0"><?= $checkOut->format('d M Y') ?></p>
                                                <span class="text-dark text-md">By <?= $hotel['check_out_time'] ?? '11:00 AM' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center justify-content-between mb-4">
                                        <div class="col-12">
                                            <p class="text-muted-2 text-sm text-uppercase fw-medium mb-1">Total Length of Stay:</p>
                                            <div class="d-flex align-items-center">
                                                <div class="square--30 circle text-seegreen bg-light-seegreen"><i class="fa-regular fa-calendar"></i></div>
                                                <span class="text-dark fw-semibold ms-2"><?= $nights ?> Day<?= $nights > 1 ? 's' : '' ?> \ <?= $nights ?> Night<?= $nights > 1 ? 's' : '' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-12">
                                            <p class="text-muted-2 text-sm text-uppercase fw-medium mb-1">You Selected</p>
                                            <div class="d-flex align-items-center flex-column">
                                                <p class="mb-0"><?= esc($hotel['name']) ?> with <?= $rooms ?> Room<?= $rooms > 1 ? 's' : '' ?> for <?= $adults + $children ?> Guest<?= ($adults + $children) > 1 ? 's' : '' ?>.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bott-block d-block mb-3">
                                    <h5 class="fw-semibold fs-6">Your Price Summary</h5>
                                    <ul class="list-group list-group-borderless">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-medium mb-0">Price per Night</span>
                                            <span class="fw-semibold">₹<?= number_format($pricePerNight, 2) ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-medium mb-0">Rooms & Stay (<?= $nights ?> nights × <?= $rooms ?> room<?= $rooms > 1 ? 's' : '' ?>)</span>
                                            <span class="fw-semibold">₹<?= number_format($basePrice, 2) ?></span>
                                        </li>
                                        <?php if ($discountInfo['has_discount']): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-medium mb-0">
                                                Hotel Discount
                                                <span class="badge rounded-1 text-bg-danger smaller mb-0 ms-2">
                                                    <?php if ($discountInfo['discount_type'] === 'percentage'): ?>
                                                        <?= number_format($discountInfo['discount_percentage'], 0) ?>% off
                                                    <?php else: ?>
                                                        ₹<?= number_format($hotel['discount_value'], 0) ?> off per night
                                                    <?php endif; ?>
                                                </span>
                                            </span>
                                            <span class="fw-semibold text-success">-₹<?= number_format($discount, 2) ?></span>
                                        </li>
                                        <?php endif; ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-medium mb-0">8% Taxes & Fees</span>
                                            <span class="fw-semibold">₹<?= number_format($taxes, 2) ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-top pt-3">
                                            <span class="fw-bold text-success mb-0 fs-5">Total Price</span>
                                            <span class="fw-bold text-success fs-5">₹<?= number_format($totalPrice, 2) ?></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="bott-block">
                                    <button type="submit" class="btn fw-medium btn-primary full-width">Continue to Payment</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="text-center d-flex align-items-center justify-content-center mt-4">
                    <a href="<?= base_url('/booking') ?>" class="btn btn-md btn-dark fw-semibold mx-2"><i class="fa-solid fa-arrow-left me-2"></i>Previous</a>
                    <button type="submit" form="guestDetailsForm" class="btn btn-md btn-primary fw-semibold mx-2">Continue to Payment<i class="fa-solid fa-arrow-right ms-2"></i></button>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ============================ Booking Page End ================================== -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkInInput = document.querySelector('input[name="check_in_date"]');
    const checkOutInput = document.querySelector('input[name="check_out_date"]');
    
    // Update check-out min date when check-in changes
    if (checkInInput && checkOutInput) {
        checkInInput.addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            const minCheckOut = new Date(checkInDate);
            minCheckOut.setDate(minCheckOut.getDate() + 1);
            
            const minCheckOutStr = minCheckOut.toISOString().split('T')[0];
            checkOutInput.setAttribute('min', minCheckOutStr);
            
            // If current check-out is before new min, update it
            if (checkOutInput.value && new Date(checkOutInput.value) <= checkInDate) {
                checkOutInput.value = minCheckOutStr;
            }
        });
        
        // Validate dates on form submit
        const form = document.getElementById('guestDetailsForm');
        form.addEventListener('submit', function(e) {
            if (checkInInput.value && checkOutInput.value) {
                const checkIn = new Date(checkInInput.value);
                const checkOut = new Date(checkOutInput.value);
                
                if (checkOut <= checkIn) {
                    e.preventDefault();
                    alert('Check-out date must be after check-in date.');
                    return false;
                }
            }
        });
    }
});
</script>

<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>