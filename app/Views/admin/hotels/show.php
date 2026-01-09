<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/hotels') ?>">Hotels</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Hotel Information -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Hotel Information</h4>
                        <div class="btn-group">
                            <a href="<?= base_url('/hotels/' . ($hotel['slug'] ?? $hotel['id'])) ?>" 
                               class="btn btn-outline-info btn-sm" target="_blank">
                                <i data-lucide="external-link" class="me-1"></i> View Public
                            </a>
                            <a href="<?= base_url('/admin/hotels/edit/' . $hotel['id']) ?>" 
                               class="btn btn-primary btn-sm">
                                <i data-lucide="edit" class="me-1"></i> Edit Hotel
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-medium text-muted" width="120">Name:</td>
                                    <td><?= esc($hotel['name']) ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium text-muted">Slug:</td>
                                    <td><code><?= esc($hotel['slug'] ?? 'auto-generated') ?></code></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium text-muted">Destination:</td>
                                    <td>
                                        <span class="badge bg-primary"><?= esc($hotel['destination_name'] ?? 'No Destination') ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium text-muted">Star Rating:</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i data-lucide="star" class="<?= $i <= ($hotel['star_rating'] ?? 0) ? 'text-warning' : 'text-muted' ?>" style="width: 16px; height: 16px;"></i>
                                            <?php endfor; ?>
                                            <span class="ms-2">(<?= $hotel['star_rating'] ?? 0 ?> Star)</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium text-muted">Price per Night:</td>
                                    <td><strong class="text-success">₹<?= number_format($hotel['price_per_night'] ?? 0, 2) ?></strong></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-medium text-muted" width="120">Status:</td>
                                    <td>
                                        <span class="badge bg-<?= ($hotel['status'] ?? 'inactive') === 'active' ? 'success' : 'secondary' ?>">
                                            <?= ucfirst($hotel['status'] ?? 'inactive') ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium text-muted">Featured:</td>
                                    <td>
                                        <span class="badge bg-<?= !empty($hotel['is_featured']) ? 'warning' : 'light text-dark' ?>">
                                            <?= !empty($hotel['is_featured']) ? 'Yes' : 'No' ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium text-muted">Sort Order:</td>
                                    <td><?= $hotel['sort_order'] ?? 0 ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium text-muted">Created:</td>
                                    <td><?= date('M j, Y g:i A', strtotime($hotel['created_at'] ?? 'now')) ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium text-muted">Updated:</td>
                                    <td><?= date('M j, Y g:i A', strtotime($hotel['updated_at'] ?? 'now')) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Description</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($hotel['description'])): ?>
                        <div class="mb-3">
                            <h6 class="text-muted">Full Description:</h6>
                            <p><?= nl2br(esc($hotel['description'])) ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($hotel['short_description'])): ?>
                        <div class="mb-3">
                            <h6 class="text-muted">Short Description:</h6>
                            <p class="text-muted"><?= esc($hotel['short_description']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Location & Contact -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Location & Contact Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Address:</h6>
                            <p><?= nl2br(esc($hotel['address'] ?? 'Not provided')) ?></p>
                            
                            <?php if (!empty($hotel['latitude']) && !empty($hotel['longitude'])): ?>
                                <h6 class="text-muted">Coordinates:</h6>
                                <p>
                                    <strong>Lat:</strong> <?= $hotel['latitude'] ?><br>
                                    <strong>Lng:</strong> <?= $hotel['longitude'] ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <?php if (!empty($hotel['contact_phone'])): ?>
                                <h6 class="text-muted">Phone:</h6>
                                <p><i data-lucide="phone" class="me-1"></i> <?= esc($hotel['contact_phone']) ?></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($hotel['contact_email'])): ?>
                                <h6 class="text-muted">Email:</h6>
                                <p><i data-lucide="mail" class="me-1"></i> <a href="mailto:<?= esc($hotel['contact_email']) ?>"><?= esc($hotel['contact_email']) ?></a></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($hotel['website'])): ?>
                                <h6 class="text-muted">Website:</h6>
                                <p><i data-lucide="globe" class="me-1"></i> <a href="<?= esc($hotel['website']) ?>" target="_blank"><?= esc($hotel['website']) ?></a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Amenities -->
            <?php if (!empty($hotel['amenities'])): ?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Amenities & Services</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php 
                            $amenities = explode(',', $hotel['amenities']);
                            foreach ($amenities as $amenity): 
                                $amenity = trim($amenity);
                                if (!empty($amenity)):
                            ?>
                                <div class="col-md-6 col-lg-4 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i data-lucide="check" class="text-success me-2" style="width: 16px; height: 16px;"></i>
                                        <span><?= esc($amenity) ?></span>
                                    </div>
                                </div>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- SEO Information -->
            <?php if (!empty($hotel['meta_title']) || !empty($hotel['meta_description'])): ?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">SEO Information</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($hotel['meta_title'])): ?>
                            <div class="mb-3">
                                <h6 class="text-muted">Meta Title:</h6>
                                <p><?= esc($hotel['meta_title']) ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($hotel['meta_description'])): ?>
                            <div class="mb-3">
                                <h6 class="text-muted">Meta Description:</h6>
                                <p><?= esc($hotel['meta_description']) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <!-- Featured Image -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Featured Image</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($hotel['featured_image'])): ?>
                        <img src="<?= base_url($hotel['featured_image']) ?>" 
                             alt="<?= esc($hotel['name']) ?>" 
                             class="img-fluid rounded">
                    <?php else: ?>
                        <div class="text-center py-5 bg-light rounded">
                            <i data-lucide="image" class="text-muted mb-2" style="width: 48px; height: 48px;"></i>
                            <p class="text-muted mb-0">No featured image</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('/admin/hotels/edit/' . $hotel['id']) ?>" 
                           class="btn btn-primary">
                            <i data-lucide="edit" class="me-1"></i> Edit Hotel
                        </a>
                        
                        <button type="button" class="btn btn-outline-<?= ($hotel['status'] ?? 'inactive') === 'active' ? 'warning' : 'success' ?> toggle-status-btn"
                                data-hotel-id="<?= $hotel['id'] ?>" 
                                data-current-status="<?= $hotel['status'] ?? 'inactive' ?>">
                            <i data-lucide="<?= ($hotel['status'] ?? 'inactive') === 'active' ? 'pause' : 'play' ?>" class="me-1"></i>
                            <?= ($hotel['status'] ?? 'inactive') === 'active' ? 'Deactivate' : 'Activate' ?>
                        </button>
                        
                        <button type="button" class="btn btn-outline-<?= !empty($hotel['is_featured']) ? 'secondary' : 'warning' ?> toggle-featured-btn"
                                data-hotel-id="<?= $hotel['id'] ?>" 
                                data-is-featured="<?= $hotel['is_featured'] ?? 0 ?>">
                            <i data-lucide="star" class="me-1"></i>
                            <?= !empty($hotel['is_featured']) ? 'Remove Featured' : 'Mark Featured' ?>
                        </button>
                        
                        <a href="<?= base_url('/hotels/' . ($hotel['slug'] ?? $hotel['id'])) ?>" 
                           class="btn btn-outline-info" target="_blank">
                            <i data-lucide="external-link" class="me-1"></i> View Public Page
                        </a>
                        
                        <hr>
                        
                        <button type="button" class="btn btn-outline-danger delete-btn"
                                data-hotel-id="<?= $hotel['id'] ?>" 
                                data-hotel-name="<?= esc($hotel['name']) ?>">
                            <i data-lucide="trash-2" class="me-1"></i> Delete Hotel
                        </button>
                        
                        <a href="<?= base_url('/admin/hotels') ?>" class="btn btn-secondary">
                            <i data-lucide="arrow-left" class="me-1"></i> Back to List
                        </a>
                    </div>
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

    // Toggle status
    document.querySelector('.toggle-status-btn')?.addEventListener('click', function() {
        const hotelId = this.dataset.hotelId;
        
        fetch(`/admin/hotels/toggle-status/${hotelId}`, {
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

    // Toggle featured
    document.querySelector('.toggle-featured-btn')?.addEventListener('click', function() {
        const hotelId = this.dataset.hotelId;
        
        fetch(`/admin/hotels/toggle-featured/${hotelId}`, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to update featured status');
            }
        });
    });

    // Delete functionality
    document.querySelector('.delete-btn')?.addEventListener('click', function() {
        deleteHotelId = this.dataset.hotelId;
        document.getElementById('hotelName').textContent = this.dataset.hotelName;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });

    document.getElementById('confirmDelete')?.addEventListener('click', function() {
        if (deleteHotelId) {
            window.location.href = `/admin/hotels/delete/${deleteHotelId}`;
        }
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>