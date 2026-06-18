@extends('admin.dashboard.master')

@section('title')
Email Templates
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    .template-shell {
        background: #f6f8fb;
        min-height: calc(100vh - 90px);
        padding: 24px 0;
    }
    .template-header {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: center;
        margin-bottom: 18px;
    }
    .template-title {
        color: #172033;
        font-size: 24px;
        font-weight: 700;
        margin: 0;
    }
    .template-subtitle {
        color: #667085;
        margin: 6px 0 0;
        font-size: 14px;
    }
    .stat-strip {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 16px;
    }
    .stat-tile {
        background: #fff;
        border: 1px solid #e6eaf0;
        border-radius: 8px;
        padding: 16px;
    }
    .stat-label {
        color: #667085;
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 700;
    }
    .stat-value {
        color: #172033;
        font-size: 28px;
        font-weight: 800;
        margin-top: 4px;
    }
    .filter-bar {
        align-items: end;
        background: #fff;
        border: 1px solid #e6eaf0;
        border-radius: 8px;
        display: flex;
        gap: 12px;
        justify-content: space-between;
        margin-bottom: 16px;
        padding: 14px;
    }
    .filter-field {
        min-width: 260px;
    }
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 14px;
    }
    .badge {
        font-size: 12px;
        padding: 7px 10px;
        border-radius: 999px;
    }
    .badge-type {
        background: #eef4ff;
        color: #175cd3;
    }
    .badge-active {
        background: #ecfdf3;
        color: #027a48;
    }
    .badge-inactive {
        background: #fef3f2;
        color: #b42318;
    }
    .template-card {
        border: 1px solid #e6eaf0 !important;
        border-radius: 8px !important;
    }
    @media (max-width: 767px) {
        .template-header,
        .filter-bar {
            align-items: stretch;
            flex-direction: column;
        }
        .stat-strip {
            grid-template-columns: 1fr;
        }
        .filter-field {
            min-width: 0;
        }
    }
</style>
@endpush

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page premium-form">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-envelope-open-text"></i> Digital Product Email Templates
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.email.test') }}" class="btn btn-sm btn-info mr-2">
                                <i class="fas fa-paper-plane"></i> Test Email
                            </a>
                            <a href="{{ route('email-templates.create') }}" class="btn btn-sm btn-success mr-2">
                                <i class="fas fa-plus-circle"></i> Add Template
                            </a>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Template Management:</strong> Manage purchase confirmation, payment, delivery, and access reminder emails for digital products.
                        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger small">{{ session('error') }}</div>
        @endif

        <div class="stat-strip">
            <div class="stat-tile">
                <div class="stat-label">Total Templates</div>
                <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
            </div>
            <div class="stat-tile">
                <div class="stat-label">Active Templates</div>
                <div class="stat-value">{{ $stats['active'] ?? 0 }}</div>
            </div>
            <div class="stat-tile">
                <div class="stat-label">Product Workflows</div>
                <div class="stat-value">{{ $stats['product'] ?? 0 }}</div>
            </div>
        </div>

        <div class="card card-outline card-primary template-card">
            <div class="card-header">
                <h5 class="card-title"><i class="fas fa-list"></i> Template Library</h5>
                <div class="card-tools template-filter-tools">
                    <select id="templateTypeFilter" class="form-control form-control-sm">
                        <option value="">All product templates</option>
                        @foreach($types as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="button" id="resetFilters" class="btn btn-sm btn-outline-secondary">
                        <i class="fa fa-rotate-left"></i> Reset
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive template-table-wrap">
                    <table id="emailTemplateTable" class="table table-striped table-bordered align-middle" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Type</th>
                                <th>Subject</th>
                                <th>Variables</th>
                                <th>Status</th>
                                <th>Updated</th>
                                <th width="18%">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
                    </div>
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
            { data: 'variables_count', name: 'variables_count', className: 'text-center', orderable: false, searchable: false },
            { data: 'is_active', name: 'is_active', className: 'text-center', orderable: false },
            { data: 'updated_at', name: 'updated_at', className: 'text-nowrap' },
            { data: 'preview', name: 'preview', orderable: false, searchable: false, className: 'text-center' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"></div>'
        },
    });

    $('#templateTypeFilter').on('change', function() {
        table.ajax.url("{{ route('email-templates.index') }}?type=" + encodeURIComponent($(this).val())).load();
    });

    $('#resetFilters').on('click', function() {
        $('#templateTypeFilter').val('');
        table.ajax.url("{{ route('email-templates.index') }}").load();
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
