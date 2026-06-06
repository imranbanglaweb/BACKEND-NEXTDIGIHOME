@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); padding: 30px;">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.5px;"><i class="fa fa-plus-circle text-primary me-2"></i>Create New Product</h2>
                    <p class="text-muted mb-0" style="font-size: 1.05rem;">Add a premium product to your digital marketplace with rich media</p>
                </div>
                <a class="btn btn-outline-secondary btn-lg px-4" href="{{ route('admin.products.index') }}" style="border-radius: 50px;">
                    <i class="fa fa-arrow-left me-2"></i>Back to Products
                </a>
            </div>
        </div>
    </div>

    <!-- Main Form Card - Premium Design -->
    <div class="card" style="border: none; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); overflow: hidden;">
        <div class="card-header" style="background: linear-gradient(90deg, #007bff, #0056b3); color: white; padding: 1.25rem 1.5rem; border: none;">
            <h5 class="mb-0" style="font-weight: 600; font-size: 1.25rem;"><i class="fa fa-box me-2"></i>Product Information</h5>
        </div>
        <div class="card-body p-4" style="background: #fff;">
            <!-- Alert Container -->
            <div id="formAlert"></div>

            <form id="productForm" action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <!-- Basic Information Section -->
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <h6 class="text-primary mb-3"><i class="fa fa-info-circle me-2"></i>Basic Information</h6>
                    </div>

                    <!-- Product Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-bold">
                            Product Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name">
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- URL Slug -->
                    <div class="col-md-6">
                        <label for="slug" class="form-label fw-bold">
                            URL Slug <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="slug" name="slug" placeholder="product-url-slug">
                        <div class="form-text">Auto-generated from product name</div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <label for="category" class="form-label fw-bold">
                            Category <span class="text-danger">*</span>
                        </label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select Category</option>
                            <option value="Digital Marketing">Digital Marketing</option>
                            <option value="Web Development">Web Development</option>
                            <option value="Graphic Design">Graphic Design</option>
                            <option value="Business Tools">Business Tools</option>
                            <option value="Education">Education</option>
                            <option value="Photography">Photography</option>
                            <option value="Music & Audio">Music & Audio</option>
                            <option value="Video & Animation">Video & Animation</option>
                            <option value="Software & Apps">Software & Apps</option>
                            <option value="Templates">Templates</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Product Type -->
                    <div class="col-md-6">
                        <label for="digital" class="form-label fw-bold">
                            Product Type <span class="text-danger">*</span>
                        </label>
                        <select name="digital" id="digital" class="form-control">
                            <option value="1">Digital Product</option>
                            <option value="0">Physical Product</option>
                        </select>
                        <div class="form-text">Digital products are delivered via download</div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <!-- Pricing Section -->
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <h6 class="text-success mb-3"><i class="fa fa-dollar-sign me-2"></i>Pricing Information</h6>
                    </div>

                    <!-- Price -->
                    <div class="col-md-4">
                        <label for="price" class="form-label fw-bold">
                            Price <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" placeholder="0.00">
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Compare Price -->
                    <div class="col-md-4">
                        <label for="compare_price" class="form-label fw-bold">Compare Price</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" min="0" class="form-control" id="compare_price" name="compare_price" placeholder="0.00">
                        </div>
                        <div class="form-text">Original price (shows crossed out)</div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Stock -->
                    <div class="col-md-4">
                        <label for="stock" class="form-label fw-bold">
                            Stock Quantity <span class="text-danger">*</span>
                        </label>
                        <input type="number" min="0" class="form-control" id="stock" name="stock" placeholder="0">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <h6 class="text-info mb-3"><i class="fa fa-file-alt me-2"></i>Product Content</h6>
                    </div>

                    <!-- Description -->
                    <div class="col-md-6">
                        <label for="description" class="form-label fw-bold">Short Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Brief product description"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Detailed Description with WYSIWYG -->
                    <div class="col-12">
                        <label for="detailed_description" class="form-label fw-bold">Detailed Description <span class="text-muted">(Rich Text Editor)</span></label>
                        <textarea class="form-control" id="detailed_description" name="detailed_description" rows="6" placeholder="Detailed product information, features, benefits, usage guide..."></textarea>
                        <div class="form-text">Use the rich text editor for formatted content, lists, links, images, etc.</div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Tags -->
                    <div class="col-md-6">
                        <label for="tags" class="form-label fw-bold">Tags</label>
                        <input type="text" class="form-control" id="tags" name="tags" placeholder="e-commerce, marketing, tools" data-role="tagsinput">
                        <div class="form-text">Comma-separated tags for better search</div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Display Options -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Display Options</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1">
                            <label class="form-check-label fw-bold" for="featured">
                                Featured Product
                            </label>
                            <div class="form-text">Show in featured products section</div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="active" name="active" value="1" checked>
                            <label class="form-check-label fw-bold" for="active">
                                Active Product
                            </label>
                            <div class="form-text">Available for purchase</div>
                        </div>
                    </div>
                </div>



                <!-- Media Upload Section -->
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <h6 class="text-warning mb-3"><i class="fa fa-images me-2"></i>Product Media</h6>
                    </div>

                    <!-- Thumbnail Upload -->
                    <div class="col-md-6">
                        <label for="thumbnail" class="form-label fw-bold">
                            Product Thumbnail <span class="text-danger">*</span>
                        </label>
                        <div class="text-center mb-3">
                            <img id="thumbnailPreview" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUwIiBoZWlnaHQ9IjE1MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjhmOWZhIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNiIgZmlsbD0iIzk5YTNhZiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPk5vIEltYWdlPC90ZXh0Pjwvc3ZnPg=="
                                 class="img-thumbnail rounded" style="width: 150px; height: 150px; object-fit: cover; border: 2px dashed #dee2e6;">
                        </div>
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" onchange="previewThumbnail(this);">
                        <input type="hidden" id="selected_thumbnail_path" name="selected_thumbnail_path" value="">
                        <div class="form-text">Recommended: 500x500px, JPG, PNG (Max: 2MB) or select from gallery below</div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Gallery Images -->
                    <div class="col-md-6">
                        <label for="images" class="form-label fw-bold">Gallery Images</label>
                        <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple onchange="previewGallery(this);">
                        <div class="form-text">Multiple images allowed (Max: 5MB each)</div>
                        <div id="galleryPreview" class="mt-2 d-flex flex-wrap gap-2"></div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <!-- Digital Product Settings - Premium -->
                <div class="row g-3 mb-4 digital-options" style="display: block; background: linear-gradient(135deg, #f0f7ff 0%, #f8f9fa 100%); border-radius: 16px; border: 1px solid #e3e8f0;">
                    <div class="col-12">
                        <h6 class="text-primary mb-3" style="border-bottom-color: #007bff;"><i class="fa fa-download me-2"></i>Digital Product Settings</h6>
                        <p class="text-muted small mb-3">Configure delivery options. Download URL is optional - you can deliver manually after purchase.</p>
                    </div>

                    <div class="col-md-6">
                        <label for="file_url" class="form-label fw-bold">Download File URL <span class="badge bg-secondary">Optional</span></label>
                        <input type="url" class="form-control" id="file_url" name="file_url" placeholder="https://example.com/download/file.zip">
                        <div class="form-text">Direct download link for customers (not required)</div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="preview_url" class="form-label fw-bold">Preview URL (Optional)</label>
                        <input type="url" class="form-control" id="preview_url" name="preview_url" placeholder="https://example.com/preview/demo.mp4">
                        <div class="form-text">URL for product preview/demo</div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Video Add Options - Premium Feature -->
                    <div class="col-12 mt-4 pt-3" style="border-top: 1px dashed #ced4da;">
                        <h6 class="text-success mb-3"><i class="fa fa-video-camera me-2"></i>Product Video <span class="badge bg-success">New</span></h6>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="video_type" class="form-label fw-bold">Video Type</label>
                                <select name="video_type" id="video_type" class="form-control">
                                    <option value="none">No Video</option>
                                    <option value="youtube">YouTube Link</option>
                                    <option value="upload">Upload Video File (Manual)</option>
                                </select>
                            </div>

                            <!-- YouTube Section -->
                            <div class="col-md-8" id="youtube_section" style="display: none;">
                                <label for="video_url_youtube" class="form-label fw-bold">YouTube Video URL</label>
                                <input type="url" class="form-control" id="video_url_youtube" name="video_url" placeholder="https://www.youtube.com/watch?v=xxxxxxxx">
                                <div class="form-text">Full YouTube video link (embed will be auto-generated)</div>
                            </div>

                            <!-- Manual Upload Section -->
                            <div class="col-md-8" id="upload_section" style="display: none;">
                                <label for="video_file" class="form-label fw-bold">Upload Video File</label>
                                <input type="file" class="form-control" id="video_file" name="video_file" accept="video/*">
                                <div class="form-text">MP4, WebM, MOV, AVI supported. Max size 50MB. Video will be hosted on your server.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save me-2"></i>Create Product
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" style="display: none; background: rgba(0,0,0,0.7); z-index: 9999; position: fixed; top: 0; left: 0; width: 100%; height: 100%; align-items: center; justify-content: center;">
        <div class="text-center text-white">
            <div class="spinner-border mb-3" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h5>Creating Product...</h5>
            <p class="mb-0">Please wait while we process your request</p>
        </div>
    </div>

    <!-- Progress Bar - Force hidden on page load to prevent showing default -->
    <div id="progressContainer" class="d-none position-fixed bottom-0 end-0 p-3" style="z-index: 10000; display: none;">
        <div class="bg-white rounded shadow p-2">
            <div class="progress mb-2" style="width: 300px; height: 20px;">
                <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar" style="width: 0%">0%</div>
            </div>
        </div>
    </div>
