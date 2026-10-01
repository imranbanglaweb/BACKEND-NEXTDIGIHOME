@extends('admin.dashboard.master')

@section('main_content')

<style>
    #menuTable td {
        cursor: move;
    }
    
    /* Modal Styles */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5);
    }
    
    .modal-content {
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }
    
    .modal-header {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: white;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        padding: 15px 20px;
    }
    
    .modal-header .close {
        color: white;
        opacity: 0.8;
        font-size: 28px;
        font-weight: bold;
        text-shadow: none;
    }
    
    .modal-header .close:hover {
        opacity: 1;
    }
    
    .modal-title {
        font-weight: 600;
    }
    
    .modal-body {
        padding: 30px 20px;
    }
    
    .modal-footer {
        border-top: 1px solid #e9ecef;
        padding: 15px 20px;
    }
</style>

<section class="content-body" style="background-color: #fff;">
    <div class="row">
        <div class="col-lg-12"><h2>Menu Manage</h2></div>
        <div class="col-lg-12 text-end">
            @can('menu-create')
                <a class="btn btn-success pull-right" href="{{ route('menus.create') }}">
                    <i class="fa fa-plus"></i> Add Menu
                </a>
            @endcan
        </div>
    </div>

    <div id="successMessage">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
        @endif
        @if ($message = Session::get('danger'))
            <div class="alert alert-danger">{{ $message }}</div>
        @endif
    </div>

    <section class="panel">
        <header class="panel-heading">
            <h4>Menu List</h4>
        </header>
        <div class="panel-body">
            <table class="table table-bordered table-striped" id="menuTable">
                <thead>
                    <tr>
                        <th style="display:none;">Order</th>
                        <th>No</th>
                        <th>Name</th>
                        <th>Menu Type</th>
                        <th>Menu Icon</th>
                        <th>Menu URL</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </section>

    <!-- Delete Modal -->
    <div id="applicantDeleteModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h4 class="modal-title" id="deleteModalLabel">Delete Menu</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                            <h5 class="text-danger">Are you sure you want to delete this menu?</h5>
                            <p class="text-muted">This action cannot be undone and will permanently delete the menu.</p>
                        </div>
                        <input type="hidden" name="menu_id" id="menu_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    
    setTimeout(function() {
        $('#successMessage').fadeOut('fast');
    }, 3000);

    try {
        var table = $('#menuTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("menus.index") }}',
            columns: [
                { data: 'menu_order', visible: false },
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'menu_name' },
                { data: 'menu_type' },
                { data: 'menu_icon', orderable: false, searchable: false, className: 'text-center' },
                { data: 'menu_url' },
                { data: 'action', orderable: false, searchable: false }
            ],
            rowReorder: {
                dataSrc: 'menu_order'
            },
            order: [[0, 'asc']]
        });

        // Row reorder AJAX
        table.on('row-reorder', function(e, diff, edit) {
            var orderedData = table.rows().data();
            var reorderData = [];

            orderedData.each(function(row, index) {
                reorderData.push({
                    id: row.id,
                    newPosition: index + 1
                });
            });

            $.ajax({
                url: '{{ route("menus.reorder") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order: reorderData
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success('Menu order updated successfully!');
                        table.ajax.reload(null, false);
                    } else {
                        toastr.error(response.message || 'Error updating order');
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                    toastr.error('Error updating order');
                }
            });
        });

        // Delete menu
        $(document).on('click', '.deleteUser', function(e) {
            e.preventDefault();
            var menu_id = $(this).data('menuid');
            let deleteRoute = "{{ route('menus.destroy', ':id') }}";
                deleteRoute = deleteRoute.replace(':id', menu_id);
            $('#menu_id').val(menu_id);
            $('#deleteForm').attr('action', deleteRoute);
            $('#applicantDeleteModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });
        
    } catch (error) {
        console.error('Error initializing DataTable:', error);
        document.getElementById('menuTable').innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error initializing DataTable: ' + error.message + '</td></tr>';
    }
});
</script>
@endsection
