<?php
/**
 * Hotel Booking Form Component
 * 
 * @param array $hotel - Hotel data array
 * @param string $formId - Unique form ID (optional)
 * @param string $size - Form size: 'full', 'compact' (optional)
 */

$formId = $formId ?? 'hotel-booking-form-' . uniqid();
$size = $size ?? 'full';
$isCompact = $size === 'compact';
?>

<div class="card border br-dashed hotel-booking-form">
   <div class="card-header">
      <div class="crd-heady102 d-flex align-items-center justify-content-start">
         <div class="square--30 circle bg-light-primary text-primary flex-shrink-0">
            <i class="fa-solid fa-percent"></i>
         </div>
         <div class="crd-heady102Title lh-1 ps-2">
            <span class="text-sm fw-semibold text-dark text-uppercase lh-1 mb-0">Best Price Guaranteed</span>
         </div>
      </div>
   </div>
   
   <div class="card-body">
      <!-- Price Display -->
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

      <!-- Booking Form -->
      <form id="<?= $formId ?>" class="hotel-booking-form-inner">
         <?= csrf_field() ?>
         <input type="hidden" name="hotel_id" value="<?= $hotel['id'] ?? '' ?>">
         
         <!-- Check-in Date -->
         <div class="form-group mb-3">
            <label class="form-label text-dark fw-medium mb-2">Check-in Date</label>
            <div class="inputIicon">
               <div class="myIcon">
                  <svg width="24" height="24" viewBox="0 0 24 24" class="fill-primary" xmlns="http://www.w3.org/2000/svg">
                     <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"/>
                     <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"/>
                  </svg>
               </div>
               <div class="input-box">
                  <input class="form-control fw-medium fs-md check-in-date" type="text" name="check_in_date" placeholder="Select Check-in Date" readonly>
               </div>
            </div>
         </div>

         <!-- Check-out Date -->
         <div class="form-group mb-3">
            <label class="form-label text-dark fw-medium mb-2">Check-out Date</label>
            <div class="inputIicon">
               <div class="myIcon">
                  <svg width="24" height="24" viewBox="0 0 24 24" class="fill-primary" xmlns="http://www.w3.org/2000/svg">
                     <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"/>
                     <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"/>
                  </svg>
               </div>
               <div class="input-box">
                  <input class="form-control fw-medium fs-md check-out-date" type="text" name="check_out_date" placeholder="Select Check-out Date" readonly>
               </div>
            </div>
         </div>

         <!-- Guests & Rooms -->
         <div class="form-group mb-3">
            <label class="form-label text-dark fw-medium mb-2">Guests & Rooms</label>
            <div class="inputIicon">
               <div class="myIcon">
                  <svg width="24" height="24" viewBox="0 0 24 24" class="fill-primary" xmlns="http://www.w3.org/2000/svg">
                     <path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z"/>
                     <path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z"/>
                  </svg>
               </div>
               <div class="input-box">
                  <div class="guest-selector-container">
                     <input type="text" class="form-control fw-medium fs-md guest-display" value="1 Room, 2 Adults" readonly>
                     <div class="guest-dropdown">
                        <div class="guest-dropdown-content">
                           <div class="guest-row">
                              <div class="guest-info">
                                 <span class="guest-type">Rooms</span>
                                 <small class="text-muted">Number of rooms</small>
                              </div>
                              <div class="guest-controls">
                                 <button type="button" class="btn btn-sm btn-outline-secondary guest-minus" data-target="rooms">-</button>
                                 <span class="guest-count" id="rooms-count">1</span>
                                 <button type="button" class="btn btn-sm btn-outline-secondary guest-plus" data-target="rooms">+</button>
                              </div>
                           </div>
                           <div class="guest-row">
                              <div class="guest-info">
                                 <span class="guest-type">Adults</span>
                                 <small class="text-muted">Ages 13 or above</small>
                              </div>
                              <div class="guest-controls">
                                 <button type="button" class="btn btn-sm btn-outline-secondary guest-minus" data-target="adults">-</button>
                                 <span class="guest-count" id="adults-count">2</span>
                                 <button type="button" class="btn btn-sm btn-outline-secondary guest-plus" data-target="adults">+</button>
                              </div>
                           </div>
                           <div class="guest-row">
                              <div class="guest-info">
                                 <span class="guest-type">Children</span>
                                 <small class="text-muted">Ages 2-12</small>
                              </div>
                              <div class="guest-controls">
                                 <button type="button" class="btn btn-sm btn-outline-secondary guest-minus" data-target="children">-</button>
                                 <span class="guest-count" id="children-count">0</span>
                                 <button type="button" class="btn btn-sm btn-outline-secondary guest-plus" data-target="children">+</button>
                              </div>
                           </div>
                           <div class="guest-row">
                              <div class="guest-info">
                                 <span class="guest-type">Infants</span>
                                 <small class="text-muted">Under 2 years</small>
                              </div>
                              <div class="guest-controls">
                                 <button type="button" class="btn btn-sm btn-outline-secondary guest-minus" data-target="infants">-</button>
                                 <span class="guest-count" id="infants-count">0</span>
                                 <button type="button" class="btn btn-sm btn-outline-secondary guest-plus" data-target="infants">+</button>
                              </div>
                           </div>
                           <div class="guest-actions mt-3">
                              <button type="button" class="btn btn-sm btn-primary guest-done">Done</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Hidden inputs for form submission -->
                  <input type="hidden" name="rooms" value="1">
                  <input type="hidden" name="adults" value="2">
                  <input type="hidden" name="children" value="0">
                  <input type="hidden" name="infants" value="0">
               </div>
            </div>
         </div>

         <!-- Special Requests (Optional) -->
         <?php if (!$isCompact): ?>
         <div class="form-group mb-3">
            <label class="form-label text-dark fw-medium mb-2">Special Requests (Optional)</label>
            <textarea class="form-control" name="special_requests" rows="2" placeholder="Any special requirements or requests..."></textarea>
         </div>
         <?php endif; ?>

         <!-- Action Buttons -->
         <div class="form-group mb-2">
            <button type="submit" class="btn btn-primary full-width fw-medium booking-submit-btn">
               <i class="fa-solid fa-calendar-check me-2"></i>Book Now
            </button>
         </div>
         
         <?php if (!$isCompact): ?>
         <div class="form-group mb-0">
            <button type="button" class="btn btn-outline-primary full-width fw-medium" onclick="requestQuote(<?= $hotel['id'] ?? 0 ?>)">
               <i class="fa-solid fa-envelope me-2"></i>Request Custom Quote
            </button>
         </div>
         <?php endif; ?>
      </form>
   </div>

   <!-- Rating Footer -->
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

