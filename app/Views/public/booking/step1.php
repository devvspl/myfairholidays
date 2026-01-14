<?php include APPPATH . 'Views/layouts/public_header.php'; ?>

<!-- ============================ Booking Page Step 1 ================================== -->
<section class="pt-4 gray-simple position-relative">
    <div class="container">

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div id="stepper" class="bs-stepper stepper-outline mb-5">
                    <div class="bs-stepper-header">
                        <!-- Step 1 -->
                        <div class="step active" data-target="#step-1">
                            <div class="text-center">
                                <button type="button" class="step-trigger mb-0" id="steppertrigger1">
                                    <span class="bs-stepper-circle">1</span>
                                </button>
                                <h6 class="bs-stepper-label d-none d-md-block">Tour Review</h6>
                            </div>
                        </div>
                        <div class="line"></div>

                        <!-- Step 2 -->
                        <div class="step" data-target="#step-2">
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
                <div class="row align-items-start">
                    <div class="col-xl-8 col-lg-8 col-md-12">
                        <div class="card p-3 mb-xl-0 mb-lg-0 mb-3">

                            <!-- Booking Info -->
                            <div class="card-box list-layout-block border br-dashed rounded-3 p-2">
                                <div class="row">

                                    <div class="col-xl-4 col-lg-3 col-md">
                                        <div class="cardImage__caps rounded-2 overflow-hidden h-100">
                                            <?php if (!empty($images) && count($images) > 0): ?>
                                            <img class="img-fluid h-100 object-fit" src="<?= base_url($images[0]['image_path']) ?>" alt="<?= esc($hotel['name']) ?>">
                                            <?php elseif (!empty($hotel['featured_image'])): ?>
                                            <img class="img-fluid h-100 object-fit" src="<?= base_url($hotel['featured_image']) ?>" alt="<?= esc($hotel['name']) ?>">
                                            <?php else: ?>
                                            <img class="img-fluid h-100 object-fit" src="https://placehold.co/1100x700/e9ecef/6c757d?text=<?= urlencode($hotel['name']) ?>" alt="<?= esc($hotel['name']) ?>">
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-xl col-lg col-md">
                                        <div class="listLayout_midCaps mt-md-0 mt-3 mb-md-0 mb-3">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="d-inline-block">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fa fa-star <?= $i <= ($hotel['star_rating'] ?? 0) ? 'text-warning' : 'text-muted' ?> text-xs"></i>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                            <h4 class="fs-5 fw-bold mb-1"><?= esc($hotel['name']) ?></h4>
                                            <ul class="row g-2 p-0">
                                                <?php if (!empty($hotel['address'])): ?>
                                                <li class="col-auto">
                                                    <p class="text-muted-2 text-md"><?= esc($hotel['address']) ?></p>
                                                </li>
                                                <?php endif; ?>
                                                <?php if (!empty($hotel['destination_name'])): ?>
                                                <li class="col-auto">
                                                    <p class="text-muted-2 text-md fw-bold">.</p>
                                                </li>
                                                <li class="col-auto">
                                                    <p class="text-muted-2 text-md"><?= esc($hotel['destination_name']) ?></p>
                                                </li>
                                                <?php endif; ?>
                                            </ul>
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="col-auto">
                                                    <div class="square--40 rounded-2 bg-primary text-light fw-semibold">4.<?= $hotel['star_rating'] ?? 0 ?></div>
                                                </div>
                                                <div class="col-auto text-start ps-2">
                                                    <div class="text-md text-dark fw-medium">Excellent</div>
                                                    <div class="text-md text-muted-2"><?= $hotel['star_rating'] ?? 0 ?> Star Hotel</div>
                                                </div>
                                            </div>
                                            <div class="position-relative mt-3">
                                                <div class="d-flex flex-wrap align-items-center">
                                                    <div class="d-inline-flex align-items-center border br-dashed rounded-2 p-2 me-2 mb-2">
                                                        <div class="export-icon text-muted-2"><i class="fa-solid fa-bed"></i></div>
                                                        <div class="export ps-2">
                                                            <span class="mb-0 text-muted-2 fw-semibold me-1"><?= $rooms ?></span><span
                                                                class="mb-0 text-muted-2 text-md">Room<?= $rooms > 1 ? 's' : '' ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="d-inline-flex align-items-center border br-dashed rounded-2 p-2 me-2 mb-2">
                                                        <div class="export-icon text-muted-2"><i class="fa-solid fa-user-group"></i></div>
                                                        <div class="export ps-2 text-muted-2">
                                                            <span class="mb-0 text-muted-2 fw-semibold me-1"><?= $adults + $children ?></span><span
                                                                class="mb-0 text-muted-2 text-md">Guests</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-inline-flex align-items-center border br-dashed rounded-2 p-2 me-2 mb-2">
                                                        <div class="export-icon text-muted-2"><i class="fa-solid fa-calendar-days"></i></div>
                                                        <div class="export ps-2">
                                                            <span class="mb-0 text-muted-2 fw-semibold me-1"><?= $nights ?></span><span
                                                                class="mb-0 text-muted-2 text-md">Night<?= $nights > 1 ? 's' : '' ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Details -->
                            <div class="flight-boxyhc mt-4">
                                <h4 class="fs-5">Booking Details</h4>
                                <div class="flights-accordion">
                                    <div class="flights-list-item bg-white border rounded-3 p-3">
                                        <div class="row gy-4 align-items-center justify-content-between">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <span class="label bg-light-primary text-primary me-2">Check-in</span>
                                                            <span class="text-muted text-sm"><?= $checkIn->format('d M Y') ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                                        <div class="row gx-lg-5 gx-3 gy-4 align-items-center">
                                                            <div class="col-sm-auto">
                                                                <div class="d-flex align-items-center justify-content-start">
                                                                    <div class="d-start fl-pic">
                                                                        <i class="fa-solid fa-hotel text-primary fs-2"></i>
                                                                    </div>
                                                                    <div class="d-end fl-title ps-2">
                                                                        <div class="text-dark fw-medium"><?= esc($hotel['name']) ?></div>
                                                                        <div class="text-sm text-muted"><?= $hotel['star_rating'] ?? 0 ?> Star Hotel</div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col">
                                                                <div class="row gx-3 align-items-center">
                                                                    <div class="col-auto">
                                                                        <div class="text-dark fw-bold"><?= $checkIn->format('d M') ?></div>
                                                                        <div class="text-muted text-sm fw-medium">Check-in</div>
                                                                    </div>

                                                                    <div class="col text-center">
                                                                        <div class="flightLine departure">
                                                                            <div></div>
                                                                            <div></div>
                                                                        </div>
                                                                        <div class="text-muted text-sm fw-medium mt-3"><?= $nights ?> Night<?= $nights > 1 ? 's' : '' ?></div>
                                                                    </div>

                                                                    <div class="col-auto">
                                                                        <div class="text-dark fw-bold"><?= $checkOut->format('d M') ?></div>
                                                                        <div class="text-muted text-sm fw-medium">Check-out</div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-auto">
                                                                <div class="text-dark fw-medium"><?= $rooms ?> Room<?= $rooms > 1 ? 's' : '' ?></div>
                                                                <div class="text-muted text-sm fw-medium"><?= $adults + $children ?> Guest<?= ($adults + $children) > 1 ? 's' : '' ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Good to Know -->
                            <div class="flight-boxyhc mt-4">
                                <h4 class="fs-5">Good To Know</h4>
                                <div class="effloration-wrap">
                                    <p>All Prices are in Indian Rupees and are subject to change without prior notice. Please review the hotel's cancellation policy before confirming your booking.</p>
                                    <ul class="row align-items-center g-1 mb-0 p-0">
                                        <?php if (!empty($hotel['cancellation_policy'])): ?>
                                        <li class="col-12"><span class="text-success text-md"><i class="fa-solid fa-circle-dot me-2"></i>Free Cancellation as per hotel policy</span></li>
                                        <?php endif; ?>
                                        <li class="col-12"><span class="text-muted-2 text-md"><i class="fa-solid fa-circle-dot me-2"></i>Check-in: <?= $hotel['check_in_time'] ?? '2:00 PM' ?></span></li>
                                        <li class="col-12"><span class="text-muted-2 text-md"><i class="fa-solid fa-circle-dot me-2"></i>Check-out: <?= $hotel['check_out_time'] ?? '11:00 AM' ?></span></li>
                                        <li class="col-12"><span class="text-success text-md"><i class="fa-solid fa-circle-dot me-2"></i>Best Price Guaranteed</span></li>
                                        <li class="col-12"><span class="text-muted-2 text-md"><i class="fa-solid fa-circle-dot me-2"></i>All taxes included in the price</span></li>
                                        <?php if (!empty($hotel['amenities'])): ?>
                                        <li class="col-12"><span class="text-success text-md"><i class="fa-solid fa-circle-dot me-2"></i>Hotel amenities included</span></li>
                                        <?php endif; ?>
                                    </ul>
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
                                <a href="<?= base_url('/booking/step2') ?>" class="btn fw-medium btn-primary full-width">Continue to Guest Details</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="text-center d-flex align-items-center justify-content-center mt-4">
                    <a href="<?= base_url('/booking/step2') ?>" class="btn btn-md btn-primary fw-semibold">Next<i class="fa-solid fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ============================ Booking Page End ================================== -->

<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>