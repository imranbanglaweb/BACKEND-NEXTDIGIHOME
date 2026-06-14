@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body product-page">
    <div class="container-fluid">
        <div class="product-header">
            <div>
                <div class="product-eyebrow">Catalog</div>
                <h2>Digital Downloads</h2>
                <p>Track digital product files, purchase access, and customer download activity.</p>
            </div>
            <div class="product-header-actions">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Product
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i>Products
                </a>
            </div>
        </div>

        <div class="product-nav mb-3">
            <a href="{{ route('admin.products.index') }}">Products</a>
            <a href="{{ route('admin.products.downloads') }}" class="active">Downloads</a>
            <a href="{{ route('admin.products.reviews') }}">Reviews</a>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-xl-3 col-md-6">
                <div class="product-stat-card">
                    <span class="stat-icon stat-blue"><i class="fas fa-download"></i></span>
                    <div>
                        <small>Total Downloads</small>
                        <strong>{{ number_format($stats['downloads'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-stat-card">
                    <span class="stat-icon stat-green"><i class="fas fa-box"></i></span>
                    <div>
                        <small>Digital Products</small>
                        <strong>{{ number_format($stats['digital'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-stat-card">
                    <span class="stat-icon stat-cyan"><i class="fas fa-link"></i></span>
                    <div>
                        <small>With File URL</small>
                        <strong>{{ number_format($stats['with_file'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-stat-card">
                    <span class="stat-icon stat-amber"><i class="fas fa-dollar-sign"></i></span>
                    <div>
                        <small>Paid Revenue</small>
                        <strong>$ {{ number_format($stats['revenue'] ?? 0, 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-panel">
            <div class="product-panel-title">
                <div>
                    <h5>Download Products</h5>
                    <p>Digital products with delivery URLs and purchase/download activity.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table product-table" id="downloadsTable">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>File URL</th>
                            <th>Purchases</th>
                            <th>Paid Access</th>
                            <th>Downloads</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($product->thumbnail)
                                            <img src="{{ asset('public/storage/'.$product->thumbnail) }}" alt="{{ $product->name }}" class="product-thumb me-2">
                                        @else
                                            <span class="product-thumb product-thumb-empty me-2"><i class="fas fa-image"></i></span>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $product->name }}</div>
                                            <small class="text-muted">{{ $product->category }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($product->file_url)
                                        <a href="{{ $product->file_url }}" target="_blank" rel="noopener" class="text-primary">Open file</a>
                                    @else
                                        <span class="badge bg-warning text-dark">Missing URL</span>
                                    @endif
                                </td>
                                <td>{{ number_format($product->purchases_count) }}</td>
                                <td>{{ number_format($product->completed_purchases_count) }}</td>
                                <td>{{ number_format($product->purchases->sum('download_count')) }}</td>
                                <td>
                                    <span class="badge bg-{{ $product->active ? 'success' : 'secondary' }}">{{ $product->active ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-primary" title="View"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No digital products found.</td>
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
    .product-thumb { border-radius:8px; height:44px; object-fit:cover; width:44px; }
    .product-thumb-empty { align-items:center; background:#eef2f7; color:#94a3b8; display:inline-flex; justify-content:center; }
    @media (max-width:767px) { .product-page { padding:14px; } .product-header { align-items:flex-start; flex-direction:column; } .product-header-actions, .product-header-actions .btn { width:100%; } }
</style>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#downloadsTable').DataTable({
            pageLength: 15,
            order: [[2, 'desc']],
            language: {
                emptyTable: 'No digital products found'
            }
        });
    }
});
</script>
@endsection
