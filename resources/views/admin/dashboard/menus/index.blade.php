@extends('admin.dashboard.master')

@section('main_content')

<style>
    .parent-menu {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .child-menu {
        background-color: #ffffff;
    }

    .child-menu td {
        border-left: 3px solid #007bff;
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
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Name</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Icon</th>
                            <th>URL</th>
                            <th>Permission</th>
                            <th class="text-center">Order</th>
                            <th class="text-center">Created</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hierarchicalMenus as $index => $menu)
                        <tr class="{{ $menu->level > 0 ? 'child-menu' : 'parent-menu' }}">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <div style="padding-left: {{ $menu->level * 30 }}px;">
                                    @if($menu->level > 0)
                                        <i class="fas fa-angle-right text-muted mr-2"></i>
                                    @endif
                                    <strong>{{ $menu->menu_name }}</strong>
                                    @if($menu->has_children)
                                        <span class="badge badge-info ml-2">Parent</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $menu->menu_parent == 0 ? 'badge-success' : 'badge-primary' }}">
                                    {{ $menu->menu_parent == 0 ? 'Parent' : 'Child' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($menu->menu_icon)
                                    <i class="fa {{ $menu->menu_icon }}"></i>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $menu->menu_url ?: '-' }}</td>
                            <td>{{ $menu->menu_permission ?: '-' }}</td>
                            <td class="text-center">{{ $menu->menu_order }}</td>
                            <td class="text-center">{{ $menu->created_at->format('M d, Y') }}</td>
                            <td class="text-center">
                                @include('admin.dashboard.menus.partials.actions', ['menu' => $menu])
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
});
</script>
@endsection
