<?= $this->include('layouts/dashboard_header') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?= $title ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/admin/testimonials') ?>">Testimonials</a></li>
                        <li class="breadcrumb-item active">Create</li>
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

    <form action="<?= base_url('/admin/testimonials/store') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Customer Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                           value="<?= old('customer_name') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_email" class="form-label">Customer Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="customer_email" name="customer_email" 
                                           value="<?= old('customer_email') ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_city" class="form-label">Customer City</label>
                                    <input type="text" class="form-control" id="customer_city" name="customer_city" 
                                           value="<?= old('customer_city') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                                    <select class="form-select" id="rating" name="rating" required>
                                        <option value="">Select Rating</option>
                                        <option value="5" <?= old('rating') == '5' ? 'selected' : '' ?>>⭐⭐⭐⭐⭐ (5 Stars)</option>
                                        <option value="4" <?= old('rating') == '4' ? 'selected' : '' ?>>⭐⭐⭐⭐ (4 Stars)</option>
                                        <option value="3" <?= old('rating') == '3' ? 'selected' : '' ?>>⭐⭐⭐ (3 Stars)</option>
                                        <option value="2" <?= old('rating') == '2' ? 'selected' : '' ?>>⭐⭐ (2 Stars)</option>
                                        <option value="1" <?= old('rating') == '1' ? 'selected' : '' ?>>⭐ (1 Star)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="testimonial_text" class="form-label">Testimonial Text <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="testimonial_text" name="testimonial_text" 
                                      rows="5" required><?= old('testimonial_text') ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Travel Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-select" id="category_id" name="category_id">
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>>
                                                <?= esc($category['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="destination_id" class="form-label">Destination</label>
                                    <select class="form-select" id="destination_id" name="destination_id">
                                        <option value="">Select Destination</option>
                                        <?php foreach ($destinations as $destination): ?>
                                            <option value="<?= $destination['id'] ?>" <?= old('destination_id') == $destination['id'] ? 'selected' : '' ?>>
                                                <?= esc($destination['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="package_name" class="form-label">Package Name</label>
                                    <input type="text" class="form-control" id="package_name" name="package_name" 
                                           value="<?= old('package_name') ?>" placeholder="e.g., Goa Beach Paradise - 4 Days">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="travel_date" class="form-label">Travel Date</label>
                                    <input type="date" class="form-control" id="travel_date" name="travel_date" 
                                           value="<?= old('travel_date') ?>">
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
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="pending" <?= old('status', 'pending') == 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="approved" <?= old('status') == 'approved' ? 'selected' : '' ?>>Approved</option>
                                <option value="rejected" <?= old('status') == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                            </select>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1"
                                   <?= old('is_featured') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_featured">
                                Mark as Featured Testimonial
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Customer Image -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Customer Photo</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="file" class="form-control" id="customer_image" name="customer_image" 
                                   accept="image/*">
                            <div class="form-text">Recommended size: 200x200px</div>
                        </div>
                        
                        <div id="image_preview" style="display: none;">
                            <img id="preview_img" src="" alt="Preview" class="img-fluid rounded">
                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="remove_image">
                                Remove Image
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i data-lucide="save" class="me-1"></i> Create Testimonial
                            </button>
                            <a href="<?= base_url('/admin/testimonials') ?>" class="btn btn-secondary">
                                <i data-lucide="x" class="me-1"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview
    const imageInput = document.getElementById('customer_image');
    const imagePreview = document.getElementById('image_preview');
    const previewImg = document.getElementById('preview_img');
    const removeImageBtn = document.getElementById('remove_image');
    
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
    
    removeImageBtn.addEventListener('click', function() {
        imageInput.value = '';
        imagePreview.style.display = 'none';
        previewImg.src = '';
    });
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>