<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
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

    <!-- Quick Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-2 card-title">Total Content</p>
                            <h4 class="fw-bold text-primary mb-0"><?= $quick_stats['total_content'] ?></h4>
                            <small class="text-muted">Blog Posts</small>
                        </div>
                        <div>
                            <i data-lucide="file-text" class="fs-32 text-primary"></i>
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
                            <p class="mb-2 card-title">Total Destinations</p>
                            <h4 class="fw-bold text-info mb-0"><?= $quick_stats['total_destinations'] ?></h4>
                            <small class="text-muted">Travel Destinations</small>
                        </div>
                        <div>
                            <i data-lucide="map-pin" class="fs-32 text-info"></i>
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
                            <p class="mb-2 card-title">Total Bookings</p>
                            <h4 class="fw-bold text-success mb-0"><?= $quick_stats['total_bookings'] ?></h4>
                            <small class="text-muted">Completed</small>
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
                            <p class="mb-2 card-title">Pending Testimonials</p>
                            <h4 class="fw-bold text-warning mb-0"><?= $quick_stats['pending_testimonials'] ?></h4>
                            <small class="text-muted">Need Approval</small>
                        </div>
                        <div>
                            <i data-lucide="clock" class="fs-32 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics -->
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">📊 Content Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Blog Stats -->
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold mb-3">�  Blog Management</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Posts</span>
                                <span class="fw-bold"><?= $stats['blogs']['total'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Published</span>
                                <span class="text-success"><?= $stats['blogs']['published'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Draft</span>
                                <span class="text-warning"><?= $stats['blogs']['draft'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Featured</span>
                                <span class="text-info"><?= $stats['blogs']['featured'] ?></span>
                            </div>
                        </div>

                        <!-- Destinations Stats -->
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold mb-3">🌍 Destinations</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Destinations</span>
                                <span class="fw-bold"><?= $stats['destinations']['total'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Active</span>
                                <span class="text-success"><?= $stats['destinations']['active'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Countries</span>
                                <span class="text-primary"><?= $stats['destinations']['countries'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Cities</span>
                                <span class="text-info"><?= $stats['destinations']['cities'] ?></span>
                            </div>
                        </div>

                        <!-- Itineraries Stats -->
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold mb-3">🗺️ Itineraries</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Packages</span>
                                <span class="fw-bold"><?= $stats['itineraries']['total'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Published</span>
                                <span class="text-success"><?= $stats['itineraries']['published'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Featured</span>
                                <span class="text-info"><?= $stats['itineraries']['featured'] ?></span>
                            </div>
                        </div>

                        <!-- Payments Stats -->
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold mb-3">💳 Payments</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Payments</span>
                                <span class="fw-bold"><?= $stats['payments']['total'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Completed</span>
                                <span class="text-success"><?= $stats['payments']['completed'] ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Pending</span>
                                <span class="text-warning"><?= $stats['payments']['pending'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <!-- Testimonials Stats -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">⭐ Testimonials</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Testimonials</span>
                        <span class="fw-bold"><?= $stats['testimonials']['total'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Approved</span>
                        <span class="text-success"><?= $stats['testimonials']['approved'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Pending</span>
                        <span class="text-warning"><?= $stats['testimonials']['pending'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Featured</span>
                        <span class="text-info"><?= $stats['testimonials']['featured'] ?></span>
                    </div>
                    <?php if ($stats['testimonials']['pending'] > 0): ?>
                        <div class="alert alert-warning">
                            <small><i data-lucide="alert-triangle" class="me-1"></i> 
                            <?= $stats['testimonials']['pending'] ?> testimonials need your attention</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Payment Stats -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">💰 Payments</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Transactions</span>
                        <span class="fw-bold"><?= $stats['payments']['total'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Completed</span>
                        <span class="text-success"><?= $stats['payments']['completed'] ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Pending</span>
                        <span class="text-warning"><?= $stats['payments']['pending'] ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total Revenue</span>
                        <span class="fw-bold text-success">$<?= number_format($stats['payments']['total_amount'], 2) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">🕒 Recent Activities</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($recent_activities)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Title</th>
                                        <th>Action</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_activities as $activity): ?>
                                        <tr>
                                            <td>
                                                <span class="badge badge-soft-<?= 
                                                    $activity['type'] === 'blog' ? 'primary' : 
                                                    ($activity['type'] === 'itinerary' ? 'info' : 'warning') ?>">
                                                    <?= ucfirst($activity['type']) ?>
                                                </span>
                                            </td>
                                            <td><?= esc($activity['title']) ?></td>
                                            <td><?= ucfirst($activity['action']) ?></td>
                                            <td>
                                                <span class="badge badge-soft-<?= 
                                                    $activity['status'] === 'published' || $activity['status'] === 'approved' ? 'success' : 
                                                    ($activity['status'] === 'pending' ? 'warning' : 'secondary') ?>">
                                                    <?= ucfirst($activity['status']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('M d, Y g:i A', strtotime($activity['date'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i data-lucide="inbox" class="fs-48 text-muted mb-3"></i>
                            <p class="text-muted">No recent activities found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layouts/dashboard_footer') ?>