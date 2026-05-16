@extends('admin.dashboard.master')

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff;">
<div class="container-fluid">

<h4 class="fw-bold mb-3">
    <i class="fa fa-tachometer-alt"></i> Quota Management
</h4>

<div class="row mb-3">
    <div class="col-md-12">
        <form action="{{ route('admin.quota-management.search') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search by company name, code, or email..." value="{{ $search ?? '' }}">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-search"></i> Search
            </button>
            <a href="{{ route('admin.quota-management.index') }}" class="btn btn-secondary ms-2">Reset</a>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Company</th>
                <th>Email</th>
                <th>Current Plan</th>
                <th>Vehicle Limit</th>
                <th>User Limit</th>
                <th>Driver Limit</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($companies as $company)
            <tr>
                <td>
                    <strong>{{ $company->company_name }}</strong>
                    <br>
                    <small class="text-muted">{{ $company->company_code }}</small>
                </td>
                <td>{{ $company->email }}</td>
                <td>
                    @if($company->subscription && $company->subscription->plan)
                        <span class="badge bg-primary">{{ $company->subscription->plan->name }}</span>
                    @else
                        <span class="badge bg-secondary">No Plan</span>
                    @endif
                </td>
                <td>
                    @if($company->subscription && $company->subscription->plan)
                        {{ $company->subscription->plan->vehicle_limit ?? '∞' }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($company->subscription && $company->subscription->plan)
                        {{ $company->subscription->plan->user_limit ?? '∞' }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($company->subscription && $company->subscription->plan)
                        {{ $company->subscription->plan->driver_limit ?? '∞' }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($company->status == 1)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.quota-management.show', $company) }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-cog"></i> Manage
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No companies found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center">
    {{ $companies->links() }}
</div>

</div>
</section>
@endsection