<!-- Booking Form Styles -->
<style>
.hotel-booking-form {
   position: sticky;
   top: 20px;
}

.guest-selector-container {
   position: relative;
}

.guest-display {
   cursor: pointer;
}

.guest-dropdown {
   position: absolute;
   top: 100%;
   left: 0;
   right: 0;
   background: white;
   border: 1px solid #ddd;
   border-radius: 8px;
   box-shadow: 0 4px 12px rgba(0,0,0,0.15);
   z-index: 1000;
   display: none;
   margin-top: 5px;
}

.guest-dropdown.show {
   display: block;
}

.guest-dropdown-content {
   padding: 15px;
}

.guest-row {
   display: flex;
   justify-content: space-between;
   align-items: center;
   padding: 10px 0;
   border-bottom: 1px solid #f0f0f0;
}

.guest-row:last-of-type {
   border-bottom: none;
}

.guest-info {
   flex: 1;
}

.guest-type {
   font-weight: 500;
   display: block;
}

.guest-controls {
   display: flex;
   align-items: center;
   gap: 10px;
}

.guest-controls button {
   width: 32px;
   height: 32px;
   border-radius: 50%;
   display: flex;
   align-items: center;
   justify-content: center;
   padding: 0;
}

.guest-count {
   min-width: 20px;
   text-align: center;
   font-weight: 500;
}

.guest-actions {
   text-align: right;
   padding-top: 10px;
   border-top: 1px solid #f0f0f0;
}

.booking-submit-btn:hover {
   transform: translateY(-1px);
   box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.form-label {
   font-size: 14px;
}

.inputIicon {
   position: relative;
}

.myIcon {
   position: absolute;
   left: 12px;
   top: 50%;
   transform: translateY(-50%);
   z-index: 2;
}

.input-box input {
   padding-left: 45px;
}

/* Date picker styling */
.check-in-date, .check-out-date {
   cursor: pointer;
}

/* Responsive adjustments */
@media (max-width: 768px) {
   .hotel-booking-form {
      position: static;
   }
   
   .guest-dropdown {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 90%;
      max-width: 400px;
   }
}
</style>

<!-- Booking Form JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
   initializeBookingForm('<?= $formId ?>');
});

