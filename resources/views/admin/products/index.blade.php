@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background-color: #fff; padding: 10px;">

<div class="row">
    <div class="col-md-12">
        <h4 class="mb-3"><i class="fa fa-box"></i> Product Management</h4>
    </div>
</div>

<!-- Filters -->
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card" style="background-color: #f8f9fa; border: 1px solid #ddd;">
            <div class="card-body">
                <div class="row align-items-end">
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Status</label>
                        <select id="status_filter" class="form-control form-control-sm select2">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Featured</label>
                        <select id="featured_filter" class="form-control form-control-sm select2">
                            <option value="">All Products</option>
                            <option value="1">Featured</option>
                            <option value="0">Not Featured</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Type</label>
                        <select id="digital_filter" class="form-control form-control-sm select2">
                            <option value="">All Types</option>
                            <option value="1">Digital</option>
                            <option value="0">Physical</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Category</label>
                        <select id="category_filter" class="form-control form-control-sm select2">
                            <option value="">All Categories</option>
                            @foreach(\App\Models\Product::distinct()->pluck('category')->filter()->sort() as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <br>
                        <button type="button" id="filter_reset" class="btn btn-secondary btn-sm w-100">
                            <i class="fa fa-refresh"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 text-right">
        <div class="btn-group">
            <a class="btn btn-success" href="{{ route('admin.products.create') }}">
                <i class="fa fa-plus"></i> Add Product
            </a>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success myElem">
    <p>{{ $message }}</p>
</div>
@endif

<!-- TABLE -->
<div class="card mt-3 p-2">
    <table class="table table-bordered table-hover" id="productsTable" style="width:100%;">
        <thead>
            <tr>
                <th></th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Featured</th>
                <th width="150px">Action</th>
            </tr>
        </thead>
    </table>
</div>

</section>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<style>
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 14px;
    }
    .custom-control-label::before,
    .custom-control-label::after {
        top: 0.25rem;
        left: -1.75rem;
    }
    .custom-switch .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #28a745;
        border-color: #28a745;
    }
</style>

<!-- Load SweetAlert2 from CDN to ensure it's available -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    console.log('jQuery loaded:', typeof $);
    console.log('Swal loaded:', typeof Swal);

    // Initialize Select2
    $('.select2').select2({
        width: '100%',
        placeholder: 'Select option',
        allowClear: true
    });

    // DataTable with advanced filtering
    var table = $('#productsTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: "{{ route('admin.products.getData') }}",
        columns: [
            { orderable: false, searchable: false, width: '5%' },
            { orderable: false, searchable: false, width: '8%' },
            { searchable: false },
            { searchable: false },
            { searchable: false, width: '10%' },
            { searchable: false, width: '10%' },
            { orderable: false, searchable: false, width: '8%' },
            { orderable: false, searchable: false, width: '8%' },
            { orderable: false, searchable: false, width: '15%' }
        ]
    });

    // Apply filters on change
    $('#status_filter, #featured_filter, #digital_filter, #category_filter').on('change', function() {
        table.draw();
    });

    // Reset filters
    $('#filter_reset').on('click', function() {
        $('#status_filter').val('').trigger('change');
        $('#featured_filter').val('').trigger('change');
        $('#digital_filter').val('').trigger('change');
        $('#category_filter').val('').trigger('change');
        table.draw();
    });

    // Status toggle
    $(document).on('change', '.status-toggle', function() {
        var productId = $(this).data('id');
        $.ajax({
            url: '{{ route("admin.products.toggle-status", ":id") }}'.replace(':id', productId),
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                // Show success message or just reload table
                table.draw();
            },
            error: function(xhr) {
                Swal.fire('Error!', 'Failed to update status', 'error');
                // Revert checkbox
                $(this).prop('checked', !$(this).prop('checked'));
            }
        });
    });

    // Featured toggle
    $(document).on('change', '.featured-toggle', function() {
        var productId = $(this).data('id');
        $.ajax({
            url: '{{ route("admin.products.toggle-featured", ":id") }}'.replace(':id', productId),
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                table.draw();
            },
            error: function(xhr) {
                Swal.fire('Error!', 'Failed to update featured status', 'error');
                // Revert checkbox
                $(this).prop('checked', !$(this).prop('checked'));
            }
        });
    });

    // Delete click handler
    $(document).on('click', '.delete-product', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'This product will be deleted permanently!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.products.destroy", ":id") }}'.replace(':id', id),
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(response) {
                        $('#productsTable').DataTable().ajax.reload();
                        Swal.fire('Deleted!', 'Product has been deleted.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.message || 'Delete failed', 'error');
                    }
                });
            }
        });
    });
});
</script>

@endsection