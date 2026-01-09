<?php include APPPATH . 'Views/layouts/public_header.php'; ?>
<div class="image-cover hero-header" style="background:url(main/images/home-img/banner-02.webp) no-repeat center center/cover;" data-overlay="6">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-xl-9 col-lg-10 col-md-12 text-left">
            <div class="hero-content-wrap mb-5">
               <h2 class="apw-heroCursive">Experience Unmatched Delight With Us</h2>
               <h1 class="text-white fw-bold display-4 mb-3">Explore The World Around You</h1>
               <p class=" fs-5 text-light opacity-75 ind">
                  Book trusted tour packages for India and abroad with guaranteed best prices and 24×7 support.
               </p>
               <div class="apw-heroBtns">
                  <a href="#get-started" class="apw-heroBtn apw-heroBtn--primary">
                  Let's Get Started <span class="apw-heroArrow">→</span>
                  </a>
                  <a href="#discover-more" class="apw-heroBtn apw-heroBtn--ghost">
                  Discover More <span class="apw-heroArrow">→</span>
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="hero-search-container">
   <div class="custom-search-wrap">
      <form class="row align-items-center g-0" action="<?= base_url('/hotels') ?>" method="GET">
         <div class="col-lg-5 col-md-12">
            <div class="search-item">
               <label><i class="fas fa-map-marker-alt text-warning me-2"></i>Location</label>
               <select class="form-select border-0 bg-transparent fw-bold p-0 shadow-none" name="destination_id">
                  <option selected disabled>Where are you going?</option>
                  <?php if (!empty($allDestinations)): ?>
                  <?php foreach ($allDestinations as $destination): ?>
                  <option value="<?= $destination['id'] ?>"><?= esc($destination['name']) ?></option>
                  <?php endforeach; ?>
                  <?php else: ?>
                  <option>Char Dham Yatra</option>
                  <option>Thailand</option>
                  <option>Goa</option>
                  <option>Himachal</option>
                  <?php endif; ?>
               </select>
            </div>
         </div>
         <div class="col-lg-4 col-md-12">
            <div class="search-item">
               <label><i class="fas fa-box text-warning me-2"></i>Packages</label>
               <select class="form-select border-0 bg-transparent fw-bold p-0 shadow-none">
                  <option selected disabled>Select Package Type</option>
                  <option>Group Tours</option>
                  <option>Family Packages</option>
                  <option>Honeymoon Specials</option>
                  <option>Budget Tours</option>
               </select>
            </div>
         </div>
         <div class="col-lg-3 col-md-12 ps-lg-3">
            <button type="submit" class="btn-deals-main shadow-sm w-100">
            <i class="fa-solid fa-magnifying-glass me-2"></i>Search
            </button>
         </div>
      </form>
   </div>
