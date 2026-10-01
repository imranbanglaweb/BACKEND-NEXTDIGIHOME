@extends('admin.dashboard.master')

@section('main_content')
<style>
    .text-secondary {
    color: #0088cc !important;
    font-size: 15px;
    font-weight: 700;
}
.text-dark {
    color: #000!important;
    font-size: 16px;
    font-weight: 600;
}
.table th,td{
    font-size: 15px!important;
    font-weight: 500!important;
}

.table th{
    font-size: 16px!important;
    font-weight: 500!important;
    color: #fff!important;
    background-color: #0088cc!important;
}
</style>
<section role="main" class="content-body" style="background-color:#eef2f7;">
<br>
<br>
    <div class="container py-4">

        <!-- PAGE TITLE -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">
                <i class="fa fa-file-alt me-2"></i> Requisition Review
            </h2>
        </div>
<br>
        <!-- CARD -->
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">

                <h4 class="fw-bold text-dark mb-3">
                    <i class="fa fa-info-circle me-2"></i> Requisition Information
                </h4>

                <hr>

                <!-- GRID INFO -->
                <div class="row g-4">

                    <div class="col-md-4">
                        <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                            <span class="fw-bold text-secondary">Requisition No</span>
                            <div class="fs-5 fw-bold text-dark">{{ $requisition->requisition_number }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                            <span class="fw-bold text-secondary">Requested By</span>
                            <div class="fs-5 fw-bold text-dark">{{ $requisition->requestedBy->name }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                            <span class="fw-bold text-secondary">Department</span>
                            <div class="fs-5 fw-bold text-dark">{{ $requisition->department->department_name }}</div>
                        </div>
                    </div>
</div>
<hr>
<div class="row">
                    <!-- Unit -->
                    <div class="col-md-4">
                        <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                            <span class="fw-bold text-secondary">Unit</span>
                            <div class="fs-5 fw-bold text-dark">{{ $requisition->unit->unit_name }}</div>
                        </div>
                    </div>

                    <!-- Passengers -->
                    <div class="col-md-4">
                        <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                            <span class="fw-bold text-secondary">Number of Passengers</span>
                            <div class="fs-5 fw-bold text-dark">{{ $requisition->number_of_passenger }}</div>
                        </div>
                    </div>

                    <!-- Created Date -->
                    <div class="col-md-4">
                        <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                            <span class="fw-bold text-secondary">Created Date</span>
                            <div class="fs-5 fw-bold text-dark">
                                {{ $requisition->created_at->format('d M Y, h:i A') }}
                            </div>
                        </div>
                    </div>
</div>
<div class="row">
                    <!-- Assigned Date -->
                    @if($requisition->assigned_date)
                    <div class="col-md-4">
                        <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                            <span class="fw-bold text-secondary">Assigned Date</span>
                            <div class="fs-5 fw-bold text-dark">
                                {{ \Carbon\Carbon::parse($requisition->assigned_date)->format('d M Y, h:i A') }}
                            </div>
                        </div>
                    </div>
                    @endif
<br>
                    <!-- From Location -->
                    <div class="col-md-4">
                        <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                            <span class="fw-bold text-secondary">From Location</span>
                            <div class="fs-5 fw-bold text-dark">{{ $requisition->from_location }}</div>
                        </div>
                    </div>

                    <!-- To Location -->
                    <div class="col-md-4">
                        <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                            <span class="fw-bold text-secondary">To Location</span>
                            <div class="fs-5 fw-bold text-dark">{{ $requisition->to_location }}</div>
                        </div>
                    </div>

                    <!-- Pickup Location -->
                    <div class="col-md-4">
                        <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                            <span class="fw-bold text-secondary">Pickup Location</span>
                            <div class="fs-5 fw-bold text-dark">{{ $requisition->pickup_location ?? 'N/A' }}</div>
                        </div>
                    </div>
<hr>
                </div>
<hr>
                <!-- Passenger List -->
                <h4 class="fw-bold text-dark mt-5 mb-3">
                    <i class="fa fa-users me-2"></i> Passenger List
                </h4>

                <table class="table table-bordered table-striped shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">SL</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requisition->passengers as $p)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $p->employee->name }}</td>
                                <td>{{ $p->employee->designation }}</td>
                                <td>{{ $p->employee->department->department_name ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <hr class="mt-4">

                <!-- ACTION BUTTONS -->
                <form id="actionForm" class="mt-4">
                    @csrf

                    <div class="d-flex gap-3">

                        <button type="button"
                            class="btn btn-success btn-lg px-4 fw-bold"
                            onclick="submitApproval('approve')">
                            <i class="fa fa-thumbs-up me-2"></i> Approve
                        </button>

                        <button type="button"
                            class="btn btn-danger btn-lg px-4 fw-bold"
                            onclick="submitApproval('reject')">
                            <i class="fa fa-thumbs-down me-2"></i> Reject
                        </button>

                        <a href="{{ route('department.approvals.index') }}"
                           class="btn btn-secondary btn-lg px-4 fw-bold">
                            <i class="fa fa-arrow-left me-2"></i> Back
                        </a>

                    </div>
                </form>

            </div>
        </div>

    </div>

</section>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
// DEBUG: Log when page loads
console.log('[DEBUG] Department approval page loaded for requisition:', {{ $requisition->id }});

function submitApproval(action) {
    console.log('[DEBUG] submitApproval called with action:', action);
    
    let url = action === 'approve'
        ? '{{ route("department.approvals.approve", $requisition->id) }}'
        : '{{ route("department.approvals.reject", $requisition->id) }}';
    
    console.log('[DEBUG] Target URL:', url);
    console.log('[DEBUG] Form data:', $("#actionForm").serialize());

    // Show confirmation modal before submitting
    Swal.fire({
        title: action === 'approve' ? 'Confirm Approval' : 'Confirm Rejection',
        text: action === 'approve' 
            ? 'Are you sure you want to approve this requisition?'
            : 'Are you sure you want to reject this requisition? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: action === 'approve' ? '#28a745' : '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: action === 'approve' ? 'Yes, Approve!' : 'Yes, Reject!'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('[DEBUG] User confirmed action:', action);
            
            $.ajax({
                url: url,
                method: "POST",
                data: $("#actionForm").serialize(),
                beforeSend: function() {
                    console.log('[DEBUG] AJAX request starting...');
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we process your request.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(res) {
                    console.log('[DEBUG] AJAX success response:', res);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: res.message || 'Action completed successfully',
                        timer: 2000,
                        showConfirmButton: true
                    });
                    setTimeout(() => {
                        window.location.href = "{{ route('department.approvals.index') }}";
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    console.log('[DEBUG] AJAX error:', {xhr: xhr, status: status, error: error});
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'Something went wrong! Please try again.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        } else {
            console.log('[DEBUG] User cancelled action:', action);
        }
    });
}
</script>

@endsection
