<!DOCTYPE html>
<html lang="en">
<head>
     <!-- Title Meta -->
     <meta charset="utf-8" />
     <title>Sign Up | My Fair Holidays</title>
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
                                             <h3 class="fw-bold text-dark fs-20">Hi, Sign Up 👋</h3>
                                             <p class="text-muted mt-1 mb-2">New to our platform? Sign up now! It only takes a minute.</p>
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
                                             <form action="<?= base_url('/auth/register') ?>" method="post" class="authentication-form">
                                                  <?= csrf_field() ?>
                                                  
                                                  <div class="mb-3">
                                                       <label class="form-label" for="UserName">Name</label>
                                                       <div class="position-relative w-100">
                                                            <input type="text" 
                                                                   class="form-control form-control-lg rounded <?= (isset($validation) && $validation->hasError('name')) ? 'is-invalid' : '' ?>" 
                                                                   id="UserName" 
                                                                   name="name"
                                                                   value="<?= old('name') ?>"
                                                                   placeholder="Enter User Name" 
                                                                   required>
                                                            <p class="text-muted p-0 position-absolute end-0 top-50 border-0 fs-4 translate-middle-y me-2 mb-0">
                                                                 <iconify-icon icon="solar:user-bold-duotone" class="fs-20 mt-1 text-muted"></iconify-icon>
                                                            </p>
                                                            <?php if (isset($validation) && $validation->hasError('name')): ?>
                                                                 <div class="invalid-feedback">
                                                                      <?= $validation->getError('name') ?>
                                                                 </div>
                                                            <?php endif; ?>
                                                       </div>
                                                  </div>
                                                  
                                                  <div class="mb-3">
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
                                                  
                                                  <div class="mb-3">
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
                                                       <label class="form-label" for="ConfirmPass">Confirm Password</label>
                                                       <div class="position-relative w-100">
                                                            <input type="password" 
                                                                   class="form-control form-control-lg rounded <?= (isset($validation) && $validation->hasError('confirm_password')) ? 'is-invalid' : '' ?>" 
                                                                   id="ConfirmPass" 
                                                                   name="confirm_password"
                                                                   placeholder="Confirm password" 
                                                                   required>
                                                            <button type="button" class="btn text-muted p-0 position-absolute end-0 top-50 border-0 fs-4 translate-middle-y me-2">
                                                                 <iconify-icon icon="solar:eye-bold-duotone" class="fs-20 mt-1 text-muted"></iconify-icon>
                                                            </button>
                                                            <?php if (isset($validation) && $validation->hasError('confirm_password')): ?>
                                                                 <div class="invalid-feedback">
                                                                      <?= $validation->getError('confirm_password') ?>
                                                                 </div>
                                                            <?php endif; ?>
                                                       </div>
                                                  </div>
                                                  
                                                  <div class="mb-3">
                                                       <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox-signin" name="terms" required>
                                                            <label class="form-check-label" for="checkbox-signin">I accept Terms and Condition</label>
                                                       </div>
                                                  </div>

                                                  <div class="mb-1 text-center d-grid">
                                                       <button class="btn btn-primary" type="submit">Sign Up</button>
                                                  </div>
                                             </form>
                                             
                                             <p class="mt-3 fw-semibold no-span">Or Sign Up with</p>

                                             <div class="d-flex align-items-center justify-content-center gap-3 text-center">
                                                  <a href="javascript:void(0);" class="btn btn-outline-danger shadow px-2 d-flex align-items-center justify-content-center gap-1 fw-medium">
                                                       <iconify-icon icon="flat-color-icons:google" class="fs-20"></iconify-icon>
                                                       Google
                                                  </a>
                                                  <a href="javascript:void(0);" class="btn btn-outline-primary shadow px-2 d-flex align-items-center justify-content-center gap-1 fw-medium">
                                                       <iconify-icon icon="logos:facebook" class="fs-20"></iconify-icon>
                                                       Facebook
                                                  </a>
                                                  <a href="javascript:void(0);" class="btn btn-outline-dark shadow px-2 d-flex align-items-center justify-content-center gap-1 fw-medium">
                                                       <iconify-icon icon="mdi:github" class="fs-20"></iconify-icon>
                                                       Github
                                                  </a>
                                             </div>
                                        </div>

                                        <p class="text-muted text-center mt-4 mb-0">I already have an account <a href="<?= base_url('/auth/login') ?>" class="link-primary fst-italic text-decoration-underline fw-semibold">Sign In</a></p>
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