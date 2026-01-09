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

    <form action="<?= base_url('/admin/blogs/update/' . $post['id']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Blog Post Content</h4>
                        <?php if ($post['is_homepage']): ?>
                            <div class="alert alert-info mt-2 mb-0">
                                <i data-lucide="home" class="me-2"></i>
                                <strong>Homepage:</strong> This post is currently set as the homepage.
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Post Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?= old('title', $post['title']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">URL Slug</label>
                            <div class="input-group">
                                <span class="input-group-text"><?= base_url() ?>/</span>
                                <input type="text" class="form-control" id="slug" name="slug" 
                                       value="<?= old('slug', $post['slug']) ?>">
                            </div>
                            <div class="form-text">Leave empty to auto-generate from title</div>
                        </div>

                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea class="form-control" id="excerpt" name="excerpt" rows="3"><?= old('excerpt', $post['excerpt']) ?></textarea>
                            <div class="form-text">Brief description of the blog post content</div>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <div id="content" style="height: 300px;"></div>
                            <textarea name="content" id="content-hidden" style="display: none;" required><?= old('content', $post['content']) ?></textarea>
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
                                   value="<?= old('meta_title', $post['meta_title']) ?>" maxlength="255">
                            <div class="form-text">Leave empty to use post title</div>
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" 
                                      rows="3" maxlength="500"><?= old('meta_description', $post['meta_description']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                                   value="<?= old('meta_keywords', $post['meta_keywords']) ?>" placeholder="keyword1, keyword2, keyword3">
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
                                <option value="draft" <?= old('status', $post['status']) == 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="published" <?= old('status', $post['status']) == 'published' ? 'selected' : '' ?>>Published</option>
                            </select>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1"
                                   <?= old('is_featured', $post['is_featured']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_featured">
                                Mark as Featured Post
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="is_homepage" name="is_homepage" value="1"
                                   <?= old('is_homepage', $post['is_homepage']) ? 'checked' : '' ?> disabled>
                            <label class="form-check-label" for="is_homepage">
                                Set as Homepage (Not applicable for blog posts)
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="show_in_menu" name="show_in_menu" value="1"
                                   <?= old('show_in_menu', $post['show_in_menu']) ? 'checked' : '' ?> disabled>
                            <label class="form-check-label" for="show_in_menu">
                                Show in Navigation Menu (Not applicable for blog posts)
                            </label>
                        </div>

                        <div class="mb-3" id="menu_order_group" style="display: none;">
                            <label for="menu_order" class="form-label">Menu Order</label>
                            <input type="number" class="form-control" id="menu_order" name="menu_order" 
                                   value="<?= old('menu_order', $post['menu_order']) ?>" min="0" disabled>
                            <div class="form-text">Not applicable for blog posts</div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">
                                <strong>Created:</strong> <?= date('M j, Y g:i A', strtotime($post['created_at'])) ?><br>
                                <strong>Updated:</strong> <?= date('M j, Y g:i A', strtotime($post['updated_at'])) ?>
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
                        <?php if ($post['featured_image']): ?>
                            <div class="mb-3" id="current_image">
                                <img src="<?= base_url($post['featured_image']) ?>" 
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
                                <i data-lucide="save" class="me-1"></i> Update Blog Post
                            </button>
                            <a href="<?= base_url('/admin/blogs/show/' . $post['id']) ?>" class="btn btn-outline-info">
                                <i data-lucide="eye" class="me-1"></i> View Post
                            </a>
                            <a href="<?= base_url('/admin/blogs') ?>" class="btn btn-secondary">
                                <i data-lucide="arrow-left" class="me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from title (only if slug is empty)
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    
    titleInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.autoGenerated) {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            
            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });
    
    slugInput.addEventListener('input', function() {
        if (this.value) {
            delete this.dataset.autoGenerated;
        }
    });

    // Show/hide menu order field
    const showInMenuCheckbox = document.getElementById('show_in_menu');
    const menuOrderGroup = document.getElementById('menu_order_group');
    
    showInMenuCheckbox.addEventListener('change', function() {
        menuOrderGroup.style.display = this.checked ? 'block' : 'none';
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

    // Initialize rich text editor if available
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#content',
            height: 400,
            plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }'
        });
    }
});
</script>

<!-- Quill Editor CSS & JS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
// Initialize Quill Snow Editor for blog content
var quill = new Quill('#content', {
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

// Update hidden textarea when Quill content changes
quill.on('text-change', function() {
    document.querySelector('#content-hidden').value = quill.root.innerHTML;
});

// Set initial content if editing
document.addEventListener('DOMContentLoaded', function() {
    var initialContent = document.querySelector('#content-hidden').value;
    if (initialContent) {
        quill.root.innerHTML = initialContent;
    }
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>