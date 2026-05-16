@extends('admin.dashboard.master')
@section('main_content')
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-dark: #4338ca;
        --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }
    
    body { font-family: 'Inter', sans-serif; }
    
    .page-header {
    background: #fff;
    padding: 0 25px;
    border-bottom: 1px solid var(--border-color);
    /* margin-bottom: 20px; */
    background-color:#000
}
    
    .page-header h2 {
        color: white;
        margin: 0;
        font-weight: 700;
        font-size: 22px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .right-wrapper {
        color: white;
    }
    
    .breadcrumbs {
        color: rgba(255,255,255,0.9);
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        gap: 5px;
    }
    
    .breadcrumbs li {
        display: flex;
        align-items: center;
    }
    
    .breadcrumbs li + li::before {
        content: "/";
        margin: 0 8px;
        opacity: 0.7;
    }
    
    .breadcrumbs a {
        color: rgba(255,255,255,0.9);
        text-decoration: none;
        transition: opacity 0.3s ease;
    }
    
    .breadcrumbs a:hover {
        opacity: 1;
    }
    
    .breadcrumbs span {
        color: rgba(255,255,255,0.7);
    }
    
    .card-premium {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    
    .card-premium .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }
    
    .card-premium .card-body {
        padding: 25px;
    }
    
    .table-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    
    .table-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }
    
    .table-card .card-body {
        padding: 0;
    }
    
    .table {
        margin: 0;
    }
    
    .table thead th {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        color: #4a5568;
        font-weight: 600;
        padding: 15px;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }
    
    .table tbody td {
        padding: 15px;
        border-bottom: 1px solid #e2e8f0;
        color: #4a5568;
    }
    
    .table tbody tr:hover {
        background: #f8fafc;
    }
    
    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-success {
        background: #10b981;
        color: white;
    }
    
    .badge-warning {
        background: #f59e0b;
        color: white;
    }
    
    .badge-info {
        background: #3b82f6;
        color: white;
    }
    
    .badge-secondary {
        background: #6b7280;
        color: white;
    }
    
    .alert-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 20px 25px;
        font-size: 15px;
    }
</style>


<section role="main" class="content-body">
    <header class="page-header">
        <h2><i class="fa fa-calendar-alt mr-2"></i>My Schedule</h2>
        <div class="right-wrapper">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{ route('home') }}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Driver Portal</span></li>
                <li><span>My Schedule</span></li>
            </ol>
        </div>
    </header>

    <div class="container-fluid">
        @if(!$driver)
        <div class="alert alert-warning mb-4">
            <i class="fa fa-exclamation-triangle mr-2"></i>
            <strong>No Driver Profile Found!</strong> Your account is not linked to any driver profile.
        </div>
        @endif
        
        <div class="row">
            <div class="col-md-12">
                @if(isset($schedules) && $schedules->count() > 0)
                <div class="table-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0"><i class="fa fa-list mr-2"></i>Upcoming Trip Schedule ({{ $schedules->count() }} Trips)</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Req. No.</th>
                                    <th>Travel Date</th>
                                    <th>Vehicle</th>
                                    <th>Route</th>
                                    <th>Purpose</th>
                                    <th>Passengers</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedules as $schedule)
                                <tr>
                                    <td><strong>#{{ $schedule->requisition_number ?? $schedule->id }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->travel_date)->format('d M Y') }}</td>
                                    <td>
                                        @if($schedule->assignedVehicle)
                                            {{ $schedule->assignedVehicle->vehicle_name ?? 'N/A' }}
                                            @if($schedule->assignedVehicle->number_plate)
                                                <br><small class="text-muted">{{ $schedule->assignedVehicle->number_plate }}</small>
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($schedule->from_location && $schedule->to_location)
                                            {{ $schedule->from_location }} <i class="fa fa-arrow-right mx-1 text-muted"></i> {{ $schedule->to_location }}
                                        @else
                                            {{ $schedule->from_location ?? 'N/A' }} - {{ $schedule->to_location ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td>{{ $schedule->purpose ?? 'N/A' }}</td>
                                    <td>
                                        @if($schedule->passengers && $schedule->passengers->count() > 0)
                                            {{ $schedule->passengers->count() }}
                                        @else
                                            {{ $schedule->number_of_passenger ?? 0 }}
                                        @endif
                                    </td>
                                    <td>
                                        @switch($schedule->transport_status)
                                            @case('Pending')
                                                <span class="badge badge-warning">Pending</span>
                                                @break
                                            @case('Approved')
                                                <span class="badge badge-info">Approved</span>
                                                @break
                                            @case('In Transit')
                                                <span class="badge badge-secondary">In Transit</span>
                                                @break
                                            @case('Completed')
                                                <span class="badge badge-success">Completed</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ ucfirst($schedule->transport_status) }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="card-premium">
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle mr-2"></i>
                            No upcoming trips scheduled. Contact dispatch if you expect assignments.
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
