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
     <div class="col-xl-3 col-md-6">
          <div class="card">
               <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                         <div>
                              <p class="mb-3 card-title">Active Tasks</p>
                              <h4 class="fw-bold text-primary d-flex align-items-center gap-2 mb-0">0</h4>
                         </div>
                         <div>
                              <i data-lucide="clipboard-list" class="fs-32 text-primary"></i>
                         </div>
                    </div>
               </div>
          </div>
     </div>

     <div class="col-xl-3 col-md-6">
          <div class="card">
               <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                         <div>
                              <p class="mb-3 card-title">Completed Tasks</p>
                              <h4 class="fw-bold d-flex align-items-center gap-2 mb-0">0</h4>
                         </div>
                         <div>
                              <i data-lucide="check-circle" class="fs-32 text-success"></i>
                         </div>
                    </div>
               </div>
          </div>
     </div>

     <div class="col-xl-3 col-md-6">
          <div class="card">
               <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                         <div>
                              <p class="mb-3 card-title">Messages</p>
                              <h4 class="fw-bold text-info d-flex align-items-center gap-2 mb-0">0</h4>
                         </div>
                         <div>
                              <i data-lucide="mail" class="fs-32 text-info"></i>
                         </div>
                    </div>
               </div>
          </div>
     </div>

     <div class="col-xl-3 col-md-6">
          <div class="card">
               <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                         <div>
                              <p class="mb-3 card-title">Profile Complete</p>
                              <h4 class="fw-bold text-success d-flex align-items-center gap-2 mb-0">100%</h4>
                         </div>
                         <div>
                              <i data-lucide="user-check" class="fs-32 text-success"></i>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<div class="row">
     <div class="col-xl-6">
          <div class="card">
               <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                         <h4 class="card-title mb-0">👤 Quick Actions</h4>
                    </div>
               </div>
               <div class="card-body">
                    <div class="d-grid gap-3">
                         <a href="<?= base_url('/user/profile') ?>" class="btn btn-primary d-flex align-items-center gap-2">
                              <i data-lucide="user"></i> Edit Profile
                         </a>
                         <a href="#" class="btn btn-outline-primary d-flex align-items-center gap-2">
                              <i data-lucide="clipboard-list"></i> My Tasks
                         </a>
                         <a href="#" class="btn btn-outline-primary d-flex align-items-center gap-2">
                              <i data-lucide="mail"></i> Messages
                         </a>
                         <a href="#" class="btn btn-outline-primary d-flex align-items-center gap-2">
                              <i data-lucide="settings"></i> Settings
                         </a>
                    </div>
               </div>
          </div>
     </div>

     <div class="col-xl-6">
          <div class="card">
               <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                         <h4 class="card-title mb-0">📋 Profile Information</h4>
                    </div>
               </div>
               <div class="card-body">
                    <div class="row">
                         <div class="col-sm-6">
                              <p class="mb-2"><strong>Name:</strong> <?= $user['name'] ?></p>
                              <p class="mb-2"><strong>Email:</strong> <?= $user['email'] ?></p>
                              <p class="mb-2"><strong>Role:</strong> 
                                   <span class="badge badge-soft-success"><?= ucfirst($user['role_name']) ?></span>
                              </p>
                         </div>
                         <div class="col-sm-6">
                              <p class="mb-2"><strong>Status:</strong> 
                                   <span class="badge badge-soft-success"><?= ucfirst($user['status']) ?></span>
                              </p>
                              <p class="mb-2"><strong>Member Since:</strong> <?= date('M j, Y', strtotime($user['created_at'])) ?></p>
                              <p class="mb-2"><strong>Last Updated:</strong> <?= date('M j, Y', strtotime($user['updated_at'])) ?></p>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<div class="row">
     <div class="col-xl-6">
          <div class="card">
               <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                         <h4 class="card-title mb-0">🎯 Available Features</h4>
                    </div>
               </div>
               <div class="card-body">
                    <ul class="list-unstyled">
                         <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> View and update profile information</li>
                         <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Access personal dashboard</li>
                         <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> View assigned tasks and projects</li>
                         <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Communicate with team members</li>
                         <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Update account settings</li>
                    </ul>
               </div>
          </div>
     </div>

     <div class="col-xl-6">
          <div class="card">
               <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                         <h4 class="card-title mb-0">📊 Recent Activity</h4>
                    </div>
               </div>
               <div class="card-body text-center">
                    <div class="py-4">
                         <i data-lucide="activity" class="fs-48 text-muted mb-3"></i>
                         <h6 class="text-muted mb-2">🎉 Welcome to your dashboard!</h6>
                         <p class="text-muted mb-3">Start by updating your profile or exploring the available features.</p>
                         <a href="<?= base_url('/user/profile') ?>" class="btn btn-primary">
                              <i data-lucide="user"></i> Update Profile
                         </a>
                    </div>
               </div>
          </div>
     </div>
</div>

<?= $this->include('layouts/dashboard_footer') ?>