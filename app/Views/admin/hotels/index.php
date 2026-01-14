<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Hotels</li>
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
                                    <i data-lucide="building" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Total Hotels</p>
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
                            <p class="text-muted mb-1">Active</p>
                            <h4 class="mb-0"><?= $stats['active'] ?? 0 ?></h4>
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
                        <h4 class="card-title mb-0">Hotels List</h4>
                        <div class="btn-group">
                            <a href="<?= base_url('/admin/destinations') ?>" class="btn btn-outline-secondary btn-sm">
                                <i data-lucide="map-pin" class="me-1"></i> Manage Destinations
                            </a>
                            <a href="<?= base_url('/admin/hotels/create') ?>" class="btn btn-primary btn-sm">
                                <i data-lucide="plus" class="me-1"></i> Add New Hotel
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="<?= base_url('/admin/hotels') ?>" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search hotels..." 
                                       value="<?= esc($currentFilters['search'] ?? '') ?>">
                            </div>
                            <div class="col-md-2">
                                <select name="destination_id" class="form-select">
                                    <option value="">All Destinations</option>
                                    <?php foreach ($destinations as $destination): ?>
                                        <option value="<?= $destination['id'] ?>" 
                                                <?= ($currentFilters['destination_id'] ?? '') == $destination['id'] ? 'selected' : '' ?>>
                                            <?= esc($destination['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="star_rating" class="form-select">
                                    <option value="">All Ratings</option>
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                        <option value="<?= $i ?>" 
                                                <?= ($currentFilters['star_rating'] ?? '') == $i ? 'selected' : '' ?>>
                                            <?= $i ?> Star<?= $i > 1 ? 's' : '' ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="active" <?= ($currentFilters['status'] ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= ($currentFilters['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group w-100">
                                    <button type="submit" class="btn btn-primary">
                                        <i data-lucide="search" class="me-1"></i> Search
                                    </button>
                                    <a href="<?= base_url('/admin/hotels') ?>" class="btn btn-outline-secondary">
                                        <i data-lucide="x" class="me-1"></i> Clear
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php if (!empty($hotels)): ?>
                        <form id="bulkActionForm" method="POST" action="<?= base_url('/admin/hotels/bulk-action') ?>">
                            <?= csrf_field() ?>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <select name="bulk_action" class="form-select form-select-sm" style="width: auto;">
                                            <option value="">Bulk Actions</option>
                                            <option value="activate">Activate</option>
                                            <option value="deactivate">Deactivate</option>
                                            <option value="feature">Mark as Featured</option>
                                            <option value="unfeature">Remove Featured</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-secondary">Apply</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-end">
                                        <input type="text" class="form-control form-control-sm" placeholder="Search hotels..." style="width: 250px;" id="searchInput">
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
                                            <th>Hotel</th>
                                            <th>Destination</th>
                                            <th>Star Rating</th>
                                            <th>Price/Night</th>
                                            <th>Status</th>
                                            <th>Featured</th>
                                            <th>Created</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($hotels as $hotel): ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input hotel-checkbox" 
                                                           name="hotel_ids[]" value="<?= $hotel['id'] ?>">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php if ($hotel['featured_image']): ?>
                                                            <img src="<?= base_url($hotel['featured_image']) ?>" 
                                                                 alt="<?= esc($hotel['name']) ?>" 
                                                                 class="me-2 rounded" width="40" height="40" style="object-fit: cover;">
                                                        <?php else: ?>
                                                            <div class="me-2 rounded bg-light d-flex align-items-center justify-content-center" 
                                                                 style="width: 40px; height: 40px;">
                                                                <i data-lucide="image" class="text-muted" style="width: 20px; height: 20px;"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div>
                                                            <strong><?= esc($hotel['name']) ?></strong>
                                                            <?php if (!empty($hotel['short_description'])): ?>
                                                                <br><small class="text-muted"><?= esc(substr($hotel['short_description'], 0, 50)) ?>...</small>
                                                            <?php endif; ?>
                                                            <?php if (!empty($hotel['address'])): ?>
                                                                <br><small class="text-muted"><i data-lucide="map-pin" style="width: 12px; height: 12px;"></i> <?= esc(substr($hotel['address'], 0, 30)) ?>...</small>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">
                                                        <?= esc($hotel['destination_name'] ?? 'No Destination') ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                                            <i data-lucide="star" class="<?= $i <= $hotel['star_rating'] ? 'text-warning' : 'text-muted' ?>" style="width: 16px; height: 16px;"></i>
                                                        <?php endfor; ?>
                                                        <span class="ms-1 small text-muted">(<?= $hotel['star_rating'] ?>)</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <strong>₹<?= number_format($hotel['price_per_night'], 0) ?></strong>
                                                    <br><small class="text-muted">per night</small>
                                                    <?php if (!empty($hotel['contact_phone'])): ?>
                                                        <br><small class="text-muted"><i data-lucide="phone" style="width: 12px; height: 12px;"></i> <?= esc($hotel['contact_phone']) ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $hotel['status'] === 'active' ? 'success' : 'secondary' ?> status-badge" 
                                                          data-hotel-id="<?= $hotel['id'] ?>" 
                                                          data-current-status="<?= $hotel['status'] ?>" 
                                                          style="cursor: pointer;" title="Click to toggle status">
                                                        <?= ucfirst($hotel['status']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= !empty($hotel['is_featured']) ? 'warning' : 'light text-dark' ?> featured-badge" 
                                                          data-hotel-id="<?= $hotel['id'] ?>" 
                                                          data-is-featured="<?= $hotel['is_featured'] ?? 0 ?>" 
                                                          style="cursor: pointer;" title="Click to toggle featured">
                                                        <?= !empty($hotel['is_featured']) ? 'Featured' : 'Regular' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?= date('M j, Y', strtotime($hotel['created_at'] ?? 'now')) ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="<?= base_url('/admin/hotels/show/' . $hotel['id']) ?>" 
                                                           class="btn btn-outline-secondary" title="View Details">
                                                            <i data-lucide="eye"></i>
                                                        </a>
                                                        <a href="<?= base_url('/hotels/' . ($hotel['slug'] ?? $hotel['id'])) ?>" 
                                                           class="btn btn-outline-info" title="View Public" target="_blank">
                                                            <i data-lucide="external-link"></i>
                                                        </a>
                                                        <a href="<?= base_url('/admin/hotels/edit/' . $hotel['id']) ?>" 
                                                           class="btn btn-outline-primary" title="Edit">
                                                            <i data-lucide="edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-outline-danger delete-btn" 
                                                                data-hotel-id="<?= $hotel['id'] ?>" 
                                                                data-hotel-name="<?= esc($hotel['name']) ?>" title="Delete">
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
                            <i data-lucide="building" class="text-muted" style="width: 48px; height: 48px;"></i>
                            <h5 class="mt-3 text-muted">No hotels found</h5>
                            <p class="text-muted">Create your first hotel to get started.</p>
                            <a href="<?= base_url('/admin/hotels/create') ?>" class="btn btn-primary">
                                <i data-lucide="plus" class="me-1"></i> Create Hotel
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
                <p>Are you sure you want to delete "<span id="hotelName"></span>"?</p>
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
    let deleteHotelId = null;

    // Select all functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const hotelCheckboxes = document.querySelectorAll('.hotel-checkbox');
    
    selectAllCheckbox?.addEventListener('change', function() {
        hotelCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const hotelName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            
            if (hotelName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Status badge click to toggle status
    document.querySelectorAll('.status-badge').forEach(badge => {
        badge.addEventListener('click', function() {
            const hotelId = this.dataset.hotelId;
            
            fetch(`/admin/hotels/toggle-status/${hotelId}`, {
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

    // Featured badge click to toggle featured status
    document.querySelectorAll('.featured-badge').forEach(badge => {
        badge.addEventListener('click', function() {
            const hotelId = this.dataset.hotelId;
            
            fetch(`/admin/hotels/toggle-featured/${hotelId}`, {
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
            deleteHotelId = this.dataset.hotelId;
            document.getElementById('hotelName').textContent = this.dataset.hotelName;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });

    document.getElementById('confirmDelete')?.addEventListener('click', function() {
        if (deleteHotelId) {
            window.location.href = `/admin/hotels/delete/${deleteHotelId}`;
        }
    });

    // Bulk action form validation
    document.getElementById('bulkActionForm')?.addEventListener('submit', function(e) {
        const selectedHotels = document.querySelectorAll('.hotel-checkbox:checked');
        const bulkAction = document.querySelector('select[name="bulk_action"]').value;
        
        if (selectedHotels.length === 0) {
            e.preventDefault();
            alert('Please select at least one hotel');
            return;
        }
        
        if (!bulkAction) {
            e.preventDefault();
            alert('Please select an action');
            return;
        }
        
        if (!confirm(`Apply "${bulkAction}" to ${selectedHotels.length} selected hotel(s)?`)) {
            e.preventDefault();
        }
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>