@extends('admin.dashboard.master')

@section('title', 'Categories')

@section('main_content')

<section class="content-body py-4"
         style="background: linear-gradient(135deg,#f5f7fa 0%,#c3cfe2 100%); min-height:100vh;">

    <div class="container-fluid">

        <div class="card border-0 shadow-lg rounded-lg overflow-hidden">

            <div class="card-header text-white d-flex justify-content-between align-items-center"
                 style="background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);">

                <h4 class="mb-0">
                    <i class="fas fa-tags mr-2"></i>
                    Categories Management
                </h4>

                <button type="button"
                        class="btn btn-light font-weight-bold"
                        id="openAddCategoryModal">

                    <i class="fas fa-plus mr-1"></i>
                    Add Category

                </button>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover"
                           id="categoriesTable"
                           width="100%">

                        <thead class="thead-light">

                            <tr>

                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th width="180">Actions</th>

                            </tr>

                        </thead>

                    </table>

                </div>

            </div>

        </div>

    </div>

</section>

{{-- =========================
        ADD MODAL
========================= --}}

<div class="modal"
     id="addCategoryModal"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 rounded-lg">

            <div class="modal-header text-white"
                 style="background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);">

                <h5 class="modal-title">

                    <i class="fas fa-plus-circle mr-2"></i>
                    Add Category

                </h5>

                <button type="button"
                        class="close text-white"
                        data-dismiss="modal"
                        aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <form id="addCategoryForm">

                    @csrf

                    <div class="form-group">

                        <label>
                            Category Name
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               class="form-control"
                               id="category_name"
                               name="category_name">

                        <small class="text-danger category_name_error"></small>

                    </div>

                    <div class="form-group">

                        <label>Slug</label>

                        <input type="text"
                               class="form-control"
                               id="category_slug"
                               name="category_slug"
                               readonly>

                    </div>

                    <div class="form-group">

                        <label>Status</label>

                        <select class="form-control"
                                id="status"
                                name="status">

                            <option value="1">Active</option>
                            <option value="0">Inactive</option>

                        </select>

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">

                    Cancel

                </button>

                <button type="button"
                        class="btn btn-primary"
                        id="saveCategoryBtn">

                    <i class="fas fa-save mr-1"></i>
                    Save Category

                </button>

            </div>

        </div>

    </div>

</div>

{{-- =========================
        EDIT MODAL
========================= --}}

<div class="modal"
     id="editCategoryModal"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 rounded-lg">

            <div class="modal-header text-white"
                 style="background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);">

                <h5 class="modal-title">

                    <i class="fas fa-edit mr-2"></i>
                    Edit Category

                </h5>

                <button type="button"
                        class="close text-white"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <form id="editCategoryForm">

                    @csrf
                    @method('PUT')

                    <input type="hidden" id="edit_category_id">

                    <div class="form-group">

                        <label>Category Name</label>

                        <input type="text"
                               class="form-control"
                               id="edit_category_name">

                    </div>

                    <div class="form-group">

                        <label>Slug</label>

                        <input type="text"
                               class="form-control"
                               id="edit_category_slug"
                               readonly>

                    </div>

                    <div class="form-group">

                        <label>Status</label>

                        <select class="form-control"
                                id="edit_status">

                            <option value="1">Active</option>
                            <option value="0">Inactive</option>

                        </select>

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">

                    Cancel

                </button>

                <button type="button"
                        class="btn btn-success"
                        id="updateCategoryBtn">

                    <i class="fas fa-save mr-1"></i>
                    Update

                </button>

            </div>

        </div>

    </div>

</div>

{{-- =========================
        DELETE MODAL
========================= --}}

<div class="modal"
     id="deleteCategoryModal"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-lg">

            <div class="modal-header bg-danger text-white">

                <h5 class="modal-title">

                    <i class="fas fa-trash mr-2"></i>
                    Delete Category

                </h5>

                <button type="button"
                        class="close text-white"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <div class="modal-body text-center">

                <h5>

                    Are you sure delete
                    <strong id="delete_category_name"></strong> ?

                </h5>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">

                    Cancel

                </button>

                <button type="button"
                        class="btn btn-danger"
                        id="confirmDeleteBtn">

                    Delete

                </button>

            </div>

        </div>

    </div>

</div>

<style>

.rounded-lg{
    border-radius: 20px !important;
}

.modal-content{
    overflow: hidden;
}

.form-control{
    border-radius: 10px;
}

.btn{
    border-radius: 10px;
}

.table td,
.table th{
    vertical-align: middle !important;
}

</style>

