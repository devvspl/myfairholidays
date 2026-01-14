<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Testimonial Categories</li>
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
                                    <i data-lucide="tag" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Total Categories</p>
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
                            <p class="text-muted mb-1">Active</p>
                            <h4 class="mb-0"><?= $stats['active'] ?></h4>
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
                                    <i data-lucide="pause-circle" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Inactive</p>
                            <h4 class="mb-0"><?= $stats['inactive'] ?></h4>
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
                                    <i data-lucide="message-square" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">With Testimonials</p>
                            <h4 class="mb-0"><?= $stats['with_testimonials'] ?></h4>
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
                        <h4 class="card-title mb-0">Testimonial Categories</h4>
                        <a href="<?= base_url('/admin/testimonial-categories/create') ?>" class="btn btn-primary btn-sm">
                            <i data-lucide="plus" class="me-1"></i> Add New Category
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($categories)): ?>
                        <form id="bulkActionForm" method="POST" action="<?= base_url('/admin/testimonial-categories/bulk-action') ?>">
                            <?= csrf_field() ?>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                <div class="btn-group">
                                        <select name="bulk_action" class="form-select form-select-sm" style="width: auto;" id="bulkAction">
                                            <option value="">Bulk Actions</option>
                                            <option value="activate">Activate</option>
                                            <option value="deactivate">Deactivate</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-secondary" id="applyBulkAction">Apply</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-end">
                                        <input type="text" class="form-control form-control-sm" placeholder="Search categories..." style="width: 250px;" id="searchInput">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="30">
                                                <input type="checkbox" class="form-check-input" id="selectAll">
                                            </th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Testimonials</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th width="150">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($categories as $category): ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input category-checkbox" 
                                                           name="category_ids[]" value="<?= $category['id'] ?>">
                                                </td>
                                                <td>
                                                    <strong><?= esc($category['name']) ?></strong>
                                                </td>
                                                <td>
                                                    <?php if (!empty($category['description'])): ?>
                                                        <?= esc(substr($category['description'], 0, 80)) ?>
                                                        <?php if (strlen($category['description']) > 80): ?>...<?php endif; ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">No description</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?= $category['testimonial_count'] ?> testimonials</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $category['status'] === 'active' ? 'success' : 'secondary' ?> status-badge" 
                                                          data-category-id="<?= $category['id'] ?>" 
                                                          data-current-status="<?= $category['status'] ?>" 
                                                          style="cursor: pointer;" title="Click to toggle status">
                                                        <?= ucfirst($category['status']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?= date('M j, Y', strtotime($category['created_at'] ?? 'now')) ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="<?= base_url('/admin/testimonial-categories/edit/' . $category['id']) ?>" 
                                                           class="btn btn-outline-primary" title="Edit">
                                                            <i data-lucide="edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-outline-danger delete-btn" 
                                                                data-category-id="<?= $category['id'] ?>" 
                                                                data-category-name="<?= esc($category['name']) ?>" 
                                                                data-testimonial-count="<?= $category['testimonial_count'] ?>" title="Delete">
                                                            <i data-lucide="trash-2"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        
                        <!-- Pagination -->
                        <?php if ($pager): ?>
                            <div class="d-flex justify-content-center mt-3">
                                <?= $pager->links() ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i data-lucide="tag" class="text-muted" style="width: 48px; height: 48px;"></i>
                            <h5 class="mt-3 text-muted">No testimonial categories found</h5>
                            <p class="text-muted">Create categories to organize your testimonials better.</p>
                            <a href="<?= base_url('/admin/testimonial-categories/create') ?>" class="btn btn-primary">
                                <i data-lucide="plus" class="me-1"></i> Create Category
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
                <p>Are you sure you want to delete "<span id="categoryName"></span>"?</p>
                <div id="testimonialWarning" style="display: none;">
                    <div class="alert alert-warning">
                        <i data-lucide="alert-triangle" class="me-1"></i>
                        This category has <span id="testimonialCount"></span> testimonials. Deleting it will remove the category association from these testimonials.
                    </div>
                </div>
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
    let deleteCategoryId = null;

    // Select all functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    
    selectAllCheckbox?.addEventListener('change', function() {
        categoryCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const categoryName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const description = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            
            if (categoryName.includes(searchTerm) || description.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Status badge click to toggle status
    document.querySelectorAll('.status-badge').forEach(badge => {
        badge.addEventListener('click', function() {
            const categoryId = this.dataset.categoryId;
            
            fetch(`/admin/testimonial-categories/toggle-status/${categoryId}`, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                    this.className = `badge bg-${data.status === 'active' ? 'success' : 'secondary'} status-badge`;
                    this.dataset.currentStatus = data.status;
                } else {
                    alert('Failed to update status');
                }
            });
        });
    });

    // Delete functionality
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            deleteCategoryId = this.dataset.categoryId;
            const categoryName = this.dataset.categoryName;
            const testimonialCount = parseInt(this.dataset.testimonialCount);
            
            document.getElementById('categoryName').textContent = categoryName;
            document.getElementById('testimonialCount').textContent = testimonialCount;
            
            if (testimonialCount > 0) {
                document.getElementById('testimonialWarning').style.display = 'block';
            } else {
                document.getElementById('testimonialWarning').style.display = 'none';
            }
            
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });

    document.getElementById('confirmDelete')?.addEventListener('click', function() {
        if (deleteCategoryId) {
            window.location.href = `/admin/testimonial-categories/delete/${deleteCategoryId}`;
        }
    });

    // Bulk action form validation
    document.getElementById('bulkActionForm')?.addEventListener('submit', function(e) {
        const selectedCategories = document.querySelectorAll('.category-checkbox:checked');
        const bulkAction = document.querySelector('select[name="bulk_action"]').value;
        
        if (selectedCategories.length === 0) {
            e.preventDefault();
            alert('Please select at least one category');
            return;
        }
        
        if (!bulkAction) {
            e.preventDefault();
            alert('Please select an action');
            return;
        }
        
        if (!confirm(`Apply "${bulkAction}" to ${selectedCategories.length} selected category(ies)?`)) {
            e.preventDefault();
        }
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>