</div>
<section class="domestic-section">
   <div class="domestic-header">
      <h2>International Destinations</h2>
      <div class="header-controls">
         <div class="nav-arrows">
            <button class="arrow-btn btn-left" aria-label="Scroll Left"><i class="fas fa-chevron-left"></i></button>
            <button class="arrow-btn btn-right" aria-label="Scroll Right"><i class="fas fa-chevron-right"></i></button>
         </div>
         <a href="<?= base_url('/hotels?destination_type=2') ?>" class="view-all-link" id="viewAllBtn">View All</a>
      </div>
   </div>
   <div class="destination-tabs">
      <?php if (!empty($internationalDestinations)): ?>
      <?php foreach (array_slice($internationalDestinations, 0, 9) as $index => $destination): ?>
      <button class="tab-btn <?= $index === 0 ? 'active' : '' ?>" data-region="dest-<?= $destination['id'] ?>"><?= esc($destination['name']) ?></button>
      <?php endforeach; ?>
      <?php else: ?>
      <div class="alert alert-warning text-center">
         <small>No international destinations available at the moment.</small>
      </div>
      <?php endif; ?>
   </div>
   <div class="destination-grid" id="destinationGrid">
      <?php if (!empty($internationalHotels)): ?>
      <?php foreach ($internationalHotels as $index => $hotel): ?>
      <?php
        $themes = ['theme-blue-gray', 'theme-navy', 'theme-green', 'theme-orange'];
        $theme = $themes[$index % count($themes)];
        $region = 'dest-' . ($hotel['destination_id'] ?? 'default');
        $isVisible = $index < 4 ? 'visible' : '';
        ?>
      <div class="dest-card <?= $region ?> <?= $isVisible ?>">
         <div class="dest-img">
            <?php if (!empty($hotel['featured_image'])): ?>
            <img src="<?= base_url($hotel['featured_image']) ?>" alt="<?= esc($hotel['name']) ?>">
            <?php else: ?>
            <img src="<?= esc($defaultImageUrl) ?>" alt="<?= esc($hotel['name']) ?>">
            <?php endif; ?>
            <h3><?= esc($hotel['name']) ?></h3>
         </div>
         <div class="dest-details <?= $theme ?>">
            <div class="dest-info-row">
               <span class="duration-badge"><?= $hotel['star_rating'] ?? 3 ?> Star</span>
               <span class="location-text"><?= esc($hotel['destination_name'] ?? 'Hotel') ?></span>
            </div>
            <ul class="tour-highlights">
               <?php if (!empty($hotel['short_description'])): ?>
               <li><?= esc(substr($hotel['short_description'], 0, 50)) ?>...</li>
               <?php endif; ?>
               <?php if (!empty($hotel['amenities'])): ?>
               <?php
            $amenities = explode(',', $hotel['amenities']);
            $topAmenities = array_slice($amenities, 0, 2);
            ?>
               <?php foreach ($topAmenities as $amenity): ?>
               <li><?= esc(trim($amenity)) ?></li>
               <?php endforeach; ?>
               <?php else: ?>
               <li>Comfortable accommodation</li>
               <li>Great amenities</li>
               <?php endif; ?>
            </ul>
            <div class="dest-pricing">
               <div class="price-box">
                  <span class="new-price">₹<?= number_format($hotel['price_per_night'] ?? 3999, 0) ?>/-</span>
               </div>
               <a href="<?= base_url('/hotels/' . ($hotel['slug'] ?? $hotel['id'])) ?>" class="view-details">View Details</a>
            </div>
         </div>
      </div>
      <?php endforeach; ?>
      <?php else: ?>
      <!-- No hotels available message -->
      <div class="col-12 text-center py-5">
         <div class="alert alert-info">
            <h5>No International Hotels Available</h5>
            <p>Please check back later for exciting international hotel deals!</p>
         </div>
      </div>
      <?php endif; ?>
   </div>
</section>
<section class="offers-section">
   <h2 class="offers-title">Best offers exclusively for you!</h2>
   <div class="offers-grid">
      <div class="offer-card slider-container">
         <div class="slider-wrapper" id="europeSlider">
            <div class="slide active">
               <img src="main/images/young-woman-taking-photo-with-her-phone-beautiful-mountain-view.jpg" alt="Europe 1">
            </div>
            <div class="slide">
               <img src="main/images/beautiful-landscape.jpg" alt="Europe 2">
            </div>
         </div>
         <button class="arrow prev1" onclick="changeSlide(-1)"><i class="fas fa-chevron-left"></i></button>
         <button class="arrow next1" onclick="changeSlide(1)"><i class="fas fa-chevron-right"></i></button>
         <div class="label-top">Rishikesh</div>
         <div class="yellow-bar">Starting Rs 1,35,500</div>
      </div>
      <div class="offer-card">
         <img src="main/images/ski-resort-winter-tourism-mountains.jpg" alt="Hong Kong">
         <div class="label-center">
            <h3>Manali</h3>
            <div class="price-tag">Starting Rs.</div>
         </div>
      </div>
      <div class="offer-card">
         <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=500" alt="Japan">
         <div class="label-center">
            <h3>Switzerland and Paris</h3>
            <small style="display:block; margin-top:5px;">Wonders of Switzerland and Paris
            </small>
            <div class="price-tag">Rs 1,35,500</div>
         </div>
      </div>
   </div>
</section>
<section class="themes-section">
   <div class="themes-header">
      <div class="header-left">
         <h2 class="themes-title" style="font-size:22px;">Where Travel Meets Spirituality</h2>
         <div class="themes-tabs">
            <button class="theme-tab active" data-theme="adventure">Adventure</button>
            <button class="theme-tab" data-theme="newyear">New Year</button>
            <button class="theme-tab" data-theme="christmas">Christmas</button>
         </div>
      </div>
      <div class="nav-arrows">
         <button class="arrow-btn" id="slideLeft"><i class="fas fa-chevron-left"></i></button>
         <button class="arrow-btn" id="slideRight"><i class="fas fa-chevron-right"></i></button>
      </div>
   </div>
   <div class="themes-slider" id="themesSlider"></div>
