<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/destinations') ?>">Destinations</a></li>
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

    <form action="<?= base_url('/admin/destinations/update/' . $destination['id']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Destination Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Destination Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?= old('name', $destination['name']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?= old('description', $destination['description'] ?? '') ?></textarea>
                        </div>

                        <!-- Content Editor -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Detailed Content</label>
                            <div id="quill-editor" style="height: 300px;"></div>
                            <textarea name="content" id="content" style="display: none;"><?= old('content', $destination['content'] ?? '') ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="number" step="any" class="form-control" id="latitude" name="latitude" 
                                           value="<?= old('latitude', $destination['latitude'] ?? '') ?>" placeholder="e.g., 40.7128">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="number" step="any" class="form-control" id="longitude" name="longitude" 
                                           value="<?= old('longitude', $destination['longitude'] ?? '') ?>" placeholder="e.g., -74.0060">
                                </div>
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="mb-3">
                            <label class="form-label">Location on Map</label>
                            <div id="map" style="height: 300px; border-radius: 8px;"></div>
                            <div class="form-text">Click on the map to set coordinates or drag the marker</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="number" step="any" class="form-control" id="latitude" name="latitude" 
                                           value="<?= old('latitude', $destination['latitude']) ?>" placeholder="e.g., 40.7128">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="number" step="any" class="form-control" id="longitude" name="longitude" 
                                           value="<?= old('longitude', $destination['longitude']) ?>" placeholder="e.g., -74.0060">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Settings -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="destination_type" class="form-label">Destination Type</label>
                            <select class="form-select" id="destination_type" name="type_id">
                                <option value="">Select Type</option>
                                <!-- Types will be loaded dynamically -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Category</label>
                            <select class="form-select" id="type" name="type">
                                <option value="destination" <?= old('type', $destination['type'] ?? 'destination') == 'destination' ? 'selected' : '' ?>>Destination</option>
                                <option value="country" <?= old('type', $destination['type'] ?? 'destination') == 'country' ? 'selected' : '' ?>>Country</option>
                                <option value="state" <?= old('type', $destination['type'] ?? 'destination') == 'state' ? 'selected' : '' ?>>State</option>
                                <option value="city" <?= old('type', $destination['type'] ?? 'destination') == 'city' ? 'selected' : '' ?>>City</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active" <?= old('status', $destination['status'] ?? 'active') == 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= old('status', $destination['status'] ?? 'active') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1"
                                   <?= old('is_featured', $destination['is_popular'] ?? 0) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_featured">
                                Mark as Popular Destination
                            </label>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">
                                <strong>Created:</strong> <?= date('M j, Y g:i A', strtotime($destination['created_at'] ?? 'now')) ?><br>
                                <strong>Updated:</strong> <?= date('M j, Y g:i A', strtotime($destination['updated_at'] ?? 'now')) ?>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Featured Image</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($destination['image']) && $destination['image']): ?>
                            <div class="mb-3" id="current_image">
                                <img src="<?= base_url($destination['image']) ?>" 
                                     alt="Current featured image" class="img-fluid rounded">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="remove_current_image">
                                    Remove Current Image
                                </button>
                            </div>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <input type="file" class="form-control" id="featured_image" name="featured_image" 
                                   accept="image/*">
                            <div class="form-text">Recommended size: 1200x630px</div>
                        </div>
                        
                        <div id="image_preview" style="display: none;">
                            <img id="preview_img" src="" alt="Preview" class="img-fluid rounded">
                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="remove_image">
                                Remove New Image
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i data-lucide="save" class="me-1"></i> Update Destination
                            </button>
                            <a href="<?= base_url('/admin/destinations') ?>" class="btn btn-secondary">
                                <i data-lucide="arrow-left" class="me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill editor
    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['link', 'image', 'video'],
                ['clean']
            ]
        }
    });

    // Set existing content
    const existingContent = document.getElementById('content').value;
    if (existingContent) {
        quill.root.innerHTML = existingContent;
    }

    // Update hidden textarea when form is submitted
    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        document.getElementById('content').value = quill.root.innerHTML;
    });

    // Initialize map
    const lat = parseFloat(document.getElementById('latitude').value) || 40.7128;
    const lng = parseFloat(document.getElementById('longitude').value) || -74.0060;
    
    const map = L.map('map').setView([lat, lng], 10);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let marker = L.marker([lat, lng], { draggable: true }).addTo(map);

    // Update coordinates when marker is moved
    marker.on('dragend', function(e) {
        const position = e.target.getLatLng();
        document.getElementById('latitude').value = position.lat.toFixed(6);
        document.getElementById('longitude').value = position.lng.toFixed(6);
    });

    // Update marker when coordinates are changed manually
    document.getElementById('latitude').addEventListener('input', updateMarker);
    document.getElementById('longitude').addEventListener('input', updateMarker);

    function updateMarker() {
        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(document.getElementById('longitude').value);
        
        if (!isNaN(lat) && !isNaN(lng)) {
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng], map.getZoom());
        }
    }

    // Add click event to map
    map.on('click', function(e) {
        const { lat, lng } = e.latlng;
        marker.setLatLng([lat, lng]);
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);
    });

    // Load destination types
    fetch('/admin/destination-types/api/active')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('destination_type');
            const currentTypeId = '<?= old('type_id', $destination['type_id'] ?? '') ?>';
            
            data.forEach(type => {
                const option = document.createElement('option');
                option.value = type.id;
                option.textContent = type.name;
                if (type.id == currentTypeId) {
                    option.selected = true;
                }
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading destination types:', error));

    // Image preview
    const featuredImageInput = document.getElementById('featured_image');
    const imagePreview = document.getElementById('image_preview');
    const previewImg = document.getElementById('preview_img');
    const removeImageBtn = document.getElementById('remove_image');
    const currentImage = document.getElementById('current_image');
    const removeCurrent = document.getElementById('remove_current_image');
    
    featuredImageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
                if (currentImage) {
                    currentImage.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        }
    });
    
    removeImageBtn?.addEventListener('click', function() {
        featuredImageInput.value = '';
        imagePreview.style.display = 'none';
        previewImg.src = '';
        if (currentImage) {
            currentImage.style.display = 'block';
        }
    });
    
    removeCurrent?.addEventListener('click', function() {
        if (confirm('Remove current featured image?')) {
            currentImage.style.display = 'none';
            // Add hidden input to indicate image removal
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'remove_featured_image';
            hiddenInput.value = '1';
            document.querySelector('form').appendChild(hiddenInput);
        }
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>