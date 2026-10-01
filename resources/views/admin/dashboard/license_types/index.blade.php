@extends('admin.dashboard.master')

@section('main_content')
<section class="content-body" style="background-color: #ffffff; padding-top:20px;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>License Types</h3>
            <button class="btn btn-primary" id="addNewBtn"><i class="fa fa-plus"></i> Create New</button>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="licenseTypesTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th width="120px">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- MODAL -->
<div class="modal" id="licenseTypeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="licenseTypeForm">
                <div class="modal-header">
                    <h5 class="modal-title">License Type</h5>
                    <button type="button" class="btn-close pull-right" data-dismiss="modal"><i class="fa fa-minus"></i> Close</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="type_id">

                    <div class="mb-3">
                        <label>Type Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="type_name" name="type_name">
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<script src="{{ asset('public/admin_resource/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<style>
.modal-backdrop { background-color: rgba(0, 0, 0, 0.5); opacity: 1; }
.modal-content { border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
</style>
<script>
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let table = $('#licenseTypesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("license-types.data") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'type_name', name: 'type_name' },
            { data: 'description', name: 'description', render: function(data){ return data ? data.substring(0, 80) : ''; } },
            { data: 'status', name: 'status' },
            { data: 'actions', name: 'actions', orderable:false, searchable:false }
        ]
    });

    // OPEN CREATE MODAL
    $('#addNewBtn').click(function(){
        $('#licenseTypeForm')[0].reset();
        $('#type_id').val("");
        $('#licenseTypeModal .modal-title').text("Create License Type");
        $('#licenseTypeModal').modal('show');
    });

    // SAVE (CREATE / UPDATE)
    $('#licenseTypeForm').on('submit', function(e){
        e.preventDefault();

        let id = $('#type_id').val();
        // let url = id ? '/license-types/' + id : "{{ route('license-types.store') }}";
        let url = id ? "{{ route('license-types.update', ':id') }}".replace(':id', id) : "{{ route('license-types.store') }}";
        let method = id ? "POST" : "POST"; // always POST
        let data = {
            type_name: $('#type_name').val(),
            description: $('#description').val(),
            status: $('#status').val(),
            
        };
        if(id) data._method = 'PUT';

        $.ajax({
            url: url,
            method: method,
            data: data,
            success: function(res){
                $('#licenseTypeModal').modal('hide');
                table.ajax.reload();

                Swal.fire({ icon:'success', title: res.message });
            },
            error: function(xhr){
                Swal.fire({ icon:'error', title:'Validation Error' });
            }
        });
    });

    // EDIT
    $(document).on('click', '.editBtn', function(){
        let id = $(this).data('id');

        $.ajax({
            url: '{{ route('license-types.edit', ':id') }}'.replace(':id', id),
            method: "GET",
            success: function(data){
                $('#type_id').val(data.id);
                $('#type_name').val(data.type_name);
                $('#description').val(data.description);
                $('#status').val(data.status);

                $('#licenseTypeModal .modal-title').text("Edit License Type");
                $('#licenseTypeModal').modal('show');
            }
        });
    });

    // DELETE
    $(document).on('click', '.deleteBtn', function(){
        let id = $(this).data('id');

        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete'
        }).then(function(result){
            if(result.isConfirmed){
                $.ajax({
                    url: '{{ route('license-types.destroy', ':id') }}'.replace(':id', id),
                    method: "POST",
                    type: 'POST',
                    data: { _method: 'DELETE' },
                    success: function(res){
                        table.ajax.reload();
                        Swal.fire('Deleted!', res.message, 'success');
                    }
                });
            }
        });
    });

});
</script>
@endsection
