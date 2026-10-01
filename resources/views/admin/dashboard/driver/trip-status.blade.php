@extends('admin.dashboard.master')
@section('main_content')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
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
    
    .badge-danger {
        background: #ef4444;
        color: white;
    }
    
    .btn-update {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    
    .btn-update:hover {
        transform: translateY(-2px);
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
        <h2><i class="fa fa-clipboard-check mr-2"></i>Update Trip Status</h2>
        <div class="right-wrapper">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{ route('home') }}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Driver Portal</span></li>
                <li><span>Trip Status</span></li>
            </ol>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if(!$driver)
        <div class="alert alert-warning mb-4">
            <i class="fa fa-exclamation-triangle mr-2"></i>
            <strong>No Driver Profile Found!</strong> Your account is not linked to any driver profile.
        </div>
        @endif
        
        @if(isset($activeTrips) && $activeTrips->count() > 0)
                <div class="table-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0"><i class="fa fa-road mr-2"></i>Active Trips ({{ $activeTrips->count() }})</h3>
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
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeTrips as $trip)
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
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($trip->from_location && $trip->to_location)
                                            {{ $trip->from_location }} <i class="fa fa-arrow-right mx-1 text-muted"></i> {{ $trip->to_location }}
                                        @else
                                            {{ $trip->from_location ?? 'N/A' }} - {{ $trip->to_location ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td>{{ $trip->purpose ?? 'N/A' }}</td>
                                    <td>
                                        @if($trip->passengers && $trip->passengers->count() > 0)
                                            {{ $trip->passengers->count() }}
                                        @else
                                            {{ $trip->number_of_passenger ?? 0 }}
                                        @endif
                                    </td>
                                    <td>
                                        @switch($trip->transport_status)
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
                                                <span class="badge badge-secondary">{{ ucfirst($trip->transport_status) }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @if($trip->transport_status == 'Pending' || $trip->transport_status == 'Approved')
                                        <form action="{{ route('driver.trip.start', $trip->id) }}" method="POST" style="display: inline;" class="trip-form">
                                            @csrf
                                            <button type="submit" class="btn-update">
                                                <i class="fa fa-play mr-1"></i>Start Trip
                                            </button>
                                        </form>
                                        @elseif($trip->transport_status == 'In Transit')
                                        <form action="{{ route('driver.trip.end', $trip->id) }}" method="POST" style="display: inline;" class="trip-form">
                                            @csrf
                                            <button type="submit" class="btn-update">
                                                <i class="fa fa-flag-checkered mr-1"></i>End Trip
                                            </button>
                                        </form>
                                        @endif
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
                            No active trips. You will see trips here when assigned by dispatch.
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script>
$(document).ready(function() {
    // Handle form submission via AJAX
    $('.trip-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var url = form.attr('action');
        var button = form.find('button');
        var originalText = button.html();
        var isStartTrip = button.find('.fa-play').length > 0;
        
        Swal.fire({
            title: isStartTrip ? 'Start Trip?' : 'Complete Trip?',
            text: isStartTrip ? 'Are you sure you want to start this trip?' : 'Are you sure you want to complete this trip?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: isStartTrip ? '<i class="fa fa-play me-1"></i> Yes, Start' : '<i class="fa fa-check me-1"></i> Yes, Complete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message || 'Trip updated successfully!',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'An error occurred.',
                                confirmButtonText: 'OK'
                            });
                            button.prop('disabled', false).html(originalText);
                        }
                    },
                    error: function(xhr) {
                        var message = 'An error occurred. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: message,
                            confirmButtonText: 'OK'
                        });
                        button.prop('disabled', false).html(originalText);
                    }
                });
            }
        });
    });
});
</script>
@endsection
