<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/blogs') ?>">Blog Posts</a></li>
                        <li class="breadcrumb-item active">Trash</li>
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
                        <h4 class="card-title mb-0">Trashed Blog Posts</h4>
                        <a href="<?= base_url('/admin/blogs') ?>" class="btn btn-secondary btn-sm">
                            <i data-lucide="arrow-left" class="me-1"></i> Back to Blog Posts
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($posts)): ?>
                        <div class="alert alert-warning">
                            <i data-lucide="alert-triangle" class="me-2"></i>
                            <strong>Note:</strong> Blog posts in trash are not visible on your website. 
                            You can restore them or permanently delete them.
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Featured</th>
                                        <th>Author</th>
                                        <th>Deleted</th>
                                        <th width="200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($posts as $post): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if ($post['featured_image']): ?>
                                                        <img src="<?= base_url($post['featured_image']) ?>" 
                                                             alt="Featured" class="me-2 rounded" width="40" height="60">
                                                    <?php endif; ?>
                                                    <div>
                                                        <strong class="text-muted"><?= esc($post['title']) ?></strong>
                                                        <span class="badge bg-danger ms-1">Trashed</span>
                                                        <?php if (!empty($post['excerpt'])): ?>
                                                            <br><small class="text-muted"><?= esc(substr($post['excerpt'], 0, 60)) ?>...</small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $post['status'] === 'published' ? 'success' : 'warning' ?>">
                                                    <?= ucfirst($post['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= !empty($post['is_featured']) ? 'info' : 'secondary' ?>">
                                                    <?= !empty($post['is_featured']) ? 'Featured' : 'Regular' ?>
                                                </span>
                                            </td>
                                            <td><?= esc($post['author_name']) ?></td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= date('M j, Y g:i A', strtotime($post['deleted_at'])) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button" class="btn btn-outline-success restore-btn" 
                                                            data-post-id="<?= $post['id'] ?>" 
                                                            data-post-title="<?= esc($post['title']) ?>" title="Restore">
                                                        <i data-lucide="rotate-ccw"></i> Restore
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger force-delete-btn" 
                                                            data-post-id="<?= $post['id'] ?>" 
                                                            data-post-title="<?= esc($post['title']) ?>" title="Permanently Delete">
                                                        <i data-lucide="trash-2"></i> Delete Forever
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i data-lucide="trash-2" class="text-muted" style="width: 48px; height: 48px;"></i>
                            <h5 class="mt-3 text-muted">Trash is empty</h5>
                            <p class="text-muted">No blog posts have been moved to trash.</p>
                            <a href="<?= base_url('/admin/blogs') ?>" class="btn btn-primary">
                                <i data-lucide="arrow-left" class="me-1"></i> Back to Blog Posts
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Restore Confirmation Modal -->
<div class="modal fade" id="restoreModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Restore</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to restore "<span id="restorePostTitle"></span>"?</p>
                <p class="text-muted small">The blog post will be moved back to the posts list.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmRestore">Restore Post</button>
            </div>
        </div>
    </div>
</div>

<!-- Force Delete Confirmation Modal -->
<div class="modal fade" id="forceDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Permanent Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i data-lucide="alert-triangle" class="me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone!
                </div>
                <p>Are you sure you want to permanently delete "<span id="deletePostTitle"></span>"?</p>
                <p class="text-muted small">This will completely remove the blog post and all its data from the database.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmForceDelete">Delete Forever</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let actionPostId = null;

    // Restore functionality
    document.querySelectorAll('.restore-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            actionPostId = this.dataset.postId;
            document.getElementById('restorePostTitle').textContent = this.dataset.postTitle;
            new bootstrap.Modal(document.getElementById('restoreModal')).show();
        });
    });

    document.getElementById('confirmRestore')?.addEventListener('click', function() {
        if (actionPostId) {
            window.location.href = `/admin/blogs/restore/${actionPostId}`;
        }
    });

    // Force delete functionality
    document.querySelectorAll('.force-delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            actionPostId = this.dataset.postId;
            document.getElementById('deletePostTitle').textContent = this.dataset.postTitle;
            new bootstrap.Modal(document.getElementById('forceDeleteModal')).show();
        });
    });

    document.getElementById('confirmForceDelete')?.addEventListener('click', function() {
        if (actionPostId) {
            window.location.href = `/admin/blogs/force-delete/${actionPostId}`;
        }
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>