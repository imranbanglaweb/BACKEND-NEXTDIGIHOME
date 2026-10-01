@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background-color:#eef2f7; padding-bottom: 40px;">

<div class="container mt-4">

    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fa fa-file-alt me-2"></i> Review Requisition
        </h2>
        <a href="{{ route('department.approvals.index') }}" class="btn btn-secondary btn-lg">
            <i class="fa fa-arrow-left me-2"></i> Back
        </a>
    </div>

    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4">

            <!-- Section Title -->
            <h4 class="fw-bold text-dark mb-3">
                <i class="fa fa-info-circle me-2 text-primary"></i> Requisition Information
            </h4>
            <hr>

            <!-- Requisition Info Grid -->
            <div class="row g-4 mb-4">

                <div class="col-md-4">
                    <div class="p-4 bg-white shadow-sm rounded-3 border text-center">
                        <p class="fw-bold fs-5 text-secondary mb-1">Requisition No</p>
                        <h4 class="fw-bold text-primary">{{ $requisition->requisition_number }}</h4>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 bg-white shadow-sm rounded-3 border text-center">
                        <p class="fw-bold fs-5 text-secondary mb-1">Requested By</p>
                        <h4 class="fw-bold text-dark">{{ $requisition->requestedBy->name }}</h4>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 bg-light shadow-sm rounded-3 border text-center">
                        <p class="fw-bold fs-5 text-secondary mb-1">Department</p>
                        <h4 class="fw-bold text-dark">{{ $requisition->department->department_name ?? '-' }}</h4>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 bg-light shadow-sm rounded-3 border text-center">
                        <p class="fw-bold fs-5 text-secondary mb-1">Unit</p>
                        <h4 class="fw-bold text-dark">{{ $requisition->unit->unit_name ?? '-' }}</h4>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 shadow-sm rounded-3 text-center">
                        <p class="fw-bold fs-5 text-white mb-1">NUmber Of Seat</p>
                        <h4 class="fw-bold text-white">{{ $requisition->number_of_passenger }}</h4>
                    </div>
                </div>

            </div>

            <!-- Passenger List -->
            <h4 class="fw-bold text-dark mb-3">
                <i class="fa fa-users me-2 text-success"></i> Passenger List
            </h4>
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Passenger Name</th>
                            <th>Designation</th>
                            <th>Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requisition->passengers as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $p->employee->name }}</td>
                            <td>{{ $p->employee->designation ?? '-' }}</td>
                            <td>{{ $p->employee->phone ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No passenger records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <hr>

            <!-- Approval Buttons -->
            <div class="text-center mt-4">
                <form id="actionForm">
                    @csrf

                    <div class="d-flex gap-3 justify-content-center">

                        <button type="button" class="btn btn-success btn-lg px-5"
                            onclick="submitApproval('approve')">
                            <i class="fa fa-thumbs-up me-2"></i> Approve
                        </button>

                        <button type="button" class="btn btn-danger btn-lg px-5"
                            onclick="submitApproval('reject')">
                            <i class="fa fa-thumbs-down me-2"></i> Reject
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

</section>

<!-- Script -->
<script>
// DEBUG: Log when page loads
console.log('[DEBUG] Department approval modal loaded for requisition:', {{ $requisition->id }});

function submitApproval(action) {
    console.log('[DEBUG] submitApproval called with action:', action);
    
    let url = action === 'approve'
        ? '{{ route("department.approvals.approve", $requisition->id) }}'
        : '{{ route("department.approvals.reject", $requisition->id) }}';
    
    console.log('[DEBUG] Target URL:', url);

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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
