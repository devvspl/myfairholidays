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
                <div class="div-title d-flex align-items-center mb-3">
                    <h4>Billing Details</h4>
                </div>
                
                <form action="<?= base_url('/booking/payment') ?>" method="post" id="paymentForm">
                    <?= csrf_field() ?>
                    
                    <div class="row align-items-start">
                        <div class="col-xl-8 col-lg-8 col-md-12">

                            <div class="card mb-3">
                                <div class="card-header">
                                    <h4>Basic Detail</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Billing Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="billing_name" placeholder="Full Name" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" name="billing_email" placeholder="Email Address" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                                <input type="tel" class="form-control" name="billing_phone" placeholder="Phone Number" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Address 01 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="billing_address1" placeholder="Street Address" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Address 02</label>
                                                <input type="text" class="form-control" name="billing_address2" placeholder="Apartment, suite, etc. (Optional)">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Country <span class="text-danger">*</span></label>
    