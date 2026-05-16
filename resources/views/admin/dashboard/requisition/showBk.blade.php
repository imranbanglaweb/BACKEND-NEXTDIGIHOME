@extends('admin.dashboard.master')

@section('main_content')
<style>
    .content-body {
        background-color: #fff !important;
        font-family: 'Poppins', sans-serif;
        padding:10px;
    }
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
        margin-bottom: 25px;
         padding:10px;
    }
    .card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }
    .card-header {
        background: linear-gradient(to right, #f8f9fa, #fff);
        border-bottom: 1px solid #eee;
        padding: 1.25rem 1.5rem;
        border-radius: 12px 12px 0 0 !important;
    }
    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
        display: flex;
        align-items: center;
    }
    .info-group {
        margin-bottom: 1.5rem;
    }
    .info-label {
        font-size: 1.45rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.4rem;
        font-weight: 600;
        padding: 10px;
    }
    .info-value {
        font-size: 1.15rem;
        font-weight: 500;
        color: #212529;
        padding:10px;
    }
    
    .info-value-purpose {
        font-size: 1.15rem;
        font-weight: 500;
        color: #212529;
        padding-left:20px;
    }
    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-right: 1.2rem;
        flex-shrink: 0;
    }
    .bg-soft-primary { background-color: #ebf2ff; color: #0088cc; }
    .bg-soft-success { background-color: #e6fffa; color: #00b894; }
    .bg-soft-warning { background-color: #fffaf0; color: #ed8936; }
    .bg-soft-info { background-color: #e6f7ff; color: #00a3bf; }
    .bg-soft-danger { background-color: #fff5f5; color: #f56565; }
    .bg-soft-purple { background-color: #f3e8ff; color: #805ad5; }

    .btn-back {
        background: #fff;
        color: #4a5568;
        border: 1px solid #cbd5e0;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        font-size: 1.4rem;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
    }
    .btn-back:hover {
        background: #f7fafc;
        color: #2d3748;
        border-color: #a0aec0;
        text-decoration: none;
    }
    
    .status-badge {
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-block;
    }
    .table thead th {
        background-color: #f1f5f9;
        color: #495057;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
        font-size: 1rem;
    }
    .table td {
        vertical-align: middle;
        font-size: 1rem;
    }
</style>

<section role="main" class="content-body">
    <div class="container-fluid py-4">
        
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1" style="font-size: 3rem;">Requisition Details</h2>
                <p class="text-muted mb-0" style="font-size: 1.1rem;">
                    Requisition No: <span class="text-primary fw-bold">#{{ $requisition->requisition_number }}</span>
                </p>
            </div>
            <a href="{{ route('requisitions.index') }}" class="btn btn-back shadow-sm">
                <i class="fa fa-arrow-left me-2"></i>&nbsp; Back to List
            </a>
        </div>

        <div class="row">
            {{-- Main Info Column --}}
            <div class="col-lg-8">
                
                {{-- Basic Information --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="section-title"><i class="fa fa-info-circle me-2 text-primary"></i>&nbsp; Basic Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center info-group">
                                    <div class="icon-box bg-soft-primary">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="info-label">Requested By</div>
                                        <div class="info-value">{{ $requisition->requestedBy->name ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center info-group">
                                    <div class="icon-box bg-soft-info">
                                        <i class="fa fa-building"></i>
                                    </div>
                                    <div>
                                        <div class="info-label">Department</div>
                                        <div class="info-value">{{ $requisition->department->department_name ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center info-group">
                                    <div class="icon-box bg-soft-success">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div>
                                        <div class="info-label">Passengers</div>
                                        <div class="info-value">{{ $requisition->number_of_passenger }} Persons</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center info-group">
                                    <div class="icon-box bg-soft-warning">
                                        <i class="fa fa-sitemap"></i>
                                    </div>
                                    <div>
                                        <div class="info-label">Unit</div>
                                        <div class="info-value">{{ $requisition->unit->unit_name ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Travel Itinerary --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="section-title"><i class="fa fa-map-signs me-2 text-success"></i>&nbsp; Travel Itinerary</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light h-100">
                                    <div class="d-flex align-items-center mb-3"  style="margin-left: 5px;">
                                        <i class="fa fa-map-marker text-danger me-2 fs-4"></i>
                                        <span class="fw-bold text-dark fs-5">&nbsp;From Location</span>
                                    </div>
                                    <p class="mb-0 fs-5 fw-bold text-secondary"  style="margin-left: 10px;">{{ $requisition->from_location }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light h-100">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fa fa-flag text-success me-2 fs-4"></i>
                                        <span class="fw-bold text-dark fs-5">To Location</span>
                                    </div>
                                    <p class="mb-0 fs-5 fw-bold text-secondary">{{ $requisition->to_location }}</p>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-group mt-3">
                                    <div class="info-label">Pickup Date & Time</div>
                                    <div class="info-value text-primary">
                                        <i class="fa fa-calendar me-2"></i>
                                        {{ $requisition->travel_date ? \Carbon\Carbon::parse($requisition->travel_date)->format('d M Y, h:i A') : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group mt-3">
                                    <div class="info-label">Return Date & Time</div>
                                    <div class="info-value text-danger">
                                        <i class="fa fa-calendar me-2"></i>
                                        {{ $requisition->return_date ? \Carbon\Carbon::parse($requisition->return_date)->format('d M Y, h:i A') : 'N/A' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr>
                                <div class="info-label mb-2" style="padding-left:20px">Purpose of Visit</div>
                                <div class="p-3 bg-light rounded  info-value-purpose">
                                    {{ $requisition->purpose }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right Column --}}
            <div class="col-lg-4">
                
                {{-- Status & Assignment --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="section-title"><i class="fa fa-tasks me-2 text-warning"></i> &nbsp;Status & Assignment</h5>
                    </div>
                    <div class="card-body p-4 text-center">
                        <div class="mb-4">
                            <div class="info-label mb-2">Current Status</div>
                            @if($requisition->status == 'Pending')
                                <span class="status-badge bg-warning text-dark">Pending Approval</span>
                            @elseif($requisition->status == 'Approved')
                                <span class="status-badge bg-success">Approved</span>
                            @elseif($requisition->status == 'Rejected')
                                <span class="status-badge bg-danger">Rejected</span>
                            @else
                                <span class="status-badge bg-secondary">{{ $requisition->status }}</span>
                            @endif
                        </div>

                        <div class="text-start bg-light p-3 rounded">
                            <div class="mb-3">
                                <div class="info-label">Assigned Vehicle</div>
                                <div class="d-flex">
                                    <div class="icon-box bg-white shadow-sm" style="width: 40px; height: 40px; font-size: 3rem; text-align:right">
                                        <i class="fa fa-car text-secondary"></i>
                                    </div>
                                    <span class="fw-bold fs-5">{{ $requisition->vehicle->vehicle_name ?? 'Not Assigned' }}</span>
                                </div>
                            </div>
                            <div>
                                <div class="info-label">Assigned Driver</div>
                                <div class="d-flex align-items-center mt-1">
                                    <div class="icon-box bg-white shadow-sm" style="width: 40px; height: 40px; font-size: 1rem; margin-right: 10px;">
                                        <i class="fa fa-id-card text-secondary"></i>
                                    </div>
                                    <span class="fw-bold fs-5">{{ $requisition->driver->driver_name ?? 'Not Assigned' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 text-start">
                            <div class="info-label">Created At</div>
                            <div class="text-muted">
                                <i class="fa fa-clock-o me-1"></i> {{ $requisition->created_at->format('d M Y, h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Passenger List --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="section-title"><i class="fa fa-list-ul me-2 text-purple"></i>&nbsp; Passenger List</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Name</th>
                                        <th>Dept.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($requisition->passengers as $p)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $p->employee->name }}</div>
                                            <small class="">{{ $p->employee->designation }}</small>
                                        </td>
                                        <td><span class="badge bg-light  border">{{ $p->employee->department->department_name ?? '-' }}</span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4 text-muted">
                                            <i class="fa fa-user-times mb-2 fs-3 d-block opacity-50"></i>
                                            No additional passengers
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
