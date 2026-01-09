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
                        <li class="breadcrumb-item active"><?= isset($image) ? 'Edit' : 'Create' ?></li>
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
                        <h4 class="card-title mb-0"><?= isset($image) ? 'Edit Image' : 'Upload New Image' ?></h4>
                        <a href="<?= base_url('/admin/images') ?>" class="btn btn-outline-secondary">
                            <i data-lucide="arrow-left" class="me-1"></i> Back to Gallery
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" 
                          action="<?= isset($image) ? base_url('/admin/images/update/' . $image['id']) : base_url('/admin/images/store') ?>" 
                          enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Image Title <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control <?= isset($validation) && $validation->hasError('title') ? 'is-invalid' : '' ?>" 
                                           id="title" 
                                           name="title" 
                                           value="<?= old('title', $image['title'] ?? '') ?>" 
                                           required>
                                    <?php if (isset($validation) && $validation->hasError('title')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('title') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="alt_text" class="form-label">Alt Text</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="alt_text" 
                                           name="alt_text" 
                                           value="<?= old('alt_text', $image['alt_text'] ?? '') ?>" 
                                           placeholder="Descriptive text for accessibility">
                                    <div class="form-text">Provide descriptive text for screen readers and SEO.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" 
                                              id="description" 
                                              name="description" 
                                              rows="3" 
                                              placeholder="Optional description for the image"><?= old('description', $image['description'] ?? '') ?></textarea>
                                </div>

                                <?php if (!isset($image)): ?>
                                <div class="mb-3">
                                    <label for="images" class="form-label">Select Images <span class="text-danger">*</span></label>
                                    <input type="file" 
                                           class="form-control <?= session()->getFlashdata('error') ? 'is-invalid' : '' ?>" 
                                           id="images" 
                                           name="images[]" 
                                           multiple 
                                           accept="image/*" 
                                           required>
                                    <div class="form-text">You can select multiple images. Supported formats: JPG, PNG, GIF, WebP. Max size: 2MB per image.</div>
                                    <?php if (session()->getFlashdata('error')): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('error') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php else: ?>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Replace Image (Optional)</label>
                                    <input type="file" 
                                           class="form-control <?= isset($validation) && $validation->hasError('image') ? 'is-invalid' : '' ?>" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*">
                                    <div class="form-text">Leave empty to keep current image. Max size: 2MB.</div>
                                    <?php if (isset($validation) && $validation->hasError('image')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('image') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>

                                <div id="imagePreview" class="mb-3"></div>
                            </div>

                            <div class="col-md-4">
                                <?php if (isset($image) && $image['image_path']): ?>
                                <div class="mb-3">
                                    <label class="form-label">Current Image</label>
                                    <div class="border rounded p-2">
                                        <img src="<?= base_url($image['image_path']) ?>" 
                                             alt="<?= esc($image['alt_text'] ?: $image['title']) ?>" 
                                             class="img-fluid rounded">
                                    </div>
                                </div>
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select <?= isset($validation) && $validation->hasError('status') ? 'is-invalid' : '' ?>" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="">Select Status</option>
                                        <option value="active" <?= old('status', $image['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= old('status', $image['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                    <?php if (isset($validation) && $validation->hasError('status')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('status') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_homepage" 
                                               name="is_homepage" 
                                               value="1" 
                                               <?= old('is_homepage', $image['is_homepage'] ?? 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="is_homepage">
                                            Display on Homepage
                                        </label>
                                    </div>
                                    <div class="form-text">Check to display this image on the homepage gallery.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="sort_order" 
                                           name="sort_order" 
                                           value="<?= old('sort_order', $image['sort_order'] ?? 0) ?>" 
                                           min="0">
                                    <div class="form-text">Lower numbers appear first. Leave 0 for automatic ordering.</div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i data-lucide="save" class="me-1"></i>
                                        <?= isset($image) ? 'Update Image' : 'Upload Images' ?>
                                    </button>
                                    <a href="<?= base_url('/admin/images') ?>" class="btn btn-outline-secondary">
                                        <i data-lucide="x" class="me-1"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality
    const imageInput = document.getElementById('images') || document.getElementById('image');
    const previewContainer = document.getElementById('imagePreview');
    
    if (imageInput) {
        imageInput.addEventListener('change', function() {
            const files = this.files;
            previewContainer.innerHTML = '';
            
            if (files.length > 0) {
                const previewTitle = document.createElement('label');
                previewTitle.className = 'form-label';
                previewTitle.textContent = 'Preview:';
                previewContainer.appendChild(previewTitle);
                
                const previewGrid = document.createElement('div');
                previewGrid.className = 'row';
                
                for (let i = 0; i < Math.min(files.length, 6); i++) {
                    const file = files[i];
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const col = document.createElement('div');
                            col.className = 'col-md-6 col-lg-4 mb-2';
                            col.innerHTML = `
                                <div class="border rounded p-2">
                                    <img src="${e.target.result}" 
                                         class="img-fluid rounded" 
                                         style="height: 100px; width: 100%; object-fit: cover;">
                                    <small class="text-muted d-block mt-1">${file.name}</small>
                                </div>
                            `;
                            previewGrid.appendChild(col);
                        };
                        reader.readAsDataURL(file);
                    }
                }
                
                previewContainer.appendChild(previewGrid);
                
                if (files.length > 6) {
                    const moreText = document.createElement('small');
                    moreText.className = 'text-muted';
                    moreText.textContent = `... and ${files.length - 6} more image(s)`;
                    previewContainer.appendChild(moreText);
                }
            }
        });
    }
    
    // Auto-generate alt text from title
    const titleInput = document.getElementById('title');
    const altInput = document.getElementById('alt_text');
    
    if (titleInput && altInput) {
        titleInput.addEventListener('input', function() {
            if (!altInput.value) {
                altInput.value = this.value;
            }
        });
    }
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>