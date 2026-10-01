@extends('admin.dashboard.master')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1">
                            <i class="fas fa-comments me-3"></i>Testimonials Management
                        </h2>
                        <p class="text-white-50 mb-0">Manage customer testimonials and reviews</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>Add Testimonial
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-comments text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">{{ $testimonials->total() }}</h3>
                        <p class="text-muted mb-0">Total Testimonials</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-check-circle text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">{{ $testimonials->where('is_active', true)->count() }}</h3>
                        <p class="text-muted mb-0">Active Testimonials</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-star text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">{{ $testimonials->avg('rating') ? number_format($testimonials->avg('rating'), 1) : '0.0' }}</h3>
                        <p class="text-muted mb-0">Average Rating</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user-tie text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">{{ $testimonials->unique('company')->count() }}</h3>
                        <p class="text-muted mb-0">Different Companies</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-comments me-2"></i>All Testimonials
                            </h5>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control form-control-sm" placeholder="Search testimonials..." style="width: 200px;">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Customer</th>
                                        <th class="border-0 px-4 py-3">Position</th>
                                        <th class="border-0 px-4 py-3">Company</th>
                                        <th class="border-0 px-4 py-3">Rating</th>
                                        <th class="border-0 px-4 py-3">Content</th>
                                        <th class="border-0 px-4 py-3">Status</th>
                                        <th class="border-0 px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($testimonials as $testimonial)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                @if($testimonial->image)
                                                    <img src="{{ asset($testimonial->image) }}" alt="Customer" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                        <span class="text-white fw-bold">{{ substr($testimonial->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold">{{ $testimonial->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">{{ $testimonial->position ?: 'N/A' }}</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-secondary">{{ $testimonial->company ?: 'N/A' }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                                <span class="ms-2 text-muted">{{ $testimonial->rating }}/5</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <small class="text-muted">{{ Str::limit(strip_tags($testimonial->content), 60) }}</small>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-{{ $testimonial->is_active ? 'success' : 'secondary' }}">
                                                {{ $testimonial->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.testimonials.show', $testimonial) }}" class="btn btn-outline-primary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-outline-{{ $testimonial->is_active ? 'secondary' : 'success' }}" title="{{ $testimonial->is_active ? 'Deactivate' : 'Activate' }}"
                                                        onclick="toggleStatus({{ $testimonial->id }})">
                                                    <i class="fas fa-{{ $testimonial->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Delete"
                                                        onclick="confirmDelete({{ $testimonial->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-comments fa-3x mb-3"></i>
                                                <p>No testimonials found. <a href="{{ route('admin.testimonials.create') }}">Create your first testimonial</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($testimonials->hasPages())
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $testimonials->firstItem() }} to {{ $testimonials->lastItem() }} of {{ $testimonials->total() }} testimonials
                                </div>
                                {{ $testimonials->links() }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function toggleStatus(id) {
    if (confirm('Are you sure you want to toggle the status of this testimonial?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/testimonials/${id}/toggle-status`;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        document.body.appendChild(form);
        form.submit();
    }
}

function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this testimonial? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/testimonials/${id}`;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
    }
    .rounded-circle {
        border-radius: 50% !important;
    }
    .badge-primary {
        background-color: #007bff;
    }
    .bg-primary { background-color: #007bff !important; }
    .bg-success { background-color: #28a745 !important; }
    .bg-warning { background-color: #ffc107 !important; }
    .bg-info { background-color: #17a2b8 !important; }
    .bg-danger { background-color: #dc3545 !important; }
    .bg-secondary { background-color: #6c757d !important; }
    .text-primary { color: #007bff !important; }
    .text-success { color: #28a745 !important; }
    .text-warning { color: #ffc107 !important; }
    .text-info { color: #17a2b8 !important; }
    .text-muted { color: #6c757d !important; }
    .text-white { color: #ffffff !important; }
    .text-white-50 { color: rgba(255,255,255,0.5) !important; }
</style>
@endsection
