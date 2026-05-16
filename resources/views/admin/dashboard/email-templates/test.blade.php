@extends('admin.dashboard.master')

@section('title')
Test Email - Email Templates
@endsection

@section('main_content')
<section role="main" class="content-body" style="background-color: #fff;">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold text-primary">
                <br>
                <i class="fa fa-paper-plane"></i> Test Email Template
            </h4>
            <div class="btn-group pull-right">
                <a href="{{ route('email-templates.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back to Templates
                </a>
            </div>
        </div>
        <br>
        <br>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger small">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fa fa-cog"></i> Email Settings</h5>
                    </div>
                    <div class="card-body">
                        <form id="testEmailForm" method="POST" action="{{ route('admin.email.test.send') }}">
                            @csrf
                            
                            <div class="form-group mb-3">
                                <label>Select Template:</label>
                                <select name="template_id" id="templateSelect" class="form-control">
                                    <option value="">-- Select a Template --</option>
                                    @foreach($templates as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>Recipient Email:</label>
                                <input type="email" name="recipient_email" id="recipientEmail" class="form-control" placeholder="Enter email address" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>Subject:</label>
                                <input type="text" name="subject" id="emailSubject" class="form-control" placeholder="Email Subject" value="Test Email">
                            </div>

                            <div class="form-group mb-3">
                                <label>Custom Body (Optional):</label>
                                <textarea name="body" id="emailBody" class="form-control" rows="5" placeholder="Leave empty to use template content"></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <button type="button" class="btn btn-info btn-block" id="previewBtn">
                                    <i class="fa fa-eye"></i> Preview
                                </button>
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary btn-block" id="sendBtn">
                                    <i class="fa fa-paper-plane"></i> Send Test Email
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fa fa-envelope-open"></i> Email Preview</h5>
                        <button type="button" class="btn btn-sm btn-light" id="refreshPreview">
                            <i class="fa fa-sync"></i> Refresh
                        </button>
                    </div>
                    <div class="card-body email-preview-container">
                        <div id="previewFrame" class="preview-frame p-3">
                            <div class="text-center text-muted py-5">
                                <i class="fa fa-envelope-open fa-4x mb-3"></i>
                                <p>Select a template and click Preview to see the email content</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
    .badge {
        font-size: 15px;
    }
    .preview-frame {
        border: 1px solid #ddd;
        border-radius: 8px;
        min-height: 400px;
        background: #fff;
    }
    .email-preview-container {
        max-height: 500px;
        overflow-y: auto;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function() {
    // Preview Button Click
    $('#previewBtn').click(function() {
        let templateId = $('#templateSelect').val();
        let subject = $('#emailSubject').val();
        let body = $('#emailBody').val();

        if (!templateId && !body) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Data',
                text: 'Please select a template or enter custom body content'
            });
            return;
        }

        $('#previewFrame').html('<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-2x"></i><p class="mt-2">Loading preview...</p></div>');

        $.ajax({
            url: "{{ route('admin.email.test.preview') }}",
            type: 'POST',
            data: {
                template_id: templateId,
                subject: subject,
                body: body,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#previewFrame').html(response);
            },
            error: function(xhr) {
                let errorMsg = 'Failed to load preview';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                $('#previewFrame').html('<div class="alert alert-danger">' + errorMsg + '</div>');
            }
        });
    });

    // Refresh Preview Button
    $('#refreshPreview').click(function() {
        $('#previewBtn').click();
    });

    // Template Selection Change
    $('#templateSelect').change(function() {
        let templateId = $(this).val();
        if (templateId) {
            // Auto-preview when template is selected
            $('#previewBtn').click();
        }
    });

    // Form Submit
    $('#testEmailForm').submit(function(e) {
        e.preventDefault();
        
        let recipientEmail = $('#recipientEmail').val();
        if (!recipientEmail) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Email',
                text: 'Please enter a recipient email address'
            });
            return;
        }

        let formData = $(this).serialize();
        $('#sendBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Sending...');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Test email sent successfully!',
                    timer: 3000,
                    showConfirmButton: false
                });
                $('#sendBtn').prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Send Test Email');
            },
            error: function(xhr) {
                let errorMsg = 'Failed to send test email';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: errorMsg
                });
                $('#sendBtn').prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Send Test Email');
            }
        });
    });
});
</script>
@endpush
