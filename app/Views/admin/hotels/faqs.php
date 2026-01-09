<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/hotels') ?>">Hotels</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/hotels/edit/' . $hotel['id']) ?>">Edit Hotel</a></li>
                        <li class="breadcrumb-item active">Manage FAQs</li>
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
        <div class="col-lg-8">
            <!-- Existing FAQs -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Hotel FAQs</h4>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                        <i data-lucide="plus" class="me-1"></i> Add FAQ
                    </button>
                </div>
                <div class="card-body">
                    <?php if (!empty($faqs)): ?>
                        <div id="faq-list" class="sortable-list">
                            <?php foreach ($faqs as $faq): ?>
                            <div class="faq-item card mb-3" data-faq-id="<?= $faq['id'] ?>">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <i data-lucide="grip-vertical" class="text-muted me-2 drag-handle" style="cursor: move;"></i>
                                                <h6 class="mb-0"><?= esc($faq['question']) ?></h6>
                                                <?php if (!$faq['is_active']): ?>
                                                    <span class="badge bg-secondary ms-2">Inactive</span>
                                                <?php endif; ?>
                                            </div>
                                            <p class="text-muted mb-0"><?= esc(substr($faq['answer'], 0, 150)) ?><?= strlen($faq['answer']) > 150 ? '...' : '' ?></p>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-primary edit-faq-btn" 
                                                    data-faq-id="<?= $faq['id'] ?>"
                                                    data-question="<?= esc($faq['question']) ?>"
                                                    data-answer="<?= esc($faq['answer']) ?>"
                                                    data-sort-order="<?= $faq['sort_order'] ?>"
                                                    data-is-active="<?= $faq['is_active'] ?>">
                                                <i data-lucide="edit" style="width: 14px; height: 14px;"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-faq-btn" 
                                                    data-faq-id="<?= $faq['id'] ?>">
                                                <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i data-lucide="help-circle" class="text-muted mb-3" style="width: 48px; height: 48px;"></i>
                            <h5 class="text-muted">No FAQs Added Yet</h5>
                            <p class="text-muted">Add your first FAQ to help customers understand your hotel better.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                                <i data-lucide="plus" class="me-1"></i> Add First FAQ
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Hotel Info -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Hotel Information</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <?php if (!empty($hotel['featured_image'])): ?>
                            <img src="<?= base_url($hotel['featured_image']) ?>" alt="<?= esc($hotel['name']) ?>" 
                                 class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <?php endif; ?>
                        <div>
                            <h6 class="mb-1"><?= esc($hotel['name']) ?></h6>
                            <p class="text-muted mb-0"><?= $hotel['star_rating'] ?> Star Hotel</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Status:</small>
                        <span class="badge bg-<?= $hotel['status'] === 'active' ? 'success' : 'secondary' ?>"><?= ucfirst($hotel['status']) ?></span>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('/admin/hotels/edit/' . $hotel['id']) ?>" class="btn btn-outline-primary btn-sm">
                            <i data-lucide="edit" class="me-1"></i> Edit Hotel
                        </a>
                        <a href="<?= base_url('/hotels/' . $hotel['slug']) ?>" target="_blank" class="btn btn-outline-info btn-sm">
                            <i data-lucide="external-link" class="me-1"></i> View Public Page
                        </a>
                    </div>
                </div>
            </div>

            <!-- FAQ Tips -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">FAQ Tips</h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i data-lucide="check" class="text-success me-2" style="width: 16px; height: 16px;"></i> Keep questions clear and specific</li>
                        <li class="mb-2"><i data-lucide="check" class="text-success me-2" style="width: 16px; height: 16px;"></i> Provide detailed, helpful answers</li>
                        <li class="mb-2"><i data-lucide="check" class="text-success me-2" style="width: 16px; height: 16px;"></i> Order FAQs by importance</li>
                        <li class="mb-2"><i data-lucide="check" class="text-success me-2" style="width: 16px; height: 16px;"></i> Update regularly based on guest questions</li>
                        <li><i data-lucide="check" class="text-success me-2" style="width: 16px; height: 16px;"></i> Use drag & drop to reorder</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add FAQ Modal -->
<div class="modal fade" id="addFaqModal" tabindex="-1" aria-labelledby="addFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('/admin/hotels/faqs/' . $hotel['id'] . '/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="addFaqModalLabel">Add New FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="question" name="question" required maxlength="500">
                    </div>
                    <div class="mb-3">
                        <label for="answer" class="form-label">Answer <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="answer" name="answer" rows="4" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" value="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check mt-4">
                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit FAQ Modal -->
<div class="modal fade" id="editFaqModal" tabindex="-1" aria-labelledby="editFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editFaqForm" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="editFaqModalLabel">Edit FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_question" class="form-label">Question <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_question" name="question" required maxlength="500">
                    </div>
                    <div class="mb-3">
                        <label for="edit_answer" class="form-label">Answer <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_answer" name="answer" rows="4" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_sort_order" class="form-label">Sort Order</label>
                                <input type="number" class="form-control" id="edit_sort_order" name="sort_order" value="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check mt-4">
                                    <input type="checkbox" class="form-check-input" id="edit_is_active" name="is_active" value="1">
                                    <label class="form-check-label" for="edit_is_active">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit FAQ functionality
    document.querySelectorAll('.edit-faq-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const faqId = this.dataset.faqId;
            const question = this.dataset.question;
            const answer = this.dataset.answer;
            const sortOrder = this.dataset.sortOrder;
            const isActive = this.dataset.isActive === '1';
            
            // Set form action
            document.getElementById('editFaqForm').action = `/admin/hotels/faqs/<?= $hotel['id'] ?>/update/${faqId}`;
            
            // Fill form fields
            document.getElementById('edit_question').value = question;
            document.getElementById('edit_answer').value = answer;
            document.getElementById('edit_sort_order').value = sortOrder;
            document.getElementById('edit_is_active').checked = isActive;
            
            // Show modal
            new bootstrap.Modal(document.getElementById('editFaqModal')).show();
        });
    });

    // Delete FAQ functionality
    document.querySelectorAll('.delete-faq-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const faqId = this.dataset.faqId;
            const faqItem = this.closest('.faq-item');
            
            if (confirm('Are you sure you want to delete this FAQ?')) {
                fetch(`/admin/hotels/faqs/<?= $hotel['id'] ?>/delete/${faqId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        faqItem.remove();
                        showAlert('success', data.message);
                    } else {
                        showAlert('error', data.message);
                    }
                })
                .catch(error => {
                    showAlert('error', 'Failed to delete FAQ');
                });
            }
        });
    });

    // Simple alert function
    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const container = document.querySelector('.container-fluid');
        container.insertBefore(alertDiv, container.firstChild.nextSibling);
        
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>