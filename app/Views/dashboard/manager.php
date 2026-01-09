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
                              <p class="mb-3 card-title">Team Members</p>
                              <h4 class="fw-bold text-primary d-flex align-items-center gap-2 mb-0"><?= $stats['user_count'] ?></h4>
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
                              <p class="mb-3 card-title">Active Projects</p>
                              <h4 class="fw-bold d-flex align-items-center gap-2 mb-0">0</h4>
                         </div>
                         <div>
                              <i data-lucide="briefcase" class="fs-32 text-success"></i>
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
                              <p class="mb-3 card-title">Pending Tasks</p>
                              <h4 class="fw-bold text-warning d-flex align-items-center gap-2 mb-0">0</h4>
                         </div>
                         <div>
                              <i data-lucide="clipboard-list" class="fs-32 text-warning"></i>
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
                              <p class="mb-3 card-title">Team Performance</p>
                              <h4 class="fw-bold text-success d-flex align-items-center gap-2 mb-0">100%</h4>
                         </div>
                         <div>
                              <i data-lucide="trending-up" class="fs-32 text-success"></i>
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
                         <h4 class="card-title mb-0">👨‍💼 Manager Actions</h4>
                    </div>
               </div>
               <div class="card-body">
                    <div class="d-grid gap-3">
                         <a href="<?= base_url('/manager/users') ?>" class="btn btn-primary d-flex align-items-center gap-2">
                              <i data-lucide="users"></i> View Team
                         </a>
                         <a href="#" class="btn btn-outline-primary d-flex align-items-center gap-2">
                              <i data-lucide="clipboard-list"></i> Assign Tasks
                         </a>
                         <a href="#" class="btn btn-outline-primary d-flex align-items-center gap-2">
                              <i data-lucide="bar-chart-3"></i> Team Reports
                         </a>
                         <a href="#" class="btn btn-outline-primary d-flex align-items-center gap-2">
                              <i data-lucide="calendar"></i> Schedule Meeting
                         </a>
                    </div>
               </div>
          </div>
     </div>

     <div class="col-xl-6">
          <div class="card">
               <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                         <h4 class="card-title mb-0">📋 Manager Information</h4>
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
                              <p class="mb-2"><strong>Access Level:</strong> Team Management</p>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<?php if (!empty($stats['total_users'])): ?>
<div class="row">
     <div class="col-12">
          <div class="card">
               <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                         <h4 class="card-title mb-0">👥 Team Members</h4>
                    </div>
                    <div>
                         <a href="<?= base_url('/manager/users') ?>" class="btn btn-sm btn-primary">View All</a>
                    </div>
               </div>
               <div class="card-body p-0">
                    <div class="table-responsive">
                         <table class="table table-sm table-hover mb-0">
                              <thead>
                                   <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Last Active</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php foreach (array_slice($stats['total_users'], 0, 5) as $teamMember): ?>
                                   <tr>
                                        <td>
                                             <div class="d-flex align-items-center gap-2">
                                                  <img src="<?= base_url('assets/images/users/avatar-1.jpg') ?>" alt="" class="avatar-sm rounded-circle">
                                                  <?= $teamMember['name'] ?>
                                             </div>
                                        </td>
                                        <td><?= $teamMember['email'] ?></td>
                                        <td>
                                             <span class="badge badge-soft-success">
                                                  <?= ucfirst($teamMember['status']) ?>
                                             </span>
                                        </td>
                                        <td><?= date('M j, Y', strtotime($teamMember['updated_at'])) ?></td>
                                   </tr>
                                   <?php endforeach; ?>
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>
<?php endif; ?>

<div class="row">
     <div class="col-12">
          <div class="card">
               <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                         <h4 class="card-title mb-0">🎯 Manager Responsibilities</h4>
                    </div>
               </div>
               <div class="card-body">
                    <div class="row">
                         <div class="col-md-6">
                              <h6 class="fw-bold mb-3">Team Management</h6>
                              <ul class="list-unstyled">
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> View and monitor team members</li>
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Assign tasks and projects</li>
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Track team performance</li>
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Schedule team meetings</li>
                              </ul>
                         </div>
                         <div class="col-md-6">
                              <h6 class="fw-bold mb-3">Reporting & Analytics</h6>
                              <ul class="list-unstyled">
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Generate team performance reports</li>
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Monitor project progress</li>
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Analyze team productivity</li>
                                   <li class="mb-2"><i data-lucide="check" class="text-success me-2"></i> Coordinate with other departments</li>
                              </ul>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<?= $this->include('layouts/dashboard_footer') ?>