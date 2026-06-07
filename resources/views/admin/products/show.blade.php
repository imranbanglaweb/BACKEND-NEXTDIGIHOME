@extends('admin.dashboard.master')

@section('main_content')
@php
    $galleryImages = is_string($product->images) ? json_decode($product->images, true) : $product->images;
    $galleryImages = is_array($galleryImages) ? array_values(array_filter($galleryImages)) : [];
    $mainImage = $product->thumbnail ?: ($galleryImages[0] ?? null);
    $tags = is_array($product->tags) ? $product->tags : (is_string($product->tags) ? array_filter(array_map('trim', explode(',', $product->tags))) : []);
    $discountPercent = null;
    if ($product->compare_price && $product->compare_price > $product->price) {
        $discountPercent = round((($product->compare_price - $product->price) / $product->compare_price) * 100);
    }
    $allowedProductHtml = '<p><br><strong><b><em><i><u><s><sub><sup><code><pre><blockquote><ul><ol><li><h2><h3><h4><table><thead><tbody><tr><th><td><a><hr><span>';
    $youtubeEmbed = null;
    if ($product->video_type === 'youtube' && $product->video_url) {
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([A-Za-z0-9_-]{6,})/', $product->video_url, $matches);
        $youtubeEmbed = isset($matches[1]) ? 'https://www.youtube.com/embed/' . $matches[1] : null;
    }
    $renderedDetailedDescription = $product->detailed_description
        ? strip_tags(html_entity_decode($product->detailed_description, ENT_QUOTES | ENT_HTML5, 'UTF-8'), $allowedProductHtml)
        : null;
@endphp

