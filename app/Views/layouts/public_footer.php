<footer class="footer skin-dark-footer">
   <div style="padding: 30px 0;">
      <div class="container">
         <div class="row">
            <div class="col-lg-2 col-md-6">
               <div class="footer-widget">
                  <img src="<?php echo base_url(); ?>main/images/logo.png" class="img-footer" alt="My Fair Holidays" style="border-radius: 5px;">
                  <div class="footer-add">
                     <p>We make your dream more beautiful & enjoyful with lots of happiness.</p>
                  </div>
                 <div class="foot-socials">
    <ul>
        <li>
            <a href="https://www.facebook.com/MyFairHolidays" target="_blank" title="Facebook">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
        </li>

        <li>
            <a href="https://www.instagram.com/myfairholidays/" target="_blank" title="Instagram">
                <i class="fa-brands fa-instagram"></i>
            </a>
        </li>

        <li>
            <a href="https://twitter.com/MyFairHolidays" target="_blank" title="Twitter">
                <i class="fa-brands fa-twitter"></i>
            </a>
        </li>

        <li>
            <a href="https://www.linkedin.com/company/my-fair-holidays" target="_blank" title="LinkedIn">
                <i class="fa-brands fa-linkedin-in"></i>
            </a>
        </li>


        <li>
            <a href="https://www.youtube.com/channel/UCWpKAllkfYN6fUN_3D2A4Bw" target="_blank" title="YouTube">
                <i class="fa-brands fa-youtube"></i>
            </a>
        </li>

        <li>
            <a href="https://wa.me/9971124567" target="_blank" title="WhatsApp">
                <i class="fa-brands fa-whatsapp"></i>
            </a>
        </li>
    </ul>
