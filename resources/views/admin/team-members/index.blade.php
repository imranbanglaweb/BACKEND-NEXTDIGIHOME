@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); min-height: 100vh; padding: 30px 0;">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1">
                            <i class="fas fa-users me-3"></i>Team Members Management
                        </h2>
                        <p class="text-white-50 mb-0">Manage team member profiles and information</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.team-members.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>Add Team Member
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
                                <i class="fas fa-users text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">{{ $teamMembers->total() }}</h3>
                        <p class="text-muted mb-0">Total Team Members</p>
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
                        <h3 class="text-success mb-1">{{ $teamMembers->where('is_active', true)->count() }}</h3>
                        <p class="text-muted mb-0">Active Members</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user-tie text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">{{ $teamMembers->unique('position')->count() }}</h3>
                        <p class="text-muted mb-0">Different Positions</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-linkedin text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">{{ $teamMembers->whereNotNull('linkedin_url')->count() }}</h3>
                        <p class="text-muted mb-0">With LinkedIn</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Members Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-users me-2"></i>All Team Members
                            </h5>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control form-control-sm" placeholder="Search team members..." style="width: 200px;">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Member</th>
                                        <th class="border-0 px-4 py-3">Position</th>
                                        <th class="border-0 px-4 py-3">Bio</th>
                                        <th class="border-0 px-4 py-3">Social Links</th>
                                        <th class="border-0 px-4 py-3">Status</th>
                                        <th class="border-0 px-4 py-3">Order</th>
                                        <th class="border-0 px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($teamMembers as $member)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                @if($member->image)
                                                    <img src="{{ asset($member->image) }}" alt="Team Member" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                        <span class="text-white fw-bold">{{ substr($member->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold">{{ $member->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-info">{{ $member->position }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <small class="text-muted">{{ Str::limit(strip_tags($member->bio), 50) ?: 'No bio' }}</small>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex gap-1">
                                                @if($member->linkedin_url)
                                                    <a href="{{ $member->linkedin_url }}" target="_blank" class="text-primary" title="LinkedIn">
                                                        <i class="fab fa-linkedin"></i>
                                                    </a>
                                                @endif
                                                @if($member->twitter_url)
                                                    <a href="{{ $member->twitter_url }}" target="_blank" class="text-info" title="Twitter">
                                                        <i class="fab fa-twitter"></i>
                                                    </a>
                                                @endif
                                                @if(!$member->linkedin_url && !$member->twitter_url)
                                                    <span class="text-muted">None</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-{{ $member->is_active ? 'success' : 'secondary' }}">
                                                {{ $member->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">{{ $member->sort_order }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.team-members.show', $member) }}" class="btn btn-outline-primary" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.team-members.edit', $member) }}" class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-outline-{{ $member->is_active ? 'secondary' : 'success' }}" title="{{ $member->is_active ? 'Deactivate' : 'Activate' }}"
                                                        onclick="toggleStatus({{ $member->id }})">
                                                    <i class="fas fa-{{ $member->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Delete"
                                                        onclick="confirmDelete({{ $member->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-users fa-3x mb-3"></i>
                                                <p>No team members found. <a href="{{ route('admin.team-members.create') }}">Add your first team member</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($teamMembers->hasPages())
                        <div class="card-footer bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $teamMembers->firstItem() }} to {{ $teamMembers->lastItem() }} of {{ $teamMembers->total() }} team members
                                </div>
                                {{ $teamMembers->links() }}
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
    if (confirm('Are you sure you want to toggle the status of this team member?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/team-members/${id}/toggle-status`;

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
    if (confirm('Are you sure you want to delete this team member? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/team-members/${id}`;

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