<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Itineraries</li>
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
                                    <i data-lucide="map" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Total Itineraries</p>
                            <h4 class="mb-0"><?= $stats['total'] ?? 0 ?></h4>
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
                            <p class="text-muted mb-1">Published</p>
                            <h4 class="mb-0"><?= $stats['published'] ?? 0 ?></h4>
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
                            <h4 class="mb-0"><?= $stats['featured'] ?? 0 ?></h4>
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
                                    <i data-lucide="trending-up" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Avg Price</p>
                            <h4 class="mb-0">₹<?= number_format($stats['avg_price'] ?? 0, 0) ?></h4>
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
                        <h4 class="card-title mb-0">Itineraries List</h4>
                        <div class="btn-group">
                            <a href="<?= base_url('/admin/itinerary-categories') ?>" class="btn btn-outline-secondary btn-sm">
                                <i data-lucide="folder" class="me-1"></i> Manage Categories
                            </a>
                            <a href="<?= base_url('/admin/destinations') ?>" class="btn btn-outline-secondary btn-sm">
                                <i data-lucide="map-pin" class="me-1"></i> Manage Destinations
                            </a>
                            <a href="<?= base_url('/admin/itineraries/create') ?>" class="btn btn-primary btn-sm">
                                <i data-lucide="plus" class="me-1"></i> Add New Itinerary
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($itineraries)): ?>
                        <form id="bulkActionForm" method="POST" action="<?= base_url('/admin/itineraries/bulk-action') ?>">
                            <?= csrf_field() ?>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <select name="bulk_action" class="form-select form-select-sm" style="width: auto;">
                                            <option value="">Bulk Actions</option>
                                            <option value="publish">Publish</option>
                                            <option value="draft">Move to Draft</option>
                                            <option value="feature">Mark as Featured</option>
                                            <option value="unfeature">Remove Featured</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-secondary">Apply</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-end">
                                        <input type="text" class="form-control form-control-sm" placeholder="Search itineraries..." style="width: 250px;" id="searchInput">
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
                                            <th>Itinerary</th>
                                            <th>Destination</th>
                                            <th>Category</th>
                                            <th>Duration</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Featured</th>
                                            <th>Created</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($itineraries as $itinerary): ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input itinerary-checkbox" 
                                                           name="itinerary_ids[]" value="<?= $itinerary['id'] ?>">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php if ($itinerary['featured_image']): ?>
                                                            <img src="<?= base_url($itinerary['featured_image']) ?>" 
                                                                 alt="<?= esc($itinerary['title']) ?>" 
                                                                 class="me-2 rounded" width="32" height="32">
                                                        <?php endif; ?>
                                                        <div>
                                                            <strong><?= esc($itinerary['title']) ?></strong>
                                                            <?php if (!empty($itinerary['short_description'])): ?>
                                                                <br><small class="text-muted"><?= esc(substr($itinerary['short_description'], 0, 50)) ?>...</small>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">
                                                        <?= esc($itinerary['destination_name'] ?? 'No Destination') ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">
                                                        <?= esc($itinerary['category_name'] ?? 'No Category') ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong><?= $itinerary['duration_days'] ?> days</strong>
                                                    <br><small class="text-muted"><?= $itinerary['duration_nights'] ?> nights</small>
                                                </td>
                                                <td>
                                                    <?php if (!empty($itinerary['discounted_price']) && $itinerary['discounted_price'] < $itinerary['price']): ?>
                                                        <span class="text-decoration-line-through text-muted small">₹<?= number_format($itinerary['price'], 0) ?></span><br>
                                                        <strong class="text-success">₹<?= number_format($itinerary['discounted_price'], 0) ?></strong>
                                                    <?php else: ?>
                                                        <strong>₹<?= number_format($itinerary['price'], 0) ?></strong>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $itinerary['status'] === 'published' ? 'success' : 'secondary' ?> status-badge" 
                                                          data-itinerary-id="<?= $itinerary['id'] ?>" 
                                                          data-current-status="<?= $itinerary['status'] ?>" 
                                                          style="cursor: pointer;" title="Click to toggle status">
                                                        <?= ucfirst($itinerary['status']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= !empty($itinerary['is_featured']) ? 'warning' : 'light text-dark' ?> featured-badge" 
                                                          data-itinerary-id="<?= $itinerary['id'] ?>" 
                                                          data-is-featured="<?= $itinerary['is_featured'] ?? 0 ?>" 
                                                          style="cursor: pointer;" title="Click to toggle featured">
                                                        <?= !empty($itinerary['is_featured']) ? 'Featured' : 'Regular' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?= date('M j, Y', strtotime($itinerary['created_at'] ?? 'now')) ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="<?= base_url('/admin/itineraries/edit/' . $itinerary['id']) ?>" 
                                                           class="btn btn-outline-primary" title="Edit">
                                                            <i data-lucide="edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-outline-danger delete-btn" 
                                                                data-itinerary-id="<?= $itinerary['id'] ?>" 
                                                                data-itinerary-name="<?= esc($itinerary['title']) ?>" title="Delete">
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
                            <i data-lucide="map" class="text-muted" style="width: 48px; height: 48px;"></i>
                            <h5 class="mt-3 text-muted">No itineraries found</h5>
                            <p class="text-muted">Create your first itinerary to get started.</p>
                            <a href="<?= base_url('/admin/itineraries/create') ?>" class="btn btn-primary">
                                <i data-lucide="plus" class="me-1"></i> Create Itinerary
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
                <p>Are you sure you want to delete "<span id="itineraryName"></span>"?</p>
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
    let deleteItineraryId = null;

    // Select all functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const itineraryCheckboxes = document.querySelectorAll('.itinerary-checkbox');
    
    selectAllCheckbox?.addEventListener('change', function() {
        itineraryCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const itineraryName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            
            if (itineraryName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Status badge click to toggle status
    document.querySelectorAll('.status-badge').forEach(badge => {
        badge.addEventListener('click', function() {
            const itineraryId = this.dataset.itineraryId;
            
            fetch(`/admin/itineraries/toggle-status/${itineraryId}`, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                    this.className = `badge bg-${data.status === 'published' ? 'success' : 'secondary'} status-badge`;
                    this.dataset.currentStatus = data.status;
                } else {
                    alert('Failed to update status');
                }
            });
        });
    });

    // Featured badge click to toggle featured status
    document.querySelectorAll('.featured-badge').forEach(badge => {
        badge.addEventListener('click', function() {
            const itineraryId = this.dataset.itineraryId;
            
            fetch(`/admin/itineraries/toggle-featured/${itineraryId}`, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.textContent = data.is_featured ? 'Featured' : 'Regular';
                    this.className = `badge bg-${data.is_featured ? 'warning' : 'light text-dark'} featured-badge`;
                    this.dataset.isFeatured = data.is_featured;
                } else {
                    alert('Failed to update featured status');
                }
            });
        });
    });

    // Delete functionality
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            deleteItineraryId = this.dataset.itineraryId;
            document.getElementById('itineraryName').textContent = this.dataset.itineraryName;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });

    document.getElementById('confirmDelete')?.addEventListener('click', function() {
        if (deleteItineraryId) {
            window.location.href = `/admin/itineraries/delete/${deleteItineraryId}`;
        }
    });

    // Bulk action form validation
    document.getElementById('bulkActionForm')?.addEventListener('submit', function(e) {
        const selectedItineraries = document.querySelectorAll('.itinerary-checkbox:checked');
        const bulkAction = document.querySelector('select[name="bulk_action"]').value;
        
        if (selectedItineraries.length === 0) {
            e.preventDefault();
            alert('Please select at least one itinerary');
            return;
        }
        
        if (!bulkAction) {
            e.preventDefault();
            alert('Please select an action');
            return;
        }
        
        if (!confirm(`Apply "${bulkAction}" to ${selectedItineraries.length} selected itinerary(s)?`)) {
            e.preventDefault();
        }
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>