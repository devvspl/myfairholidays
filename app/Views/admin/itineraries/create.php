<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/itineraries') ?>">Itineraries</a></li>
                        <li class="breadcrumb-item active">Create</li>
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

    <form action="<?= base_url('/admin/itineraries/store') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Itinerary Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Itinerary Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?= old('title') ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required><?= old('description') ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <textarea class="form-control" id="short_description" name="short_description" rows="4" 
                                              placeholder="Brief summary for listings"><?= old('short_description') ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Content Editor -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Detailed Content</label>
                            <div id="quill-editor" style="height: 300px;"></div>
                            <textarea name="content" id="content" style="display: none;"><?= old('content') ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="duration_days" class="form-label">Duration (Days) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="duration_days" name="duration_days" 
                                           value="<?= old('duration_days') ?>" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="duration_nights" class="form-label">Duration (Nights) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="duration_nights" name="duration_nights" 
                                           value="<?= old('duration_nights') ?>" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price (₹) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price" 
                                           value="<?= old('price') ?>" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="discounted_price" class="form-label">Discounted Price (₹)</label>
                                    <input type="number" step="0.01" class="form-control" id="discounted_price" name="discounted_price" 
                                           value="<?= old('discounted_price') ?>" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="inclusions" class="form-label">What's Included</label>
                            <textarea class="form-control" id="inclusions" name="inclusions" rows="3" 
                                      placeholder="e.g., Accommodation, Meals, Transportation, Guide"><?= old('inclusions') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="exclusions" class="form-label">What's Excluded</label>
                            <textarea class="form-control" id="exclusions" name="exclusions" rows="3" 
                                      placeholder="e.g., Personal expenses, Travel insurance, Tips"><?= old('exclusions') ?></textarea>
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
                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>>
                                        <?= esc($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="destination_id" class="form-label">Destination <span class="text-danger">*</span></label>
                            <select class="form-select" id="destination_id" name="destination_id" required>
                                <option value="">Select Destination</option>
                                <?php foreach ($destinations as $destination): ?>
                                    <option value="<?= $destination['id'] ?>" <?= old('destination_id') == $destination['id'] ? 'selected' : '' ?>>
                                        <?= esc($destination['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="draft" <?= old('status') == 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="published" <?= old('status') == 'published' ? 'selected' : '' ?>>Published</option>
                            </select>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1"
                                   <?= old('is_featured') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_featured">
                                Mark as Featured Itinerary
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Featured Image</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="file" class="form-control" id="featured_image" name="featured_image" 
                                   accept="image/*">
                            <div class="form-text">Recommended size: 1200x630px</div>
                        </div>
                        
                        <div id="image_preview" style="display: none;">
                            <img id="preview_img" src="" alt="Preview" class="img-fluid rounded">
                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="remove_image">
                                Remove Image
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i data-lucide="save" class="me-1"></i> Create Itinerary
                            </button>
                            <a href="<?= base_url('/admin/itineraries') ?>" class="btn btn-secondary">
                                <i data-lucide="x" class="me-1"></i> Cancel
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
    
    featuredImageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
    
    removeImageBtn.addEventListener('click', function() {
        featuredImageInput.value = '';
        imagePreview.style.display = 'none';
        previewImg.src = '';
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>