{{-- =========================
        SCRIPTS
========================= --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

$(document).ready(function () {

    // =========================
    // CSRF TOKEN
    // =========================

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    // =========================
    // OPEN ADD MODAL
    // =========================

    $('#openAddCategoryModal').click(function () {

        $('#addCategoryModal').modal('show');

    });

    // =========================
    // DATATABLE
    // =========================

    let table = $('#categoriesTable').DataTable({

        processing: true,
        serverSide: true,

        ajax: "{{ url('admin/categories-data') }}",

        columns: [

            {data: 'id', name: 'id'},

            {data: 'category_name', name: 'category_name'},

            {data: 'category_slug', name: 'category_slug'},

            {
                data: 'status',
                name: 'status',

                render: function(data){

                    if(data == 1){

                        return '<span class="badge badge-success">Active</span>';

                    }

                    return '<span class="badge badge-danger">Inactive</span>';

                }
            },

            {data: 'created_at', name: 'created_at'},

            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false
            }

        ]

    });

    // =========================
    // AUTO SLUG
    // =========================

    function makeSlug(text){

        return text.toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/--+/g, '-');

    }

    $('#category_name').keyup(function(){

        $('#category_slug').val(
            makeSlug($(this).val())
        );

    });

    $('#edit_category_name').keyup(function(){

        $('#edit_category_slug').val(
            makeSlug($(this).val())
        );

    });

    // =========================
    // STORE CATEGORY
    // =========================

    $('#saveCategoryBtn').click(function(){

        $('.category_name_error').text('');

        $.ajax({

            url: "{{ route('admin.categories.store') }}",

            type: "POST",

            data: {

                category_name: $('#category_name').val(),

                category_slug: $('#category_slug').val(),

                status: $('#status').val()

            },

            success: function(response){

                $('#addCategoryForm')[0].reset();

                $('#addCategoryModal').modal('hide');

                table.ajax.reload();

                Swal.fire({

                    icon: 'success',
                    title: 'Success',
                    text: 'Category created successfully'

                });

            },

            error: function(xhr){

                if(xhr.status == 422){

                    $.each(xhr.responseJSON.errors, function(key, value){

                        $('.' + key + '_error').text(value[0]);

                    });

                }else{

                    Swal.fire({

                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong'

                    });

                }

            }

        });

    });

    // =========================
    // EDIT CATEGORY
    // =========================

    $(document).on('click', '.edit-category', function(){

        $('#edit_category_id').val($(this).data('id'));

        $('#edit_category_name').val($(this).data('name'));

        $('#edit_category_slug').val($(this).data('slug'));

        $('#edit_status').val($(this).data('status'));

        $('#editCategoryModal').modal('show');

    });

    // =========================
    // UPDATE CATEGORY
    // =========================

    $('#updateCategoryBtn').click(function(){

        let id = $('#edit_category_id').val();

        $.ajax({

             url: "{{ route('admin.categories.update', ':id') }}".replace(':id', id),

            type: "PUT",

            data: {

                category_name: $('#edit_category_name').val(),

                category_slug: $('#edit_category_slug').val(),

                status: $('#edit_status').val()

            },

            success: function(response){

                $('#editCategoryModal').modal('hide');

                table.ajax.reload();

                Swal.fire({

                    icon: 'success',
                    title: 'Updated',
                    text: 'Category updated successfully'

                });

            },

            error: function(){

                Swal.fire({

                    icon: 'error',
                    title: 'Error',
                    text: 'Update failed'

                });

            }

        });

    });

    // =========================
    // DELETE CATEGORY
    // =========================

    $(document).on('click', '.delete-category', function(){

        let id = $(this).data('id');

        let name = $(this).data('name');

        $('#delete_category_name').text(name);

        $('#confirmDeleteBtn').data('id', id);

        $('#deleteCategoryModal').modal('show');

    });

    // =========================
    // CONFIRM DELETE
    // =========================

    $('#confirmDeleteBtn').click(function(){

        let id = $(this).data('id');

        $.ajax({

              url: "{{ route('admin.categories.destroy', ':id') }}".replace(':id', id),

            type: "DELETE",

            data: {},

            success: function(){

                $('#deleteCategoryModal').modal('hide');

                table.ajax.reload();

                Swal.fire({

                    icon: 'success',
                    title: 'Deleted',
                    text: 'Category deleted successfully'

                });

            },

            error: function(){

                Swal.fire({

                    icon: 'error',
                    title: 'Error',
                    text: 'Delete failed'

                });

            }

        });

    });

});

</script>

@endsection