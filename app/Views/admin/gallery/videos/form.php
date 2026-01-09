<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/videos') ?>">Video Gallery</a></li>
                        <li class="breadcrumb-item active"><?= isset($video) ? 'Edit' : 'Create' ?></li>
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
                        <h4 class="card-title mb-0"><?= isset($video) ? 'Edit Video' : 'Add New Video' ?></h4>
                        <a href="<?= base_url('/admin/videos') ?>" class="btn btn-outline-secondary">
                            <i data-lucide="arrow-left" class="me-1"></i> Back to Gallery
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" 
                          action="<?= isset($video) ? base_url('/admin/videos/update/' . $video['id']) : base_url('/admin/videos/store') ?>" 
                          enctype="multipart/form-data">
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Video Title <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control <?= isset($validation) && $validation->hasError('title') ? 'is-invalid' : '' ?>" 
                                           id="title" 
                                           name="title" 
                                           value="<?= old('title', $video['title'] ?? '') ?>" 
                                           required>
                                    <?php if (isset($validation) && $validation->hasError('title')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('title') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" 
                                              id="description" 
                                              name="description" 
                                              rows="3" 
                                              placeholder="Optional description for the video"><?= old('description', $video['description'] ?? '') ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="video_type" class="form-label">Video Type <span class="text-danger">*</span></label>
                                    <select class="form-select <?= isset($validation) && $validation->hasError('video_type') ? 'is-invalid' : '' ?>" 
                                            id="video_type" 
                                            name="video_type" 
                                            required>
                                        <option value="">Select Video Type</option>
                                        <option value="youtube" <?= old('video_type', $video['video_type'] ?? '') === 'youtube' ? 'selected' : '' ?>>YouTube</option>
                                        <option value="mp4" <?= old('video_type', $video['video_type'] ?? '') === 'mp4' ? 'selected' : '' ?>>MP4 Upload</option>
                                    </select>
                                    <?php if (isset($validation) && $validation->hasError('video_type')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('video_type') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- YouTube URL Field -->
                                <div class="mb-3" id="youtube_url_field" style="display: none;">
                                    <label for="video_url" class="form-label">YouTube URL <span class="text-danger">*</span></label>
                                    <input type="url" 
                                           class="form-control <?= isset($validation) && $validation->hasError('video_url') ? 'is-invalid' : '' ?>" 
                                           id="video_url" 
                                           name="video_url" 
                                           value="<?= old('video_url', $video['video_url'] ?? '') ?>" 
                                           placeholder="https://www.youtube.com/watch?v=...">
                                    <div class="form-text">Enter the full YouTube URL (e.g., https://www.youtube.com/watch?v=dQw4w9WgXcQ)</div>
                                    <?php if (isset($validation) && $validation->hasError('video_url')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('video_url') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- MP4 Upload Field -->
                                <div class="mb-3" id="mp4_upload_field" style="display: none;">
                                    <label for="video_file" class="form-label">
                                        <?= isset($video) ? 'Replace Video File (Optional)' : 'Video File' ?> 
                                        <?= !isset($video) ? '<span class="text-danger">*</span>' : '' ?>
                                    </label>
                                    <input type="file" 
                                           class="form-control <?= isset($validation) && $validation->hasError('video_file') ? 'is-invalid' : '' ?>" 
                                           id="video_file" 
                                           name="video_file" 
                                           accept="video/mp4,video/avi,video/mov,video/wmv">
                                    <div class="form-text">
                                        <?= isset($video) ? 'Leave empty to keep current video. ' : '' ?>
                                        Supported formats: MP4, AVI, MOV, WMV. Max size: 50MB.
                                    </div>
                                    <?php if (isset($validation) && $validation->hasError('video_file')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('video_file') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Thumbnail Upload -->
                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Custom Thumbnail (Optional)</label>
                                    <input type="file" 
                                           class="form-control" 
                                           id="thumbnail" 
                                           name="thumbnail" 
                                           accept="image/*">
                                    <div class="form-text">
                                        Upload a custom thumbnail image. For YouTube videos, the default thumbnail will be used if not provided.
                                    </div>
                                </div>

                                <div id="videoPreview" class="mb-3"></div>
                            </div>

                            <div class="col-md-4">
                                <?php if (isset($video)): ?>
                                <div class="mb-3">
                                    <label class="form-label">Current Video</label>
                                    <div class="border rounded p-2">
                                        <?php if ($video['video_type'] === 'youtube'): ?>
                                            <div class="ratio ratio-16x9">
                                                <img src="https://img.youtube.com/vi/<?= $video['video_id'] ?>/maxresdefault.jpg" 
                                                     alt="<?= esc($video['title']) ?>" 
                                                     class="img-fluid rounded">
                                            </div>
                                            <small class="text-muted d-block mt-2">YouTube Video</small>
                                        <?php else: ?>
                                            <div class="ratio ratio-16x9">
                                                <?php if ($video['thumbnail']): ?>
                                                    <img src="<?= base_url($video['thumbnail']) ?>" 
                                                         alt="<?= esc($video['title']) ?>" 
                                                         class="img-fluid rounded">
                                                <?php else: ?>
                                                    <div class="d-flex align-items-center justify-content-center bg-light rounded">
                                                        <i data-lucide="video" class="text-muted" style="width: 48px; height: 48px;"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <small class="text-muted d-block mt-2">MP4 Video</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select <?= isset($validation) && $validation->hasError('status') ? 'is-invalid' : '' ?>" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="">Select Status</option>
                                        <option value="active" <?= old('status', $video['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= old('status', $video['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                    <?php if (isset($validation) && $validation->hasError('status')): ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('status') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_homepage" 
                                               name="is_homepage" 
                                               value="1" 
                                               <?= old('is_homepage', $video['is_homepage'] ?? 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="is_homepage">
                                            Display on Homepage
                                        </label>
                                    </div>
                                    <div class="form-text">Check to display this video on the homepage gallery.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="sort_order" 
                                           name="sort_order" 
                                           value="<?= old('sort_order', $video['sort_order'] ?? 0) ?>" 
                                           min="0">
                                    <div class="form-text">Lower numbers appear first. Leave 0 for automatic ordering.</div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i data-lucide="save" class="me-1"></i>
                                        <?= isset($video) ? 'Update Video' : 'Add Video' ?>
                                    </button>
                                    <a href="<?= base_url('/admin/videos') ?>" class="btn btn-outline-secondary">
                                        <i data-lucide="x" class="me-1"></i> Cancel
                                    </a>
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
    const videoTypeSelect = document.getElementById('video_type');
    const youtubeField = document.getElementById('youtube_url_field');
    const mp4Field = document.getElementById('mp4_upload_field');
    const videoUrlInput = document.getElementById('video_url');
    const videoFileInput = document.getElementById('video_file');
    const previewContainer = document.getElementById('videoPreview');

    // Show/hide fields based on video type
    function toggleVideoFields() {
        const selectedType = videoTypeSelect.value;
        
        if (selectedType === 'youtube') {
            youtubeField.style.display = 'block';
            mp4Field.style.display = 'none';
            videoUrlInput.required = true;
            videoFileInput.required = false;
        } else if (selectedType === 'mp4') {
            youtubeField.style.display = 'none';
            mp4Field.style.display = 'block';
            videoUrlInput.required = false;
            <?php if (!isset($video)): ?>
            videoFileInput.required = true;
            <?php endif; ?>
        } else {
            youtubeField.style.display = 'none';
            mp4Field.style.display = 'none';
            videoUrlInput.required = false;
            videoFileInput.required = false;
        }
    }

    // Initialize on page load
    toggleVideoFields();

    // Handle video type change
    videoTypeSelect.addEventListener('change', toggleVideoFields);

    // YouTube URL preview
    videoUrlInput.addEventListener('blur', function() {
        const url = this.value;
        if (url && videoTypeSelect.value === 'youtube') {
            const videoId = extractYouTubeId(url);
            if (videoId) {
                showYouTubePreview(videoId);
            } else {
                previewContainer.innerHTML = '<div class="alert alert-warning">Invalid YouTube URL. Please check the URL format.</div>';
            }
        }
    });

    // Video file preview
    videoFileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            showVideoFilePreview(file);
        }
    });

    function extractYouTubeId(url) {
        const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
        const matches = url.match(regex);
        return matches ? matches[1] : null;
    }

    function showYouTubePreview(videoId) {
        previewContainer.innerHTML = `
            <label class="form-label">Preview:</label>
            <div class="border rounded p-2">
                <div class="ratio ratio-16x9">
                    <img src="https://img.youtube.com/vi/${videoId}/maxresdefault.jpg" 
                         alt="YouTube Video Preview" 
                         class="img-fluid rounded">
                </div>
                <small class="text-muted d-block mt-2">YouTube Video Preview</small>
            </div>
        `;
    }

    function showVideoFilePreview(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewContainer.innerHTML = `
                <label class="form-label">Preview:</label>
                <div class="border rounded p-2">
                    <div class="ratio ratio-16x9">
                        <video controls class="rounded">
                            <source src="${e.target.result}" type="${file.type}">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <small class="text-muted d-block mt-2">${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)</small>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const videoType = videoTypeSelect.value;
        
        if (!videoType) {
            e.preventDefault();
            alert('Please select a video type');
            return;
        }
        
        if (videoType === 'youtube' && !videoUrlInput.value) {
            e.preventDefault();
            alert('Please enter a YouTube URL');
            return;
        }
        
        <?php if (!isset($video)): ?>
        if (videoType === 'mp4' && !videoFileInput.files.length) {
            e.preventDefault();
            alert('Please select a video file');
            return;
        }
        <?php endif; ?>
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>