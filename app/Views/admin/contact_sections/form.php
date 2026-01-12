<?php include APPPATH . 'Views/layouts/dashboard_header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"><?= isset($section) ? 'Edit' : 'Create' ?> Contact Section</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/contact-sections') ?>">Contact Sections</a></li>
                        <li class="breadcrumb-item active"><?= isset($section) ? 'Edit' : 'Create' ?></li>
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
                            <h4 class="card-title mb-0"><?= isset($section) ? 'Edit' : 'Create' ?> Contact Section</h4>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('/admin/contact-sections') ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <?php if (session('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= isset($section) ? base_url('/admin/contact-sections/update/' . $section['id']) : base_url('/admin/contact-sections/store') ?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Section Type <span class="text-danger">*</span></label>
                                    <select name="section_type" class="form-select" required id="sectionType">
                                        <option value="">Select Section Type</option>
                                        <option value="hero" <?= (old('section_type') ?? $section['section_type'] ?? '') === 'hero' ? 'selected' : '' ?>>Hero Section</option>
                                        <option value="contact_info" <?= (old('section_type') ?? $section['section_type'] ?? '') === 'contact_info' ? 'selected' : '' ?>>Contact Info Card</option>
                                        <option value="form_settings" <?= (old('section_type') ?? $section['section_type'] ?? '') === 'form_settings' ? 'selected' : '' ?>>Form Settings</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active" <?= (old('status') ?? $section['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= (old('status') ?? $section['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" value="<?= esc(old('title') ?? $section['title'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number" name="sort_order" class="form-control" value="<?= esc(old('sort_order') ?? $section['sort_order'] ?? '') ?>" min="0">
                                    <small class="text-muted">Leave empty for auto-assignment</small>
                                </div>
                            </div>
                        </div>

                        <!-- Subtitle Field (for form_settings) -->
                        <div class="mb-3 field-group" data-types="form_settings">
                            <label class="form-label">Subtitle</label>
                            <input type="text" name="subtitle" class="form-control" value="<?= esc(old('subtitle') ?? $section['subtitle'] ?? '') ?>">
                            <small class="text-muted">Subtitle for form section</small>
                        </div>

                        <!-- Content Field (for contact_info) -->
                        <div class="mb-3 field-group" data-types="contact_info">
                            <label class="form-label">Content</label>
                            <textarea name="content" class="form-control" rows="4"><?= esc(old('content') ?? $section['content'] ?? '') ?></textarea>
                            <small class="text-muted">Additional content or description. HTML is allowed.</small>
                        </div>

                        <!-- Contact Info Fields -->
                        <div class="field-group" data-types="contact_info">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Contact Type</label>
                                        <select name="contact_type" class="form-select">
                                            <option value="">Select Contact Type</option>
                                            <option value="email" <?= (old('contact_type') ?? $section['contact_type'] ?? '') === 'email' ? 'selected' : '' ?>>Email</option>
                                            <option value="phone" <?= (old('contact_type') ?? $section['contact_type'] ?? '') === 'phone' ? 'selected' : '' ?>>Phone</option>
                                            <option value="address" <?= (old('contact_type') ?? $section['contact_type'] ?? '') === 'address' ? 'selected' : '' ?>>Address</option>
                                            <option value="website" <?= (old('contact_type') ?? $section['contact_type'] ?? '') === 'website' ? 'selected' : '' ?>>Website</option>
                                            <option value="social" <?= (old('contact_type') ?? $section['contact_type'] ?? '') === 'social' ? 'selected' : '' ?>>Social Media</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Icon</label>
                                        <input type="text" name="icon" class="form-control" value="<?= esc(old('icon') ?? $section['icon'] ?? '') ?>">
                                        <small class="text-muted">FontAwesome class (e.g., fa-solid fa-envelope)</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Contact Value</label>
                                        <input type="text" name="contact_value" class="form-control" value="<?= esc(old('contact_value') ?? $section['contact_value'] ?? '') ?>">
                                        <small class="text-muted">Email, phone number, address, etc.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Contact Link</label>
                                        <input type="text" name="contact_link" class="form-control" value="<?= esc(old('contact_link') ?? $section['contact_link'] ?? '') ?>">
                                        <small class="text-muted">mailto:, tel:, or URL link</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Background Image Field (for hero) -->
                        <div class="mb-3 field-group" data-types="hero">
                            <label class="form-label">Background Image</label>
                            <div class="mb-2">
                                <input type="file" name="background_image_file" class="form-control" accept="image/*" id="backgroundImageFile">
                                <small class="text-muted">Upload new background image (JPG, PNG, WebP - Max 5MB)</small>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Or enter image path manually:</label>
                                <input type="text" name="background_image" class="form-control" value="<?= esc(old('background_image') ?? $section['background_image'] ?? '') ?>" placeholder="e.g., main/images/contactus.png">
                            </div>
                            <?php if (!empty($section['background_image'])): ?>
                            <div class="current-image">
                                <label class="form-label">Current Background Image:</label>
                                <div class="border rounded p-2">
                                    <img src="<?= base_url($section['background_image']) ?>" alt="Current background" style="max-width: 200px; max-height: 150px;" class="img-thumbnail">
                                    <div class="mt-1">
                                        <small class="text-muted"><?= esc($section['background_image']) ?></small>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Map Embed Code Field (for form_settings) -->
                        <div class="mb-3 field-group" data-types="form_settings">
                            <label class="form-label">Map Embed Code</label>
                            <textarea name="map_embed_code" class="form-control" rows="4"><?= esc(old('map_embed_code') ?? $section['map_embed_code'] ?? '') ?></textarea>
                            <small class="text-muted">Google Maps embed URL or iframe code</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> <?= isset($section) ? 'Update' : 'Create' ?> Section
                            </button>
                            <a href="<?= base_url('/admin/contact-sections') ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sectionTypeSelect = document.getElementById('sectionType');
    const fieldGroups = document.querySelectorAll('.field-group');
    
    function toggleFields() {
        const selectedType = sectionTypeSelect.value;
        
        fieldGroups.forEach(group => {
            const types = group.dataset.types ? group.dataset.types.split(',') : [];
            
            if (types.length === 0 || types.includes(selectedType)) {
                group.style.display = 'block';
            } else {
                group.style.display = 'none';
                // Clear hidden field values
                const inputs = group.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    if (!group.style.display || group.style.display === 'none') {
                        // Don't clear on page load if field should be visible
                        if (selectedType && !types.includes(selectedType)) {
                            if (input.type !== 'file') {
                                input.value = '';
                            }
                        }
                    }
                });
            }
        });
    }
    
    // Initial toggle
    toggleFields();
    
    // Toggle on change
    sectionTypeSelect.addEventListener('change', toggleFields);

    // Image preview functionality
    function setupImagePreview(fileInputId) {
        const fileInput = document.getElementById(fileInputId);
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file type
                    if (!file.type.startsWith('image/')) {
                        alert('Please select a valid image file');
                        this.value = '';
                        return;
                    }
                    
                    // Validate file size (5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('File size must be less than 5MB');
                        this.value = '';
                        return;
                    }
                    
                    // Create preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Remove existing preview
                        const existingPreview = fileInput.parentNode.querySelector('.upload-preview');
                        if (existingPreview) {
                            existingPreview.remove();
                        }
                        
                        // Create new preview
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'upload-preview mt-2';
                        previewDiv.innerHTML = `
                            <div class="border rounded p-2 bg-light">
                                <img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 150px;" class="img-thumbnail">
                                <div class="mt-1">
                                    <small class="text-success"><i class="fas fa-check-circle me-1"></i>New image selected: ${file.name}</small>
                                    <br><small class="text-muted">Size: ${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                                </div>
                            </div>
                        `;
                        
                        fileInput.parentNode.appendChild(previewDiv);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    }
    
    // Setup image preview
    setupImagePreview('backgroundImageFile');
});
</script>

<style>
.current-image img {
    border: 2px solid #dee2e6;
    transition: all 0.3s ease;
}

.current-image img:hover {
    border-color: #007bff;
    transform: scale(1.05);
}

.upload-preview {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.form-control[type="file"] {
    border: 2px dashed #dee2e6;
    padding: 0.75rem;
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}

.form-control[type="file"]:hover {
    border-color: #007bff;
    background-color: #e3f2fd;
}

.form-control[type="file"]:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.field-group {
    transition: all 0.3s ease;
}

.field-group[style*="none"] {
    opacity: 0;
    height: 0;
    overflow: hidden;
}
</style>

<?php include APPPATH . 'Views/layouts/dashboard_footer.php'; ?>