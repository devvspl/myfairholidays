<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/itinerary-categories') ?>">Categories</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('/admin/itinerary-categories/update/' . $category['id']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Category Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?= old('name', $category['name']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?= old('description', $category['description']) ?></textarea>
                        </div>

                        <!-- Content Editor -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Detailed Content</label>
                            <div id="quill-editor" style="height: 300px;"></div>
                            <textarea name="content" id="content" style="display: none;"><?= old('content', $category['content'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Settings -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active" <?= old('status', $category['status']) == 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= old('status', $category['status']) == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1"
                                   <?= old('is_featured', $category['is_featured'] ?? 0) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_featured">
                                Mark as Featured Category
                            </label>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">
                                <strong>Created:</strong> <?= date('M j, Y g:i A', strtotime($category['created_at'] ?? 'now')) ?><br>
                                <strong>Updated:</strong> <?= date('M j, Y g:i A', strtotime($category['updated_at'] ?? 'now')) ?>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Featured Image</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($category['image']) && $category['image']): ?>
                            <div class="mb-3" id="current_image">
                                <img src="<?= base_url($category['image']) ?>" 
                                     alt="Current featured image" class="img-fluid rounded">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="remove_current_image">
                                    Remove Current Image
                                </button>
                            </div>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <input type="file" class="form-control" id="featured_image" name="featured_image" 
                                   accept="image/*">
                            <div class="form-text">Recommended size: 1200x630px</div>
                        </div>
                        
                        <div id="image_preview" style="display: none;">
                            <img id="preview_img" src="" alt="Preview" class="img-fluid rounded">
                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="remove_image">
                                Remove New Image
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i data-lucide="save" class="me-1"></i> Update Category
                            </button>
                            <a href="<?= base_url('/admin/itinerary-categories') ?>" class="btn btn-secondary">
                                <i data-lucide="arrow-left" class="me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill editor
    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['link', 'image', 'video'],
                ['clean']
            ]
        }
    });

    // Set existing content
    const existingContent = document.getElementById('content').value;
    if (existingContent) {
        quill.root.innerHTML = existingContent;
    }

    // Update hidden textarea when form is submitted
    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        document.getElementById('content').value = quill.root.innerHTML;
    });

    // Image preview
    const featuredImageInput = document.getElementById('featured_image');
    const imagePreview = document.getElementById('image_preview');
    const previewImg = document.getElementById('preview_img');
    const removeImageBtn = document.getElementById('remove_image');
    const currentImage = document.getElementById('current_image');
    const removeCurrent = document.getElementById('remove_current_image');
    
    featuredImageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
                if (currentImage) {
                    currentImage.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        }
    });
    
    removeImageBtn?.addEventListener('click', function() {
        featuredImageInput.value = '';
        imagePreview.style.display = 'none';
        previewImg.src = '';
        if (currentImage) {
            currentImage.style.display = 'block';
        }
    });
    
    removeCurrent?.addEventListener('click', function() {
        if (confirm('Remove current featured image?')) {
            currentImage.style.display = 'none';
            // Add hidden input to indicate image removal
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'remove_featured_image';
            hiddenInput.value = '1';
            document.querySelector('form').appendChild(hiddenInput);
        }
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>