</section>
<section class="hs-hero-slider">
   <div class="hs-slider-container">
      <div class="hs-image-wrapper">
         <div class="hs-slide hs-active">
            <img src="main/images/golden-pavilion-kinkakuji-temple-autumn-kyoto-japan.jpg" alt="Japan">
            <div class="hs-content-overlay">
               <h1 class="hs-main-title">Best of Japan</h1>
               <div class="hs-partner-row">
                  <div class="hs-separator"></div>
                  <span class="hs-partner-text">Ancient Shrines & Neon Lights</span>
               </div>
            </div>
         </div>
         <div class="hs-slide">
            <img src="main/images/MapBasic133.png" alt="South Korea">
            <div class="hs-content-overlay">
               <h1 class="hs-main-title">Instagrammable Singapore</h1>
               <div class="hs-partner-row">
                  <div class="hs-separator"></div>
                  <span class="hs-partner-text"> Marina Bay Sands Skypark</span>
               </div>
            </div>
         </div>
         <div class="hs-slide">
            <img src="main/images/MapBasic157.png" alt="Autumn Special">
            <div class="hs-content-overlay">
               <h1 class="hs-main-title"> Discover <br>Japan</h1>
               <div class="hs-partner-row">
                  <i class="fa-solid fa-leaf" style="color: #FF9800; font-size: 24px;"></i>
                  <div class="hs-separator"></div>
                  <span class="hs-partner-text"></span>
               </div>
            </div>
         </div>
      </div>
      <button class="hs-arrow hs-prev" aria-label="Previous Slide"><i class="fa-solid fa-chevron-left"></i></button>
      <button class="hs-arrow hs-next" aria-label="Next Slide"><i class="fa-solid fa-chevron-right"></i></button>
      <div class="hs-pagination">
         <span class="hs-dot hs-active"></span>
         <span class="hs-dot"></span>
         <span class="hs-dot"></span>
      </div>
   </div>
