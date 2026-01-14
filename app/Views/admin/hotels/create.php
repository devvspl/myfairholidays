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

    <form action="<?= base_url('/admin/hotels/store') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Hotel Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Hotel Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?= old('name') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <div id="quill-editor" style="height: 300px;"></div>
                            <textarea name="description" id="description" style="display: none;" required><?= old('description') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="3" 
                                      placeholder="Brief summary for listings"><?= old('short_description') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="address" name="address" rows="3" required><?= old('address') ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="number" step="any" class="form-control" id="latitude" name="latitude" 
                                           value="<?= old('latitude') ?>" placeholder="e.g., 40.7128">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="number" step="any" class="form-control" id="longitude" name="longitude" 
                                           value="<?= old('longitude') ?>" placeholder="e.g., -74.0060">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="amenities" class="form-label">Amenities</label>
                            <textarea class="form-control" id="amenities" name="amenities" rows="3" 
                                      placeholder="e.g., WiFi, Pool, Gym, Spa, Restaurant, Free Parking, Air Conditioning"><?= old('amenities') ?></textarea>
                            <div class="form-text">Separate amenities with commas</div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="contact_phone" class="form-label">Contact Phone</label>
                                    <input type="text" class="form-control" id="contact_phone" name="contact_phone" 
                                           value="<?= old('contact_phone') ?>" placeholder="+91 9876543210">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="contact_email" class="form-label">Contact Email</label>
                                    <input type="email" class="form-control" id="contact_email" name="contact_email" 
                                           value="<?= old('contact_email') ?>" placeholder="info@hotel.com">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="url" class="form-control" id="website" name="website" 
                                           value="<?= old('website') ?>" placeholder="https://hotel.com">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hotel Policies & Information -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Hotel Policies & Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="check_in_time" class="form-label">Check-in Time</label>
                                    <input type="text" class="form-control" id="check_in_time" name="check_in_time" 
                                           value="<?= old('check_in_time', '2:00 PM') ?>" placeholder="e.g., 2:00 PM">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="check_out_time" class="form-label">Check-out Time</label>
                                    <input type="text" class="form-control" id="check_out_time" name="check_out_time" 
                                           value="<?= old('check_out_time', '12:00 PM') ?>" placeholder="e.g., 12:00 PM">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="cancellation_policy" class="form-label">Cancellation Policy</label>
                            <div id="quill-cancellation-policy" style="height: 200px;"></div>
                            <textarea name="cancellation_policy" id="cancellation_policy" style="display: none;"><?= old('cancellation_policy') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="hotel_policies" class="form-label">Hotel Policies</label>
                            <div id="quill-hotel-policies" style="height: 250px;"></div>
                            <textarea name="hotel_policies" id="hotel_policies" style="display: none;"><?= old('hotel_policies') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="nearby_attractions" class="form-label">Nearby Attractions</label>
                            <textarea class="form-control" id="nearby_attractions" name="nearby_attractions" rows="4" 
                                      placeholder="Enter nearby attractions (one per line or separated by commas)"><?= old('nearby_attractions') ?></textarea>
                            <div class="form-text">List popular attractions near the hotel</div>
                        </div>

                        <div class="mb-3">
                            <label for="transportation_info" class="form-label">Transportation Information</label>
                            <textarea class="form-control" id="transportation_info" name="transportation_info" rows="4" 
                                      placeholder="Enter transportation details (one per line or separated by commas)"><?= old('transportation_info') ?></textarea>
                            <div class="form-text">Provide information about nearby transportation options</div>
                        </div>

                        <div class="mb-3">
                            <label for="dining_entertainment" class="form-label">Dining & Entertainment</label>
                            <textarea class="form-control" id="dining_entertainment" name="dining_entertainment" rows="4" 
                                      placeholder="Enter dining and entertainment options (one per line or separated by commas)"><?= old('dining_entertainment') ?></textarea>
                            <div class="form-text">List restaurants, bars, entertainment venues, etc.</div>
                        </div>
                    </div>
                </div>

                <!-- SEO & Meta Information -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">SEO & Meta Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title" 
                                   value="<?= old('meta_title') ?>" maxlength="60" 
                                   placeholder="SEO title for search engines">
                            <div class="form-text">Recommended: 50-60 characters</div>
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3" 
                                      maxlength="160" placeholder="Brief description for search engines"><?= old('meta_description') ?></textarea>
                            <div class="form-text">Recommended: 150-160 characters</div>
                        </div>

                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="2" 
                                      placeholder="hotel, accommodation, booking, destination name, amenities"><?= old('meta_keywords') ?></textarea>
                            <div class="form-text">
                                Separate keywords with commas. Example: hotel, luxury accommodation, city center, free wifi
                                <span id="keyword-count" class="text-muted ms-2"></span>
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
                            <label for="destination_id" class="form-label">Destination <span class="text-danger">*</span></label>
                            <select class="form-select" id="destination_id" name="destination_id" required>
                                <option value="">Select Destination</option>
                                <?php foreach ($destinations as $destination): ?>
                                    <option value="<?= $destination['id'] ?>" <?= old('destination_id') == $destination['id'] ? 'selected' : '' ?>>
                                        <?= esc($destination['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="star_rating" class="form-label">Star Rating <span class="text-danger">*</span></label>
                            <select class="form-select" id="star_rating" name="star_rating" required>
                                <option value="">Select Rating</option>
                                <option value="1" <?= old('star_rating') == '1' ? 'selected' : '' ?>>1 Star</option>
                                <option value="2" <?= old('star_rating') == '2' ? 'selected' : '' ?>>2 Stars</option>
                                <option value="3" <?= old('star_rating') == '3' ? 'selected' : '' ?>>3 Stars</option>
                                <option value="4" <?= old('star_rating') == '4' ? 'selected' : '' ?>>4 Stars</option>
                                <option value="5" <?= old('star_rating') == '5' ? 'selected' : '' ?>>5 Stars</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="price_per_night" class="form-label">Price per Night (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" id="price_per_night" 
                                   name="price_per_night" value="<?= old('price_per_night') ?>" required>
                        </div>

                        <!-- Discount Section -->
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Discount Settings</h6>
                                
                                <div class="mb-3">
                                    <label for="discount_type" class="form-label">Discount Type</label>
                                    <select class="form-select" id="discount_type" name="discount_type">
                                        <option value="none" <?= old('discount_type') == 'none' ? 'selected' : '' ?>>No Discount</option>
                                        <option value="percentage" <?= old('discount_type') == 'percentage' ? 'selected' : '' ?>>Percentage (%)</option>
                                        <option value="fixed" <?= old('discount_type') == 'fixed' ? 'selected' : '' ?>>Fixed Amount (₹)</option>
                                    </select>
                                </div>

                                <div class="mb-3" id="discount_value_group" style="display: none;">
                                    <label for="discount_value" class="form-label">
                                        <span id="discount_value_label">Discount Value</span>
                                    </label>
                                    <input type="number" step="0.01" class="form-control" id="discount_value" 
                                           name="discount_value" value="<?= old('discount_value', 0) ?>" min="0">
                                    <div class="form-text" id="discount_help_text">Enter discount value</div>
                                </div>

                                <div class="row" id="discount_dates_group" style="display: none;">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="discount_start_date" class="form-label">Start Date</label>
                                            <input type="date" class="form-control" id="discount_start_date" 
                                                   name="discount_start_date" value="<?= old('discount_start_date') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="discount_end_date" class="form-label">End Date</label>
                                            <input type="date" class="form-control" id="discount_end_date" 
                                                   name="discount_end_date" value="<?= old('discount_end_date') ?>">
                                        </div>
                                    </div>
                                </div>

                                <div id="discount_preview" class="alert alert-info" style="display: none;">
                                    <strong>Preview:</strong>
                                    <div id="discount_preview_text"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active" <?= old('status') == 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= old('status') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" 
                                   value="<?= old('sort_order', 0) ?>" min="0">
                            <div class="form-text">Lower numbers appear first</div>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1"
                                   <?= old('is_featured') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_featured">
                                Mark as Featured Hotel
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Featured Image</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="file" class="form-control" id="featured_image" name="featured_image" 
                                   accept="image/*">
                            <div class="form-text">Recommended size: 1200x630px</div>
                        </div>
                        
                        <div id="image_preview" style="display: none;">
                            <img id="preview_img" src="" alt="Preview" class="img-fluid rounded">
                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="remove_image">
                                Remove Image
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hotel Gallery -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Hotel Gallery</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="hotel_images" class="form-label">Upload Multiple Images</label>
                            <input type="file" class="form-control" id="hotel_images" name="hotel_images[]" 
                                   accept="image/*" multiple>
                            <div class="form-text">You can select multiple images. Recommended size: 1200x800px</div>
                        </div>
                        
                        <div id="gallery_preview" class="row g-2" style="display: none;">
                            <!-- Gallery previews will be added here -->
                        </div>
                        
                        <div class="mt-3">
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="add_more_images">
                                <i data-lucide="plus" class="me-1"></i> Add More Images
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i data-lucide="save" class="me-1"></i> Create Hotel
                            </button>
                            <a href="<?= base_url('/admin/hotels') ?>" class="btn btn-secondary">
                                <i data-lucide="x" class="me-1"></i> Cancel
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

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill editors
    const editors = {
        description: new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'align': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        }),
        cancellationPolicy: new Quill('#quill-cancellation-policy', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'color': [] }],
                    ['clean']
                ]
            }
        }),
        hotelPolicies: new Quill('#quill-hotel-policies', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'color': [] }],
                    ['clean']
                ]
            }
        })
    };

    // Set existing content for all editors
    const existingContent = {
        description: document.getElementById('description').value,
        cancellationPolicy: document.getElementById('cancellation_policy').value,
        hotelPolicies: document.getElementById('hotel_policies').value
    };

    Object.keys(existingContent).forEach(key => {
        if (existingContent[key] && editors[key]) {
            editors[key].root.innerHTML = existingContent[key];
        }
    });

    // Update hidden textareas when form is submitted
    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        document.getElementById('description').value = editors.description.root.innerHTML;
        document.getElementById('cancellation_policy').value = editors.cancellationPolicy.root.innerHTML;
        document.getElementById('hotel_policies').value = editors.hotelPolicies.root.innerHTML;
    });

    // Featured image preview
    const featuredImageInput = document.getElementById('featured_image');
    const imagePreview = document.getElementById('image_preview');
    const previewImg = document.getElementById('preview_img');
    const removeImageBtn = document.getElementById('remove_image');
    
    featuredImageInput.addEventListener('change', function() {
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
        featuredImageInput.value = '';
        imagePreview.style.display = 'none';
        previewImg.src = '';
    });

    // Gallery images preview
    const galleryInput = document.getElementById('hotel_images');
    const galleryPreview = document.getElementById('gallery_preview');
    let imageIndex = 0;

    galleryInput.addEventListener('change', function() {
        handleGalleryImages(this.files);
    });

    function handleGalleryImages(files) {
        if (files.length > 0) {
            galleryPreview.style.display = 'block';
        }

        Array.from(files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageContainer = createImagePreview(e.target.result, imageIndex);
                    galleryPreview.appendChild(imageContainer);
                    imageIndex++;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    function createImagePreview(src, index) {
        const col = document.createElement('div');
        col.className = 'col-md-4 col-sm-6';
        
        col.innerHTML = `
            <div class="card">
                <img src="${src}" class="card-img-top" alt="Preview" style="height: 150px; object-fit: cover;">
                <div class="card-body p-2">
                    <input type="text" class="form-control form-control-sm mb-1" 
                           name="image_alt_texts[]" placeholder="Alt text">
                    <input type="text" class="form-control form-control-sm mb-2" 
                           name="image_captions[]" placeholder="Caption (optional)">
                    <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-gallery-image">
                        <i data-lucide="trash-2" class="me-1"></i> Remove
                    </button>
                </div>
            </div>
        `;

        // Add remove functionality
        col.querySelector('.remove-gallery-image').addEventListener('click', function() {
            col.remove();
            if (galleryPreview.children.length === 0) {
                galleryPreview.style.display = 'none';
            }
        });

        return col;
    }

    // Add more images button
    document.getElementById('add_more_images').addEventListener('click', function() {
        galleryInput.click();
    });

    // Meta keywords counter and helper
    const metaKeywordsInput = document.getElementById('meta_keywords');
    const keywordCountSpan = document.getElementById('keyword-count');
    
    function updateKeywordCount() {
        const keywords = metaKeywordsInput.value.split(',').filter(k => k.trim().length > 0);
        const count = keywords.length;
        keywordCountSpan.textContent = `(${count} keyword${count !== 1 ? 's' : ''})`;
        
        if (count > 10) {
            keywordCountSpan.className = 'text-warning ms-2';
            keywordCountSpan.textContent += ' - Consider reducing for better SEO';
        } else if (count > 15) {
            keywordCountSpan.className = 'text-danger ms-2';
            keywordCountSpan.textContent += ' - Too many keywords';
        } else {
            keywordCountSpan.className = 'text-muted ms-2';
        }
    }
    
    if (metaKeywordsInput) {
        metaKeywordsInput.addEventListener('input', updateKeywordCount);
        updateKeywordCount(); // Initial count
    }

    // Discount handling
    const discountType = document.getElementById('discount_type');
    const discountValueGroup = document.getElementById('discount_value_group');
    const discountDatesGroup = document.getElementById('discount_dates_group');
    const discountValue = document.getElementById('discount_value');
    const discountValueLabel = document.getElementById('discount_value_label');
    const discountHelpText = document.getElementById('discount_help_text');
    const discountPreview = document.getElementById('discount_preview');
    const discountPreviewText = document.getElementById('discount_preview_text');
    const pricePerNight = document.getElementById('price_per_night');

    function updateDiscountFields() {
        const type = discountType.value;
        
        if (type === 'none') {
            discountValueGroup.style.display = 'none';
            discountDatesGroup.style.display = 'none';
            discountPreview.style.display = 'none';
        } else {
            discountValueGroup.style.display = 'block';
            discountDatesGroup.style.display = 'block';
            
            if (type === 'percentage') {
                discountValueLabel.textContent = 'Discount Percentage (%)';
                discountHelpText.textContent = 'Enter percentage (e.g., 15 for 15% off)';
                discountValue.max = 100;
            } else if (type === 'fixed') {
                discountValueLabel.textContent = 'Discount Amount (₹)';
                discountHelpText.textContent = 'Enter fixed discount amount in rupees';
                discountValue.removeAttribute('max');
            }
            
            updateDiscountPreview();
        }
    }

    function updateDiscountPreview() {
        const type = discountType.value;
        const value = parseFloat(discountValue.value) || 0;
        const price = parseFloat(pricePerNight.value) || 0;
        
        if (type === 'none' || value <= 0 || price <= 0) {
            discountPreview.style.display = 'none';
            return;
        }
        
        let discountAmount = 0;
        let finalPrice = price;
        let previewText = '';
        
        if (type === 'percentage') {
            discountAmount = (price * value) / 100;
            finalPrice = price - discountAmount;
            previewText = `Original Price: ₹${price.toFixed(2)} | Discount: ${value}% (₹${discountAmount.toFixed(2)}) | Final Price: ₹${finalPrice.toFixed(2)}`;
        } else if (type === 'fixed') {
            discountAmount = Math.min(value, price);
            finalPrice = price - discountAmount;
            const percentage = ((discountAmount / price) * 100).toFixed(1);
            previewText = `Original Price: ₹${price.toFixed(2)} | Discount: ₹${discountAmount.toFixed(2)} (${percentage}%) | Final Price: ₹${finalPrice.toFixed(2)}`;
        }
        
        discountPreviewText.textContent = previewText;
        discountPreview.style.display = 'block';
    }

    discountType.addEventListener('change', updateDiscountFields);
    discountValue.addEventListener('input', updateDiscountPreview);
    pricePerNight.addEventListener('input', updateDiscountPreview);
    
    // Initialize on page load
    updateDiscountFields();
});
</script>

<?= $this->include('layouts/dashboard_footer') ?>