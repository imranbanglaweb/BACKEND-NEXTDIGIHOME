@extends('admin.dashboard.master')

@section('main_content')

<section role="main" class="content-body" style="background-color:#fff;">
    <br>
    <br>
    <br>
<div class="container">
    <h3>Departments Manage</h3>
    <button class="btn btn-success pull-right" id="addNew"><i class="fa fa-plus"></i> Add Department</button>
    <br>
    <br>
<table id="departmentsTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Unit</th>
            <th>Name</th>
            <th>Code</th>
            <th>Short Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
</table>
</div>
<!-- Modal -->

<div class="modal" id="deptModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="deptForm">
        <div class="modal-header">
          <h5 class="modal-title">Department</h5>
          <button type="button" class="btn-close pull-right btn-danger" data-dismiss="modal"><i class="fa fa-minus"></i></button>
          <br>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="deptId">
            <div class="mb-3">
                <label>Select Unit</label>
                <select name="unit_id" id="unit_id" class="form-select select2">
                    <option value="">Select Unit</option>
                    @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>/
                    @endforeach
                </select>
                <span class="text-danger" id="unit_id_error"></span>
            </div>
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="department_name" id="department_name" class="form-control">
                <span class="text-danger" id="department_name_error"></span>
            </div>
            <div class="mb-3">
                <label>Code</label>
                <input type="text" name="department_code" id="department_code" class="form-control">
                <span class="text-danger" id="department_code_error"></span>
            </div>
            <div class="mb-3">
                <label>Short Name</label>
                <input type="text" name="department_short_name" id="department_short_name" class="form-control">
                <span class="text-danger" id="department_short_name_error"></span>
            </div>
            <div class="mb-3">
                <label>Location</label>
                <input type="text" name="location" id="location" class="form-control">
                <span class="text-danger" id="location_error"></span>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" id="description" class="form-control"></textarea>
                <span class="text-danger" id="description_error"></span>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                <span class="text-danger" id="status_error"></span>
            </div>
            <div class="mb-3">
                <label>Department Head</label>
                <select name="head_employee_id" id="head_employee_id" class="form-select select2">
                    <option value="">Select Department Head</option>
                    @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->email }})</option>
                    @endforeach
                </select>
                <span class="text-danger" id="head_employee_id_error"></span>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="submit">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
</section>

<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<script src="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<style>
.modal-backdrop { background-color: rgba(0, 0, 0, 0.5); opacity: 1; }
.modal-content { border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
.modal .modal-content { border-radius: 12px; }
.modal-header .btn-close { background-color:#f6f6f6; border: none; font-size: 24px; line-height: 1; color: #000; opacity: 0.5; }
</style>

<style>
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
</style>


<script>
function clearErrors() {
    $('.text-danger').text('');
    $('.form-control, .form-select').removeClass('is-invalid');
}
$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $('#departmentsTable').DataTable({
        processing:true,
        serverSide:true,
        ajax: "{{ route('admin.departments.data') }}",
        columns:[
            {data:'id', name:'id'},
            {data:'unit_name', name:'unit_name'},
            {data:'department_name', name:'department_name'},
            {data:'department_code', name:'department_code'},
            {data:'department_short_name', name:'department_short_name'},
            {data:'status', name:'status', render:function(d){ return d==1 ? 'Active':'Inactive'; }},
            {data:'action', name:'action', orderable:false, searchable:false}
        ]
    });

    $('.select2').select2({
        dropdownParent: $('#deptModal')
    });

    // Add New
    $('#addNew').click(function(){
        $('#deptForm')[0].reset();
        $('#deptId').val('');
        clearErrors();
        $('#unit_id').val('').trigger('change');
        $('#deptModal').modal('show');
    });

    // Edit
    $(document).on('click','.editBtn', function(){
        var id = $(this).data('id');
        clearErrors();
        $.get("{{ route('admin.departments.edit', ':id') }}".replace(':id', id), function(data){
            $('#deptId').val(data.id);
            $('#unit_id').val(data.unit_id).trigger('change');
            $('#department_name').val(data.department_name);
            $('#department_code').val(data.department_code);
            $('#department_short_name').val(data.department_short_name);
            $('#location').val(data.location);
            $('#description').val(data.description);
            $('#status').val(data.status);
            $('#head_employee_id').val(data.head_employee_id).trigger('change');
            $('#deptModal').modal('show');
        }).fail(function(){
            Swal.fire('Error','Failed to load department data.','error');
        });
    });

    // Save form (Add/Edit)
    $('#deptForm').off('submit').on('submit', function(e){
        e.preventDefault();
        var id = $('#deptId').val();
        clearErrors();
        var url = id ? "{{ route('admin.departments.update', ':id') }}".replace(':id', id) : "{{ route('admin.departments.store') }}";
        var method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: $(this).serialize(),
            success: function(res){
                Swal.fire('Success', res.message, 'success');
                $('#deptModal').modal('hide');
                table.ajax.reload();
            },
            error: function(xhr){
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = 'Validation failed. Please check the form.';
                    $.each(errors, function(key, value){
                        $('#' + key + '_error').text(value[0]);
                        $('[name="' + key + '"]').addClass('is-invalid');
                    });
                    Swal.fire('Error', errorMsg, 'error');
                } else {
                    let msg = xhr.responseJSON?.message || 'An error occurred.';
                    Swal.fire('Error', msg, 'error');
                }
            }
        });
    });

    // Delete
    $(document).on('click','.deleteBtn', function(){
        var id = $(this).data('id');
        Swal.fire({
            title:'Delete Department?',
            icon:'warning',
            showCancelButton:true,
            confirmButtonText:'Yes, Delete'
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({
                    url:"{{ route('admin.departments.destroy', ':id') }}".replace(':id', id),
                    type: 'POST',
                    data: { _method: 'DELETE' },
                    type:'DELETE',
                    success:function(res){
                        Swal.fire('Deleted', res.message, 'success');
                        table.ajax.reload();
                    },
                    error:function(){
                        Swal.fire('Error','Failed to delete department.','error');
                    }
                });
            }
        });
    });

});
</script>


@endsection
