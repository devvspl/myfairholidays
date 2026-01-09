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
                              <p class="mb-3 card-title">Total Users</p>
                              <h4 class="fw-bold text-primary d-flex align-items-center gap-2 mb-0"><?= $stats['total_users'] ?></h4>
                         </div>
                         <div>
                              <i data-lucide="users" class="fs-32 text-primary"></i>
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
                              <p class="mb-3 card-title">Active Users</p>
                              <h4 class="fw-bold d-flex align-items-center gap-2 mb-0"><?= $stats['active_users'] ?></h4>
                         </div>
                         <div>
                              <i data-lucide="user-check" class="fs-32 text-success"></i>
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
                              <p class="mb-3 card-title">Inactive Users</p>
                              <h4 class="fw-bold text-danger d-flex align-items-center gap-2 mb-0"><?= $stats['inactive_users'] ?></h4>
                         </div>
                         <div>
                              <i data-lucide="user-x" class="fs-32 text-danger"></i>
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
                              <p class="mb-3 card-title">Total Roles</p>
                              <h4 class="fw-bold d-flex align-items-center gap-2 mb-0"><?= $stats['total_roles'] ?></h4>
                         </div>
                         <div>
                              <i data-lucide="shield" class="fs-32 text-primary"></i>
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
                         <h4 class="card-title mb-0">👑 Admin Actions</h4>
                    </div>
               </div>
               <div class="card-body">
                    <div class="d-grid gap-3">
                         <a href="<?= base_url('/admin/users') ?>" class="btn btn-primary d-flex align-items-center gap-2">
                              <i data-lucide="users"></i> Manage Users
                         </a>
                         <a href="#" class="btn btn-outline-primary d-flex align-items-center gap-2">
                              <i data-lucide="settings"></i> System Settings
                         </a>
                         <a href="#" class="btn btn-outline-primary d-flex align-items-center gap-2">
                              <i data-lucide="bar-chart-3"></i> Reports
                         </a>
                         <a href="#" class="btn btn-outline-primary d-flex align-items-center gap-2">
                              <i data-lucide="shield-alert"></i> Security Logs
                         </a>
                    </div>
               </div>
          </div>
     </div>

     <div class="col-xl-6">
          <div class="card">
               <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                         <h4 class="card-title mb-0">📋 Admin Information</h4>
                    </div>
               </div>
               <div class="card-body">
                    <div class="row">
                         <div class="col-sm-6">
                              <p class="mb-2"><strong>Name:</strong> <?= $user['name'] ?></p>
                              <p class="mb-2"><strong>Email:</strong> <?= $user['email'] ?></p>
                         </div>
                         <div class="col-sm-6">
                              <p class="mb-2"><strong>Role:</strong> 
                                   <span class="badge badge-soft-success"><?= ucfirst($user['role']) ?></span>
                              </p>
                              <p class="mb-2"><strong>Access Level:</strong> Full System Access</p>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<div class="row">
     <div class="col-12">
          <div class="card">
               <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                         <h4 class="card-title mb-0">🚀 Administrator Capabilities</h4>
                    </div>
               </div>
               <div class="card-body">
                    <div class="row">
                         <div class="col-md-6">
                              <h6 class="fw-bold mb-3">User Management</h6>
                              <ul class="list-unstyled">
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Create, edit, and delete user accounts</li>
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Assign and modify user roles</li>
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Activate/deactivate user accounts</li>
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> View detailed user statistics</li>
                              </ul>
                         </div>
                         <div class="col-md-6">
                              <h6 class="fw-bold mb-3">System Control</h6>
                              <ul class="list-unstyled">
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Configure system settings</li>
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Access security logs and audit trails</li>
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Generate comprehensive reports</li>
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Manage application permissions</li>
                              </ul>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<?= $this->include('layouts/dashboard_footer') ?>