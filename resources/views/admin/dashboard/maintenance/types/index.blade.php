@extends('admin.dashboard.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
  .card-premium { border: none; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
  .form-label-premium { font-weight: 600; color: #495057; }
  .form-control-premium { border-radius: 8px; padding: .5rem .75rem; font-size: 1rem; }
  .form-error { color: #e74a3b; font-size: .875rem; margin-top: .25rem; display: none; }
  .btn-primary-premium, .btn-info-premium, .btn-danger-premium, .btn-secondary-premium { border-radius: 8px; padding: .45rem .9rem; }
  table.table-premium th, table.table-premium td { vertical-align: middle; }
  .dt-search { max-width: 360px; margin-left:auto; }
  .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
    .modal-backdrop { background-color: rgba(0, 0, 0, 0.5); opacity: 1; }
    .modal-content { border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
</style>
@endpush

@section('main_content')

<section role="main" class="content-body" style="background:#f8f9fc;">
<div class="container-fluid mt-5">
    <h3 class="fw-bold text-primary mb-3"><i class="fa fa-tools me-2"></i> Maintenance Types</h3>

    <div id="notification"></div>

    {{-- Form + Search Row --}}
    <div class="row g-3 mb-3">
        <div class="col-lg-7">
            <div class="card card-premium shadow-sm">
                <div class="card-body">
                    <form id="typeForm" autocomplete="off">
                        @csrf
                        <input type="hidden" name="type_id" id="type_id">

                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label-premium">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-premium" name="mtype_name" id="mtype_name" placeholder="Enter type name">
                                <div class="form-error" id="error-mtype_name"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-premium">Description</label>
                                <input type="text" class="form-control form-control-premium" name="description" id="description" placeholder="Short description">
                                <div class="form-error" id="error-description"></div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fa fa-save me-2"></i> Save
                            </button>
                            <button type="button" class="btn btn-info" id="resetBtn">
                                <i class="fa fa-undo me-2"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

      
    </div>

    <div class="card card-premium shadow-sm">
        <div class="card-body">
            <table class="table table-hover table-premium table-striped" id="typesTable" width="100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th style="width:140px">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</div>
</section>

@push('scripts')
<script src="{{ asset('public/admin_resource/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
$(function(){

    // Global AJAX setup (csrf)
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    // Initialize DataTable (server-side)
    var table = $('#typesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('maintenance.types.data') }}",
            data: function(d){
                d.search_text = $('#globalSearch').val();
            },
            error: function(xhr){
                console.error('DataTables AJAX Error:', xhr.responseText || xhr.statusText);
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'status_badge', name: 'status', orderable:false, searchable:false },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable:false, searchable:false }
        ],
        order: [[4,'desc']],
        pageLength: 10,
        lengthChange: true,
        responsive: true,
        drawCallback: function(){ /* optional post-draw tasks */ }
    });

    // Live search (enter or delay)
    var searchDelay = null;
    $('#globalSearch').on('keyup', function(e){
        clearTimeout(searchDelay);
        // trigger on Enter immediately
        if (e.which === 13) {
            table.ajax.reload();
            return;
        }
        searchDelay = setTimeout(function(){ table.ajax.reload(); }, 700);
    });

    $('#refreshTable').on('click', function(){ table.ajax.reload(); });

    // Reset form
    $('#resetBtn').on('click', function(){
        $('#typeForm')[0].reset();
        $('#type_id').val('');
        $('.form-error').hide().text('');
    });

    // Create or Update submit
    $('#typeForm').on('submit', function(e){
        e.preventDefault();
        $('.form-error').hide().text('');

        var typeId = $('#type_id').val();

        // Correct dynamic URL
        var url = typeId 
            ? "{{ route('maintenance-types.update', ':id') }}".replace(':id', typeId)
            : "{{ route('maintenance-types.store') }}";

        // Always POST but spoof PUT for update
        var method = typeId ? 'PUT' : 'POST';

        $('#submitBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-2"></i> Saving...');

        var data = $(this).serializeArray();

        if (method === 'PUT') {
            data.push({ name: '_method', value: 'PUT' });
        }

        $.ajax({
            url: url,
            method: 'POST',
            data: $.param(data),
            success: function(res){
                Swal.fire({
                    icon: 'success',
                    title: 'Saved',
                    text: res.message || 'Saved successfully',
                    timer: 1200,
                    showConfirmButton: false
                });

                $('#typeForm')[0].reset();
                $('#type_id').val('');
                table.ajax.reload(null, false);
            },
            error: function(xhr){
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    var errs = xhr.responseJSON.errors;
                    Object.keys(errs).forEach(function(key){
                        $('#error-' + key).text(errs[key][0]).show();
                    });
                    Swal.fire({ icon:'error', title:'Validation failed', text:'Please correct errors.' });
                } else {
                    Swal.fire({
                        icon:'error',
                        title:'Error',
                        text: xhr.responseJSON?.message || 'Something went wrong'
                    });
                }
            },
            complete: function(){
                $('#submitBtn').prop('disabled', false).html('<i class="fa fa-save me-2"></i> Save');
            }
        });
    });


    // Open edit (delegated)
    $('#typesTable').on('click', '.editBtn', function(){
        var id = $(this).data('id');
        // GET JSON from server: use edit endpoint
        // $.get(`{{ url('maintenance-types') }}/${id}/edit`, function(data){
         $.get("{{ route('maintenance-types.edit', ':id') }}".replace(':id', id), function(data){
            // server should return JSON { id, name, description, ... }
            $('#type_id').val(data.id);
            $('#mtype_name').val(data.name);
            $('#description').val(data.description);
            // scroll to form
            $('html,body').animate({ scrollTop: $('.card-premium').offset().top - 20 }, 300);
        }).fail(function(xhr){
            Swal.fire({ icon:'error', title:'Error', text:'Unable to load type.'});
        });
    });

    // Delete with SweetAlert2
    $('#typesTable').on('click', '.deleteBtn', function(){
        var id = $(this).data('id');
        var urlTemplate = '{{ route("maintenance-types.destroy", "id") }}';
        var deleteURL = urlTemplate.replace('id', id);

        Swal.fire({
            title: 'Confirm delete?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete'
        }).then((result) => {
            if (!result.isConfirmed) return;
            $.ajax({
                url: deleteURL,
                type: 'POST',
                data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                success: function(res){
                    Swal.fire({ icon:'success', title:'Deleted', text: res.message || 'Type deleted' });
                    table.ajax.reload(null, false);
                },
                error: function(xhr){
                    Swal.fire({ icon:'error', title:'Error', text: xhr.responseJSON?.message || 'Unable to delete' });
                }
            });
        });
    });

});
</script>
@endpush

@endsection
