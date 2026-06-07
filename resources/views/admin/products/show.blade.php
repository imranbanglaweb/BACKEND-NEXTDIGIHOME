@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background-color: #fff">
    <div class="row">
        <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
            <h2><i class="fa fa-eye text-info"></i> Product Details: {{ $product->name }}</h2>
            <div class="btn-group">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
                    <i class="fa fa-edit me-1"></i> Edit Product
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Back to Products
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-4">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fa fa-images"></i> Product Images</h5>
                </div>
                <div class="card-body text-center">
                    @if($product->thumbnail)
                        <img src="{{ asset('public/storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow mb-3" style="max-height: 300px;">
                    @else
                        <div class="bg-light rounded p-4 mb-3">
                            <i class="fa fa-image fa-3x text-muted"></i>
                            <p class="text-muted mt-2">No thumbnail image</p>
                        </div>
                    @endif

                    @php
                        $galleryImages = is_string($product->images) ? json_decode($product->images, true) : $product->images;
                    @endphp
                    @if($galleryImages && is_array($galleryImages) && count($galleryImages) > 0)
                        <h6 class="text-muted mb-2">Gallery Images</h6>
                        <div class="d-flex flex-wrap justify-content-center">
                            @foreach($galleryImages as $image)
                                <img src="{{ asset('public/storage/' . $image) }}" alt="Gallery" class="img-thumbnail me-2 mb-2" style="width: 80px; height: 80px; object-fit: cover;">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Information -->
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fa fa-info-circle"></i> Product Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <h6 class="text-primary mb-3"><i class="fa fa-tag"></i> Basic Details</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td class="text-muted" width="40%">Name:</td>
                                        <td class="fw-bold">{{ $product->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Slug:</td>
                                        <td><code>{{ $product->slug }}</code></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Category:</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $product->category }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Type:</td>
                                        <td>
                                            @if($product->digital)
                                                <span class="badge bg-success"><i class="fa fa-download"></i> Digital</span>
                                            @else
                                                <span class="badge bg-info"><i class="fa fa-box"></i> Physical</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Status:</td>
                                        <td>
                                            @if($product->active)
                                                <span class="badge bg-success"><i class="fa fa-check"></i> Active</span>
                                            @else
                                                <span class="badge bg-danger"><i class="fa fa-times"></i> Inactive</span>
                                            @endif
                                            @if($product->featured)
                                                <span class="badge bg-warning ms-1"><i class="fa fa-star"></i> Featured</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <h6 class="text-success mb-3"><i class="fa fa-dollar-sign"></i> Pricing & Stock</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td class="text-muted" width="40%">Price:</td>
                                        <td class="fw-bold text-success fs-5">${{ number_format($product->price, 2) }}</td>
                                    </tr>
                                    @if($product->compare_price)
                                    <tr>
                                        <td class="text-muted">Compare Price:</td>
                                        <td class="text-decoration-line-through text-muted">${{ number_format($product->compare_price, 2) }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="text-muted">Stock:</td>
                                        <td>
                                            @if($product->stock > 10)
                                                <span class="badge bg-success">{{ $product->stock }} (In Stock)</span>
                                            @elseif($product->stock > 0)
                                                <span class="badge bg-warning">{{ $product->stock }} (Low Stock)</span>
                                            @else
                                                <span class="badge bg-danger">Out of Stock</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($product->published_at)
                                    <tr>
                                        <td class="text-muted">Published:</td>
                                        <td>{{ $product->published_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Descriptions -->
            @if($product->description || $product->detailed_description)
            <div class="card shadow-lg border-0 rounded-lg mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fa fa-file-alt"></i> Product Descriptions</h5>
                </div>
                <div class="card-body">
                    @if($product->description)
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Short Description:</h6>
                            <p class="mb-3">{{ $product->description }}</p>
                        </div>
                    @endif

                    @if($product->detailed_description)
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Detailed Description:</h6>
                            @php
                                $allowedProductHtml = '<p><br><strong><b><em><i><u><s><sub><sup><code><pre><blockquote><ul><ol><li><h2><h3><h4><table><thead><tbody><tr><th><td><a><hr><span>';
                            @endphp
                            <div class="border rounded p-3 bg-light product-template-preview">
                                {!! strip_tags($product->detailed_description, $allowedProductHtml) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Digital Product Settings -->
            @if($product->digital)
            <div class="card shadow-lg border-0 rounded-lg mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fa fa-download"></i> Digital Product Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @if($product->file_url)
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Download URL:</h6>
                            <a href="{{ $product->file_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fa fa-external-link-alt"></i> Open Download Link
                            </a>
                            <small class="d-block mt-1 text-muted">{{ $product->file_url }}</small>
                        </div>
                        @endif

                        @if($product->preview_url)
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Preview URL:</h6>
                            <a href="{{ $product->preview_url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="fa fa-external-link-alt"></i> Open Preview Link
                            </a>
                            <small class="d-block mt-1 text-muted">{{ $product->preview_url }}</small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Tags -->
            @if($product->tags && is_array($product->tags) && count($product->tags) > 0)
            <div class="card shadow-lg border-0 rounded-lg mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fa fa-tags"></i> Product Tags</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($product->tags as $tag)
                            <span class="badge bg-primary fs-6 px-3 py-2">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Timestamps -->
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fa fa-clock"></i> Record Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">Created:</small><br>
                            <span class="fw-bold">{{ $product->created_at->format('M d, Y H:i:s') }}</span>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Last Updated:</small><br>
                            <span class="fw-bold">{{ $product->updated_at->format('M d, Y H:i:s') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .card {
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .badge {
        font-size: 0.75rem;
    }
    .table-borderless td {
        padding: 0.25rem 0;
    }
    .product-template-preview {
        line-height: 1.7;
    }
    .product-template-preview h2,
    .product-template-preview h3,
    .product-template-preview h4 {
        margin-top: 1rem;
        margin-bottom: 0.75rem;
        font-weight: 700;
        color: #1f2937;
    }
    .product-template-preview ul,
    .product-template-preview ol {
        padding-left: 1.35rem;
    }
    .product-template-preview pre {
        background: #111827;
        color: #f9fafb;
        border-radius: 8px;
        padding: 1rem;
        overflow-x: auto;
    }
    .product-template-preview code {
        background: #eef2ff;
        border-radius: 4px;
        padding: 0.15rem 0.35rem;
    }
    .product-template-preview pre code {
        background: transparent;
        padding: 0;
    }
</style>

@endsection
