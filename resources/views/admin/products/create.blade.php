@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background-color: #fff; padding: 20px;">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fa fa-plus-circle text-primary me-2"></i>Create New Product</h2>
                    <p class="text-muted mb-0">Add a new product to your digital marketplace</p>
                </div>
                <a class="btn btn-secondary" href="{{ route('admin.products.index') }}">
                    <i class="fa fa-arrow-left me-2"></i>Back to Products
                </a>
            </div>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fa fa-box me-2"></i>Product Information</h5>
        </div>
        <div class="card-body p-4">
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

                    <!-- Detailed Description -->
                    <div class="col-md-6">
                        <label for="detailed_description" class="form-label fw-bold">Detailed Description</label>
                        <textarea class="form-control" id="detailed_description" name="detailed_description" rows="3" placeholder="Detailed product information, features, etc."></textarea>
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
                        <div class="form-text">Recommended: 500x500px, JPG, PNG (Max: 2MB)</div>
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

                <!-- Digital Product Settings -->
                <div class="row g-3 mb-4 digital-options" style="display: block;">
                    <div class="col-12">
                        <h6 class="text-primary mb-3"><i class="fa fa-download me-2"></i>Digital Product Settings</h6>
                    </div>

                    <div class="col-md-6">
                        <label for="file_url" class="form-label fw-bold">Download File URL</label>
                        <input type="url" class="form-control" id="file_url" name="file_url" placeholder="https://example.com/download/file.zip">
                        <div class="form-text">URL where customers can download the product</div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="preview_url" class="form-label fw-bold">Preview URL (Optional)</label>
                        <input type="url" class="form-control" id="preview_url" name="preview_url" placeholder="https://example.com/preview/demo.mp4">
                        <div class="form-text">URL for product preview/demo</div>
                        <div class="invalid-feedback"></div>
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

    <!-- Progress Bar -->
    <div id="progressContainer" class="d-none position-fixed bottom-0 end-0 p-3" style="z-index: 10000;">
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
</style>
<script>
$(document).ready(function() {
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
        const thumbnailResult = window.customValidators.validateRequired($('#thumbnail')[0], 'Thumbnail image');
        if (!thumbnailResult.valid) {
            errors.push(thumbnailResult.message);
            showFieldError('#thumbnail', thumbnailResult.message);
            isValid = false;
        } else {
            // Check file size and extension
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

        // Validate digital product fields if digital
        if ($('#digital').val() == '1') {
            const fileUrlResult = window.customValidators.validateRequired($('#file_url').val(), 'Download URL');
            if (!fileUrlResult.valid) {
                errors.push(fileUrlResult.message);
                showFieldError('#file_url', fileUrlResult.message);
                isValid = false;
            } else {
                // Basic URL validation
                const urlPattern = /^https?:\/\/.+/;
                if (!urlPattern.test($('#file_url').val())) {
                    errors.push('Download URL must be a valid URL starting with http:// or https://');
                    showFieldError('#file_url', 'Please enter a valid URL');
                    isValid = false;
                } else {
                    $('#file_url').addClass('is-valid');
                }
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

        // Form submission with custom validation
        $('#productForm').on('submit', function(e) {
            e.preventDefault();

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

                    // Show progress bar
                    $('#progressContainer').removeClass('d-none');
                    $('#progressBar').css('width', '0%').text('0%');
                },
                success: function(response) {
                    $('#loadingOverlay').css('display', 'none');

                    // Success animation
                    $('#progressBar').addClass('bg-success').css('width', '100%').text('Complete!');

                    setTimeout(() => {
                        // Show success message using SweetAlert2 if available, otherwise redirect
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                html: '<div class="text-center"><i class="fa fa-check-circle" style="font-size:56px;color:#28a745"></i><h3 style="margin-top:8px;margin-bottom:6px;">Success!</h3><div>Product created successfully.</div></div>',
                                showConfirmButton: true,
                                confirmButtonText: 'View Products',
                                customClass: { popup: 'shadow-lg rounded-3' },
                                timer: 3000,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.href = '{{ route("admin.products.index") }}';
                            });
                        } else {
                            window.location.href = '{{ route("admin.products.index") }}';
                        }
                    }, 500);
                },
                error: function(xhr) {
                    $('#loadingOverlay').css('display', 'none');

                    if(xhr.status === 422){
                        // Server validation errors
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

                        // Show summary alert
                        if (errorCount > 0) {
                            $('#formAlert').html('<div class="alert alert-danger alert-dismissible fade show">' +
                                '<i class="fa fa-times-circle"></i>' +
                                '<strong>Please fix the ' + errorCount + ' server validation error' + (errorCount > 1 ? 's' : '') + '.</strong>' +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                                '</div>').fadeIn(300);
                        }

                        // Update progress bar to show error
                        $('#progressBar').addClass('bg-danger').css('width', '100%').text('Validation Failed');

                    } else {
                        // Server error
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

                    // Hide progress after a delay
                    setTimeout(() => {
                        $('#progressContainer').addClass('d-none');
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

                    // Check file size (5MB limit)
                    if (file.size > 5*1024*1024) {
                        invalidFiles++;
                        continue;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        galleryPreview.append(`<img src="${e.target.result}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">`);
                    };
                    reader.readAsDataURL(file);
                    validFiles++;
                }

                // Show validation feedback
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