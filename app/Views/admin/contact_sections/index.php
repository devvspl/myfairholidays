<?php include APPPATH . 'Views/layouts/dashboard_header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Contact Page Sections</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Contact Sections</li>
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
                            <h4 class="card-title mb-0">Contact Page Sections</h4>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('/admin/contact-sections/create') ?>" class="btn btn-primary btn-sm">
                                <i data-lucide="plus" class="me-1"></i> Add New Section
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Sections Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Contact Info</th>
                                    <th>Sort Order</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($sections)): ?>
                                    <?php foreach ($sections as $section): ?>
                                    <tr>
                                        <td>
                                            <?php
                                            $typeLabels = [
                                                'hero' => 'Hero',
                                                'contact_info' => 'Contact Info',
                                                'form_settings' => 'Form Settings'
                                            ];
                                            $typeColors = [
                                                'hero' => 'primary',
                                                'contact_info' => 'info',
                                                'form_settings' => 'success'
                                            ];
                                            ?>
                                            <span class="badge bg-<?= $typeColors[$section['section_type']] ?? 'secondary' ?>">
                                                <?= $typeLabels[$section['section_type']] ?? ucfirst($section['section_type']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <strong><?= esc($section['title']) ?></strong>
                                            <?php if (!empty($section['subtitle'])): ?>
                                            <br><small class="text-muted"><?= esc($section['subtitle']) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($section['contact_type']) && !empty($section['contact_value'])): ?>
                                                <div class="d-flex align-items-center">
                                                    <?php if (!empty($section['icon'])): ?>
                                                        <i class="<?= esc($section['icon']) ?> me-2"></i>
                                                    <?php endif; ?>
                                                    <div>
                                                        <span class="badge bg-light text-dark"><?= ucfirst($section['contact_type']) ?></span>
                                                        <br><small><?= esc($section['contact_value']) ?></small>
                                                    </div>
                                                </div>
                                            <?php elseif (!empty($section['content'])): ?>
                                                <?= esc(substr(strip_tags($section['content']), 0, 100)) ?>...
                                            <?php elseif (!empty($section['map_embed_code'])): ?>
                                                <span class="text-muted"><i class="fas fa-map me-1"></i>Map Embedded</span>
                                            <?php else: ?>
                                                <span class="text-muted">No content</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark"><?= $section['sort_order'] ?></span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?= base_url('/admin/contact-sections/edit/' . $section['id']) ?>" 
                                                   class="btn btn-outline-primary" title="Edit">
                                                    <i data-lucide="edit"></i>
                                                </a>
                                                <a href="<?= base_url('/admin/contact-sections/delete/' . $section['id']) ?>" 
                                                   class="btn btn-outline-danger" 
                                                   onclick="return confirm('Are you sure you want to delete this section?')" 
                                                   title="Delete">
                                                    <i data-lucide="trash-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="text-muted">
                                                <i data-lucide="inbox" style="width: 48px; height: 48px;"></i>
                                                <p class="mt-3">No contact sections found</p>
                                                <a href="<?= base_url('/admin/contact-sections/create') ?>" class="btn btn-primary">
                                                    Create First Section
                                                </a>
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
    // Status toggle functionality
    document.querySelectorAll('.status-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const currentStatus = this.dataset.status;
            
            fetch(`<?= base_url('/admin/contact-sections/toggle-status/') ?>${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button
                    const newStatus = data.new_status;
                    this.dataset.status = newStatus;
                    this.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                    this.className = `btn btn-sm btn-outline-${newStatus === 'active' ? 'success' : 'secondary'} status-toggle`;
                    
                    // Show success message
                    alert('Status updated successfully');
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
            });
        });
    });
});
</script>

<?php include APPPATH . 'Views/layouts/dashboard_footer.php'; ?>