</section>
<section class="seasonal-mood-wrapper" id="SeasonalSection">
   <div class="sotc-container">
      <div class="section-header">
         <h2>Not Sure When or Where to Travel?</h2>
         <div class="filter-tabs">
            <button class="filter-btn" data-season="winter">
            <i class="fas fa-snowflake"></i> Winter
            </button>
            <button class="filter-btn active" data-season="summer">
            <i class="fas fa-sun"></i> Summer
            </button>
            <button class="filter-btn" data-season="monsoon">
            <i class="fas fa-cloud-rain"></i> Monsoon
            </button>
         </div>
      </div>
      <div class="mood-grid">
         <div class="mood-info-panel">
            <div class="mood-content active" id="summer-text">
               <h3>Sunshine Escapes & Signature Summer Tours</h3>
               <p>
                  Explore vibrant beach breaks, cultural city tours, and international escapes with My Fair Holidays. 
                  Our expertly curated summer packages offer you perfect weather, unforgettable experiences and 
                  great deals — whether you’re travelling with family, friends or on a honeymoon. 
               </p>
            </div>
            <div class="mood-content" id="winter-text">
               <h3>Winter Wonders & Cool Getaways</h3>
               <p>
                  Discover snow-kissed mountain retreats, festive city tours and serene winter escapes across India 
                  and abroad. From Himachal and Rajasthan to Europe and Asia, our winter packages blend comfort, 
                  culture and adventure in one seamless experience.
               </p>
            </div>
            <div class="mood-content" id="monsoon-text">
               <h3>Monsoon Magic & Lush Nature Trails</h3>
               <p>
                  Let the rains take you to lush landscapes and offbeat retreats. Our monsoon holiday ideas bring you 
                  closer to nature with rejuvenating hill station escapes, scenic drives and cultural experiences. 
                  Monsoon is perfect for peaceful stays, romantic moments, and refreshing breaks.
               </p>
            </div>
         </div>
         <div class="packages-wrapper">
            <button class="scroll-btn left" id="scrollLeft">
            <i class="fas fa-chevron-left"></i>
            </button>
            <div class="packages-container">
               <div class="package-card active" data-season="summer">
                  <img src="main/images/woman-holding-man.jpg" alt="Thailand">
                  <div class="card-body">
                     <h4>Simply Thailand Special</h4>
                     <div class="card-footer">
                        <span class="days">5 Days</span>
                        <span class="price">₹ 50,840</span>
                     </div>
                  </div>
               </div>
               <div class="package-card active" data-season="summer">
                  <img src="main/images/couple-with-rose-their-faces-smiling-with-lake-background.jpg" alt="Bali">
                  <div class="card-body">
                     <h4>Wonderful Bali - Honeymoon Special</h4>
                     <div class="card-footer">
                        <span class="days">5 Days</span>
                        <span class="price">₹ 26,562</span>
                     </div>
                  </div>
               </div>
               <div class="package-card active" data-season="summer">
                  <img src="main/images/portrait-woman-visiting-luxurious-city-dubai.jpg" alt="Dubai">
                  <div class="card-body">
                     <h4>Truly Dubai Getaway</h4>
                     <div class="card-footer">
                        <span class="days">6 Days</span>
                        <span class="price">₹ 29,556</span>
                     </div>
                  </div>
               </div>
               <div class="package-card" data-season="winter">
                  <img src="https://www.sotc.in/images/homePageRevamp/Finland-Winter.jpg" alt="Finland">
                  <div class="card-body">
                     <h4>Best of Finland Winter Special</h4>
                     <div class="card-footer">
                        <span class="days">8 Days</span>
                        <span class="price">₹ 4,41,672</span>
                     </div>
                  </div>
               </div>
               <div class="package-card" data-season="winter">
                  <img src="main/images/young-woman-walking-market-with-trees.jpg" alt="Singapore">
                  <div class="card-body">
                     <h4>Premium Singapore Winter</h4>
                     <div class="card-footer">
                        <span class="days">5 Days</span>
                        <span class="price">₹ 1,18,919</span>
                     </div>
                  </div>
               </div>
               <div class="package-card" data-season="winter">
                  <img src="main/images/view-mountain-with-dreamy-aesthetic.jpg" alt="Himachal">
                  <div class="card-body">
                     <h4>Heavenly Himachal - Snowy Peaks</h4>
                     <div class="card-footer">
                        <span class="days">7 Days</span>
                        <span class="price">₹ 48,900</span>
                     </div>
                  </div>
               </div>
               <div class="package-card" data-season="monsoon">
                  <img src="main/images/scene-with-diverse-young.jpg" alt="Wayanad">
                  <div class="card-body">
                     <h4>Short Break to Wayanad with Taj Hotels</h4>
                     <div class="card-footer">
                        <span class="days">3 Days</span>
                        <span class="price">₹ 30,890</span>
                     </div>
                  </div>
               </div>
               <div class="package-card" data-season="monsoon">
                  <img src="main/images/woman-wearing-hill-tribe.jpg" alt="Munnar">
                  <div class="card-body">
                     <h4>Munnar Calling - Lush Greenery</h4>
                     <div class="card-footer">
                        <span class="days">4 Days</span>
                        <span class="price">₹ 13,300</span>
                     </div>
                  </div>
               </div>
               <div class="package-card" data-season="monsoon">
                  <img src="main/images/girl-walks-umbrella-rainy-weather-bridge-forest.jpg" alt="Lonavala">
                  <div class="card-body">
                     <h4>Scenic Lonavala with Mumbai Rains</h4>
                     <div class="card-footer">
                        <span class="days">5 Days</span>
                        <span class="price">₹ 31,240</span>
                     </div>
                  </div>
               </div>
            </div>
            <button class="scroll-btn right" id="scrollRight">
            <i class="fas fa-chevron-right"></i>
            </button>
         </div>
      </div>
   </div>
