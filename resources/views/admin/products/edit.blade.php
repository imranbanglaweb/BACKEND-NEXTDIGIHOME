@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background-color: #fff; padding: 20px;">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fa fa-edit text-warning me-2"></i>Edit Product</h2>
                    <p class="text-muted mb-0">Update product information: <strong>{{ $product->name }}</strong></p>
                </div>
                <div class="btn-group">
                    <a class="btn btn-info" href="{{ route('admin.products.show', $product) }}">
                        <i class="fa fa-eye me-2"></i>View Product
                    </a>
                    <a class="btn btn-secondary" href="{{ route('admin.products.index') }}">
                        <i class="fa fa-arrow-left me-2"></i>Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fa fa-times-circle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Form Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0"><i class="fa fa-box me-2"></i>Product Information</h5>
        </div>
        <div class="card-body p-4">
            <!-- Alert Container -->
            <div id="formAlert"></div>

            <form id="productForm" action="{{ route('admin.products.update', $product) }}" method="post" enctype="multipart/form-data" data-has-existing-thumbnail="{{ $product->thumbnail ? 'true' : 'false' }}">
                @csrf
                @method('PUT')

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
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" placeholder="Enter product name">
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- URL Slug -->
                    <div class="col-md-6">
                        <label for="slug" class="form-label fw-bold">
                            URL Slug <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" placeholder="product-url-slug">
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
                            @foreach(\App\Models\Category::orderBy('category_name')->get() as $category)
                                <option value="{{ $category->category_name }}" {{ old('category', $product->category) == $category->category_name ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Product Type -->
                    <div class="col-md-6">
                        <label for="digital" class="form-label fw-bold">
                            Product Type <span class="text-danger">*</span>
                        </label>
                        <select name="digital" id="digital" class="form-control">
                            <option value="1" {{ old('digital', $product->digital) == '1' ? 'selected' : '' }}>Digital Product</option>
                            <option value="0" {{ old('digital', $product->digital) == '0' ? 'selected' : '' }}>Physical Product</option>
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
                            <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" placeholder="0.00">
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Compare Price -->
                    <div class="col-md-4">
                        <label for="compare_price" class="form-label fw-bold">Compare Price</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" min="0" class="form-control" id="compare_price" name="compare_price" value="{{ old('compare_price', $product->compare_price) }}" placeholder="0.00">
                        </div>
                        <div class="form-text">Original price (shows crossed out)</div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Stock -->
                    <div class="col-md-4">
                        <label for="stock" class="form-label fw-bold">
                            Stock Quantity <span class="text-danger">*</span>
                        </label>
                        <input type="number" min="0" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" placeholder="0">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                    {{-- Category --}}
                    <div class="col-md-6">
                        <label for="category" class="form-label"><strong>Category <span class="text-danger">*</span></strong></label>
                        <select name="category" id="category" class="form-control select2">
                            <option value="">Select Category</option>
                            <option value="Education" {{ old('category', $product->category) == 'Education' ? 'selected' : '' }}>Education</option>
                            <option value="Templates" {{ old('category', $product->category) == 'Templates' ? 'selected' : '' }}>Templates</option>
                            <option value="Electronics" {{ old('category', $product->category) == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                            <option value="Graphics" {{ old('category', $product->category) == 'Graphics' ? 'selected' : '' }}>Graphics</option>
                            <option value="Software" {{ old('category', $product->category) == 'Software' ? 'selected' : '' }}>Software</option>
                            <option value="Books" {{ old('category', $product->category) == 'Books' ? 'selected' : '' }}>Books</option>
                            <option value="Music" {{ old('category', $product->category) == 'Music' ? 'selected' : '' }}>Music</option>
                            <option value="Video" {{ old('category', $product->category) == 'Video' ? 'selected' : '' }}>Video</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Product Type --}}
                    <div class="col-md-6">
                        <label for="digital" class="form-label"><strong>Product Type <span class="text-danger">*</span></strong></label>
                        <select name="digital" id="digital" class="form-control select2">
                            <option value="1" {{ old('digital', $product->digital) == '1' ? 'selected' : '' }}>Digital Product</option>
                            <option value="0" {{ old('digital', $product->digital) == '0' ? 'selected' : '' }}>Physical Product</option>
                        </select>
                        <small class="form-text text-muted">Digital products are delivered via download</small>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label for="description" class="form-label"><strong>Description</strong></label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Brief product description">{{ old('description', $product->description) }}</textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Detailed Description with Premium WYSIWYG --}}
                    <div class="col-md-12">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                            <label for="detailed_description" class="form-label mb-0"><strong>Detailed Description</strong> <span class="text-muted small">(Rich Editor)</span></label>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="applyPremiumProductTemplate(false)">
                                <i class="fa fa-layer-group me-1"></i> Apply Premium Template
                            </button>
                        </div>
                        <textarea class="form-control" id="detailed_description" name="detailed_description" rows="6" placeholder="Detailed product information, features, etc.">{{ old('detailed_description', $product->detailed_description) }}</textarea>
                        <small class="form-text text-muted">Use one reusable premium structure for eBooks, SaaS, source code, templates, AI prompts, and other digital products.</small>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Tags --}}
                    <div class="col-md-6">
                        <label for="tags" class="form-label"><strong>Tags</strong></label>
                        <input type="text" class="form-control" id="tags" name="tags" value="{{ old('tags', is_array($product->tags) ? implode(',', $product->tags) : $product->tags) }}" placeholder="e-commerce, marketing, tools" data-role="tagsinput">
                        <small class="form-text text-muted">Comma-separated tags for better search</small>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Featured & Active --}}
                    <div class="col-md-6">
                        <label class="form-label"><strong>Display Options</strong></label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">
                                <strong>Featured Product</strong>
                            </label>
                            <small class="form-text text-muted d-block">Show in featured products section</small>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="active" name="active" value="1" {{ old('active', $product->active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">
                                <strong>Active Product</strong>
                            </label>
                            <small class="form-text text-muted d-block">Available for purchase</small>
                        </div>
                    </div>

                    {{-- Thumbnail Upload --}}
                    <div class="col-md-6">
                        <label class="form-label"><strong>Product Thumbnail</strong></label>
                        <div class="text-center mb-3">
                            <img id="thumbnailPreview" src="{{ $product->thumbnail ? asset('public/storage/' . $product->thumbnail) : 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUwIiBoZWlnaHQ9IjE1MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjhmOWZhIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNiIgZmlsbD0iIzk5YTNhZiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPk5vIEltYWdlPC90ZXh0Pjwvc3ZnPg==' }}" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover; border: 2px dashed #dee2e6;">
                        </div>
                        <input type="hidden" id="selected_thumbnail_path" name="selected_thumbnail_path" value="{{ $product->thumbnail }}">
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" onchange="previewThumbnail(this);">
                        <small class="form-text text-muted">
                            Leave empty to keep current image. Recommended: 500x500px, JPG, PNG (Max: 2MB)
                        </small>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Gallery Images --}}
                    <div class="col-md-6">
                        <label class="form-label"><strong>Gallery Images</strong></label>
                        <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple onchange="previewGallery(this);">
                         <small class="form-text text-muted">
                             Multiple images allowed. Leave empty to keep current images (Max: 5MB each)
                         </small>
                          @php
                              $images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
                          @endphp
                          @if($images && is_array($images))
                              <div class="mt-2">
                                  <small class="text-muted">Current images (click to set as thumbnail):</small>
                                  <div class="d-flex flex-wrap">
                                       @foreach($images as $index => $image)
                                          <div class="position-relative me-2 mb-2 gallery-image-item {{ $product->thumbnail == $image ? 'border border-warning border-2' : '' }}" data-image-path="{{ $image }}" data-index="{{ $index }}">
                                              <img src="{{ asset('public/storage/' . $image) }}" class="img-thumbnail set-as-thumbnail" style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;" title="Click to set as thumbnail" onclick="setAsThumbnail('{{ $image }}', this)">
                                              <span class="badge bg-warning position-absolute top-0 start-100 translate-middle" style="font-size: 10px; cursor: pointer;" onclick="event.stopPropagation(); removeGalleryImage(this, '{{ $image }}');">&times;</span>
                                          </div>
                                       @endforeach
                                     </div>
                              </div>
                          @endif
                        <div id="galleryPreview" class="mt-2"></div>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Digital Product Options - Premium with Video --}}
                    <div class="col-md-12 digital-options" style="{{ old('digital', $product->digital) ? 'display: block;' : 'display: none;' }}; background: linear-gradient(135deg, #f0f7ff 0%, #f8f9fa 100%); border-radius: 16px; border: 1px solid #e3e8f0; padding: 15px;">
                        <hr>
                        <h5 class="text-primary"><i class="fa fa-download"></i> Digital Product Settings</h5>
                        <p class="text-muted small">Download URL is now optional.</p>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="file_url" class="form-label"><strong>Download File URL</strong> <span class="badge bg-secondary">Optional</span></label>
                                <input type="url" class="form-control" id="file_url" name="file_url" value="{{ old('file_url', $product->file_url) }}" placeholder="https://example.com/download/file.zip">
                                <small class="form-text text-muted">URL where customers can download the product (not mandatory)</small>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="col-md-6">
                                <label for="preview_url" class="form-label"><strong>Preview URL (Optional)</strong></label>
                                <input type="url" class="form-control" id="preview_url" name="preview_url" value="{{ old('preview_url', $product->preview_url) }}" placeholder="https://example.com/preview/demo.mp4">
                                <small class="form-text text-muted">URL for product preview/demo</small>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <!-- Video Section for Edit -->
                        <div class="row mt-4 pt-3" style="border-top:1px dashed #ced4da;">
                            <div class="col-12">
                                <h6 class="text-success mb-2"><i class="fa fa-video-camera"></i> Product Video <span class="badge bg-success">New</span></h6>
                            </div>
                            <div class="col-md-4">
                                <label for="video_type" class="form-label"><strong>Video Type</strong></label>
                                <select name="video_type" id="video_type" class="form-control">
                                    <option value="none" {{ old('video_type', $product->video_type) == 'none' ? 'selected' : '' }}>No Video</option>
                                    <option value="youtube" {{ old('video_type', $product->video_type) == 'youtube' ? 'selected' : '' }}>YouTube Link</option>
                                    <option value="upload" {{ old('video_type', $product->video_type) == 'upload' ? 'selected' : '' }}>Upload Video File</option>
                                </select>
                            </div>
                            <div class="col-md-8" id="youtube_section" style="display: {{ old('video_type', $product->video_type) == 'youtube' ? 'block' : 'none' }};">
                                <label class="form-label"><strong>YouTube Video URL</strong></label>
                                <input type="url" class="form-control" id="video_url_youtube" name="video_url" value="{{ old('video_url', $product->video_type == 'youtube' ? $product->video_url : '') }}" placeholder="https://www.youtube.com/watch?v=...">
                            </div>
                            <div class="col-md-8" id="upload_section" style="display: {{ old('video_type', $product->video_type) == 'upload' ? 'block' : 'none' }};">
                                <label class="form-label"><strong>Upload New Video (replaces existing)</strong></label>
                                <input type="file" class="form-control" name="video_file" id="video_file" accept="video/*">
                                @if($product->video_type === 'upload' && $product->video_url)
                                    <small class="text-success">Current video: {{ basename($product->video_url) }} — upload new to replace</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-warning btn-lg px-5 shadow">
                            <i class="fa fa-save"></i> Update Product
                        </button>
                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info btn-lg ms-2">
                            <i class="fa fa-eye"></i> View Product
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-lg ms-2">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" style="display: none;">
        <div class="overlay-content">
            <div class="spinner-border text-warning" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="mt-3">
                <h5 class="text-white">Updating Product...</h5>
                <p class="text-white-50 mb-0">Please wait while we process your request</p>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div id="progressContainer" class="progress-container" style="display: none;">
        <div class="progress">
            <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 0%">
                0%
            </div>
        </div>
    </div>
