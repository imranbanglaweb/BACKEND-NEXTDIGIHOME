@extends('admin.dashboard.master')

@section('title', 'Company Details - ' . $company->company_name)

@section('main_content')
<section class="content-body bg-white">
    <div class="container-fluid">

        <!-- Company Header -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">{{ $company->company_name }}</h4>
                        <p class="text-muted mb-0">{{ $company->company_code }}</p>
                    </div>
                    <div>
                        <span class="badge bg-{{ $company->status ? 'success' : 'danger' }} fs-6 me-2">
                            {{ $company->status ? 'Active' : 'Inactive' }}
                        </span>
                        @if($company->subscription)
                            <span class="badge bg-{{ $company->subscription->status === 'active' ? 'success' : 'warning' }} fs-6">
                                {{ $company->subscription->plan->name ?? 'Unknown Plan' }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Contact Information</h6>
                        <p><strong>Email:</strong> {{ $company->email ?: 'Not provided' }}</p>
                        <p><strong>Phone:</strong> {{ $company->contact_number ?: 'Not provided' }}</p>
                        <p><strong>Address:</strong> {{ $company->address ?: 'Not provided' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>System Information</h6>
                        <p><strong>Created:</strong> {{ $company->created_at->format('M d, Y H:i') }}</p>
                        <p><strong>Last Updated:</strong> {{ $company->updated_at->format('M d, Y H:i') }}</p>
                        @if($company->stripe_customer_id)
                            <p><strong>Stripe Customer:</strong> {{ $company->stripe_customer_id }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="btn-group">
                    <a href="{{ route('company.edit', $company) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Edit Company
                    </a>
                    @if($company->status)
                        <button class="btn btn-warning btn-sm" id="deactivateBtn">
                            <i class="fas fa-ban"></i> Deactivate
                        </button>
                    @else
                        <button class="btn btn-success btn-sm" id="reactivateBtn">
                            <i class="fas fa-check"></i> Reactivate
                        </button>
                    @endif
                    <button class="btn btn-info btn-sm" id="exportBtn">
                        <i class="fas fa-download"></i> Export Data
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Users
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $company->users()->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Vehicles
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $company->vehicles()->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-truck fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Departments
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $company->departments()->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-building fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Active Requisitions
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $company->requisitions()->where('status', 'active')->count() ?? 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-road fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usage Statistics -->
        @if(isset($usageStats))
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Usage Statistics</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($usageStats as $resource => $data)
                            <div class="col-md-3 mb-3">
                                <div class="card border-left-{{ $data['status'] === 'exceeded' ? 'danger' : ($data['status'] === 'warning' ? 'warning' : 'success') }}">
                                    <div class="card-body">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                            {{ ucfirst($resource) }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold">
                                            {{ $data['current'] }} / {{ $data['limit'] ?: '∞' }}
                                        </div>
                                        <div class="progress mt-2" style="height: 6px;">
                                            @php $progWidth = min(100, $data['percentage']); @endphp
                                            <div class="progress-bar" role="progressbar" style="width: {{ $progWidth }}%"></div>
                                        </div>
                                        @if($data['status'] === 'exceeded')
                                            <small class="text-danger">Limit exceeded!</small>
                                        @elseif($data['status'] === 'warning')
                                            <small class="text-warning">Approaching limit</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Quota Alerts -->
        @if(isset($quotaAlerts) && count($quotaAlerts) > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-left-warning">
                    <div class="card-header bg-warning text-white">
                        <h6 class="m-0 font-weight-bold">⚠️ Usage Alerts</h6>
                    </div>
                    <div class="card-body">
                        @foreach($quotaAlerts as $alert)
                        <div class="alert alert-{{ $alert['type'] === 'error' ? 'danger' : 'warning' }} mb-2">
                            <strong>{{ ucfirst($alert['resource']) }}:</strong> {{ $alert['message'] }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Subscription Details -->
        @if($company->subscription)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Subscription Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Plan:</strong> {{ $company->subscription->plan->name }}</p>
                                <p><strong>Status:</strong>
                                    <span class="badge bg-{{ $company->subscription->status === 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($company->subscription->status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Started:</strong> 
                                    @if($company->subscription->starts_at)
                                        {{ \Carbon\Carbon::parse($company->subscription->starts_at)->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                                <p><strong>Ends:</strong> 
                                    @if($company->subscription->ends_at)
                                        {{ \Carbon\Carbon::parse($company->subscription->ends_at)->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4">
                                @if($company->subscription->trial_ends_at)
                                    <p><strong>Trial Ends:</strong> {{ $company->subscription->trial_ends_at->format('M d, Y') }}</p>
                                @endif
                                <p><strong>Stripe ID:</strong> {{ $company->subscription->stripe_subscription_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Activity -->
        <div class="row">
            <!-- Recent Users -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Users</h6>
                    </div>
                    <div class="card-body">
                        @forelse($company->users()->latest()->take(5)->get() as $user)
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-grow-1">
                                    <strong>{{ $user->name }}</strong>
                                    <br><small class="text-muted">{{ $user->email }}</small>
                                </div>
                                <span class="badge bg-secondary">{{ $user->roles->first()?->name ?? 'User' }}</span>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No users found</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Vehicles -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Vehicles</h6>
                    </div>
                    <div class="card-body">
                        @forelse($company->vehicles()->latest()->take(5)->get() as $vehicle)
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-grow-1">
                                    <strong>{{ $vehicle->registration_number }}</strong>
                                    <br><small class="text-muted">{{ $vehicle->make_model ?? 'Unknown Model' }}</small>
                                </div>
                                <span class="badge bg-{{ $vehicle->status ? 'success' : 'secondary' }}">
                                    {{ $vehicle->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No vehicles found</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Deactivate Company Modal -->
<div class="modal fade" id="deactivateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deactivate Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to deactivate <strong>{{ $company->company_name }}</strong>? This will:</p>
                <ul>
                    <li>Prevent all users from accessing the system</li>
                    <li>Cancel their subscription</li>
                    <li>Keep all data intact for reactivation</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeactivate">Deactivate</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function deactivateCompany(companyId) {
    $('#deactivateModal').modal('show');
}

function reactivateCompany(companyId) {
    if (confirm('Are you sure you want to reactivate this company?')) {
        $.ajax({
            url: '{{ url("/admin/company") }}/' + companyId + '/reactivate',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Failed to reactivate company');
            }
        });
    }
}

function exportCompanyData(companyId) {
    window.open('{{ url("/admin/company") }}/' + companyId + '/export-data', '_blank');
}

$(document).ready(function() {
    $('#confirmDeactivate').click(function() {
        $.ajax({
            url: '{{ url("/admin/company") }}/{{ $company->id }}/deactivate',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#deactivateModal').modal('hide');
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Failed to deactivate company');
            }
        });
    });
});
</script>
@endsection