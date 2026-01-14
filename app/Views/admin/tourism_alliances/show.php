<?php include APPPATH . 'Views/layouts/dashboard_header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tourism Alliance Details</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/tourism-alliances') ?>">Tourism Alliances</a></li>
                        <li class="breadcrumb-item active">View Details</li>
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
                            <h4 class="card-title mb-0">Tourism Alliance Information</h4>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group">
                                <a href="<?= base_url('/admin/tourism-alliances/edit/' . $alliance['id']) ?>" class="btn btn-primary btn-sm">
                                    <i data-lucide="edit" class="me-1"></i> Edit
                                </a>
                                <a href="<?= base_url('/admin/tourism-alliances') ?>" class="btn btn-secondary btn-sm">
                                    <i data-lucide="arrow-left" class="me-1"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Name:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <?= esc($alliance['name']) ?>
                                </div>
                            </div>

                            <?php if (!empty($alliance['description'])): ?>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Description:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <?= nl2br(esc($alliance['description'])) ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($alliance['website'])): ?>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Website:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <a href="<?= esc($alliance['website']) ?>" target="_blank" class="text-primary">
                                        <?= esc($alliance['website']) ?>
                                        <i data-lucide="external-link" class="ms-1" style="width: 14px; height: 14px;"></i>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($alliance['contact_email'])): ?>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Contact Email:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <a href="mailto:<?= esc($alliance['contact_email']) ?>" class="text-primary">
                                        <?= esc($alliance['contact_email']) ?>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($alliance['contact_phone'])): ?>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Contact Phone:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <a href="tel:<?= esc($alliance['contact_phone']) ?>" class="text-primary">
                                        <?= esc($alliance['contact_phone']) ?>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Sort Order:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <span class="badge bg-light text-dark"><?= $alliance['sort_order'] ?></span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Status:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <span class="badge bg-<?= $alliance['status'] === 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($alliance['status']) ?>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Created:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <?= date('M d, Y \a\t g:i A', strtotime($alliance['created_at'])) ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Last Updated:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <?= date('M d, Y \a\t g:i A', strtotime($alliance['updated_at'])) ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <?php if (!empty($alliance['logo_path'])): ?>
                            <div class="text-center">
                                <h6 class="mb-3">Logo</h6>
                                <div class="border rounded p-3 bg-light">
                                    <img src="<?= base_url($alliance['logo_path']) ?>" 
                                         alt="<?= esc($alliance['name']) ?> Logo" 
                                         class="img-fluid rounded"
                                         style="max-height: 200px;">
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="text-center">
                                <h6 class="mb-3">Logo</h6>
                                <div class="border rounded p-3 bg-light text-muted">
                                    <i data-lucide="image" style="width: 48px; height: 48px;"></i>
                                    <p class="mt-2 mb-0">No logo uploaded</p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include APPPATH . 'Views/layouts/dashboard_footer.php'; ?>