<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/tourism-alliances') ?>">Tourism Alliances</a></li>
                        <li class="breadcrumb-item active">Trash</li>
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
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Trashed Tourism Alliances</h4>
                        <div class="btn-group" role="group" aria-label="Alliance actions">
                            <a href="<?= base_url('/admin/tourism-alliances') ?>" class="btn btn-sm btn-outline-primary">
                                <i data-lucide="arrow-left" class="me-1"></i>
                                Back to Alliances
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($alliances)): ?>
                        <div class="alert alert-info">
                            <i data-lucide="info" class="me-2"></i>
                            These alliances have been moved to trash. You can restore them or permanently delete them.
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="80">Logo</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Deleted Date</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($alliances as $alliance): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($alliance['logo'])): ?>
                                                    <img src="<?= base_url($alliance['logo']) ?>" 
                                                         alt="<?= esc($alliance['name']) ?>" 
                                                         class="img-thumbnail" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <i data-lucide="image" class="text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?= esc($alliance['name']) ?></strong>
                                                    <?php if (!empty($alliance['website_url'])): ?>
                                                        <br><small class="text-muted"><?= esc($alliance['website_url']) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?= ucwords(str_replace('_', ' ', $alliance['type'])) ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $alliance['status'] === 'active' ? 'success' : 'secondary' ?>">
                                                    <?= ucfirst($alliance['status']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('M d, Y H:i', strtotime($alliance['deleted_at'])) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('/admin/tourism-alliances/restore/' . $alliance['id']) ?>" 
                                                       class="btn btn-sm btn-outline-success" 
                                                       title="Restore"
                                                       onclick="return confirm('Are you sure you want to restore this alliance?')">
                                                        <i data-lucide="rotate-ccw"></i>
                                                    </a>
                                                    <a href="<?= base_url('/admin/tourism-alliances/force-delete/' . $alliance['id']) ?>" 
                                                       class="btn btn-sm btn-outline-danger" 
                                                       title="Permanently Delete"
                                                       onclick="return confirm('Are you sure you want to permanently delete this alliance? This action cannot be undone!')">
                                                        <i data-lucide="trash-2"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i data-lucide="trash-2" class="icon-xxl text-muted mb-3"></i>
                            <h5>No Trashed Alliances</h5>
                            <p class="text-muted">There are no tourism alliances in the trash.</p>
                            <a href="<?= base_url('/admin/tourism-alliances') ?>" class="btn btn-primary">
                                <i data-lucide="arrow-left" class="me-1"></i> Back to Alliances
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layouts/dashboard_footer') ?>