@extends('admin.dashboard.master')

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff;">
<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">
        <i class="fa fa-building"></i> Quota Management: {{ $company->company_name }}
    </h4>
    <div>
        <a href="{{ route('admin.quota-management.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Back
        </a>
        <form action="{{ route('admin.quota-management.clear-cache', $company) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-warning" onclick="return confirm('Clear cache for this company?')">
                <i class="fa fa-sync"></i> Clear Cache
            </button>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <!-- Company Info -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fa fa-info-circle"></i> Company Info</h5>
            </div>
            <div class="card-body">
                <p><strong>Company Name:</strong> {{ $company->company_name }}</p>
                <p><strong>Company Code:</strong> {{ $company->company_code }}</p>
                <p><strong>Email:</strong> {{ $company->email }}</p>
                <p><strong>Contact:</strong> {{ $company->contact_number }}</p>
                <p><strong>Status:</strong> 
                    @if($company->status == 1)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Current Plan -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fa fa-credit-card"></i> Current Plan</h5>
            </div>
            <div class="card-body">
                @if($company->subscription && $company->subscription->plan)
                    <p><strong>Plan Name:</strong> {{ $company->subscription->plan->name }}</p>
                    <p><strong>Price:</strong> ৳{{ number_format($company->subscription->plan->price) }}</p>
                    <p><strong>Billing Cycle:</strong> {{ $company->subscription->plan->billing_cycle }}</p>
                    <p><strong>Status:</strong> {{ $company->subscription->status }}</p>
                    <p><strong>Started:</strong> 
                        @if($company->subscription->starts_at)
                            {{ is_string($company->subscription->starts_at) ? $company->subscription->starts_at : $company->subscription->starts_at->format('Y-m-d') }}
                        @else
                            N/A
                        @endif
                    </p>
                @else
                    <p class="text-muted">No active subscription</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Assign Plan -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fa fa-exchange-alt"></i> Change Plan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.quota-management.assign-plan', $company) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Select Plan</label>
                        <select name="plan_id" class="form-select" required>
                            <option value="">-- Select Plan --</option>
                            @foreach(\App\Models\SubscriptionPlan::where('is_active', true)->get() as $plan)
                                <option value="{{ $plan->id }}" 
                                    {{ ($company->subscription && $company->subscription->plan_id == $plan->id) ? 'selected' : '' }}>
                                    {{ $plan->name }} (৳{{ number_format($plan->price) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Assign Plan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Quota Stats -->
<div class="row mb-4">
    <div class="col-12">
        <h5 class="fw-bold mb-3"><i class="fa fa-chart-bar"></i> Current Usage</h5>
    </div>
    <div class="col-md-2">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3>{{ $stats['vehicles']['current'] ?? 0 }}</h3>
                <p class="mb-0">Vehicles</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h3>{{ $stats['users']['current'] ?? 0 }}</h3>
                <p class="mb-0">Users</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3>{{ $stats['drivers']['current'] ?? 0 }}</h3>
                <p class="mb-0">Drivers</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3>{{ $stats['reports']['current'] ?? 0 }}</h3>
                <p class="mb-0">Reports</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <h3>{{ $stats['maintenance_alerts']['current'] ?? 0 }}</h3>
                <p class="mb-0">Alerts</p>
            </div>
        </div>
    </div>
</div>

<!-- Quota Alerts -->
@if(!empty($alerts))
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-warning">
            <h5><i class="fa fa-exclamation-triangle"></i> Quota Alerts</h5>
            <ul class="mb-0">
                @foreach($alerts as $alert)
                    <li>{{ $alert['message'] }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<!-- Edit Quota Limits -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fa fa-edit"></i> Edit Quota Limits</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.quota-management.update', $company) }}" method="POST" class="row">
                    @csrf
                    @method('PUT')
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Vehicle Limit</label>
                        <input type="number" name="vehicle_limit" class="form-control" 
                            value="{{ $company->subscription?->plan?->vehicle_limit ?? '' }}" 
                            placeholder="Leave empty for unlimited">
                        <small class="text-muted">0 = unlimited</small>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">User Limit</label>
                        <input type="number" name="user_limit" class="form-control" 
                            value="{{ $company->subscription?->plan?->user_limit ?? '' }}" 
                            placeholder="Leave empty for unlimited">
                        <small class="text-muted">0 = unlimited</small>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Driver Limit</label>
                        <input type="number" name="driver_limit" class="form-control" 
                            value="{{ $company->subscription?->plan?->driver_limit ?? '' }}" 
                            placeholder="Leave empty for unlimited">
                        <small class="text-muted">0 = unlimited</small>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Monthly Reports Limit</label>
                        <input type="number" name="monthly_reports" class="form-control" 
                            value="{{ $company->subscription?->plan?->monthly_reports ?? '' }}" 
                            placeholder="Leave empty for unlimited">
                        <small class="text-muted">0 = unlimited</small>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Monthly Alerts Limit</label>
                        <input type="number" name="monthly_alerts" class="form-control" 
                            value="{{ $company->subscription?->plan?->monthly_alerts ?? '' }}" 
                            placeholder="Leave empty for unlimited">
                        <small class="text-muted">0 = unlimited</small>
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Update Quota
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
</section>
@endsection
