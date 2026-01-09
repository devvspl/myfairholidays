<?php include APPPATH . 'Views/layouts/public_header.php'; ?>
<section class="bg-cover position-relative" style="background:url(<?= base_url('main/images/home-img/banner-02.webp') ?>)no-repeat;" data-overlay="5">
   <div class="container">
      <div class="row align-items-center justify-content-center">
         <div class="col-xl-7 col-lg-9 col-md-12">
            <div class="fpc-capstion text-center my-4">
               <div class="fpc-captions">
                  <h1 class="xl-heading text-light">Travel Blog</h1>
                  <p class="text-light">Discover amazing destinations, travel tips, and insider guides from our travel experts. Get inspired for your next adventure!</p>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="fpc-banner"></div>
</section>
<section>
   <div class="container">
      <div class="row justify-content-center g-4">
         <?php if (!empty($posts)): ?>
         <?php foreach ($posts as $post): ?>
         <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
            <div class="blogGrid-wrap d-flex flex-column h-100">
               <div class="blogGrid-pics">
                  <a href="<?= base_url('/blog/' . $post['slug']) ?>" class="d-block">
                  <?php if (!empty($post['featured_image'])): ?>
                  <img src="<?= base_url($post['featured_image']) ?>" class="img-fluid rounded" alt="<?= esc($post['title']) ?>">
                  <?php else: ?>
                  <img src="<?= base_url('custom/default_image.png') ?>" class="img-fluid rounded" alt="<?= esc($post['title']) ?>">
                  <?php endif; ?>
                  </a>
               </div>
               <div class="blogGrid-caps pt-3">
                  <div class="d-flex align-items-center mb-1">
                     <span class="label text-success bg-light-success">
                     <?= $post['is_featured'] ? 'Featured' : 'Travel' ?>
                     </span>
                  </div>
                  <h4 class="fw-bold fs-6 lh-base">
                     <a href="<?= base_url('/blog/' . $post['slug']) ?>" class="text-dark">
                     <?= esc($post['title']) ?>
                     </a>
                  </h4>
                  <p class="mb-3">
                     <?= esc(substr(strip_tags($post['excerpt'] ?: $post['content']), 0, 150)) ?>...
                  </p>
                  <div class="d-flex align-items-center justify-content-between">
                     <a class="text-primary fw-medium" href="<?= base_url('/blog/' . $post['slug']) ?>">
                     Read More<i class="fa-solid fa-arrow-trend-up ms-2"></i>
                     </a>
                     <small class="text-muted">
                     <?= date('M d, Y', strtotime($post['created_at'])) ?>
                     </small>
                  </div>
               </div>
            </div>
         </div>
         <?php endforeach; ?>
         <?php else: ?>
         <div class="col-12 text-center py-5">
            <div class="alert alert-info">
               <h5>No Blog Posts Available</h5>
               <p>Check back later for exciting travel stories and tips!</p>
            </div>
         </div>
         <?php endif; ?>
      </div>
      <?php if (!empty($posts) && $pager->getPageCount() > 1): ?>
      <div class="row align-items-center">
         <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="d-flex align-items-center justify-content-center mt-5 mx-auto text-center">
               <?= $pager->links() ?>
            </div>
         </div>
      </div>
      <?php endif; ?>
   </div>
</section>
<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>