</section>
<section id="mfh-dom-unique-01" class="mfh-domestic-section">
   <div class="mfh-domestic-header">
      <h2>Domestic Destination</h2>
      <div class="mfh-header-controls">
         <div class="mfh-nav-arrows">
            <button type="button" class="mfh-arrow-btn mfh-left-ctrl"><i class="fa-solid fa-chevron-left"></i></button>
            <button type="button" class="mfh-arrow-btn mfh-right-ctrl"><i class="fa-solid fa-chevron-right"></i></button>
         </div>
         <a href="<?= base_url('/hotels?destination_type=1') ?>" class="mfh-view-all-trigger">View All</a>
      </div>
   </div>
   <div class="mfh-tabs-row">
      <?php if (!empty($domesticDestinations)): ?>
      <?php foreach (array_slice($domesticDestinations, 0, 8) as $index => $destination): ?>
      <button type="button" class="mfh-tab-item <?= $index === 0 ? 'mfh-active' : '' ?>" data-region="dom-<?= $destination['id'] ?>"><?= esc($destination['name']) ?></button>
      <?php endforeach; ?>
      <?php else: ?>
      <div class="alert alert-warning text-center">
         <small>No domestic destinations available at the moment.</small>
      </div>
      <?php endif; ?>
   </div>
   <div class="mfh-destination-track mfh-scroll-box">
   <?php if (!empty($domesticHotels)): ?>
   <?php foreach ($domesticHotels as $index => $hotel): ?>
   <?php
        $themes = ['theme-blue-gray', 'theme-navy', 'theme-green', 'theme-orange'];
        $theme = $themes[$index % count($themes)];
        $region = 'dom-' . ($hotel['destination_id'] ?? 'default');
        $isVisible = $index < 4 ? 'mfh-visible' : '';
        ?>
   <div class="mfh-card <?= $region ?> <?= $isVisible ?>">
      <div class="mfh-img-top">
         <?php if (!empty($hotel['featured_image'])): ?>
         <img src="<?= base_url($hotel['featured_image']) ?>" alt="<?= esc($hotel['name']) ?>">
         <?php else: ?>
         <img src="<?= esc($defaultImageUrl) ?>" alt="<?= esc($hotel['name']) ?>">
         <?php endif; ?>
         <h3><?= esc($hotel['name']) ?></h3>
      </div>
      <div class="mfh-details <?= $theme ?>">
         <div class="mfh-meta-badge">
            <span><?= $hotel['star_rating'] ?? 3 ?> Star</span>
            <span><?= esc($hotel['destination_name'] ?? 'Hotel') ?></span>
         </div>
         <ul class="mfh-list">
            <?php if (!empty($hotel['short_description'])): ?>
            <li><?= esc(substr($hotel['short_description'], 0, 40)) ?>...</li>
            <?php endif; ?>
            <?php if (!empty($hotel['amenities'])): ?>
            <?php
            $amenities = explode(',', $hotel['amenities']);
            $topAmenity = trim($amenities[0] ?? 'Great amenities');
            ?>
            <li><?= esc($topAmenity) ?></li>
            <?php else: ?>
            <li>Comfortable stay & amenities</li>
            <?php endif; ?>
         </ul>
         <div class="mfh-card-footer">
            <span class="mfh-price-tag">₹<?= number_format($hotel['price_per_night'] ?? 3999, 0) ?>/-</span>
            <a href="<?= base_url('/hotels/' . ($hotel['slug'] ?? $hotel['id'])) ?>" class="mfh-details-btn">View Details</a>
         </div>
      </div>
   </div>
   <?php endforeach; ?>
   <?php else: ?>
   <!-- No hotels available message -->
   <div class="col-12 text-center py-5">
      <div class="alert alert-info">
         <h5>No Domestic Hotels Available</h5>
         <p>Please check back later for exciting domestic hotel deals!</p>
      </div>
   </div>
   <?php endif; ?>
