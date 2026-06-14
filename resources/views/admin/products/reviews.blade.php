@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body product-page">
    <div class="container-fluid">
        <div class="product-header">
            <div>
                <div class="product-eyebrow">Catalog</div>
                <h2>Product Reviews</h2>
                <p>Review customer-facing ratings and testimonials used across the marketplace.</p>
            </div>
            <div class="product-header-actions">
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-primary">
                    <i class="fas fa-comments me-2"></i>Manage Testimonials
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i>Products
                </a>
            </div>
        </div>

        <div class="product-nav mb-3">
            <a href="{{ route('admin.products.index') }}">Products</a>
            <a href="{{ route('admin.products.downloads') }}">Downloads</a>
            <a href="{{ route('admin.products.reviews') }}" class="active">Reviews</a>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-xl-3 col-md-6">
                <div class="product-stat-card">
                    <span class="stat-icon stat-amber"><i class="fas fa-star"></i></span>
                    <div>
                        <small>Average Rating</small>
                        <strong>{{ $stats['average'] ?? '0.0' }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-stat-card">
                    <span class="stat-icon stat-blue"><i class="fas fa-comments"></i></span>
                    <div>
                        <small>Total Reviews</small>
                        <strong>{{ number_format($stats['total'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-stat-card">
                    <span class="stat-icon stat-green"><i class="fas fa-check-circle"></i></span>
                    <div>
                        <small>Published</small>
                        <strong>{{ number_format($stats['active'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-stat-card">
                    <span class="stat-icon stat-cyan"><i class="fas fa-box"></i></span>
                    <div>
                        <small>Products</small>
                        <strong>{{ number_format($stats['products'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-panel mb-3">
            <div class="alert alert-info mb-0">
                <i class="fas fa-info-circle me-2"></i>
                This installation does not include a dedicated product review table yet. This page displays real testimonial/rating records. Use the testimonial manager to create, edit, publish, or hide these reviews.
            </div>
        </div>

        <div class="product-panel">
            <div class="product-panel-title">
                <div>
                    <h5>Published Review Content</h5>
                    <p>Customer quotes and ratings currently available for storefront trust sections.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table product-table" id="reviewsTable">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Position</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $testimonial)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($testimonial->image)
                                            <img src="{{ asset('public/admin_resource/assets/images/'.$testimonial->image) }}" alt="{{ $testimonial->name }}" class="product-thumb me-2">
                                        @else
                                            <span class="review-avatar me-2">{{ strtoupper(substr($testimonial->name, 0, 1)) }}</span>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $testimonial->name }}</div>
                                            <small class="text-muted">{{ $testimonial->company ?: 'No company' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $testimonial->position ?: 'N/A' }}</td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                    <span class="ms-1 fw-bold">{{ $testimonial->rating }}/5</span>
                                </td>
                                <td>{{ Str::limit($testimonial->content, 110) }}</td>
                                <td>
                                    <span class="badge bg-{{ $testimonial->is_active ? 'success' : 'secondary' }}">
                                        {{ $testimonial->is_active ? 'Published' : 'Hidden' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-sm btn-outline-primary" title="Manage"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No review or testimonial records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<style>
    .product-page { background: #f6f8fb; min-height: calc(100vh - 70px); padding: 24px; }
    .product-header { align-items:center; background:#111827; border-radius:8px; color:#fff; display:flex; justify-content:space-between; margin-bottom:18px; padding:22px 24px; }
    .product-header h2 { font-size:26px; font-weight:700; margin:0 0 4px; }
    .product-header p, .product-panel-title p { margin:0; }
    .product-header p { color:rgba(255,255,255,.72); }
    .product-eyebrow { color:#60a5fa; font-size:12px; font-weight:700; text-transform:uppercase; }
    .product-header-actions, .product-nav { display:flex; flex-wrap:wrap; gap:10px; }
    .product-nav { background:#fff; border:1px solid #e5e7eb; border-radius:8px; gap:8px; padding:10px; }
    .product-nav a { border-radius:6px; color:#4b5563; font-size:13px; font-weight:700; padding:8px 12px; text-decoration:none; }
    .product-nav a:hover, .product-nav a.active { background:#111827; color:#fff; }
    .product-stat-card, .product-panel { background:#fff; border:1px solid #e5e7eb; border-radius:8px; box-shadow:0 8px 24px rgba(15,23,42,.06); }
    .product-stat-card { align-items:center; display:flex; gap:14px; min-height:102px; padding:18px; }
    .product-stat-card small { color:#6b7280; display:block; font-size:13px; margin-bottom:5px; }
    .product-stat-card strong { color:#111827; display:block; font-size:24px; line-height:1; }
    .stat-icon { align-items:center; border-radius:8px; display:inline-flex; flex:0 0 46px; height:46px; justify-content:center; width:46px; }
    .stat-blue { background:#dbeafe; color:#1d4ed8; }
    .stat-green { background:#dcfce7; color:#15803d; }
    .stat-cyan { background:#cffafe; color:#0e7490; }
    .stat-amber { background:#fef3c7; color:#b45309; }
    .product-panel { padding:18px; }
    .product-panel-title { margin-bottom:16px; }
    .product-panel-title h5 { color:#111827; font-size:18px; font-weight:700; margin:0 0 3px; }
    .product-panel-title p { color:#6b7280; }
    .product-table thead th { background:#f9fafb; border-bottom:1px solid #e5e7eb; color:#4b5563; font-size:12px; font-weight:700; padding:13px 12px; text-transform:uppercase; white-space:nowrap; }
    .product-table tbody td { border-top:1px solid #edf0f4; color:#1f2937; padding:13px 12px; vertical-align:middle; }
    .product-thumb, .review-avatar { border-radius:50%; height:42px; width:42px; }
    .product-thumb { object-fit:cover; }
    .review-avatar { align-items:center; background:#2563eb; color:#fff; display:inline-flex; font-weight:700; justify-content:center; }
    @media (max-width:767px) { .product-page { padding:14px; } .product-header { align-items:flex-start; flex-direction:column; } .product-header-actions, .product-header-actions .btn { width:100%; } }
</style>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#reviewsTable').DataTable({
            pageLength: 15,
            order: [[2, 'desc']],
            language: {
                emptyTable: 'No review records found'
            }
        });
    }
});
</script>
@endsection
