@extends('admin.dashboard.master')

@section('title', 'GPS Device Management')

@section('main_content')
<style>
    /* Premium Styling */
    * { box-sizing: border-box; }

    .page-header {
        /* padding: 2.5rem 0 2rem 0; */
        /* animation: slideDown 0.5s cubic-bezier(0.34, 1.56, 0.64, 1); */
        /* background: blue; */
        border-bottom: 2px solid #e9ecf1;
        border-radius: 8px;
        /* margin-bottom: 1.5rem; */
    }
.page-header h2 {
 
    line-height: 0px !important;

}
    .page-header h4 {
        margin: 0 0 0.5rem 0;
    }

    .page-header p {
        margin: 0;
    }

    .page-title {
        color: #0f0f1e;
        font-weight: 900;
        font-size: 2.25rem;
        margin-bottom: 0.5rem;
        letter-spacing: -0.8px;
        /* text-shadow: 0 2px 4px rgba(15, 15, 30, 0.1); */
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-title i {
        color: #4a90e2;
        font-size: 2rem;
        text-shadow: 0 2px 8px rgba(74, 144, 226, 0.2);
    }

    .page-header .text-muted {
        color: #5a6a7a !important;
        font-size: 1.05rem;
        font-weight: 500;
        letter-spacing: 0.2px;
        margin-top: 0.5rem;
    }

    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
    }

    .card:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    .card-body {
        padding: 1.75rem;
    }

    .form-control {
        border: 2px solid #e0e6ed;
        border-radius: 8px;
        height: 44px;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
        background-color: #ffffff;
        font-weight: 500;
    }

    .form-control:focus {
        border-color: #4a90e2;
        box-shadow: inset 0 2px 4px rgba(74, 144, 226, 0.08), 0 0 0 4px rgba(74, 144, 226, 0.12);
        outline: none;
        background-color: #fafbfc;
    }

    .form-control::placeholder {
        color: #a8b2c1;
        font-weight: 500;
    }

    .btn {
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 700;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        letter-spacing: 0.5px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.5s ease;
        z-index: 0;
    }

    .btn:hover::before { left: 100%; }

    .btn-primary {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #357abd 0%, #2a6ab5 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
    }

    .btn-secondary {
        background: #f8f9fa;
        border: 2px solid #d5dce3;
        color: #1a2332;
        transition: all 0.35s ease;
        font-weight: 700;
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #ffffff 0%, #f5f8fc 100%);
        border-color: #4a90e2;
        color: #4a90e2;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.2);
    }

    .badge {
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 6px;
    }

    .badge-info {
        background-color: #4a90e2;
        color: white;
    }

    .badge-warning {
        background-color: #ff9800;
        color: white;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        font-weight: 700;
        color: #1a2332;
        border-bottom: 2px solid #e9ecf1;
        background-color: #f8f9fa;
        padding: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f2f5;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateX(2px);
    }

    .btn-group .btn {
        margin: 0 3px;
        border-radius: 6px;
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
    }

    .btn-sm {
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
    }

    .btn-info {
        background-color: #0dcaf0;
        color: white;
        border: none;
    }

    .btn-info:hover {
        background-color: #0aa8cc;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(13, 202, 240, 0.3);
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
    }

    .d-flex {
        display: flex;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .align-items-center {
        align-items: center;
    }

    .text-center {
        text-align: center;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .g-3 {
        gap: 1rem;
    }

    .g-3 > * {
        flex: 1;
    }

    .w-100 {
        width: 100% !important;
    }

    .mb-2 {
        margin-bottom: 0.5rem;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }

    .mb-4 {
        margin-bottom: 1.5rem;
    }

    .mt-2 {
        margin-top: 0.5rem;
    }

    .me-1 {
        margin-right: 0.25rem;
    }

    .me-2 {
        margin-right: 0.5rem;
    }

    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
    }

    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecf1;
        padding: 1.5rem;
        border-radius: 0 0 12px 12px;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .page-header { padding: 2rem 0 1.5rem 0; margin-bottom: 1rem; }
        .page-title { font-size: 1.8rem; }
        .page-title i { font-size: 1.6rem; }
        .page-header .text-muted { font-size: 0.95rem; }
        .table-responsive { font-size: 0.9rem; }
        .g-3 { gap: 0.75rem; }
        .g-3 > * { flex: 0 1 100%; }
    }