</section>
<section class="where-to-go-section" id="WhereToGo">
   <div class="container custom-1200">
      <h2 class="section-title">Where To Go When</h2>
      <div class="month-tabs-nav">
         <ul class="month-list" id="monthTabs">
            <li class="month-item active" data-month="jan">JAN</li>
            <li class="month-item" data-month="feb">FEB</li>
            <li class="month-item" data-month="mar">MAR</li>
            <li class="month-item" data-month="apr">APR</li>
            <li class="month-item" data-month="may">MAY</li>
            <li class="month-item" data-month="jun">JUN</li>
            <li class="month-item" data-month="jul">JUL</li>
            <li class="month-item" data-month="aug">AUG</li>
            <li class="month-item" data-month="sep">SEP</li>
            <li class="month-item" data-month="oct">OCT</li>
            <li class="month-item" data-month="nov">NOV</li>
            <li class="month-item" data-month="dec">DEC</li>
         </ul>
      </div>
      <div class="row">
         <div class="col-lg-8">
            <div class="d-flex justify-content-end mb-3">
               <div class="nav-icon-wrapper">
                  <button class="arrow-btn-gray" onclick="scrollDest(-280)"><i class="fas fa-chevron-left"></i></button>
                  <button class="arrow-btn-gray" onclick="scrollDest(280)"><i class="fas fa-chevron-right"></i></button>
               </div>
            </div>
         </div>
      </div>
      <div class="row align-items-start g-4">
         <div class="new-section1">
            <div class="dest-scroll-container" id="destContainer">
               <div class="dest-mini-card filter-item jan active">
                  <img src="main/images/14.jpg" alt="Maldives">
                  <div class="price-overlay">Maldives <strong>₹51,503/-</strong></div>
               </div>
               <div class="dest-mini-card filter-item jan active">
                  <img src="main/images/15.jpg" alt="Australia">
                  <div class="price-overlay">Australia <strong>₹38,894/-</strong></div>
               </div>
               <div class="dest-mini-card filter-item jan active">
                  <img src="main/images/16.jpg" alt="Thailand">
                  <div class="price-overlay">Thailand <strong>₹14,040/-</strong></div>
               </div>
               <div class="dest-mini-card filter-item jan active">
                  <img src="main/images/18.jpg" alt="New Zealand">
                  <div class="price-overlay">New Zealand <strong>₹65,626/-</strong></div>
               </div>
               <div class="dest-mini-card filter-item jan active">
                  <img src="main/images/18.jpg" alt="New Zealand">
                  <div class="price-overlay">New Zealand <strong>₹65,626/-</strong></div>
               </div>
               <div class="dest-mini-card filter-item feb">
                  <img src="main/images/16.jpg" alt="Thailand">
                  <div class="price-overlay">Thailand <strong>₹14,040/-</strong></div>
               </div>
               <div class="dest-mini-card filter-item feb">
                  <img src="main/images/16.jpg" alt="Thailand">
                  <div class="price-overlay">Thailand <strong>₹14,040/-</strong></div>
               </div>
            </div>
         </div>
         <div class="col-lg-4 d-none d-lg-block">
            <div class="butterfly-collage">
               <div class="bubble-item b-large"><img src="main/images/17.jpg"></div>
               <div class="bubble-item b-medium"><img src="main/images/14.jpg"></div>
               <div class="bubble-item b-small"><img src="main/images/15.jpg"></div>
               <div class="bubble-item b-tiny"><img src="main/images/16.jpg"></div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="mfh-why-choose-us">
   <h2 class="mfh-section-title">Why to choose Holidays with us</h2>
   <div class="mfh-container">
      <div class="mfh-feature-box">
         <div class="mfh-feature-item">
            <div class="mfh-icon-wrap">
               <img src="main/img/ticket.png" alt="Easy Booking" class="mfh-feature-icon">
            </div>
            <div class="mfh-feature-content">
               <h3>Easy Booking</h3>
               <p>Book online within minutes.</p>
            </div>
         </div>
         <div class="mfh-v-line"></div>
         <div class="mfh-feature-item">
            <div class="mfh-icon-wrap">
               <img src="main/img/best-price.png" alt="Best Price" class="mfh-feature-icon">
            </div>
            <div class="mfh-feature-content">
               <h3>Best Price Guarantee</h3>
               <p>Competitive rates & exclusive weekly deals.</p>
            </div>
         </div>
         <div class="mfh-v-line"></div>
         <div class="mfh-feature-item">
            <div class="mfh-icon-wrap">
               <img src="main/img/customer-support.png" alt="Global Network" class="mfh-feature-icon">
            </div>
            <div class="mfh-feature-content">
               <h3>Global Network</h3>
               <p>150+ Offices around the world.</p>
            </div>
         </div>
         <div class="mfh-v-line"></div>
         <div class="mfh-feature-item">
            <div class="mfh-icon-wrap">
               <img src="main/img/24-hours-service.png" alt="24/7 Support" class="mfh-feature-icon">
            </div>
            <div class="mfh-feature-content">
               <h3>24/7 Support</h3>
               <p>Round-the-clock assistance anytime, anywhere.</p>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="review-section">
   <div class="review-container">
      <div class="review-header">
         <h2>Dear travelers,<br>we are grateful for being a part of your lifetime memories!</h2>
      </div>
      <div class="review-wrapper">
         <button class="slider-btn slider-prev">
         <i class="fa-solid fa-chevron-left"></i>
         </button>
         <div class="review-slider">
            <div class="review-card">
               <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80">
               <div class="card-body">
                  <div class="user-meta">
                     <div class="user-name">Paul & Marie</div>
                     <i class="fa-brands fa-google google-icon"></i>
                  </div>
                  <div class="rating">★★★★★</div>
                  <div class="review-content">
                     <p class="review-text">
                        My Fair Holidays is the most professional travel company we have ever dealt with.
                        They provided a unique travel experience we could not have achieved on our own.
                        Their in depth knowledge and connections locally gave us access to places and activities.
                     </p>
                     <span class="read-more-btn">Read More</span>
                  </div>
               </div>
            </div>
            <div class="review-card">
               <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=600&q=80">
               <div class="card-body">
                  <div class="user-meta">
                     <div class="user-name">Lynda Sykes</div>
                     <i class="fa-brands fa-google google-icon"></i>
                  </div>
                  <div class="rating">★★★★★</div>
                  <div class="review-content">
                     <p class="review-text">
                        My Fair Holidays delivers an amazing travel experience!
                        Overall we were really happy how everything was handled.
                        Knowing someone was physically there shows dedication.
                     </p>
                     <span class="read-more-btn">Read More</span>
                  </div>
               </div>
            </div>
            <div class="review-card">
               <img src="https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=800&q=80">
               <div class="card-body">
                  <div class="user-meta">
                     <div class="user-name">Corrine and Daniel Elston</div>
                     <i class="fa-brands fa-google google-icon"></i>
                  </div>
                  <div class="rating">★★★★★</div>
                  <div class="review-content">
                     <p class="review-text">
                        Having My Fair Holidays is like having a personal assistant a phone call away. The experience overall was excellent, excellent, excellent. All of the apartments and restaurants recommendations were great. The mobile phones are a great idea.
                     </p>
                     <span class="read-more-btn">Read More</span>
                  </div>
               </div>
            </div>
         </div>
         <button class="slider-btn slider-next">
         <i class="fa-solid fa-chevron-right"></i>
         </button>
      </div>
   </div>
   <div class="view-all">
      <button>View All Reviews</button>
   </div>
