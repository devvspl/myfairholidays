<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?= isset($title) ? esc($title) : 'My Fair Holidays: Best Domestic & International Travel Agency in Noida' ?></title>
      <?php if (isset($meta_description)): ?>
      <meta name="description" content="<?= esc($meta_description) ?>">
      <?php endif; ?>
      <?php if (isset($meta_keywords)): ?>
      <meta name="keywords" content="<?= esc($meta_keywords) ?>">
      <?php endif; ?>
      <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>main/images/logo.png">
      <link href="<?php echo base_url(); ?>main/css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>main/css/animation.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>main/css/dropzone.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>main/css/flatpickr.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>main/css/flickity.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>main/css/lightbox.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>main/css/magnifypopup.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>main/css/select2.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>main/css/rangeSlider.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>main/css/prism.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>main/css/bootstrap-icons.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>main/css/fontawesome.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>main/css/template.css" rel="stylesheet">
            <link href="<?php echo base_url(); ?>main/css/style.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
   </head>
   <body>
      <div id="preloader">
         <div class="preloader"><span></span><span></span></div>
      </div>
      <div id="main-wrapper">
      <div class="top-bar">
         <div class="info-side">
            <span><i class="fas fa-envelope"></i><a href="mailto:info@myfairholidays.com" style="color: inherit; text-decoration: none;">info@myfairholidays.com</a></span>
            <span><i class="fas fa-map-marker-alt"></i>Gaur City Center, Greater Noida Uttar Pradesh 201307</span>
         </div>
         <div class="social-side">
    <a href="https://www.facebook.com/MyFairHolidays" target="_blank" title="Facebook">
        <i class="fab fa-facebook-f"></i>
    </a>

    <a href="https://www.instagram.com/myfairholidays/" target="_blank" title="Instagram">
        <i class="fab fa-instagram"></i>
    </a>

    <a href="https://twitter.com/MyFairHolidays" target="_blank" title="Twitter">
        <i class="fab fa-twitter"></i>
    </a>

    <a href="https://www.linkedin.com/company/my-fair-holidays" target="_blank" title="LinkedIn">
        <i class="fab fa-linkedin-in"></i>
    </a>

    <a href="https://www.youtube.com/channel/UCWpKAllkfYN6fUN_3D2A4Bw" target="_blank" title="YouTube">
        <i class="fab fa-youtube"></i>
    </a>

    <a href="https://wa.me/9971124567" target="_blank" title="WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>

      </div>
      <header class="mfh-header">
         <div class="mfh-container">
            <a href="<?php echo base_url(); ?>" class="mfh-logo">
            <img src="<?php echo base_url(); ?>main/images/logo.png" alt="My Fair Holidays">
            </a>
            <div class="mfh-hamburger" id="mfhHamburger">
               <span></span>
               <span></span>
               <span></span>
            </div>
            <nav class="mfh-nav" id="mfhNav">
               <div class="mfh-close" id="mfhClose">&times;</div>
               <ul class="mfh-menu">
                  <li><a href="<?= base_url('/') ?>">Home</a></li>
                  <li><a href="<?= base_url('/about') ?>">About Us</a></li>
                  <?php if (!empty($destinationTypes) && is_array($destinationTypes)): ?>
                     <?php foreach ($destinationTypes as $type): ?>
                        <li class="mfh-dropdown">
                           <a href="<?= base_url('/hotels?destination_type=' . strtolower($type['name'])) ?>">
                              <?= esc($type['name']) ?> <span class="mfh-arrow"></span>
                           </a>
                           <?php if (!empty($type['destinations']) && is_array($type['destinations'])): ?>
                              <ul>
                                 <?php foreach ($type['destinations'] as $destination): ?>
                                    <li><a href="<?= base_url('/hotels?search=&destination_id=' . $destination['id']) ?>"><?= esc($destination['name']) ?></a></li>
                                 <?php endforeach; ?>
                              </ul>
                           <?php endif; ?>
                        </li>
                     <?php endforeach; ?>
                  <?php endif; ?>
                  <li><a href="<?= base_url('/testimonials') ?>">Testimonials</a></li>
                  <li><a href="<?= base_url('/contact') ?>">Contact Us</a></li>
                  <li class="nav-search">
                     <a href="javascript:void(0);" class="search-toggle">
                     <i class="bi bi-search"></i>
                     </a>
                  </li>
                  <li class="mfh-mobile-btn">
                     <a href="<?= base_url('/contact') ?>" class="mfh-btn">Request A Quote</a>
                  </li>
               </ul>
            </nav>
            <a href="<?= base_url('/contact') ?>" class="mfh-btn mfh-desktop-btn">Request A Quote</a>
         </div>
      </header>
      <div class="clearfix"></div>