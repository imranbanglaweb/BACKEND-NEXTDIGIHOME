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
                            <i class="fas fa-images me-3"></i>Hero Sliders Management
                        </h2>
                        <p class="text-white-50 mb-0">Manage website hero slider content</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.hero-sliders.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>Add Hero Slider
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
                                <i class="fas fa-images text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">{{ $heroSliders->total() }}</h3>
                        <p class="text-muted mb-0">Total Sliders</p>
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
                        <h3 class="text-success mb-1">{{ $heroSliders->where('is_active', true)->count() }}</h3>
                        <p class="text-muted mb-0">Active Sliders</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-eye-slash text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">{{ $heroSliders->where('is_active', false)->count() }}</h3>
                        <p class="text-muted mb-0">Inactive Sliders</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-sort-numeric-up text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">{{ $heroSliders->max('sort_order') ?: 0 }}</h3>
                        <p class="text-muted mb-0">Highest Order</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Sliders Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-images me-2"></i>All Hero Sliders
                            </h5>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control form-control-sm" placeholder="Search sliders..." style="width: 200px;">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Image</th>
                                        <th class="border-0 px-4 py-3">Title</th>
                                        <th class="border-0 px-4 py-3">Subtitle</th>
                                        <th class="border-0 px-4 py-3">CTA Button</th>
                                        <th class="border-0 px-4 py-3">Status</th>
                                        <th class="border-0 px-4 py-3">Order</th>
                                        <th class="border-0 px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($heroSliders as $slider)
                                    <tr>
                                        <td class="px-4 py-3">
                                            @if($slider->image)
                                                <img src="{{ asset($slider->image) }}" alt="Slider Image" class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 40px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 fw-bold">{{ $slider->title ?: 'No Title' }}</td>
                                        <td class="px-4 py-3">
                                            <small class="text-muted">{{ Str::limit($slider->subtitle, 30) ?: 'No subtitle' }}</small>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($slider->cta_text)
                                                <span class="badge bg-primary">{{ $slider->cta_text }}</span>
                                            @else
                                                <span class="text-muted">No CTA</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-{{ $slider->is_active ? 'success' : 'secondary' }}">
                                                {{ $slider->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">{{ $slider->sort_order }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.hero-sliders.show', $slider) }}" class="btn btn-outline-primary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.hero-sliders.edit', $slider) }}" class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-outline-{{ $slider->is_active ? 'secondary' : 'success' }}" title="{{ $slider->is_active ? 'Deactivate' : 'Activate' }}"
                                                        onclick="toggleStatus({{ $slider->id }})">
                                                    <i class="fas fa-{{ $slider->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Delete"
                                                        onclick="confirmDelete({{ $slider->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-images fa-3x mb-3"></i>
                                                <p>No hero sliders found. <a href="{{ route('admin.hero-sliders.create') }}">Create your first hero slider</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($heroSliders->hasPages())
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $heroSliders->firstItem() }} to {{ $heroSliders->lastItem() }} of {{ $heroSliders->total() }} hero sliders
                                </div>
                                {{ $heroSliders->links() }}
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
    if (confirm('Are you sure you want to toggle the status of this hero slider?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/hero-sliders/${id}/toggle-status`;

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
    if (confirm('Are you sure you want to delete this hero slider? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/hero-sliders/${id}`;

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
