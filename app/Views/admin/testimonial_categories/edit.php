<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/testimonial-categories') ?>">Testimonial Categories</a></li>
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Category Information</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/admin/testimonial-categories/update/' . $category['id']) ?>" method="POST">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?= old('name', $category['name'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="active" <?= old('status', $category['status'] ?? 'active') == 'active' ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= old('status', $category['status'] ?? 'active') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="4" placeholder="Brief description of this testimonial category"><?= old('description', $category['description'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">
                                <strong>Created:</strong> <?= date('M j, Y g:i A', strtotime($category['created_at'] ?? 'now')) ?><br>
                                <strong>Updated:</strong> <?= date('M j, Y g:i A', strtotime($category['updated_at'] ?? 'now')) ?>
                            </small>
                        </div>

                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i data-lucide="save" class="me-1"></i> Update Category
                            </button>
                            <a href="<?= base_url('/admin/testimonial-categories') ?>" class="btn btn-secondary btn-sm">
                                <i data-lucide="arrow-left" class="me-1"></i> Back to List
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layouts/dashboard_footer') ?>