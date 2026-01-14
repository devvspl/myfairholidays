<?php include APPPATH . 'Views/layouts/public_header.php'; ?>

<!-- Hero Section -->
<section class="bg-cover position-relative" style="background-image:url('<?= base_url('main/images/contactus.png') ?>');background-size: cover;background-position: center;background-repeat: no-repeat;" data-overlay="5">
   <div class="container">
      <div class="row align-items-center justify-content-center">
         <div class="col-xl-7 col-lg-9 col-md-12">
            <div class="fpc-capstion text-center my-4">
               <div class="fpc-captions">
                  <h1 class="xl-heading text-light">Customer Testimonials</h1>
                  <p class="text-light">Read what our satisfied customers say about their travel experiences</p>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="fpc-banner"></div>
</section>

<!-- Submit Testimonial Section -->
<section class="py-5">
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-xl-10 col-lg-12">
            <div class="card border-0 shadow-sm">
               <div class="card-header bg-primary text-white text-center">
                  <h3 class="mb-0" style="color: white;">Share Your Travel Experience</h3>
                  <p class="mb-0 mt-2">Tell us about your amazing journey with My Fair Holidays</p>
               </div>
               <div class="card-body p-4">
                  <form id="testimonialForm" enctype="multipart/form-data">
                     <?= csrf_field() ?>
                     
                     <div class="row">
                        <div class="col-lg-8">
                           <!-- Customer Information Section -->
                           <div class="card">
                              <div class="card-header">
                                 <h5 class="mb-0 text-primary">
                                    <i class="fa-solid fa-user me-2"></i>Customer Information
                                 </h5>
                              </div>
                              <div class="card-body" style="padding-left: 0;padding-right: 0;">
                                 <div class="row">
                                    <div class="col-md-6" >
                                       <div class="mb-3">
                                          <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                          <input type="text" name="customer_name" class="form-control" required>
                                       </div>
                                    </div>
                                    <div class="col-md-6" >
                                       <div class="mb-3">
                                          <label class="form-label">Customer Email <span class="text-danger">*</span></label>
                                          <input type="email" name="customer_email" class="form-control" required>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="row">
                                    <div class="col-md-6" >
                                       <div class="mb-3">
                                          <label class="form-label">Customer City</label>
                                          <input type="text" name="customer_city" class="form-control">
                                       </div>
                                    </div>
                                    <div class="col-md-6" >
                                       <div class="mb-3">
                                          <label class="form-label">Rating <span class="text-danger">*</span></label>
                                          <select class="form-select" style="height: 56px;" name="rating" required>
                                             <option value="">Select Rating</option>
                                             <option value="5">⭐⭐⭐⭐⭐ (5 Stars)</option>
                                             <option value="4">⭐⭐⭐⭐ (4 Stars)</option>
                                             <option value="3">⭐⭐⭐ (3 Stars)</option>
                                             <option value="2">⭐⭐ (2 Stars)</option>
                                             <option value="1">⭐ (1 Star)</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                         <div class="mb-3">
                                    <label class="form-label">Testimonial Text <span class="text-danger">*</span></label>
                                    <textarea name="testimonial_text" class="form-control" rows="2" required></textarea>
                                 </div>
                                    </div>
                                 </div>

                                
                              </div>
                           </div>

                           <!-- Travel Details Section -->
                           <div class="card">
                              <div class="card-header">
                                 <h5 class="mb-0 text-primary">
                                    <i class="fa-solid fa-map-marker-alt me-2"></i>Travel Details
                                 </h5>
                              </div>
                              <div class="card-body" style="padding-left: 0;padding-right: 0;">
                                 <div class="row">
                                    <div class="col-md-6" >
                                       <div class="mb-3">
                                          <label class="form-label">Category</label>
                                          <select class="form-select" style="height: 56px;" name="category_id">
                                             <option value="">Select Category</option>
                                             <?php if (!empty($categories)): ?>
                                                <?php foreach ($categories as $category): ?>
                                                   <option value="<?= $category['id'] ?>"><?= esc($category['name']) ?></option>
                                                <?php endforeach; ?>
                                             <?php endif; ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-6" >
                                       <div class="mb-3">
                                          <label class="form-label">Destination</label>
                                          <select class="form-select" style="height: 56px;" name="destination_id">
                                             <option value="">Select Destination</option>
                                             <?php if (!empty($destinations)): ?>
                                                <?php foreach ($destinations as $destination): ?>
                                                   <option value="<?= $destination['id'] ?>"><?= esc($destination['name']) ?></option>
                                                <?php endforeach; ?>
                                             <?php endif; ?>
                                          </select>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="mb-3">
                                          <label class="form-label">Package Name</label>
                                          <input type="text" name="package_name" class="form-control" placeholder="e.g., Goa Beach Paradise - 4 Days">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="mb-3">
                                          <label class="form-label">Travel Date</label>
                                          <input type="date" name="travel_date" class="form-control">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-lg-4">
                           <!-- Customer Photo -->
                           <div class="card">
                              <div class="card-header">
                                 <h5 class="mb-0 text-primary">
                                    <i class="fa-solid fa-camera me-2"></i>Customer Photo
                                 </h5>
                              </div>
                              <div class="card-body">
                                 <div class="mb-3">
                                    <input type="file" class="form-control" name="customer_image" accept="image/*" id="customerImage">
                                    <div class="form-text">Recommended size: 200x200px</div>
                                 </div>
                                 
                                 <div id="image_preview" style="display: none;">
                                    <img id="preview_img" src="" alt="Preview" class="img-fluid rounded">
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="remove_image">
                                       Remove Image
                                    </button>
                                 </div>
                              </div>
                           </div>

                           <!-- Actions -->
                           <div class="card">
                              <div class="card-body">
                                 <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                       <i class="fa-solid fa-paper-plane me-1"></i> Submit Testimonial
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                       <i class="fa-solid fa-refresh me-1"></i> Reset Form
                                    </button>
                                 </div>
                                 <div class="mt-3 text-center">
                                    <small class="text-muted">Your testimonial will be reviewed before being published</small>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>

                  <!-- Success/Error Messages -->
                  <div id="formMessage" class="mt-3" style="display: none;"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<!-- Testimonials List Section -->
