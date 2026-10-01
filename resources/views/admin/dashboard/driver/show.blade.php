@extends('admin.dashboard.master')

@section('main_content')

<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
    .view-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        padding: 20px;
    }
    .view-label {
        font-weight: 600;
        color: #333;
    }
    .view-value {
        color: #666;
    }
    .photo-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #ddd;
    }
</style>

<section role="main" class="content-body" style="background-color:#fff;">
    <div class="d-flex justify-content-between">
        <br>
        <h3>Driver Details</h3>
        <div>
            <a href="{{ route('drivers.index')}}" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Back to List</a>
        </div>
    </div>
    <br>
    <hr>

    <div class="view-card">
        <div class="row">
            <!-- Driver Photo -->
            <div class="col-md-4 text-center mb-4">
                @if($driver->photograph)
                    <img src="{{ asset('public/' . $driver->photograph) }}" alt="Driver Photo" class="photo-preview">
                @else
                    <img src="{{ asset('public/admin_resource/img/no-image.png') }}" alt="Driver Photo" class="photo-preview">
                @endif
                <h4 class="mt-3">{{ $driver->driver_name }}</h4>
                <span class="badge bg-primary">Driver</span>
            </div>

            <!-- Driver Information -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="view-label">Employee Code</div>
                        <div class="view-value">{{ $driver->employee->employee_code ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="view-label">Driver Name</div>
                        <div class="view-value">{{ $driver->driver_name }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="view-label">Unit</div>
                        <div class="view-value">{{ $driver->unit->unit_name ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="view-label">Department</div>
                        <div class="view-value">{{ $driver->department->department_name ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="view-label">License Number</div>
                        <div class="view-value">{{ $driver->license_number ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="view-label">License Type</div>
                        <div class="view-value">{{ $driver->licenseType->type_name ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="view-label">License Issue Date</div>
                        <div class="view-value">{{ $driver->license_issue_date ? date('d M, Y', strtotime($driver->license_issue_date)) : '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="view-label">Date of Birth</div>
                        <div class="view-value">{{ $driver->date_of_birth ? date('d M, Y', strtotime($driver->date_of_birth)) : '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="view-label">Mobile</div>
                        <div class="view-value">{{ $driver->mobile ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="view-label">NID</div>
                        <div class="view-value">{{ $driver->nid ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="view-label">Joining Date</div>
                        <div class="view-value">{{ $driver->joining_date ? date('d M, Y', strtotime($driver->joining_date)) : '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="view-label">Working Time Slot</div>
                        <div class="view-value">{{ $driver->working_time_slot ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="view-label">Leave Status</div>
                        <div class="view-value">
                            @if($driver->leave_status == 1)
                                <span class="badge bg-success">Available</span>
                            @else
                                <span class="badge bg-danger">On Leave</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="view-label">Present Address</div>
                        <div class="view-value">{{ $driver->present_address ?? '-' }}</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="view-label">Permanent Address</div>
                        <div class="view-value">{{ $driver->permanent_address ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

</section>

@endsection
