<!DOCTYPE html>
<html lang="en">
<head>
     <!-- Title Meta -->
     <meta charset="utf-8" />
     <title><?= $title ?? 'Dashboard' ?> | My Fair Holidays</title>
     <meta name="viewport" content="width=device-width, initial-scale=1" />
     <meta name="description" content="Multi-Role Authentication System Dashboard" />
     <meta name="author" content="Your Company" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />
     <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>">

     <link href="<?= base_url('assets/css/vendor.min.css') ?>" rel="stylesheet" type="text/css" />
     <link href="<?= base_url('assets/css/app.min.css') ?>" rel="stylesheet" type="text/css" />
     <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet" type="text/css" />
     <script src="<?= base_url('assets/js/config.min.js') ?>"></script>
     <script src="<?= base_url('assets/js/admin-common.js') ?>"></script>
     
     <script>
          // Initialize CSRF tokens for admin pages
          document.addEventListener('DOMContentLoaded', function() {
               if (typeof AdminCSRF !== 'undefined') {
                    AdminCSRF.init('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
               }
               
               // Handle active menu states
               setActiveMenu();
          });
          
          function setActiveMenu() {
               const currentPath = window.location.pathname;
               const menuItems = document.querySelectorAll('#navbar-nav .menu-item');
               
               // Remove all active classes first
               menuItems.forEach(item => {
                    item.classList.remove('active');
                    const menuLink = item.querySelector('.menu-link');
                    if (menuLink) {
                         menuLink.classList.remove('active');
                    }
                    const subMenuItems = item.querySelectorAll('.sub-menu-item');
                    subMenuItems.forEach(subItem => {
                         subItem.classList.remove('active');
                         const subLink = subItem.querySelector('.sub-menu-link');
                         if (subLink) {
                              subLink.classList.remove('active');
                         }
                    });
               });
               
               // Find and activate current menu item
               let foundMatch = false;
               
               menuItems.forEach(item => {
                    const menuLink = item.querySelector('.menu-link');
                    const subMenuLinks = item.querySelectorAll('.sub-menu-link');
                    
                    // Check main menu link (only for direct links, not dropdowns)
                    if (menuLink && !menuLink.hasAttribute('data-bs-toggle')) {
                         const href = menuLink.getAttribute('href');
                         if (href && href !== 'javascript:void(0);') {
                              try {
                                   const linkPath = new URL(href, window.location.origin).pathname;
                                   if (currentPath === linkPath) {
                                        item.classList.add('active');
                                        menuLink.classList.add('active');
                                        foundMatch = true;
                                        return;
                                   }
                              } catch (e) {
                                   // Handle relative URLs
                                   if (currentPath === href) {
                                        item.classList.add('active');
                                        menuLink.classList.add('active');
                                        foundMatch = true;
                                        return;
                                   }
                              }
                         }
                    }
                    
                    // Check sub menu links
                    if (!foundMatch) {
                         subMenuLinks.forEach(subLink => {
                              const href = subLink.getAttribute('href');
                              if (href && href !== 'javascript:void(0);') {
                                   try {
                                        const linkPath = new URL(href, window.location.origin).pathname;
                                        if (currentPath === linkPath) {
                                             // Activate sub menu item
                                             subLink.closest('.sub-menu-item').classList.add('active');
                                             subLink.classList.add('active');
                                             // Activate parent menu item
                                             item.classList.add('active');
                                             menuLink.classList.add('active');
                                             // Expand parent menu
                                             const collapse = item.querySelector('.collapse');
                                             if (collapse) {
                                                  collapse.classList.add('show');
                                             }
                                             foundMatch = true;
                                        }
                                   } catch (e) {
                                        // Handle relative URLs
                                        if (currentPath === href) {
                                             subLink.closest('.sub-menu-item').classList.add('active');
                                             subLink.classList.add('active');
                                             item.classList.add('active');
                                             menuLink.classList.add('active');
                                             const collapse = item.querySelector('.collapse');
                                             if (collapse) {
                                                  collapse.classList.add('show');
                                             }
                                             foundMatch = true;
                                        }
                                   }
                              }
                         });
                    }
               });
          }
     </script>
</head>

<body>
     <!-- START Wrapper -->
     <div class="wrapper">
          <div class="main-nav">
               <div class="d-flex justify-content-between main-logo-box">
                    <!-- Sidebar Logo -->
                    <div class="logo-box">
                         <a href="<?= base_url('/') ?>" class="logo-dark">
                              <img src="<?= base_url('assets/images/logo-sm.png') ?>" class="logo-sm" alt="logo sm">
                              <img src="<?= base_url('custom/logo.webp') ?>" class="logo-lg" alt="logo dark">
                         </a>
                         <a href="<?= base_url('/') ?>" class="logo-light">
                              <img src="<?= base_url('assets/images/logo-sm.png') ?>" class="logo-sm" alt="logo sm">
                              <img src="<?= base_url('assets/images/logo-white.png') ?>" class="logo-lg" alt="logo light">
                         </a>
                    </div>
                    <!-- Menu Toggle Button -->
                    <button type="button" class="btn btn-link d-flex button-sm-hover button-toggle-menu" aria-label="Show Full Sidebar">
                         <i data-lucide="menu" class="button-sm-hover-icon"></i>
                    </button>
               </div>

               <div class="h-100" data-simplebar>
                    <ul class="navbar-nav" id="navbar-nav">
                         <?php $userRole = session()->get('user_role'); ?>
                         
                         <?php if ($userRole === 'admin'): ?>
                         
                         <!-- Dashboard -->
                         <li class="menu-item">
                              <a class="menu-link" href="<?= base_url('/admin/dashboard') ?>">
                                   <span class="nav-icon">
                                        <i data-lucide="house"></i>
                                   </span>
                                   <span class="nav-text"> Dashboard </span>
                              </a>
                         </li>

                         <!-- User & Access Management -->
                         <li class="menu-item">
                              <a class="menu-link" href="#sidebarUserManagement" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarUserManagement">
                                   <span class="nav-icon">
                                        <i data-lucide="users"></i>
                                   </span>
                                   <span class="nav-text"> User & Access </span>
                                   <span class="menu-arrow">
                                        <i data-lucide="chevron-down"></i>
                                   </span>
                              </a>
                              <div class="collapse" id="sidebarUserManagement">
                                   <ul class="sub-menu-nav">
                                        <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/user-management') ?>">Users</a>
                                        </li>
                                        <!-- <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/roles') ?>">Roles & Permissions</a>
                                        </li> -->
                                   </ul>
                              </div>
                         </li>

                         <!-- Content Management -->
                         <li class="menu-item">
                              <a class="menu-link" href="#sidebarContentManagement" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarContentManagement">
                                   <span class="nav-icon">
                                        <i data-lucide="notebook-text"></i>
                                   </span>
                                   <span class="nav-text"> Content </span>
                                   <span class="menu-arrow">
                                        <i data-lucide="chevron-down"></i>
                                   </span>
                              </a>
                              <div class="collapse" id="sidebarContentManagement">
                                   <ul class="sub-menu-nav">
                                          <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/about-sections') ?>">About Page</a>
                                        </li>
                                        <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/contact-sections') ?>">Contact Page</a>
                                        </li>

                                         <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/tourism-alliances') ?>">Tourism Alliances</a>
                                        </li>
                                       

                                        <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/blogs') ?>">Blogs</a>
                                        </li>
                                        <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/testimonials') ?>">Testimonials</a>
                                        </li>
                                        <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/testimonial-categories') ?>">Testimonial Categories</a>
                                        </li>

                                         <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/contacts') ?>">Contact Messages</a>
                                        </li>
                                       
                                   </ul>
                              </div>
                         </li>

                         <!-- Travel Management -->
                         <li class="menu-item">
                              <a class="menu-link" href="#sidebarTravelManagement" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarTravelManagement">
                                   <span class="nav-icon">
                                        <i data-lucide="map"></i>
                                   </span>
                                   <span class="nav-text"> Travel </span>
                                   <span class="menu-arrow">
                                        <i data-lucide="chevron-down"></i>
                                   </span>
                              </a>
                              <div class="collapse" id="sidebarTravelManagement">
                                   <ul class="sub-menu-nav">
                                        <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/destinations') ?>">Destinations</a>
                                        </li>
                                        <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/destination-types') ?>">Destination Types</a>
                                        </li>
                                        <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/hotels') ?>">Hotels</a>
                                        </li>
                                        <!-- <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/itineraries') ?>">Itineraries</a>
                                        </li>
                                        <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/itinerary-categories') ?>">Itinerary Categories</a>
                                        </li> -->
                                   </ul>
                              </div>
                         </li>

                         <!-- Media Management -->
                         <li class="menu-item">
                              <a class="menu-link" href="#sidebarMediaManagement" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMediaManagement">
                                   <span class="nav-icon">
                                        <i data-lucide="image"></i>
                                   </span>
                                   <span class="nav-text"> Media </span>
                                   <span class="menu-arrow">
                                        <i data-lucide="chevron-down"></i>
                                   </span>
                              </a>
                              <div class="collapse" id="sidebarMediaManagement">
                                   <ul class="sub-menu-nav">
                                        <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/images') ?>">Image Gallery</a>
                                        </li>
                                        <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/admin/videos') ?>">Video Gallery</a>
                                        </li>
                                   </ul>
                              </div>
                         </li>

                         <!-- Bookings -->
                         <li class="menu-item">
                              <a class="menu-link" href="<?= base_url('/admin/bookings') ?>">
                                   <span class="nav-icon">
                                        <i data-lucide="calendar-check"></i>
                                   </span>
                                   <span class="nav-text"> Bookings </span>
                              </a>
                         </li>

                         <!-- Payments -->
                         <li class="menu-item">
                              <a class="menu-link" href="<?= base_url('/admin/payment-history') ?>">
                                   <span class="nav-icon">
                                        <i data-lucide="credit-card"></i>
                                   </span>
                                   <span class="nav-text"> Payments </span>
                              </a>
                         </li>

                         <!-- System -->
                         <li class="menu-title">System</li>
                         <li class="menu-item">
                              <a class="menu-link" href="#sidebarSystemManagement" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSystemManagement">
                                   <span class="nav-icon">
                                        <i data-lucide="settings"></i>
                                   </span>
                                   <span class="nav-text"> Settings </span>
                                   <span class="menu-arrow">
                                        <i data-lucide="chevron-down"></i>
                                   </span>
                              </a>
                              <div class="collapse" id="sidebarSystemManagement">
                                   <ul class="sub-menu-nav">
                                        <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="javascript:void(0);">General Settings</a>
                                        </li>
                                        <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="javascript:void(0);">Activity Logs</a>
                                        </li>
                                   </ul>
                              </div>
                         </li>

                         <?php elseif ($userRole === 'manager'): ?>
                         
                         <!-- Manager Dashboard -->
                         <li class="menu-item">
                              <a class="menu-link" href="<?= base_url('/manager/dashboard') ?>">
                                   <span class="nav-icon">
                                        <i data-lucide="house"></i>
                                   </span>
                                   <span class="nav-text"> Dashboard </span>
                              </a>
                         </li>

                         <!-- Team Management -->
                         <li class="menu-item">
                              <a class="menu-link" href="<?= base_url('/manager/users') ?>">
                                   <span class="nav-icon">
                                        <i data-lucide="users"></i>
                                   </span>
                                   <span class="nav-text"> Team Members </span>
                              </a>
                         </li>

                         <!-- Content Management (Limited) -->
                         <li class="menu-item">
                              <a class="menu-link" href="#sidebarManagerContent" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarManagerContent">
                                   <span class="nav-icon">
                                        <i data-lucide="notebook-text"></i>
                                   </span>
                                   <span class="nav-text"> Content </span>
                                   <span class="menu-arrow">
                                        <i data-lucide="chevron-down"></i>
                                   </span>
                              </a>
                              <div class="collapse" id="sidebarManagerContent">
                                   <ul class="sub-menu-nav">
                                        <li class="sub-menu-item">
                                             <a class="sub-menu-link" href="<?= base_url('/manager/testimonials') ?>">Testimonials</a>
                                        </li>
                                   </ul>
                              </div>
                         </li>

                         <?php else: ?>
                         
                         <!-- User Dashboard -->
                         <li class="menu-item">
                              <a class="menu-link" href="<?= base_url('/user/dashboard') ?>">
                                   <span class="nav-icon">
                                        <i data-lucide="house"></i>
                                   </span>
                                   <span class="nav-text"> Dashboard </span>
                              </a>
                         </li>

                         <!-- User Profile -->
                         <li class="menu-item">
                              <a class="menu-link" href="<?= base_url('/user/profile') ?>">
                                   <span class="nav-icon">
                                        <i data-lucide="circle-user"></i>
                                   </span>
                                   <span class="nav-text"> My Profile </span>
                              </a>
                         </li>

                         <!-- User Bookings -->
                         <li class="menu-item">
                              <a class="menu-link" href="<?= base_url('/user/bookings') ?>">
                                   <span class="nav-icon">
                                        <i data-lucide="calendar"></i>
                                   </span>
                                   <span class="nav-text"> My Bookings </span>
                              </a>
                         </li>

                         <?php endif; ?>

                         <!-- Logout (All Roles) -->
                         <li class="menu-item">
                              <a class="menu-link" href="<?= base_url('/auth/logout') ?>">
                                   <span class="nav-icon">
                                        <i data-lucide="log-out"></i>
                                   </span>
                                   <span class="nav-text"> Logout </span>
                              </a>
                         </li>
                    </ul>
               </div>
          </div>

          <header class="topbar d-flex">
               <div class="container-fluid">
                    <div class="navbar-header">
                         <div class="d-flex align-items-center gap-2">
                              <!-- App Search-->
                              <form class="app-search d-none d-md-block me-auto">
                                   <div class="position-relative">
                                        <input type="search" class="form-control" placeholder="Start typing..." autocomplete="off" value="">
                                        <i data-lucide="search" class="search-widget-icon"></i>
                                   </div>
                              </form>
                         </div>

                         <div class="d-flex align-items-center gap-2 ms-auto">
                              <!-- Theme Color (Light/Dark) -->
                              <div class="topbar-item">
                                   <button type="button" class="topbar-button fs-24" id="light-dark-mode">
                                        <i data-lucide="moon" class="light-mode"></i>
                                        <i data-lucide="sun" class="dark-mode"></i>
                                   </button>
                              </div>

                              <!-- User -->
                              <div class="dropdown topbar-item">
                                   <a type="button" class="topbar-button p-0" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="d-flex align-items-center gap-2">
                                             <img class="rounded-circle" width="32" src="<?= base_url('assets/images/users/user.png') ?>" alt="user-image">
                                             <span class="d-lg-flex flex-column gap-1 d-none">
                                                  <h5 class="my-0 text-reset fs-14"><?= session()->get('user_name') ?></h5>
                                                  <small class="text-muted"><?= ucfirst(session()->get('user_role')) ?></small>
                                             </span>
                                        </span>
                                   </a>

                              </div>
                         </div>
                    </div>
               </div>
          </header>

          <!-- Start Content here -->
          <div class="page-container">
               <!-- Start Container Fluid -->
               <div class="page-content">