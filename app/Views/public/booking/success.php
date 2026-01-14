<?php include APPPATH . 'Views/layouts/public_header.php'; ?>

<!-- ============================ Booking Success Page ================================== -->
<section class="py-5 gray-simple position-relative">
    <div class="container">

        <div class="row align-items-start">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card mb-3">
                    <div class="car-body px-xl-5 px-lg-4 py-lg-5 py-4 px-2">

                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="square--80 circle text-light bg-success"><i class="fa-solid fa-check-double fs-1"></i></div>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-center flex-column text-center mb-5">
                            <h3 class="mb-0">Your order was confirmed successfully!</h3>
                            <p class="text-md mb-0">Booking detail sent to: <span class="text-primary"><?= esc($bookingComplete['payment_data']['customer_email']) ?></span></p>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-center flex-column mb-4">
                            <div class="border br-dashed full-width rounded-2 p-3 pt-0">
                                <ul class="row align-items-center justify-content-start g-3 m-0 p-0">
                                    <li class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="d-block">
                                            <p class="text-dark fw-medium lh-2 mb-0">Booking Reference</p>
                                            <p class="text-muted mb-0 lh-2"><?= esc($bookingComplete['booking_reference']) ?></p>
                                        </div>
                                    </li>
                                    <li class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="d-block">
                                            <p class="text-dark fw-medium lh-2 mb-0">Check-in Date</p>
                                            <p class="text-muted mb-0 lh-2"><?= date('d M Y', strtotime($bookingComplete['booking_data']['check_in_date'])) ?></p>
                                        </div>
                                    </li>
                                    <li class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="d-block">
                                            <p class="text-dark fw-medium lh-2 mb-0">Total Amount</p>
                                            <p class="text-muted mb-0 lh-2">₹<?= number_format($bookingComplete['pricing']['total_amount'], 2) ?></p>
                                        </div>
                                    </li>
                                    <li class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="d-block">
                                            <p class="text-dark fw-medium lh-2 mb-0">Payment Mode</p>
                                            <p class="text-muted mb-0 lh-2"><?= ucfirst(str_replace('_', ' ', $bookingComplete['payment_data']['payment_method'])) ?></p>
                                        </div>
                                    </li>
                                    <li class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="d-block">
                                            <p class="text-dark fw-medium lh-2 mb-0">Customer Name</p>
                                            <p class="text-muted mb-0 lh-2"><?= esc($bookingComplete['billing_data']['name']) ?></p>
                                        </div>
                                    </li>
                                    <li class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="d-block">
                                            <p class="text-dark fw-medium lh-2 mb-0">Phone</p>
                                            <p class="text-muted mb-0 lh-2"><?= esc($bookingComplete['billing_data']['phone']) ?></p>
                                        </div>
                                    </li>
                                    <li class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="d-block">
                                            <p class="text-dark fw-medium lh-2 mb-0">Email</p>
                                            <p class="text-muted mb-0 lh-2"><?= esc($bookingComplete['billing_data']['email']) ?></p>
                                        </div>
                                    </li>
                                    <li class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="d-block">
                                            <p class="text-dark fw-medium lh-2 mb-0">Hotel Name</p>
                                            <p class="text-muted mb-0 lh-2"><?= esc($bookingComplete['hotel']['name']) ?></p>
                                        </div>
                                    </li>
                                    <li class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="d-block">
                                            <p class="text-dark fw-medium lh-2 mb-0">Nights</p>
                                            <p class="text-muted mb-0 lh-2"><?= $bookingComplete['booking_data']['nights'] ?> Night<?= $bookingComplete['booking_data']['nights'] > 1 ? 's' : '' ?></p>
                                        </div>
                                    </li>
                                    <li class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="d-block">
                                            <p class="text-dark fw-medium lh-2 mb-0">Rooms</p>
                                            <p class="text-muted mb-0 lh-2"><?= $bookingComplete['booking_data']['rooms'] ?> Room<?= $bookingComplete['booking_data']['rooms'] > 1 ? 's' : '' ?></p>
                                        </div>
                                    </li>
                                    <li class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="d-block">
                                            <p class="text-dark fw-medium lh-2 mb-0">Guests</p>
                                            <p class="text-muted mb-0 lh-2"><?= $bookingComplete['booking_data']['adults'] ?> Adult<?= $bookingComplete['booking_data']['adults'] > 1 ? 's' : '' ?><?= $bookingComplete['booking_data']['children'] > 0 ? ', ' . $bookingComplete['booking_data']['children'] . ' Child' : '' ?></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="text-center d-flex align-items-center justify-content-center">
                            <a href="<?= base_url('/hotels') ?>" class="btn btn-md btn-light-seegreen fw-semibold mx-2">Book Next Tour</a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#invoice" class="btn btn-md btn-light-primary fw-semibold mx-2">View Invoice</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
<!-- ============================ Booking Success Page End ================================== -->

