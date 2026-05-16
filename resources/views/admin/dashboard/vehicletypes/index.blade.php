@extends('admin.dashboard.master')
@section('main_content')
<section role="main" class="content-body" style="background-color:#fff;">
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <br>
        <h4 class="fw-bold text-primary mb-0">
            <i class="fa fa-list"></i> Vehicle Types
        </h4>
        <a href="{{ route('vehicle-type.create') }}" class="btn btn-primary btn-sm pull-right">
            <i class="fa fa-plus-circle"></i> Add Vehicle Type
        </a>
        <br>
        <br>
        
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <div class="table-responsive">
                <table id="vehicleTypeTable" class="table table-striped table-bordered align-middle">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</section>

<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">


<script src="{{ asset('public/admin_resource/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
$(function() {
    let table = $('#vehicleTypeTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('vehicle-type.index') }}",
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', width: '3%' },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'status', name: 'status', className: 'text-center', render: function(data){
                return data == 1 
                    ? '<span class="badge bg-success">Active</span>' 
                    : '<span class="badge bg-danger">Inactive</span>';
            }},
            { data: 'id', name: 'action', orderable: false, searchable: false, className: 'text-center', render: function(id){
                let editUrl = "{{ route('vehicle-type.edit', ':id') }}".replace(':id', id);
                let deleteBtn = `<button class="btn btn-danger btn-sm deleteBtn" data-id="${id}">
                                    <i class="fa fa-minus"></i>
                                 </button>`;
                let editBtn = `<a href="${editUrl}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i>
                               </a>`;
                return editBtn + ' ' + deleteBtn;
            }}
        ],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"></div>'
        },
    });

    // SweetAlert2 toast setup
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Handle delete button click
    $(document).on('click', '.deleteBtn', function() {
        let id = $(this).data('id');
        let url = "{{ route('vehicle-type.destroy', ':id') }}".replace(':id', id);

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
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
                        Toast.fire({
                            icon: 'warning',
                            title: 'Vehicle type deleted successfully'
                        });
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong!'
                        });
                    }
                });
            }
        });
    });

    // Laravel session messages (Add/Edit/Delete) using toast
    @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: "{{ session('success') }}"
        });
    @elseif(session('error'))
        Toast.fire({
            icon: 'error',
            title: "{{ session('error') }}"
        });
    @endif

});

</script>

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
