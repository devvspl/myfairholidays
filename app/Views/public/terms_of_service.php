<?php include APPPATH . 'Views/layouts/public_header.php'; ?>
<section class="bg-cover position-relative" style="background-image:url('<?= base_url($page['banner_image'] ?? 'main/images/contactus.png') ?>');background-size: cover;background-position: center;background-repeat: no-repeat;" data-overlay="5">
   <div class="container">
      <div class="row align-items-center justify-content-center">
         <div class="col-xl-7 col-lg-9 col-md-12">
            <div class="fpc-capstion text-center my-4">
               <div class="fpc-captions">
                  <h1 class="xl-heading text-light"><?= esc($page['title']) ?></h1>
                  <p class="text-light">Read our terms and conditions</p>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="fpc-banner"></div>
</section>
<section>
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-md-12">
            <div class="card border-0 rounded-3">
               <div class="card-body p-xl-5 p-lg-4 p-3">
                  <div class="mb-4">
                     <h2 class="fs-3 fw-bold mb-2"><?= esc($page['title']) ?></h2>
                     <?php if (isset($page['updated_at'])): ?>
                     <p class="text-muted mb-0">
                        <i class="fa-regular fa-calendar me-2"></i>Last Updated: <?= date('F d, Y', strtotime($page['updated_at'])) ?>
                     </p>
                     <?php endif; ?>
                  </div>
                  <div class="legal-content">
                     <?= $page['content'] ?>
                  </div>
                  <div class="text-center mt-4">
                     <a href="<?= base_url('/') ?>" class="btn btn-md btn-primary fw-medium">
                     <i class="fa-solid fa-arrow-left me-2"></i>Back to Home
                     </a>
                     <a href="<?= base_url('/contact') ?>" class="btn btn-md btn-light-primary fw-medium ms-2">
                     <i class="fa-solid fa-envelope me-2"></i>Contact Us
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<style>
   .legal-content h2 {
   font-size: 1.5rem;
   font-weight: 600;
   margin-top: 2rem;
   margin-bottom: 1rem;
   color: #2d3748;
   }
   .legal-content h3 {
   font-size: 1.25rem;
   font-weight: 600;
   margin-top: 1.5rem;
   margin-bottom: 0.75rem;
   color: #4a5568;
   }
   .legal-content p {
   margin-bottom: 1rem;
   line-height: 1.7;
   color: #4a5568;
   }
   .legal-content ul, .legal-content ol {
   margin-bottom: 1rem;
   padding-left: 2rem;
   }
   .legal-content li {
   margin-bottom: 0.5rem;
   line-height: 1.7;
   color: #4a5568;
   }
   .legal-content strong {
   font-weight: 600;
   color: #2d3748;
   }
   .legal-content a {
   color: #3b82f6;
   text-decoration: none;
   }
   .legal-content a:hover {
   text-decoration: underline;
   }
</style>
<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>