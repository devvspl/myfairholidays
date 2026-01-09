<?php include APPPATH . 'Views/layouts/public_header.php'; ?>

<!-- Hero Banner Start -->
<div class="py-5 bg-primary position-relative"
    style="background-image: url('main/images/thailand-bg.jpg'); background-size: cover; background-position: center;">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-navy opacity-50"></div>
    <div class="container position-relative z-index-1">
        <div class="row justify-content-center mb-4">
            <div class="col-xl-8 col-lg-10 col-md-12 text-center">
                <h1 class="text-light mb-2"><?= esc($destinationType['name']) ?> Tour Packages</h1>
                <?php if (!empty($destinationType['description'])): ?>
                    <p class="text-light opacity-75 fs-5"><?= esc($destinationType['description']) ?></p>
                <?php else: ?>
                    <p class="text-light opacity-75 fs-5">Explore amazing <?= esc($destinationType['name']) ?> destinations with our carefully curated tour packages.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-12 col-md-12">
                <div class="search-wrap bg-white rounded-4 shadow-lg p-3">
                    <form>
                        <div class="row g-3 align-items-center">
                            <div class="col-xl-4 col-lg-4 col-md-12 border-end-md">
                                <div class="form-group mb-0">
                                    <label class="small fw-bold text-navy text-uppercase mb-1">
                                        <i class="fas fa-map-marker-alt text-warning me-2"></i>Package
                                    </label>
                                    <div class="input-box">
                                        <select class="form-control border-0 fw-medium p-0 ps-1 select2" style="box-shadow:none; appearance: none;">
                                            <option value="">Select Packages</option>
                                            <?php if (!empty($destinations)): ?>
                                                <?php foreach ($destinations as $dest): ?>
                                                    <option value="<?= $dest['slug'] ?>"><?= esc($dest['name']) ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 border-end-md">
                                <div class="form-group mb-0">
                                    <label class="small fw-bold text-navy text-uppercase mb-1">
                                        <i class="fas fa-calendar-alt text-warning me-2"></i>Departure Month
                                    </label>
                                    <div class="input-box">
                                        <input class="form-control border-0 fw-medium p-0 ps-1 choosedate"
                                               style="box-shadow:none;" type="text" placeholder="Select Month" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6">
                                <div class="form-group mb-0">
                                    <label class="small fw-bold text-navy text-uppercase mb-1">
                                        <i class="fas fa-users text-warning me-2"></i>Travelers
                                    </label>
                                    <div class="input-box">
                                        <select class="form-control border-0 fw-medium p-0 ps-1" style="box-shadow:none;">
                                            <option>2 Adults</option>
                                            <option>Family (2+1)</option>
                                            <option>Family (2+2)</option>
                                            <option>Group (6+)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-12">
                                <button type="button" class="btn btn-md btn-primary full-width fw-medium px-lg-4">
                                    <i class="fa-solid fa-magnifying-glass me-2"></i>SEE DEALS
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero Banner End -->

