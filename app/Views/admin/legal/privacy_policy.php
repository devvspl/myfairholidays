<?php include APPPATH . 'Views/layouts/dashboard_header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Privacy Policy Management</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Privacy Policy</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">Edit Privacy Policy</h4>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('/admin/privacy-policy/preview') ?>" class="btn btn-outline-primary btn-sm me-1" target="_blank">
                                <i data-lucide="eye" class="me-1"></i>Preview
                            </a>
                            <a href="<?= base_url('/privacy-policy') ?>" class="btn btn-outline-success btn-sm" target="_blank">
                                <i data-lucide="external-link" class="me-1"></i>View Live
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i data-lucide="check-circle" class="me-2"></i><?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i data-lucide="alert-circle" class="me-2"></i><?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i data-lucide="alert-triangle" class="me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/admin/privacy-policy/update') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Page Content</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Page Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="title" name="title" 
                                                   value="<?= old('title', $policy['title'] ?? 'Privacy Policy') ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Banner Image</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="banner_image_file" class="form-label">Upload Banner Image</label>
                                                        <input type="file" class="form-control" id="banner_image_file" name="banner_image_file" accept="image/*">
                                                        <div class="form-text">Upload new banner image (JPG, PNG, WebP - Max 5MB)</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="banner_image" class="form-label">Or enter image path manually:</label>
                                                        <input type="text" class="form-control" id="banner_image" name="banner_image" 
                                                               value="<?= old('banner_image', $policy['banner_image'] ?? 'main/images/contactus.png') ?>" 
                                                               placeholder="e.g., main/images/banner.jpg">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (!empty($policy['banner_image'])): ?>
                                            <div class="current-banner">
                                                <label class="form-label">Current Banner:</label>
                                                <div class="border rounded p-2">
                                                    <img src="<?= base_url($policy['banner_image']) ?>" alt="Current banner" style="max-width: 100%; max-height: 200px;" class="img-thumbnail">
                                                    <div class="mt-1">
                                                        <small class="text-muted"><?= esc($policy['banner_image']) ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="mb-3">
                                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                            <div id="content-editor" style="min-height: 400px;"></div>
                                            <textarea id="content" name="content" style="display:none;" required><?= old('content', $policy['content'] ?? '') ?></textarea>
                                            <div class="form-text">You can use HTML tags for formatting</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- SEO Section -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">SEO Settings</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="meta_title" class="form-label">Meta Title</label>
                                            <input type="text" class="form-control" id="meta_title" name="meta_title" 
                                                   value="<?= old('meta_title', $policy['meta_title'] ?? '') ?>" maxlength="255">
                                            <div class="form-text">Leave empty to use page title</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="meta_description" class="form-label">Meta Description</label>
                                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3" maxlength="500"><?= old('meta_description', $policy['meta_description'] ?? '') ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                                                   value="<?= old('meta_keywords', $policy['meta_keywords'] ?? '') ?>" placeholder="keyword1, keyword2, keyword3">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- Publish Settings -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Publish Settings</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="active" <?= old('status', $policy['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option>
                                                <option value="inactive" <?= old('status', $policy['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                            </select>
                                        </div>

                                        <?php if (isset($policy['updated_at'])): ?>
                                        <div class="mb-0">
                                            <small class="text-muted">
                                                <i data-lucide="clock" style="width: 14px; height: 14px;"></i> Last Updated:<br>
                                                <?= date('M d, Y h:i A', strtotime($policy['updated_at'])) ?>
                                            </small>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Info Card -->
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title"><i data-lucide="info" style="width: 16px; height: 16px;"></i> Information</h6>
                                        <p class="card-text small mb-0">
                                            Only one Privacy Policy record is allowed. This form will update the existing record.
                                        </p>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i data-lucide="save" class="me-1"></i> Update Privacy Policy
                                            </button>
                                            <a href="<?= base_url('/admin/dashboard') ?>" class="btn btn-secondary">
                                                <i data-lucide="x" class="me-1"></i> Cancel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Quill Editor for rich text editing -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill Editor for content
    var quill = new Quill('#content-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'font': [] }, { 'size': [] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'script': 'super' }, { 'script': 'sub' }],
                [{ 'header': [false, 1, 2, 3, 4, 5, 6] }, 'blockquote', 'code-block'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '-1' }, { 'indent': '+1' }],
                ['direction', { 'align': [] }],
                ['link', 'image', 'video'],
                ['clean']
            ]
        }
    });

    // Set initial content from hidden textarea
    var contentTextarea = document.querySelector('#content');
    var initialContent = contentTextarea.value;
    
    if (initialContent && initialContent.trim() !== '') {
        // Set the HTML content
        quill.root.innerHTML = initialContent;
    }

    // Update hidden textarea on form submit
    var form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Get the HTML content from Quill
            var htmlContent = quill.root.innerHTML;
            
            // Update the hidden textarea
            contentTextarea.value = htmlContent;
            
            // Log for debugging
            console.log('Submitting content:', htmlContent);
        });
    }

    // Also update on any content change (optional, for auto-save features)
    quill.on('text-change', function() {
        contentTextarea.value = quill.root.innerHTML;
    });
});
</script>

<style>
.ql-container {
    min-height: 400px;
    font-size: 14px;
}
.ql-editor {
    min-height: 400px;
}
</style>

<?php include APPPATH . 'Views/layouts/dashboard_footer.php'; ?>
