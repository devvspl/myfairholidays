<?php include APPPATH . 'Views/layouts/public_header.php'; ?>

<!-- Hero Section -->
<?php if (!empty($heroSection)): ?>
<section class="bg-cover position-relative" style="background:url(<?= base_url($heroSection['background_image'] ?? 'assets/images/home-img/bg.webp') ?>)no-repeat;" data-overlay="5">
   <div class="container">
      <div class="row align-items-center justify-content-center">
         <div class="col-xl-7 col-lg-9 col-md-12">
            <div class="fpc-capstion text-center my-4">
               <div class="fpc-captions">
                  <h1 class="xl-heading text-light"><?= esc($heroSection['title']) ?></h1>
                  <?php if (!empty($heroSection['subtitle'])): ?>
                  <p class="text-light fs-5"><?= esc($heroSection['subtitle']) ?></p>
                  <?php endif; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="fpc-banner"></div>
</section>
<?php endif; ?>

<!-- Mission Section -->
<?php if (!empty($missionSection)): ?>
<section>
   <div class="container">
      <div class="row align-items-center justify-content-between g-4">
         <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="">
               <h2 class="lh-base fs-1 fw-bold"><?= esc($missionSection['title']) ?></h2>
               <?php if (!empty($missionSection['subtitle'])): ?>
               <h3 class="fs-4 text-muted mb-3"><?= esc($missionSection['subtitle']) ?></h3>
               <?php endif; ?>
               <?php if (!empty($missionSection['content'])): ?>
               <div class="mission-content">
                  <?= $missionSection['content'] ?>
               </div>
               <?php endif; ?>
            </div>
         </div>
         <div class="col-xl-5 col-lg-6 col-md-6">
            <div class="position-relative">
               <img src="<?= base_url($missionSection['image_path'] ?? 'assets/images/side-3.webp') ?>" class="img-fluid" alt="<?= esc($missionSection['title']) ?>">
            </div>
         </div>
      </div>
   </div>
</section>
<?php endif; ?>

<!-- Stats Section -->
<?php if (!empty($statsSection)): ?>
<section class="py-4 gray">
   <div class="container">
      <div class="row align-items-center justify-content-between g-4">
         <?php foreach ($statsSection as $stat): ?>
         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
            <div class="urfacts-wrap d-flex align-items-center justify-content-center">
               <div class="urfacts-first flex-shrink-0">
                  <h3 class="fs-1 fw-medium text-primary mb-0"><?= esc($stat['stat_value']) ?></h3>
               </div>
               <div class="urfacts-caps ps-3">
                  <p class="text-muted-2 lh-base mb-0"><?= $stat['stat_label'] ?></p>
               </div>
            </div>
         </div>
         <?php endforeach; ?>
      </div>
   </div>
</section>
<?php endif; ?>

<!-- Features Section -->
<?php if (!empty($featuresSection)): ?>
<section style="padding:70px 20px; background:#ffffff; font-family: Arial, sans-serif;">
   <div style="max-width:1200px; margin:auto; text-align:center;">
      <h2 style="font-size:36px; font-weight:700; margin-bottom:10px;">
         Why Choose My Fair Holidays?
      </h2>
      <p style="max-width:700px; margin:0 auto 50px; color:#666; line-height:1.6;">
         Personalized travel planning, flexible options, and trusted partnerships —
         everything you need for a stress-free holiday.
      </p>
      <div style="display:flex; gap:30px; flex-wrap:wrap; justify-content:center;">
         <?php foreach ($featuresSection as $feature): ?>
         <div style="flex:1; min-width:280px; max-width:360px; border:1px solid #e6e6e6; border-radius:14px; padding:30px; text-align:left;">
            <?php if (!empty($feature['icon'])): ?>
            <div style="width:55px; height:55px; background:#f1f6ff; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:20px; font-size:24px;">
               <?= $feature['icon'] ?>
            </div>
            <?php endif; ?>
            <h4 style="font-size:20px; margin-bottom:10px;"><?= esc($feature['title']) ?></h4>
            <?php if (!empty($feature['content'])): ?>
            <div style="color:#666; line-height:1.6;">
               <?= $feature['content'] ?>
            </div>
            <?php endif; ?>
         </div>
         <?php endforeach; ?>
      </div>
   </div>
</section>
<?php endif; ?>

<style>
.mission-content p {
    margin-bottom: 1rem;
    line-height: 1.6;
}

.mission-content h1, .mission-content h2, .mission-content h3, 
.mission-content h4, .mission-content h5, .mission-content h6 {
    color: #333;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.mission-content ul, .mission-content ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.mission-content li {
    margin-bottom: 0.25rem;
}

.mission-content strong {
    font-weight: 600;
    color: #333;
}

.mission-content em {
    font-style: italic;
}

.mission-content a {
    color: #007bff;
    text-decoration: none;
}

.mission-content a:hover {
    text-decoration: underline;
}
</style>

<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>