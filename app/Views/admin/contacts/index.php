<?php include APPPATH . 'Views/layouts/dashboard_header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Contact Messages</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Contact Messages</li>
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
                                    <i data-lucide="mail" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Total Messages</p>
                            <h4 class="mb-0"><?= number_format($stats['total']) ?></h4>
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
                                    <i data-lucide="alert-circle" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">New Messages</p>
                            <h4 class="mb-0"><?= number_format($stats['new']) ?></h4>
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
                                    <i data-lucide="reply" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">Replied</p>
                            <h4 class="mb-0"><?= number_format($stats['replied']) ?></h4>
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
                                    <i data-lucide="calendar" class="fs-20"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1">This Month</p>
                            <h4 class="mb-0"><?= number_format($stats['this_month']) ?></h4>
                        </div>
                    </div>
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
                            <h4 class="card-title mb-0">Contact Messages</h4>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('/admin/contacts/export') ?>" class="btn btn-success btn-sm">
                                <i data-lucide="download" class="me-1"></i> Export CSV
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="new" <?= ($filters['status'] === 'new') ? 'selected' : '' ?>>New</option>
                                    <option value="read" <?= ($filters['status'] === 'read') ? 'selected' : '' ?>>Read</option>
                                    <option value="replied" <?= ($filters['status'] === 'replied') ? 'selected' : '' ?>>Replied</option>
                                    <option value="closed" <?= ($filters['status'] === 'closed') ? 'selected' : '' ?>>Closed</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Search</label>
                                <input type="text" name="search" class="form-control" placeholder="Search messages..." value="<?= esc($filters['search']) ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">From Date</label>
                                <input type="date" name="date_from" class="form-control" value="<?= esc($filters['date_from']) ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">To Date</label>
                                <input type="date" name="date_to" class="form-control" value="<?= esc($filters['date_to']) ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Bulk Actions -->
                    <div class="row mb-3">
                        <div class="col">
                            <div class="btn-group">
                                <select id="bulkAction" class="form-select form-select-sm" style="width: 200px;">
                                    <option value="">Select Bulk Action</option>
                                    <option value="mark_read">Mark as Read</option>
                                    <option value="mark_replied">Mark as Replied</option>
                                    <option value="mark_closed">Mark as Closed</option>
                                    <option value="delete">Delete Selected</option>
                                </select>
                                <button type="button" id="applyBulkAction" class="btn btn-sm btn-secondary">Apply</button>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="30">
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($contacts)): ?>
                                    <?php foreach ($contacts as $contact): ?>
                                    <tr class="<?= $contact['status'] === 'new' ? 'table-warning' : '' ?>">
                                        <td>
                                            <input type="checkbox" class="form-check-input contact-checkbox" value="<?= $contact['id'] ?>">
                                        </td>
                                        <td>
                                            <strong><?= esc($contact['name']) ?></strong>
                                            <?php if ($contact['status'] === 'new'): ?>
                                                <span class="badge bg-warning ms-1">New</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="mailto:<?= esc($contact['email']) ?>" class="text-decoration-none">
                                                <?= esc($contact['email']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('/admin/contacts/show/' . $contact['id']) ?>" class="text-decoration-none">
                                                <?= esc(substr($contact['subject'], 0, 50)) ?><?= strlen($contact['subject']) > 50 ? '...' : '' ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php
                                            $statusClass = [
                                                'new' => 'bg-warning',
                                                'read' => 'bg-info',
                                                'replied' => 'bg-success',
                                                'closed' => 'bg-secondary'
                                            ];
                                            ?>
                                            <span class="badge <?= $statusClass[$contact['status']] ?? 'bg-secondary' ?>">
                                                <?= ucfirst($contact['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= date('M j, Y g:i A', strtotime($contact['created_at'])) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?= base_url('/admin/contacts/show/' . $contact['id']) ?>" 
                                                   class="btn btn-outline-primary" title="View">
                                                    <i data-lucide="eye"></i>
                                                </a>
                                                <a href="<?= base_url('/admin/contacts/delete/' . $contact['id']) ?>" 
                                                   class="btn btn-outline-danger" 
                                                   onclick="return confirm('Are you sure you want to delete this message?')" 
                                                   title="Delete">
                                                    <i data-lucide="trash-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i data-lucide="inbox" style="width: 48px; height: 48px;"></i>
                                                <p class="mt-3">No contact messages found</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if (isset($pager)): ?>
                        <div class="d-flex justify-content-center mt-4">
                            <?= $pager->links() ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    // Update selectAll state when individual checkboxes change
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.contact-checkbox:checked').length;
            const totalCount = checkboxes.length;
            
            if (selectAll) {
                selectAll.checked = checkedCount === totalCount;
                selectAll.indeterminate = checkedCount > 0 && checkedCount < totalCount;
            }
        });
    });

    // Bulk Actions
    const applyBulkActionBtn = document.getElementById('applyBulkAction');
    const bulkActionSelect = document.getElementById('bulkAction');
    
    if (applyBulkActionBtn && bulkActionSelect) {
        applyBulkActionBtn.addEventListener('click', function() {
            const action = bulkActionSelect.value;
            const checkedBoxes = document.querySelectorAll('.contact-checkbox:checked');
            const selectedIds = Array.from(checkedBoxes).map(cb => cb.value);
            
            console.log('Action:', action);
            console.log('Checked boxes found:', checkedBoxes.length);
            console.log('Selected IDs:', selectedIds);
            
            if (!action) {
                alert('Please select an action from the dropdown');
                return;
            }
            
            if (selectedIds.length === 0) {
                alert('Please select at least one message by checking the boxes');
                return;
            }
            
            let confirmMessage = `Are you sure you want to ${action.replace('_', ' ')} ${selectedIds.length} message(s)?`;
            if (action === 'delete') {
                confirmMessage = `Are you sure you want to delete ${selectedIds.length} message(s)? This action cannot be undone.`;
            }
            
            if (!confirm(confirmMessage)) {
                return;
            }
            
            // Disable button during request
            applyBulkActionBtn.disabled = true;
            applyBulkActionBtn.textContent = 'Processing...';
            
            // Send AJAX request
            const formData = new FormData();
            formData.append('action', action);
            selectedIds.forEach(id => {
                formData.append('ids[]', id);
            });
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            
            fetch('<?= base_url('/admin/contacts/bulk-action') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Unknown error occurred'));
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('An error occurred while processing the request');
            })
            .finally(() => {
                // Re-enable button
                applyBulkActionBtn.disabled = false;
                applyBulkActionBtn.textContent = 'Apply';
            });
        });
    }
});
</script>

<style>
.table tbody tr.selected {
    background-color: #e3f2fd !important;
}

.contact-checkbox:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.075);
}

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}
</style>

<?php include APPPATH . 'Views/layouts/dashboard_footer.php'; ?>