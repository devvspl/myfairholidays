<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">User Management</li>
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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Users List</h4>
                    <div class="btn-group">
                        <a href="<?= base_url('/admin/user-management/export') ?>" class="btn btn-outline-success btn-sm">
                            <i data-lucide="download" class="me-1"></i> Export
                        </a>
                        <a href="<?= base_url('/admin/user-management/create') ?>" class="btn btn-primary btn-sm">
                            <i data-lucide="plus" class="me-1"></i> Add New User
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="bulkActionForm" method="POST" action="<?= base_url('/admin/user-management/bulk-action') ?>">
                        <?= csrf_field() ?>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <select name="action" class="form-select" style="width: auto;">
                                        <option value="">Bulk Actions</option>
                                        <option value="activate">Activate</option>
                                        <option value="deactivate">Deactivate</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                    <button type="submit" class="btn btn-outline-primary">Apply</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($users)): ?>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="user_ids[]" value="<?= $user['id'] ?>" class="form-check-input user-checkbox">
                                                </td>
                                                <td><?= $user['id'] ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <strong><?= esc($user['name']) ?></strong>
                                                    </div>
                                                </td>
                                                <td><?= esc($user['email']) ?></td>
                                                <td>
                                                    <span class="badge badge-soft-<?= $user['role_name'] === 'admin' ? 'danger' : ($user['role_name'] === 'manager' ? 'warning' : 'info') ?>">
                                                        <?= ucfirst($user['role_name'] ?? 'User') ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-soft-<?= $user['status'] === 'active' ? 'success' : 'danger' ?>">
                                                        <?= ucfirst($user['status']) ?>
                                                    </span>
                                                </td>
                                                <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="<?= base_url('/admin/user-management/show/' . $user['id']) ?>" 
                                                           class="btn btn-sm btn-outline-info" title="View">
                                                            <i data-lucide="eye"></i>
                                                        </a>
                                                        <a href="<?= base_url('/admin/user-management/edit/' . $user['id']) ?>" 
                                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                                            <i data-lucide="edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-warning toggle-status" 
                                                                data-id="<?= $user['id'] ?>" title="Toggle Status">
                                                            <i data-lucide="power"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary reset-password" 
                                                                data-id="<?= $user['id'] ?>" title="Reset Password">
                                                            <i data-lucide="key"></i>
                                                        </button>
                                                        <a href="<?= base_url('/admin/user-management/delete/' . $user['id']) ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           onclick="return confirm('Are you sure you want to delete this user?')" title="Delete">
                                                            <i data-lucide="trash-2"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">No users found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox functionality
    // Get CSRF token
    const csrfToken = '<?= csrf_token() ?>';
    const csrfHash = '<?= csrf_hash() ?>';

    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Toggle status functionality
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function() {
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
    });

    // Reset password functionality
    document.querySelectorAll('.reset-password').forEach(button => {
        button.addEventListener('click', function() {
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

    // Bulk action form validation
    document.getElementById('bulkActionForm').addEventListener('submit', function(e) {
        const selectedUsers = document.querySelectorAll('.user-checkbox:checked');
        const action = document.querySelector('select[name="action"]').value;
        
        if (selectedUsers.length === 0) {
            e.preventDefault();
            alert('Please select at least one user');
            return;
        }
        
        if (!action) {
            e.preventDefault();
            alert('Please select an action');
            return;
        }
        
        if (!confirm(`Are you sure you want to ${action} ${selectedUsers.length} user(s)?`)) {
            e.preventDefault();
        }
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>