</section>


</section>

<!-- SweetAlert2 for success notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- CKEditor 5 WYSIWYG - Premium Rich Text Editor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

<!-- Bootstrap Tags Input -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />

<style>
    /* Form Styling */
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border-radius: 0.375rem;
        border: 1px solid #ced4da;
        padding: 0.75rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: #ced4da;
    }

    /* Section Headers */
    h6 {
        font-weight: 600;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 0.5rem;
    }

    .text-primary h6 { border-bottom-color: #007bff; }
    .text-success h6 { border-bottom-color: #28a745; }
    .text-info h6 { border-bottom-color: #17a2b8; }
    .text-warning h6 { border-bottom-color: #ffc107; }

    /* Image Previews */
    #thumbnailPreview {
        border: 2px dashed #dee2e6 !important;
        background-color: #f8f9fa;
    }

    #galleryPreview img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
    }

    .gallery-image-item {
        display: inline-block;
        position: relative;
        margin: 3px;
        transition: transform 0.2s;
    }

    .gallery-image-item:hover {
        transform: scale(1.05);
    }

    .gallery-image-item img {
        cursor: pointer;
    }

    .gallery-image-item img:hover {
        opacity: 0.8;
    }

    /* Digital Options */
    .digital-options {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
        padding: 1rem;
    }

    /* Bootstrap Tags Input */
    .bootstrap-tagsinput {
        width: 100%;
        min-height: 38px;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
    }

    .bootstrap-tagsinput .tag {
        background-color: #007bff;
        color: white;
        border-radius: 0.25rem;
        padding: 0.25rem 0.5rem;
        margin-right: 0.25rem;
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
    }

    /* Validation Styles */
    .is-valid {
        border-color: #28a745 !important;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .valid-feedback {
        display: block;
        color: #28a745;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Loading States */
    .btn:disabled {
        opacity: 0.65;
    }

    /* Card Styling */
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }

    .card-header {
        background-color: #007bff;
        color: white;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
        }

        .d-flex.justify-content-end {
            justify-content: center !important;
        }
    }

    /* ========== PREMIUM UI ENHANCEMENTS ========== */
    .form-control, .form-select {
        border-radius: 10px !important;
        padding: 0.65rem 0.9rem;
        border: 1px solid #d1d9e0;
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1);
        transform: translateY(-1px);
    }

    .digital-options {
        box-shadow: 0 8px 25px rgba(0, 123, 255, 0.08);
    }

    #detailed_description {
        border-radius: 12px;
    }

    /* Video sections premium */
    #youtube_section, #upload_section {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 25px 70px rgba(0,0,0,0.1);
    }

    .badge {
        font-weight: 500;
        padding: 0.35em 0.6em;
    }

    /* CKEditor premium look */
    .ck-editor__editable {
        border-radius: 0 0 12px 12px !important;
    }
    .ck.ck-editor__top .ck-toolbar {
        border-radius: 12px 12px 0 0 !important;
        background: #f8f9fa !important;
    }

    /* Section headers premium */
    h6 {
        font-size: 1rem;
        letter-spacing: 0.3px;
    }
