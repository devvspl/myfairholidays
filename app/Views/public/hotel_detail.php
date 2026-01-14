<?php include APPPATH . 'Views/layouts/public_header.php'; ?>
<!-- Hero Section -->
<section class="bg-cover position-relative" style="background-image:url('<?= base_url('main/images/contactus.png') ?>');background-size: cover;background-position: center;background-repeat: no-repeat;" data-overlay="5">
   <div class="container">
      <div class="row align-items-center justify-content-center">
         <div class="col-xl-7 col-lg-9 col-md-12">
            <div class="fpc-capstion text-center my-4">
               <div class="fpc-captions">
                  <h1 class="xl-heading text-light"><?= esc($hotel['name']) ?></h1>
                  <p class="text-light">
                     <?php if (!empty($hotel['short_description'])): ?>
                     <?= esc($hotel['short_description']) ?>
                     <?php else: ?>
                     Experience luxury and comfort at this <?= $hotel['star_rating'] ?? 0 ?> star hotel in <?= esc($hotel['destination_name'] ?? 'prime location') ?>
                     <?php endif; ?>
                  </p>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="fpc-banner"></div>
</section>
<!-- Hotel Details Start -->
<section class="pt-3 gray-simple">
   <div class="container">
      <div class="row">
         <!-- Breadcrumb -->
         <div class="col-xl-12 col-lg-12 col-md-12 p-0">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-primary">Home</a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url('/hotels') ?>" class="text-primary">Hotels</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?= esc($hotel['name']) ?></li>
               </ol>
            </nav>
         </div>
         <!-- Gallery & Info -->
         <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card border-0 p-3 mb-4">
               <div class="crd-heaader d-md-flex align-items-center justify-content-between">
                  <div class="crd-heaader-first">
                     <div class="d-inline-flex align-items-center mb-1">
                        <?php if (!empty($hotel['is_featured'])): ?>
                        <span class="label bg-light-success text-success">Featured Hotel</span>
                        <?php else: ?>
                        <span class="label bg-light-success text-success">Health Protected</span>
                        <?php endif; ?>
                        <div class="d-inline-block ms-2">
                           <?php for ($i = 1; $i <= 5; $i++): ?>
                           <i class="fa fa-star <?= $i <= ($hotel['star_rating'] ?? 0) ? 'text-warning' : 'text-muted' ?> text-xs"></i>
                           <?php endfor; ?>
                        </div>
                     </div>
                     <div class="d-block">
                        <h4 class="mb-0"><?= esc($hotel['name']) ?></h4>
                        <div class="">
                           <?php if (!empty($hotel['address'])): ?>
                           <p class="text-md m-0"><i class="fa-solid fa-location-dot me-2"></i><?= esc($hotel['address']) ?>
                              <?php if (!empty($hotel['latitude']) && !empty($hotel['longitude'])): ?>
                              <a href="https://www.google.com/maps?q=<?= $hotel['latitude'] ?>,<?= $hotel['longitude'] ?>" target="_blank" class="text-primary fw-medium ms-2">Show on Map</a>
                              <?php endif; ?>
                           </p>
                           <?php endif; ?>
                        </div>
                     </div>
                  </div>
                  <div class="crd-heaader-last my-md-0 my-2">
                     <div class="drix-wrap d-flex align-items-center">
                        <div class="drix-first pe-2">
                           <div class="text-dark fw-semibold fs-4">₹<?= number_format($hotel['price_per_night'] ?? 0, 0) ?></div>
                           <?php if (!empty($hotel['is_featured'])): ?>
                           <div class="d-flex align-items-center justify-content-start justify-content-md-end">
                              <span class="label bg-offer text-light" style="    padding: 0px 10px;font-weight: 500;border-radius: 4px;font-size: 10px !important;">15% Off</span>
                           </div>
                           <?php endif; ?>
                        </div>
                        <div class="drix-last">
                           <div class="d-flex align-items-center gap-2 flex-wrap">
                              <a href="#" onclick="shareHotel(); return false;" class="btn btn-outline-primary btn-sm fw-medium">
                              <i class="fa-solid fa-share-nodes me-1"></i><span class="d-none d-sm-inline">Share</span>
                              </a>
                              <a href="<?= base_url('/booking?hotel_id=' . $hotel['id']) ?>" class="btn btn-primary btn-sm  fw-medium">
                              <i class="fa-solid fa-calendar-check me-1"></i>Book Now
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="geotrip-gallery mb-lg-0 mt-2">
                  <div class="left-img">
                     <?php if (!empty($images) && count($images) > 0): ?>
                     <a href="<?= base_url($images[0]['image_path']) ?>" data-lightbox="hotel-gallery">
                     <img src="<?= base_url($images[0]['image_path']) ?>" alt="<?= esc($images[0]['alt_text'] ?? $hotel['name']) ?>" class="img-fluid">
                     </a>
                     <?php elseif (!empty($hotel['featured_image'])): ?>
                     <a href="<?= base_url($hotel['featured_image']) ?>" data-lightbox="hotel-gallery">
                     <img src="<?= base_url($hotel['featured_image']) ?>" alt="<?= esc($hotel['name']) ?>" class="img-fluid">
                     </a>
                     <?php else: ?>
                     <img src="https://placehold.co/1100x700/e9ecef/6c757d?text=<?= urlencode($hotel['name']) ?>" alt="<?= esc($hotel['name']) ?>" class="img-fluid">
                     <?php endif; ?>
                  </div>
                  <div class="right-grid position-relative">
                     <?php if (!empty($images) && count($images) > 1): ?>
                     <?php for ($i = 1; $i <= 4 && $i < count($images); $i++): ?>
                     <a href="<?= base_url($images[$i]['image_path']) ?>" data-lightbox="hotel-gallery">
                     <img src="<?= base_url($images[$i]['image_path']) ?>" alt="<?= esc($images[$i]['alt_text'] ?? $hotel['name']) ?>" class="rounded-2 img-fluid">
                     </a>
                     <?php endfor; ?>
                     <?php if (count($images) < 5): ?>
                     <?php for ($j = count($images); $j < 5; $j++): ?>
                     <?php if (!empty($hotel['featured_image'])): ?>
                     <a href="<?= base_url($hotel['featured_image']) ?>" data-lightbox="hotel-gallery">
                     <img src="<?= base_url($hotel['featured_image']) ?>" alt="<?= esc($hotel['name']) ?>" class="rounded-2 img-fluid">
                     </a>
                     <?php else: ?>
                     <img src="https://placehold.co/1100x700/e9ecef/6c757d?text=<?= urlencode($hotel['name']) ?>" alt="<?= esc($hotel['name']) ?>" class="rounded-2 img-fluid">
                     <?php endif; ?>
                     <?php endfor; ?>
                     <?php endif; ?>
                     <?php else: ?>
                     <?php for ($i = 0; $i < 4; $i++): ?>
                     <?php if (!empty($hotel['featured_image'])): ?>
                     <a href="<?= base_url($hotel['featured_image']) ?>" data-lightbox="hotel-gallery">
                     <img src="<?= base_url($hotel['featured_image']) ?>" alt="<?= esc($hotel['name']) ?>" class="rounded-2 img-fluid">
                     </a>
                     <?php else: ?>
                     <img src="https://placehold.co/1100x700/e9ecef/6c757d?text=<?= urlencode($hotel['name']) ?>" alt="<?= esc($hotel['name']) ?>" class="rounded-2 img-fluid">
                     <?php endif; ?>
                     <?php endfor; ?>
                     <?php endif; ?>
                     <div class="position-absolute end-0 bottom-0 mb-3 me-3">
                        <?php if (!empty($images) && count($images) > 5): ?>
                        <a href="#" onclick="openGallery(); return false;" class="btn btn-md btn-whites fw-medium text-dark">
                        <i class="fa-solid fa-caret-right me-1"></i>+<?= count($images) - 5 ?> More Photos
                        </a>
                        <?php else: ?>
                        <a href="<?= !empty($images) ? base_url($images[0]['image_path']) : (!empty($hotel['featured_image']) ? base_url($hotel['featured_image']) : 'https://placehold.co/1200x800') ?>" data-lightbox="hotel-gallery" class="btn btn-md btn-whites fw-medium text-dark">
                        <i class="fa-solid fa-caret-right me-1"></i>View Gallery
                        </a>
                        <?php endif; ?>
                     </div>
                  </div>
               </div>
               <!-- Hidden images for lightbox -->
               <?php if (!empty($images) && count($images) > 5): ?>
               <div style="display: none;">
                  <?php for ($i = 5; $i < count($images); $i++): ?>
                  <a href="<?= base_url($images[$i]['image_path']) ?>" data-lightbox="hotel-gallery" data-title="<?= esc($images[$i]['caption'] ?? $hotel['name']) ?>"></a>
                  <?php endfor; ?>
               </div>
               <?php endif; ?>
            </div>
         </div>
         <section class="pt-0 gray-simple p-0">
            <div class="container p-0">
               <div class="row">
                  <!-- Top Attractions -->
                  <?php
                     // Prepare data for all three sections
                     $displayAttractions = [];
                     if (!empty($hotel['nearby_attractions'])) {
                        $attractionsText = strip_tags($hotel['nearby_attractions']);
                        $attractions = array_filter(array_map('trim', explode("\n", $attractionsText)));
                        // Also check for comma-separated items
                        if (count($attractions) === 1 && strpos($attractions[0], ',') !== false) {
                           $attractions = array_filter(array_map('trim', explode(',', $attractions[0])));
                        }
                        $displayAttractions = array_slice($attractions, 0, 10);
                     }
                     
                     $displayTransport = [];
                     if (!empty($hotel['transportation_info'])) {
                        $transportText = strip_tags($hotel['transportation_info']);
                        $transportInfo = array_filter(array_map('trim', explode("\n", $transportText)));
                        // Also check for comma-separated items
                        if (count($transportInfo) === 1 && strpos($transportInfo[0], ',') !== false) {
                           $transportInfo = array_filter(array_map('trim', explode(',', $transportInfo[0])));
                        }
                        $displayTransport = array_slice($transportInfo, 0, 10);
                     }
                     
                     $displayDining = [];
                     if (!empty($hotel['dining_entertainment'])) {
                        $diningText = strip_tags($hotel['dining_entertainment']);
                        $diningItems = array_filter(array_map('trim', explode("\n", $diningText)));
                        // Also check for comma-separated items
                        if (count($diningItems) === 1 && strpos($diningItems[0], ',') !== false) {
                           $diningItems = array_filter(array_map('trim', explode(',', $diningItems[0])));
                        }
                        $displayDining = array_slice($diningItems, 0, 10);
                     }
                     
                     // Only show the section if at least one has data
                     $hasAnyData = !empty($displayAttractions) || !empty($displayTransport) || !empty($displayDining);
                     
                     // Count how many sections have data for proper column sizing
                     $sectionsWithData = 0;
                     if (!empty($displayAttractions)) $sectionsWithData++;
                     if (!empty($displayTransport)) $sectionsWithData++;
                     if (!empty($displayDining)) $sectionsWithData++;
                     
                     // Determine column class based on number of sections
                     $colClass = 'col-xl-4 col-lg-4 col-md-6';
                     if ($sectionsWithData == 2) {
                        $colClass = 'col-xl-6 col-lg-6 col-md-6';
                     } elseif ($sectionsWithData == 1) {
                        $colClass = 'col-xl-12 col-lg-12 col-md-12';
                     }
                  ?>
                  
                  <?php if ($hasAnyData): ?>
                  <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                     <div class="row align-items-stretch justify-content-start gx-4">
                        <?php if (!empty($displayAttractions)): ?>
                        <div class="<?= $colClass ?> p-1">
                           <div class="card p-3 mb-4 h-100">
                              <div class="nearestServ-wrap">
                                 <div class="nearestServ-head d-flex mb-1">
                                    <h6 class="fs-6 fw-semibold text-primary mb-1"><i class="fa-brands fa-servicestack me-2"></i>Top Attractions</h6>
                                 </div>
                                 <div class="nearestServ-caps">
                                    <ul class="row align-items-start g-2 p-0 m-0">
                                       <?php foreach ($displayAttractions as $attraction): ?>
                                       <li class="col-12 text-muted-2"><?= esc($attraction) ?></li>
                                       <?php endforeach; ?>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($displayTransport)): ?>
                        <div class="<?= $colClass ?> p-1">
                           <div class="card p-3 mb-4 h-100">
                              <div class="nearestServ-wrap">
                                 <div class="nearestServ-head d-flex mb-1">
                                    <h6 class="fs-6 fw-semibold text-primary mb-1"><i class="fa-solid fa-jet-fighter me-2"></i>Transportation</h6>
                                 </div>
                                 <div class="nearestServ-caps">
                                    <ul class="row align-items-start g-2 p-0 m-0">
                                       <?php foreach ($displayTransport as $transport): ?>
                                       <li class="col-12 text-muted-2"><?= esc($transport) ?></li>
                                       <?php endforeach; ?>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($displayDining)): ?>
                        <div class="<?= $colClass ?> p-1">
                           <div class="card p-3 mb-4 h-100">
                              <div class="nearestServ-wrap">
                                 <div class="nearestServ-head d-flex mb-1">
                                    <h6 class="fs-6 fw-semibold text-primary mb-1"><i class="fa-solid fa-martini-glass-empty me-2"></i>Dining & Entertainment</h6>
                                 </div>
                                 <div class="nearestServ-caps">
                                    <ul class="row align-items-start g-2 p-0 m-0">
                                       <?php foreach ($displayDining as $dining): ?>
                                       <li class="col-12 text-muted-2"><?= esc($dining) ?></li>
                                       <?php endforeach; ?>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php endif; ?>
                     </div>
                  </div>
                  <?php endif; ?>
                  <!-- Login Alert -->
                  <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                     <div class="d-flex align-items-center justify-content-start py-3 px-3 rounded-2 bg-success mb-4">
                        <p class="text-light fw-semibold m-0"><i class="fa-solid fa-gift text-warning me-2"></i>
                           <a href="<?= base_url('/contact') ?>" class="text-white text-decoration-underline">Request Quote</a> to get the best deals and personalized offers for your stay.
                        </p>
                     </div>
                  </div>
                  <!-- Hotel Description -->
                  <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                     <div class="card mb-4">
                        <div class="card-header">
                           <h4 class="fs-5 mb-0">About This Hotel</h4>
                        </div>
                        <div class="card-body">
                           <?php if (!empty($hotel['description'])): ?>
                           <div class="text-md text-muted lh-lg mb-4 hotel-description">
                              <?= $hotel['description'] ?>
                           </div>
                           <?php else: ?>
                           <p class="text-muted mb-4">
                              Experience comfort and luxury at <?= esc($hotel['name']) ?>.
                              Our hotel offers excellent service and modern amenities for a memorable stay.
                           </p>
                           <?php endif; ?>
                        </div>
                     </div>
                  </div>
                  <!-- Service & Amenities -->
                  <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                     <div class="card mb-4">
                        <div class="card-header">
                           <h4 class="fs-5 mb-0">Service & Amenities</h4>
                        </div>
                        <div class="card-body">
                           <div class="row">
                              <div class="col-xl-2 col-lg-3 col-md-4">
                                 <h5 class="fs-6 fw-semibold mb-0">Hotel Amenities</h5>
                              </div>
                              <div class="col-xl-10 col-lg-9 col-md-8">
                                 <ul class="row align-items-center p-0 mb-0 list-unstyled">
                                    <?php if (!empty($hotel['amenities'])): ?>
                                    <?php foreach (explode(',', $hotel['amenities']) as $amenity): ?>
                                    <?php $amenity = trim($amenity); ?>
                                    <?php if ($amenity !== ''): ?>
                                    <li class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                       <div class="d-flex align-items-center mb-3">
                                          <i class="fa-solid fa-check text-success me-2"></i>
                                          <?= esc($amenity) ?>
                                       </div>
                                    </li>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <li class="col-xl-4 col-md-6">
                                       <div class="mb-3">Free WiFi</div>
                                    </li>
                                    <li class="col-xl-4 col-md-6">
                                       <div class="mb-3">Air Conditioning</div>
                                    </li>
                                    <li class="col-xl-4 col-md-6">
                                       <div class="mb-3">24-Hour Front Desk</div>
                                    </li>
                                    <li class="col-xl-4 col-md-6">
                                       <div class="mb-3">Room Service</div>
                                    </li>
                                    <li class="col-xl-4 col-md-6">
                                       <div class="mb-3">Parking <span class="text-success fw-medium ms-2">Free</span></div>
                                    </li>
                                    <li class="col-xl-4 col-md-6">
                                       <div class="mb-3">Luggage Storage</div>
                                    </li>
                                    <?php endif; ?>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Contact Information -->
                  <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                     <div class="card mb-4">
                        <div class="card-header">
                           <h4 class="fs-5 mb-0">Contact Information</h4>
                        </div>
                        <div class="card-body">
                           <div class="row">
                              <div class="col-md-6">
                                 <?php if (!empty($hotel['contact_phone'])): ?>
                                 <div class="d-flex align-items-center mb-3">
                                    <i class="fa-solid fa-phone text-primary me-3"></i>
                                    <div>
                                       <div class="fw-medium">Phone</div>
                                       <div class="text-muted"><?= esc($hotel['contact_phone']) ?></div>
                                    </div>
                                 </div>
                                 <?php endif; ?>
                                 <?php if (!empty($hotel['contact_email'])): ?>
                                 <div class="d-flex align-items-center mb-3">
                                    <i class="fa-solid fa-envelope text-primary me-3"></i>
                                    <div>
                                       <div class="fw-medium">Email</div>
                                       <div class="text-muted"><?= esc($hotel['contact_email']) ?></div>
                                    </div>
                                 </div>
                                 <?php endif; ?>
                              </div>
                              <div class="col-md-6">
                                 <?php if (!empty($hotel['website'])): ?>
                                 <?php
                  $website = esc($hotel['website']);
                  if (!preg_match('#^https?://#', $website)) {
                     $website = 'https://' . $website;
                  }
                  ?>
                                 <div class="d-flex align-items-center mb-3">
                                    <i class="fa-solid fa-globe text-primary me-3"></i>
                                    <div>
                                       <div class="fw-medium">Website</div>
                                       <a href="<?= $website ?>" target="_blank" class="text-primary">
                                       <?= $website ?>
                                       </a>
                                    </div>
                                 </div>
                                 <?php endif; ?>
                                 <?php if (!empty($hotel['address'])): ?>
                                 <div class="d-flex align-items-center mb-3">
                                    <i class="fa-solid fa-location-dot text-primary me-3"></i>
                                    <div>
                                       <div class="fw-medium">Address</div>
                                       <div class="text-muted"><?= esc($hotel['address']) ?></div>
                                    </div>
                                 </div>
                                 <?php endif; ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Hotel Policies -->
                  <?php if (!empty($hotel['check_in_time']) || !empty($hotel['check_out_time']) || !empty($hotel['hotel_policies'])): ?>
                  <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                     <div class="card mb-4">
                        <div class="card-header">
                           <h4 class="fs-5 mb-0">Hotel Policies</h4>
                        </div>
                        <div class="card-body">
                           <div class="row align-items-start">
                              <?php if (!empty($hotel['hotel_policies'])): ?>
                              <div class="col-xl-12 col-lg-12 col-md-12">
                                 <div class="text-muted lh-lg hotel-policies">
                                    <?= $hotel['hotel_policies'] ?>
                                 </div>
                              </div>
                              <?php endif; ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php endif; ?>
                  <!-- Cancellation Policy -->
                  <?php if (!empty($hotel['cancellation_policy'])): ?>
                  <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                     <div class="card mb-4">
                        <div class="card-header">
                           <h4 class="fs-5 mb-0">Cancellation Policy</h4>
                        </div>
                        <div class="card-body">
                           <div class="d-flex align-items-start">
                              <i class="fa-solid fa-info-circle text-info me-3 mt-1"></i>
                              <div class="text-muted lh-lg cancellation-policy">
                                 <?= $hotel['cancellation_policy'] ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php endif; ?>
                  <!-- Hotel Details & Specifications -->
                  <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                     <div class="card mb-4">
                        <div class="card-header">
                           <h4 class="fs-5 mb-0">Hotel Details & Specifications</h4>
                        </div>
                        <div class="card-body">
                           <div class="row align-items-start">
                              <div class="col-xl-6 col-lg-6 col-md-6">
                                 <h6 class="fw-semibold mb-3">Basic Information</h6>
                                 <div class="d-flex align-items-center mb-2">
                                    <i class="fa-solid fa-star text-warning me-3"></i>
                                    <div>
                                       <div class="text-dark fw-medium">Star Rating</div>
                                       <div class="text-muted"><?= $hotel['star_rating'] ?? 'Not Rated' ?> Star Hotel</div>
                                    </div>
                                 </div>
                                 <div class="d-flex align-items-center mb-2">
                                    <i class="fa-solid fa-money-bill text-success me-3"></i>
                                    <div>
                                       <div class="text-dark fw-medium">Price Range</div>
                                       <div class="text-muted">₹<?= number_format($hotel['price_per_night'] ?? 0, 0) ?> per night</div>
                                    </div>
                                 </div>
                                 <?php if (!empty($hotel['destination_name'])): ?>
                                 <div class="d-flex align-items-center mb-2">
                                    <i class="fa-solid fa-map-marker-alt text-primary me-3"></i>
                                    <div>
                                       <div class="text-dark fw-medium">Location</div>
                                       <div class="text-muted"><?= esc($hotel['destination_name']) ?></div>
                                    </div>
                                 </div>
                                 <?php endif; ?>
                                 <?php if (!empty($hotel['is_featured'])): ?>
                                 <div class="d-flex align-items-center mb-2">
                                    <i class="fa-solid fa-award text-warning me-3"></i>
                                    <div>
                                       <div class="text-dark fw-medium">Special Status</div>
                                       <div class="text-muted">Featured Hotel</div>
                                    </div>
                                 </div>
                                 <?php endif; ?>
                              </div>
                              <div class="col-xl-6 col-lg-6 col-md-6">
                                 <h6 class="fw-semibold mb-3">Additional Information</h6>
                                 <?php if (!empty($hotel['short_description'])): ?>
                                 <div class="d-flex align-items-start mb-3">
                                    <i class="fa-solid fa-info text-info me-3 mt-1"></i>
                                    <div>
                                       <div class="text-dark fw-medium">Quick Overview</div>
                                       <div class="text-muted"><?= esc($hotel['short_description']) ?></div>
                                    </div>
                                 </div>
                                 <?php endif; ?>
                                 <?php if (!empty($hotel['latitude']) && !empty($hotel['longitude'])): ?>
                                 <div class="d-flex align-items-center mb-2">
                                    <i class="fa-solid fa-map text-success me-3"></i>
                                    <div>
                                       <div class="text-dark fw-medium">GPS Coordinates</div>
                                       <div class="text-muted">
                                          <a href="https://www.google.com/maps?q=<?= $hotel['latitude'] ?>,<?= $hotel['longitude'] ?>" target="_blank" class="text-primary">
                                          <?= number_format($hotel['latitude'], 6) ?>, <?= number_format($hotel['longitude'], 6) ?>
                                          </a>
                                       </div>
                                    </div>
                                 </div>
                                 <?php endif; ?>
                                 <div class="d-flex align-items-center mb-2">
                                    <i class="fa-solid fa-calendar text-info me-3"></i>
                                    <div>
                                       <div class="text-dark fw-medium">Listed Since</div>
                                       <div class="text-muted"><?= date('F Y', strtotime($hotel['created_at'])) ?></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- FAQ -->
                  <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                     <div class="row align-items-start justify-content-between gx-3">
                        <div class="col-xl-3 col-lg-4 col-md-4">
                           <div class="position-relative mb-4">
                              <h4 class="lh-base">FAQ About <?= esc($hotel['name']) ?></h4>
                           </div>
                           <div class="position-relative mb-4">
                              <a href="<?= base_url('/contact') ?>" class="btn btn-md btn-primary fw-medium">Contact Us</a>
                           </div>
                        </div>
                        <div class="col-xl-9 col-lg-8 col-md-8">
                           <div class="accordion accordion-flush" id="accordionFlushExample">
                              <?php if (!empty($faqs)): ?>
                              <?php foreach ($faqs as $index => $faq): ?>
                              <div class="accordion-item">
                                 <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $index + 1 ?>" aria-expanded="false" aria-controls="flush-collapse<?= $index + 1 ?>">
                                    <?= esc($faq['question']) ?>
                                    </button>
                                 </h2>
                                 <div id="flush-collapse<?= $index + 1 ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body"><?= $faq['answer'] ?></div>
                                 </div>
                              </div>
                              <?php endforeach; ?>
                              <?php endif; ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>