</section>

<style>
    .bootstrap-tagsinput {
        width: 100%;
    }
    .bootstrap-tagsinput .tag {
        background: #ffc107;
        color: #212529;
        padding: 3px 8px;
        margin-right: 5px;
        border-radius: 3px;
    }
    .digital-options {
        background: #fff3cd;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #ffeaa7;
    }
    .gallery-preview img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        margin: 5px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
    }

    /* Loading Overlay Styles */
    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .overlay-content {
        text-align: center;
        color: white;
    }

    /* Progress Bar Styles */
    .progress-container {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 400px;
        max-width: 90%;
        z-index: 10000;
    }

    .progress-container .progress {
        height: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }

    /* Shake Animation */
    .shake {
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }

    /* Validation Styles */
    .is-valid {
        border-color: #28a745 !important;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
    }

    .invalid-feedback {
        display: block !important;
        color: #dc3545 !important;
        font-size: 13px;
        margin-top: 5px;
    }

    .invalid-feedback i {
        margin-right: 5px;
    }

    /* Enhanced form styling */
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    /* Select2 custom styling */
    .select2-container--default .select2-selection--single {
        border-radius: 6px !important;
        border-color: #ced4da !important;
        height: 38px !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #ffc107 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25) !important;
    }

    /* Premium enhancements for edit */
    .form-control, .form-select {
        border-radius: 10px;
        transition: all 0.2s;
    }
    .digital-options {
        box-shadow: 0 8px 25px rgba(0,123,255,0.07);
    }
    #youtube_section, #upload_section {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #e9ecef;
    }
    .ck-editor__editable { min-height: 180px; }
