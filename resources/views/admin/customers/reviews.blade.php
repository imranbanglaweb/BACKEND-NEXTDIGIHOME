@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body customer-page">
    <div class="container-fluid">
        <div class="customer-header">
            <div>
                <div class="customer-eyebrow">Customers</div>
                <h2>Customer Reviews</h2>
                <p>Monitor customer feedback and published testimonial ratings.</p>
            </div>
            <div class="customer-header-actions">
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-primary">
                    <i class="fas fa-comments me-2"></i>Manage Testimonials
                </a>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-users me-2"></i>Customers
                </a>
            </div>
        </div>

        <div class="customer-nav mb-3">
            <a href="{{ route('admin.customers.index') }}">Customers</a>
            <a href="{{ route('admin.customer-groups.index') }}">Groups</a>
            <a href="{{ route('admin.customers.reviews') }}" class="active">Reviews</a>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-xl-3 col-md-6"><div class="customer-stat-card"><span class="stat-icon stat-amber"><i class="fas fa-star"></i></span><div><small>Average Rating</small><strong>{{ $stats['average'] ?? '0.0' }}</strong></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="customer-stat-card"><span class="stat-icon stat-blue"><i class="fas fa-comments"></i></span><div><small>Total Reviews</small><strong>{{ number_format($stats['total'] ?? 0) }}</strong></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="customer-stat-card"><span class="stat-icon stat-green"><i class="fas fa-check-circle"></i></span><div><small>Published</small><strong>{{ number_format($stats['active'] ?? 0) }}</strong></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="customer-stat-card"><span class="stat-icon stat-cyan"><i class="fas fa-thumbs-up"></i></span><div><small>Positive</small><strong>{{ number_format($stats['positive'] ?? 0) }}%</strong></div></div></div>
        </div>

        <div class="customer-panel mb-3">
            <div class="alert alert-info mb-0">
                <i class="fas fa-info-circle me-2"></i>
                This app stores customer-facing review content in the testimonials table. Use the testimonial manager for create, edit, publish, and hide actions.
            </div>
        </div>

        <div class="customer-panel">
            <div class="customer-panel-title">
                <div>
                    <h5>Review Records</h5>
                    <p>Real testimonial records currently available in the system.</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table customer-table" id="reviewsTable">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Company</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($review->image)
                                            <img src="{{ asset('public/admin_resource/assets/images/'.$review->image) }}" alt="{{ $review->name }}" class="customer-avatar me-2">
                                        @else
                                            <span class="customer-avatar customer-avatar-empty me-2">{{ strtoupper(substr($review->name, 0, 1)) }}</span>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $review->name }}</div>
                                            <small class="text-muted">{{ $review->position ?: 'No position' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $review->company ?: 'N/A' }}</td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                    <span class="ms-1 fw-bold">{{ $review->rating }}/5</span>
                                </td>
                                <td>{{ Str::limit($review->content, 120) }}</td>
                                <td><span class="badge bg-{{ $review->is_active ? 'success' : 'secondary' }}">{{ $review->is_active ? 'Published' : 'Hidden' }}</span></td>
                                <td class="text-center">
                                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-sm btn-outline-primary" title="Manage"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">No review records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<style>
    .customer-page { background:#f6f8fb; min-height:calc(100vh - 70px); padding:24px; }
    .customer-header { align-items:center; background:#111827; border-radius:8px; color:#fff; display:flex; justify-content:space-between; margin-bottom:18px; padding:22px 24px; }
    .customer-header h2 { font-size:26px; font-weight:700; margin:0 0 4px; }
    .customer-header p, .customer-panel-title p { margin:0; }
    .customer-header p { color:rgba(255,255,255,.72); }
    .customer-eyebrow { color:#60a5fa; font-size:12px; font-weight:700; text-transform:uppercase; }
    .customer-header-actions, .customer-nav { display:flex; flex-wrap:wrap; gap:10px; }
    .customer-nav { background:#fff; border:1px solid #e5e7eb; border-radius:8px; gap:8px; padding:10px; }
    .customer-nav a { border-radius:6px; color:#4b5563; font-size:13px; font-weight:700; padding:8px 12px; text-decoration:none; }
    .customer-nav a:hover, .customer-nav a.active { background:#111827; color:#fff; }
    .customer-stat-card, .customer-panel { background:#fff; border:1px solid #e5e7eb; border-radius:8px; box-shadow:0 8px 24px rgba(15,23,42,.06); }
    .customer-stat-card { align-items:center; display:flex; gap:14px; min-height:102px; padding:18px; }
    .customer-stat-card small { color:#6b7280; display:block; font-size:13px; margin-bottom:5px; }
    .customer-stat-card strong { color:#111827; display:block; font-size:24px; line-height:1; }
    .stat-icon { align-items:center; border-radius:8px; display:inline-flex; flex:0 0 46px; height:46px; justify-content:center; width:46px; }
    .stat-blue { background:#dbeafe; color:#1d4ed8; } .stat-green { background:#dcfce7; color:#15803d; } .stat-amber { background:#fef3c7; color:#b45309; } .stat-cyan { background:#cffafe; color:#0e7490; }
    .customer-panel { padding:18px; }
    .customer-panel-title { margin-bottom:16px; }
    .customer-panel-title h5 { color:#111827; font-size:18px; font-weight:700; margin:0 0 3px; }
    .customer-panel-title p { color:#6b7280; }
    .customer-table thead th { background:#f9fafb; border-bottom:1px solid #e5e7eb; color:#4b5563; font-size:12px; font-weight:700; padding:13px 12px; text-transform:uppercase; white-space:nowrap; }
    .customer-table tbody td { border-top:1px solid #edf0f4; color:#1f2937; padding:13px 12px; vertical-align:middle; }
    .customer-avatar { border-radius:50%; height:38px; object-fit:cover; width:38px; }
    .customer-avatar-empty { align-items:center; background:#2563eb; color:#fff; display:inline-flex; font-weight:700; justify-content:center; }
    @media (max-width:767px) { .customer-page { padding:14px; } .customer-header { align-items:flex-start; flex-direction:column; } .customer-header-actions, .customer-header-actions .btn { width:100%; } }
</style>

<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#reviewsTable').DataTable({ pageLength: 15, order: [[2, 'desc']] });
    }
});
</script>
@endsection