</section>
<section class="gallery-section">
   <div class="gallery-inner">
      <div class="gallery-header">
         <span class="sub-title">Gallery</span>
         <h2>Explore Beautiful Destinations</h2>
      </div>
      <div class="gallery-wrapper">
         <div class="nav-arrow prev">‹</div>
         <div class="gallery-container">
            <?php if (!empty($galleryImages)): ?>
            <?php foreach ($galleryImages as $image): ?>
            <div class="gallery-item">
               <img src="<?= base_url($image['image_path']) ?>" 
                  alt="<?= esc($image['alt_text'] ?? $image['hotel_name'] ?? 'Gallery Image') ?>"
                  title="<?= esc($image['caption'] ?? $image['hotel_name'] ?? '') ?>">
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <?php for ($i = 1; $i <= 6; $i++): ?>
            <div class="gallery-item">
               <img src="<?= base_url('custom/default_image.png') ?>" alt="Default Gallery Image <?= $i ?>">
            </div>
            <?php endfor; ?>
            <?php endif; ?>
         </div>
         <div class="nav-arrow next">›</div>
      </div>
   </div>
</section>
<section class="banner-section">
   <img 
      src="main/images/travel.png"
      alt="Promotional Banner"
      loading="lazy"
      >
</section>
<section class="gram-section">
   <div class="container">
      <div class="gram-header text-center mb-5">
         <h2 class="gram-main-title">Love From The Gram <span class="heart-icon">❤️</span></h2>
         <div class="gram-trust-badges d-flex justify-content-center gap-4 mt-3">
            <div class="badge-item d-flex align-items-center gap-2">
               <img src="https://www.gstatic.com/images/branding/product/1x/googleg_48dp.png" width="24" alt="Google">
               <div class="text-start">
                  <div class="badge-stats">4.6<span class="opacity-50">/5</span> <span class="text-warning">★</span></div>
                  <p class="badge-count">8400+ reviews</p>
               </div>
            </div>
            <div class="badge-item d-flex align-items-center gap-2 border-start ps-4">
               <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg" width="24" alt="FB">
               <div class="text-start">
                  <div class="badge-stats">4.8<span class="opacity-50">/5</span> <span class="text-warning">★</span></div>
                  <p class="badge-count">1440+ reviews</p>
               </div>
            </div>
         </div>
      </div>
      <div class="gram-slider-wrapper position-relative">
         <button class="gram-nav-btn prev" id="gramPrev"><i class="fa-solid fa-chevron-left"></i></button>
         <button class="gram-nav-btn next" id="gramNext"><i class="fa-solid fa-chevron-right"></i></button>
         <div class="gram-container" id="gramSlider">
            <div class="gram-card-item">
               <div class="gram-arch-frame">
                  <img src="main/images/portrait-overweight-couple-traveling-world-world-tourism-day.jpg" alt="Maldives">
                  <div class="gram-overlay">
                     <span class="gram-label-small">STARRING</span>
                     <div class="gram-sticker">Roobal & Anjali</div>
                  </div>
               </div>
               <div class="gram-footer text-center mt-3">
                  <h5 class="gram-main-title1">Roobal & Anjali</h5>
                  <span class="gram-location">Maldives</span>
               </div>
            </div>
            <div class="gram-card-item">
               <div class="gram-arch-frame">
                  <img src="main/images/young-woman-taking-photo-with-her-phone-beautiful-mountain-view.jpg" alt="Bali">
                  <div class="gram-overlay flex-center">
                     <div class="gram-sticker">I'm here today in Bali.</div>
                  </div>
               </div>
               <div class="gram-footer text-center mt-3">
                  <h5 class="gram-main-title1">Sai Sree</h5>
                  <span class="gram-location">Bali</span>
               </div>
            </div>
            <div class="gram-card-item">
               <div class="gram-arch-frame">
                  <img src="main/images/portrait-woman-visiting-luxurious-city-dubai.jpg" alt="Dubai">
                  <div class="gram-overlay">
                     <span class="gram-label-small">STARRING</span>
                     <div class="gram-sticker">Pranav & Anjali</div>
                  </div>
               </div>
               <div class="gram-footer text-center mt-3">
                  <h5 class="gram-main-title1">Pranav & Anjali</h5>
                  <span class="gram-location">Dubai</span>
               </div>
            </div>
            <div class="gram-card-item">
               <div class="gram-arch-frame">
                  <img src="main/images/group-friends-searching-location-through-binoculars-map.jpg" alt="Dubai">
                  <div class="gram-overlay flex-center gap-5">
                     <div class="gram-sticker">Ayush Gupta & family</div>
                     <div class="gram-sticker bg-success">Dubai</div>
                  </div>
               </div>
               <div class="gram-footer text-center mt-3">
                  <h5 class="gram-main-title1">Ayusha Gupta Family</h5>
                  <span class="gram-location">Dubai</span>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="mfh-blog-section">
   <div class="mfh-blog-container">
      <p class="mfh-blog-subtitle">OUR NEWS & BLOG</p>
      <div class="d-flex justify-content-between align-items-center mb-4">
         <h2 class="mfh-blog-title mb-0">News, Tips, Guides and Articles</h2>
         <div class="view-all">
            <button><a href="<?= base_url('/blog') ?>" >View All Reviews</a></button>
         </div>
      </div>
      <div class="mfh-blog-grid">
         <?php if (!empty($blogPosts)): ?>
         <?php foreach ($blogPosts as $post): ?>
         <div class="mfh-blog-card">
            <div class="mfh-blog-img">
               <?php if (!empty($post['featured_image'])): ?>
               <img src="<?= base_url($post['featured_image']) ?>" alt="<?= esc($post['title']) ?>">
               <?php else: ?>
               <img src="<?= base_url('custom/default_image.png') ?>" alt="<?= esc($post['title']) ?>">
               <?php endif; ?>
               <div class="mfh-blog-meta">
                  <span><i class="far fa-calendar-alt"></i> <?= date('d F, Y', strtotime($post['created_at'])) ?></span>
                  <span class="mfh-meta-separator">—</span>
                  <span>Travel</span>
               </div>
            </div>
            <div class="mfh-blog-content">
               <h3><?= esc($post['title']) ?></h3>
               <p><?= esc(substr(strip_tags($post['excerpt'] ?: $post['content']), 0, 120)) ?>...</p>
               <a href="<?= base_url('/blog/' . $post['slug']) ?>" class="mfh-continue-btn">
               <span>&rarr;</span> Continue Reading
               </a>
            </div>
         </div>
         <?php endforeach; ?>
         <?php endif; ?>
      </div>
   </div>
