<?php include APPPATH . 'Views/layouts/public_header.php'; ?>
<div class="py-5 bg-primary position-relative">
   <div class="container">
      <div class="row justify-content-center align-items-center">
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form method="GET" action="<?= base_url('/hotels') ?>" class="search-wrap position-relative">
               <div class="row align-items-end gy-3 gx-md-3 gx-sm-2">
                  <div class="col-xl-8 col-lg-7 col-md-12">
                     <div class="row gy-3 gx-md-3 gx-sm-2">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 position-relative">
                           <div class="form-group mb-0">
                              <label class="text-light text-uppercase opacity-75">Search Hotels</label>
                              <div class="inputIicon">
                                 <div class="myIcon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" class="fill-primary" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"/>
                                    </svg>
                                 </div>
                                 <div class="input-box">
                                    <input class="form-control fw-medium fs-6" type="text" name="search" placeholder="Hotel name, location..." value="<?= esc($currentFilters['search'] ?? '') ?>">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 position-relative">
                           <div class="form-group mb-0">
                              <label class="text-light text-uppercase opacity-75">Destination</label>
                              <div class="inputIicon">
                                 <div class="myIcon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" class="fill-primary" xmlns="http://www.w3.org/2000/svg">
                                       <path opacity="0.3" d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z" />
                                       <path d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z"/>
                                    </svg>
                                 </div>
                                 <div class="input-box">
                                    <select class="form-control fw-medium fs-6" name="destination_id">
                                       <option value="">All Destinations</option>
                                       <?php if (!empty($destinations)): ?>
                                          <?php foreach ($destinations as $destination): ?>
                                             <option value="<?= $destination['id'] ?>" <?= ($currentFilters['destination_id'] ?? '') == $destination['id'] ? 'selected' : '' ?>>
                                                <?= esc($destination['name']) ?>
                                             </option>
                                          <?php endforeach; ?>
                                       <?php endif; ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-5 col-md-12">
                     <div class="row align-items-end gy-3 gx-md-3 gx-sm-2">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                           <div class="form-group mb-0">
                              <button type="submit" class="btn btn-warning text-dark full-width fw-medium" style="background-color:#fe8815;border-color: #fe8815;">
                                 <i class="fa-solid fa-magnifying-glass me-2"></i>Search
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<section class="gray-simple">
   <div class="container">
      <div class="row justify-content-between gy-4 gx-xl-4 gx-lg-3 gx-md-3 gx-4">
         <div class="col-xl-3 col-lg-4 col-md-12">
            <div class="filter-searchBar bg-white rounded-3">
               <div class="filter-searchBar-head border-bottom">
                  <div class="searchBar-headerBody d-flex align-items-start justify-content-between px-3 py-3">
                     <div class="searchBar-headerfirst">
                        <h6 class="fw-bold fs-5 m-0">Filters</h6>
                     </div>
                  </div>
               </div>
               <div class="filter-searchBar-body">
                  <form method="GET" action="<?= base_url('/hotels') ?>" id="sidebar-filters-form">
                     <!-- Preserve search bar values -->
                     <input type="hidden" name="search" value="<?= esc($currentFilters['search'] ?? '') ?>">
                     <input type="hidden" name="destination_id" value="<?= esc($currentFilters['destination_id'] ?? '') ?>">
                     <input type="hidden" name="sort" value="<?= esc($currentFilters['sort'] ?? '') ?>">
                     
                     <!-- Star Rating -->
                     <div class="searchBar-single px-3 py-3 border-bottom">
                        <div class="searchBar-single-title d-flex mb-3">
                           <h6 class="sidebar-subTitle fs-6 fw-medium m-0">Star Rating</h6>
                        </div>
                        <div class="searchBar-single-wrap">
                           <ul class="row align-items-center justify-content-between p-0 gx-3 gy-2 mb-0">
                              <?php 
                              $selectedStars = [];
                              if (!empty($currentFilters['sidebar_stars'])) {
                                  $selectedStars = is_array($currentFilters['sidebar_stars']) 
                                      ? $currentFilters['sidebar_stars'] 
                                      : explode(',', $currentFilters['sidebar_stars']);
                                  $selectedStars = array_filter($selectedStars); // Remove empty values
                              }
                              ?>
                              <li class="col-6">
                                 <input type="checkbox" class="btn-check star-filter" name="sidebar_stars[]" id="star5" value="5" <?= in_array('5', $selectedStars) ? 'checked' : '' ?>>
                                 <label class="btn btn-sm btn-secondary rounded-1 fw-medium full-width" for="star5">5 Star</label>
                              </li>
                              <li class="col-6">
                                 <input type="checkbox" class="btn-check star-filter" name="sidebar_stars[]" id="star4" value="4" <?= in_array('4', $selectedStars) ? 'checked' : '' ?>>
                                 <label class="btn btn-sm btn-secondary rounded-1 fw-medium full-width" for="star4">4 Star</label>
                              </li>
                              <li class="col-6">
                                 <input type="checkbox" class="btn-check star-filter" name="sidebar_stars[]" id="star3" value="3" <?= in_array('3', $selectedStars) ? 'checked' : '' ?>>
                                 <label class="btn btn-sm btn-secondary rounded-1 fw-medium full-width" for="star3">3 Star</label>
                              </li>
                              <li class="col-6">
                                 <input type="checkbox" class="btn-check star-filter" name="sidebar_stars[]" id="star2" value="2" <?= in_array('2', $selectedStars) ? 'checked' : '' ?>>
                                 <label class="btn btn-sm btn-secondary rounded-1 fw-medium full-width" for="star2">2 Star</label>
                              </li>
                              <li class="col-6">
                                 <input type="checkbox" class="btn-check star-filter" name="sidebar_stars[]" id="star1" value="1" <?= in_array('1', $selectedStars) ? 'checked' : '' ?>>
                                 <label class="btn btn-sm btn-secondary rounded-1 fw-medium full-width" for="star1">1 Star</label>
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
                                    <input class="form-check-input feature-filter" type="checkbox" name="is_featured" id="featured" value="1" <?= ($currentFilters['is_featured'] ?? '') == '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="featured">Featured Hotels</label>
                                 </div>
                              </li>
                              <?php 
                              $selectedAmenities = [];
                              if (!empty($currentFilters['amenities'])) {
                                  $selectedAmenities = is_array($currentFilters['amenities']) 
                                      ? $currentFilters['amenities'] 
                                      : explode(',', $currentFilters['amenities']);
                                  $selectedAmenities = array_filter($selectedAmenities); // Remove empty values
                              }
                              ?>
                              <li class="col-12">
                                 <div class="form-check">
                                    <input class="form-check-input amenity-filter" type="checkbox" name="amenities[]" id="wifi" value="WiFi" <?= in_array('WiFi', $selectedAmenities) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="wifi">Free WiFi</label>
                                 </div>
                              </li>
                              <li class="col-12">
                                 <div class="form-check">
                                    <input class="form-check-input amenity-filter" type="checkbox" name="amenities[]" id="pool" value="Pool" <?= in_array('Pool', $selectedAmenities) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="pool">Swimming Pool</label>
                                 </div>
                              </li>
                              <li class="col-12">
                                 <div class="form-check">
                                    <input class="form-check-input amenity-filter" type="checkbox" name="amenities[]" id="gym" value="Gym" <?= in_array('Gym', $selectedAmenities) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="gym">Fitness Center</label>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </div>

                     <!-- Price Range -->
                     <div class="searchBar-single px-3 py-3 border-bottom">
                        <div class="searchBar-single-title d-flex mb-3">
                           <h6 class="sidebar-subTitle fs-6 fw-medium m-0">Price Range (₹ per night)</h6>
                        </div>
                        <div class="searchBar-single-wrap">
                           <div class="row">
                              <div class="col-6">
                                 <input type="number" class="form-control form-control-sm" name="min_price" placeholder="Min" value="<?= esc($currentFilters['min_price'] ?? '') ?>">
                              </div>
                              <div class="col-6">
                                 <input type="number" class="form-control form-control-sm" name="max_price" placeholder="Max" value="<?= esc($currentFilters['max_price'] ?? '') ?>">
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- Hotel Type & Features -->
                     <div class="searchBar-single px-3 py-3 border-bottom">
                        <div class="searchBar-single-title d-flex mb-3">
                           <h6 class="sidebar-subTitle fs-6 fw-medium m-0">Hotel Features</h6>
                        </div>
                        <div class="searchBar-single-wrap">
                           <ul class="row align-items-center justify-content-between p-0 gx-3 gy-2 mb-0">
                              <li class="col-12">
                                 <div class="form-check">
                                    <input class="form-check-input feature-filter" type="checkbox" name="has_contact" id="has_contact" value="1" <?= ($currentFilters['has_contact'] ?? '') == '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="has_contact">Contact Available</label>
                                 </div>
                              </li>
                              <li class="col-12">
                                 <div class="form-check">
                                    <input class="form-check-input feature-filter" type="checkbox" name="has_website" id="has_website" value="1" <?= ($currentFilters['has_website'] ?? '') == '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="has_website">Official Website</label>
                                 </div>
                              </li>
                              <li class="col-12">
                                 <div class="form-check">
                                    <input class="form-check-input feature-filter" type="checkbox" name="has_description" id="has_description" value="1" <?= ($currentFilters['has_description'] ?? '') == '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="has_description">Detailed Description</label>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </div>

                     <!-- Advanced Amenities -->
                     <div class="searchBar-single px-3 py-3 border-bottom">
                        <div class="searchBar-single-title d-flex mb-3">
                           <h6 class="sidebar-subTitle fs-6 fw-medium m-0">Advanced Amenities</h6>
                        </div>
                        <div class="searchBar-single-wrap">
                           <ul class="row align-items-center justify-content-between p-0 gx-3 gy-2 mb-0">
                              <?php 
                              $advancedAmenities = [
                                  'Spa' => 'Spa & Wellness',
                                  'Restaurant' => 'Restaurant',
                                  'Bar' => 'Bar/Lounge',
                                  'Conference' => 'Conference Room',
                                  'Parking' => 'Parking',
                                  'Airport' => 'Airport Shuttle',
                                  'Pet' => 'Pet Friendly',
                                  'Business' => 'Business Center'
                              ];
                              foreach ($advancedAmenities as $value => $label):
                              ?>
                                 <li class="col-12">
                                    <div class="form-check">
                                       <input class="form-check-input amenity-filter" type="checkbox" name="amenities[]" id="amenity_<?= strtolower($value) ?>" value="<?= $value ?>" <?= in_array($value, $selectedAmenities) ? 'checked' : '' ?>>
                                       <label class="form-check-label" for="amenity_<?= strtolower($value) ?>"><?= $label ?></label>
                                    </div>
                                 </li>
                              <?php endforeach; ?>
                           </ul>
                        </div>
                     </div>

                     <!-- Filter Actions -->
                     <div class="searchBar-single px-3 py-3">
                        <div class="row">
                           <div class="col-6">
                              <button type="submit" class="btn btn-primary btn-sm full-width">Apply Filters</button>
                           </div>
                           <div class="col-6">
                              <a href="<?= base_url('/hotels') ?>" class="btn btn-light btn-sm full-width">Clear All</a>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>

         <div class="col-xl-9 col-lg-8 col-md-12">
            <div class="row align-items-center justify-content-between">
               <div class="col-xl-4 col-lg-4 col-md-4">
                  <h5 class="fw-bold fs-6 mb-lg-0 mb-3">
                     Showing <span id="results-count"><?= count($hotels ?? []) ?></span> of <span id="total-count"><?= $totalHotels ?? 0 ?></span> Hotels
                  </h5>
               </div>
               <div class="col-xl-8 col-lg-8 col-md-12">
                  <div class="d-flex align-items-center justify-content-start justify-content-lg-end flex-wrap">
                     <div class="flsx-first mt-sm-0 mt-2">
                        <ul class="nav nav-pills nav-fill p-1 small lights blukker bg-primary rounded-2 shadow-sm" id="filtersblocks" role="tablist">
                           <li class="nav-item" role="presentation">
                              <a href="<?= current_url() ?>?<?= http_build_query(array_merge($currentFilters, ['sort' => 'featured'])) ?>" class="nav-link rounded-1 <?= ($currentFilters['sort'] ?? 'featured') == 'featured' ? 'active' : '' ?>">Featured</a>
                           </li>
                           <li class="nav-item" role="presentation">
                              <a href="<?= current_url() ?>?<?= http_build_query(array_merge($currentFilters, ['sort' => 'rating'])) ?>" class="nav-link rounded-1 <?= ($currentFilters['sort'] ?? '') == 'rating' ? 'active' : '' ?>">Highest Rated</a>
                           </li>
                           <li class="nav-item" role="presentation">
                              <a href="<?= current_url() ?>?<?= http_build_query(array_merge($currentFilters, ['sort' => 'price_low'])) ?>" class="nav-link rounded-1 <?= ($currentFilters['sort'] ?? '') == 'price_low' ? 'active' : '' ?>">Lowest Price</a>
                           </li>
                           <li class="nav-item" role="presentation">
                              <a href="<?= current_url() ?>?<?= http_build_query(array_merge($currentFilters, ['sort' => 'price_high'])) ?>" class="nav-link rounded-1 <?= ($currentFilters['sort'] ?? '') == 'price_high' ? 'active' : '' ?>">Highest Price</a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>

            <div class="row align-items-center g-4 mt-2" id="hotels-container">
               <?php if (!empty($hotels)): ?>
                  <?php foreach ($hotels as $hotel): ?>
                     <div class="col-xl-12 col-lg-12 col-md-12 hotel-item" 
                          data-star="<?= $hotel['star_rating'] ?>"
                          data-price="<?= $hotel['price_per_night'] ?>"
                          data-destination="<?= $hotel['destination_id'] ?>"
                          data-featured="<?= $hotel['is_featured'] ?? 0 ?>"
                          data-amenities="<?= strtolower($hotel['amenities'] ?? '') ?>">
                        <div class="card list-layout-block rounded-3 p-3">
                           <div class="row">
                              <div class="col-xl-4 col-lg-3 col-md">
                                 <div class="cardImage__caps rounded-2 overflow-hidden h-100">
                                    <?php if (!empty($hotel['featured_image'])): ?>
                                       <img class="img-fluid h-100 object-fit" src="<?= base_url($hotel['featured_image']) ?>" alt="<?= esc($hotel['name']) ?>">
                                    <?php else: ?>
                                       <img class="img-fluid h-100 object-fit" src="https://placehold.co/400x300/e9ecef/6c757d?text=No+Image" alt="<?= esc($hotel['name']) ?>">
                                    <?php endif; ?>
                                 </div>
                              </div>
                              <div class="col-xl col-lg col-md">
                                 <div class="listLayout_midCaps mt-md-0 mt-3 mb-md-0 mb-3">
                                    <div class="d-flex align-items-center justify-content-start mb-1">
                                       <?php if (!empty($hotel['is_featured'])): ?>
                                          <span class="label bg-light-success text-success">Featured</span>
                                       <?php endif; ?>
                                    </div>
                                    <h4 class="fs-5 fw-bold mb-1"><?= esc($hotel['name']) ?></h4>
                                    <div class="d-flex align-items-center">
                                       <?php for ($i = 1; $i <= 5; $i++): ?>
                                          <i class="fa fa-star <?= $i <= $hotel['star_rating'] ? 'text-warning' : 'text-muted' ?>"></i>
                                       <?php endfor; ?>
                                       <span class="ms-2 text-muted"><?= $hotel['star_rating'] ?> Star Hotel</span>
                                    </div>
                                    <ul class="row p-0 excortio">
                                       <li class="col-auto">
                                          <p class="text-muted-2 text-md"><?= esc($hotel['destination_name'] ?? 'Location') ?></p>
                                       </li>
                                    </ul>
                                    <div class="detail ellipsis-container">
                                       <?php if (!empty($hotel['short_description'])): ?>
                                          <p class="text-muted mb-2"><?= esc($hotel['short_description']) ?></p>
                                       <?php endif; ?>
                                       <?php if (!empty($hotel['amenities'])): ?>
                                          <?php $amenities = explode(',', $hotel['amenities']); ?>
                                          <?php foreach (array_slice($amenities, 0, 5) as $amenity): ?>
                                             <span class="ellipsis"><?= esc(trim($amenity)) ?></span>
                                          <?php endforeach; ?>
                                       <?php endif; ?>
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
                                       <div class="square--40 rounded-2 bg-warning text-light">4.<?= $hotel['star_rating'] ?></div>
                                    </div>
                                 </div>
                                 <div class="position-relative mt-auto full-width">
                                    <div class="d-flex align-items-center justify-content-start justify-content-md-end mb-1">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-start justify-content-md-end">
                                       <div class="text-dark fw-bold fs-3">₹<?= number_format($hotel['price_per_night'], 0) ?></div>
                                    </div>
                                    <div class="text-end mb-2">
                                       <small class="text-muted">per night</small>
                                    </div>
                                    <div class="d-flex align-items-start align-items-md-end text-start text-md-end flex-column">
                                       <a href="<?= base_url('/hotels/' . ($hotel['slug'] ?? $hotel['id'])) ?>" class="btn btn-md btn-primary full-width fw-medium px-lg-4">
                                          View Details<i class="fa-solid fa-arrow-trend-up ms-2"></i>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  <?php endforeach; ?>
               <?php else: ?>
                  <div class="col-12">
                     <div class="text-center py-5">
                        <i class="fas fa-building fa-3x text-muted mb-3"></i>
                        <h3 class="text-muted">No hotels found</h3>
                        <p class="text-muted">Try adjusting your search criteria.</p>
                     </div>
                  </div>
               <?php endif; ?>

               <!-- Pagination -->
               <?php if (!empty($pager) && $pager->getPageCount() > 1): ?>
                  <div class="col-xl-12 col-lg-12 col-12">
                     <div class="pags py-2 px-5">
                        <nav aria-label="Page navigation example">
                           <ul class="pagination m-0 p-0">
                              <?php 
                              $currentPage = $pager->getCurrentPage();
                              $totalPages = $pager->getPageCount();
                              $currentFilters = http_build_query(array_filter($currentFilters ?? []));
                              $baseUrl = current_url() . ($currentFilters ? '?' . $currentFilters . '&page=' : '?page=');
                              ?>
                              
                              <!-- Previous Button -->
                              <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                 <?php if ($currentPage > 1): ?>
                                    <a class="page-link" href="<?= $baseUrl . ($currentPage - 1) ?>" aria-label="Previous">
                                       <span aria-hidden="true"><i class="fa-solid fa-arrow-left-long"></i></span>
                                    </a>
                                 <?php else: ?>
                                    <a class="page-link" href="#" aria-label="Previous">
                                       <span aria-hidden="true"><i class="fa-solid fa-arrow-left-long"></i></span>
                                    </a>
                                 <?php endif; ?>
                              </li>
                              
                              <!-- Page Numbers (show up to 5 pages) -->
                              <?php
                              $startPage = max(1, $currentPage - 2);
                              $endPage = min($totalPages, $startPage + 4);
                              $startPage = max(1, $endPage - 4);
                              
                              for ($i = $startPage; $i <= $endPage; $i++):
                              ?>
                                 <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= $i == $currentPage ? '#' : $baseUrl . $i ?>"><?= $i ?></a>
                                 </li>
                              <?php endfor; ?>
                              
                              <!-- Next Button -->
                              <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                 <?php if ($currentPage < $totalPages): ?>
                                    <a class="page-link" href="<?= $baseUrl . ($currentPage + 1) ?>" aria-label="Next">
                                       <span aria-hidden="true"><i class="fa-solid fa-arrow-right-long"></i></span>
                                    </a>
                                 <?php else: ?>
                                    <a class="page-link" href="#" aria-label="Next">
                                       <span aria-hidden="true"><i class="fa-solid fa-arrow-right-long"></i></span>
                                    </a>
                                 <?php endif; ?>
                              </li>
                           </ul>
                        </nav>
                     </div>
                  </div>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit sidebar form when filters change
    const sidebarForm = document.getElementById('sidebar-filters-form');
    const filterInputs = sidebarForm.querySelectorAll('input[type="checkbox"], input[type="number"], input[type="text"]');
    
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Small delay to allow for multiple quick changes
            setTimeout(() => {
                sidebarForm.submit();
            }, 300);
        });
        
        // For text inputs, also listen for keyup with debounce
        if (input.type === 'text') {
            let timeout;
            input.addEventListener('keyup', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    sidebarForm.submit();
                }, 1000); // 1 second delay for text inputs
            });
        }
    });
    
    // Update hidden fields in sidebar form when search form values change
    const searchForm = document.querySelector('form[action*="/hotels"]');
    const hiddenInputs = sidebarForm.querySelectorAll('input[type="hidden"]');
    
    if (searchForm) {
        const searchInputs = searchForm.querySelectorAll('select, input');
        searchInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Update corresponding hidden field
                const hiddenField = sidebarForm.querySelector(`input[name="${this.name}"]`);
                if (hiddenField) {
                    hiddenField.value = this.value;
                }
            });
        });
    }
});
</script>

<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>