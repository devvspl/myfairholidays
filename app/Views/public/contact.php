<?php include APPPATH . 'Views/layouts/public_header.php'; ?>

<?php
// Get hero section data
$heroTitle = 'Get-in Touch';
$heroBackground = 'main/images/contactus.png';
if (!empty($heroSection)) {
    $heroTitle = $heroSection['title'];
    if (!empty($heroSection['background_image'])) {
        $heroBackground = $heroSection['background_image'];
    }
}
?>

<section class="bg-cover position-relative" style="background-image:url('<?= base_url($heroBackground) ?>');background-size: cover;background-position: center;background-repeat: no-repeat;"
   data-overlay="5">
   <div class="container">
      <div class="row align-items-center justify-content-center">
         <div class="col-xl-7 col-lg-9 col-md-12">
            <div class="fpc-capstion text-center my-4">
               <div class="fpc-captions">
                  <h1 class="xl-heading text-light"><?= esc($heroTitle) ?></h1>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="fpc-banner"></div>
</section>

<section>
   <div class="container">
      <div class="row justify-content-between g-4 mb-5">
         <?php if (!empty($contactInfoSections)): ?>
            <?php foreach ($contactInfoSections as $section): ?>
            <div class="col-xl-3 col-lg-3 col-md-6">
               <div class="card p-4 rounded-4 border br-dashed text-center h-100">
                  <?php if (!empty($section['icon'])): ?>
                  <div class="crds-icons d-inline-flex mx-auto mb-3 text-primary fs-2">
                     <i class="<?= esc($section['icon']) ?>"></i>
                  </div>
                  <?php endif; ?>
                  <div class="crds-desc">
                     <h5><?= esc($section['title']) ?></h5>
                     <p class="fs-6 text-md lh-2 mb-0">
                        <?php if (!empty($section['contact_link']) && !empty($section['contact_value'])): ?>
                           <a href="<?= esc($section['contact_link']) ?>" class="text-primary text-decoration-none"><?= esc($section['contact_value']) ?></a>
                        <?php elseif (!empty($section['contact_value'])): ?>
                           <?php
                           // If contact_value contains phone numbers but no link, make them clickable
                           $contactValue = $section['contact_value'];
                           if ($section['contact_type'] === 'phone') {
                               // Pattern to match phone numbers (various formats including international)
                               $phonePattern = '/(\+?\d{1,4}[-.\s]?\(?\d{1,4}\)?[-.\s]?\d{1,4}[-.\s]?\d{1,9})/';
                               $contactValue = preg_replace_callback($phonePattern, function($matches) {
                                   $phone = $matches[1];
                                   // Clean phone number for tel: link (remove spaces, dashes, dots, parentheses)
                                   $cleanPhone = preg_replace('/[^\d+]/', '', $phone);
                                   return '<a href="tel:' . $cleanPhone . '" class="text-primary text-decoration-none">' . $phone . '</a>';
                               }, $contactValue);
                               echo $contactValue;
                           } elseif ($section['contact_type'] === 'email') {
                               // Make emails clickable
                               $emailPattern = '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/';
                               $contactValue = preg_replace_callback($emailPattern, function($matches) {
                                   $email = $matches[1];
                                   return '<a href="mailto:' . $email . '" class="text-primary text-decoration-none">' . $email . '</a>';
                               }, $contactValue);
                               echo $contactValue;
                           } else {
                               // For other types, still check for phone numbers and emails
                               $value = $contactValue;
                               // Make phone numbers clickable
                               $phonePattern = '/(\+?\d{1,4}[-.\s]?\(?\d{1,4}\)?[-.\s]?\d{1,4}[-.\s]?\d{1,9})/';
                               $value = preg_replace_callback($phonePattern, function($matches) {
                                   $phone = $matches[1];
                                   $cleanPhone = preg_replace('/[^\d+]/', '', $phone);
                                   return '<a href="tel:' . $cleanPhone . '" class="text-primary text-decoration-none">' . $phone . '</a>';
                               }, $value);
                               // Make emails clickable
                               $emailPattern = '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/';
                               $value = preg_replace_callback($emailPattern, function($matches) {
                                   $email = $matches[1];
                                   return '<a href="mailto:' . $email . '" class="text-primary text-decoration-none">' . $email . '</a>';
                               }, $value);
                               echo $value;
                           }
                           ?>
                        <?php endif; ?>
                        
                        <?php if (!empty($section['content'])): ?>
                           <br><?php
                           // Function to make phone numbers and emails clickable in content
                           $content = $section['content'];
                           // Pattern to match phone numbers (various formats including international)
                           $phonePattern = '/(\+?\d{1,4}[-.\s]?\(?\d{1,4}\)?[-.\s]?\d{1,4}[-.\s]?\d{1,9})/';
                           $content = preg_replace_callback($phonePattern, function($matches) {
                               $phone = $matches[1];
                               // Clean phone number for tel: link (remove spaces, dashes, dots, parentheses)
                               $cleanPhone = preg_replace('/[^\d+]/', '', $phone);
                               return '<a href="tel:' . $cleanPhone . '" class="text-primary text-decoration-none">' . $phone . '</a>';
                           }, $content);
                           // Make emails clickable
                           $emailPattern = '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/';
                           $content = preg_replace_callback($emailPattern, function($matches) {
                               $email = $matches[1];
                               return '<a href="mailto:' . $email . '" class="text-primary text-decoration-none">' . $email . '</a>';
                           }, $content);
                           echo $content;
                           ?>
                        <?php endif; ?>
                     </p>
                  </div>
               </div>
            </div>
            <?php endforeach; ?>
            
         <?php else: ?>
         
         
    <!-- Fallback to static content if no dynamic sections -->
    
            <div class="col-xl-3 col-lg-3 col-md-6">
               <div class="card p-4 rounded-4 border br-dashed text-center h-100">
                  <div class="crds-icons d-inline-flex mx-auto mb-3 text-primary fs-2"><i class="fa-solid fa-briefcase"></i></div>
                  <div class="crds-desc">
                     <h5>Drop a Mail</h5>
                     <p class="fs-6 text-md lh-2 mb-0">
                        <a href="mailto:info@myfairholidays.com" class="text-primary text-decoration-none">info@myfairholidays.com</a><br>
                        <a href="https://www.myfairholidays.com" target="_blank" class="text-primary text-decoration-none">www.myfairholidays.com</a>
                     </p>
                  </div>
               </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6">
               <div class="card p-4 rounded-4 border br-dashed text-center h-100">
                  <div class="crds-icons d-inline-flex mx-auto mb-3 text-primary fs-2"><i class="fa-solid fa-headset"></i></div>
                  <div class="crds-desc">
                     <h5>Call Us</h5>
                     <p class="fs-6 text-md lh-2 mb-0">
                        <a href="tel:+919971124567" class="text-primary text-decoration-none">+91-9971124567</a><br>
                        <a href="tel:+919582560106" class="text-primary text-decoration-none">+91-9582560106</a>
                     </p>
                  </div>
               </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6">
               <div class="card p-4 rounded-4 border br-dashed text-center h-100">
                  <div class="crds-icons d-inline-flex mx-auto mb-3 text-primary fs-2"><i class="fa-solid fa-location-dot"></i></div>
                  <div class="crds-desc">
                     <h5>Head Office</h5>
                     <p class="fs-6 text-md lh-2 mb-0">Office No O-445, (4th Floor)Gaur City Center, Greater Noida Uttar Pradesh 201307</p>
                  </div>
               </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6">
               <div class="card p-4 rounded-4 border br-dashed text-center h-100">
                  <div class="crds-icons d-inline-flex mx-auto mb-3 text-primary fs-2"><i class="fa-solid fa-location-dot"></i></div>
                  <div class="crds-desc">
                     <h5>Branch Office</h5>
                     <p class="fs-6 text-md lh-2 mb-0">Broadway Shivpora,B.B.Cant Srinagar Airport Distance. 6km,Dal Lake Distance. 3km Pincode : 190004<br>
                     Contact: <a href="tel:+919971124567" class="text-primary text-decoration-none">+91-9971124567</a></p>
                  </div>
               </div>
               
               
    </div>
            
            
            
            
            
         <?php endif; ?>
      </div>
      
      <div class="row align-items-center justify-content-between g-4">
         <div class="col-xl-7 col-lg-7 col-md-12">
            <div class="contactForm gray-simple p-4 rounded-3">
               <form id="contactForm">
                  <?= csrf_field() ?>
                  <div class="row align-items-center">
                     <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="touch-block d-flex flex-column mb-4">
                           <?php
                              $formTitle = 'Drop Us a Line';
                              $formSubtitle = 'Get in touch via form below and we will reply as soon as we can.';
                              if (!empty($formSettingsSection)) {
                                 $formTitle = $formSettingsSection['title'];
                                 if (!empty($formSettingsSection['subtitle'])) {
                                    $formSubtitle = $formSettingsSection['subtitle'];
                                 }
                              }
                              ?>
                           <h2><?= esc($formTitle) ?></h2>
                           <p><?= esc($formSubtitle) ?></p>
                        </div>
                     </div>
                     <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                           <label class="form-label">Your Name <span class="text-danger">*</span></label>
                           <input type="text" name="name" class="form-control" required>
                        </div>
                     </div>
                     <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                           <label class="form-label">Email ID <span class="text-danger">*</span></label>
                           <input type="email" name="email" class="form-control" required>
                        </div>
                     </div>
                     <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                           <label class="form-label">Phone No. <span class="text-danger">*</span></label>
                           <input type="tel" name="phone" class="form-control" required>
                        </div>
                     </div>
                     <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                           <label class="form-label">Subject <span class="text-danger">*</span></label>
                           <input type="text" name="subject" class="form-control" required>
                        </div>
                     </div>
                     <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="form-group">
                           <label class="form-label">Your Query <span class="text-danger">*</span></label>
                           <textarea name="message" class="form-control ht-120" required></textarea>
                        </div>
                     </div>
                     <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="form-group mb-0">
                           <button type="submit" class="btn fw-medium btn-primary" id="submitBtn">
                              Send Message<i class="fa-solid fa-paper-plane ms-2"></i>
                           </button>
                        </div>
                     </div>
                  </div>
               </form>
               
               <!-- Success/Error Messages -->
               <div id="formMessage" class="mt-3" style="display: none;"></div>
            </div>
         </div>
         <div class="col-xl-5 col-lg-5 col-md-12">
            <?php
            $mapEmbedCode = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.823934128228!2d77.42434187409307!3d28.60505828533036!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce15bb128924b%3A0xdb0ad8999d11a006!2sMy%20Fair%20Holidays%20-%20Best%20Travel%20Agency%20in%20Greater%20Noida%20%7C%20Top%20Travel%20Company%20for%20Domestic%20%26%20International%20Packages!5e0!3m2!1sen!2sin!4v1767627511358!5m2!1sen!2sin';
            if (!empty($formSettingsSection['map_embed_code'])) {
                $mapEmbedCode = $formSettingsSection['map_embed_code'];
            }
            ?>
            <iframe class="full-width ht-100 grayscale rounded"
               src="<?= esc($mapEmbedCode) ?>"
               height="500" style="border:0;" aria-hidden="false" tabindex="0"></iframe>
         </div>
      </div>
   </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const formMessage = document.getElementById('formMessage');

    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Disable submit button and show loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Sending...';
        
        // Hide previous messages
        formMessage.style.display = 'none';
        
        // Get form data
        const formData = new FormData(contactForm);
        
        // Send AJAX request
        fetch('<?= base_url('/contact/submit') ?>', {
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
                formMessage.innerHTML = '<div class="alert alert-success"><i class="fa-solid fa-check-circle me-2"></i>' + data.message + '</div>';
                formMessage.style.display = 'block';
                
                // Reset form
                contactForm.reset();
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
            formMessage.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-exclamation-triangle me-2"></i>Something went wrong. Please try again.</div>';
            formMessage.style.display = 'block';
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Send Message<i class="fa-solid fa-paper-plane ms-2"></i>';
            
            // Scroll to message
            formMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    });
});
</script>

<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>