</section>
<section class="tourism-alliance-section">
   <div class="alliance-container">
      <div class="alliance-header">
         <h2 class="alliance-main-title">Tourism Board Alliances</h2>
         <div class="alliance-divider"></div>
      </div>
      <div class="alliance-row">
         <?php if (!empty($tourismAlliances)): ?>
            <?php foreach ($tourismAlliances as $alliance): ?>
               <div class="alliance-logo-item <?= $alliance['is_circle_frame'] ? 'circle-frame' : '' ?>">
                  <?php if (!empty($alliance['website_url'])): ?>
                     <a href="<?= esc($alliance['website_url']) ?>" target="_blank" title="<?= esc($alliance['name']) ?>">
                  <?php endif; ?>
                  
                  <?php if (!empty($alliance['logo'])): ?>
                     <img src="<?= base_url($alliance['logo']) ?>" alt="<?= esc($alliance['name']) ?>">
                  <?php else: ?>
                     <img src="<?= base_url('custom/default_image.png') ?>" alt="<?= esc($alliance['name']) ?>">
                  <?php endif; ?>
                  
                  <?php if (!empty($alliance['website_url'])): ?>
                     </a>
                  <?php endif; ?>
               </div>
            <?php endforeach; ?>
         <?php endif; ?>
      </div>
   </div>
</section>
<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>