</div>

               </div>
            </div>
            <div class="col-lg-2 col-md-6">
               <div class="footer-widget">
                  <h4 class="widget-title">Quick Links</h4>
                  <ul class="footer-menu">
                     <li><a href="<?= base_url('/') ?>">Home</a></li>
                     <li><a href="<?= base_url('/about') ?>">About Us</a></li>
                     <li><a href="<?= base_url('/blog') ?>">Our Blogs</a></li>
                     <li><a href="<?= base_url('/testimonials') ?>">Testimonials</a></li>
                     <li><a href="<?= base_url('/contact') ?>">Contact Us</a></li>
                     <li><a href="<?= base_url('/payment') ?>">Payment</a></li>
                     <li><a href="<?= base_url('/register-as-agent') ?>">Register as Agent</a></li>
                  </ul>
               </div>
            </div>
            <div class="col-lg-2 col-md-6">
               <div class="footer-widget">
                  <h4 class="widget-title">Domestic</h4>
                  <ul class="footer-menu">
                     <?php if (!empty($footerDomesticDestinations) && is_array($footerDomesticDestinations)): ?>
                        <?php foreach (array_slice($footerDomesticDestinations, 0, 6) as $destination): ?>
                           <li><a href="<?= base_url('/hotels?search=&destination_id=' . $destination['id']) ?>"><?= esc($destination['name']) ?></a></li>
                        <?php endforeach; ?>
                     <?php endif; ?>
                  </ul>
               </div>
            </div>
            <div class="col-lg-2 col-md-6">
               <div class="footer-widget">
                  <h4 class="widget-title">International</h4>
                  <ul class="footer-menu">
                     <?php if (!empty($footerInternationalDestinations) && is_array($footerInternationalDestinations)): ?>
                        <?php foreach (array_slice($footerInternationalDestinations, 0, 6) as $destination): ?>
                           <li><a href="<?= base_url('/hotels?search=&destination_id=' . $destination['id']) ?>"><?= esc($destination['name']) ?></a></li>
                        <?php endforeach; ?>
                     <?php endif; ?>
                  </ul>
               </div>
            </div>
            <div class="col-lg-4 col-md-6">
               <div class="footer-widget">
                  <h4 class="widget-title">Contact Info</h4>
                  <div class="footer-add">

                     <p><i class="fas fa-map-marker-alt me-2"></i><b>Head Office:</b> Office No O-445, (4th Floor)<br>Gaur City Center, Greater Noida<br>Uttar Pradesh 201307</p>
                     <p><i class="fas fa-map-marker-alt me-2"></i><b>Branch Office:</b> Broadway Shivpora, B.B.Cant<br>Srinagar Airport Distance: 6km<br>Dal Lake Distance: 3km<br>Pincode: 190004</p>
                                          <p><i class="fas fa-phone me-2"></i><a href="tel:+919971124567" style="color: inherit;">+91-9971124567</a></p>
                     <p><i class="fas fa-phone me-2"></i><a href="tel:+919582560106" style="color: inherit;">+91-9582560106</a></p>
                     <p><i class="fas fa-envelope me-2"></i><a href="mailto:info@myfairholidays.com" style="color: inherit;">info@myfairholidays.com</a></p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="footer-bottom border-top">
      <div class="container">
         <div class="row align-items-center justify-content-between">
            <div class="col-xl-6 col-lg-6 col-md-6">
               <p class="mb-0">© 2025 My Fair Holidays. All Rights Reserved.</p>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6">
               <ul class="p-0 d-flex justify-content-start justify-content-md-end text-start text-md-end m-0">
                  <li><a href="<?= base_url('/terms-of-service') ?>">Terms of Service</a></li>
                  <li class="ms-3"><a href="<?= base_url('/privacy-policy') ?>">Privacy Policy</a></li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</footer>
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginmodal" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
      <div class="modal-content" id="loginmodal">
         <div class="modal-header">
            <h4 class="modal-title fs-6"></h4>
            <a href="#" class="text-muted fs-4" data-bs-dismiss="modal" aria-label="Close"><i
               class="fa-solid fa-square-xmark"></i></a>
         </div>
         <div class="modal-body">
            <div class="modal-login-form py-4 px-md-3 px-0">
               <form>
                  <div class="form-floating mb-4">
                     <input type="email" class="form-control" placeholder="name@example.com">
                     <label>User Name</label>
                  </div>
                  <div class="form-floating mb-4">
                     <input type="password" class="form-control" placeholder="Password">
                     <label>Password</label>
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-primary full-width font--bold btn-lg">Log In</button>
                  </div>
                  <div class="modal-flex-item d-flex align-items-center justify-content-between mb-3">
                     <div class="modal-flex-first">
                        <div class="form-check form-check-inline">
                           <input class="form-check-input" type="checkbox" id="savepassword" value="option1">
                           <label class="form-check-label" for="savepassword">Save Password</label>
                        </div>
                     </div>
                     <div class="modal-flex-last">
                        <a href="JavaScript:Void(0);" class="text-primary fw-medium">Forget Password?</a>
                     </div>
                  </div>
               </form>
            </div>
            <div class="prixer px-3">
               <div class="devider-wraps position-relative">
                  <div class="devider-text text-muted-2 text-md">Sign In with More Methods</div>
               </div>
            </div>
            <div class="social-login py-4 px-2">
               <ul class="row align-items-center justify-content-between g-3 p-0 m-0">
                  <li class="col"><a href="#" class="square--60 border br-dashed rounded-2 full-width"><i
                     class="fa-brands fa-facebook color--facebook fs-2"></i></a></li>
                  <li class="col"><a href="#" class="square--60 border br-dashed rounded-2"><i
                     class="fa-brands fa-whatsapp color--whatsapp fs-2"></i></a></li>
                  <li class="col"><a href="#" class="square--60 border br-dashed rounded-2"><i
                     class="fa-brands fa-linkedin color--linkedin fs-2"></i></a></li>
                  <li class="col"><a href="#" class="square--60 border br-dashed rounded-2"><i
                     class="fa-brands fa-dribbble color--dribbble fs-2"></i></a></li>
                  <li class="col"><a href="#" class="square--60 border br-dashed rounded-2"><i
                     class="fa-brands fa-twitter color--twitter fs-2"></i></a></li>
               </ul>
            </div>
         </div>
         <div class="modal-footer align-items-center justify-content-center">
            <p>Don't have an account yet?<a href="#" class="text-primary fw-medium ms-1">Sign Up</a></p>
         </div>
      </div>
   </div>
