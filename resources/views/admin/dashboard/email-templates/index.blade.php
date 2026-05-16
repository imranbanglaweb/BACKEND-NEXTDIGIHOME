@extends('admin.dashboard.master')

@section('title')
Email Templates
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
</style>
@endpush

@section('main_content')
<section role="main" class="content-body" style="background-color: #fff;">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold text-primary">
                <br>
                <i class="fa fa-envelope"></i> Email Templates
            </h4>
            <div class="btn-group pull-right">
                <a href="{{ route('admin.email.test') }}" class="btn btn-info btn-sm">
                    <i class="fa fa-paper-plane"></i> Test Email
                </a>
                <a href="{{ route('email-templates.create') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-plus-circle"></i> Add Template
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

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="emailTemplateTable" class="table table-striped table-bordered align-middle" style="width:100%">
                        <thead class="bg-primary text-white text-center">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Type</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Preview</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Preview Modal -->
<div class="modal" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="previewModalLabel"><i class="fa fa-eye"></i> Template Preview</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="previewContent" class="border rounded p-3" style="min-height: 300px; background: #fff;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
<style>
    .modal-backdrop.show {
        opacity: 0.5 !important;
    }
    #previewModal .modal-content {
        background: #fff;
    }
</style>
@endsection

@push('scripts')
<script>
$(function() {
    // Initialize DataTable
    let table = $('#emailTemplateTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('email-templates.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', width: '5%', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'type_label', name: 'type', orderable: false },
            { data: 'subject', name: 'subject' },
            { data: 'is_active', name: 'is_active', className: 'text-center', orderable: false },
            { data: 'preview', name: 'preview', orderable: false, searchable: false, className: 'text-center' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"></div>'
        },
    });

    // Toggle Status
    $(document).on('click', '.toggleStatusBtn', function() {
        let id = $(this).data('id');
        let isActive = $(this).data('active') == '1';
        let action = isActive ? 'deactivate' : 'activate';
        let newStatus = isActive ? '0' : '1';

        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to ${action} this template?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, ' + action + ' it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('email-templates.toggle-status') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        is_active: newStatus,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            table.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Something went wrong!'
                        });
                    }
                });
            }
        });
    });

    // Delete Template
    $(document).on('click', '.deleteTemplateBtn', function() {
        let id = $(this).data('id');
        let url = "{{ route('email-templates.destroy', ':id') }}".replace(':id', id);

        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            table.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Something went wrong!'
                        });
                    }
                });
            }
        });
    });

    // Preview Template
    $(document).on('click', '.previewTemplateBtn', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        
        $('#previewModalLabel').html('<i class="fa fa-eye"></i> Preview: ' + name);
        $('#previewContent').html('<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-2x"></i><p class="mt-2">Loading preview...</p></div>');
        
        $('#previewModal').modal('show');
        
        $.ajax({
            url: "{{ route('email-templates.preview', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(response) {
                $('#previewContent').html(response);
            },
            error: function() {
                $('#previewContent').html('<div class="alert alert-danger">Failed to load preview</div>');
            }
        });
    });
});
</script>
@endpush