</section>
<!-- Similar Hotels -->
<?php if (!empty($relatedHotels)): ?>
<section>
   <div class="container">
      <div class="row align-items-center justify-content-between mb-3">
         <div class="col-8">
            <div class="upside-heading">
               <h5 class="fw-bold fs-6 m-0">Similar Hotels in <?= esc($hotel['destination_name'] ?? 'This Area') ?></h5>
            </div>
         </div>
         <div class="col-4">
            <div class="text-end grpx-btn">
               <a href="<?= base_url('/hotels') ?>" class="btn btn-light-primary btn-md fw-medium">More<i class="fa-solid fa-arrow-trend-up ms-2"></i></a>
            </div>
         </div>
      </div>
      <div class="row justify-content-center">
         <div class="col-xl-12 col-lg-12 col-md-12 p-0">
            <div class="main-carousel cols-3 dots-full">
               <?php foreach ($relatedHotels as $relatedHotel): ?>
               <!-- Single Item -->
               <div class="carousel-cell">
                  <div class="pop-touritem">
                     <a href="<?= base_url('/hotels/' . ($relatedHotel['slug'] ?? $relatedHotel['id'])) ?>" class="card rounded-3 border br-dashed m-0">
                        <div class="flight-thumb-wrapper">
                           <div class="popFlights-item-overHidden">
                              <?php if (!empty($relatedHotel['featured_image'])): ?>
                              <img src="<?= base_url($relatedHotel['featured_image']) ?>" class="img-fluid" alt="<?= esc($relatedHotel['name']) ?>">
                              <?php else: ?>
                              <img src="https://placehold.co/1100x700/e9ecef/6c757d?text=<?= urlencode($relatedHotel['name']) ?>" class="img-fluid" alt="<?= esc($relatedHotel['name']) ?>">
                              <?php endif; ?>
                           </div>
                        </div>
                        <div class="touritem-middle position-relative p-3">
                           <div class="touritem-flexxer">
                              <h4 class="city fs-6 m-0 fw-bold">
                                 <span><?= esc($relatedHotel['name']) ?></span>
                              </h4>
                              <p class="detail ellipsis-container">
                                 <span class="ellipsis-item__normal"><?= esc($relatedHotel['destination_name'] ?? 'Hotel') ?></span>
                                 <span class="separate ellipsis-item__normal"></span>
                                 <span class="ellipsis-item"><?= $relatedHotel['star_rating'] ?? 0 ?> Star Hotel</span>
                              </p>
                              <div class="touritem-centrio mt-4">
                                 <?php if (!empty($relatedHotel['is_featured'])): ?>
                                 <div class="d-block position-relative">
                                    <span class="label bg-light-success text-success">Featured Hotel</span>
                                 </div>
                                 <?php endif; ?>
                                 <div class="aments-lists mt-2">
                                    <ul class="p-0 row gx-3 gy-2 align-items-start flex-wrap">
                                       <?php if (!empty($relatedHotel['amenities'])): ?>
                                       <?php
                                                   $amenities = array_slice(explode(',', $relatedHotel['amenities']), 0, 6);
                                                   foreach ($amenities as $amenity):
                                                      $amenity = trim($amenity);
                                                      if (!empty($amenity)):
                                                         ?>
                                                                              <li class="col-auto text-dark text-md text-muted-2 d-inline-flex align-items-center">
                                                                                 <i class="fa-solid fa-check text-success me-1"></i><?= esc($amenity) ?>
                                                                              </li>
                                                                              <?php
                                                      endif;
                                                   endforeach;
                                       ?>
                                       <?php else: ?>
                                       <li class="col-auto text-dark text-md text-muted-2 d-inline-flex align-items-center">
                                          <i class="fa-solid fa-check text-success me-1"></i>Free WiFi
                                       </li>
                                       <li class="col-auto text-dark text-md text-muted-2 d-inline-flex align-items-center">
                                          <i class="fa-solid fa-check text-success me-1"></i>Air Conditioning
                                       </li>
                                       <li class="col-auto text-dark text-md text-muted-2 d-inline-flex align-items-center">
                                          <i class="fa-solid fa-check text-success me-1"></i>Room Service
                                       </li>
                                       <?php endif; ?>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                           <div class="trsms-foots mt-4">
                              <div class="flts-flex d-flex align-items-end justify-content-between">
                                 <div class="flts-flex-strat">
                                    <?php if (!empty($relatedHotel['is_featured'])): ?>
                                    <div class="d-flex align-items-center justify-content-start">
                                       <span class="label bg-offer text-light">Featured</span>
                                    </div>
                                    <?php endif; ?>
                                    <div class="d-flex align-items-center">
                                       <div class="text-dark fw-bold fs-4">₹<?= number_format($relatedHotel['price_per_night'] ?? 0, 0) ?></div>
                                    </div>
                                    <div class="d-flex align-items-start flex-column">
                                       <div class="text-muted-2 text-sm">Per Night</div>
                                    </div>
                                 </div>
                                 <div class="flts-flex-end">
                                    <div class="row align-items-center justify-content-end gx-2">
                                       <div class="col-auto text-start text-md-end">
                                          <div class="text-md text-dark fw-medium">Excellent</div>
                                          <div class="text-md text-muted-2"><?= $relatedHotel['star_rating'] ?? 0 ?> Star</div>
                                       </div>
                                       <div class="col-auto">
                                          <div class="square--40 rounded-2 bg-ratting text-light">4.<?= $relatedHotel['star_rating'] ?? 0 ?></div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
               </div>
               <?php endforeach; ?>
            </div>
         </div>
      </div>
   </div>
