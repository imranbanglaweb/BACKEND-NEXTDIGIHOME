@extends('admin.dashboard.master')

@section('title','Expiring Subscriptions')

@section('main_content')
<section class="content-body py-4" style="background:#fff">
<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">
        <i class="fa fa-exclamation-triangle text-warning"></i>
        Expiring Subscriptions
    </h2>
    <a href="{{ route('admin.dashboard.plans.index') }}" class="btn btn-outline-secondary">
        <i class="fa fa-arrow-left"></i> Back to Plans
    </a>
</div>

<div class="alert alert-warning mb-4">
    <i class="fa fa-info-circle me-2"></i>
    These subscriptions will expire within the next 7 days.
</div>

<!-- Expiring Subscriptions Table -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-warning bg-gradient text-dark rounded-top-4 py-3">
        <h5 class="mb-0"><i class="fa fa-clock"></i> Subscriptions Expiring Soon</h5>
    </div>
    <div class="card-body">
        <table class="table table-hover" id="expiringTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Company</th>
                    <th>Plan</th>
                    <th>Expires At</th>
                    <th>Days Left</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($subscriptions as $sub)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>
                        <strong>{{ $sub->company->name ?? 'N/A' }}</strong>
                    </td>
                    <td>
                        <span class="badge bg-primary">{{ $sub->plan->name ?? 'N/A' }}</span>
                    </td>
                    <td>
                        {{ $sub->ends_at->format('d M Y') }}
                    </td>
                    <td>
                        @php $daysLeft = now()->diffInDays($sub->ends_at); @endphp
                        <span class="badge bg-{{ $daysLeft <= 3 ? 'danger' : 'warning' }}">
                            {{ $daysLeft }} days
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-success">Active</span>
                    </td>
                </tr>
                @endforeach
                @if($subscriptions->isEmpty())
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        No subscriptions expiring soon
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

</div>
</section>
@endsection