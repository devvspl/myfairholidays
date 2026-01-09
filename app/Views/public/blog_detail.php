<?php include APPPATH . 'Views/layouts/public_header.php'; ?>
<section class="p-0">
   <div class="thumb-wrap">
      <?php if (!empty($post['featured_image'])): ?>
      <img src="<?= base_url($post['featured_image']) ?>" class="img-fluid full-width ht-500 object-fit" alt="<?= esc($post['title']) ?>">
      <?php else: ?>
      <img src="<?= base_url('custom/default_image.png') ?>" class="img-fluid full-width ht-500 object-fit" alt="<?= esc($post['title']) ?>">
      <?php endif; ?>
   </div>
</section>
<section class="p-0 position-relative mt-n6">
   <div class="container">
      <div class="row g-4">
         <div class="col-11 col-lg-10 mx-auto">
            <div class="bg-white shadow rounded-4 p-4">
               <div class="d-inline-flex mb-2">
                  <span class="label text-success bg-light-success">
                  <?= $post['is_featured'] ? 'Featured Post' : 'Travel Blog' ?>
                  </span>
               </div>
               <h1 class="fs-3"><?= esc($post['title']) ?></h1>
               <?php if (!empty($post['excerpt'])): ?>
               <p class="mb-2"><?= esc($post['excerpt']) ?></p>
               <?php endif; ?>
               <ul class="nav nav-divider align-items-center p-0">
                  <li class="nav-item ps-0">
                     <div class="nav-link">
                        <div class="d-flex align-items-center">
                           <div class="avatar avatar-lg">
                              <img class="avatar-img circle" src="<?= base_url('assets/images/users/user.png') ?>" alt="<?= esc($post['author_name'] ?? 'Author') ?>">
                           </div>
                           <div class="ms-2">
                              <h6 class="mb-0">
                                 <a href="#"><?= esc($post['author_name'] ?? 'My Fair Holidays') ?></a>
                              </h6>
                              <p class="mb-0">
                                 <span><?= date('d M Y', strtotime($post['created_at'])) ?></span>
                                 <span class="text-muted-2 mx-2">.</span>
                                 <span><?= ceil(str_word_count(strip_tags($post['content'])) / 200) ?> min read</span>
                              </p>
                           </div>
                        </div>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</section>
<section>
   <div class="container">
      <div class="row">
         <div class="col-lg-10 mx-auto">
            <div class="blog-content">
               <?= $post['content'] ?>
            </div>
            <div class="d-lg-flex justify-content-lg-between mt-4">
               <div class="align-items-center mb-3 mb-lg-0">
                  <h6 class="d-inline-block mb-2 me-4">Share This:</h6>
                  <ul class="list-inline hstack flex-wrap gap-3 h6 fw-normal mb-0">
                     <li class="list-inline-item">
                        <a class="text-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank">
                        <i class="fa-brands fa-facebook-square"></i> Facebook
                        </a>
                     </li>
                     <li class="list-inline-item">
                        <a class="text-twitter" href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($post['title']) ?>" target="_blank">
                        <i class="fa-brands fa-twitter-square"></i> Twitter
                        </a>
                     </li>
                     <li class="list-inline-item">
                        <a class="text-primary" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(current_url()) ?>" target="_blank">
                        <i class="fa-brands fa-linkedin-square"></i> LinkedIn
                        </a>
                     </li>
                  </ul>
               </div>
               <div class="align-items-center">
                  <h6 class="d-inline-block mb-2 me-4">Popular Tags:</h6>
                  <ul class="list-inline mb-0">
                     <li class="list-inline-item">
                        <a class="btn btn-light btn-sm mb-xl-0" href="<?= base_url('/blog') ?>">Travel</a>
                     </li>
                     <li class="list-inline-item">
                        <a class="btn btn-light btn-sm mb-xl-0" href="<?= base_url('/blog') ?>">Holiday</a>
                     </li>
                     <li class="list-inline-item">
                        <a class="btn btn-light btn-sm mb-xl-0" href="<?= base_url('/blog') ?>">Destination</a>
                     </li>
                     <li class="list-inline-item">
                        <a class="btn btn-light btn-sm mb-xl-0" href="<?= base_url('/blog') ?>">My Fair Holidays</a>
                     </li>
                  </ul>
               </div>
            </div>
            <?php if (!empty($relatedPosts)): ?>
            <div class="mt-5">
               <h4 class="mb-4">Related Articles</h4>
               <div class="row g-4">
                  <?php foreach ($relatedPosts as $relatedPost): ?>
                  <div class="col-md-4">
                     <div class="card border-0 shadow-sm">
                        <?php if (!empty($relatedPost['featured_image'])): ?>
                        <img src="<?= base_url($relatedPost['featured_image']) ?>" class="card-img-top" alt="<?= esc($relatedPost['title']) ?>">
                        <?php else: ?>
                        <img src="<?= base_url('custom/default_image.png') ?>" class="card-img-top" alt="<?= esc($relatedPost['title']) ?>">
                        <?php endif; ?>
                        <div class="card-body">
                           <h6 class="card-title">
                              <a href="<?= base_url('/blog/' . $relatedPost['slug']) ?>" class="text-dark text-decoration-none">
                              <?= esc($relatedPost['title']) ?>
                              </a>
                           </h6>
                           <p class="card-text small text-muted">
                              <?= esc(substr(strip_tags($relatedPost['excerpt'] ?: $relatedPost['content']), 0, 80)) ?>...
                           </p>
                           <small class="text-muted">
                           <?= date('M d, Y', strtotime($relatedPost['created_at'])) ?>
                           </small>
                        </div>
                     </div>
                  </div>
                  <?php endforeach; ?>
               </div>
            </div>
            <?php endif; ?>
         </div>
      </div>
   </div>
</section>
<?php include APPPATH . 'Views/layouts/public_footer.php'; ?>