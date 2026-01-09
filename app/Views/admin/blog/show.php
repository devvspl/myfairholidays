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
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0"><?= esc($post['title']) ?></h4>
                        <div class="d-flex gap-2">
                            <span class="badge bg-<?= $post['status'] === 'published' ? 'success' : 'warning' ?>">
                                <?= ucfirst($post['status']) ?>
                            </span>
                            <?php if (!empty($post['is_featured'])): ?>
                                <span class="badge bg-info">Featured</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($post['featured_image']): ?>
                        <div class="mb-4">
                            <img src="<?= base_url($post['featured_image']) ?>" 
                                 alt="<?= esc($post['title']) ?>" class="img-fluid rounded">
                        </div>
                    <?php endif; ?>

                    <?php if ($post['excerpt']): ?>
                        <div class="alert alert-light">
                            <strong>Excerpt:</strong> <?= esc($post['excerpt']) ?>
                        </div>
                    <?php endif; ?>

                    <div class="content">
                        <?= $post['content'] ?>
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            <?php if ($post['meta_title'] || $post['meta_description'] || $post['meta_keywords']): ?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">SEO Information</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($post['meta_title']): ?>
                            <div class="mb-3">
                                <strong>Meta Title:</strong><br>
                                <span class="text-muted"><?= esc($post['meta_title']) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($post['meta_description']): ?>
                            <div class="mb-3">
                                <strong>Meta Description:</strong><br>
                                <span class="text-muted"><?= esc($post['meta_description']) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($post['meta_keywords']): ?>
                            <div class="mb-3">
                                <strong>Meta Keywords:</strong><br>
                                <span class="text-muted"><?= esc($post['meta_keywords']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <!-- Post Information -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Post Information</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>URL Slug:</strong></td>
                            <td>
                                <code><?= esc($post['slug']) ?></code>
                                <a href="<?= base_url('blog/' . $post['slug']) ?>" target="_blank" class="ms-2">
                                    <i data-lucide="external-link" class="text-muted"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Template:</strong></td>
                            <td><?= ucfirst($post['template']) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Author:</strong></td>
                            <td><?= esc($post['author_name']) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Featured:</strong></td>
                            <td>
                                <span class="badge bg-<?= !empty($post['is_featured']) ? 'info' : 'secondary' ?>">
                                    <?= !empty($post['is_featured']) ? 'Yes' : 'No' ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td><?= date('M j, Y g:i A', strtotime($post['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Updated:</strong></td>
                            <td><?= date('M j, Y g:i A', strtotime($post['updated_at'])) ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Actions</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('/admin/blogs/edit/' . $post['id']) ?>" class="btn btn-primary">
                            <i data-lucide="edit" class="me-1"></i> Edit Post
                        </a>
                        
                        <a href="<?= base_url('blog/' . $post['slug']) ?>" target="_blank" class="btn btn-outline-info">
                            <i data-lucide="external-link" class="me-1"></i> View on Site
                        </a>

                        <button type="button" class="btn btn-outline-secondary status-toggle-btn" 
                                data-post-id="<?= $post['id'] ?>" data-current-status="<?= $post['status'] ?>">
                            <i data-lucide="<?= $post['status'] === 'published' ? 'eye-off' : 'eye' ?>" class="me-1"></i>
                            <?= $post['status'] === 'published' ? 'Unpublish' : 'Publish' ?>
                        </button>

                        <button type="button" class="btn btn-outline-info featured-toggle-btn" 
                                data-post-id="<?= $post['id'] ?>" data-current-featured="<?= !empty($post['is_featured']) ? '1' : '0' ?>">
                            <i data-lucide="<?= !empty($post['is_featured']) ? 'star-off' : 'star' ?>" class="me-1"></i>
                            <?= !empty($post['is_featured']) ? 'Remove Featured' : 'Mark Featured' ?>
                        </button>

                        <hr>

                        <a href="<?= base_url('/admin/blogs') ?>" class="btn btn-secondary">
                            <i data-lucide="arrow-left" class="me-1"></i> Back to List
                        </a>

                        <button type="button" class="btn btn-outline-danger delete-btn" 
                                data-post-id="<?= $post['id'] ?>" data-post-title="<?= esc($post['title']) ?>">
                            <i data-lucide="trash-2" class="me-1"></i> Move to Trash
                        </button>
                    </div>
                </div>
            </div>

            <!-- Post Preview -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Post Preview</h4>
                </div>
                <div class="card-body p-0">
                    <div class="ratio ratio-16x9">
                        <iframe src="<?= base_url('blog/' . $post['slug']) ?>" class="border-0"></iframe>
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
                <p>Are you sure you want to move "<span id="postTitle"></span>" to trash?</p>
                <p class="text-muted small">You can restore it later from the trash.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Move to Trash</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status toggle
    const statusToggleBtn = document.querySelector('.status-toggle-btn');
    statusToggleBtn?.addEventListener('click', function() {
        const postId = this.dataset.postId;
        
        AdminUtils.makeRequest(`/admin/blogs/toggle-status/${postId}`, 'POST')
            .then(response => {
                if (response.success) {
                    AdminUtils.showToast('Status updated successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    AdminUtils.showToast(response.message || 'Failed to update status', 'error');
                }
            })
            .catch(error => {
                AdminUtils.showToast('An error occurred', 'error');
            });
    });

    // Featured toggle
    const featuredToggleBtn = document.querySelector('.featured-toggle-btn');
    featuredToggleBtn?.addEventListener('click', function() {
        const postId = this.dataset.postId;
        
        AdminUtils.makeRequest(`/admin/blogs/toggle-featured/${postId}`, 'POST')
            .then(response => {
                if (response.success) {
                    AdminUtils.showToast('Featured status updated successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    AdminUtils.showToast(response.message || 'Failed to update featured status', 'error');
                }
            })
            .catch(error => {
                AdminUtils.showToast('An error occurred', 'error');
            });
    });

    // Delete functionality
    let deletePostId = null;
    
    const deleteBtn = document.querySelector('.delete-btn');
    deleteBtn?.addEventListener('click', function() {
        deletePostId = this.dataset.postId;
        document.getElementById('postTitle').textContent = this.dataset.postTitle;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });

    document.getElementById('confirmDelete')?.addEventListener('click', function() {
        if (deletePostId) {
            window.location.href = `/admin/blogs/delete/${deletePostId}`;
        }
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>