<!-- Destination Lists Start -->
<section class="gray-simple">
    <div class="container">
        <div class="row justify-content-between gy-4 gx-xl-4 gx-lg-3 gx-md-3 gx-4">
            <!-- Sidebar -->
            <div class="col-xl-3 col-lg-4 col-md-12">
                <div class="filter-searchBar bg-white">
                    <div class="filter-searchBar-head border-bottom">
                        <div class="searchBar-headerBody d-flex align-items-start justify-content-between px-3 py-3">
                            <div class="searchBar-headerfirst">
                                <h6 class="fw-bold fs-5 m-0">Filters</h6>
                                <p class="text-md text-muted m-0"><?= esc($destinationType['name']) ?></p>
                            </div>
                            <div class="searchBar-headerlast text-end">
                                <a href="#" class="text-md fw-medium text-primary active">Clear All</a>
                            </div>
                        </div>
                    </div>
                    <div class="filter-searchBar-body">
                        <!-- Tour Type -->
                        <div class="searchBar-single px-3 py-3 border-bottom">
                            <div class="searchBar-single-title d-flex mb-3">
                                <h6 class="sidebar-subTitle fs-6 fw-medium m-0">Tour Type</h6>
                            </div>
                            <div class="searchBar-single-wrap">
                                <ul class="row align-items-center justify-content-between p-0 gx-3 gy-2 mb-0">
                                    <li class="col-6">
                                        <input type="checkbox" class="btn-check" id="couple">
                                        <label class="btn btn-sm btn-secondary rounded-1 fw-medium full-width" for="couple">Couple / Honeymoon</label>
                                    </li>
                                    <li class="col-6">
                                        <input type="checkbox" class="btn-check" id="family">
                                        <label class="btn btn-sm btn-secondary rounded-1 fw-medium full-width" for="family">Family Tour</label>
                                    </li>
                                    <li class="col-6">
                                        <input type="checkbox" class="btn-check" id="group">
                                        <label class="btn btn-sm btn-secondary rounded-1 fw-medium full-width" for="group">Group Tour</label>
                                    </li>
                                    <li class="col-6">
                                        <input type="checkbox" class="btn-check" id="friends">
                                        <label class="btn btn-sm btn-secondary rounded-1 fw-medium full-width" for="friends">Friends Trip</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Popular Filters -->
                        <div class="searchBar-single px-3 py-3 border-bottom">
                            <div class="searchBar-single-title d-flex mb-3">
                                <h6 class="sidebar-subTitle fs-6 fw-medium m-0">Popular Filters</h6>
                            </div>
                            <div class="searchBar-single-wrap">
                                <ul class="row align-items-center justify-content-between p-0 gx-3 gy-2 mb-0">
                                    <li class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="popular">
                                            <label class="form-check-label" for="popular">Popular Destinations</label>
                                        </div>
                                    </li>
                                    <li class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="meals">
                                            <label class="form-check-label" for="meals">Indian Meals Available</label>
                                        </div>
                                    </li>
                                    <li class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="transfers">
                                            <label class="form-check-label" for="transfers">Private Transfers Available</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- All List -->
            <div class="col-xl-9 col-lg-8 col-md-12">
                <div class="row align-items-center justify-content-between">
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <h5 class="fw-bold fs-6 mb-lg-0 mb-3">Showing <?= count($destinations) ?> Search Results</h5>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-12">
                        <div class="d-flex align-items-center justify-content-start justify-content-lg-end flex-wrap">
                            <div class="flsx-first mt-sm-0 mt-2">
                                <ul class="nav nav-pills nav-fill p-1 small lights blukker bg-primary rounded-2 shadow-sm" id="filtersblocks" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link rounded-1" id="mostpopular" data-bs-toggle="tab" type="button" role="tab" aria-selected="false">Most Popular</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link rounded-1" id="lowprice" data-bs-toggle="tab" type="button" role="tab" aria-selected="false">Lowest Price</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row align-items-center g-4 mt-2">
                    <?php if (!empty($destinations)): ?>
                        <?php foreach ($destinations as $destination): ?>
                            <!-- Single List -->
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card list-layout-block p-3">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-3 col-md">
                                            <div class="cardImage__caps rounded-2 overflow-hidden h-100">
                                                <?php if (!empty($destination['image'])): ?>
                                                    <img class="img-fluid h-100 object-fit" src="<?= base_url($destination['image']) ?>" alt="<?= esc($destination['name']) ?>">
                                                <?php else: ?>
                                                    <img class="img-fluid h-100 object-fit" src="main/images/placeholder.jpg" alt="<?= esc($destination['name']) ?>">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-xl col-lg col-md">
                                            <div class="listLayout_midCaps mt-md-0 mt-3 mb-md-0 mb-3">
                                                <div class="d-flex align-items-center justify-content-start mb-1">
                                                    <?php if (!empty($destination['is_popular'])): ?>
                                                        <span class="label bg-light-success text-success">Popular</span>
                                                    <?php endif; ?>
                                                </div>
                                                <h4 class="fs-5 fw-bold mb-1"><?= esc($destination['name']) ?></h4>
                                                <ul class="row gx-2 p-0 excortio">
                                                    <li class="col-auto">
                                                        <p class="text-muted-2 text-md"><?= esc($destinationType['name']) ?></p>
                                                    </li>
                                                </ul>
                                                <div class="detail ellipsis-container mt-3">
                                                    <p class="text-muted"><?= esc(substr(strip_tags($destination['description'] ?? ''), 0, 150)) ?>...</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-auto col-lg-auto col-md-auto text-right text-md-left d-flex align-items-start align-items-md-end flex-column">
                                            <div class="row align-items-center justify-content-start justify-content-md-end gx-2 mb-3">
                                                <div class="col-auto text-start text-md-end">
                                                    <div class="text-md text-dark fw-medium">Excellent</div>
                                                    <div class="text-md text-muted-2">Reviews</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="square--40 rounded-2 bg-warning text-light">4.8</div>
                                                </div>
                                            </div>
                                            <div class="position-relative mt-auto full-width">
                                                <div class="d-flex align-items-start align-items-md-end text-start text-md-end flex-column">
                                                    <a href="<?= base_url('/destinations/' . $destination['slug']) ?>" class="btn btn-md btn-primary full-width fw-medium px-lg-4">
                                                        View Details<i class="fa-solid fa-arrow-trend-up ms-2"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Single List -->
                        <?php endforeach; ?>
                        
                        <!-- Pagination -->
                        <?php if ($pager): ?>
                            <div class="col-xl-12 col-lg-12 col-12">
                                <div class="pags py-2 px-5">
                                    <?= $pager->links() ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                <h3 class="text-muted">No destinations found</h3>
                                <p class="text-muted">No destinations available for <?= esc($destinationType['name']) ?> at the moment.</p>
                                <a href="<?= base_url('/destinations') ?>" class="btn btn-primary">
                                    View All Destinations
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Destination Lists End -->

<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>