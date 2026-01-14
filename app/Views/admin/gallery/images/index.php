<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Image Gallery</li>
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

    <!-- Statistics Cards -->
<!-- Image Statistics Cards -->
<div class="row mb-1">

    <!-- Total Images -->
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm">
                            <div class="avatar-title bg-primary-subtle text-primary rounded">
                                <i data-lucide="image" class="fs-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1">Total Images</p>
                        <h4 class="mb-0"><?= $stats['total'] ?? 0 ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active -->
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
                        <h4 class="mb-0 text-success"><?= $stats['active'] ?? 0 ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Homepage -->
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm">
                            <div class="avatar-title bg-info-subtle text-info rounded">
                                <i data-lucide="home" class="fs-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1">Homepage</p>
                        <h4 class="mb-0 text-info"><?= $stats['homepage'] ?? 0 ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trashed -->
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm">
                            <div class="avatar-title bg-warning-subtle text-warning rounded">
                                <i data-lucide="trash-2" class="fs-20"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1">Trashed</p>
                        <h4 class="mb-0 text-warning"><?= $stats['trashed'] ?? 0 ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Image Gallery</h4>
                        <div class="btn-group">
                            <a href="<?= base_url('/admin/images/trash') ?>" class="btn btn-outline-warning btn-sm">
                                <i data-lucide="trash-2" class="me-1"></i> Recycle Bin (<?= $stats['trashed'] ?? 0 ?>)
                            </a>
                            <a href="<?= base_url('/admin/images/create') ?>" class="btn btn-primary btn-sm">
                                <i data-lucide="plus" class="me-1"></i> Add New Image
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Bulk Actions -->
                    <?php if (!empty($images)): ?>
                    <form id="bulkForm" method="post" action="<?= base_url('/admin/images/bulk-action') ?>">
                        <?= csrf_field() ?>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <select name="bulk_action" class="form-select me-2" style="width: auto;">
                                        <option value="">Bulk Actions</option>
                                        <option value="activate">Activate Selected</option>
                                        <option value="deactivate">Deactivate Selected</option>
                                        <option value="delete">Move to Trash</option>
                                    </select>
                                    <button type="submit" class="btn btn-outline-secondary btn-sm">Apply</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search images..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i data-lucide="search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Images Grid -->
                    <div class="row" id="imagesGrid">
                        <?php if (!empty($images)): ?>
                            <?php foreach ($images as $image): ?>
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card image-card">
                                    <div class="position-relative">
                                        <img src="<?= base_url($image['image_path']) ?>" 
                                             class="card-img-top" 
                                             alt="<?= esc($image['alt_text'] ?: $image['title']) ?>" 
                                             style="height: 150px; object-fit: cover;"
                                             onerror="this.src='<?= base_url('assets/images/small/img-1.jpg') ?>'">
                                        
                                        <div class="position-absolute top-0 start-0 p-2">
                                            <input type="checkbox" name="selected_ids[]" value="<?= $image['id'] ?>" class="form-check-input">
                                        </div>
                                        
                                        <div class="position-absolute top-0 end-0 p-2">
                                            <?php if ($image['is_homepage']): ?>
                                                <span class="badge bg-info">Homepage</span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="position-absolute bottom-0 start-0 p-2">
                                            <span class="badge <?= $image['status'] === 'active' ? 'bg-success' : 'bg-warning' ?>">
                                                <?= ucfirst($image['status']) ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body p-2">
                                        <h6 class="card-title mb-1" title="<?= esc($image['title']) ?>">
                                            <?= esc(strlen($image['title']) > 20 ? substr($image['title'], 0, 20) . '...' : $image['title']) ?>
                                        </h6>
                                        <small class="text-muted">
                                            <?= date('M j, Y', strtotime($image['created_at'])) ?>
                                        </small>
                                        <div class="mt-2">
                                            <div class="btn-group btn-group-sm w-100">
                                                <a href="<?= base_url('/admin/images/edit/' . $image['id']) ?>" 
                                                   class="btn btn-outline-primary" title="Edit">
                                                    <i data-lucide="edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-info view-image" 
                                                        title="View"
                                                        data-image="<?= base_url($image['image_path']) ?>"
                                                        data-title="<?= esc($image['title']) ?>"
                                                        data-alt="<?= esc($image['alt_text']) ?>">
                                                    <i data-lucide="eye"></i>
                                                </button>
                                                <a href="<?= base_url('/admin/images/toggle-homepage/' . $image['id']) ?>" 
                                                   class="btn btn-outline-<?= $image['is_homepage'] ? 'warning' : 'info' ?>" 
                                                   title="<?= $image['is_homepage'] ? 'Remove from Homepage' : 'Add to Homepage' ?>">
                                                    <i data-lucide="home"></i>
                                                </a>
                                                <a href="<?= base_url('/admin/images/delete/' . $image['id']) ?>" 
                                                   class="btn btn-outline-danger" 
                                                   title="Delete"
                                                   onclick="return confirm('Are you sure you want to move this image to trash?')">
                                                    <i data-lucide="trash-2"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Empty state when no images -->
                            <div class="col-12 text-center py-5">
                                <i data-lucide="image" class="text-muted" style="width: 48px; height: 48px;"></i>
                                <h5 class="mt-3 text-muted">No images found</h5>
                                <p class="text-muted">Upload your first image to get started.</p>
                                <a href="<?= base_url('/admin/images/create') ?>" class="btn btn-primary">
                                    <i data-lucide="plus" class="me-1"></i> Add New Image
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($images)): ?>
                        </form>
                    <?php endif; ?>

                    <!-- Pagination -->
                    <?php if (isset($pager)): ?>
                        <div class="d-flex justify-content-center">
                            <?= $pager->links() ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Image Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="viewImage" src="" alt="" class="img-fluid rounded mb-3">
                <div>
                    <h6 id="viewTitle"></h6>
                    <p class="text-muted" id="viewAlt"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // View image modal
    document.querySelectorAll('.view-image').forEach(button => {
        button.addEventListener('click', function() {
            const imageSrc = this.getAttribute('data-image');
            const title = this.getAttribute('data-title');
            const altText = this.getAttribute('data-alt');
            
            document.getElementById('viewImage').src = imageSrc;
            document.getElementById('viewTitle').textContent = title;
            document.getElementById('viewAlt').textContent = altText || 'No alt text provided';
            
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        });
    });

    // Bulk actions
    const bulkForm = document.getElementById('bulkForm');
    if (bulkForm) {
        bulkForm.addEventListener('submit', function(e) {
            const action = this.querySelector('select[name="bulk_action"]').value;
            const selected = this.querySelectorAll('input[name="selected_ids[]"]:checked');
            
            if (!action) {
                e.preventDefault();
                alert('Please select an action');
                return;
            }
            
            if (selected.length === 0) {
                e.preventDefault();
                alert('Please select at least one image');
                return;
            }
            
            if (action === 'delete') {
                if (!confirm(`Are you sure you want to move ${selected.length} image(s) to trash?`)) {
                    e.preventDefault();
                }
            }
        });
    }

    // Select all checkbox
    const selectAllBtn = document.createElement('button');
    selectAllBtn.type = 'button';
    selectAllBtn.className = 'btn btn-outline-secondary btn-sm ms-2';
    selectAllBtn.innerHTML = '<i data-lucide="check-square"></i> Select All';
    selectAllBtn.addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkboxes.forEach(cb => cb.checked = !allChecked);
        this.innerHTML = allChecked ? '<i data-lucide="check-square"></i> Select All' : '<i data-lucide="square"></i> Deselect All';
    });
    
    const bulkActions = document.querySelector('.d-flex.align-items-center');
    if (bulkActions) {
        bulkActions.appendChild(selectAllBtn);
    }

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }

    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const imageCards = document.querySelectorAll('.image-card');
        
        imageCards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const parent = card.closest('.col-xl-2, .col-lg-3, .col-md-4, .col-sm-6');
            
            if (title.includes(searchTerm)) {
                parent.style.display = '';
            } else {
                parent.style.display = 'none';
            }
        });
    }
});
</script>
<?= $this->include('layouts/dashboard_footer') ?>