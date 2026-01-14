<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Roles</li>
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
                    <h4 class="card-title mb-0">Roles & Permissions</h4>
                    <a href="<?= base_url('/admin/roles/create') ?>" class="btn btn-primary btn-sm">
                        <i data-lucide="plus"></i> Add New Role
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Role Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($roles)): ?>
                                    <?php foreach ($roles as $role): ?>
                                        <tr>
                                            <td><?= $role['id'] ?></td>
                                            <td>
                                                <strong><?= esc(ucfirst($role['name'])) ?></strong>
                                                <?php if (in_array($role['name'], ['admin', 'manager', 'user'])): ?>
                                                
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($role['description'] ?? 'No description') ?></td>
                                            <td>
                                                <span class="badge badge-soft-<?= ($role['status'] ?? 'active') === 'active' ? 'success' : 'danger' ?>">
                                                    <?= ucfirst($role['status'] ?? 'active') ?>
                                                </span>
                                            </td>
                                            <td><?= date('M d, Y', strtotime($role['created_at'])) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('/admin/roles/edit/' . $role['id']) ?>" 
                                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i data-lucide="edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-warning toggle-status" 
                                                            data-id="<?= $role['id'] ?>" title="Toggle Status">
                                                        <i data-lucide="power"></i>
                                                    </button>
                                                    <?php if (!in_array($role['name'], ['admin', 'manager', 'user'])): ?>
                                                        <a href="<?= base_url('/admin/roles/delete/' . $role['id']) ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           onclick="return confirm('Are you sure you want to delete this role?')" title="Delete">
                                                            <i data-lucide="trash-2"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No roles found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
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
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function() {
            const roleId = this.dataset.id;
            
            fetch(`<?= base_url('/admin/roles/toggle-status/') ?>${roleId}`, {
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
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>