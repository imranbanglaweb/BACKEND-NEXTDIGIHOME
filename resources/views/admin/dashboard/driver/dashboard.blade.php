@extends('admin.dashboard.master')
@section('main_content')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<script src="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<style>
    :root {
        --primary-dark: #1a1a2e;
        --secondary-dark: #16213e;
        --accent-blue: #0f3460;
        --success: #28a745;
        --warning: #ffc107;
        --info: #17a2b8;
        --danger: #dc3545;
    }
    
    body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }
    
    .page-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
        padding: 0px 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
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
    
    .page-header .datetime {
        color: rgba(255,255,255,0.9);
        text-align: right;
        font-size: 14px;
    }
    
    .page-header .datetime .date { font-weight: 600; font-size: 16px; }
    .page-header .datetime .time { opacity: 0.8; }
    
    .breadcrumbs {
        color: rgba(255,255,255,0.8);
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        gap: 5px;
        font-size: 13px;
    }
    
    .breadcrumbs li + li::before {
        content: "/";
        margin: 0 8px;
        opacity: 0.6;
    }
    
    .breadcrumbs a, .breadcrumbs span { color: rgba(255,255,255,0.8); text-decoration: none; }
    
    /* Driver Profile Card */
    .driver-profile-card {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
        border-radius: 12px;
        padding: 20px;
        color: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .driver-profile-card .driver-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 10px;
    }
    
    .driver-profile-card h4 { margin: 0 0 5px 0; font-weight: 700; }
    .driver-profile-card .license-info { opacity: 0.85; font-size: 13px; }
    
    .availability-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        margin-top: 10px;
    }
    
    .availability-badge.available { background: var(--success); color: white; }
    .availability-badge.busy { background: var(--warning); color: #000; }
    .availability-badge.on_leave { background: var(--danger); color: white; }
    
    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        border: 1px solid #e9ecef;
        height: 100%;
    }
    
    .stat-card:hover { box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); }
    
    .stat-card .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 12px;
    }
    
    .stat-card.pending .stat-icon { background: #fff3cd; color: #ffc107; }
    .stat-card.in-progress .stat-icon { background: #cce5ff; color: #0d6efd; }
    .stat-card.completed .stat-icon { background: #d4edda; color: #28a745; }
    .stat-card.total .stat-icon { background: #e2e3e5; color: #6c757d; }
    
    .stat-card .stat-title {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .stat-card .stat-value {
        font-size: 26px;
        font-weight: 700;
        color: #212529;
    }
    
    /* Table Cards */
    .table-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        border: 1px solid #e9ecef;
    }
    
    .table-card .card-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
        color: white;
        padding: 15px 20px;
        border: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .table-card .card-header h3 { margin: 0; font-size: 16px; font-weight: 600; }
    .table-card .card-header .badge { font-size: 12px; padding: 4px 10px; }
    
    .table thead th {
        background: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        color: #495057;
        font-weight: 600;
        padding: 12px 15px;
        font-size: 12px;
        text-transform: uppercase;
    }
    
    .table tbody td {
        padding: 12px 15px;
        border-bottom: 1px solid #e9ecef;
        color: #495057;
        font-size: 14px;
        vertical-align: middle;
    }
    
    .table tbody tr:hover { background: #f8f9fa; }
    .table tbody tr:last-child td { border-bottom: none; }
    
    /* Status Badges */
    .badge { padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-block; }
    .badge-pending { background: #fff3cd; color: #856404; }
    .badge-approved { background: #cce5ff; color: #084298; }
    .badge-in-transit { background: #d1e7dd; color: #0f5132; }
    .badge-completed { background: #d4edda; color: #146c43; }
    .badge-cancelled { background: #f8d7da; color: #842029; }
    
    /* Action Buttons */
    .btn-action {
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-start { background: var(--success); color: white; }
    .btn-start:hover { background: #218838; transform: translateY(-1px); }
    
    .btn-end { background: var(--info); color: white; }
    .btn-end:hover { background: #138496; transform: translateY(-1px); }
    
    /* Quick Links */
    .quick-link-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        text-decoration: none;
        color: #495057;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
    }
    
    .quick-link-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        color: var(--primary-dark);
        border-color: var(--primary-dark);
    }
    
    .quick-link-card .icon {
        font-size: 28px;
        margin-bottom: 10px;
        color: var(--primary-dark);
    }
    
    .quick-link-card .title { font-weight: 600; font-size: 14px; }
    .quick-link-card .subtitle { font-size: 12px; color: #6c757d; margin-top: 4px; }
    
    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
        color: white;
        border-radius: 12px;
        padding: 20px 25px;
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .welcome-banner h3 { margin: 0 0 5px 0; font-weight: 700; font-size: 20px; }
    .welcome-banner p { margin: 0; opacity: 0.85; }
    
    .welcome-banner .driver-status {
        text-align: right;
    }
    
    .welcome-banner .status-label {
        font-size: 12px;
        opacity: 0.8;
        margin-bottom: 5px;
    }
    
    .alert-warning-box {
        background: #fff3cd;
        border: 1px solid #ffc107;
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .alert-warning-box i { color: #856404; font-size: 20px; }
    .alert-warning-box strong { color: #856404; }
    .alert-warning-box span { color: #664d03; }
    
    .vehicle-info-box {
        background: linear-gradient(135deg, var(--accent-blue) 0%, var(--secondary-dark) 100%);
        color: white;
        border-radius: 12px;
        padding: 20px;
        height: 100%;
    }
    
    .vehicle-info-box h4 { margin: 0 0 15px 0; font-size: 15px; font-weight: 600; opacity: 0.9; }
    .vehicle-info-box .vehicle-name { font-size: 18px; font-weight: 700; margin-bottom: 5px; }
    .vehicle-info-box .plate-number { font-size: 14px; opacity: 0.85; }
</style>

<section role="main" class="content-body">
    <header class="page-header">
        <h2><i class="fa fa-id-card-alt"></i> Driver Dashboard</h2>
        <div class="datetime">
            <div class="date" id="currentDate"></div>
            <div class="time" id="currentTime"></div>
        </div>
        <div>
            <ol class="breadcrumbs">
                <li><a href="{{ route('home') }}"><i class="fa fa-home"></i></a></li>
                <li><span>Driver Portal</span></li>
                <li><span>Dashboard</span></li>
            </ol>
        </div>
    </header>

    <div class="container-fluid">
        @if(!$driver)
        <div class="alert-warning-box">
            <i class="fa fa-exclamation-triangle"></i>
            <div>
                <strong>No Driver Profile Found!</strong><br>
                <span>Your account is not linked to any driver profile. Please contact the administrator.</span>
            </div>
        </div>
        @endif

        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div>
                <h3><i class="fa fa-hand-wave mr-2"></i>Welcome, {{ Auth::user()->name }}!</h3>
                <p>Driver Dashboard - Manage your trips and track your performance</p>
            </div>
            @if($driver)
            <div class="driver-status">
                <div class="status-label">Your Status</div>
                <div class="availability-badge {{ $driver->availability_status ?? 'available' }}">
                    <i class="fa fa-circle"></i>
                    {{ ucfirst(str_replace('_', ' ', $driver->availability_status ?? 'Available')) }}
                </div>
            </div>
            @endif
        </div>

        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-3 col-6">
                <div class="stat-card pending">
                    <div class="stat-icon"><i class="fa fa-clock"></i></div>
                    <div class="stat-title">Pending Trips</div>
                    <div class="stat-value">{{ $pendingTripsCount ?? 0 }}</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card in-progress">
                    <div class="stat-icon"><i class="fa fa-route"></i></div>
                    <div class="stat-title">In Transit</div>
                    <div class="stat-value">{{ $activeTripsCount ?? 0 }}</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card completed">
                    <div class="stat-icon"><i class="fa fa-check-circle"></i></div>
                    <div class="stat-title">Completed Today</div>
                    <div class="stat-value">{{ $completedTripsCount ?? 0 }}</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card total">
                    <div class="stat-icon"><i class="fa fa-calendar-check"></i></div>
                    <div class="stat-title">Total Assigned</div>
                    <div class="stat-value">{{ $assignedTrips->count() ?? 0 }}</div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Active Trips Table -->
            <div class="col-lg-8 mb-4">
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title mb-0"><i class="fa fa-road mr-2"></i>Your Active Trips</h3>
                        @if($assignedTrips->count() > 0)
                        <span class="badge badge-in-transit">{{ $assignedTrips->count() }} Trip(s)</span>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        @if(isset($assignedTrips) && $assignedTrips->count() > 0)
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Req. No.</th>
                                        <th>Date</th>
                                        <th>Vehicle</th>
                                        <th>Route</th>
                                        <th>Passengers</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignedTrips as $trip)
                                    <tr>
                                        <td><strong>#{{ $trip->requisition_number ?? $trip->id }}</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($trip->travel_date)->format('d M Y') }}</td>
                                        <td>
                                            @if($trip->assignedVehicle)
                                                {{ $trip->assignedVehicle->vehicle_name ?? 'N/A' }}
                                                @if($trip->assignedVehicle->number_plate)
                                                    <br><small class="text-muted">{{ $trip->assignedVehicle->number_plate }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">Not Assigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $trip->from_location ?? 'N/A' }}
                                            <i class="fa fa-arrow-right mx-1 text-muted"></i>
                                            {{ $trip->to_location ?? 'N/A' }}
                                        </td>
                                        <td>{{ $trip->number_of_passenger ?? ($trip->passengers ? $trip->passengers->count() : 0) }}</td>
                                        <td>
                                            @switch($trip->transport_status)
                                                @case('Pending')
                                                    <span class="badge badge-pending">Pending</span>
                                                    @break
                                                @case('Approved')
                                                    <span class="badge badge-approved">Approved</span>
                                                    @break
                                                @case('In Transit')
                                                    <span class="badge badge-in-transit">In Transit</span>
                                                    @break
                                                @case('Completed')
                                                    <span class="badge badge-completed">Completed</span>
                                                    @break
                                                @default
                                                    <span class="badge badge-pending">{{ $trip->transport_status }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($trip->transport_status == 'Pending' || $trip->transport_status == 'Approved')
                                                <a href="{{ route('driver.trip.status') }}" class="btn-action btn-start">
                                                    <i class="fa fa-play"></i> Start
                                                </a>
                                            @elseif($trip->transport_status == 'In Transit')
                                                <a href="{{ route('driver.trip.status') }}" class="btn-action btn-end">
                                                    <i class="fa fa-flag-checkered"></i> End Trip
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="fa fa-route" style="font-size: 48px; opacity: 0.3; margin-bottom: 15px;"></i>
                            <p class="text-muted mb-0">No active trips assigned.</p>
                            <small class="text-muted">Check your schedule for upcoming trips.</small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            @php
                $displayVehicle = $driver->vehicle ?? $lastVehicle ?? null;
            @endphp
            <div class="col-lg-4">
                <!-- Vehicle Info -->
                @if($driver && $displayVehicle)
                <div class="vehicle-info-box mb-4">
                    <h4><i class="fa fa-truck mr-2"></i>Assigned Vehicle</h4>
                    <div class="vehicle-name">{{ $displayVehicle->vehicle_name ?? 'N/A' }}</div>
                    <div class="plate-number">{{ $displayVehicle->number_plate ?? '' }}</div>
                    <hr style="opacity: 0.3; margin: 15px 0;">
                    <div class="row text-center">
                        <div class="col-6">
                            <div style="font-size: 12px; opacity: 0.8;">Capacity</div>
                            <div style="font-weight: 600;">{{ $displayVehicle->capacity ?? 'N/A' }}</div>
                        </div>
                        <div class="col-6">
                            <div style="font-size: 12px; opacity: 0.8;">Type</div>
                            <div style="font-weight: 600;">{{ $displayVehicle->vehicleType->name ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
                @else
                <div class="vehicle-info-box mb-4">
                    <h4><i class="fa fa-truck mr-2"></i>Assigned Vehicle</h4>
                    <div class="text-center py-3">
                        <i class="fa fa-question-circle" style="font-size: 32px; opacity: 0.5;"></i>
                        <p class="mb-0 mt-2" style="opacity: 0.8;">No vehicle assigned</p>
                    </div>
                </div>
                @endif

                <!-- Driver Info Card -->
                @if($driver)
                <div class="driver-profile-card mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="driver-avatar">
                            <i class="fa fa-user"></i>
                        </div>
                        <div>
                            <h4>{{ $driver->driver_name ?? 'Driver' }}</h4>
                            <div class="license-info">
                                <i class="fa fa-id-card mr-1"></i>
                                License: {{ $driver->license_number ?? 'N/A' }}
                            </div>
                            <div class="license-info">
                                <i class="fa fa-phone mr-1"></i>
                                {{ $driver->mobile ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Links -->
        <div class="row mt-4">
            <div class="col-md-2 col-6 mb-3">
                <a href="{{ route('driver.live.tracking') }}" class="quick-link-card">
                    <div class="icon"><i class="fa fa-satellite-dish"></i></div>
                    <div class="title">Live Map</div>
                    <div class="subtitle">GPS Tracking</div>
                </a>
            </div>
            <div class="col-md-2 col-6 mb-3">
                <a href="{{ route('driver.trip.status') }}" class="quick-link-card">
                    <div class="icon"><i class="fa fa-clipboard-check"></i></div>
                    <div class="title">Trip Status</div>
                    <div class="subtitle">Start/End trips</div>
                </a>
            </div>
            <div class="col-md-2 col-6 mb-3">
                <a href="{{ route('driver.schedule') }}" class="quick-link-card">
                    <div class="icon"><i class="fa fa-calendar-alt"></i></div>
                    <div class="title">Schedule</div>
                    <div class="subtitle">View upcoming</div>
                </a>
            </div>
            <div class="col-md-2 col-6 mb-3">
                <a href="{{ route('driver.trips') }}" class="quick-link-card">
                    <div class="icon"><i class="fa fa-list"></i></div>
                    <div class="title">My Trips</div>
                    <div class="subtitle">All trips</div>
                </a>
            </div>
            <div class="col-md-2 col-6 mb-3">
                <a href="{{ route('driver.availability') }}" class="quick-link-card">
                    <div class="icon"><i class="fa fa-user-clock"></i></div>
                    <div class="title">Availability</div>
                    <div class="subtitle">Update status</div>
                </a>
            </div>
            <div class="col-md-2 col-6 mb-3">
                <a href="{{ route('driver.fuel.log') }}" class="quick-link-card">
                    <div class="icon"><i class="fa fa-gas-pump"></i></div>
                    <div class="title">Fuel Log</div>
                    <div class="subtitle">Log fuel</div>
                </a>
            </div>
            <div class="col-md-2 col-6 mb-3">
                <a href="{{ route('driver.vehicle') }}" class="quick-link-card">
                    <div class="icon"><i class="fa fa-truck-moving"></i></div>
                    <div class="title">My Vehicle</div>
                    <div class="subtitle">View details</div>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    // Update datetime
    function updateDateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
        document.getElementById('currentTime').textContent = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Start Trip confirmation
    $('.btn-start').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
            title: 'Start Trip?',
            text: 'Are you sure you want to start this trip?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-play me-1"></i> Yes, Start',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) window.location.href = url;
        });
    });

    // End Trip confirmation
    $('.btn-end').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
            title: 'End Trip?',
            text: 'Are you sure you want to end this trip?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-flag-checkered me-1"></i> Yes, End',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) window.location.href = url;
        });
    });
});
</script>
@endsection