@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 30px 0;">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1">
                            <i class="fas fa-file-alt me-3"></i>Pages Management
                        </h2>
                        <p class="text-white-50 mb-0">Manage website page content sections</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.pages.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>Add Page Content
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
                                <i class="fas fa-file-alt text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">{{ $pageContents->total() }}</h3>
                        <p class="text-muted mb-0">Total Page Sections</p>
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
                        <h3 class="text-success mb-1">{{ $pageContents->where('is_active', true)->count() }}</h3>
                        <p class="text-muted mb-0">Active Sections</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-eye text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">{{ $pageContents->where('is_active', false)->count() }}</h3>
                        <p class="text-muted mb-0">Inactive Sections</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-layer-group text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">{{ $pageContents->unique('page')->count() }}</h3>
                        <p class="text-muted mb-0">Different Pages</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Contents Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-list me-2"></i>All Page Content Sections
                            </h5>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control form-control-sm" placeholder="Search content..." style="width: 200px;">
                                <select class="form-control form-control-sm" style="width: 120px;">
                                    <option>All Pages</option>
                                    <option>Home</option>
                                    <option>About</option>
                                    <option>Services</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Page</th>
                                        <th class="border-0 px-4 py-3">Section</th>
                                        <th class="border-0 px-4 py-3">Title</th>
                                        <th class="border-0 px-4 py-3">Content</th>
                                        <th class="border-0 px-4 py-3">Status</th>
                                        <th class="border-0 px-4 py-3">Order</th>
                                        <th class="border-0 px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pageContents as $content)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-info">{{ ucfirst($content->page) }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-secondary">{{ ucfirst($content->section) }}</span>
                                        </td>
                                        <td class="px-4 py-3 fw-bold">{{ $content->title ?: 'No Title' }}</td>
                                        <td class="px-4 py-3">
                                            <small class="text-muted">{{ Str::limit(strip_tags($content->content), 50) ?: 'No content' }}</small>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-{{ $content->is_active ? 'success' : 'secondary' }}">
                                                {{ $content->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">{{ $content->sort_order }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.pages.show', $content) }}" class="btn btn-outline-primary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.pages.edit', $content) }}" class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-outline-{{ $content->is_active ? 'secondary' : 'success' }}" title="{{ $content->is_active ? 'Deactivate' : 'Activate' }}"
                                                        onclick="toggleStatus({{ $content->id }})">
                                                    <i class="fas fa-{{ $content->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Delete"
                                                        onclick="confirmDelete({{ $content->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-file-alt fa-3x mb-3"></i>
                                                <p>No page content found. <a href="{{ route('admin.pages.create') }}">Create your first page content</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($pageContents->hasPages())
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $pageContents->firstItem() }} to {{ $pageContents->lastItem() }} of {{ $pageContents->total() }} page contents
                                </div>
                                {{ $pageContents->links() }}
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
    if (confirm('Are you sure you want to toggle the status of this page content?')) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/pages/${id}/toggle-status`;

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
    if (confirm('Are you sure you want to delete this page content? This action cannot be undone.')) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/pages/${id}`;

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