<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Testimonials</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-1">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-primary-subtle text-primary rounded">
                                    <i data-lucide="message-square" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Total Testimonials</p>
                            <h4 class="mb-0"><?= $stats['total'] ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-success-subtle text-success rounded">
                                    <i data-lucide="check-circle" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Approved</p>
                            <h4 class="mb-0"><?= $stats['approved'] ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-warning-subtle text-warning rounded">
                                    <i data-lucide="clock" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Pending</p>
                            <h4 class="mb-0"><?= $stats['pending'] ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-info-subtle text-info rounded">
                                    <i data-lucide="star" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Featured</p>
                            <h4 class="mb-0"><?= $stats['featured'] ?></h4>
                        </div>
                    </div>
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Testimonials Management</h4>
                        <div class="btn-group">
                            <a href="<?= base_url('/admin/testimonial-categories') ?>" class="btn btn-outline-secondary btn-sm">
                                <i data-lucide="tag" class="me-1"></i> Manage Categories
                            </a>
                            <a href="<?= base_url('/admin/testimonials/create') ?>" class="btn btn-primary btn-sm">
                                <i data-lucide="plus" class="me-1"></i> Add New Testimonial
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($testimonials)): ?>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <select class="form-select form-select-sm" style="width: auto;" id="bulkAction">
                                        <option value="">Bulk Actions</option>
                                        <option value="approve">Approve</option>
                                        <option value="reject">Reject</option>
                                        <option value="feature">Mark as Featured</option>
                                        <option value="unfeature">Remove Featured</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                    <button type="button" class="btn btn-sm btn-secondary" id="applyBulkAction">Apply</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-end">
                                    <input type="text" class="form-control form-control-sm" placeholder="Search testimonials..." style="width: 250px;" id="searchInput">
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="30">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                        <th>Customer</th>
                                        <th>Rating</th>
                                        <th>Testimonial</th>
                                        <th>Category</th>
                                        <th>Destination</th>
                                        <th>Status</th>
                                        <th>Featured</th>
                                        <th>Date</th>
                                        <th width="200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($testimonials as $testimonial): ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="form-check-input testimonial-checkbox" 
                                                       value="<?= $testimonial['id'] ?>">
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if ($testimonial['customer_image']): ?>
                                                        <img src="<?= base_url($testimonial['customer_image']) ?>" 
                                                             alt="<?= esc($testimonial['customer_name']) ?>" 
                                                             class="rounded-circle me-2" width="32" height="32">
                                                    <?php else: ?>
                                                        <div class="avatar-sm me-2">
                                                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                                                <?= strtoupper(substr($testimonial['customer_name'], 0, 1)) ?>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <strong><?= esc($testimonial['customer_name']) ?></strong>
                                                        <?php if ($testimonial['customer_city']): ?>
                                                            <br><small class="text-muted"><?= esc($testimonial['customer_city']) ?></small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <i data-lucide="star" class="fs-14 <?= $i <= $testimonial['rating'] ? 'text-warning' : 'text-muted' ?>"></i>
                                                    <?php endfor; ?>
                                                    <span class="ms-1 small">(<?= $testimonial['rating'] ?>)</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="max-width: 200px;">
                                                    <?= esc(substr($testimonial['testimonial_text'], 0, 100)) ?>
                                                    <?php if (strlen($testimonial['testimonial_text']) > 100): ?>...<?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($testimonial['category_name']): ?>
                                                    <span class="badge bg-primary"><?= esc($testimonial['category_name']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">No category</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($testimonial['destination_name']): ?>
                                                    <span class="badge bg-info"><?= esc($testimonial['destination_name']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">General</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $statusClass = match ($testimonial['status']) {
                                                    'approved' => 'success',
                                                    'pending' => 'warning',
                                                    'rejected' => 'danger',
                                                    default => 'secondary'
                                                };
                                                ?>
                                                <span class="badge bg-<?= $statusClass ?> status-badge" 
                                                      data-testimonial-id="<?= $testimonial['id'] ?>" 
                                                      data-current-status="<?= $testimonial['status'] ?>" 
                                                      style="cursor: pointer;" title="Click to change status">
                                                    <?= ucfirst($testimonial['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($testimonial['is_featured']): ?>
                                                    <span class="badge bg-info">Yes</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">No</span>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <small class="text-muted">
                                                    <?= date('M j, Y', strtotime($testimonial['created_at'])) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <?php if ($testimonial['status'] === 'pending'): ?>
                                                        <button type="button" class="btn btn-outline-success approve-btn" 
                                                                data-testimonial-id="<?= $testimonial['id'] ?>" title="Approve">
                                                            <i data-lucide="check"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-danger reject-btn" 
                                                                data-testimonial-id="<?= $testimonial['id'] ?>" title="Reject">
                                                            <i data-lucide="x"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                    <a href="<?= base_url('/admin/testimonials/edit/' . $testimonial['id']) ?>" 
                                                       class="btn btn-outline-primary" title="Edit">
                                                        <i data-lucide="edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger delete-btn" 
                                                            data-testimonial-id="<?= $testimonial['id'] ?>" 
                                                            data-customer-name="<?= esc($testimonial['customer_name']) ?>" title="Delete">
                                                        <i data-lucide="trash-2"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if ($pager): ?>
                            <div class="d-flex justify-content-center mt-3">
                                <?= $pager->links() ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i data-lucide="message-square" class="text-muted" style="width: 48px; height: 48px;"></i>
                            <h5 class="mt-3 text-muted">No testimonials found</h5>
                            <p class="text-muted">Start collecting customer testimonials to build trust and credibility.</p>
                            <a href="<?= base_url('/admin/testimonials/create') ?>" class="btn btn-primary">
                                <i data-lucide="plus" class="me-1"></i> Add First Testimonial
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the testimonial from "<span id="customerName"></span>"?</p>
                <p class="text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let deleteTestimonialId = null;

    // Select all functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const testimonialCheckboxes = document.querySelectorAll('.testimonial-checkbox');
    
    selectAllCheckbox?.addEventListener('change', function() {
        testimonialCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const customerName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const testimonialText = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            
            if (customerName.includes(searchTerm) || testimonialText.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Bulk actions
    document.getElementById('applyBulkAction')?.addEventListener('click', function() {
        const selectedTestimonials = document.querySelectorAll('.testimonial-checkbox:checked');
        const bulkAction = document.getElementById('bulkAction').value;
        
        if (selectedTestimonials.length === 0) {
            alert('Please select at least one testimonial');
            return;
        }
        
        if (!bulkAction) {
            alert('Please select an action');
            return;
        }
        
        if (!confirm(`Apply "${bulkAction}" to ${selectedTestimonials.length} selected testimonial(s)?`)) {
            return;
        }
        
        const testimonialIds = Array.from(selectedTestimonials).map(cb => cb.value);
        
        // Handle bulk actions
        testimonialIds.forEach(id => {
            switch(bulkAction) {
                case 'approve':
                    fetch(`/admin/testimonials/approve/${id}`, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    break;
                case 'reject':
                    fetch(`/admin/testimonials/reject/${id}`, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    break;
                case 'feature':
                    fetch(`/admin/testimonials/toggle-featured/${id}`, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    break;
                case 'delete':
                    window.location.href = `/admin/testimonials/delete/${id}`;
                    break;
            }
        });
        
        if (bulkAction !== 'delete') {
            setTimeout(() => location.reload(), 1000);
        }
    });

    // Status badge click to cycle through statuses
    document.querySelectorAll('.status-badge').forEach(badge => {
        badge.addEventListener('click', function() {
            const testimonialId = this.dataset.testimonialId;
            const currentStatus = this.dataset.currentStatus;
            
            // Cycle through statuses: pending -> approved -> rejected -> pending
            let newStatus;
            switch(currentStatus) {
                case 'pending':
                    newStatus = 'approved';
                    break;
                case 'approved':
                    newStatus = 'rejected';
                    break;
                case 'rejected':
                    newStatus = 'pending';
                    break;
                default:
                    newStatus = 'approved';
            }
            
            const endpoint = newStatus === 'approved' ? 'approve' : 'reject';
            
            fetch(`/admin/testimonials/${endpoint}/${testimonialId}`, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to update status');
                }
            });
        });
    });

    // Approve testimonial
    document.querySelectorAll('.approve-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const testimonialId = this.dataset.testimonialId;
            
            fetch(`/admin/testimonials/approve/${testimonialId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to approve testimonial');
                }
            });
        });
    });

    // Reject testimonial
    document.querySelectorAll('.reject-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const testimonialId = this.dataset.testimonialId;
            
            fetch(`/admin/testimonials/reject/${testimonialId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to reject testimonial');
                }
            });
        });
    });


    // Delete functionality
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            deleteTestimonialId = this.dataset.testimonialId;
            document.getElementById('customerName').textContent = this.dataset.customerName;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });

    document.getElementById('confirmDelete')?.addEventListener('click', function() {
        if (deleteTestimonialId) {
            window.location.href = `/admin/testimonials/delete/${deleteTestimonialId}`;
        }
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>