<section role="main" class="content-body product-preview-page">
    <div class="preview-toolbar">
        <div>
            <span class="preview-kicker">Storefront Preview</span>
            <h2>{{ $product->name }}</h2>
            <p>This page shows how the product details can look to customers on the frontend.</p>
        </div>
        <div class="preview-actions">
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
                <i class="fa fa-edit me-1"></i> Edit Product
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="storefront-shell">
        <div class="product-hero">
            <div class="product-gallery">
                <div class="product-main-media">
                    @if($mainImage)
                        <img id="mainProductPreviewImage" src="{{ asset('public/storage/' . $mainImage) }}" alt="{{ $product->name }}">
                    @else
                        <div class="media-placeholder">
                            <i class="fa fa-image"></i>
                            <span>No product image</span>
                        </div>
                    @endif

                    <div class="media-badges">
                        @if($product->featured)
                            <span class="badge badge-featured"><i class="fa fa-star"></i> Featured</span>
                        @endif
                        @if($discountPercent)
                            <span class="badge badge-sale">{{ $discountPercent }}% Off</span>
                        @endif
                    </div>
                </div>

                @if(count($galleryImages) > 0 || $product->thumbnail)
                    <div class="gallery-strip">
                        @if($product->thumbnail)
                            <button type="button" class="gallery-thumb active" data-image="{{ asset('public/storage/' . $product->thumbnail) }}">
                                <img src="{{ asset('public/storage/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                            </button>
                        @endif
                        @foreach($galleryImages as $image)
                            <button type="button" class="gallery-thumb" data-image="{{ asset('public/storage/' . $image) }}">
                                <img src="{{ asset('public/storage/' . $image) }}" alt="{{ $product->name }} gallery image">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <aside class="product-purchase-panel">
                <div class="product-meta-row">
                    <span class="category-pill">{{ $product->category }}</span>
                    <span class="type-pill">{{ $product->digital ? 'Digital Product' : 'Physical Product' }}</span>
                </div>

                <h1>{{ $product->name }}</h1>

                @if($product->description)
                    <p class="short-description">{{ $product->description }}</p>
                @endif

                <div class="price-row">
                    <span class="current-price">${{ number_format($product->price, 2) }}</span>
                    @if($product->compare_price)
                        <span class="compare-price">${{ number_format($product->compare_price, 2) }}</span>
                    @endif
                </div>

                <div class="trust-grid">
                    <div>
                        <i class="fa fa-box-open"></i>
                        <span>{{ $product->stock > 0 ? $product->stock . ' available' : 'Out of stock' }}</span>
                    </div>
                    <div>
                        <i class="fa fa-bolt"></i>
                        <span>{{ $product->digital ? 'Instant delivery' : 'Manual delivery' }}</span>
                    </div>
                    <div>
                        <i class="fa fa-shield-alt"></i>
                        <span>Secure checkout</span>
                    </div>
                    <div>
                        <i class="fa fa-life-ring"></i>
                        <span>Support ready</span>
                    </div>
                </div>

                <div class="cta-stack">
                    <button type="button" class="btn btn-primary btn-lg" disabled>
                        <i class="fa fa-shopping-cart me-1"></i> Buy Now
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-lg" disabled>
                        <i class="fa fa-cart-plus me-1"></i> Add to Cart
                    </button>
                </div>

                @if($product->preview_url || $product->file_url)
                    <div class="link-actions">
                        @if($product->preview_url)
                            <a href="{{ $product->preview_url }}" target="_blank" rel="noopener" class="btn btn-light">
                                <i class="fa fa-eye me-1"></i> Open Preview
                            </a>
                        @endif
                        @if($product->file_url)
                            <a href="{{ $product->file_url }}" target="_blank" rel="noopener" class="btn btn-light">
                                <i class="fa fa-download me-1"></i> Delivery Link
                            </a>
                        @endif
                    </div>
                @endif

                @if(count($tags) > 0)
                    <div class="tag-list">
                        @foreach($tags as $tag)
                            <span>{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif
            </aside>
        </div>

        @if($youtubeEmbed || ($product->video_type === 'upload' && $product->video_url))
            <section class="preview-section">
                <div class="section-heading">
                    <span>Product Media</span>
                    <h3>Preview Video</h3>
                </div>
                <div class="video-frame">
                    @if($youtubeEmbed)
                        <iframe src="{{ $youtubeEmbed }}" title="{{ $product->name }} video preview" allowfullscreen></iframe>
                    @elseif($product->video_type === 'upload' && $product->video_url)
                        <video controls>
                            <source src="{{ asset('public/storage/' . $product->video_url) }}">
                        </video>
                    @endif
                </div>
            </section>
        @endif

        <section class="preview-section details-grid">
            <div class="product-description-panel">
                <div class="section-heading">
                    <span>Overview</span>
                    <h3>Product Details</h3>
                </div>
                @if($renderedDetailedDescription)
                    <div class="product-template-preview">
                        {!! $renderedDetailedDescription !!}
                    </div>
                @else
                    <p class="empty-copy">No detailed description has been added yet. Use the premium template on the edit page to create a complete product page quickly.</p>
                @endif
            </div>

            <aside class="product-info-panel">
                <div class="info-card">
                    <h4>Product Information</h4>
                    <dl>
                        <dt>Status</dt>
                        <dd>{{ $product->active ? 'Active' : 'Inactive' }}</dd>
                        <dt>Featured</dt>
                        <dd>{{ $product->featured ? 'Yes' : 'No' }}</dd>
                        <dt>Slug</dt>
                        <dd><code>{{ $product->slug }}</code></dd>
                        <dt>Created</dt>
                        <dd>{{ $product->created_at->format('M d, Y') }}</dd>
                        <dt>Updated</dt>
                        <dd>{{ $product->updated_at->format('M d, Y') }}</dd>
                    </dl>
                </div>
            </aside>
        </section>
    </div>
</section>

<style>
    .product-preview-page {
        background: #f5f7fb;
        padding: 24px;
    }
    .preview-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
    }
    .preview-toolbar h2 {
        margin: 0;
        font-weight: 800;
        color: #111827;
    }
    .preview-toolbar p {
        margin: 4px 0 0;
        color: #6b7280;
    }
    .preview-kicker {
        display: inline-block;
        margin-bottom: 4px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #2563eb;
    }
    .preview-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .storefront-shell {
        max-width: 1180px;
        margin: 0 auto;
    }
    .product-hero,
    .preview-section {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08);
    }
    .product-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.08fr) minmax(340px, 0.92fr);
        gap: 28px;
        padding: 28px;
    }
    .product-main-media {
        position: relative;
        aspect-ratio: 4 / 3;
        background: #eef2f7;
        border-radius: 12px;
        overflow: hidden;
    }
    .product-main-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .media-placeholder {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: #94a3b8;
        font-weight: 700;
    }
    .media-placeholder i {
        font-size: 42px;
    }
    .media-badges {
        position: absolute;
        top: 14px;
        left: 14px;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .badge {
        border-radius: 999px;
        padding: 0.45rem 0.7rem;
    }
    .badge-featured {
        background: #f59e0b;
        color: #111827;
    }
    .badge-sale {
        background: #dc2626;
        color: #fff;
    }
    .gallery-strip {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(72px, 1fr));
        gap: 10px;
        margin-top: 12px;
    }
    .gallery-thumb {
        border: 2px solid transparent;
        border-radius: 10px;
        padding: 0;
        aspect-ratio: 1;
        overflow: hidden;
        background: #fff;
        cursor: pointer;
    }
    .gallery-thumb.active {
        border-color: #2563eb;
    }
    .gallery-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .product-purchase-panel h1 {
        margin: 16px 0 10px;
        font-size: 2.15rem;
        line-height: 1.12;
        font-weight: 850;
        color: #0f172a;
    }
    .product-meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .category-pill,
    .type-pill,
    .tag-list span {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 0.42rem 0.7rem;
        font-size: 0.82rem;
        font-weight: 700;
    }
    .category-pill {
        background: #dbeafe;
        color: #1d4ed8;
    }
    .type-pill {
        background: #dcfce7;
        color: #166534;
    }
    .short-description {
        color: #475569;
        line-height: 1.7;
        margin-bottom: 18px;
    }
    .price-row {
        display: flex;
        align-items: baseline;
        gap: 12px;
        margin: 18px 0;
    }
    .current-price {
        font-size: 2rem;
        font-weight: 850;
        color: #16a34a;
    }
    .compare-price {
        font-size: 1.1rem;
        color: #94a3b8;
        text-decoration: line-through;
    }
    .trust-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        margin: 20px 0;
    }
    .trust-grid div {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 11px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        color: #334155;
        font-weight: 650;
        background: #f8fafc;
    }
    .trust-grid i {
        color: #2563eb;
    }
    .cta-stack {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 18px;
    }
    .link-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }
    .tag-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 18px;
    }
    .tag-list span {
        background: #f1f5f9;
        color: #334155;
    }
    .preview-section {
        margin-top: 22px;
        padding: 28px;
    }
    .details-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 24px;
    }
    .section-heading span {
        color: #2563eb;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.78rem;
        letter-spacing: 0.08em;
    }
    .section-heading h3 {
        margin: 4px 0 18px;
        font-weight: 820;
        color: #111827;
    }
    .video-frame {
        aspect-ratio: 16 / 9;
        overflow: hidden;
        border-radius: 12px;
        background: #0f172a;
    }
    .video-frame iframe,
    .video-frame video {
        width: 100%;
        height: 100%;
        border: 0;
        display: block;
    }
    .product-template-preview {
        color: #334155;
        line-height: 1.75;
    }
    .product-template-preview h2,
    .product-template-preview h3,
    .product-template-preview h4 {
        margin-top: 1.1rem;
        margin-bottom: 0.75rem;
        font-weight: 800;
        color: #111827;
    }
    .product-template-preview ul,
    .product-template-preview ol {
        padding-left: 1.35rem;
    }
    .product-template-preview pre {
        background: #111827;
        color: #f9fafb;
        border-radius: 10px;
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
    .empty-copy {
        color: #64748b;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        padding: 18px;
    }
    .info-card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 18px;
        background: #f8fafc;
    }
    .info-card h4 {
        margin: 0 0 14px;
        font-weight: 800;
        color: #111827;
    }
    .info-card dl {
        margin: 0;
    }
    .info-card dt {
        color: #64748b;
        font-size: 0.82rem;
        margin-top: 12px;
    }
    .info-card dd {
        margin: 2px 0 0;
        color: #111827;
        font-weight: 700;
        word-break: break-word;
    }
    @media (max-width: 992px) {
        .product-hero,
        .details-grid {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 768px) {
        .product-preview-page {
            padding: 16px;
        }
        .preview-toolbar {
            align-items: flex-start;
            flex-direction: column;
        }
        .product-hero,
        .preview-section {
            padding: 18px;
        }
        .product-purchase-panel h1 {
            font-size: 1.65rem;
        }
        .trust-grid,
        .cta-stack {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
document.querySelectorAll('.gallery-thumb').forEach(function(button) {
    button.addEventListener('click', function() {
        var target = document.getElementById('mainProductPreviewImage');
        if (!target) {
            return;
        }

        document.querySelectorAll('.gallery-thumb').forEach(function(item) {
            item.classList.remove('active');
        });

        target.src = button.getAttribute('data-image');
        button.classList.add('active');
    });
});
</script>

@endsection
