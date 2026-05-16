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
                            <i class="fas fa-address-book me-3"></i>Contact Info Management
                        </h2>
                        <p class="text-white-50 mb-0">Manage contact information and details</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.contact-info.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>Add Contact Info
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
                                <i class="fas fa-address-book text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">{{ $contactInfos->total() }}</h3>
                        <p class="text-muted mb-0">Total Contact Items</p>
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
                        <h3 class="text-success mb-1">{{ $contactInfos->where('is_active', true)->count() }}</h3>
                        <p class="text-muted mb-0">Active Items</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-tags text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">{{ $contactInfos->unique('type')->count() }}</h3>
                        <p class="text-muted mb-0">Different Types</p>
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
                        <h3 class="text-primary mb-1">{{ $contactInfos->max('sort_order') ?: 0 }}</h3>
                        <p class="text-muted mb-0">Highest Order</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Info Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-address-book me-2"></i>All Contact Information
                            </h5>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control form-control-sm" placeholder="Search contact info..." style="width: 200px;">
                                <select class="form-control form-control-sm" style="width: 120px;">
                                    <option>All Types</option>
                                    <option>Phone</option>
                                    <option>Email</option>
                                    <option>Address</option>
                                    <option>Social</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Type</th>
                                        <th class="border-0 px-4 py-3">Title</th>
                                        <th class="border-0 px-4 py-3">Value</th>
                                        <th class="border-0 px-4 py-3">Description</th>
                                        <th class="border-0 px-4 py-3">Icon</th>
                                        <th class="border-0 px-4 py-3">Status</th>
                                        <th class="border-0 px-4 py-3">Order</th>
                                        <th class="border-0 px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($contactInfos as $contact)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-info">{{ ucfirst($contact->type) }}</span>
                                        </td>
                                        <td class="px-4 py-3 fw-bold">{{ $contact->title }}</td>
                                        <td class="px-4 py-3">
                                            <small class="text-muted">{{ Str::limit($contact->value, 30) }}</small>
                                        </td>
                                        <td class="px-4 py-3">
                                            <small class="text-muted">{{ Str::limit($contact->description, 40) ?: 'No description' }}</small>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($contact->icon)
                                                <i class="{{ $contact->icon }}"></i>
                                            @else
                                                <span class="text-muted">None</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-{{ $contact->is_active ? 'success' : 'secondary' }}">
                                                {{ $contact->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">{{ $contact->sort_order }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.contact-info.show', $contact) }}" class="btn btn-outline-primary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.contact-info.edit', $contact) }}" class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-outline-{{ $contact->is_active ? 'secondary' : 'success' }}" title="{{ $contact->is_active ? 'Deactivate' : 'Activate' }}"
                                                        onclick="toggleStatus({{ $contact->id }})">
                                                    <i class="fas fa-{{ $contact->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Delete"
                                                        onclick="confirmDelete({{ $contact->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-address-book fa-3x mb-3"></i>
                                                <p>No contact information found. <a href="{{ route('admin.contact-info.create') }}">Add your first contact info</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($contactInfos->hasPages())
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $contactInfos->firstItem() }} to {{ $contactInfos->lastItem() }} of {{ $contactInfos->total() }} contact info items
                                </div>
                                {{ $contactInfos->links() }}
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
    if (confirm('Are you sure you want to toggle the status of this contact info?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/contact-info/${id}/toggle-status`;

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
    if (confirm('Are you sure you want to delete this contact info? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/contact-info/${id}`;

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