<section class="gray-simple bg-cover py-5" style="background:url('<?= base_url('assets/img/reviewbg.png') ?>')no-repeat;">
   <div class="container">
      <div class="row align-items-center justify-content-center">
         <div class="col-xl-8 col-lg-9 col-md-11 col-sm-12">
            <div class="secHeading-wrap text-center mb-5">
               <h2>Loving Reviews By Our Customers</h2>
               <p>Read authentic experiences shared by our valued customers who traveled with us</p>
            </div>
         </div>
      </div>

      <?php if (!empty($testimonials)): ?>
      <div class="row align-items-center justify-content-center g-xl-4 g-lg-4 g-md-4 g-3">
         <?php foreach ($testimonials as $testimonial): ?>
         <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="card border rounded-3 h-100">
               <div class="card-body">
                  <div class="position-absolute top-0 end-0 mt-3 me-3">
                     <span class="square--40 circle text-primary bg-light-primary">
                        <i class="fa-solid fa-quote-right"></i>
                     </span>
                  </div>
                  
                  <div class="d-flex align-items-center flex-thumbes">
                     <div class="revws-pic">
                        <?php if (!empty($testimonial['customer_image'])): ?>
                           <img src="<?= base_url($testimonial['customer_image']) ?>" class="img-fluid rounded-2" width="80" alt="<?= esc($testimonial['customer_name']) ?>">
                        <?php else: ?>
                           <div class="bg-primary text-white rounded-2 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                              <i class="fa-solid fa-user fs-3"></i>
                           </div>
                        <?php endif; ?>
                     </div>
                     <div class="revws-caps ps-3">
                        <h6 class="fw-bold fs-6 m-0"><?= esc($testimonial['customer_name']) ?></h6>
                        <?php if (!empty($testimonial['customer_city'])): ?>
                           <p class="text-muted-2 text-md m-0"><?= esc($testimonial['customer_city']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($testimonial['package_name'])): ?>
                           <p class="text-primary text-sm m-0"><i class="fa-solid fa-map-marker-alt me-1"></i><?= esc($testimonial['package_name']) ?></p>
                        <?php endif; ?>
                        <div class="d-flex align-items-center justify-content-start mt-1">
                           <?php for ($i = 1; $i <= 5; $i++): ?>
                              <span class="me-1 text-xs <?= $i <= $testimonial['rating'] ? 'text-warning' : 'text-muted' ?>">
                                 <i class="fa-solid fa-star"></i>
                              </span>
                           <?php endfor; ?>
                        </div>
                     </div>
                  </div>
                  
                  <div class="revws-desc mt-3">
                     <p class="m-0 text-md"><?= esc($testimonial['testimonial_text']) ?></p>
                     <?php if (!empty($testimonial['travel_date'])): ?>
                        <small class="text-muted mt-2 d-block">
                           <i class="fa-solid fa-calendar me-1"></i>Traveled: <?= date('M Y', strtotime($testimonial['travel_date'])) ?>
                        </small>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         </div>
         <?php endforeach; ?>
      </div>

      <!-- Pagination -->
      <?php if (isset($pager)): ?>
      <div class="row">
         <div class="col-12">
            <div class="d-flex justify-content-center mt-5">
               <?= $pager->links() ?>
            </div>
         </div>
      </div>
      <?php endif; ?>

      <?php else: ?>
      <div class="row">
         <div class="col-12">
            <div class="text-center py-5">
               <i class="fa-solid fa-comments fs-1 text-muted mb-3"></i>
               <h4 class="text-muted">No testimonials yet</h4>
               <p class="text-muted">Be the first to share your travel experience with us!</p>
            </div>
         </div>
      </div>
      <?php endif; ?>
   </div>
