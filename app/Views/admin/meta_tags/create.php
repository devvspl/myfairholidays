<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/meta-tags') ?>">SEO Meta Tags</a></li>
                        <li class="breadcrumb-item active">Create Meta Tag</li>
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
                    <h4 class="card-title mb-0">Create SEO Meta Tag</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/admin/meta-tags/store') ?>" method="post" id="metaTagForm">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="page_url" class="form-label">Page URL <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><?= base_url() ?>/</span>
                                        <input type="text" class="form-control" id="page_url" name="page_url" 
                                               value="<?= old('page_url') ?>" required placeholder="about-us">
                                    </div>
                                    <small class="text-muted">Enter the page URL path (without domain)</small>
                                </div>

                                <div class="mb-3">
                                    <label for="title" class="form-label">Meta Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?= old('title') ?>" required maxlength="60">
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">Optimal length: 50-60 characters</small>
                                        <small id="titleCounter" class="text-muted">0/60</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Meta Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="3" 
                                              required maxlength="160"><?= old('description') ?></textarea>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">Optimal length: 150-160 characters</small>
                                        <small id="descriptionCounter" class="text-muted">0/160</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="keywords" class="form-label">Meta Keywords</label>
                                    <input type="text" class="form-control" id="keywords" name="keywords" 
                                           value="<?= old('keywords') ?>" placeholder="travel, tourism, booking">
                                    <small class="text-muted">Comma-separated keywords (optional, less important for modern SEO)</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="og_title" class="form-label">Open Graph Title</label>
                                            <input type="text" class="form-control" id="og_title" name="og_title" 
                                                   value="<?= old('og_title') ?>" maxlength="95">
                                            <small class="text-muted">Title for social media sharing</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="og_type" class="form-label">Open Graph Type</label>
                                            <select class="form-select" id="og_type" name="og_type">
                                                <option value="website" <?= old('og_type', 'website') === 'website' ? 'selected' : '' ?>>Website</option>
                                                <option value="article" <?= old('og_type') === 'article' ? 'selected' : '' ?>>Article</option>
                                                <option value="product" <?= old('og_type') === 'product' ? 'selected' : '' ?>>Product</option>
                                                <option value="profile" <?= old('og_type') === 'profile' ? 'selected' : '' ?>>Profile</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="og_description" class="form-label">Open Graph Description</label>
                                    <textarea class="form-control" id="og_description" name="og_description" rows="2" 
                                              maxlength="300"><?= old('og_description') ?></textarea>
                                    <small class="text-muted">Description for social media sharing</small>
                                </div>

                                <div class="mb-3">
                                    <label for="og_image" class="form-label">Open Graph Image URL</label>
                                    <input type="url" class="form-control" id="og_image" name="og_image" 
                                           value="<?= old('og_image') ?>" placeholder="https://example.com/image.jpg">
                                    <small class="text-muted">Image URL for social media sharing (recommended: 1200x630px)</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="canonical_url" class="form-label">Canonical URL</label>
                                            <input type="url" class="form-control" id="canonical_url" name="canonical_url" 
                                                   value="<?= old('canonical_url') ?>">
                                            <small class="text-muted">Preferred URL for this page (prevents duplicate content)</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="robots" class="form-label">Robots Meta</label>
                                            <select class="form-select" id="robots" name="robots">
                                                <option value="index,follow" <?= old('robots', 'index,follow') === 'index,follow' ? 'selected' : '' ?>>Index, Follow</option>
                                                <option value="noindex,follow" <?= old('robots') === 'noindex,follow' ? 'selected' : '' ?>>No Index, Follow</option>
                                                <option value="index,nofollow" <?= old('robots') === 'index,nofollow' ? 'selected' : '' ?>>Index, No Follow</option>
                                                <option value="noindex,nofollow" <?= old('robots') === 'noindex,nofollow' ? 'selected' : '' ?>>No Index, No Follow</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="active" <?= old('status', 'active') === 'active' ? 'selected' : '' ?>>
                                            Active
                                        </option>
                                        <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>
                                            Inactive
                                        </option>
                                    </select>
                                </div>

                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">SEO Preview</h6>
                                        <div id="seoPreview" class="border rounded p-2 bg-white">
                                            <div id="previewTitle" class="text-primary fw-bold" style="font-size: 18px;">Page Title</div>
                                            <div id="previewUrl" class="text-success small">https://example.com/page-url</div>
                                            <div id="previewDescription" class="text-muted small">Meta description will appear here...</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">SEO Analysis</h6>
                                        <div id="seoAnalysis">
                                            <div class="mb-2">
                                                <small class="text-muted">Title Length:</small>
                                                <div id="titleAnalysis" class="progress" style="height: 5px;">
                                                    <div class="progress-bar" style="width: 0%"></div>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Description Length:</small>
                                                <div id="descriptionAnalysis" class="progress" style="height: 5px;">
                                                    <div class="progress-bar" style="width: 0%"></div>
                                                </div>
                                            </div>
                                            <div id="seoScore" class="text-center">
                                                <div class="fw-bold text-muted">SEO Score: <span id="scoreValue">0</span>/100</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card bg-info bg-opacity-10 border-info">
                                    <div class="card-body">
                                        <h6 class="card-title text-info">💡 SEO Tips</h6>
                                        <ul class="small mb-0">
                                            <li>Keep titles under 60 characters</li>
                                            <li>Write compelling descriptions (150-160 chars)</li>
                                            <li>Use relevant keywords naturally</li>
                                            <li>Make each page unique</li>
                                            <li>Include Open Graph tags for social sharing</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('/admin/meta-tags') ?>" class="btn btn-secondary">
                                        <i data-lucide="arrow-left"></i> Back to Meta Tags
                                    </a>
                                    <div>
                                        <button type="reset" class="btn btn-outline-secondary me-2">
                                            <i data-lucide="rotate-ccw"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i data-lucide="save"></i> Create Meta Tag
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const descriptionInput = document.getElementById('description');
    const pageUrlInput = document.getElementById('page_url');
    const ogTitleInput = document.getElementById('og_title');

    // Character counters
    function updateCounter(input, counterId, maxLength) {
        const counter = document.getElementById(counterId);
        const length = input.value.length;
        counter.textContent = `${length}/${maxLength}`;
        
        if (length > maxLength * 0.9) {
            counter.classList.add('text-warning');
        } else {
            counter.classList.remove('text-warning');
        }
        
        if (length > maxLength) {
            counter.classList.add('text-danger');
        } else {
            counter.classList.remove('text-danger');
        }
    }

    titleInput.addEventListener('input', function() {
        updateCounter(this, 'titleCounter', 60);
        updatePreview();
        updateSEOAnalysis();
    });

    descriptionInput.addEventListener('input', function() {
        updateCounter(this, 'descriptionCounter', 160);
        updatePreview();
        updateSEOAnalysis();
    });

    pageUrlInput.addEventListener('input', function() {
        updatePreview();
    });

    // Auto-fill OG title from main title
    titleInput.addEventListener('input', function() {
        if (!ogTitleInput.value) {
            ogTitleInput.value = this.value;
        }
    });

    // Update SEO preview
    function updatePreview() {
        const title = titleInput.value || 'Page Title';
        const description = descriptionInput.value || 'Meta description will appear here...';
        const url = pageUrlInput.value || 'page-url';
        
        document.getElementById('previewTitle').textContent = title;
        document.getElementById('previewUrl').textContent = `<?= base_url() ?>/${url}`;
        document.getElementById('previewDescription').textContent = description;
    }

    // SEO Analysis
    function updateSEOAnalysis() {
        const titleLength = titleInput.value.length;
        const descriptionLength = descriptionInput.value.length;
        
        // Title analysis
        const titleProgress = Math.min((titleLength / 60) * 100, 100);
        const titleBar = document.querySelector('#titleAnalysis .progress-bar');
        titleBar.style.width = titleProgress + '%';
        
        if (titleLength >= 30 && titleLength <= 60) {
            titleBar.className = 'progress-bar bg-success';
        } else if (titleLength > 60) {
            titleBar.className = 'progress-bar bg-danger';
        } else {
            titleBar.className = 'progress-bar bg-warning';
        }
        
        // Description analysis
        const descriptionProgress = Math.min((descriptionLength / 160) * 100, 100);
        const descriptionBar = document.querySelector('#descriptionAnalysis .progress-bar');
        descriptionBar.style.width = descriptionProgress + '%';
        
        if (descriptionLength >= 120 && descriptionLength <= 160) {
            descriptionBar.className = 'progress-bar bg-success';
        } else if (descriptionLength > 160) {
            descriptionBar.className = 'progress-bar bg-danger';
        } else {
            descriptionBar.className = 'progress-bar bg-warning';
        }
        
        // Calculate SEO score
        let score = 0;
        if (titleLength >= 30 && titleLength <= 60) score += 40;
        else if (titleLength > 0) score += 20;
        
        if (descriptionLength >= 120 && descriptionLength <= 160) score += 40;
        else if (descriptionLength > 0) score += 20;
        
        if (pageUrlInput.value) score += 10;
        if (document.getElementById('keywords').value) score += 10;
        
        document.getElementById('scoreValue').textContent = score;
        
        const scoreElement = document.getElementById('scoreValue');
        if (score >= 80) {
            scoreElement.className = 'text-success';
        } else if (score >= 60) {
            scoreElement.className = 'text-warning';
        } else {
            scoreElement.className = 'text-danger';
        }
    }

    // Form validation
    document.getElementById('metaTagForm').addEventListener('submit', function(e) {
        if (!titleInput.value.trim()) {
            e.preventDefault();
            alert('Please enter a meta title');
            titleInput.focus();
            return false;
        }
        
        if (!descriptionInput.value.trim()) {
            e.preventDefault();
            alert('Please enter a meta description');
            descriptionInput.focus();
            return false;
        }
        
        if (!pageUrlInput.value.trim()) {
            e.preventDefault();
            alert('Please enter a page URL');
            pageUrlInput.focus();
            return false;
        }
    });

    // Initialize
    updatePreview();
    updateSEOAnalysis();
    updateCounter(titleInput, 'titleCounter', 60);
    updateCounter(descriptionInput, 'descriptionCounter', 160);
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>