</section>
<?php endif; ?>
<script>
   function openGallery() {
       const hiddenImages = document.querySelectorAll('[data-lightbox="hotel-gallery"]');
       if (hiddenImages.length > 5) {
           // Click on the first hidden image (6th image)
           const hiddenContainer = document.querySelector('div[style*="display: none"]');
           if (hiddenContainer) {
               const firstHiddenImage = hiddenContainer.querySelector('a[data-lightbox="hotel-gallery"]');
               if (firstHiddenImage) {
                   firstHiddenImage.click();
               }
           }
       } else if (hiddenImages.length > 0) {
           // If no hidden images, just open the first image
           hiddenImages[0].click();
       }
   }
   
   function shareHotel() {
       const hotelName = '<?= esc($hotel['name']) ?>';
       const hotelUrl = window.location.href;
       const hotelDescription = '<?= esc(strip_tags($hotel['short_description'] ?? $hotel['description'] ?? '')) ?>';
       
       // Check if Web Share API is supported
       if (navigator.share) {
           navigator.share({
               title: hotelName,
               text: hotelDescription,
               url: hotelUrl
           }).then(() => {
               console.log('Hotel shared successfully');
           }).catch((error) => {
               console.log('Error sharing hotel:', error);
               fallbackShare(hotelName, hotelUrl);
           });
       } else {
           fallbackShare(hotelName, hotelUrl);
       }
   }
   
   function fallbackShare(hotelName, hotelUrl) {
       // Create a modal with share options
       const shareModal = document.createElement('div');
       shareModal.className = 'modal fade';
       shareModal.innerHTML = `
           <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title">Share ${hotelName}</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                   </div>
                   <div class="modal-body">
                       <div class="row g-3">
                           <div class="col-6">
                               <a href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(hotelUrl)}" target="_blank" class="btn btn-primary w-100">
                                   <i class="fab fa-facebook-f me-2"></i>Facebook
                               </a>
                           </div>
                           <div class="col-6">
                               <a href="https://twitter.com/intent/tweet?url=${encodeURIComponent(hotelUrl)}&text=${encodeURIComponent(hotelName)}" target="_blank" class="btn btn-info w-100">
                                   <i class="fab fa-twitter me-2"></i>Twitter
                               </a>
                           </div>
                           <div class="col-6">
                               <a href="https://wa.me/?text=${encodeURIComponent(hotelName + ' - ' + hotelUrl)}" target="_blank" class="btn btn-success w-100">
                                   <i class="fab fa-whatsapp me-2"></i>WhatsApp
                               </a>
                           </div>
                           <div class="col-6">
                               <button onclick="copyToClipboard('${hotelUrl}')" class="btn btn-secondary w-100">
                                   <i class="fas fa-copy me-2"></i>Copy Link
                               </button>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       `;
       
       document.body.appendChild(shareModal);
       const modal = new bootstrap.Modal(shareModal);
       modal.show();
       
       // Remove modal from DOM when hidden
       shareModal.addEventListener('hidden.bs.modal', () => {
           document.body.removeChild(shareModal);
       });
   }
   
   function copyToClipboard(text) {
       navigator.clipboard.writeText(text).then(() => {
           // Show success message
           const alert = document.createElement('div');
           alert.className = 'alert alert-success position-fixed';
           alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
           alert.innerHTML = '<i class="fas fa-check me-2"></i>Link copied to clipboard!';
           document.body.appendChild(alert);
           
           setTimeout(() => {
               document.body.removeChild(alert);
           }, 3000);
       }).catch(() => {
           // Fallback for older browsers
           const textArea = document.createElement('textarea');
           textArea.value = text;
           document.body.appendChild(textArea);
           textArea.select();
           document.execCommand('copy');
           document.body.removeChild(textArea);
           
           const alert = document.createElement('div');
           alert.className = 'alert alert-success position-fixed';
           alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
           alert.innerHTML = '<i class="fas fa-check me-2"></i>Link copied to clipboard!';
           document.body.appendChild(alert);
           
           setTimeout(() => {
               document.body.removeChild(alert);
           }, 3000);
       });
   }
