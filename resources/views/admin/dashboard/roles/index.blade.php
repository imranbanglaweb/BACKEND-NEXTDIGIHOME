@extends('admin.dashboard.master')

@section('main_content')
<section class="content-body" style="background-color:#fff; padding:20px;">
    <div class="container-fluid">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-dark">Role Management</h3>

            <div>
                @can('role-create')
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-info me-2">
                        <i class="fa fa-shield"></i> Permissions
                    </a>

                    <a href="{{ route('admin.roles.create') }}" class="btn btn-success">
                        <i class="fa fa-plus"></i> Create Role
                    </a>
                @endcan
            </div>
        </div>

        <!-- CARD -->
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <table id="rolesTable" class="table table-hover table-bordered w-100">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">#</th>
                            <th>Name</th>
                            <th width="180">Created At</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>

    </div>
</section>
@endsection


@push('scripts')
<script>
    // Show toast notification on page load if session success exists
    @if(session('success'))
        showPremiumToast(
            'success',
            '<i class="fas fa-check-circle me-2"></i>Success',
            '{{ session('success') }}',
            5000
        );
    @endif

    @if(session('error'))
        showPremiumToast(
            'error',
            '<i class="fas fa-times-circle me-2"></i>Error',
            '{{ session('error') }}',
            5000
        );
    @endif
</script>

<script>
$(document).ready(function () {

    /* ==============================
       DATATABLE INITIALIZATION
    =============================== */
    let table = $('#rolesTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('admin.roles.data') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', orderable: false, searchable: false }
        ],
        language: {
            processing: "Loading roles..."
        }
    });

    /* ==============================
       DELETE ROLE (Premium Confirm)
    =============================== */
    $(document).on('click', '.deleteRole', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: '<span style="font-size: 18px;"><i class="fas fa-exclamation-triangle me-2" style="color: #f59e0b;"></i>Delete Role?</span>',
            html: '<span style="color: #64748b; font-size: 14px;">This action cannot be undone and all permissions assigned to this role will be removed.</span>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash me-1"></i> Yes, Delete',
            cancelButtonText: '<i class="fas fa-times me-1"></i> Cancel',
            reverseButtons: true,
            backdrop: 'rgba(0, 0, 0, 0.5)'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "{{ route('admin.roles.destroy', ':id') }}".replace(':id', id),
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        showPremiumToast(
                            'success',
                            '<i class="fas fa-check-circle me-2"></i>Deleted',
                            res.message,
                            5000
                        );
                        table.ajax.reload(null, false);
                    },
                    error: function () {
                        showPremiumToast(
                            'error',
                            '<i class="fas fa-times-circle me-2"></i>Failed',
                            'Unable to delete role. Please try again.',
                            5000
                        );
                    }
                });

            }
        });
    });

});
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
</style>
@endpush
