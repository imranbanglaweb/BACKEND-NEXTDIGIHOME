@extends('admin.dashboard.master')

@section('main_content')

<section role="main" class="content-body" style="background-color:#fff;">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold text-primary">
            <br>
                <i class="fa fa-store"></i> Vendor List
            </h4>
            <a href="{{ route('vendors.create') }}" class="btn btn-success btn-sm pull-right">
                <i class="fa fa-plus-circle"></i> Add Vendor
            </a>
        </div>
        <br>
        <br>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body">
            <div class="table-responsive">
                <table id="vendorsTable" class="table table-striped table-bordered align-middle" style="width:100%">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>ID</th>
                            <th>Vendor Name</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</section>

<script>
$(function () {
    let table = $('#vendorsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('vendors.index') }}",
        columns: [
            { data: 'id', name: 'id', className: 'text-center' },
            { data: 'name', name: 'name' },
            { data: 'contact_person', name: 'contact_person' },
            { data: 'contact_number', name: 'contact_number' },
            { data: 'email', name: 'email' },
            { 
                data: 'status', 
                name: 'status',
                className: 'text-center',
                render: function (data) {
                    return data === 'Active'
                        ? `<span class="badge bg-success">Active</span>`
                        : `<span class="badge bg-danger">Inactive</span>`;
                }
            },
            {
                data: 'action', 
                name: 'action',
                orderable: false, 
                searchable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    let editUrl = "{{ route('vendors.edit', ':id') }}".replace(':id', row.id);
                    return `
                        <a href="${editUrl}" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm deleteVendorBtn" data-id="${row.id}">
                            <i class="fa fa-trash"></i>
                        </button>`;
                }
            }
        ],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"></div>'
        }
    });

    // Delete Vendor
    $(document).on('click', '.deleteVendorBtn', function() {
        let id = $(this).data('id');
        let url = "{{ route('vendors.destroy', ':id') }}".replace(':id', id);

        Swal.fire({
            title: "Are you sure?",
            text: "This vendor will be permanently removed!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Vendor deleted successfully.",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        table.ajax.reload(null, false);
                    },
                    error: function () {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to delete vendor.",
                            icon: "error"
                        });
                    }
                });
            }
        });
    });
});
</script>

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
@endsection
