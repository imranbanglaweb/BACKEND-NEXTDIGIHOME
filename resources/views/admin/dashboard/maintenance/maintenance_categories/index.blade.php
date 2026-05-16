@extends('admin.dashboard.master')

@section('main_content')

<style>
    /* Fix for modal black background */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5) !important;
    }
    .modal-backdrop.show {
        opacity: 0.5 !important;
    }
</style>

<section class="content-body" style="background-color:#fff;">
<div class="container-fluid mt-4">

    <h3 class="fw-bold mb-3">
        <i class="fa fa-list"></i> Maintenance Categories
    </h3>

    <button class="btn btn-dark mb-3 pull-right" id="addNew">
        <i class="fa fa-plus"></i> Add New
    </button>
<br>
<br>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="categoryTable">
                <thead class="table-dark">
                    <tr>
                        <!-- <th>#</th> -->
                        <th>Category Name</th>
                        <th>Category Type</th>
                        <th>Status</th>
                        <th width="130px">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>

@include('admin.dashboard.maintenance.maintenance_categories.modal')


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {

    // Load DataTable
    $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('maintenance-categories.index') }}",
        columns: [
            // { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'category_name', name: 'category_name' },
            { data: 'category_type', name: 'category_type' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // --- Add New ---
    $('#addNew').click(function () {
        $('#categoryForm')[0].reset();
        $('#id').val('');
        $('#errorAlert').addClass('d-none').html('');
        $('#categoryModal').modal('show');
    });

    // --- Save Data ---
    $('#saveBtn').click(function (e) {
        e.preventDefault();

        let formData = new FormData($('#categoryForm')[0]);

        $.ajax({
            url: "{{ route('maintenance-categories.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,

            success: function (res) {
                Swal.fire('Success', res.message, 'success');
                $('#categoryModal').modal('hide');
                $('#categoryTable').DataTable().ajax.reload();
            },

            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = "<ul>";

                    $.each(errors, function (key, value) {
                        errorHtml += "<li>" + value[0] + "</li>";
                    });

                    errorHtml += "</ul>";

                    $('#errorAlert').removeClass('d-none').html(errorHtml);
                    $('#errorAlert').addClass('alert alert-danger');

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errorHtml
                    });
                }
            }
        });
    });

    // --- Edit ---
    $(document).on('click', '.editBtn', function () {
        let id = $(this).data('id');

        $.get("maintenance-categories/" + id + "/edit", function (data) {
            $('#id').val(data.id);
            $('#category_name').val(data.category_name);
            $('#category_type').val(data.category_type);

            $('#errorAlert').addClass('d-none').html('');
            $('#categoryModal').modal('show');
        });
    });

    // --- Delete ---
    $(document).on('click', '.deleteBtn', function () {
        let id = $(this).data('id');
    let deleteRoute = "{{ route('maintenance-categories.destroy', ':id') }}";
    deleteRoute = deleteRoute.replace(':id', id);

        Swal.fire({
            title: 'Are you sure?',
            text: "This will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: deleteRoute,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },

                    success: function (res) {
                        Swal.fire('Deleted!', res.message, 'success');
                        $('#categoryTable').DataTable().ajax.reload();
                    }
                });

            }
        });
    });

});
</script>

@endsection
