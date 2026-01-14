<!DOCTYPE html>
<html lang="en">
<head>
     <!-- Title Meta -->
     <meta charset="utf-8" />
     <title>Sign In | My Fair Holidays</title>
     <meta name="viewport" content="width=device-width, initial-scale=1" />
     <meta name="description" content="Multi-Role Authentication System." />
     <meta name="author" content="Your Company" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />
     <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>">

     <link href="<?= base_url('assets/css/vendor.min.css') ?>" rel="stylesheet" type="text/css" />
     <link href="<?= base_url('assets/css/app.min.css') ?>" rel="stylesheet" type="text/css" />
     <script src="<?= base_url('assets/js/config.min.js') ?>"></script>
</head>

<body>
     <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
          <div class="container">
               <div class="row justify-content-center">
                    <div class="col-xl-5">
                         <div class="card auth-card">
                              <div class="card-body">
                                   <div class="p-3">
                                        <div class="mx-auto mb-2 auth-logo text-center">
                                             <a href="<?= base_url('/') ?>" class="logo-dark">
                                                  <img src="<?= base_url('custom/logo.webp') ?>" height="60" alt="logo dark">
                                             </a>
                                             <a href="<?= base_url('/') ?>" class="logo-light">
                                                  <img src="<?= base_url('assets/images/logo-white.png') ?>" height="60" alt="logo light">
                                             </a>
                                        </div>

                                        <div class="text-center">
                                             <h3 class="fw-bold text-dark fs-20">Hi, Welcome Back 👋</h3>
                                             <p class="text-muted mt-1 mb-2">Enter your credentials to access your account.</p>
                                        </div>

                                        <?php if (session()->getFlashdata('success')): ?>
                                             <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                  <?= session()->getFlashdata('success') ?>
                                                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                             </div>
                                        <?php endif; ?>

                                        <?php if (session()->getFlashdata('error')): ?>
                                             <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                  <?= session()->getFlashdata('error') ?>
                                                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                             </div>
                                        <?php endif; ?>
                                        
                                        <div class="p-3">
                                             <form action="<?= base_url('/auth/login') ?>" method="post" class="authentication-form">
                                                  <?= csrf_field() ?>
                                                  
                                                  <div class="mb-4">
                                                       <label class="form-label" for="UserEmail">Email</label>
                                                       <div class="position-relative w-100">
                                                            <input type="email" 
                                                                   class="form-control form-control-lg rounded <?= (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : '' ?>" 
                                                                   id="UserEmail" 
                                                                   name="email"
                                                                   value="<?= old('email') ?>"
                                                                   placeholder="Enter Email" 
                                                                   required>
                                                            <p class="text-muted p-0 position-absolute end-0 top-50 border-0 fs-4 translate-middle-y me-2 mb-0">
                                                                 <iconify-icon icon="solar:letter-bold-duotone" class="fs-20 mt-1 text-muted"></iconify-icon>
                                                            </p>
                                                            <?php if (isset($validation) && $validation->hasError('email')): ?>
                                                                 <div class="invalid-feedback">
                                                                      <?= $validation->getError('email') ?>
                                                                 </div>
                                                            <?php endif; ?>
                                                       </div>
                                                  </div>
                                                  
                                                  <div class="mb-4">
                                                       <a href="#" class="float-end fw-semibold text-reset ms-1">Reset password</a>
                                                       <label class="form-label" for="UserPass">Password</label>
                                                       <div class="position-relative w-100">
                                                            <input type="password" 
                                                                   class="form-control form-control-lg rounded <?= (isset($validation) && $validation->hasError('password')) ? 'is-invalid' : '' ?>" 
                                                                   id="UserPass" 
                                                                   name="password"
                                                                   placeholder="Enter password" 
                                                                   required>
                                                            <button type="button" class="btn text-muted p-0 position-absolute end-0 top-50 border-0 fs-4 translate-middle-y me-2">
                                                                 <iconify-icon icon="solar:eye-bold-duotone" class="fs-20 mt-1 text-muted"></iconify-icon>
                                                            </button>
                                                            <?php if (isset($validation) && $validation->hasError('password')): ?>
                                                                 <div class="invalid-feedback">
                                                                      <?= $validation->getError('password') ?>
                                                                 </div>
                                                            <?php endif; ?>
                                                       </div>
                                                  </div>
                                                  
                                                  <div class="mb-3">
                                                       <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox-signin" name="remember">
                                                            <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                                       </div>
                                                  </div>
                                                  
                                                  <div class="text-center d-grid">
                                                       <button class="btn btn-primary d-flex align-items-center justify-content-center gap-1 fw-medium" type="submit">
                                                            <i data-lucide="log-in" class="fs-18"></i> Sign In
                                                       </button>
                                                  </div>
                                             </form>
                                        </div>
                                        <p class="text-muted text-center mb-0">Don't have an account? <a href="<?= base_url('/auth/register') ?>" class="link-primary fst-italic text-decoration-underline fw-semibold">Sign up</a></p>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>

     <script src="<?= base_url('assets/js/vendor.js') ?>"></script>
     <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>