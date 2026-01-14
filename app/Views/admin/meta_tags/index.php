<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">SEO Meta Tags</li>
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
                    <h4 class="card-title mb-0">SEO Meta Tags Management</h4>
                    <div class="btn-group">
                        <a href="<?= base_url('/admin/meta-tags/export') ?>" class="btn btn-outline-success btn-sm">
                            <i data-lucide="download" class="me-1"></i> Export
                        </a>
                        <a href="<?= base_url('/admin/meta-tags/bulk-import') ?>" class="btn btn-outline-info btn-sm">
                            <i data-lucide="upload" class="me-1"></i> Bulk Import
                        </a>
                        <a href="<?= base_url('/admin/meta-tags/create') ?>" class="btn btn-primary btn-sm">
                            <i data-lucide="plus" class="me-1"></i> Add Meta Tag
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Page URL</th>
                                    <th>Meta Title</th>
                                    <th>Meta Description</th>
                                    <th>Keywords</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($metaTags)): ?>
                                    <?php foreach ($metaTags as $tag): ?>
                                        <tr>
                                            <td><?= $tag['id'] ?></td>
                                            <td>
                                                <code><?= esc($tag['page_url']) ?></code>
                                            </td>
                                            <td>
                                                <div style="max-width: 200px;">
                                                    <strong><?= substr(esc($tag['meta_title']), 0, 50) ?></strong>
                                                    <?= strlen($tag['meta_title']) > 50 ? '...' : '' ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="max-width: 250px;">
                                                    <?= substr(esc($tag['meta_description']), 0, 80) ?>
                                                    <?= strlen($tag['meta_description']) > 80 ? '...' : '' ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="max-width: 150px;">
                                                    <?php if ($tag['meta_keywords']): ?>
                                                        <?php 
                                                        $keywords = explode(',', $tag['meta_keywords']);
                                                        $displayKeywords = array_slice($keywords, 0, 3);
                                                        ?>
                                                        <?php foreach ($displayKeywords as $keyword): ?>
                                                            <span class="badge badge-soft-secondary me-1"><?= trim(esc($keyword)) ?></span>
                                                        <?php endforeach; ?>
                                                        <?php if (count($keywords) > 3): ?>
                                                            <span class="text-muted">+<?= count($keywords) - 3 ?> more</span>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">No keywords</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-<?= $tag['status'] === 'active' ? 'success' : 'danger' ?>">
                                                    <?= ucfirst($tag['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('/admin/meta-tags/edit/' . $tag['id']) ?>" 
                                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i data-lucide="edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-warning toggle-status" 
                                                            data-id="<?= $tag['id'] ?>" title="Toggle Status">
                                                        <i data-lucide="power"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-info preview-meta" 
                                                            data-id="<?= $tag['id'] ?>" 
                                                            data-title="<?= esc($tag['meta_title']) ?>"
                                                            data-description="<?= esc($tag['meta_description']) ?>"
                                                            data-url="<?= esc($tag['page_url']) ?>" title="Preview">
                                                        <i data-lucide="eye"></i>
                                                    </button>
                                                    <a href="<?= base_url('/admin/meta-tags/delete/' . $tag['id']) ?>" 
                                                       class="btn btn-sm btn-outline-danger" 
                                                       onclick="return confirm('Are you sure you want to delete this meta tag?')" title="Delete">
                                                        <i data-lucide="trash-2"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No meta tags found</td>
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

<!-- Meta Tag Preview Modal -->
<div class="modal fade" id="metaPreviewModal" tabindex="-1" aria-labelledby="metaPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="metaPreviewModalLabel">SEO Meta Tag Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i data-lucide="info" class="me-2"></i>
                    This is how your page might appear in search engine results.
                </div>
                
                <div class="search-result-preview p-3 border rounded">
                    <div class="search-url text-success mb-1" id="previewUrl"></div>
                    <h6 class="search-title text-primary mb-1" id="previewTitle"></h6>
                    <p class="search-description text-muted mb-0" id="previewDescription"></p>
                </div>
                
                <div class="mt-3">
                    <h6>SEO Analysis:</h6>
                    <div id="seoAnalysis"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle status functionality
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function() {
            const tagId = this.dataset.id;
            
            fetch(`<?= base_url('/admin/meta-tags/toggle-status/') ?>${tagId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
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

    // Preview meta tag functionality
    document.querySelectorAll('.preview-meta').forEach(button => {
        button.addEventListener('click', function() {
            const title = this.dataset.title;
            const description = this.dataset.description;
            const url = this.dataset.url;
            
            // Update modal content
            document.getElementById('previewUrl').textContent = window.location.origin + url;
            document.getElementById('previewTitle').textContent = title;
            document.getElementById('previewDescription').textContent = description;
            
            // SEO Analysis
            let analysis = [];
            
            if (title.length < 30) {
                analysis.push('<div class="text-warning"><i data-lucide="alert-triangle"></i> Title is too short (recommended: 30-60 characters)</div>');
            } else if (title.length > 60) {
                analysis.push('<div class="text-warning"><i data-lucide="alert-triangle"></i> Title might be truncated (recommended: 30-60 characters)</div>');
            } else {
                analysis.push('<div class="text-success"><i data-lucide="check"></i> Title length is optimal</div>');
            }
            
            if (description.length < 120) {
                analysis.push('<div class="text-warning"><i data-lucide="alert-triangle"></i> Description is too short (recommended: 120-160 characters)</div>');
            } else if (description.length > 160) {
                analysis.push('<div class="text-warning"><i data-lucide="alert-triangle"></i> Description might be truncated (recommended: 120-160 characters)</div>');
            } else {
                analysis.push('<div class="text-success"><i data-lucide="check"></i> Description length is optimal</div>');
            }
            
            document.getElementById('seoAnalysis').innerHTML = analysis.join('');
            
            // Show modal
            new bootstrap.Modal(document.getElementById('metaPreviewModal')).show();
        });
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>