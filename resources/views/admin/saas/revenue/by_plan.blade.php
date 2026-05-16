@extends('admin.dashboard.master')

@section('title','Revenue by Plan')

@section('main_content')
<section class="content-body py-4" style="background:#fff">
<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">
        <i class="fa fa-chart-line text-success"></i>
        Revenue by Plan
    </h2>
    <a href="{{ route('admin.dashboard.plans.index') }}" class="btn btn-outline-secondary">
        <i class="fa fa-arrow-left"></i> Back to Plans
    </a>
</div>

<div class="row g-4">
    <!-- Total Revenue Card -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-4">
                <h6 class="text-muted mb-2">Total Revenue</h6>
                <h1 class="fw-bold text-success mb-0">৳{{ number_format($totalRevenue, 2) }}</h1>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Table -->
<div class="card border-0 shadow-sm rounded-4 mt-4">
    <div class="card-header bg-primary bg-gradient text-white rounded-top-4 py-3">
        <h5 class="mb-0"><i class="fa fa-chart-bar"></i> Revenue Breakdown</h5>
    </div>
    <div class="card-body">
        <table class="table table-hover" id="revenueTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Plan Name</th>
                    <th>Total Amount</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($revenue as $r)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>
                        <span class="badge bg-primary">{{ $r->plan->name ?? 'N/A' }}</span>
                    </td>
                    <td>
                        <strong>৳{{ number_format($r->total, 2) }}</strong>
                    </td>
                    <td>
                        @if($totalRevenue > 0)
                        {{ round(($r->total / $totalRevenue) * 100, 1) }}%
                        @else
                        0%
                        @endif
                    </td>
                </tr>
                @endforeach
                @if($revenue->isEmpty())
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        No revenue data available
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