</div>
<div class="modal modal-lg fade" id="countryModal" tabindex="-1" aria-labelledby="countryModalLabel"
   aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title fs-6" id="countryModalLabel">Select Your Country</h4>
            <a href="#" class="text-muted fs-4" data-bs-dismiss="modal" aria-label="Close"><i
               class="fa-solid fa-square-xmark"></i></a>
         </div>
         <div class="modal-body">
            <div class="allCountrieslist">
               <div class="suggestedCurrencylist-wrap mb-4">
                  <div class="d-inline-block mb-0 ps-3">
                     <h5 class="fs-6 fw-bold">Suggested Countries For you</h5>
                  </div>
                  <div class="suggestedCurrencylists">
                     <ul
                        class="row align-items-center justify-content-start row-cols-xl-4 row-cols-lg-3 row-cols-2 gy-2 gx-3 m-0 p-0">
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/united-states.png" class="img-fluid circle"
                                 width="35" alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">United State Dollar</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/united-kingdom.png" class="img-fluid circle"
                                 width="35" alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Pound Sterling</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry active" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/flag.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Indian Rupees</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/belgium.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Euro</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/brazil.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Australian Dollar</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/china.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Thai Baht</div>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="suggestedCurrencylist-wrap">
                  <div class="d-inline-block mb-0 ps-3">
                     <h5 class="fs-6 fw-bold">All Countries</h5>
                  </div>
                  <div class="suggestedCurrencylists">
                     <ul
                        class="row align-items-center justify-content-start row-cols-xl-4 row-cols-lg-3 row-cols-2 gy-2 gx-3 m-0 p-0">
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/united-states.png" class="img-fluid circle"
                                 width="35" alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">United State Dollar</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/vietnam.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Property currency</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/turkey.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Argentine Peso</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/spain.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Azerbaijani Manat</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/japan.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Australian Dollar</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/flag.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Bahraini Dinar</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/portugal.png" class="img-fluid circle"
                                 width="35" alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Brazilian Real</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/italy.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Bulgarian Lev</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/germany.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Canadian Dollar</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/france.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Chilean Peso</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/european.png" class="img-fluid circle"
                                 width="35" alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Colombian Peso</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/china.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Danish Krone</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/brazil.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Egyptian Pound</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/belgium.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Hungarian Forint</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/turkey.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Japanese Yen</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/spain.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Jordanian Dinar</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/germany.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Kuwaiti Dinar</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/france.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Malaysian Ringgit</div>
                           </a>
                        </li>
                        <li class="col">
                           <a class="selectCountry" href="#">
                              <div class="d-inline-block"><img src="<?php echo base_url(); ?>main/img/flag/brazil.png" class="img-fluid circle" width="35"
                                 alt=""></div>
                              <div class="text-dark text-md fw-medium ps-2">Singapore Dollar</div>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="popup-video" tabindex="-1" role="dialog" aria-labelledby="popupvideo" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content" id="popupvideo">
         <iframe class="embed-responsive-item full-width" height="480" src="https://www.youtube.com/embed/qN3OueBm9F4?rel=0" frameborder="0" allowfullscreen></iframe>
      </div>
   </div>
