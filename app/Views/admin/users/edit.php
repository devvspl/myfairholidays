<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/user-management') ?>">Users</a></li>
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

    <form action="<?= base_url('/admin/user-management/update/' . $user['id']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">User Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?= old('name', $user['name']) ?>" required>
                                    <div class="form-text">Enter the user's full name</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= old('email', $user['email']) ?>" required>
                                    <div class="form-text">Email must be unique</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <div class="form-text">Password must be at least 8 characters (leave empty to keep current)</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                </div>
                            </div>
                        </div>

                        <!-- Additional User Details -->
                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4" 
                                      placeholder="Brief description about the user"><?= old('bio', $user['bio'] ?? '') ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="<?= old('phone', $user['phone'] ?? '') ?>" placeholder="+1 (555) 123-4567">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <input type="text" class="form-control" id="department" name="department" 
                                           value="<?= old('department', $user['department'] ?? '') ?>" placeholder="e.g., Marketing, Sales">
                                </div>
                            </div>
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
                            <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" id="role_id" name="role_id" required>
                                <option value="">Select Role</option>
                                <?php if (isset($roles)): ?>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?= $role['id'] ?>" <?= old('role_id', $user['role_id']) == $role['id'] ? 'selected' : '' ?>>
                                            <?= esc(ucfirst($role['name'])) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active" <?= old('status', $user['status']) == 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= old('status', $user['status']) == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="email_verified" name="email_verified" value="1"
                                   <?= old('email_verified', $user['email_verified'] ?? 0) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="email_verified">
                                Mark Email as Verified
                            </label>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">
                                <strong>User ID:</strong> #<?= $user['id'] ?><br>
                                <strong>Current Role:</strong> 
                                <span class="badge badge-soft-info"><?= ucfirst($user['role_name'] ?? 'Unknown') ?></span><br>
                                <strong>Created:</strong> <?= date('M j, Y g:i A', strtotime($user['created_at'])) ?><br>
                                <strong>Updated:</strong> 
                                <?= isset($user['updated_at']) && $user['updated_at'] ? date('M j, Y g:i A', strtotime($user['updated_at'])) : 'Never' ?>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Profile Image -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Profile Image</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($user['profile_image']) && $user['profile_image']): ?>
                            <?php 
                            $imagePath = base_url($user['profile_image']);
                            $fullPath = FCPATH . $user['profile_image'];
                            ?>
                            <?php if (file_exists($fullPath)): ?>
                                <div class="mb-3" id="current_image">
                                    <img src="<?= $imagePath ?>" 
                                         alt="Current profile image" class="img-fluid rounded"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div style="display: none;" class="text-muted text-center">
                                        <i data-lucide="image-off"></i>
                                        <p>Image not available</p>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="remove_current_image">
                                        Remove Current Image
                                    </button>
                                </div>
                            <?php else: ?>
                                <div class="mb-3 text-muted text-center">
                                    <i data-lucide="image-off"></i>
                                    <p>Previous image not found</p>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <input type="file" class="form-control" id="profile_image" name="profile_image" 
                                   accept="image/*">
                            <div class="form-text">Recommended size: 400x400px</div>
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
                                <i data-lucide="save" class="me-1"></i> Update User
                            </button>
                            <a href="<?= base_url('/admin/user-management/show/' . $user['id']) ?>" class="btn btn-outline-info">
                                <i data-lucide="eye" class="me-1"></i> View Profile
                            </a>
                            <a href="<?= base_url('/admin/user-management') ?>" class="btn btn-secondary">
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
    // Password confirmation validation
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    
    function validatePassword() {
        if (password.value && password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords do not match');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    password.addEventListener('change', validatePassword);
    confirmPassword.addEventListener('keyup', validatePassword);

    // Image preview
    const profileImageInput = document.getElementById('profile_image');
    const imagePreview = document.getElementById('image_preview');
    const previewImg = document.getElementById('preview_img');
    const removeImageBtn = document.getElementById('remove_image');
    const currentImage = document.getElementById('current_image');
    const removeCurrent = document.getElementById('remove_current_image');
    
    profileImageInput.addEventListener('change', function() {
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
        profileImageInput.value = '';
        imagePreview.style.display = 'none';
        previewImg.src = '';
        if (currentImage) {
            currentImage.style.display = 'block';
        }
    });
    
    removeCurrent?.addEventListener('click', function() {
        if (confirm('Remove current profile image?')) {
            currentImage.style.display = 'none';
            // Add hidden input to indicate image removal
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'remove_profile_image';
            hiddenInput.value = '1';
            document.querySelector('form').appendChild(hiddenInput);
        }
    });

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const roleId = document.getElementById('role_id').value;

        if (!name) {
            e.preventDefault();
            alert('Please enter a name');
            document.getElementById('name').focus();
            return false;
        }

        if (!email) {
            e.preventDefault();
            alert('Please enter an email address');
            document.getElementById('email').focus();
            return false;
        }

        if (!roleId) {
            e.preventDefault();
            alert('Please select a role');
            document.getElementById('role_id').focus();
            return false;
        }

        // Check password confirmation if password is provided
        if (password.value && password.value !== confirmPassword.value) {
            e.preventDefault();
            alert('Passwords do not match');
            confirmPassword.focus();
            return false;
        }
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>