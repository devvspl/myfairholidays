<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/images') ?>">Image Gallery</a></li>
                        <li class="breadcrumb-item active">Recycle Bin</li>
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i data-lucide="trash-2" class="me-2"></i>
                            Recycle Bin (<?= count($images) ?> items)
                        </h4>
                        <a href="<?= base_url('/admin/images') ?>" class="btn btn-outline-secondary">
                            <i data-lucide="arrow-left" class="me-1"></i> Back to Gallery
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($images)): ?>
                        <div class="alert alert-warning">
                            <i data-lucide="alert-triangle" class="me-2"></i>
                            <strong>Note:</strong> Images in the recycle bin are not visible on your website. 
                            You can restore them or permanently delete them.
                        </div>

                        <div class="row">
                            <?php foreach ($images as $image): ?>
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card image-card border-warning">
                                    <div class="position-relative">
                                        <img src="<?= base_url($image['image_path']) ?>" 
                                             class="card-img-top" 
                                             alt="<?= esc($image['alt_text'] ?: $image['title']) ?>" 
                                             style="height: 150px; object-fit: cover; opacity: 0.7;"
                                             onerror="this.src='<?= base_url('assets/images/small/img-1.jpg') ?>'">
                                        
                                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-25">
                                            <span class="badge bg-warning text-dark">
                                                <i data-lucide="trash-2" class="me-1"></i> Trashed
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body p-2">
                                        <h6 class="card-title mb-1 text-muted" title="<?= esc($image['title']) ?>">
                                            <?= esc(strlen($image['title']) > 20 ? substr($image['title'], 0, 20) . '...' : $image['title']) ?>
                                        </h6>
                                        <small class="text-muted">
                                            Deleted: <?= date('M j, Y', strtotime($image['deleted_at'])) ?>
                                        </small>
                                        <div class="mt-2">
                                            <div class="btn-group btn-group-sm w-100">
                                                <button type="button" class="btn btn-outline-info view-image" 
                                                        title="View"
                                                        data-image="<?= base_url($image['image_path']) ?>"
                                                        data-title="<?= esc($image['title']) ?>"
                                                        data-alt="<?= esc($image['alt_text']) ?>">
                                                    <i data-lucide="eye"></i>
                                                </button>
                                                <a href="<?= base_url('/admin/images/restore/' . $image['id']) ?>" 
                                                   class="btn btn-outline-success" 
                                                   title="Restore"
                                                   onclick="return confirm('Are you sure you want to restore this image?')">
                                                    <i data-lucide="rotate-ccw"></i>
                                                </a>
                                                <a href="<?= base_url('/admin/images/force-delete/' . $image['id']) ?>" 
                                                   class="btn btn-outline-danger" 
                                                   title="Delete Permanently"
                                                   onclick="return confirm('Are you sure you want to permanently delete this image? This action cannot be undone!')">
                                                    <i data-lucide="x"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Bulk Actions for Trash -->
                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="mb-3">Bulk Actions</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <form method="post" action="<?= base_url('/admin/images/bulk-restore') ?>" class="d-inline">
                                        <input type="hidden" name="image_ids" value="<?= implode(',', array_column($images, 'id')) ?>">
                                        <button type="submit" class="btn btn-success me-2" 
                                                onclick="return confirm('Are you sure you want to restore all trashed images?')">
                                            <i data-lucide="rotate-ccw" class="me-1"></i>
                                            Restore All (<?= count($images) ?>)
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-6 text-end">
                                    <form method="post" action="<?= base_url('/admin/images/empty-trash') ?>" class="d-inline">
                                        <button type="submit" class="btn btn-danger" 
                                                onclick="return confirm('Are you sure you want to permanently delete ALL trashed images? This action cannot be undone!')">
                                            <i data-lucide="trash-2" class="me-1"></i>
                                            Empty Trash
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Empty trash state -->
                        <div class="text-center py-5">
                            <i data-lucide="trash-2" class="text-muted mb-3" style="width: 64px; height: 64px;"></i>
                            <h5 class="text-muted">Recycle bin is empty</h5>
                            <p class="text-muted">Deleted images will appear here before being permanently removed.</p>
                            <a href="<?= base_url('/admin/images') ?>" class="btn btn-primary">
                                <i data-lucide="arrow-left" class="me-1"></i> Back to Gallery
                            </a>
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
                <h5 class="modal-title">
                    <i data-lucide="trash-2" class="me-2 text-warning"></i>
                    Trashed Image Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="viewImage" src="" alt="" class="img-fluid rounded mb-3" style="opacity: 0.8;">
                <div>
                    <h6 id="viewTitle"></h6>
                    <p class="text-muted" id="viewAlt"></p>
                    <div class="alert alert-warning">
                        <i data-lucide="alert-triangle" class="me-2"></i>
                        This image is in the recycle bin and not visible on your website.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="restoreBtn">
                    <i data-lucide="rotate-ccw" class="me-1"></i> Restore Image
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentImageId = null;
    
    // View image modal
    document.querySelectorAll('.view-image').forEach(button => {
        button.addEventListener('click', function() {
            const imageSrc = this.getAttribute('data-image');
            const title = this.getAttribute('data-title');
            const altText = this.getAttribute('data-alt');
            
            // Extract image ID from the restore link in the same card
            const card = this.closest('.card');
            const restoreLink = card.querySelector('a[href*="/restore/"]');
            if (restoreLink) {
                const href = restoreLink.getAttribute('href');
                currentImageId = href.split('/').pop();
            }
            
            document.getElementById('viewImage').src = imageSrc;
            document.getElementById('viewTitle').textContent = title;
            document.getElementById('viewAlt').textContent = altText || 'No alt text provided';
            
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        });
    });
    
    // Restore button in modal
    document.getElementById('restoreBtn').addEventListener('click', function() {
        if (currentImageId) {
            if (confirm('Are you sure you want to restore this image?')) {
                window.location.href = `<?= base_url('/admin/images/restore/') ?>${currentImageId}`;
            }
        }
    });
});
</script>

<style>
.image-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.image-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.image-card.border-warning {
    border-color: #ffc107 !important;
}

.image-card .card-img-top {
    filter: grayscale(20%);
}

.image-card:hover .card-img-top {
    filter: grayscale(0%);
}
</style>

<?= $this->include('layouts/dashboard_footer') ?>