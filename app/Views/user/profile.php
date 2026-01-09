<?= $this->include('layouts/dashboard_header') ?>

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

<div class="row">
     <div class="col-xl-8">
          <div class="card">
               <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                         <h4 class="card-title mb-0">📝 Edit Profile</h4>
                    </div>
               </div>
               <div class="card-body">
                    <form action="<?= base_url('/user/profile') ?>" method="post">
                         <?= csrf_field() ?>
                         
                         <div class="row">
                              <div class="col-md-6">
                                   <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" 
                                               class="form-control <?= (isset($validation) && $validation->hasError('name')) ? 'is-invalid' : '' ?>" 
                                               id="name" 
                                               name="name" 
                                               value="<?= old('name', $user['name']) ?>" 
                                               required>
                                        <?php if (isset($validation) && $validation->hasError('name')): ?>
                                             <div class="invalid-feedback">
                                                  <?= $validation->getError('name') ?>
                                             </div>
                                        <?php endif; ?>
                                   </div>
                              </div>
                              
                              <div class="col-md-6">
                                   <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" 
                                               class="form-control" 
                                               id="email" 
                                               value="<?= $user['email'] ?>" 
                                               disabled>
                                        <small class="text-muted">Email cannot be changed. Contact administrator if needed.</small>
                                   </div>
                              </div>
                         </div>

                         <div class="row">
                              <div class="col-md-6">
                                   <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="role" 
                                               value="<?= ucfirst($user['role_name']) ?>" 
                                               disabled>
                                   </div>
                              </div>
                              
                              <div class="col-md-6">
                                   <div class="mb-3">
                                        <label for="status" class="form-label">Account Status</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="status" 
                                               value="<?= ucfirst($user['status']) ?>" 
                                               disabled>
                                   </div>
                              </div>
                         </div>

                         <div class="d-flex gap-2">
                              <button type="submit" class="btn btn-primary">
                                   <i data-lucide="save"></i> Update Profile
                              </button>
                              <a href="<?= base_url('/user/dashboard') ?>" class="btn btn-outline-secondary">
                                   <i data-lucide="arrow-left"></i> Back to Dashboard
                              </a>
                         </div>
                    </form>
               </div>
          </div>
     </div>

     <div class="col-xl-4">
          <div class="card">
               <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                         <h4 class="card-title mb-0">📊 Account Information</h4>
                    </div>
               </div>
               <div class="card-body">
                    <div class="text-center mb-4">
                         <img src="<?= base_url('assets/images/users/avatar-1.jpg') ?>" alt="Profile" class="rounded-circle" width="80" height="80">
                         <h5 class="mt-2 mb-0"><?= $user['name'] ?></h5>
                         <span class="badge badge-soft-success"><?= ucfirst($user['role_name']) ?></span>
                    </div>
                    
                    <div class="border-top pt-3">
                         <div class="row text-center">
                              <div class="col-6">
                                   <p class="mb-1 fw-semibold">User ID</p>
                                   <p class="text-muted mb-0">#<?= $user['id'] ?></p>
                              </div>
                              <div class="col-6">
                                   <p class="mb-1 fw-semibold">Role ID</p>
                                   <p class="text-muted mb-0"><?= $user['role_id'] ?></p>
                              </div>
                         </div>
                    </div>
                    
                    <div class="border-top pt-3 mt-3">
                         <p class="mb-2"><strong>Account Created:</strong></p>
                         <p class="text-muted mb-3"><?= date('F j, Y \a\t g:i A', strtotime($user['created_at'])) ?></p>
                         
                         <p class="mb-2"><strong>Last Updated:</strong></p>
                         <p class="text-muted mb-0"><?= date('F j, Y \a\t g:i A', strtotime($user['updated_at'])) ?></p>
                    </div>
               </div>
          </div>
     </div>
</div>

<?= $this->include('layouts/dashboard_footer') ?>