</style>

<!-- Additional Scripts for Enhanced Forms -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- CKEditor 5 for WYSIWYG -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/super-build/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />

@include('admin.products.partials.premium-description-template')

<script>
function getProductEditorConstructor() {
    return (window.CKEDITOR && window.CKEDITOR.ClassicEditor) ? window.CKEDITOR.ClassicEditor : window.ClassicEditor;
}

function getProductEditorConfig(placeholder) {
    return {
        placeholder: placeholder,
        toolbar: {
            items: [
                'showBlocks', 'findAndReplace', 'selectAll', '|',
                'heading', 'style', '|',
                'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', 'code', 'removeFormat', '|',
                'alignment', 'outdent', 'indent', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'link', 'blockQuote', 'codeBlock', 'insertTable', 'mediaEmbed', 'horizontalLine', 'specialCharacters', '|',
                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: true
        },
        codeBlock: {
            languages: [
                { language: 'plaintext', label: 'Plain text' },
                { language: 'html', label: 'HTML' },
                { language: 'css', label: 'CSS' },
                { language: 'javascript', label: 'JavaScript' },
                { language: 'php', label: 'PHP' },
                { language: 'json', label: 'JSON' }
            ]
        },
        table: {
            contentToolbar: [
                'tableColumn', 'tableRow', 'mergeTableCells',
                'tableProperties', 'tableCellProperties'
            ]
        },
        removePlugins: [
            'AIAssistant',
            'CKBox',
            'CKFinder',
            'EasyImage',
            'ExportPdf',
            'ExportWord',
            'ImportWord',
            'RealTimeCollaborativeComments',
            'RealTimeCollaborativeTrackChanges',
            'RealTimeCollaborativeRevisionHistory',
            'PresenceList',
            'Comments',
            'TrackChanges',
            'TrackChangesData',
            'RevisionHistory',
            'Pagination',
            'WProofreader',
            'MathType',
            'MultiLevelList',
            'PasteFromOfficeEnhanced',
            'CaseChange',
            'SlashCommand',
            'Template',
            'DocumentOutline',
            'FormatPainter',
            'TableOfContents'
        ]
    };
}

// Wait for jQuery Validation to be ready
function initializeProductForm() {
    $(document).ready(function() {
    // Initialize Select2 if not already initialized
    if (!$('.select2').hasClass("select2-offscreen")) {
        $('.select2').select2({
            width: '100%',
            placeholder: 'Select option',
            allowClear: true
        });
    }

    // Initialize Tags Input
    $('#tags').tagsinput();

    // Initialize Premium WYSIWYG (CKEditor 5) for detailed description
    const ProductEditor = getProductEditorConstructor();
    const detailedDescription = document.querySelector('#detailed_description');
    if (ProductEditor && detailedDescription && !window.detailedEditor) {
        ProductEditor
            .create(detailedDescription, getProductEditorConfig('Update detailed product description with rich formatting, code blocks, tables, and embeds...'))
            .then(editor => {
                window.detailedEditor = editor;
                editor.ui.view.editable.element.style.minHeight = '220px';
            })
            .catch(err => console.warn('CKEditor init failed in edit:', err));
    }

    // Auto-generate slug from name with AJAX validation
    $('#name').on('input', function() {
        var name = $(this).val();
        var slug = name.toLowerCase()
                        .replace(/[^a-z0-9\s]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim('-');
        $('#slug').val(slug);

        // Real-time validation for name
        if (name.length >= 2) {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).closest('.col-md-6').find('.invalid-feedback').html('');
        }
    });

    // Real-time slug validation
    $('#slug').on('input', function() {
        var slug = $(this).val();
        if (slug.length >= 2) {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).closest('.col-md-6').find('.invalid-feedback').html('');
        }
    });

    // Real-time price validation
    $('#price, #compare_price').on('input', function() {
        var value = parseFloat($(this).val());
        if (!isNaN(value) && value >= 0) {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).closest('.col-md-4, .col-md-6').find('.invalid-feedback').html('');
        }
    });

    // Real-time stock validation
    $('#stock').on('input', function() {
        var value = parseInt($(this).val());
        if (!isNaN(value) && value >= 0) {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).closest('.col-md-4').find('.invalid-feedback').html('');
        }
    });

    // Show/hide digital options based on product type
    $('#digital').on('change', function() {
        if ($(this).val() == '1') {
            $('.digital-options').slideDown(300);
            // Clear physical product validation if switching to digital
            $('#file_url').prop('required', true);
        } else {
            $('.digital-options').slideUp(300);
            $('#file_url').prop('required', false);
        }
    });

    // Category validation on change
    $('#category').on('change', function() {
        if ($(this).val()) {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).closest('.col-md-6').find('.invalid-feedback').html('');
        }
    });

    // Show/hide digital options based on product type
    $('#digital').on('change', function() {
        if ($(this).val() == '1') {
            $('.digital-options').show();
        } else {
            $('.digital-options').hide();
        }
    });

    // Video type toggle handler (premium video options)
    $('#video_type').on('change', function() {
        const type = $(this).val();
        $('#youtube_section').hide();
        $('#upload_section').hide();

        if (type === 'youtube') {
            $('#youtube_section').slideDown(180);
            $('#video_file').val('');
        } else if (type === 'upload') {
            $('#upload_section').slideDown(180);
            $('#video_url_youtube').val('');
        }
    });

    // Custom form submission handler
    // Custom form submission handler (works regardless of jQuery Validate)
    $('#productForm').on('submit', function(e) {
        e.preventDefault();

        // Sync WYSIWYG content to textarea
        if (window.detailedEditor) {
            $('#detailed_description').val(window.detailedEditor.getData());
        }

        // Validate the form
        const validation = validateProductForm();

        if (!validation.isValid) {
            // Show validation errors
            if (validation.errors.length > 0) {
                $('#formAlert').html(`<div class="alert alert-danger alert-dismissible fade show">
                    <i class="fa fa-times-circle"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        ${validation.errors.map(error => `<li>${error}</li>`).join('')}
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>`).fadeIn(300);

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

                // Update submit button
                const submitBtn = $("button[type='submit']");
                submitBtn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Updating Product...');

                // Show progress bar
                $('#progressContainer').show();
                $('#progressBar').css('width', '0%').text('0%');
            },
            success: function(response) {
                $('#loadingOverlay').css('display', 'none');

                $('#progressBar').addClass('bg-success').css('width', '100%').text('Complete!');

                setTimeout(() => {
                    $('#progressContainer').fadeOut();
                    toastr.success('Product updated successfully.', 'Success!');
                    setTimeout(() => {
                        window.location.href = '{{ route("admin.products.index") }}';
                    }, 1500);
                }, 500);
            },
            error: function(xhr) {
                $('#loadingOverlay').css('display', 'none');

                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    let errorCount = 0;

                    $.each(errors, function(field, messages){
                        errorCount++;
                        showFieldError(`[name="${field}"]`, messages[0]);
                    });

                    if (errorCount > 0) {
                        $('#formAlert').html(`<div class="alert alert-danger alert-dismissible fade show">
                            <i class="fa fa-times-circle"></i>
                            <strong>Please fix the ${errorCount} server validation error${errorCount > 1 ? 's' : ''}.</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>`).fadeIn(300);
                    }
                    toastr.error('Please fix the validation errors.', 'Validation Failed');
                    $('#progressBar').addClass('bg-danger').css('width', '100%').text('Validation Failed');

                } else {
                    const msg = xhr.responseJSON?.message || 'Something went wrong. Please try again.';
                    toastr.error(msg, 'Server Error');
                    $('#progressBar').addClass('bg-danger').css('width', '100%').text('Server Error');

                    $('#formAlert').html(`<div class="alert alert-danger alert-dismissible fade show">
                        <i class="fa fa-times-circle"></i>
                        <strong>Server Error:</strong> ${msg}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>`).fadeIn(300);
                }
            },
            complete: function() {
                const submitBtn = $("button[type='submit']");
                submitBtn.prop("disabled", false).html('<i class="fa fa-save"></i> Update Product');

                // Hide progress after a delay
                setTimeout(() => {
                    $('#progressContainer').fadeOut();
                }, 2000);
            }
        });
    }

    // Custom validation functions (no external dependencies)
    window.customValidators = {
        // File size validation
        validateFileSize: function(fileInput, maxSizeBytes) {
            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                return { valid: true, message: '' };
            }

            const file = fileInput.files[0];
            if (file.size > maxSizeBytes) {
                const maxSizeMB = (maxSizeBytes / (1024 * 1024)).toFixed(1);
                return {
                    valid: false,
                    message: `File size must be less than ${maxSizeMB}MB`
                };
            }

            return { valid: true, message: '' };
        },

        // File extension validation
        validateFileExtension: function(fileInput, allowedExtensions) {
            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                return { valid: true, message: '' };
            }

            const file = fileInput.files[0];
            const extension = file.name.split('.').pop().toLowerCase();

            if (!allowedExtensions.includes(extension)) {
                return {
                    valid: false,
                    message: `Please select a valid file type (${allowedExtensions.join(', ')})`
                };
            }

            return { valid: true, message: '' };
        },

        // Required field validation
        validateRequired: function(value, fieldName) {
            if (!value || (typeof value === 'string' && value.trim() === '')) {
                return {
                    valid: false,
                    message: `${fieldName} is required`
                };
            }
            return { valid: true, message: '' };
        },

        // Minimum length validation
        validateMinLength: function(value, minLength, fieldName) {
            if (value && value.length < minLength) {
                return {
                    valid: false,
                    message: `${fieldName} must be at least ${minLength} characters`
                };
            }
            return { valid: true, message: '' };
        },

        // Numeric validation
        validateNumeric: function(value, fieldName) {
            if (value && isNaN(value)) {
                return {
                    valid: false,
                    message: `${fieldName} must be a valid number`
                };
            }
            return { valid: true, message: '' };
        },

        // Minimum value validation
        validateMinValue: function(value, minValue, fieldName) {
            if (value && parseFloat(value) < minValue) {
                return {
                    valid: false,
                    message: `${fieldName} must be at least ${minValue}`
                };
            }
            return { valid: true, message: '' };
        }
    };

    // Form validation function (custom implementation)
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
        } else {
            $('#digital').addClass('is-valid');
        }

        // Validate thumbnail (from file upload or gallery selection)
        const hasThumbnailFile = $('#thumbnail')[0] && $('#thumbnail')[0].files && $('#thumbnail')[0].files.length > 0;
        const hasGalleryThumbnail = $('#selected_thumbnail_path').val() !== '';
        const hasExistingThumbnail = $('#productForm').data('has-existing-thumbnail') === true;
        
        // On edit page, if product already has thumbnail, it's optional
        if (!hasThumbnailFile && !hasGalleryThumbnail && !hasExistingThumbnail) {
            errors.push('Thumbnail image is required');
            showFieldError('#thumbnail', 'Please select a thumbnail image');
            isValid = false;
        } else if (hasThumbnailFile) {
            const sizeResult = window.customValidators.validateFileSize($('#thumbnail')[0], 2*1024*1024); // 2MB
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
            $('#thumbnail').addClass('is-valid');
        } else if (hasExistingThumbnail) {
            // Product has existing thumbnail - validation passes, keep current
            $('#thumbnail').addClass('is-valid');
        }

        // Validate gallery images (optional)
        if ($('#images')[0] && $('#images')[0].files && $('#images')[0].files.length > 0) {
            for (let i = 0; i < $('#images')[0].files.length; i++) {
                const sizeResult = window.customValidators.validateFileSize({files: [$('#images')[0].files[i]]}, 5*1024*1024); // 5MB each
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

        // Download URL is optional - only validate format if filled
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
        feedback.html(`<i class="fa fa-exclamation-triangle"></i> ${message}`).fadeIn(300);

        // Shake animation
        field.closest('.col-md-6, .col-md-12, .col-md-4').addClass('shake');
        setTimeout(() => {
            field.closest('.col-md-6, .col-md-12, .col-md-4').removeClass('shake');
        }, 500);
    }
    });
}