</script>
<style>
   /* Rich text content styling for hotel description */
   .hotel-description h1, .hotel-description h2, .hotel-description h3, 
   .hotel-description h4, .hotel-description h5, .hotel-description h6 {
   color: #333;
   margin-top: 1rem;
   margin-bottom: 0.5rem;
   font-weight: 600;
   }
   .hotel-description h1 { font-size: 1.8rem; }
   .hotel-description h2 { font-size: 1.6rem; }
   .hotel-description h3 { font-size: 1.4rem; }
   .hotel-description h4 { font-size: 1.2rem; }
   .hotel-description h5 { font-size: 1.1rem; }
   .hotel-description h6 { font-size: 1rem; }
   .hotel-description p {
   margin-bottom: 1rem;
   line-height: 1.6;
   }
   .hotel-description ul, .hotel-description ol {
   margin-bottom: 1rem;
   padding-left: 1.5rem;
   }
   .hotel-description li {
   margin-bottom: 0.25rem;
   }
   .hotel-description strong {
   font-weight: 600;
   color: #333;
   }
   .hotel-description em {
   font-style: italic;
   }
   .hotel-description a {
   color: #007bff;
   text-decoration: none;
   }
   .hotel-description a:hover {
   text-decoration: underline;
   }
   .hotel-description blockquote {
   border-left: 4px solid #007bff;
   padding-left: 1rem;
   margin: 1rem 0;
   font-style: italic;
   background-color: #f8f9fa;
   padding: 1rem;
   border-radius: 0.25rem;
   }
   .hotel-description img {
   max-width: 100%;
   height: auto;
   border-radius: 0.25rem;
   margin: 1rem 0;
   }
   /* Styling for hotel policies and other rich content sections */
   .hotel-policies h1, .hotel-policies h2, .hotel-policies h3, 
   .hotel-policies h4, .hotel-policies h5, .hotel-policies h6 {
   color: #333;
   margin-top: 0.8rem;
   margin-bottom: 0.4rem;
   font-weight: 600;
   }
   .hotel-policies h4 { font-size: 1.1rem; }
   .hotel-policies h5 { font-size: 1rem; }
   .hotel-policies h6 { font-size: 0.9rem; }
   .hotel-policies p {
   margin-bottom: 0.8rem;
   line-height: 1.5;
   }
   .hotel-policies ul, .hotel-policies ol {
   margin-bottom: 0.8rem;
   padding-left: 1.2rem;
   }
   .hotel-policies li {
   margin-bottom: 0.2rem;
   }
   .hotel-policies strong {
   font-weight: 600;
   color: #333;
   }
   .hotel-policies em {
   font-style: italic;
   }
   /* Styling for cancellation policy content */
   .cancellation-policy h1, .cancellation-policy h2, .cancellation-policy h3, 
   .cancellation-policy h4, .cancellation-policy h5, .cancellation-policy h6 {
   color: #333;
   margin-top: 0.8rem;
   margin-bottom: 0.4rem;
   font-weight: 600;
   }
   .cancellation-policy h4 { font-size: 1.1rem; }
   .cancellation-policy h5 { font-size: 1rem; }
   .cancellation-policy h6 { font-size: 0.9rem; }
   .cancellation-policy p {
   margin-bottom: 0.8rem;
   line-height: 1.5;
   }
   .cancellation-policy ul, .cancellation-policy ol {
   margin-bottom: 0.8rem;
   padding-left: 1.2rem;
   }
   .cancellation-policy li {
   margin-bottom: 0.2rem;
   }
   .cancellation-policy strong {
   font-weight: 600;
   color: #333;
   }
   .cancellation-policy em {
   font-style: italic;
   }
   /* Gallery Layout Styles */
   .geotrip-gallery {
   display: flex;
   gap: 10px;
   height: 400px;
   }
   .left-img {
   flex: 2;
   height: 100%;
   }
   .left-img img {
   width: 100%;
   height: 100%;
   object-fit: cover;
   border-radius: 8px;
   }
   .right-grid {
   flex: 1;
   display: grid;
   grid-template-columns: 1fr 1fr;
   grid-template-rows: 1fr 1fr;
   gap: 10px;
   height: 100%;
   }
   .right-grid img {
   width: 100%;
   height: 100%;
   object-fit: cover;
   }
   .btn-whites {
   background-color: rgba(255, 255, 255, 0.9);
   border: 1px solid rgba(255, 255, 255, 0.2);
   backdrop-filter: blur(10px);
   }
   .btn-whites:hover {
   background-color: rgba(255, 255, 255, 1);
   }
   /* Responsive adjustments for gallery */
   @media (max-width: 768px) {
   .geotrip-gallery {
   flex-direction: column;
   height: auto;
   }
   .left-img {
   height: 250px;
   margin-bottom: 10px;
   }
   .right-grid {
   height: 200px;
   grid-template-columns: 1fr 1fr;
   grid-template-rows: 1fr;
   }
   }
   @media (max-width: 576px) {
   .right-grid {
   grid-template-columns: 1fr;
   grid-template-rows: 1fr 1fr;
   height: 250px;
   }
   }
</style>
<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>