</style>

<div class="page-content">
       <br>
        <!-- Filter Section -->
        <div class="row mb-3">
            <form id="filterForm" method="GET" action="{{ route('admin.gps-devices.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search by name, IMEI, SIM, vehicle..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="device_type" class="form-control">
                        <option value="">All Types</option>
                        @foreach($deviceTypes as $type)
                            <option value="{{ $type }}" {{ request('device_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="is_active" class="form-control">
                        <option value="">All Status</option>
                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.gps-devices.index') }}" class="btn btn-secondary w-100 mt-2">
                        <i class="fas fa-redo me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Data Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="gpsDevicesTable" class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Device Name</th>
                                        <th>Device Type</th>
                                        <th>IMEI Number</th>
                                        <th>SIM Number</th>
                                        <th>Protocol</th>
                                        <th>Vehicle</th>
                                        <th>Status</th>
                                        <th>Last Location</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                @include('admin.dashboard.gps-device.partials.table')
                            </table>
                        </div>
                    </div>
                    @if($devices->hasPages())
                    <div class="card-footer bg-white border-top-0">
                        {{ $devices->links('pagination::bootstrap-4') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
$(document).ready(function() {
    // AJAX filter form
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        var url = $form.attr('action') || window.location.href;
        var data = $form.serialize();
        $.ajax({
            url: url,
            type: 'GET',
            data: data,
            beforeSend: function() {
                $('#gpsDevicesTable tbody').html('<tr><td colspan="9" class="text-center"><span class="spinner-border spinner-border-sm text-primary"></span> Loading...</td></tr>');
            },
            success: function(response) {
                var html = $(response);
                var newTable = html.find('#gpsDevicesTable tbody');
                if (newTable.length) {
                    $('#gpsDevicesTable tbody').replaceWith(newTable);
                } else {
                    window.location.reload();
                }
                $('[data-toggle="tooltip"]').tooltip();
                bindDeleteButtons();
            },
            error: function() {
                $('#gpsDevicesTable tbody').html('<tr><td colspan="9" class="text-center text-danger">Failed to load data.</td></tr>');
            }
        });
    });
    function bindDeleteButtons() {
        $('.delete-device').off('click').on('click', function(e) {
            e.preventDefault();
            var deviceId = $(this).data('id');
            var deviceName = $(this).data('name');
            Swal.fire({
                title: 'Delete Device?',
                html: 'Are you sure you want to delete <strong>' + deviceName + '</strong>?<br><small class="text-muted">This action cannot be undone.</small>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-2"></i>Yes, Delete Device',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary ms-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting...',
                        html: 'Please wait while we delete the device.',
                        icon: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: (dialog) => {
                            Swal.showLoading();
                        }
                    });
                    document.getElementById('delete-form-' + deviceId).submit();
                }
            });
        });
    }
    bindDeleteButtons();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Delete device with SweetAlert
    $('.delete-device').on('click', function(e) {
        e.preventDefault();
        var deviceId = $(this).data('id');
        var deviceName = $(this).data('name');

        Swal.fire({
            title: 'Delete Device?',
            html: 'Are you sure you want to delete <strong>' + deviceName + '</strong>?<br><small class="text-muted">This action cannot be undone.</small>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash me-2"></i>Yes, Delete Device',
            cancelButtonText: 'Cancel',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary ms-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Deleting...',
                    html: 'Please wait while we delete the device.',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: (dialog) => {
                        Swal.showLoading();
                    }
                });

                // Submit the form
                document.getElementById('delete-form-' + deviceId).submit();
            }
        });
    });
});
</script>
@endpush
@endsection
