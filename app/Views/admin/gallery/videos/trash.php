<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/videos') ?>">Video Gallery</a></li>
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
                            Video Recycle Bin (<?= count($videos) ?> items)
                        </h4>
                        <a href="<?= base_url('/admin/videos') ?>" class="btn btn-outline-secondary">
                            <i data-lucide="arrow-left" class="me-1"></i> Back to Gallery
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($videos)): ?>
                        <div class="alert alert-warning">
                            <i data-lucide="alert-triangle" class="me-2"></i>
                            <strong>Note:</strong> Videos in the recycle bin are not visible on your website. 
                            You can restore them or permanently delete them.
                        </div>

                        <div class="row">
                            <?php foreach ($videos as $video): ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                <div class="card video-card border-warning">
                                    <div class="position-relative">
                                        <?php 
                                        $thumbnailUrl = '';
                                        if ($video['video_type'] === 'youtube') {
                                            $thumbnailUrl = "https://img.youtube.com/vi/{$video['video_id']}/maxresdefault.jpg";
                                        } else {
                                            $thumbnailUrl = $video['thumbnail'] ? base_url($video['thumbnail']) : base_url('assets/images/small/img-1.jpg');
                                        }
                                        ?>
                                        <img src="<?= $thumbnailUrl ?>" 
                                             class="card-img-top" 
                                             alt="<?= esc($video['title']) ?>" 
                                             style="height: 180px; object-fit: cover; opacity: 0.7;"
                                             onerror="this.src='<?= base_url('assets/images/small/img-1.jpg') ?>'">
                                        
                                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-25">
                                            <span class="badge bg-warning text-dark">
                                                <i data-lucide="trash-2" class="me-1"></i> Trashed
                                            </span>
                                        </div>

                                        <div class="position-absolute top-0 end-0 p-2">
                                            <span class="badge bg-<?= $video['video_type'] === 'youtube' ? 'danger' : 'purple' ?>">
                                                <?= strtoupper($video['video_type']) ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <h6 class="card-title mb-1 text-muted" title="<?= esc($video['title']) ?>">
                                            <?= esc(strlen($video['title']) > 25 ? substr($video['title'], 0, 25) . '...' : $video['title']) ?>
                                        </h6>
                                        <small class="text-muted">
                                            Deleted: <?= date('M j, Y', strtotime($video['deleted_at'])) ?>
                                        </small>
                                        <?php if ($video['description']): ?>
                                            <p class="text-muted small mt-1 mb-2">
                                                <?= esc(strlen($video['description']) > 50 ? substr($video['description'], 0, 50) . '...' : $video['description']) ?>
                                            </p>
                                        <?php endif; ?>
                                        <div class="mt-2">
                                            <div class="btn-group btn-group-sm w-100">
                                                <button type="button" class="btn btn-outline-info play-video" 
                                                        title="Preview"
                                                        data-video-type="<?= $video['video_type'] ?>"
                                                        data-video-url="<?= esc($video['video_url']) ?>"
                                                        data-video-title="<?= esc($video['title']) ?>">
                                                    <i data-lucide="eye"></i>
                                                </button>
                                                <a href="<?= base_url('/admin/videos/restore/' . $video['id']) ?>" 
                                                   class="btn btn-outline-success" 
                                                   title="Restore"
                                                   onclick="return confirm('Are you sure you want to restore this video?')">
                                                    <i data-lucide="rotate-ccw"></i>
                                                </a>
                                                <a href="<?= base_url('/admin/videos/force-delete/' . $video['id']) ?>" 
                                                   class="btn btn-outline-danger" 
                                                   title="Delete Permanently"
                                                   onclick="return confirm('Are you sure you want to permanently delete this video? This action cannot be undone!')">
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
                                    <form method="post" action="<?= base_url('/admin/videos/bulk-restore') ?>" class="d-inline">
                                        <input type="hidden" name="video_ids" value="<?= implode(',', array_column($videos, 'id')) ?>">
                                        <button type="submit" class="btn btn-success me-2" 
                                                onclick="return confirm('Are you sure you want to restore all trashed videos?')">
                                            <i data-lucide="rotate-ccw" class="me-1"></i>
                                            Restore All (<?= count($videos) ?>)
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-6 text-end">
                                    <form method="post" action="<?= base_url('/admin/videos/empty-trash') ?>" class="d-inline">
                                        <button type="submit" class="btn btn-danger" 
                                                onclick="return confirm('Are you sure you want to permanently delete ALL trashed videos? This action cannot be undone!')">
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
                            <p class="text-muted">Deleted videos will appear here before being permanently removed.</p>
                            <a href="<?= base_url('/admin/videos') ?>" class="btn btn-primary">
                                <i data-lucide="arrow-left" class="me-1"></i> Back to Gallery
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Video Player Modal -->
<div class="modal fade" id="videoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i data-lucide="trash-2" class="me-2 text-warning"></i>
                    <span id="videoTitle">Trashed Video Preview</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div id="videoContainer" class="ratio ratio-16x9">
                    <!-- Video content will be loaded here -->
                </div>
                <div class="p-3">
                    <div class="alert alert-warning mb-0">
                        <i data-lucide="alert-triangle" class="me-2"></i>
                        This video is in the recycle bin and not visible on your website.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="restoreBtn">
                    <i data-lucide="rotate-ccw" class="me-1"></i> Restore Video
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentVideoId = null;
    
    // Video player functionality
    document.querySelectorAll('.play-video').forEach(button => {
        button.addEventListener('click', function() {
            const videoType = this.getAttribute('data-video-type');
            const videoUrl = this.getAttribute('data-video-url');
            const videoTitle = this.getAttribute('data-video-title');
            
            // Extract video ID from the restore link in the same card
            const card = this.closest('.card');
            const restoreLink = card.querySelector('a[href*="/restore/"]');
            if (restoreLink) {
                const href = restoreLink.getAttribute('href');
                currentVideoId = href.split('/').pop();
            }
            
            document.getElementById('videoTitle').textContent = videoTitle;
            const container = document.getElementById('videoContainer');
            
            if (videoType === 'youtube') {
                // Extract YouTube video ID
                const videoId = extractYouTubeId(videoUrl);
                container.innerHTML = `<iframe src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
            } else {
                // MP4 video
                container.innerHTML = `<video controls class="w-100 h-100"><source src="${videoUrl}" type="video/mp4">Your browser does not support the video tag.</video>`;
            }
            
            new bootstrap.Modal(document.getElementById('videoModal')).show();
        });
    });

    // Clear video when modal is closed
    document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('videoContainer').innerHTML = '';
    });
    
    // Restore button in modal
    document.getElementById('restoreBtn').addEventListener('click', function() {
        if (currentVideoId) {
            if (confirm('Are you sure you want to restore this video?')) {
                window.location.href = `<?= base_url('/admin/videos/restore/') ?>${currentVideoId}`;
            }
        }
    });

    function extractYouTubeId(url) {
        const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
        const matches = url.match(regex);
        return matches ? matches[1] : null;
    }
});
</script>

<style>
.video-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.video-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.video-card.border-warning {
    border-color: #ffc107 !important;
}

.video-card .card-img-top {
    filter: grayscale(20%);
}

.video-card:hover .card-img-top {
    filter: grayscale(0%);
}

.text-purple {
    color: #6f42c1 !important;
}

.bg-purple {
    background-color: #6f42c1 !important;
}
</style>

<?= $this->include('layouts/dashboard_footer') ?>