</div>
<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo base_url(); ?>main/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>main/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>main/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>main/js/dropzone.min.js"></script>
<script src="<?php echo base_url(); ?>main/js/flatpickr.js"></script>
<script src="<?php echo base_url(); ?>main/js/flickity.pkgd.min.js"></script>
<script src="<?php echo base_url(); ?>main/js/lightbox.min.js"></script>
<script src="<?php echo base_url(); ?>main/js/rangeslider.js"></script>
<script src="<?php echo base_url(); ?>main/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>main/js/counterup.min.js"></script>
<script src="<?php echo base_url(); ?>main/js/prism.js"></script>
<script src="<?php echo base_url(); ?>main/js/addadult.js"></script>
<script src="<?php echo base_url(); ?>main/js/browselocation.js"></script>
<script src="<?php echo base_url(); ?>main/js/custom.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
      // Navigation functionality
      const hamburger = document.getElementById('mfhHamburger');
      const nav = document.getElementById('mfhNav');
      const overlay = document.getElementById('mfhOverlay');
      const closeBtn = document.getElementById('mfhClose');
      
      if (hamburger && nav && closeBtn) {
         hamburger.addEventListener('click', () => {
            nav.classList.add('active');
            if (overlay) overlay.classList.add('active');
         });
         
         closeBtn.addEventListener('click', () => {
            nav.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
         });
         
         if (overlay) {
            overlay.addEventListener('click', () => {
               nav.classList.remove('active');
               overlay.classList.remove('active');
            });
         }
      }
   
      // Dropdown functionality
      document.querySelectorAll('.mfh-drop-link').forEach(link => {
         link.onclick = e => {
            if (innerWidth <= 991) {
               e.preventDefault();
               link.parentElement.classList.toggle('open');
            }
         }
      });
   
      document.querySelectorAll('.mfh-dropdown > a').forEach(item => {
         item.addEventListener('click', e => {
            if (window.innerWidth <= 991) {
               e.preventDefault();
               item.parentElement.classList.toggle('active');
            }
         });
      });
   
      // Destination tabs and filtering
      const tabs = document.querySelectorAll('.tab-btn');
      const cards = document.querySelectorAll('.dest-card');
      const grid = document.getElementById('destinationGrid');
      const btnLeft = document.querySelector('.btn-left');
      const btnRight = document.querySelector('.btn-right');
      const viewAllBtn = document.getElementById('viewAllBtn');
   
      if (tabs.length && cards.length && grid) {
         tabs.forEach(tab => {
            tab.addEventListener('click', () => {
               tabs.forEach(t => t.classList.remove('active'));
               tab.classList.add('active');
               const region = tab.getAttribute('data-region');
               
               cards.forEach(card => {
                  card.classList.toggle('visible', card.classList.contains(region));
               });
               grid.scrollLeft = 0;
               if (viewAllBtn) viewAllBtn.innerText = "View All";
            });
         });
   
         if (btnRight && btnLeft) {
            btnRight.addEventListener('click', () => grid.scrollBy({ left: 360, behavior: 'smooth' }));
            btnLeft.addEventListener('click', () => grid.scrollBy({ left: -360, behavior: 'smooth' }));
         }
   
         if (viewAllBtn) {
            viewAllBtn.addEventListener('click', () => {
               if (viewAllBtn.innerText === "View All") {
                  cards.forEach(card => card.classList.add('visible'));
                  viewAllBtn.innerText = "SHOW LESS";
               } else {
                  const activeRegion = document.querySelector('.tab-btn.active')?.dataset.region;
                  cards.forEach(card => {
                     card.classList.toggle('visible', card.classList.contains(activeRegion));
                  });
                  viewAllBtn.innerText = "View All";
               }
            });
         }
      }
   
      // Offers slider functionality
      let currentSlide = 0;
      const slides = document.querySelectorAll('#europeSlider .slide');
      
      window.changeSlide = function(direction) {
         if (slides.length) {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + direction + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
         }
      }
   
      // Themes section functionality
      const themeData = {
         adventure: [
            { title: 'Discover Japan', sub: 'Tokyo Skylines to Osaka Sights', img: '<?php echo base_url(); ?>main/images/MapBasic157.png' },
            { title: 'Turkey Romantic Getaway', sub: 'Ancient Wonders and Natural Marvels', img: '<?php echo base_url(); ?>main/images/couple-love-with-balloon-cityscape.jpg' },
            { title: 'Turkey Romantic Getaway', sub: 'Ancient Wonders and Natural Marvels', img: '<?php echo base_url(); ?>main/images/couple-love-with-balloon-cityscape.jpg' },
            { title: 'Turkey Romantic Getaway', sub: 'Ancient Wonders and Natural Marvels', img: '<?php echo base_url(); ?>main/images/couple-love-with-balloon-cityscape.jpg' },
            { title: 'Turkey Romantic Getaway', sub: 'Ancient Wonders and Natural Marvels', img: '<?php echo base_url(); ?>main/images/couple-love-with-balloon-cityscape.jpg' }
         ],
         newyear: [
            { title: 'Best of Japan', sub: 'Ancient Shrines to Futuristic Skylines', img: '<?php echo base_url(); ?>main/images/golden-pavilion-kinkakuji-temple-autumn-kyoto-japan.jpg' }
         ],
         christmas: [
            { title: 'Turkey Romantic Getaway', sub: 'Ancient Wonders and Natural Marvels', img: '<?php echo base_url(); ?>main/images/couple-love-with-balloon-cityscape.jpg' }
         ]
      };
   
      const themesSlider = document.getElementById('themesSlider');
      const themeTabs = document.querySelectorAll('.theme-tab');
      const slideRightBtn = document.getElementById('slideRight');
      const slideLeftBtn = document.getElementById('slideLeft');
   
      function renderCards(themeKey) {
         if (themesSlider && themeData[themeKey]) {
            themesSlider.innerHTML = '';
            themeData[themeKey].forEach(item => {
               const card = document.createElement('div');
               card.className = 'theme-card';
               card.innerHTML = `
                  <img src="${item.img}" alt="${item.title}">
                  <div class="theme-overlay">
                     <p class="theme-sub">${item.sub}</p>
                     <h3 class="theme-title">${item.title}</h3>
                  </div>
               `;
               themesSlider.appendChild(card);
            });
            themesSlider.scrollLeft = 0;
         }
      }
   
      if (themeTabs.length) {
         themeTabs.forEach(tab => {
            tab.addEventListener('click', () => {
               themeTabs.forEach(t => t.classList.remove('active'));
               tab.classList.add('active');
               renderCards(tab.dataset.theme);
            });
         });
      }
   
      if (slideRightBtn && slideLeftBtn && themesSlider) {
         slideRightBtn.onclick = () => themesSlider.scrollBy({ left: 300, behavior: 'smooth' });
         slideLeftBtn.onclick = () => themesSlider.scrollBy({ left: -300, behavior: 'smooth' });
      }
   
      renderCards('adventure');
   
      // Hero slider functionality
      const heroSlides = document.querySelectorAll('.hs-slide');
      const heroDots = document.querySelectorAll('.hs-dot');
      const heroNextBtn = document.querySelector('.hs-next');
      const heroPrevBtn = document.querySelector('.hs-prev');
      let heroCurrentIdx = 0;
      let heroTimer;
   
      function showHeroSlide(index) {
         if (heroSlides.length) {
            if (index >= heroSlides.length) index = 0;
            if (index < 0) index = heroSlides.length - 1;
            
            heroSlides.forEach(s => s.classList.remove('hs-active'));
            heroDots.forEach(d => d.classList.remove('hs-active'));
            
            heroSlides[index].classList.add('hs-active');
            if (heroDots[index]) heroDots[index].classList.add('hs-active');
            heroCurrentIdx = index;
         }
      }
   
      function startHeroAutoSlide() {
         heroTimer = setInterval(() => showHeroSlide(heroCurrentIdx + 1), 5000);
      }
   
      if (heroNextBtn && heroPrevBtn) {
         heroNextBtn.onclick = () => { showHeroSlide(heroCurrentIdx + 1); clearInterval(heroTimer); startHeroAutoSlide(); };
         heroPrevBtn.onclick = () => { showHeroSlide(heroCurrentIdx - 1); clearInterval(heroTimer); startHeroAutoSlide(); };
      }
   
      heroDots.forEach((dot, i) => {
         dot.onclick = () => { showHeroSlide(i); clearInterval(heroTimer); startHeroAutoSlide(); };
      });
   
      startHeroAutoSlide();
   
      // Seasonal mood section
      const filterBtns = document.querySelectorAll('.filter-btn');
      const packages = document.querySelectorAll('.package-card');
      const moods = document.querySelectorAll('.mood-content');
      const container = document.querySelector('.packages-container');
      const scrollLeftBtn = document.getElementById('scrollLeft');
      const scrollRightBtn = document.getElementById('scrollRight');
      const wrapper = document.getElementById('SeasonalSection');
   
      if (filterBtns.length) {
         filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
               filterBtns.forEach(b => b.classList.remove('active'));
               btn.classList.add('active');
   
               const selectedSeason = btn.dataset.season;
   
               if (wrapper) {
                  if (selectedSeason === 'summer') {
                     wrapper.style.backgroundImage = "linear-gradient(180deg, rgba(255,255,255,0.95) 0%, rgba(255,190,86,0.7) 100%), url('https://www.sotc.in/images/homePageRevamp/summer.gif')";
                  } else if (selectedSeason === 'winter') {
                     wrapper.style.backgroundImage = "linear-gradient(180deg, rgba(255,255,255,0.95) 0%, rgba(173,216,230,0.7) 100%), url('https://www.sotc.in/images/homePageRevamp/winter.gif')";
                  } else if (selectedSeason === 'monsoon') {
                     wrapper.style.backgroundImage = "linear-gradient(180deg, rgba(255,255,255,0.95) 0%, rgba(237,28,36,0.2) 100%), url('https://www.sotc.in/images/homePageRevamp/monsoon.gif')";
                  }
               }
   
               moods.forEach(m => {
                  m.classList.remove('active');
                  if (m.id === `${selectedSeason}-text`) {
                     m.classList.add('active');
                  }
               });
   
               packages.forEach(p => {
                  if (p.dataset.season === selectedSeason) {
                     p.classList.add('active');
                     p.style.animation = 'none';
                     p.offsetHeight; 
                     p.style.animation = null;
                  } else {
                     p.classList.remove('active');
                  }
               });
   
               if (container) container.scrollTo({ left: 0, behavior: 'smooth' });
            });
         });
      }
   
      const scrollAmount = 300;
      if (scrollRightBtn && scrollLeftBtn && container) {
         scrollRightBtn.addEventListener('click', () => {
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
         });
   
         scrollLeftBtn.addEventListener('click', () => {
            container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
         });
   
         const updateArrows = () => {
            const isAtStart = container.scrollLeft <= 5;
            const isAtEnd = container.scrollLeft + container.clientWidth >= container.scrollWidth - 5;
            
            scrollLeftBtn.style.opacity = isAtStart ? '0.3' : '1';
            scrollLeftBtn.style.pointerEvents = isAtStart ? 'none' : 'auto';
            
            scrollRightBtn.style.opacity = isAtEnd ? '0.3' : '1';
            scrollRightBtn.style.pointerEvents = isAtEnd ? 'none' : 'auto';
         };
   
         container.addEventListener('scroll', updateArrows);
         updateArrows();
      }
   
      // Domestic section functionality
      function initMfhSlider() {
         const parent = document.querySelector("#mfh-dom-unique-01");
         if (!parent) return;
   
         const track = parent.querySelector(".mfh-scroll-box");
         const leftBtn = parent.querySelector(".mfh-left-ctrl");
         const rightBtn = parent.querySelector(".mfh-right-ctrl");
         const viewAllBtn = parent.querySelector(".mfh-view-all-trigger");
         const tabs = parent.querySelectorAll(".mfh-tab-item");
         const cards = parent.querySelectorAll(".mfh-card");
   
         if (leftBtn && rightBtn && track) {
            rightBtn.addEventListener('click', () => track.scrollBy({ left: 360, behavior: 'smooth' }));
            leftBtn.addEventListener('click', () => track.scrollBy({ left: -360, behavior: 'smooth' }));
         }
   
         tabs.forEach(tab => {
            tab.addEventListener("click", function() {
               tabs.forEach(t => t.classList.remove("mfh-active"));
               this.classList.add("mfh-active");
               
               const region = this.getAttribute('data-region');
               cards.forEach(card => {
                  if (card.classList.contains(region)) {
                     card.classList.add("mfh-visible");
                  } else {
                     card.classList.remove("mfh-visible");
                  }
               });
               if (track) track.scrollTo({ left: 0, behavior: 'smooth' });
            });
         });
   
         if (viewAllBtn) {
            viewAllBtn.addEventListener("click", function() {
               tabs.forEach(t => t.classList.remove("mfh-active"));
               cards.forEach(card => card.classList.add("mfh-visible"));
               if (track) track.scrollTo({ left: 0, behavior: 'smooth' });
            });
         }
      }
   
      initMfhSlider();
   
      // Where to go section
      const monthTabs = document.querySelectorAll('.month-item');
      const filterCards = document.querySelectorAll('.filter-item');
   
      monthTabs.forEach(tab => {
         tab.addEventListener('click', function() {
            monthTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
   
            const month = this.getAttribute('data-month');
            filterCards.forEach(card => {
               if (card.classList.contains(month)) {
                  card.classList.add('active');
               } else {
                  card.classList.remove('active');
               }
            });
         });
      });
   
      // Horizontal scroll function
      window.scrollDest = function(val) {
         const destContainer = document.getElementById('destContainer');
         if (destContainer) {
            destContainer.scrollBy({ left: val, behavior: 'smooth' });
         }
      }
   
      // Review slider
      const reviewSlider = document.querySelector(".review-slider");
      const sliderNext = document.querySelector(".slider-next");
      const sliderPrev = document.querySelector(".slider-prev");
   
      if (sliderNext && sliderPrev && reviewSlider) {
         sliderNext.onclick = () => reviewSlider.scrollLeft += reviewSlider.offsetWidth;
         sliderPrev.onclick = () => reviewSlider.scrollLeft -= reviewSlider.offsetWidth;
      }
   
      document.querySelectorAll(".read-more-btn").forEach(btn => {
         btn.addEventListener("click", () => {
            const content = btn.closest(".review-content");
            content.classList.toggle("expanded");
            btn.textContent = content.classList.contains("expanded") ? "Read Less" : "Read More";
         });
      });
   
      // Gallery functionality
      document.querySelectorAll(".gallery-wrapper").forEach(wrapper => {
         const container = wrapper.querySelector(".gallery-container");
         const prevBtn = wrapper.querySelector(".nav-arrow.prev");
         const nextBtn = wrapper.querySelector(".nav-arrow.next");
   
         const scrollAmount = () => {
            const item = container.querySelector(".gallery-item");
            if (!item) return 300;
            const style = window.getComputedStyle(container);
            const gap = parseInt(style.columnGap || style.gap || 20);
            return item.offsetWidth + gap;
         };
   
         if (prevBtn && nextBtn && container) {
            prevBtn.addEventListener("click", () => {
               container.scrollBy({
                  left: -scrollAmount(),
                  behavior: "smooth"
               });
            });
   
            nextBtn.addEventListener("click", () => {
               container.scrollBy({
                  left: scrollAmount(),
                  behavior: "smooth"
               });
            });
         }
      });
   
      // Gram slider
      const gramSlider = document.getElementById('gramSlider');
      const gramNext = document.getElementById('gramNext');
      const gramPrev = document.getElementById('gramPrev');
   
      if (gramSlider && gramNext && gramPrev) {
         gramNext.onclick = () => {
            gramSlider.scrollBy({ left: 300, behavior: 'smooth' });
         };
         gramPrev.onclick = () => {
            gramSlider.scrollBy({ left: -300, behavior: 'smooth' });
         };
      }
   });
</script>
</body>
</html>