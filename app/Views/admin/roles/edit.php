<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/roles') ?>">Roles</a></li>
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Role Information</h4>
                    <?php if (in_array($role['name'], ['admin', 'manager', 'user'])): ?>
                        <div class="alert alert-warning mt-2 mb-0">
                            <i data-lucide="alert-triangle" class="me-2"></i>
                            <strong>System Role:</strong> This is a system role. Some restrictions may apply.
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/admin/roles/update/' . $role['id']) ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?= old('name', $role['name']) ?>" required>
                                    <div class="form-text">Role name will be converted to lowercase</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="active" <?= old('status', $role['status']) == 'active' ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= old('status', $role['status']) == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?= old('description', $role['description']) ?></textarea>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">Permissions</h5>
                            <div class="alert alert-info">
                                <i data-lucide="info" class="me-2"></i>
                                Select the permissions that users with this role should have.
                            </div>

                            <?php 
                            $currentPermissions = is_array($role['permissions'] ?? []) ? $role['permissions'] : [];
                            ?>

                            <div class="row">
                                <?php foreach ($availablePermissions as $category => $permissions): ?>
                                    <div class="col-md-6 mb-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    <input type="checkbox" class="form-check-input me-2 category-checkbox" 
                                                           data-category="<?= $category ?>">
                                                    <?= ucfirst($category) ?> Management
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <?php foreach ($permissions as $permission): ?>
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" class="form-check-input permission-checkbox" 
                                                               name="permissions[]" value="<?= $permission['id'] ?>" 
                                                               id="perm_<?= $permission['id'] ?>" data-category="<?= $category ?>"
                                                               <?= in_array($permission['id'], $currentPermissions) ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="perm_<?= $permission['id'] ?>">
                                                            <?= esc($permission['display_name']) ?>
                                                            <?php if (!empty($permission['description'])): ?>
                                                                <small class="text-muted d-block"><?= esc($permission['description']) ?></small>
                                                            <?php endif; ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= base_url('/admin/roles') ?>" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize category checkboxes based on current permissions
    document.querySelectorAll('.category-checkbox').forEach(categoryCheckbox => {
        updateCategoryCheckbox(categoryCheckbox.dataset.category);
    });

    // Category checkbox functionality
    document.querySelectorAll('.category-checkbox').forEach(categoryCheckbox => {
        categoryCheckbox.addEventListener('change', function() {
            const category = this.dataset.category;
            const permissionCheckboxes = document.querySelectorAll(`input[data-category="${category}"].permission-checkbox`);
            
            permissionCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    });

    // Update category checkbox when individual permissions change
    document.querySelectorAll('.permission-checkbox').forEach(permissionCheckbox => {
        permissionCheckbox.addEventListener('change', function() {
            updateCategoryCheckbox(this.dataset.category);
        });
    });

    function updateCategoryCheckbox(category) {
        const categoryCheckbox = document.querySelector(`input[data-category="${category}"].category-checkbox`);
        const permissionCheckboxes = document.querySelectorAll(`input[data-category="${category}"].permission-checkbox`);
        
        const checkedCount = Array.from(permissionCheckboxes).filter(cb => cb.checked).length;
        const totalCount = permissionCheckboxes.length;
        
        if (checkedCount === 0) {
            categoryCheckbox.checked = false;
            categoryCheckbox.indeterminate = false;
        } else if (checkedCount === totalCount) {
            categoryCheckbox.checked = true;
            categoryCheckbox.indeterminate = false;
        } else {
            categoryCheckbox.checked = false;
            categoryCheckbox.indeterminate = true;
        }
    }
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>