function initializeBookingForm(formId) {
   const form = document.getElementById(formId);
   if (!form) return;
   
   // Guest selector functionality
   const guestDisplay = form.querySelector('.guest-display');
   const guestDropdown = form.querySelector('.guest-dropdown');
   const guestCounts = {
      rooms: 1,
      adults: 2,
      children: 0,
      infants: 0
   };
   
   // Toggle guest dropdown
   guestDisplay.addEventListener('click', function() {
      guestDropdown.classList.toggle('show');
   });
   
   // Close dropdown when clicking outside
   document.addEventListener('click', function(e) {
      if (!form.contains(e.target)) {
         guestDropdown.classList.remove('show');
      }
   });
   
   // Guest counter controls
   form.querySelectorAll('.guest-plus, .guest-minus').forEach(button => {
      button.addEventListener('click', function(e) {
         e.preventDefault();
         const target = this.dataset.target;
         const isPlus = this.classList.contains('guest-plus');
         const countElement = form.querySelector(`#${target}-count`);
         const hiddenInput = form.querySelector(`input[name="${target}"]`);
         
         let currentCount = guestCounts[target];
         
         if (isPlus) {
            // Set maximum limits
            const maxLimits = { rooms: 10, adults: 20, children: 10, infants: 5 };
            if (currentCount < maxLimits[target]) {
               currentCount++;
            }
         } else {
            // Set minimum limits
            const minLimits = { rooms: 1, adults: 1, children: 0, infants: 0 };
            if (currentCount > minLimits[target]) {
               currentCount--;
            }
         }
         
         guestCounts[target] = currentCount;
         countElement.textContent = currentCount;
         hiddenInput.value = currentCount;
         
         updateGuestDisplay();
      });
   });
   
   // Done button
   form.querySelector('.guest-done').addEventListener('click', function() {
      guestDropdown.classList.remove('show');
   });
   
   function updateGuestDisplay() {
      const { rooms, adults, children, infants } = guestCounts;
      let displayText = `${rooms} Room${rooms > 1 ? 's' : ''}, ${adults} Adult${adults > 1 ? 's' : ''}`;
      
      if (children > 0) {
         displayText += `, ${children} Child${children > 1 ? 'ren' : ''}`;
      }
      
      if (infants > 0) {
         displayText += `, ${infants} Infant${infants > 1 ? 's' : ''}`;
      }
      
      guestDisplay.value = displayText;
   }
   
   // Date picker initialization (you can integrate with your preferred date picker library)
   const checkInDate = form.querySelector('.check-in-date');
   const checkOutDate = form.querySelector('.check-out-date');
   
   // Set minimum date to today
   const today = new Date().toISOString().split('T')[0];
   
   checkInDate.addEventListener('click', function() {
      // Initialize date picker here
      // For now, using basic HTML5 date input
      const dateInput = document.createElement('input');
      dateInput.type = 'date';
      dateInput.min = today;
      dateInput.style.position = 'absolute';
      dateInput.style.opacity = '0';
      dateInput.style.pointerEvents = 'none';
      
      dateInput.addEventListener('change', function() {
         checkInDate.value = formatDate(this.value);
         checkInDate.dataset.date = this.value;
         
         // Update check-out minimum date
         const nextDay = new Date(this.value);
         nextDay.setDate(nextDay.getDate() + 1);
         checkOutDate.min = nextDay.toISOString().split('T')[0];
         
         document.body.removeChild(dateInput);
      });
      
      document.body.appendChild(dateInput);
      dateInput.click();
   });
   
   checkOutDate.addEventListener('click', function() {
      const dateInput = document.createElement('input');
      dateInput.type = 'date';
      dateInput.min = checkInDate.dataset.date ? 
         new Date(new Date(checkInDate.dataset.date).getTime() + 86400000).toISOString().split('T')[0] : 
         today;
      dateInput.style.position = 'absolute';
      dateInput.style.opacity = '0';
      dateInput.style.pointerEvents = 'none';
      
      dateInput.addEventListener('change', function() {
         checkOutDate.value = formatDate(this.value);
         checkOutDate.dataset.date = this.value;
         document.body.removeChild(dateInput);
      });
      
      document.body.appendChild(dateInput);
      dateInput.click();
   });
   
   function formatDate(dateString) {
      const date = new Date(dateString);
      const options = { 
         weekday: 'short', 
         year: 'numeric', 
         month: 'short', 
         day: 'numeric' 
      };
      return date.toLocaleDateString('en-US', options);
   }
   
   // Form submission
   form.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Validate required fields
      if (!checkInDate.dataset.date || !checkOutDate.dataset.date) {
         alert('Please select check-in and check-out dates');
         return;
      }
      
      // Show loading state
      const submitBtn = form.querySelector('.booking-submit-btn');
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Processing...';
      submitBtn.disabled = true;
      
      // Collect form data and redirect to booking page
      const hotelId = form.querySelector('input[name="hotel_id"]').value;
      const checkIn = checkInDate.dataset.date;
      const checkOut = checkOutDate.dataset.date;
      const rooms = form.querySelector('input[name="rooms"]').value;
      const adults = form.querySelector('input[name="adults"]').value;
      const children = form.querySelector('input[name="children"]').value;
      const infants = form.querySelector('input[name="infants"]').value;
      const specialRequests = form.querySelector('textarea[name="special_requests"]')?.value || '';
      
      // Create URL with booking parameters
      const bookingUrl = new URL('<?= base_url('/booking') ?>');
      bookingUrl.searchParams.set('hotel_id', hotelId);
      bookingUrl.searchParams.set('check_in_date', checkIn);
      bookingUrl.searchParams.set('check_out_date', checkOut);
      bookingUrl.searchParams.set('rooms', rooms);
      bookingUrl.searchParams.set('adults', adults);
      bookingUrl.searchParams.set('children', children);
      bookingUrl.searchParams.set('infants', infants);
      if (specialRequests) {
         bookingUrl.searchParams.set('special_requests', specialRequests);
      }
      
      // Redirect to booking page
      window.location.href = bookingUrl.toString();
   });
}

function requestQuote(hotelId) {
   // Redirect to quote page with hotel pre-selected
   window.location.href = `<?= base_url('/quote') ?>?hotel_id=${hotelId}`;
}
</script>