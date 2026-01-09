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
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

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
                                <label class="form-label fw-bold">Full Name</label>
                                <p class="form-control-plaintext"><?= esc($user['name']) ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email Address</label>
                                <p class="form-control-plaintext"><?= esc($user['email']) ?></p>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($user['bio'])): ?>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Bio</label>
                            <p class="form-control-plaintext"><?= esc($user['bio']) ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <?php if (!empty($user['phone'])): ?>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Phone Number</label>
                                    <p class="form-control-plaintext"><?= esc($user['phone']) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($user['department'])): ?>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Department</label>
                                    <p class="form-control-plaintext"><?= esc($user['department']) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Profile Image -->
            <?php if (!empty($user['profile_image'])): ?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Profile Image</h4>
                    </div>
                    <div class="card-body text-center">
                        <?php 
                        $imagePath = base_url($user['profile_image']);
                        $fullPath = FCPATH . $user['profile_image'];
                        ?>
                        <?php if (file_exists($fullPath)): ?>
                            <img src="<?= $imagePath ?>" 
                                 alt="Profile image" class="img-fluid rounded"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <div style="display: none;" class="text-muted">
                                <i data-lucide="user" style="width: 100px; height: 100px;"></i>
                                <p>Image not available</p>
                            </div>
                        <?php else: ?>
                            <div class="text-muted">
                                <i data-lucide="user" style="width: 100px; height: 100px;"></i>
                                <p>Image not found</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- User Details -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">User Details</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">User ID</label>
                        <p class="form-control-plaintext">#<?= $user['id'] ?></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Role</label>
                        <p class="form-control-plaintext">
                            <span class="badge badge-soft-<?= $user['role_name'] === 'admin' ? 'danger' : ($user['role_name'] === 'manager' ? 'warning' : 'info') ?>">
                                <?= ucfirst($user['role_name'] ?? 'User') ?>
                            </span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <p class="form-control-plaintext">
                            <span class="badge badge-soft-<?= $user['status'] === 'active' ? 'success' : 'danger' ?>">
                                <?= ucfirst($user['status']) ?>
                            </span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email Verified</label>
                        <p class="form-control-plaintext">
                            <span class="badge badge-soft-<?= $user['email_verified'] ? 'success' : 'warning' ?>">
                                <?= $user['email_verified'] ? 'Verified' : 'Not Verified' ?>
                            </span>
                            <?php if ($user['email_verified'] && !empty($user['email_verified_at'])): ?>
                                <br><small class="text-muted">Verified on <?= date('M j, Y g:i A', strtotime($user['email_verified_at'])) ?></small>
                            <?php endif; ?>
                        </p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">
                            <strong>Created:</strong> <?= date('M j, Y g:i A', strtotime($user['created_at'])) ?><br>
                            <strong>Updated:</strong> 
                            <?= isset($user['updated_at']) && $user['updated_at'] ? date('M j, Y g:i A', strtotime($user['updated_at'])) : 'Never' ?><br>
                            <?php if (!empty($user['last_login_at'])): ?>
                                <strong>Last Login:</strong> <?= date('M j, Y g:i A', strtotime($user['last_login_at'])) ?>
                            <?php endif; ?>
                        </small>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('/admin/user-management/edit/' . $user['id']) ?>" class="btn btn-primary">
                            <i data-lucide="edit" class="me-1"></i> Edit User
                        </a>
                        <button type="button" class="btn btn-outline-warning toggle-status" data-id="<?= $user['id'] ?>">
                            <i data-lucide="power" class="me-1"></i> Toggle Status
                        </button>
                        <button type="button" class="btn btn-outline-secondary reset-password" data-id="<?= $user['id'] ?>">
                            <i data-lucide="key" class="me-1"></i> Reset Password
                        </button>
                        <a href="<?= base_url('/admin/user-management') ?>" class="btn btn-secondary">
                            <i data-lucide="arrow-left" class="me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get CSRF token
    const csrfToken = '<?= csrf_token() ?>';
    const csrfHash = '<?= csrf_hash() ?>';

    // Toggle status functionality
    document.querySelector('.toggle-status')?.addEventListener('click', function() {
        const userId = this.dataset.id;
        
        fetch(`<?= base_url('/admin/user-management/toggle-status/') ?>${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfHash
            },
            body: JSON.stringify({
                [csrfToken]: csrfHash
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the status');
        });
    });

    // Reset password functionality
    document.querySelector('.reset-password')?.addEventListener('click', function() {
        const userId = this.dataset.id;
        
        if (confirm('Are you sure you want to reset this user\'s password?')) {
            fetch(`<?= base_url('/admin/user-management/reset-password/') ?>${userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfHash
                },
                body: JSON.stringify({
                    [csrfToken]: csrfHash
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Password reset successfully. New password: ' + data.new_password);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while resetting the password');
            });
        }
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>