// Initialize when jQuery Validation is ready, or fallback after timeout
if (window.jQueryValidationLoaded) {
    initializeProductForm();
} else {
    $(document).on('jquery-validation-ready', function() {
        initializeProductForm();
    });

    // Fallback timeout
    setTimeout(function() {
        if (!window.jQueryValidationLoaded) {
            console.warn('jQuery Validation not loaded within timeout, initializing with fallback');
            initializeProductForm();
        }
    }, 3000);
}

window.previewThumbnail = function(input) {
     if (!input || !input.files || input.files.length === 0) return;

     const file = input.files[0];
     const previewImg = $("#thumbnailPreview");

     if (file && previewImg.length) {
         previewImg.css('opacity', '0.5');

         // Clear gallery selection when uploading new file
         document.getElementById('selected_thumbnail_path').value = '';

         const reader = new FileReader();
         reader.onload = function(e) {
             previewImg.attr("src", e.target.result).css('opacity', '1');

             if (file.size > 2*1024*1024) {
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
                    galleryPreview.append(`<img src="${e.target.result}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">`);
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

window.setAsThumbnail = function(imagePath, element) {
    const previewImg = $("#thumbnailPreview");
    const hiddenInput = $("#selected_thumbnail_path");
    
    previewImg.attr("src", "{{ asset('public/storage/') }}/" + imagePath);
    hiddenInput.val(imagePath);
    
    $('.gallery-image-item').removeClass('border border-warning border-2');
    $(element).closest('.gallery-image-item').addClass('border border-warning border-2');
    
    const thumbnailInput = $("#thumbnail");
    thumbnailInput.val('');
    thumbnailInput.removeClass('is-invalid is-valid');
};

window.removeGalleryImage = function(button, imagePath) {
    event.stopPropagation();
    
    const hiddenInput = $("#selected_thumbnail_path");
    
    if (hiddenInput.val() === imagePath) {
        hiddenInput.val('');
        const previewImg = $("#thumbnailPreview");
        if (previewImg.length && !$('#thumbnail')[0].files.length) {
            const currentThumb = '{{ $product->thumbnail }}';
            if (currentThumb && currentThumb !== imagePath) {
                previewImg.attr("src", "{{ asset('public/storage/' . $product->thumbnail) }}");
            }
        }
    }
    
    $(button).closest('.gallery-image-item').remove();
};
</script>

<!-- Robust CKEditor 5 initialization for Edit Product page -->
<script>
(function() {
    function initCKEditorEdit() {
        const textarea = document.getElementById('detailed_description');
        if (!textarea) {
            console.warn('[Edit Product] #detailed_description textarea not found');
            return;
        }

        // Prevent double initialization
        if (textarea.classList.contains('ck-editor__editable')) {
            console.log('[Edit Product] CKEditor already initialized');
            return;
        }

        const ProductEditor = getProductEditorConstructor();
        if (!ProductEditor) {
            console.error('[Edit Product] ClassicEditor is not loaded. Check CDN.');
            return;
        }

        if (window.detailedEditor) {
            return;
        }

        ProductEditor
            .create(textarea, getProductEditorConfig('Update detailed product description with rich formatting, code blocks, tables, and embeds...'))
            .then(editor => {
                window.detailedEditor = editor;
                editor.ui.view.editable.element.style.minHeight = '220px';
                editor.ui.view.editable.element.style.border = '1px solid #ced4da';
                console.log('%c[Edit Product] WYSIWYG (CKEditor 5) initialized successfully', 'color: #28a745; font-weight: bold');
            })
            .catch(error => {
                console.error('[Edit Product] Failed to initialize CKEditor 5:', error);
            });
    }

    // Run as soon as possible after DOM + scripts
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCKEditorEdit);
    } else {
        // DOM already ready, but wait a tick for other scripts
        setTimeout(initCKEditorEdit, 300);
    }

    // Extra safety net in case of late loading
    setTimeout(initCKEditorEdit, 1500);
})();
</script>

@endsection