</section>

<style>
.star-rating {
   display: flex;
   flex-direction: row-reverse;
   justify-content: flex-end;
}

.star-rating input {
   display: none;
}

.star-rating label {
   cursor: pointer;
   width: 30px;
   height: 30px;
   display: block;
   color: #ddd;
   font-size: 20px;
   transition: color 0.2s;
}

.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input:checked ~ label {
   color: #ffc107;
}

.bg-light-primary {
   background-color: rgba(13, 110, 253, 0.1) !important;
}

.square--40 {
   width: 40px;
   height: 40px;
   display: flex;
   align-items: center;
   justify-content: center;
}

.circle {
   border-radius: 50%;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const testimonialForm = document.getElementById('testimonialForm');
    const submitBtn = document.getElementById('submitBtn');
    const formMessage = document.getElementById('formMessage');
    
    // Image preview functionality (same as admin)
    const imageInput = document.getElementById('customerImage');
    const imagePreview = document.getElementById('image_preview');
    const previewImg = document.getElementById('preview_img');
    const removeImageBtn = document.getElementById('remove_image');
    
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
    
    removeImageBtn.addEventListener('click', function() {
        imageInput.value = '';
        imagePreview.style.display = 'none';
        previewImg.src = '';
    });

    testimonialForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate required fields
        const requiredFields = ['customer_name', 'customer_email', 'rating', 'testimonial_text'];
        let isValid = true;
        
        requiredFields.forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            formMessage.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-exclamation-triangle me-2"></i>Please fill in all required fields.</div>';
            formMessage.style.display = 'block';
            formMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }
        
        // Disable submit button and show loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Submitting...';
        
        // Hide previous messages
        formMessage.style.display = 'none';
        
        // Get form data
        const formData = new FormData(testimonialForm);
        
        // Send AJAX request
        fetch('<?= base_url('/testimonials/submit') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                formMessage.innerHTML = `
                    <div class="alert alert-success">
                        <i class="fa-solid fa-check-circle me-2"></i>
                        <strong>Thank you!</strong> ${data.message}
                    </div>
                `;
                formMessage.style.display = 'block';
                
                // Reset form
                testimonialForm.reset();
                
                // Hide image preview
                if (imagePreview) {
                    imagePreview.style.display = 'none';
                    previewImg.src = '';
                }
                
                // Remove validation classes
                document.querySelectorAll('.is-invalid').forEach(field => {
                    field.classList.remove('is-invalid');
                });
                
            } else {
                // Show error message
                let errorMsg = '<div class="alert alert-danger"><i class="fa-solid fa-exclamation-triangle me-2"></i>' + data.message;
                
                if (data.errors) {
                    errorMsg += '<ul class="mb-0 mt-2">';
                    for (let field in data.errors) {
                        errorMsg += '<li>' + data.errors[field] + '</li>';
                    }
                    errorMsg += '</ul>';
                }
                
                errorMsg += '</div>';
                formMessage.innerHTML = errorMsg;
                formMessage.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            formMessage.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-exclamation-triangle me-2"></i>Something went wrong. Please try again or contact us directly.</div>';
            formMessage.style.display = 'block';
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane me-1"></i> Submit Testimonial';
            
            // Scroll to message
            formMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    });
});
</script>

<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>