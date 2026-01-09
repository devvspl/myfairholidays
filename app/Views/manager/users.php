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
     <div class="col-12">
          <div class="card">
               <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                         <h4 class="card-title mb-0">👥 Team Members</h4>
                         <p class="text-muted mb-0">View your team members and their information</p>
                    </div>
                    <div>
                         <a href="<?= base_url('/manager/dashboard') ?>" class="btn btn-outline-primary">
                              <i data-lucide="arrow-left"></i> Back to Dashboard
                         </a>
                    </div>
               </div>
               <div class="card-body p-0">
                    <div class="table-responsive">
                         <table class="table table-hover mb-0">
                              <thead class="table-light">
                                   <tr>
                                        <th>Team Member</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Joined</th>
                                        <th>Last Active</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php if (!empty($users)): ?>
                                        <?php foreach ($users as $user): ?>
                                        <tr>
                                             <td>
                                                  <div class="d-flex align-items-center gap-2">
                                                       <img src="<?= base_url('assets/images/users/avatar-1.jpg') ?>" alt="" class="avatar-sm rounded-circle">
                                                       <div>
                                                            <h6 class="mb-0"><?= esc($user['name']) ?></h6>
                                                            <small class="text-muted">Regular User</small>
                                                       </div>
                                                  </div>
                                             </td>
                                             <td>
                                                  <span class="fw-medium"><?= esc($user['email']) ?></span>
                                             </td>
                                             <td>
                                                  <?php if ($user['status'] === 'active'): ?>
                                                       <span class="badge badge-soft-success">
                                                            <i data-lucide="check-circle" class="fs-12 me-1"></i>
                                                            Active
                                                       </span>
                                                  <?php else: ?>
                                                       <span class="badge badge-soft-danger">
                                                            <i data-lucide="x-circle" class="fs-12 me-1"></i>
                                                            Inactive
                                                       </span>
                                                  <?php endif; ?>
                                             </td>
                                             <td>
                                                  <span class="text-muted"><?= date('M j, Y', strtotime($user['created_at'])) ?></span>
                                                  <br>
                                                  <small class="text-muted"><?= date('g:i A', strtotime($user['created_at'])) ?></small>
                                             </td>
                                             <td>
                                                  <span class="text-muted"><?= date('M j, Y', strtotime($user['updated_at'])) ?></span>
                                                  <br>
                                                  <small class="text-muted"><?= date('g:i A', strtotime($user['updated_at'])) ?></small>
                                             </td>
                                        </tr>
                                        <?php endforeach; ?>
                                   <?php else: ?>
                                        <tr>
                                             <td colspan="5" class="text-center py-4">
                                                  <div class="text-muted">
                                                       <i data-lucide="users" class="fs-48 mb-3"></i>
                                                       <p>No team members found</p>
                                                  </div>
                                             </td>
                                        </tr>
                                   <?php endif; ?>
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>

<div class="row">
     <div class="col-xl-6">
          <div class="card">
               <div class="card-header">
                    <h5 class="card-title mb-0">📊 Team Statistics</h5>
               </div>
               <div class="card-body">
                    <?php
                    $totalMembers = count($users);
                    $activeMembers = count(array_filter($users, fn($u) => $u['status'] === 'active'));
                    $inactiveMembers = $totalMembers - $activeMembers;
                    ?>
                    
                    <div class="row text-center">
                         <div class="col-4">
                              <h4 class="fw-bold text-primary"><?= $totalMembers ?></h4>
                              <p class="text-muted mb-0 fs-13">Total Members</p>
                         </div>
                         <div class="col-4">
                              <h4 class="fw-bold text-success"><?= $activeMembers ?></h4>
                              <p class="text-muted mb-0 fs-13">Active</p>
                         </div>
                         <div class="col-4">
                              <h4 class="fw-bold text-danger"><?= $inactiveMembers ?></h4>
                              <p class="text-muted mb-0 fs-13">Inactive</p>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     
     <div class="col-xl-6">
          <div class="card">
               <div class="card-header">
                    <h5 class="card-title mb-0">🎯 Manager Actions</h5>
               </div>
               <div class="card-body">
                    <div class="d-grid gap-2">
                         <button class="btn btn-outline-primary" disabled>
                              <i data-lucide="mail"></i> Send Team Message
                         </button>
                         <button class="btn btn-outline-primary" disabled>
                              <i data-lucide="calendar"></i> Schedule Meeting
                         </button>
                         <button class="btn btn-outline-primary" disabled>
                              <i data-lucide="file-text"></i> Generate Report
                         </button>
                    </div>
                    <small class="text-muted mt-2 d-block">These features will be available in future updates.</small>
               </div>
          </div>
     </div>
</div>

<?= $this->include('layouts/dashboard_footer') ?>