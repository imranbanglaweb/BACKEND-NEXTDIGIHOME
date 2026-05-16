@extends('admin.dashboard.master')

@section('title', 'GPS Device Details')

@section('main_content')
<section role="main" class="content-body" style="background:#fff">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="page-header shadow-sm bg-white rounded-3 px-3 py-3 mb-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3 flex-grow-1 min-width-0">
                            <span class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle flex-shrink-0" style="width:44px;height:44px;font-size:1.6rem;"><i class="fas fa-info-circle"></i></span>
                            <div class="min-width-0">
                                <h2 class="fw-bold mb-1 text-truncate" style="font-size:1.6rem;letter-spacing:-0.5px;">GPS Device Details</h2>
                                <div class="text-muted small text-truncate" style="max-width:350px;">View detailed information about this GPS device</div>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('admin.gps-devices.index') }}" class="btn btn-outline-primary btn-lg px-4 shadow-sm w-100 w-md-auto mt-2 mt-md-0">
                                <i class="fas fa-arrow-left me-2"></i> Back to Devices
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Device Information Card -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="mb-0 font-weight-bold">
                            <i class="fas fa-microchip text-primary me-2"></i>Device Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted">Device Name</label>
                                <p class="form-control-static">{{ $gpsDevice->device_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted">Device Type</label>
                                <p>
                                    <span class="badge" style="background-color: #4a90e2; color: white; padding: 0.5rem 0.75rem;">
                                        {{ $gpsDevice->device_type ?? 'N/A' }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted">IMEI Number</label>
                                <p class="form-control-static">
                                    <code style="background-color: #f8f9fa; padding: 0.5rem;">{{ $gpsDevice->imei_number }}</code>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted">SIM Number</label>
                                <p class="form-control-static">{{ $gpsDevice->sim_number ?? 'Not Available' }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted">Protocol</label>
                                <p>
                                    <span class="badge badge-info" style="padding: 0.5rem 0.75rem;">{{ $gpsDevice->protocol }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted">Status</label>
                                <p>
                                    @if(!$gpsDevice->is_active)
                                        <span class="badge bg-secondary" style="padding: 0.5rem 0.75rem;">Inactive</span>
                                    @elseif($gpsDevice->isOnline())
                                        <span class="badge bg-success" style="padding: 0.5rem 0.75rem;">
                                            <i class="fas fa-circle-notch fa-spin"></i> Online
                                        </span>
                                    @else
                                        <span class="badge bg-danger" style="padding: 0.5rem 0.75rem;">Offline</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted">Installation Date</label>
                                <p class="form-control-static">
                                    @if($gpsDevice->installation_date)
                                        {{ \Carbon\Carbon::parse($gpsDevice->installation_date)->format('d M Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-muted">Created Date</label>
                                <p class="form-control-static">{{ $gpsDevice->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Server Configuration Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="mb-0 font-weight-bold">
                            <i class="fas fa-server text-primary me-2"></i>Server Configuration
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label font-weight-bold text-muted">Server Host / IP Address</label>
                                <p class="form-control-static">
                                    <code style="background-color: #f8f9fa; padding: 0.5rem;">{{ $gpsDevice->server_host ?? 'Not Configured' }}</code>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold text-muted">Server Port</label>
                                <p class="form-control-static">
                                    <code style="background-color: #f8f9fa; padding: 0.5rem;">{{ $gpsDevice->server_port ?? '-' }}</code>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Card -->
                @if($gpsDevice->notes)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="mb-0 font-weight-bold">
                            <i class="fas fa-sticky-note text-primary me-2"></i>Notes
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="form-control-static">{{ $gpsDevice->notes }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Vehicle Assignment & Actions Sidebar -->
            <div class="col-lg-4">
                <!-- Vehicle Assignment Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="mb-0 font-weight-bold">
                            <i class="fas fa-car text-primary me-2"></i>Vehicle Assignment
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($gpsDevice->vehicle)
                            <div class="alert alert-info" style="border-left: 4px solid #0d6efd;">
                                <h6 class="alert-heading">{{ $gpsDevice->vehicle->vehicle_name }}</h6>
                                <p class="mb-1">
                                    <strong>Vehicle Number:</strong> {{ $gpsDevice->vehicle->vehicle_number }}
                                </p>
                                <p class="mb-1">
                                    <strong>Vehicle Type:</strong> {{ $gpsDevice->vehicle->vehicleType->name ?? 'N/A' }}
                                </p>
                                @if($gpsDevice->vehicle->driver)
                                <p class="mb-0">
                                    <strong>Driver:</strong> {{ $gpsDevice->vehicle->driver->name ?? 'N/A' }}
                                </p>
                                @endif
                            </div>
                        @else
                            <div class="alert alert-warning" style="border-left: 4px solid #ffc107;">
                                <p class="mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    This device is not assigned to any vehicle yet.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Device Status Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="mb-0 font-weight-bold">
                            <i class="fas fa-heartbeat text-primary me-2"></i>Device Status
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-muted">Online Status</label>
                            <div>
                                @if($gpsDevice->isOnline())
                                    <span class="badge bg-success" style="padding: 0.7rem 1rem; font-size: 0.95rem;">
                                        <i class="fas fa-circle-notch fa-spin me-1"></i> Online
                                    </span>
                                @else
                                    <span class="badge bg-danger" style="padding: 0.7rem 1rem; font-size: 0.95rem;">
                                        <i class="fas fa-times-circle me-1"></i> Offline
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-muted">Active Status</label>
                            <div>
                                @if($gpsDevice->is_active)
                                    <span class="badge bg-success" style="padding: 0.7rem 1rem; font-size: 0.95rem;">Active</span>
                                @else
                                    <span class="badge bg-secondary" style="padding: 0.7rem 1rem; font-size: 0.95rem;">Inactive</span>
                                @endif
                            </div>
                        </div>

                        @if($gpsDevice->latestLocation)
                        <div class="mb-3">
                            <label class="form-label font-weight-bold text-muted">Last Location</label>
                            <div class="bg-light p-3 rounded" style="border: 1px solid #e9ecf1;">
                                <p class="mb-1">
                                    <strong>Latitude:</strong> {{ number_format($gpsDevice->latestLocation->latitude, 6) }}
                                </p>
                                <p class="mb-1">
                                    <strong>Longitude:</strong> {{ number_format($gpsDevice->latestLocation->longitude, 6) }}
                                </p>
                                <p class="mb-0 text-muted">
                                    <small>Updated: {{ $gpsDevice->latestLocation->created_at->diffForHumans() }}</small>
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="mb-0 font-weight-bold">
                            <i class="fas fa-cog text-primary me-2"></i>Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.gps-devices.edit', $gpsDevice->id) }}" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-edit me-1"></i> Edit Device
                        </a>
                        <button type="button" class="btn btn-danger w-100" id="deleteBtn">
                            <i class="fas fa-trash me-1"></i> Delete Device
                        </button>
                        <form id="delete-form" action="{{ route('admin.gps-devices.destroy', $gpsDevice->id) }}" method="POST" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .page-header {
        padding: 2.5rem 0 2rem 0;
        animation: slideDown 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        background: linear-gradient(135deg, rgba(74, 144, 226, 0.05) 0%, rgba(74, 144, 226, 0.02) 100%);
        border-bottom: 2px solid #e9ecf1;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .page-title {
        color: #0f0f1e;
        font-weight: 900;
        font-size: 2.25rem;
        margin-bottom: 0.5rem;
        letter-spacing: -0.8px;
        text-shadow: 0 2px 4px rgba(15, 15, 30, 0.1);
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

    .form-label {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control-static {
        padding: 0.5rem 0;
        font-size: 0.95rem;
        word-break: break-word;
    }

    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 8px rgba(74, 144, 226, 0.08);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card:hover {
        box-shadow: 0 6px 20px rgba(74, 144, 226, 0.12);
        transform: translateY(-2px);
    }

    .card-header {
        background: linear-gradient(135deg, #fafbfc 0%, #f5f8fc 100%);
        border-radius: 12px 12px 0 0;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .page-title { font-size: 1.8rem; }
        .page-title i { font-size: 1.6rem; }
        .page-header .text-muted { font-size: 0.95rem; }
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Delete device with SweetAlert
    $('#deleteBtn').on('click', function(e) {
        e.preventDefault();
        var deviceName = '{{ $gpsDevice->device_name }}';

        Swal.fire({
            title: 'Delete GPS Device?',
            html: 'Are you sure you want to delete <strong>' + deviceName + '</strong>?<br><small class="text-muted">This action cannot be undone. All associated data will be removed.</small>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash me-2"></i>Yes, Delete',
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
                document.getElementById('delete-form').submit();
            }
        });
    });
});
</script>
@endpush
@endsection
