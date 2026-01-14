<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Destination Types</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-1">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-primary-subtle text-primary rounded">
                                    <i data-lucide="map" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Total Types</p>
                            <h4 class="mb-0"><?= $stats['total'] ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-success-subtle text-success rounded">
                                    <i data-lucide="check-circle" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Active</p>
                            <h4 class="mb-0"><?= $stats['active'] ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-warning-subtle text-warning rounded">
                                    <i data-lucide="pause-circle" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Inactive</p>
                            <h4 class="mb-0"><?= $stats['inactive'] ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-info-subtle text-info rounded">
                                    <i data-lucide="map-pin" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">With Destinations</p>
                            <h4 class="mb-0"><?= $stats['with_destinations'] ?></h4>
                        </div>
                    </div>
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
                        <h4 class="card-title mb-0">Destination Types</h4>
                        <a href="<?= base_url('/admin/destination-types/create') ?>" class="btn btn-primary btn-sm">
                            <i data-lucide="plus" class="me-1"></i> Add New Type
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($types)): ?>
                        <form id="bulkActionForm" method="POST" action="<?= base_url('/admin/destination-types/bulk-action') ?>">
                            <?= csrf_field() ?>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                <div class="btn-group">
                                        <select name="bulk_action" class="form-select form-select-sm" style="width: auto;" id="bulkAction">
                                            <option value="">Bulk Actions</option>
                                            <option value="activate">Activate</option>
                                            <option value="deactivate">Deactivate</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-secondary" id="applyBulkAction">Apply</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-end">
                                        <input type="text" class="form-control form-control-sm" placeholder="Search destination types..." style="width: 250px;" id="searchInput">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="sortable-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="30">
                                                <input type="checkbox" class="form-check-input" id="selectAll">
                                            </th>
                                            <th width="50">Order</th>
                                            <th>Name</th>
                                            <th>Icon</th>
                                            <th>Destinations</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th width="200">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortable-body">
                                        <?php foreach ($types as $type): ?>
                                            <tr data-id="<?= $type['id'] ?>">
                                                <td>
                                                    <input type="checkbox" class="form-check-input type-checkbox" 
                                                           name="type_ids[]" value="<?= $type['id'] ?>">
                                                </td>
                                                <td class="text-center">
                                                    <i data-lucide="grip-vertical" class="text-muted sort-handle" style="cursor: move;"></i>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php if ($type['image']): ?>
                                                            <img src="<?= base_url($type['image']) ?>" 
                                                                 alt="<?= esc($type['name']) ?>" 
                                                                 class="me-2 rounded" width="32" height="32">
                                                        <?php elseif ($type['color']): ?>
                                                            <div class="me-2" style="width: 20px; height: 20px; background-color: <?= esc($type['color']) ?>; border-radius: 3px;"></div>
                                                        <?php endif; ?>
                                                        <div>
                                                            <strong><?= esc($type['name']) ?></strong>
                                                            <?php if (!empty($type['description'])): ?>
                                                                <br><small class="text-muted"><?= esc(substr($type['description'], 0, 60)) ?>...</small>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if ($type['icon']): ?>
                                                        <i class="<?= esc($type['icon']) ?>" style="font-size: 1.2em;"></i>
                                                    <?php else: ?>
                                                        <span class="text-muted">No icon</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?= $type['destination_count'] ?> destinations</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $type['status'] === 'active' ? 'success' : 'secondary' ?> status-badge" 
                                                          data-type-id="<?= $type['id'] ?>" 
                                                          data-current-status="<?= $type['status'] ?>" 
                                                          style="cursor: pointer;" title="Click to toggle status">
                                                        <?= ucfirst($type['status']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?= date('M j, Y', strtotime($type['created_at'] ?? 'now')) ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="<?= base_url('/admin/destination-types/edit/' . $type['id']) ?>" 
                                                           class="btn btn-outline-primary" title="Edit">
                                                            <i data-lucide="edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-outline-danger delete-btn" 
                                                                data-type-id="<?= $type['id'] ?>" 
                                                                data-type-name="<?= esc($type['name']) ?>" title="Delete">
                                                            <i data-lucide="trash-2"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        
                        <!-- Pagination -->
                        <?php if ($pager): ?>
                            <div class="d-flex justify-content-center mt-3">
                                <?= $pager->links() ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i data-lucide="map" class="text-muted" style="width: 48px; height: 48px;"></i>
                            <h5 class="mt-3 text-muted">No destination types found</h5>
                            <p class="text-muted">Create your first destination type to get started.</p>
                            <a href="<?= base_url('/admin/destination-types/create') ?>" class="btn btn-primary">
                                <i data-lucide="plus" class="me-1"></i> Create Type
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete "<span id="typeName"></span>"?</p>
                <p class="text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let deleteTypeId = null;

    // Select all functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const typeCheckboxes = document.querySelectorAll('.type-checkbox');
    
    selectAllCheckbox?.addEventListener('change', function() {
        typeCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const typeName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            
            if (typeName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Status badge click to toggle status
    document.querySelectorAll('.status-badge').forEach(badge => {
        badge.addEventListener('click', function() {
            const typeId = this.dataset.typeId;
            
            fetch(`/admin/destination-types/toggle-status/${typeId}`, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                    this.className = `badge bg-${data.status === 'active' ? 'success' : 'secondary'} status-badge`;
                    this.dataset.currentStatus = data.status;
                } else {
                    alert('Failed to update status');
                }
            });
        });
    });

    // Sortable functionality
    const sortableBody = document.getElementById('sortable-body');
    if (sortableBody) {
        new Sortable(sortableBody, {
            handle: '.sort-handle',
            animation: 150,
            onEnd: function(evt) {
                const sortData = {};
                const rows = sortableBody.querySelectorAll('tr[data-id]');
                rows.forEach((row, index) => {
                    sortData[row.dataset.id] = index + 1;
                });

                // Send AJAX request to update sort order
                fetch('/admin/destination-types/update-sort-order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ sort_data: sortData })
                });
            }
        });
    }

    // Delete functionality
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            deleteTypeId = this.dataset.typeId;
            document.getElementById('typeName').textContent = this.dataset.typeName;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });

    document.getElementById('confirmDelete')?.addEventListener('click', function() {
        if (deleteTypeId) {
            window.location.href = `/admin/destination-types/delete/${deleteTypeId}`;
        }
    });

    // Bulk action form validation
    document.getElementById('bulkActionForm')?.addEventListener('submit', function(e) {
        const selectedTypes = document.querySelectorAll('.type-checkbox:checked');
        const bulkAction = document.querySelector('select[name="bulk_action"]').value;
        
        if (selectedTypes.length === 0) {
            e.preventDefault();
            alert('Please select at least one destination type');
            return;
        }
        
        if (!bulkAction) {
            e.preventDefault();
            alert('Please select an action');
            return;
        }
        
        if (!confirm(`Apply "${bulkAction}" to ${selectedTypes.length} selected destination type(s)?`)) {
            e.preventDefault();
        }
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>