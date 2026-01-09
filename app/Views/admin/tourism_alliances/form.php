<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/tourism-alliances') ?>">Tourism Alliances</a></li>
                        <li class="breadcrumb-item active"><?= isset($alliance) ? 'Edit' : 'Create' ?></li>
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
                        <h4 class="card-title mb-0"><?= isset($alliance) ? 'Edit Tourism Alliance' : 'Add New Tourism Alliance' ?></h4>
                        <a href="<?= base_url('/admin/tourism-alliances') ?>" class="btn btn-outline-secondary">
                            <i data-lucide="arrow-left" class="me-1"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" 
                          action="<?= isset($alliance) ? base_url('/admin/tourism-alliances/update/' . $alliance['id']) : base_url('/admin/tourism-alliances/store') ?>" 
                          enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Alliance Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control <?= isset($validation) && $validation->hasError('name') ? 'is-invalid' : '' ?>" 
                                           id="name" 
                                           name="name" 
                                           value="<?= old('name', $alliance['name'] ?? '') ?>" 
                                           required>
                                    <?php if (isset($validation) && $validation->hasError('name')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('name') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="website_url" class="form-label">Website URL</label>
                                    <input type="url" 
                                           class="form-control <?= isset($validation) && $validation->hasError('website_url') ? 'is-invalid' : '' ?>" 
                                           id="website_url" 
                                           name="website_url" 
                                           value="<?= old('website_url', $alliance['website_url'] ?? '') ?>" 
                                           placeholder="https://example.com">
                                    <?php if (isset($validation) && $validation->hasError('website_url')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('website_url') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if (!isset($alliance)): ?>
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Logo <span class="text-danger">*</span></label>
                                    <input type="file" 
                                           class="form-control <?= isset($validation) && $validation->hasError('logo') ? 'is-invalid' : '' ?>" 
                                           id="logo" 
                                           name="logo" 
                                           accept="image/*" 
                                           required>
                                    <div class="form-text">Upload alliance logo. Supported formats: JPG, PNG, GIF. Max size: 2MB.</div>
                                    <?php if (isset($validation) && $validation->hasError('logo')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('logo') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php else: ?>
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Replace Logo (Optional)</label>
                                    <input type="file" 
                                           class="form-control <?= isset($validation) && $validation->hasError('logo') ? 'is-invalid' : '' ?>" 
                                           id="logo" 
                                           name="logo" 
                                           accept="image/*">
                                    <div class="form-text">Leave empty to keep current logo. Max size: 2MB.</div>
                                    <?php if (isset($validation) && $validation->hasError('logo')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('logo') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>

                                <div id="logoPreview" class="mb-3"></div>
                            </div>

                            <div class="col-md-4">
                                <?php if (isset($alliance) && $alliance['logo']): ?>
                                <div class="mb-3">
                                    <label class="form-label">Current Logo</label>
                                    <div class="border rounded p-2">
                                        <img src="<?= base_url($alliance['logo']) ?>" 
                                             alt="<?= esc($alliance['name']) ?>" 
                                             class="img-fluid rounded">
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_logo" name="remove_logo" value="1">
                                        <label class="form-check-label text-danger" for="remove_logo">
                                            Remove current logo
                                        </label>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label for="type" class="form-label">Alliance Type <span class="text-danger">*</span></label>
                                    <select class="form-select <?= isset($validation) && $validation->hasError('type') ? 'is-invalid' : '' ?>" 
                                            id="type" 
                                            name="type" 
                                            required>
                                        <option value="">Select Type</option>
                                        <?php foreach ($allianceTypes as $value => $label): ?>
                                            <option value="<?= $value ?>" <?= old('type', $alliance['type'] ?? '') === $value ? 'selected' : '' ?>>
                                                <?= $label ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($validation) && $validation->hasError('type')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('type') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select <?= isset($validation) && $validation->hasError('status') ? 'is-invalid' : '' ?>" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="">Select Status</option>
                                        <option value="active" <?= old('status', $alliance['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= old('status', $alliance['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
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
                                               id="is_circle_frame" 
                                               name="is_circle_frame" 
                                               value="1" 
                                               <?= old('is_circle_frame', $alliance['is_circle_frame'] ?? 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="is_circle_frame">
                                            Use Circle Frame
                                        </label>
                                    </div>
                                    <div class="form-text">Apply circular frame styling to the logo display.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="sort_order" 
                                           name="sort_order" 
                                           value="<?= old('sort_order', $alliance['sort_order'] ?? 0) ?>" 
                                           min="0">
                                    <div class="form-text">Lower numbers appear first. Leave 0 for automatic ordering.</div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i data-lucide="save" class="me-1"></i>
                                        <?= isset($alliance) ? 'Update Alliance' : 'Create Alliance' ?>
                                    </button>
                                    <a href="<?= base_url('/admin/tourism-alliances') ?>" class="btn btn-outline-secondary">
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
    // Logo preview functionality
    const logoInput = document.getElementById('logo');
    const previewContainer = document.getElementById('logoPreview');
    
    logoInput.addEventListener('change', function() {
        const file = this.files[0];
        previewContainer.innerHTML = '';
        
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewDiv = document.createElement('div');
                previewDiv.innerHTML = `
                    <label class="form-label">Preview:</label>
                    <div class="border rounded p-2">
                        <img src="${e.target.result}" 
                             class="img-fluid rounded" 
                             style="max-height: 200px;">
                        <small class="text-muted d-block mt-1">${file.name}</small>
                    </div>
                `;
                previewContainer.appendChild(previewDiv);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>