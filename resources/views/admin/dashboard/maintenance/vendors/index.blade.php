@extends('admin.dashboard.master')

@section('main_content')

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
    /* Fix for modal black background */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5) !important;
    }
    .modal-backdrop.show {
        opacity: 0.5 !important;
    }
    .form-error { color: #e74a3b; font-size: 1.2rem; margin-top: .25rem; }
    .is-invalid { border-color: #e74a3b; }
    .modal-content { border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
    /* Loader styles */
    .btn-loading {
        position: relative;
        color: transparent !important;
        pointer-events: none;
    }
    .btn-loading::after {
        content: "";
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid #fff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

<section role="main" class="content-body" style="background-color: #fff;">
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-primary mb-0">
                <i class="fa fa-building me-2"></i> Maintenance Vendors
            </h3>
            <button class="btn btn-primary" id="addNew">
                <i class="fa fa-plus"></i> Add New
            </button>
        </div>

        {{-- Vendors Table --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover" id="vendorsTable">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Vendor Name</th>
                            <th>Contact Person</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

@include('admin.dashboard.maintenance.vendors.modal')

<script src="{{ asset('public/admin_resource/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function(){

    // Load DataTable
    $('#vendorsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('maintenance-vendors.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'name', name: 'name' },
            { data: 'contact_person', name: 'contact_person' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'address', name: 'address' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // ---------- Clear field errors ----------
    function clearErrors(){
        $('.form-error').remove();
        $('.form-control').removeClass('is-invalid');
        $('#errorAlert').addClass('d-none').html('');
    }

    // ---------- Add New ----------
    $('#addNew').click(function () {
        $('#vendorForm')[0].reset();
        $('#vendor_id').val('');
        clearErrors();
        $('#vendorModal').modal('show');
    });

    // ---------- Save Data ----------
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        clearErrors();

        let vendor_id = $('#vendor_id').val();
        let url = vendor_id
            ? `{{ route('maintenance.vendors.update', ':vendor_id') }}`.replace(':vendor_id', vendor_id)
            : `{{ route('maintenance.vendors.store') }}`;

        const saveBtn = $('#saveBtn');
        saveBtn.addClass('btn-loading');
        saveBtn.prop('disabled', true);

        $.ajax({
            url: url,
            type: "POST",
            data: $('#vendorForm').serialize(),
            success: function(res){
                saveBtn.removeClass('btn-loading');
                saveBtn.prop('disabled', false);

                Swal.fire({
                    icon: 'success',
                    title: vendor_id ? 'Vendor updated successfully!' : 'Vendor added successfully!',
                    timer: 2000,
                    showConfirmButton: false
                });

                $('#vendorModal').modal('hide');
                $('#vendorsTable').DataTable().ajax.reload();
            },
            error: function(xhr){
                saveBtn.removeClass('btn-loading');
                saveBtn.prop('disabled', false);

                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = "<ul>";

                    $.each(errors, function(field, messages){
                        let input = $(`[name="${field}"]`);
                        input.addClass('is-invalid');
                        input.after(`<div class="form-error">${messages[0]}</div>`);
                        errorHtml += "<li>" + messages[0] + "</li>";
                    });

                    errorHtml += "</ul>";

                    $('#errorAlert').removeClass('d-none').html(errorHtml);
                    $('#errorAlert').addClass('alert alert-danger');

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errorHtml
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: xhr.responseJSON?.message || 'Something went wrong',
                        timer: 2500,
                        showConfirmButton: false
                    });
                }
            },
            complete: function(){
                saveBtn.removeClass('btn-loading');
                saveBtn.prop('disabled', false);
            }
        });
    });

    // ---------- Edit ----------
    $(document).on('click', '.editBtn', function(){
        clearErrors();
        let id = $(this).data('id');

        $.get(`{{ route('maintenance.vendors.edit', ':vendor') }}`.replace(':vendor', id), function(data){
            $('#vendor_id').val(data.id);
            $('#vendor_name').val(data.vendor_name);
            $('#contact_person').val(data.contact_person);
            $('#email').val(data.email);
            $('#phone').val(data.phone);
            $('#address').val(data.address);

            $('#vendorModal').modal('show');
        });
    });

    // ---------- Delete ----------
    $(document).on('click', '.deleteBtn', function(){
        let id = $(this).data('id');

        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: "This vendor will be removed permanently!",
            showCancelButton: true,
            confirmButtonText: 'Delete',
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({
                    url: `{{ route('maintenance.vendors.destroy', ':vendor') }}`.replace(':vendor', id),
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(res){
                        Swal.fire({
                            icon: 'success',
                            title: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#vendorsTable').DataTable().ajax.reload();
                    }
                });
            }
        });
    });

});
</script>
@endsection
