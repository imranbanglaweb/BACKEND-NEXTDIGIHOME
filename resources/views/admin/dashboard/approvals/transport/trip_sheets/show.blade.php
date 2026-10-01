@extends('admin.dashboard.master')

@section('main_content')
<style>
    .info-label {
        color: #0088cc !important;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-value {
        color: #000 !important;
        font-size: 16px;
        font-weight: 600;
        margin-top: 4px;
    }
    .trip-card {
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        border: none;
    }
    .status-badge {
        font-size: 14px;
        padding: 8px 16px;
        border-radius: 20px;
    }
</style>
<section role="main" class="content-body" style="background-color:#fff;">
<br>
<div class="container-fluid py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">
                <i class="fa fa-route me-2"></i> Trip Sheet Details
            </h2>
            <p class="text-muted mb-0">{{ $trip->trip_number }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('trip-sheets.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left me-1"></i> Back to List
            </a>
            <button class="btn btn-primary" onclick="window.print()">
                <i class="fa fa-print me-1"></i> Print
            </button>
        </div>
    </div>

    <!-- Status Banner -->
    <div class="alert @if($trip->status == 'completed') alert-success @elseif($trip->status == 'in_progress') alert-warning @else alert-secondary @endif d-flex align-items-center mb-4 rounded-4">
        <i class="fa fa-info-circle me-2 fa-lg"></i>
        <div>
            <strong>Trip Status:</strong> 
            <span class="text-capitalize ms-1">{{ str_replace('_', ' ', $trip->status) }}</span>
        </div>
    </div>

    <div class="row g-4">
        <!-- Trip Information -->
        <div class="col-lg-4">
            <div class="card trip-card h-100">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h5 class="mb-0 fw-bold">
                        <i class="fa fa-clipboard-list me-2"></i> Trip Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="info-label">Trip Number</div>
                        <div class="info-value">{{ $trip->trip_number }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="info-label">Start Date & Time</div>
                        <div class="info-value">
                            {{ $trip->start_date ? date('d M Y', strtotime($trip->start_date)) : '-' }}
                            @if($trip->trip_start_time)
                                <span class="text-muted">at {{ date('h:i A', strtotime($trip->trip_start_time)) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="info-label">End Date & Time</div>
                        <div class="info-value">
                            {{ $trip->end_date ? date('d M Y', strtotime($trip->end_date)) : '-' }}
                            @if($trip->trip_end_time)
                                <span class="text-muted">at {{ date('h:i A', strtotime($trip->trip_end_time)) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="info-label">Start Location</div>
                        <div class="info-value">{{ $trip->start_location ?? 'N/A' }}</div>
                    </div>
                    <div class="mb-0">
                        <div class="info-label">End Location</div>
                        <div class="info-value">{{ $trip->end_location ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Requisition Details -->
        <div class="col-lg-4">
            <div class="card trip-card h-100">
                <div class="card-header bg-info text-white rounded-top-4">
                    <h5 class="mb-0 fw-bold">
                        <i class="fa fa-file-alt me-2"></i> Requisition Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="info-label">Requisition Number</div>
                        <div class="info-value">{{ $trip->requisition->requisition_number ?? 'N/A' }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="info-label">Requested By</div>
                        <div class="info-value">{{ optional($trip->requisition)->requestedBy->name ?? 'N/A' }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="info-label">Department</div>
                        <div class="info-value">{{ optional($trip->requisition)->department->department_name ?? 'N/A' }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="info-label">From Location</div>
                        <div class="info-value">{{ $trip->requisition->from_location ?? 'N/A' }}</div>
                    </div>
                    <div class="mb-0">
                        <div class="info-label">To Location</div>
                        <div class="info-value">{{ $trip->requisition->to_location ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vehicle & Driver -->
        <div class="col-lg-4">
            <div class="card trip-card h-100">
                <div class="card-header bg-success text-white rounded-top-4">
                    <h5 class="mb-0 fw-bold">
                        <i class="fa fa-car me-2"></i> Vehicle & Driver
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="info-label">Vehicle</div>
                        <div class="d-flex align-items-center mt-2">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="fa fa-car fa-lg text-primary"></i>
                            </div>
                            <div>
                                <div class="info-value">{{ $trip->vehicle->vehicle_name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $trip->vehicle->number_plate ?? '' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="info-label">Driver</div>
                        <div class="d-flex align-items-center mt-2">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="fa fa-user fa-lg text-success"></i>
                            </div>
                            <div>
                                <div class="info-value">{{ $trip->driver->driver_name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $trip->driver->phone ?? '' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trip Metrics -->
    @if($trip->status == 'completed')
    <div class="row g-4 mt-2">
        <div class="col-md-3">
            <div class="card trip-card">
                <div class="card-body text-center">
                    <i class="fa fa-tachometer-alt fa-2x text-primary mb-2"></i>
                    <div class="info-label">Start KM</div>
                    <div class="info-value fs-4">{{ number_format($trip->start_meter) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card trip-card">
                <div class="card-body text-center">
                    <i class="fa fa-tachometer-alt fa-2x text-success mb-2"></i>
                    <div class="info-label">End KM</div>
                    <div class="info-value fs-4">{{ number_format($trip->closing_meter) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card trip-card">
                <div class="card-body text-center">
                    <i class="fa fa-road fa-2x text-warning mb-2"></i>
                    <div class="info-label">Total KM</div>
                    <div class="info-value fs-4">{{ number_format($trip->total_km) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card trip-card">
                <div class="card-body text-center">
                    <i class="fa fa-gas-pump fa-2x text-danger mb-2"></i>
                    <div class="info-label">Fuel Used</div>
                    <div class="info-value fs-4">{{ $trip->fuel_used ?? '0' }} L</div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Passenger List -->
    @if($trip->requisition && $trip->requisition->passengers && $trip->requisition->passengers->count() > 0)
    <div class="card trip-card mt-4">
        <div class="card-header bg-dark text-white rounded-top-4">
            <h5 class="mb-0 fw-bold">
                <i class="fa fa-users me-2"></i> Passenger List ({{ $trip->requisition->passengers->count() }})
            </h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width:60px">#</th>
                        <th>Name</th>
                        <th>Employee Code</th>
                        <th>Designation</th>
                        <th>Mobile</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trip->requisition->passengers as $index => $passenger)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $passenger->employee->name ?? 'N/A' }}</td>
                        <td>{{ $passenger->employee->employee_code ?? '-' }}</td>
                        <td>{{ $passenger->employee->designation ?? '-' }}</td>
                        <td>{{ $passenger->employee->mobile ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Remarks -->
    @if($trip->remarks)
    <div class="card trip-card mt-4">
        <div class="card-header bg-secondary text-white rounded-top-4">
            <h5 class="mb-0 fw-bold">
                <i class="fa fa-comment me-2"></i> Remarks
            </h5>
        </div>
        <div class="card-body">
            <p class="mb-0">{{ $trip->remarks }}</p>
        </div>
    </div>
    @endif

</div>
</section>
@endsection