<!-- Print Invoice Modal -->
<div class="modal modal-lg fade" id="invoice" tabindex="-1" role="dialog" aria-labelledby="invoicemodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered invoice-pop-form" role="document">
        <div class="modal-content" id="invoicemodal">
            <div class="modal-header">
                <h4 class="modal-title fs-6">Download your invoice</h4>
                <a href="#" class="text-muted fs-4" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-square-xmark"></i></a>
            </div>
            <div class="modal-body">
                <div class="invoiceblock-wrap p-3">
                    <!-- Header -->
                    <div class="invoice-header d-flex align-items-center justify-content-between mb-4">
                        <div class="inv-fliop01 d-flex align-items-center justify-content-start">
                            <div class="inv-fliop01">
                                <div class="square--60 circle bg-light-primary text-primary"><i class="fa-solid fa-file-invoice fs-2"></i></div>
                            </div>
                            <div class="inv-fliop01 ps-3">
                                <span class="text-uppercase d-block fw-semibold text-md text-dark lh-2 mb-0">Invoice <?= esc($bookingComplete['booking_reference']) ?></span>
                                <span class="text-sm text-muted lh-2"><i class="fa-regular fa-calendar me-1"></i>Issued Date <?= date('d M Y') ?></span>
                            </div>
                        </div>
                        <div class="inv-fliop02">
                            <span class="label text-<?= $bookingComplete['payment_data']['status'] === 'paid' ? 'success bg-light-success' : 'warning bg-light-warning' ?>">
                                <?= ucfirst($bookingComplete['payment_data']['status']) ?>
                            </span>
                        </div>
                    </div>

                    <!-- Invoice Body -->
                    <div class="invoice-body">

                        <!-- Invoice Top Body -->
                        <div class="invoice-bodytop">
                            <div class="row align-items-start justify-content-between">
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="invoice-desc mb-2">
                                        <h6>From</h6>
                                        <p class="text-md lh-2 mb-0">
                                            <?= esc($bookingComplete['hotel']['name']) ?><br>
                                            <?= esc($bookingComplete['hotel']['address']) ?><br>
                                            <?= $bookingComplete['hotel']['star_rating'] ?> Star Hotel
                                        </p>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-lg-5 col-md-6">
                                    <div class="invoice-desc mb-2">
                                        <h6>To</h6>
                                        <p class="text-md lh-2 mb-0">
                                            <?= esc($bookingComplete['billing_data']['name']) ?><br>
                                            <?= esc($bookingComplete['billing_data']['email']) ?><br>
                                            <?= esc($bookingComplete['billing_data']['phone']) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Invoice Mid Body -->
                        <div class="invoice-bodymid py-2">
                            <ul class="gray rounded-3 p-3 m-0">
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-1">
                                    <span class="fw-medium text-sm text-muted-2 mb-0">Booking Reference:</span>
                                    <span class="fw-semibold text-muted-2 text-md"><?= esc($bookingComplete['booking_reference']) ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-1">
                                    <span class="fw-medium text-sm text-muted-2 mb-0">Payment Reference:</span>
                                    <span class="fw-semibold text-muted-2 text-md"><?= esc($bookingComplete['payment_data']['payment_reference']) ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-1">
                                    <span class="fw-medium text-sm text-muted-2 mb-0">Check-in Date:</span>
                                    <span class="fw-semibold text-muted-2 text-md"><?= date('d M Y', strtotime($bookingComplete['booking_data']['check_in_date'])) ?></span>
                                </li>
                            </ul>
                        </div>

                        <!-- Invoice Bottom Body -->
                        <div class="invoice-bodybott py-2 mb-2">
                            <div class="table-responsive border rounded-2">
                                <table class="table mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">Item</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Qty.</th>
                                            <th scope="col">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row"><?= esc($bookingComplete['hotel']['name']) ?> - <?= $bookingComplete['booking_data']['nights'] ?> Night<?= $bookingComplete['booking_data']['nights'] > 1 ? 's' : '' ?></th>
                                            <td>₹<?= number_format($bookingComplete['pricing']['base_price'] / $bookingComplete['booking_data']['rooms'], 2) ?></td>
                                            <td><?= $bookingComplete['booking_data']['rooms'] ?></td>
                                            <td>₹<?= number_format($bookingComplete['pricing']['base_price'], 2) ?></td>
                                        </tr>
                                        <?php if ($bookingComplete['pricing']['discount'] > 0): ?>
                                        <tr>
                                            <th scope="row">Discount</th>
                                            <td>-</td>
                                            <td>-</td>
                                            <td class="text-success">-₹<?= number_format($bookingComplete['pricing']['discount'], 2) ?></td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <th scope="row">Tax & VAT (8%)</th>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>₹<?= number_format($bookingComplete['pricing']['taxes'], 2) ?></td>
                                        </tr>
                                        <tr class="table-active">
                                            <th scope="row" colspan="3" class="text-end">Total Amount:</th>
                                            <th>₹<?= number_format($bookingComplete['pricing']['total_amount'], 2) ?></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="invoice-bodyaction">
                            <div class="d-flex text-end justify-content-end align-items-center">
                                <button onclick="window.print()" class="btn btn-sm btn-light-success fw-medium me-2">
                                    <i class="fa-solid fa-download me-1"></i>Download Invoice
                                </button>
                                <button onclick="window.print()" class="btn btn-sm btn-light-primary fw-medium me-2">
                                    <i class="fa-solid fa-print me-1"></i>Print Invoice
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>
