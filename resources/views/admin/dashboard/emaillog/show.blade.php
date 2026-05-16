@extends('admin.dashboard.master')

@section('main_content')
<style>
    body {
        background: #fff !important;
    }
    .form-label {
        font-size: 1.7rem;
        font-weight: 600;
    }
    .card {
        border-radius: 16px;
        overflow: hidden;
    }
    .card-header {
        background: linear-gradient(135deg, #1e1e2f, #2a2a40);
        border-bottom: 0;
    }
    .detail-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 1.4rem;
    }
    .detail-value {
        font-size: 1.5rem;
        color: #212529;
    }
    .email-body {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        font-size: 1.5rem;
        line-height: 1.6;
        white-space: pre-wrap;
    }
    .status-badge {
        font-size: 1.4rem;
        padding: 8px 16px;
        border-radius: 30px;
    }
</style>

<section role="main" class="content-body" style="background:#fff">
    <div class="container-fluid p-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
                <h3 class="m-0">
                    <i class="fa fa-envelope-open me-2 text-warning"></i>
                    Email Log Details
                </h3>
                <div>
                    <a href="{{ route('emaillogs.index') }}" class="btn btn-secondary btn-sm me-2">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                    @if($emaillog->status === 'Failed')
                        <button type="button" class="btn btn-success btn-sm" onclick="resendEmail({{ $emaillog->id }})">
                            <i class="fa fa-paper-plane me-1"></i> Resend
                        </button>
                    @endif
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteEmailLog({{ $emaillog->id }})">
                        <i class="fa fa-trash me-1"></i> Delete
                    </button>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Status and Basic Info -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        @php
                            $statusClass = match($emaillog->status) {
                                'Sent' => 'bg-success',
                                'Failed' => 'bg-danger',
                                'Pending' => 'bg-warning',
                                default => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge status-badge {{ $statusClass }}">{{ $emaillog->status }}</span>
                    </div>
                </div>

                <!-- Email Details -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label detail-label">Recipient Email</label>
                            <div class="detail-value">{{ $emaillog->recipient_email }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label detail-label">Requisition</label>
                            <div class="detail-value">
                                @if($emaillog->requisition)
                                    <a href="{{ route('requisitions.show', $emaillog->requisition->id) }}">
                                        {{ $emaillog->requisition->requisition_number }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label detail-label">Subject</label>
                            <div class="detail-value">{{ $emaillog->subject }}</div>
                        </div>
                    </div>
                </div>

                <!-- Email Body -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label detail-label">Email Body</label>
                            <div class="email-body">{{ $emaillog->body }}</div>
                        </div>
                    </div>
                </div>

                <!-- Error Message (if failed) -->
                @if($emaillog->status === 'Failed' && $emaillog->error_message)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="alert alert-danger" style="font-size: 1.5rem;">
                            <h5 class="alert-heading"><i class="fa fa-exclamation-triangle me-2"></i>Failure Reason</h5>
                            <p class="mb-0">{{ $emaillog->error_message }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Timestamps -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label detail-label">Created At</label>
                            <div class="detail-value">{{ $emaillog->created_at->format('Y-m-d H:i:s') }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label detail-label">Sent At</label>
                            <div class="detail-value">
                                {{ $emaillog->sent_at ? $emaillog->sent_at->format('Y-m-d H:i:s') : 'Not sent yet' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label detail-label">Last Updated</label>
                            <div class="detail-value">{{ $emaillog->updated_at->format('Y-m-d H:i:s') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function resendEmail(id) {
    Swal.fire({
        title: 'Resend Email?',
        text: 'Are you sure you want to resend this email?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, resend it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/emaillogs/' + id + '/resend',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Something went wrong!', 'error');
                }
            });
        }
    });
}

function deleteEmailLog(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#eb3349',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            $.ajax({
                url: '{{ url("/emaillogs/") }}/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Email log has been deleted.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route('emaillogs.index') }}';
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.'
                    });
                }
            });
        }
    });
}
</script>
@endsection
