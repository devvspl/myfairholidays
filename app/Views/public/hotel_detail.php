<?php include APPPATH . 'Views/layouts/public_header.php'; ?>
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
         <div class="col-xl-12 col-lg-12 col-md-12 p-0">
            <div class="card border-0 p-3 mb-4">
               <div class="crd-heaader d-md-flex align-items-center justify-content-between mb-3">
                  <div class="crd-heaader-first">
                     <div class="d-inline-flex align-items-center mb-1">
                        <?php if (!empty($hotel['is_featured'])): ?>
                        <span class="label bg-light-success text-success">Featured Hotel</span>
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
                     <div class="drix-wrap d-flex flex-column align-items-md-end align-items-start text-end">
                        <div class="drix-first d-flex align-items-center text-end mb-2">
                           <a href="#" onclick="shareHotel(); return false;" class="bg-light-danger text-danger rounded-1 fw-medium text-sm px-3 py-2 lh-base"><i class="fa-solid fa-share-nodes me-2"></i>Share</a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="crd-body">
                  <div class="row align-items-center justify-content-between">
                     <div class="col-xl-8 col-lg-7 col-md-12">
                        <div class="mmt-gallery mb-lg-0 mb-3">
                           <div class="left-image">
                              <?php if (!empty($images) && count($images) > 0): ?>
                              <a href="<?= base_url($images[0]['image_path']) ?>" data-lightbox="hotel-gallery" data-title="<?= esc($images[0]['caption'] ?? $hotel['name']) ?>">
                              <img src="<?= base_url($images[0]['image_path']) ?>" alt="<?= esc($images[0]['alt_text'] ?? $hotel['name']) ?>" class="rounded-2 img-fluid">
                              </a>
                              <?php elseif (!empty($hotel['featured_image'])): ?>
                              <a href="<?= base_url($hotel['featured_image']) ?>" data-lightbox="hotel-gallery">
                              <img src="<?= base_url($hotel['featured_image']) ?>" alt="<?= esc($hotel['name']) ?>" class="rounded-2 img-fluid">
                              </a>
                              <?php else: ?>
                              <img src="https://placehold.co/1100x700/e9ecef/6c757d?text=No+Image" alt="<?= esc($hotel['name']) ?>" class="rounded-2 img-fluid">
                              <?php endif; ?>
                           </div>
                           <div class="right-column">
                              <div class="image-box">
                                 <?php if (!empty($images) && count($images) > 1): ?>
                                 <a href="<?= base_url($images[1]['image_path']) ?>" data-lightbox="hotel-gallery" data-title="<?= esc($images[1]['caption'] ?? $hotel['name']) ?>">
                                 <img src="<?= base_url($images[1]['image_path']) ?>" alt="<?= esc($images[1]['alt_text'] ?? $hotel['name']) ?>" class="rounded-2 img-fluid">
                                 </a>
                                 <?php elseif (!empty($images) && count($images) > 0): ?>
                                 <a href="<?= base_url($images[0]['image_path']) ?>" data-lightbox="hotel-gallery" data-title="<?= esc($images[0]['caption'] ?? $hotel['name']) ?>">
                                 <img src="<?= base_url($images[0]['image_path']) ?>" alt="<?= esc($images[0]['alt_text'] ?? $hotel['name']) ?>" class="rounded-2 img-fluid">
                                 </a>
                                 <?php elseif (!empty($hotel['featured_image'])): ?>
                                 <a href="<?= base_url($hotel['featured_image']) ?>" data-lightbox="hotel-gallery">
                                 <img src="<?= base_url($hotel['featured_image']) ?>" alt="<?= esc($hotel['name']) ?>" class="rounded-2 img-fluid">
                                 </a>
                                 <?php else: ?>
                                 <img src="https://placehold.co/1100x700/e9ecef/6c757d?text=No+Image" alt="<?= esc($hotel['name']) ?>" class="rounded-2 img-fluid">
                                 <?php endif; ?>
                              </div>
                              <div class="image-box position-relative">
                                 <?php if (!empty($images) && count($images) > 2): ?>
                                 <a href="<?= base_url($images[2]['image_path']) ?>" data-lightbox="hotel-gallery" data-title="<?= esc($images[2]['caption'] ?? $hotel['name']) ?>">
                                 <img src="<?= base_url($images[2]['image_path']) ?>" alt="<?= esc($images[2]['alt_text'] ?? $hotel['name']) ?>" class="rounded-2 img-fluid">
                                 </a>
                                 <?php elseif (!empty($images) && count($images) > 0): ?>
                                 <a href="<?= base_url($images[0]['image_path']) ?>" data-lightbox="hotel-gallery" data-title="<?= esc($images[0]['caption'] ?? $hotel['name']) ?>">
                                 <img src="<?= base_url($images[0]['image_path']) ?>" alt="<?= esc($images[0]['alt_text'] ?? $hotel['name']) ?>" class="rounded-2 img-fluid">
                                 </a>
                                 <?php elseif (!empty($hotel['featured_image'])): ?>
                                 <a href="<?= base_url($hotel['featured_image']) ?>" data-lightbox="hotel-gallery">
                                 <img src="<?= base_url($hotel['featured_image']) ?>" alt="<?= esc($hotel['name']) ?>" class="rounded-2 img-fluid">
                                 </a>
                                 <?php else: ?>
                                 <img src="https://placehold.co/1100x700/e9ecef/6c757d?text=No+Image" alt="<?= esc($hotel['name']) ?>" class="rounded-2 img-fluid">
                                 <?php endif; ?>
                                 <div class="position-absolute end-0 bottom-0 mb-3 me-3">
                                    <?php if (!empty($images) && count($images) > 3): ?>
                                    <a href="#" onclick="openGallery(); return false;" class="btn btn-dark btn-sm fw-medium">
                                    <i class="fa-solid fa-images me-1"></i>+<?= count($images) - 3 ?> Photos
                                    </a>
                                    <?php else: ?>
                                    <a href="<?= !empty($images) ? base_url($images[0]['image_path']) : base_url($hotel['featured_image'] ?? 'https://placehold.co/650x430') ?>" data-lightbox="hotel-gallery" class="btn btn-dark btn-sm fw-medium">
                                    <i class="fa-solid fa-caret-right me-1"></i>View Gallery
                                    </a>
                                    <?php endif; ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Hidden images for lightbox -->
                        <?php if (!empty($images) && count($images) > 3): ?>
                        <div style="display: none;">
                           <?php for ($i = 3; $i < count($images); $i++): ?>
                           <a href="<?= base_url($images[$i]['image_path']) ?>" data-lightbox="hotel-gallery" data-title="<?= esc($images[$i]['caption'] ?? $hotel['name']) ?>"></a>
                           <?php endfor; ?>
                        </div>
                        <?php endif; ?>
                     </div>
                     <div class="col-xl-4 col-lg-5 col-md-12">
                        <div class="card border br-dashed">
                           <div class="card-header">
                              <div class="crd-heady102 d-flex align-items-center justify-content-start">
                                 <div class="square--30 circle bg-light-primary text-primary flex-shrink-0"><i class="fa-solid fa-percent"></i></div>
                                 <div class="crd-heady102Title lh-1 ps-2">
                                    <span class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">Best Price Guaranteed</span>
                                 </div>
                              </div>
                           </div>
                           <div class="card-body">
                              <div class="d-block mb-3">
                                 <div class="d-flex align-items-center justify-content-start">
                                    <div class="text-dark fw-bold fs-3 me-2">₹<?= number_format($hotel['price_per_night'] ?? 0, 0) ?></div>
                                    <?php if (!empty($hotel['is_featured'])): ?>
                                    <div class="text-muted-2 fw-medium text-decoration-line-through me-2">₹<?= number_format(($hotel['price_per_night'] ?? 0) * 1.25, 0) ?></div>
                                    <div class="text-danger fw-semibold">20% Off</div>
                                    <?php endif; ?>
                                 </div>
                                 <div class="d-flex align-items-start justify-content-start">
                                    <div class="text-muted-2 text-md">
                                       <?= !empty($hotel['is_featured']) ? 'Special featured price - inclusive of all taxes' : 'inclusive of all taxes' ?>
                                    </div>
                                 </div>
                              </div>
                              <div class="d-block">
                                 <div class="form-group mb-3">
                                    <div class="inputIicon">
                                       <div class="myIcon">
                                          <svg width="24" height="24" viewBox="0 0 24 24" class="fill-primary" xmlns="http://www.w3.org/2000/svg">
                                             <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"/>
                                             <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"/>
                                          </svg>
                                       </div>
                                       <div class="input-box">
                                          <input class="form-control fw-medium fs-md choosedate" type="text" placeholder="Choose Date" readonly="readonly">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group mb-3">
                                    <div class="form-group mb-0">
                                       <div class="inputIicon">
                                          <div class="myIcon">
                                             <svg width="24" height="24" viewBox="0 0 24 24" class="fill-primary" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z"/>
                                                <path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z"/>
                                             </svg>
                                          </div>
                                          <div class="input-box">
                                             <div class="selection-container">
                                                <div class="traveler-box">
                                                   <input type="text" class="form-control fw-medium input-box fs-md traveler-input" value="1 Room, 2 Adults" readonly>
                                                   <div class="traveler-dropdown" data-has-rooms="true"></div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group mb-2">
                                    <button type="button" class="btn btn-primary full-width fw-medium">Check Availability</button>
                                 </div>
                              </div>
                           </div>
                           <div class="card-footer bg-white">
                              <div class="row align-items-center justify-content-start gx-2">
                                 <div class="col-auto">
                                    <div class="square--40 rounded-2 bg-ratting text-light">
                                       <?php 
                                       $rating = $hotel['star_rating'] ?? 3;
                                       $displayRating = number_format(3.5 + ($rating * 0.3), 1);
                                       echo $displayRating;
                                       ?>
                                    </div>
                                 </div>
                                 <div class="col-auto text-start">
                                    <div class="text-md text-dark fw-medium">
                                       <?php
                                       $ratingText = 'Good';
                                       if ($rating >= 5) $ratingText = 'Exceptional';
                                       elseif ($rating >= 4) $ratingText = 'Excellent';
                                       elseif ($rating >= 3) $ratingText = 'Very Good';
                                       elseif ($rating >= 2) $ratingText = 'Good';
                                       else $ratingText = 'Fair';
                                       echo $ratingText;
                                       ?>
                                    </div>
                                    <div class="text-md text-muted-2">Based on <?= $rating ?> star rating</div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <section class="pt-0 gray-simple p-0">
            <div class="container p-0">
               <div class="row">
                  <!-- Top Attractions -->
                  <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                     <div class="row align-items-center justify-content-between gx-4">
                        <div class="col-xl-4 col-lg-4 col-md-4 p-0">
                           <div class="card p-3 mb-4">
                              <div class="nearestServ-wrap">
                                 <div class="nearestServ-head d-flex mb-1">
                                    <h6 class="fs-6 fw-semibold text-primary mb-1"><i class="fa-brands fa-servicestack me-2"></i>Top Attractions</h6>
                                 </div>
                                 <div class="nearestServ-caps">
                                    <ul class="row align-items-start g-2 p-0 m-0">
                                       <?php if (!empty($hotel['nearby_attractions'])): ?>
                                          <?php
                                          // Extract plain text attractions from HTML content
                                          $attractionsHtml = $hotel['nearby_attractions'];
                                          // Remove HTML tags and get plain text lines
                                          $attractionsText = strip_tags($attractionsHtml);
                                          $attractions = array_filter(explode("\n", $attractionsText));
                                          $displayAttractions = [];
                                          
                                          foreach ($attractions as $attraction) {
                                             $attraction = trim($attraction);
                                             if (!empty($attraction) && !preg_match('/^(Cultural|Natural|Entertainment|Day Trip)/i', $attraction)) {
                                                $displayAttractions[] = $attraction;
                                             }
                                          }
                                          
                                          foreach (array_slice($displayAttractions, 0, 3) as $attraction):
                                          ?>
                                          <li class="col-12 text-muted-2"><?= esc($attraction) ?></li>
                                          <?php
                                          endforeach;
                                          ?>
                                       <?php else: ?>
                                          <li class="col-12 text-muted-2"><?= esc($hotel['destination_name'] ?? 'Local Area') ?> (nearby)</li>
                                          <?php if (!empty($hotel['destination_name'])): ?>
                                             <li class="col-12 text-muted-2"><?= esc($hotel['destination_name']) ?> Tourist Spots</li>
                                             <li class="col-12 text-muted-2">Local Shopping Areas</li>
                                          <?php else: ?>
                                             <li class="col-12 text-muted-2">Tourist Attractions</li>
                                             <li class="col-12 text-muted-2">Shopping Centers</li>
                                          <?php endif; ?>
                                       <?php endif; ?>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 p-0">
                           <div class="card p-3 mb-4">
                              <div class="nearestServ-wrap">
                                 <div class="nearestServ-head d-flex mb-1">
                                    <h6 class="fs-6 fw-semibold text-primary mb-1"><i class="fa-solid fa-jet-fighter me-2"></i>Transportation</h6>
                                 </div>
                                 <div class="nearestServ-caps">
                                    <ul class="row align-items-start g-2 p-0 m-0">
                                       <?php if (!empty($hotel['transportation_info'])): ?>
                                          <?php
                                          // Extract plain text transportation info from HTML content
                                          $transportHtml = $hotel['transportation_info'];
                                          // Remove HTML tags and get plain text lines
                                          $transportText = strip_tags($transportHtml);
                                          $transportInfo = array_filter(explode("\n", $transportText));
                                          $displayTransport = [];
                                          
                                          foreach ($transportInfo as $transport) {
                                             $transport = trim($transport);
                                             if (!empty($transport) && !preg_match('/^(Airport|Local|Public|Parking|Accessibility)/i', $transport)) {
                                                $displayTransport[] = $transport;
                                             }
                                          }
                                          
                                          foreach (array_slice($displayTransport, 0, 3) as $transport):
                                          ?>
                                          <li class="col-12 text-muted-2"><?= esc($transport) ?></li>
                                          <?php
                                          endforeach;
                                          ?>
                                       <?php else: ?>
                                          <?php if (!empty($hotel['destination_name'])): ?>
                                             <li class="col-12 text-muted-2">Airport: <?= esc($hotel['destination_name']) ?> Airport</li>
                                             <li class="col-12 text-muted-2">Metro: <?= esc($hotel['destination_name']) ?> Metro</li>
                                             <li class="col-12 text-muted-2">Bus: Local Transport Hub</li>
                                          <?php else: ?>
                                             <li class="col-12 text-muted-2">Airport: Nearby Airport</li>
                                             <li class="col-12 text-muted-2">Metro: Local Metro Station</li>
                                             <li class="col-12 text-muted-2">Bus: Public Transport</li>
                                          <?php endif; ?>
                                       <?php endif; ?>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 p-0">
                           <div class="card p-3 mb-4">
                              <div class="nearestServ-wrap">
                                 <div class="nearestServ-head d-flex mb-1">
                                    <h6 class="fs-6 fw-semibold text-primary mb-1"><i class="fa-solid fa-martini-glass-empty me-2"></i>Dining & Entertainment</h6>
                                 </div>
                                 <div class="nearestServ-caps">
                                    <ul class="row align-items-start g-2 p-0 m-0">
                                       <?php 
                                       $hasRestaurant = !empty($hotel['amenities']) && (stripos($hotel['amenities'], 'restaurant') !== false || stripos($hotel['amenities'], 'dining') !== false);
                                       $hasBar = !empty($hotel['amenities']) && (stripos($hotel['amenities'], 'bar') !== false || stripos($hotel['amenities'], 'lounge') !== false);
                                       ?>
                                       <li class="col-12 text-muted-2">
                                          <?= $hasRestaurant ? 'On-site Restaurant' : 'Restaurants nearby' ?>
                                       </li>
                                       <li class="col-12 text-muted-2">
                                          <?= $hasBar ? 'Hotel Bar & Lounge' : 'Cafes & Bars nearby' ?>
                                       </li>
                                       <li class="col-12 text-muted-2">Entertainment venues</li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Login Alert -->
                  <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                     <div class="d-flex align-items-center justify-content-start py-3 px-3 rounded-2 bg-success mb-4">
                        <p class="text-light fw-semibold m-0"><i class="fa-solid fa-gift text-warning me-2"></i>
                           <a href="<?= base_url('/quote') ?>" class="text-white text-decoration-underline">Request Quote</a> to get the best deals and personalized offers for your stay.
                        </p>
                     </div>
                  </div>
                  <!-- Hotel Description & Amenities -->
                  <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                     <div class="card mb-4">
                        <div class="card-header">
                           <h4 class="fs-5 mb-0">About This Hotel</h4>
                        </div>
                        <div class="card-body">
                           <div class="row align-items-start">
                              <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                                 <?php if (!empty($hotel['description'])): ?>
                                 <div class="text-md text-muted lh-lg mb-4 hotel-description">
                                    <?= nl2br(esc($hotel['description'])) ?>
                                 </div>
                                 <?php else: ?>
                                 <p class="text-muted mb-4">Experience comfort and luxury at <?= esc($hotel['name']) ?>. Our hotel offers excellent service and modern amenities for a memorable stay.</p>
                                 <?php endif; ?>
                              </div>
                           </div>
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
                           <div class="row align-items-start">
                              <div class="col-xl-2 col-lg-3 col-md-4">
                                 <h5 class="fs-6 fw-semibold mb-0">Hotel Amenities</h5>
                              </div>
                              <div class="col-xl-10 col-lg-9 col-md-8">
                                 <div class="row align-items-start">
                                    <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                                       <?php if (!empty($hotel['amenities'])): ?>
                                       <ul class="row align-items-center p-0 mb-0">
                                          <?php
    $amenities = explode(',', $hotel['amenities']);
    foreach ($amenities as $amenity):
        $amenity = trim($amenity);
        if (!empty($amenity)):
            ?>
                                          <li class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                             <div class="d-flex align-items-center mb-3">
                                                <i class="fa-solid fa-check text-success me-2"></i><?= esc($amenity) ?>
                                             </div>
                                          </li>
                                          <?php
        endif;
    endforeach;
    ?>
                                       </ul>
                                       <?php else: ?>
                                       <ul class="row align-items-center p-0 mb-0">
                                          <li class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                             <div class="d-flex align-items-center mb-3">Free WiFi</div>
                                          </li>
                                          <li class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                             <div class="d-flex align-items-center mb-3">Air Conditioning</div>
                                          </li>
                                          <li class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                             <div class="d-flex align-items-center mb-3">24-Hour Front Desk</div>
                                          </li>
                                          <li class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                             <div class="d-flex align-items-center mb-3">Room Service</div>
                                          </li>
                                          <li class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                             <div class="d-flex align-items-center mb-3">Parking<span class="text-success fw-medium ms-3">Free</span></div>
                                          </li>
                                          <li class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                             <div class="d-flex align-items-center mb-3">Luggage Storage</div>
                                          </li>
                                       </ul>
                                       <?php endif; ?>
                                    </div>
                                 </div>
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
                           <div class="row align-items-start">
                              <div class="col-xl-6 col-lg-6 col-md-6">
                                 <?php if (!empty($hotel['contact_phone'])): ?>
                                 <div class="d-flex align-items-center mb-3">
                                    <i class="fa-solid fa-phone text-primary me-3"></i>
                                    <div>
                                       <div class="text-dark fw-medium">Phone</div>
                                       <div class="text-muted"><?= esc($hotel['contact_phone']) ?></div>
                                    </div>
                                 </div>
                                 <?php endif; ?>
                                 <?php if (!empty($hotel['contact_email'])): ?>
                                 <div class="d-flex align-items-center mb-3">
                                    <i class="fa-solid fa-envelope text-primary me-3"></i>
                                    <div>
                                       <div class="text-dark fw-medium">Email</div>
                                       <div class="text-muted"><?= esc($hotel['contact_email']) ?></div>
                                    </div>
                                 </div>
                                 <?php endif; ?>
                              </div>
                              <div class="col-xl-6 col-lg-6 col-md-6">
                                 <?php if (!empty($hotel['website'])): ?>
                                 <div class="d-flex align-items-center mb-3">
                                    <i class="fa-solid fa-globe text-primary me-3"></i>
                                    <div>
                                       <div class="text-dark fw-medium">Website</div>
                                       <div class="text-muted"><a href="<?= esc($hotel['website']) ?>" target="_blank" class="text-primary"><?= esc($hotel['website']) ?></a></div>
                                    </div>
                                 </div>
                                 <?php endif; ?>
                                 <?php if (!empty($hotel['address'])): ?>
                                 <div class="d-flex align-items-center mb-3">
                                    <i class="fa-solid fa-location-dot text-primary me-3"></i>
                                    <div>
                                       <div class="text-dark fw-medium">Address</div>
                                       <div class="text-muted"><?= esc($hotel['address']) ?></div>
                                    </div>
                                 </div>
                                 <?php endif; ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  
                  <!-- Hotel Policies & Check-in Information -->
                  <?php if (!empty($hotel['check_in_time']) || !empty($hotel['check_out_time']) || !empty($hotel['hotel_policies'])): ?>
                  <div class="col-xl-12 col-lg-12 col-md-12 p-0">
                     <div class="card mb-4">
                        <div class="card-header">
                           <h4 class="fs-5 mb-0">Hotel Policies & Check-in Information</h4>
                        </div>
                        <div class="card-body">
                           <div class="row align-items-start">
                              <?php if (!empty($hotel['check_in_time']) || !empty($hotel['check_out_time'])): ?>
                              <div class="col-xl-6 col-lg-6 col-md-6">
                                 <h6 class="fw-semibold mb-3">Check-in & Check-out</h6>
                                 <?php if (!empty($hotel['check_in_time'])): ?>
                                 <div class="d-flex align-items-center mb-2">
                                    <i class="fa-solid fa-clock text-success me-3"></i>
                                    <div>
                                       <div class="text-dark fw-medium">Check-in Time</div>
                                       <div class="text-muted"><?= esc($hotel['check_in_time']) ?></div>
                                    </div>
                                 </div>
                                 <?php endif; ?>
                                 <?php if (!empty($hotel['check_out_time'])): ?>
                                 <div class="d-flex align-items-center mb-2">
                                    <i class="fa-solid fa-clock text-danger me-3"></i>
                                    <div>
                                       <div class="text-dark fw-medium">Check-out Time</div>
                                       <div class="text-muted"><?= esc($hotel['check_out_time']) ?></div>
                                    </div>
                                 </div>
                                 <?php endif; ?>
                              </div>
                              <?php endif; ?>
                              
                              <?php if (!empty($hotel['hotel_policies'])): ?>
                              <div class="col-xl-6 col-lg-6 col-md-6">
                                 <h6 class="fw-semibold mb-3">Hotel Policies</h6>
                                 <div class="text-muted lh-lg hotel-policies">
                                    <?= nl2br(esc($hotel['hotel_policies'])) ?>
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
                                 <?= nl2br(esc($hotel['cancellation_policy'])) ?>
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
                                       <div class="accordion-body"><?= nl2br(esc($faq['answer'])) ?></div>
                                    </div>
                                 </div>
                                 <?php endforeach; ?>
                              <?php else: ?>
                                 <!-- Default FAQs if none are set -->
                                 <div class="accordion-item">
                                    <h2 class="accordion-header">
                                       <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                       How to book this hotel?
                                       </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                       <div class="accordion-body">You can book this hotel by clicking the "Check Availability" button above and selecting your preferred dates. You can also contact us directly for personalized assistance with your booking.</div>
                                    </div>
                                 </div>
                                 <div class="accordion-item">
                                    <h2 class="accordion-header">
                                       <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                       What are the check-in and check-out times?
                                       </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                       <div class="accordion-body">
                                          <?php if (!empty($hotel['check_in_time']) || !empty($hotel['check_out_time'])): ?>
                                          Check-in time is <?= esc($hotel['check_in_time'] ?? '2:00 PM') ?> and check-out time is <?= esc($hotel['check_out_time'] ?? '12:00 PM') ?>. Early check-in and late check-out may be available upon request and subject to availability.
                                          <?php else: ?>
                                          Standard check-in time is 2:00 PM and check-out time is 12:00 PM. Early check-in and late check-out may be available upon request and subject to availability.
                                          <?php endif; ?>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="accordion-item">
                                    <h2 class="accordion-header">
                                       <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                       Is parking available?
                                       </button>
                                    </h2>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                       <div class="accordion-body">Yes, parking facilities are available. Please contact the hotel directly for specific parking arrangements and any associated fees.</div>
                                    </div>
                                 </div>
                                 <div class="accordion-item">
                                    <h2 class="accordion-header">
                                       <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                       What amenities are included?
                                       </button>
                                    </h2>
                                    <div id="flush-collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                       <div class="accordion-body">The hotel offers various amenities including <?= !empty($hotel['amenities']) ? esc(str_replace(',', ', ', $hotel['amenities'])) : 'WiFi, air conditioning, room service, and 24-hour front desk' ?>. Please see the amenities section above for a complete list.</div>
                                    </div>
                                 </div>
                                 <div class="accordion-item">
                                    <h2 class="accordion-header">
                                       <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                                       Can I cancel my booking?
                                       </button>
                                    </h2>
                                    <div id="flush-collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                       <div class="accordion-body cancellation-policy">
                                          <?php if (!empty($hotel['cancellation_policy'])): ?>
                                          <?= nl2br(esc($hotel['cancellation_policy'])) ?>
                                          <?php else: ?>
                                          Cancellation policies vary depending on the rate and booking conditions. Please review the specific cancellation terms during booking or contact us for more information about your reservation.
                                          <?php endif; ?>
                                       </div>
                                    </div>
                                 </div>
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
       if (hiddenImages.length > 3) {
           hiddenImages[3].click();
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
</style>

<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>