</style>
<script>
$(document).ready(function() {
    // Force hide progress bar on initial page load (prevents default visible state)
    $('#progressContainer').addClass('d-none').css('display', 'none');

    // Custom validation functions
    window.customValidators = {
        validateRequired: function(value, fieldName) {
            if (!value || (typeof value === 'string' && value.trim() === '')) {
                return { valid: false, message: fieldName + ' is required' };
            }
            return { valid: true, message: '' };
        },
        validateMinLength: function(value, minLength, fieldName) {
            if (value && value.length < minLength) {
                return { valid: false, message: fieldName + ' must be at least ' + minLength + ' characters' };
            }
            return { valid: true, message: '' };
        },
        validateNumeric: function(value, fieldName) {
            if (value && isNaN(value)) {
                return { valid: false, message: fieldName + ' must be a valid number' };
            }
            return { valid: true, message: '' };
        },
        validateMinValue: function(value, minValue, fieldName) {
            if (value && parseFloat(value) < minValue) {
                return { valid: false, message: fieldName + ' must be at least ' + minValue };
            }
            return { valid: true, message: '' };
        },
        validateFileSize: function(fileInput, maxSizeBytes) {
            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                return { valid: true, message: '' };
            }
            const file = fileInput.files[0];
            if (file.size > maxSizeBytes) {
                const maxSizeMB = (maxSizeBytes / (1024 * 1024)).toFixed(1);
                return { valid: false, message: 'File size must be less than ' + maxSizeMB + 'MB' };
            }
            return { valid: true, message: '' };
        },
        validateFileExtension: function(fileInput, allowedExtensions) {
            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                return { valid: true, message: '' };
            }
            const file = fileInput.files[0];
            const extension = file.name.split('.').pop().toLowerCase();
            if (!allowedExtensions.includes(extension)) {
                return { valid: false, message: 'Please select a valid file type (' + allowedExtensions.join(', ') + ')' };
            }
            return { valid: true, message: '' };
        }
    };

    // Initialize form components
    initializeForm();

    // Form validation function
    function validateProductForm() {
        let isValid = true;
        const errors = [];

        // Clear previous errors
        $('.invalid-feedback').html('').hide();
        $('.is-invalid').removeClass('is-invalid');
        $('.is-valid').removeClass('is-valid');

        // Validate product name
        const nameResult = window.customValidators.validateRequired($('#name').val(), 'Product name');
        if (!nameResult.valid) {
            errors.push(nameResult.message);
            showFieldError('#name', nameResult.message);
            isValid = false;
        } else {
            const lengthResult = window.customValidators.validateMinLength($('#name').val(), 2, 'Product name');
            if (!lengthResult.valid) {
                errors.push(lengthResult.message);
                showFieldError('#name', lengthResult.message);
                isValid = false;
            } else {
                $('#name').addClass('is-valid');
            }
        }

        // Validate slug
        const slugResult = window.customValidators.validateRequired($('#slug').val(), 'URL slug');
        if (!slugResult.valid) {
            errors.push(slugResult.message);
            showFieldError('#slug', slugResult.message);
            isValid = false;
        } else {
            const slugLengthResult = window.customValidators.validateMinLength($('#slug').val(), 2, 'URL slug');
            if (!slugLengthResult.valid) {
                errors.push(slugLengthResult.message);
                showFieldError('#slug', slugLengthResult.message);
                isValid = false;
            } else {
                $('#slug').addClass('is-valid');
            }
        }

        // Validate price
        const priceResult = window.customValidators.validateRequired($('#price').val(), 'Price');
        if (!priceResult.valid) {
            errors.push(priceResult.message);
            showFieldError('#price', priceResult.message);
            isValid = false;
        } else {
            const numericResult = window.customValidators.validateNumeric($('#price').val(), 'Price');
            if (!numericResult.valid) {
                errors.push(numericResult.message);
                showFieldError('#price', numericResult.message);
                isValid = false;
            } else {
                const minValueResult = window.customValidators.validateMinValue($('#price').val(), 0, 'Price');
                if (!minValueResult.valid) {
                    errors.push(minValueResult.message);
                    showFieldError('#price', minValueResult.message);
                    isValid = false;
                } else {
                    $('#price').addClass('is-valid');
                }
            }
        }

        // Validate compare price (optional)
        if ($('#compare_price').val()) {
            const compareNumericResult = window.customValidators.validateNumeric($('#compare_price').val(), 'Compare price');
            if (!compareNumericResult.valid) {
                errors.push(compareNumericResult.message);
                showFieldError('#compare_price', compareNumericResult.message);
                isValid = false;
            } else {
                const compareMinResult = window.customValidators.validateMinValue($('#compare_price').val(), 0, 'Compare price');
                if (!compareMinResult.valid) {
                    errors.push(compareMinResult.message);
                    showFieldError('#compare_price', compareMinResult.message);
                    isValid = false;
                } else {
                    $('#compare_price').addClass('is-valid');
                }
            }
        }

        // Validate stock
        const stockResult = window.customValidators.validateRequired($('#stock').val(), 'Stock quantity');
        if (!stockResult.valid) {
            errors.push(stockResult.message);
            showFieldError('#stock', stockResult.message);
            isValid = false;
        } else {
            const stockNumericResult = window.customValidators.validateNumeric($('#stock').val(), 'Stock quantity');
            if (!stockNumericResult.valid) {
                errors.push(stockNumericResult.message);
                showFieldError('#stock', stockNumericResult.message);
                isValid = false;
            } else {
                const stockMinResult = window.customValidators.validateMinValue($('#stock').val(), 0, 'Stock quantity');
                if (!stockMinResult.valid) {
                    errors.push(stockMinResult.message);
                    showFieldError('#stock', stockMinResult.message);
                    isValid = false;
                } else {
                    $('#stock').addClass('is-valid');
                }
            }
        }

        // Validate category
        const categoryResult = window.customValidators.validateRequired($('#category').val(), 'Category');
        if (!categoryResult.valid) {
            errors.push(categoryResult.message);
            showFieldError('#category', categoryResult.message);
            isValid = false;
        } else {
            $('#category').addClass('is-valid');
        }

        // Validate digital type
        const digitalResult = window.customValidators.validateRequired($('#digital').val(), 'Product type');
        if (!digitalResult.valid) {
            errors.push(digitalResult.message);
            showFieldError('#digital', digitalResult.message);
            isValid = false;
        }

        // Validate thumbnail
        const hasThumbnailFile = $('#thumbnail')[0] && $('#thumbnail')[0].files && $('#thumbnail')[0].files.length > 0;
        const hasGalleryThumbnail = $('#selected_thumbnail_path').val() !== '';
        
        if (!hasThumbnailFile && !hasGalleryThumbnail) {
            errors.push('Thumbnail image is required');
            showFieldError('#thumbnail', 'Please select a thumbnail image or choose from gallery below');
            isValid = false;
        } else if (hasThumbnailFile) {
            // Check file size and extension only when file is uploaded
            const sizeResult = window.customValidators.validateFileSize($('#thumbnail')[0], 2*1024*1024);
            if (!sizeResult.valid) {
                errors.push(sizeResult.message);
                showFieldError('#thumbnail', sizeResult.message);
                isValid = false;
            } else {
                const extResult = window.customValidators.validateFileExtension($('#thumbnail')[0], ['jpg', 'jpeg', 'png', 'gif']);
                if (!extResult.valid) {
                    errors.push(extResult.message);
                    showFieldError('#thumbnail', extResult.message);
                    isValid = false;
                } else {
                    $('#thumbnail').addClass('is-valid');
                }
            }
        } else if (hasGalleryThumbnail) {
            // Valid - thumbnail selected from gallery
            $('#thumbnail').addClass('is-valid');
        }

        // Validate gallery images (optional)
        if ($('#images')[0] && $('#images')[0].files && $('#images')[0].files.length > 0) {
            for (let i = 0; i < $('#images')[0].files.length; i++) {
                const sizeResult = window.customValidators.validateFileSize({files: [$('#images')[0].files[i]]}, 5*1024*1024);
                if (!sizeResult.valid) {
                    errors.push(`Gallery image ${i+1}: ${sizeResult.message}`);
                    showFieldError('#images', sizeResult.message);
                    isValid = false;
                    break;
                }

                const extResult = window.customValidators.validateFileExtension({files: [$('#images')[0].files[i]]}, ['jpg', 'jpeg', 'png', 'gif']);
                if (!extResult.valid) {
                    errors.push(`Gallery image ${i+1}: ${extResult.message}`);
                    showFieldError('#images', extResult.message);
                    isValid = false;
                    break;
                }
            }
            if (isValid) {
                $('#images').addClass('is-valid');
            }
        }

        // Note: Download file URL is now optional for digital products
        // Validate URL format only if provided
        if ($('#file_url').val()) {
            const urlPattern = /^https?:\/\/.+/;
            if (!urlPattern.test($('#file_url').val())) {
                errors.push('Download URL must be a valid URL starting with http:// or https://');
                showFieldError('#file_url', 'Please enter a valid URL');
                isValid = false;
            } else {
                $('#file_url').addClass('is-valid');
            }
        }

        return { isValid: isValid, errors: errors };
    }

    // Helper function to show field errors
    function showFieldError(selector, message) {
        const field = $(selector);
        const feedback = field.closest('.col-md-6, .col-md-12, .col-md-4').find('.invalid-feedback');

        field.addClass('is-invalid');
        feedback.html('<i class="fa fa-exclamation-triangle"></i> ' + message).fadeIn(300);

        // Shake animation
        field.closest('.col-md-6, .col-md-12, .col-md-4').addClass('shake');
        setTimeout(() => {
            field.closest('.col-md-6, .col-md-12, .col-md-4').removeClass('shake');
        }, 500);
    }

    function initializeForm() {
        // Initialize Tags Input
        $('#tags').tagsinput();

        // Initialize Premium WYSIWYG Editor (CKEditor 5)
        if (typeof ClassicEditor !== 'undefined') {
            ClassicEditor
                .create(document.querySelector('#detailed_description'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'insertTable', 'mediaEmbed', 'undo', 'redo'],
                    placeholder: 'Enter detailed product description with rich formatting...'
                })
                .then(editor => {
                    window.detailedEditor = editor;
                    // Premium editor styling
                    editor.ui.view.editable.element.style.minHeight = '220px';
                    editor.ui.view.editable.element.style.borderRadius = '8px';
                })
                .catch(error => {
                    console.warn('CKEditor failed to initialize, falling back to textarea:', error);
                });
        } else {
            console.log('CKEditor not loaded, using plain textarea for detailed_description');
        }

        // Auto-generate slug from name
        $('#name').on('input', function() {
            var name = $(this).val();
            var slug = name.toLowerCase()
                            .replace(/[^a-z0-9\s]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-')
                            .trim('-');
            $('#slug').val(slug);
        });

        // Show/hide digital options based on product type
        $('#digital').on('change', function() {
            if ($(this).val() == '1') {
                $('.digital-options').slideDown(300);
            } else {
                $('.digital-options').slideUp(300);
            }
        });

        // Video type toggle - premium video options
        $('#video_type').on('change', function() {
            const type = $(this).val();
            $('#youtube_section').hide();
            $('#upload_section').hide();
            $('#video_url_youtube').prop('required', false);
            $('#video_file').prop('required', false);

            if (type === 'youtube') {
                $('#youtube_section').slideDown(200);
                // clear upload if switching
                $('#video_file').val('');
            } else if (type === 'upload') {
                $('#upload_section').slideDown(200);
                $('#video_url_youtube').val('');
            }
        });

        // Initialize video type UI on load (if editing values in future)
        const initialVideoType = $('#video_type').val();
        if (initialVideoType === 'youtube') {
            $('#youtube_section').show();
        } else if (initialVideoType === 'upload') {
            $('#upload_section').show();
        }

        // Form submission with custom validation
        $('#productForm').on('submit', function(e) {
            e.preventDefault();

            // Sync WYSIWYG editor content before validation/submit
            if (window.detailedEditor) {
                $('#detailed_description').val(window.detailedEditor.getData());
            }

            // Validate the form
            const validation = validateProductForm();

            if (!validation.isValid) {
                // Show validation errors
                if (validation.errors.length > 0) {
                    // $('#formAlert').html('<div class="alert alert-danger alert-dismissible fade show">' +
                    //     '<i class="fa fa-times-circle"></i>' +
                    //     '<strong>Please fix the following errors:</strong>' +
                    //     '<ul class="mb-0 mt-2">' +
                    //     validation.errors.map(error => '<li>' + error + '</li>').join('') +
                    //     '</ul>' +
                    //     '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                    //     '</div>').fadeIn(300);

                    // Scroll to first error
                    const firstError = $('.is-invalid').first();
                    if (firstError.length) {
                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 100
                        }, 500);
                    }
                }
                return false;
            }

            // Form is valid, proceed with AJAX submission
            submitProductForm();
        });

        // AJAX form submission function
        function submitProductForm() {
            const form = $('#productForm')[0];
            const formData = new FormData(form);

            // Show loading overlay
            $('#loadingOverlay').css('display', 'flex');

            $.ajax({
                url: $(form).attr("action"),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            $('#progressBar').css('width', percentComplete + '%').text(Math.round(percentComplete) + '%');
                        }
                    }, false);
                    return xhr;
                },
                beforeSend: function() {
                    // Clear previous alerts
                    $('#formAlert').fadeOut().empty();
                    $('.invalid-feedback').html('').hide();
                    $('.is-invalid').removeClass('is-invalid');
                    $('.is-valid').removeClass('is-valid');

                    // Update submit button
                    const submitBtn = $("button[type='submit']");
                    submitBtn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin me-2"></i>Creating Product...');

                    // Show progress bar (force visible)
                    $('#progressContainer').removeClass('d-none').css('display', 'block');
                    $('#progressBar').css('width', '0%').text('0%');
                },
                success: function(response) {
                    $('#loadingOverlay').css('display', 'none');

                    $('#progressBar')
                        .removeClass('progress-bar-striped progress-bar-animated bg-danger')
                        .addClass('bg-success')
                        .css('width', '100%')
                        .text('100% - Complete!');

                    setTimeout(() => {
                        $('#progressContainer').addClass('d-none').css('display', 'none');

                        $('#progressBar')
                            .removeClass('bg-success')
                            .addClass('progress-bar-striped progress-bar-animated')
                            .css('width', '0%')
                            .text('0%');

                        toastr.success('Product created successfully.', 'Success!');
                        setTimeout(() => {
                            window.location.href = '{{ route("admin.products.index") }}';
                        }, 1500);
                    }, 650);
                },
                error: function(xhr) {
                    $('#loadingOverlay').css('display', 'none');

                    if(xhr.status === 422){
                        let errors = xhr.responseJSON.errors;
                        let errorCount = 0;

                        $.each(errors, function(field, messages){
                            errorCount++;
                            let input = $(`[name="${field}"]`);
                            if (!input.length) {
                                input = $(`[name="${field}[]"]`);
                            }
                            showFieldError(`[name="${field}"]`, messages[0]);
                        });

                        if (errorCount > 0) {
                            $('#formAlert').html('<div class="alert alert-danger alert-dismissible fade show">' +
                                '<i class="fa fa-times-circle"></i>' +
                                '<strong>Please fix the ' + errorCount + ' server validation error' + (errorCount > 1 ? 's' : '') + '.</strong>' +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                                '</div>').fadeIn(300);
                        }
                        toastr.error('Please fix the validation errors.', 'Validation Failed');
                        $('#progressBar').addClass('bg-danger').css('width', '100%').text('Validation Failed');
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong. Please try again.', 'Server Error');
                        $('#progressBar').addClass('bg-danger').css('width', '100%').text('Server Error');

                        $('#formAlert').html('<div class="alert alert-danger alert-dismissible fade show">' +
                            '<i class="fa fa-times-circle"></i>' +
                            '<strong>Server Error:</strong> ' + (xhr.responseJSON?.message || 'Something went wrong. Please try again.') +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                            '</div>').fadeIn(300);
                    }
                },
                complete: function() {
                    $('#loadingOverlay').css('display', 'none');
                    const submitBtn = $("button[type='submit']");
                    submitBtn.prop("disabled", false).html('<i class="fa fa-save me-2"></i>Create Product');

                    // Hide progress after a delay (force hidden)
                    setTimeout(() => {
                        $('#progressContainer').addClass('d-none').css('display', 'none');
                    }, 2000);
                }
            });
        }
    }

    // Initialize form after page load
    initializeForm();

    // Image preview functions
    window.previewThumbnail = function(input) {
        if (!input || !input.files || input.files.length === 0) return;

        const file = input.files[0];
        const previewImg = $("#thumbnailPreview");

        if (file && previewImg.length) {
            // Show loading indicator for preview
            previewImg.css('opacity', '0.5');

            // Clear gallery selection when uploading file
            document.getElementById('selected_thumbnail_path').value = '';

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.attr("src", e.target.result).css('opacity', '1');

                // Validate file size
                if (file.size > 2*1024*1024) { // 2MB
                    $(input).addClass('is-invalid');
                    $(input).closest('.col-md-6').find('.invalid-feedback').html('<i class="fa fa-exclamation-triangle"></i> File size must be less than 2MB');
                } else {
                    $(input).removeClass('is-invalid').addClass('is-valid');
                    $(input).closest('.col-md-6').find('.invalid-feedback').html('');
                }
            };
            reader.readAsDataURL(file);
        }
    };

    window.previewGallery = function(input) {
        if (!input || !input.files) return;

        const files = input.files;
        const galleryPreview = $('#galleryPreview');

        if (galleryPreview.length) {
            galleryPreview.empty();

            if (files.length > 0) {
                let validFiles = 0;
                let invalidFiles = 0;

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];

                    if (file.size > 5*1024*1024) {
                        invalidFiles++;
                        continue;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgHtml = `<div class="position-relative gallery-image-item" data-index="${i}">
                            <img src="${e.target.result}" class="img-thumbnail set-as-thumbnail" style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;" title="Click to set as thumbnail" onclick="setAsThumbnailFromGallery(this)">
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle" style="font-size: 10px; cursor: pointer;" onclick="event.stopPropagation(); removeGalleryImage(this);">&times;</span>
                        </div>`;
                        galleryPreview.append(imgHtml);
                    };
                    reader.readAsDataURL(file);
                    validFiles++;
                }

                const feedbackEl = $(input).closest('.col-md-6').find('.invalid-feedback');
                if (invalidFiles > 0) {
                    $(input).addClass('is-invalid');
                feedbackEl.html('<i class="fa fa-exclamation-triangle"></i> ' + invalidFiles + ' file' + (invalidFiles > 1 ? 's' : '') + ' exceed the 5MB limit');
                } else if (validFiles > 0) {
                    $(input).removeClass('is-invalid').addClass('is-valid');
                    feedbackEl.html('');
                }
            }
        }
    };

    window.setAsThumbnailFromGallery = function(element) {
        const previewImg = $("#thumbnailPreview");
        const hiddenInput = $("#selected_thumbnail_path");
        
        const dataUrl = $(element).attr('src');
        previewImg.attr("src", dataUrl);
        
        const index = $(element).closest('.gallery-image-item').data('index');
        hiddenInput.val('gallery_index_' + index);
        
        $('.gallery-image-item').removeClass('border border-warning border-2');
        $(element).closest('.gallery-image-item').addClass('border border-warning border-2');
        
        const thumbnailInput = $("#thumbnail");
        thumbnailInput.val('');
        thumbnailInput.removeClass('is-invalid is-valid');
    };

    window.removeGalleryImage = function(button) {
        event.stopPropagation();
        $(button).closest('.gallery-image-item').remove();
    };
});

// Add shake animation CSS
const shakeKeyframes = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    .shake { animation: shake 0.5s ease-in-out; }
`;

// Add shake animation to head if not already present
if (!$('#shake-keyframes').length) {
    $('head').append(`<style id="shake-keyframes">${shakeKeyframes}</style>`);
}
</script>

@endsection