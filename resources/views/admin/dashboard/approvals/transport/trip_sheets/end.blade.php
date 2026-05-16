@extends('admin.dashboard.master')

@section('main_content')
<style>
    .trip-card {
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        border: none;
    }
    .info-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
        padding: 20px;
    }
    .info-box.vehicle { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
    .info-box.driver { background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%); }
    .info-box.meter { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
</style>

<section role="main" class="content-body" style="background-color:#fff;">
<br>
<div class="container-fluid mt-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary">
                <i class="fa fa-flag-checkered me-2"></i> End Trip
            </h2>
            <p class="text-muted mb-0">{{ $trip->trip_number }}</p>
        </div>
        <a href="{{ route('trip-sheets.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="row g-4">
        <!-- Trip Info Cards -->
        <div class="col-lg-4">
            <div class="info-box vehicle">
                <div class="d-flex align-items-center">
                    <i class="fa fa-car fa-2x me-3"></i>
                    <div>
                        <small class="opacity-75">Vehicle</small>
                        <div class="fw-bold fs-5">{{ $trip->vehicle->vehicle_name ?? 'N/A' }}</div>
                        <small>{{ $trip->vehicle->number_plate ?? '-' }}</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="info-box driver">
                <div class="d-flex align-items-center">
                    <i class="fa fa-user fa-2x me-3"></i>
                    <div>
                        <small class="opacity-75">Driver</small>
                        <div class="fw-bold fs-5">{{ $trip->driver->driver_name ?? 'N/A' }}</div>
                        <small>{{ $trip->driver->phone ?? '-' }}</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="info-box meter">
                <div class="d-flex align-items-center">
                    <i class="fa fa-tachometer-alt fa-2x me-3"></i>
                    <div>
                        <small class="opacity-75">Start Meter</small>
                        <div class="fw-bold fs-5">{{ number_format($trip->start_meter) }} KM</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Trip Form -->
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card trip-card">
                <div class="card-header bg-warning rounded-top-4">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fa fa-clipboard-check me-2"></i> Trip Completion Details
                    </h5>
                </div>
                <div class="card-body">
                    <form id="endTripForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" id="end_date" class="form-control form-control-lg" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">End Time <span class="text-danger">*</span></label>
                                <input type="time" name="end_time" id="end_time" class="form-control form-control-lg" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Closing Meter (KM) <span class="text-danger">*</span></label>
                                <input type="number" name="closing_meter" id="closing_meter" class="form-control form-control-lg" 
                                       placeholder="Enter current meter reading" min="0" required>
                                <small class="text-muted">Start meter: {{ number_format($trip->start_meter) }} KM</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">End Location <span class="text-danger">*</span></label>
                                <input type="text" name="end_location" id="end_location" class="form-control form-control-lg" 
                                       placeholder="Where did the trip end?" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">Remarks (Optional)</label>
                                <textarea name="remarks" id="remarks" class="form-control" rows="3" 
                                          placeholder="Any additional notes about the trip..."></textarea>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex gap-3">
                            <button type="button" onclick="submitEndTrip()" class="btn btn-warning btn-lg px-5 fw-bold">
                                <i class="fa fa-flag-checkered me-2"></i> Complete Trip
                            </button>
                            <a href="{{ route('trip-sheets.index') }}" class="btn btn-secondary btn-lg px-4">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Trip Summary Preview -->
        <div class="col-lg-4">
            <div class="card trip-card">
                <div class="card-header bg-dark text-white rounded-top-4">
                    <h5 class="mb-0 fw-bold">
                        <i class="fa fa-calculator me-2"></i> Trip Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Start Date:</span>
                        <span class="fw-semibold">{{ $trip->start_date ? date('d M Y', strtotime($trip->start_date)) : '-' }}</span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Start Meter:</span>
                        <span class="fw-semibold">{{ number_format($trip->start_meter) }} KM</span>
                    </div>
                    <hr>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">End Date:</span>
                        <span class="fw-semibold" id="previewEndDate">-</span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <span class="text-muted">Closing Meter:</span>
                        <span class="fw-semibold" id="previewClosingMeter">-</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Total Distance:</span>
                        <span class="fs-4 fw-bold text-success" id="previewTotalKm">0 KM</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){
    // Set default date/time to now
    var now = new Date();
    document.getElementById('end_date').value = now.toISOString().split('T')[0];
    document.getElementById('end_time').value = now.toTimeString().slice(0, 5);

    // Update preview on input change
    $('#closing_meter').on('input', calculateDistance);
    $('#end_date').on('change', function(){
        $('#previewEndDate').text($(this).val() ? formatDate($(this).val()) : '-');
    });

    function calculateDistance() {
        var closing = parseFloat($(this).val()) || 0;
        var startMeter = {{ $trip->start_meter ?? 0 }};
        var total = closing - startMeter;
        
        $('#previewClosingMeter').text(closing > 0 ? closing.toLocaleString() + ' KM' : '-');
        
        if (total > 0) {
            $('#previewTotalKm').text(total.toLocaleString() + ' KM').removeClass('text-danger').addClass('text-success');
        } else if (total < 0) {
            $('#previewTotalKm').text(total.toLocaleString() + ' KM').removeClass('text-success').addClass('text-danger');
        } else {
            $('#previewTotalKm').text('0 KM').removeClass('text-danger text-success');
        }
    }

    function formatDate(dateStr) {
        if (!dateStr) return '-';
        var date = new Date(dateStr);
        return date.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
    }
});

function submitEndTrip() {
    var startMeter = {{ $trip->start_meter ?? 0 }};
    var closingMeter = parseFloat($('#closing_meter').val()) || 0;
    var endDate = $('#end_date').val();
    var endTime = $('#end_time').val();
    var endLocation = $('#end_location').val();

    // Validation
    if (!endDate) {
        return Swal.fire({
            icon: 'warning',
            title: 'Missing End Date',
            text: 'Please select the trip end date.',
        });
    }

    if (!endTime) {
        return Swal.fire({
            icon: 'warning',
            title: 'Missing End Time',
            text: 'Please select the trip end time.',
        });
    }

    if (!closingMeter) {
        return Swal.fire({
            icon: 'warning',
            title: 'Missing Meter Reading',
            text: 'Please enter the closing meter reading.',
        });
    }

    if (closingMeter < startMeter) {
        return Swal.fire({
            icon: 'error',
            title: 'Invalid Meter Reading',
            text: 'Closing meter cannot be less than starting meter (' + startMeter.toLocaleString() + ')!',
        });
    }

    if (!endLocation.trim()) {
        return Swal.fire({
            icon: 'warning',
            title: 'Missing End Location',
            text: 'Please enter the trip end location.',
        });
    }

    Swal.fire({
        title: "Confirm Trip Completion",
        html: "Are you sure you want to end this trip?<br><br><strong>Total Distance:</strong> " + (closingMeter - startMeter).toLocaleString() + " KM",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#ffc107",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, Complete Trip"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('trip-sheets.end.save', $trip->id) }}",
                method: "POST",
                data: $("#endTripForm").serialize(),
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Trip Completed!',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        window.location.href = "{{ route('trip-sheets.index') }}";
                    }, 2000);
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: xhr.responseJSON?.message || "Trip end failed!",
                    });
                }
            });
        }
    });
}
</script>
@endsection
