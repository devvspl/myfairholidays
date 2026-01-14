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
                <div class="div-title d-flex align-items-center mb-3">
                    <h4>Guests Detail</h4>
                </div>
                
                <form action="<?= base_url('/booking/step2') ?>" method="post" id="guestDetailsForm">
                    <?= csrf_field() ?>
                    
                    <div class="row align-items-start">
                        <div class="col-xl-8 col-lg-8 col-md-12">
                            
                            <?php 
                            $totalGuests = $adults + $children;
                            for ($i = 1; $i <= $totalGuests; $i++): 
                                $isChild = $i > $adults;
                            ?>
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4>Guest <?= $i ?> <?= $isChild ? '(Child)' : '(Adult)' ?></h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="guests[<?= $i ?>][first_name]" placeholder="First Name" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="guests[<?= $i ?>][last_name]" placeholder="Last Name" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" name="guests[<?= $i ?>][date_of_birth]" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Passport Number</label>
                                                <input type="text" class="form-control" name="guests[<?= $i ?>][passport_number]" placeholder="Passport Number (Optional)">
                                            </div>
                                        </div>
                                        <?php if ($i === 1): // Primary guest additional fields ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" name="guests[<?= $i ?>][email]" placeholder="Email Address" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                <input type="tel" class="form-control" name="guests[<?= $i ?>][phone]" placeholder="Phone Number" required>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endfor; ?>

                            <!-- Special Requests -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4>Special Requests</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Any special requests or requirements?</label>
                                        <textarea class="form-control" name="special_requests" rows="4" placeholder="Please let us know if you have any special requests, dietary requirements, accessibility needs, or preferences for your stay..."></textarea>
                                        <small class="form-text text-muted">Special requests are subject to availability and may incur additional charges.</small>
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
                                            <span class="fw-medium mb-0">Rooms & Stay (<?= $nights ?> nights)</span>
                                            <span class="fw-semibold">₹<?= number_format($basePrice, 2) ?></span>
                                        </li>
                                        <?php if ($discount > 0): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-medium mb-0">Total Discount<span class="badge rounded-1 text-bg-danger smaller mb-0 ms-2">15% off</span></span>
                                            <span class="fw-semibold">-₹<?= number_format($discount, 2) ?></span>
                                        </li>
                                        <?php endif; ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-medium mb-0">8% Taxes & Fees</span>
                                            <span class="fw-semibold">₹<?= number_format($taxes, 2) ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-medium text-success mb-0">Total Price</span>
                                            <span class="fw-semibold text-success">₹<?= number_format($totalPrice, 2) ?></span>
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
    // Form validation
    const form = document.getElementById('guestDetailsForm');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('input[required]');
        
        requiredFields.forEach(function(field) {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
    
    // Remove invalid class on input
    const inputs = form.querySelectorAll('input');
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
    });
});
</script>

<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>