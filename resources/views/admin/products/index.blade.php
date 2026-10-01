@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body product-page">
    <div class="container-fluid">
        <div class="product-header">
            <div>
                <div class="product-eyebrow">Catalog</div>
                <h2>Product Management</h2>
                <p>Manage products, stock, digital files, visibility, and featured placement.</p>
            </div>
            <div class="product-header-actions">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Product
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </div>
        </div>

        <div class="product-nav mb-3">
            <a href="{{ route('admin.products.index') }}" class="active">Products</a>
            <a href="{{ route('admin.products.downloads') }}">Downloads</a>
            <a href="{{ route('admin.products.reviews') }}">Reviews</a>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-xl-3 col-md-6">
                <div class="product-stat-card">
                    <span class="stat-icon stat-blue"><i class="fas fa-box"></i></span>
                    <div>
                        <small>Total Products</small>
                        <strong>{{ number_format($stats['total'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-stat-card">
                    <span class="stat-icon stat-green"><i class="fas fa-check-circle"></i></span>
                    <div>
                        <small>Active</small>
                        <strong>{{ number_format($stats['active'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-stat-card">
                    <span class="stat-icon stat-cyan"><i class="fas fa-download"></i></span>
                    <div>
                        <small>Digital</small>
                        <strong>{{ number_format($stats['digital'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="product-stat-card">
                    <span class="stat-icon stat-amber"><i class="fas fa-star"></i></span>
                    <div>
                        <small>Featured</small>
                        <strong>{{ number_format($stats['featured'] ?? 0) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
        @endif

        <div class="product-panel mb-3">
            <div class="product-panel-title">
                <div>
                    <h5>Filters</h5>
                    <p>Filter products by status, feature state, type, and category.</p>
                </div>
                <button type="button" id="filter_reset" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-undo me-1"></i>Reset
                </button>
            </div>
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Status</label>
                    <select id="status_filter" class="form-control">
                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Featured</label>
                    <select id="featured_filter" class="form-control">
                        <option value="">All Products</option>
                        <option value="1">Featured</option>
                        <option value="0">Not Featured</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Type</label>
                    <select id="digital_filter" class="form-control">
                        <option value="">All Types</option>
                        <option value="1">Digital</option>
                        <option value="0">Physical</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Category</label>
                    <select id="category_filter" class="form-control">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Product Kind</label>
                    <select id="product_kind_filter" class="form-control">
                        <option value="">All Kinds</option>
                        <option value="digital_download">Digital Download</option>
                        <option value="website_template">Website Template</option>
                        <option value="ecommerce_template">Ecommerce Template</option>
                        <option value="saas">SaaS Product</option>
                        <option value="course">Course</option>
                        <option value="service">Service</option>
                        <option value="physical">Physical Product</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Purchase Option</label>
                    <select id="purchase_type_filter" class="form-control">
                        <option value="">All Options</option>
                        <option value="one_time">One-time</option>
                        <option value="monthly_subscription">Monthly</option>
                        <option value="yearly_subscription">Yearly</option>
                        <option value="lifetime">Lifetime</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="product-panel">
            <div class="product-panel-title">
                <div>
                    <h5>Products</h5>
                    <p>Toggle active and featured status directly from the table.</p>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="refreshProductsBtn">
                    <i class="fas fa-sync-alt me-1"></i>Refresh
                </button>
            </div>
            <div class="table-responsive">
                <table class="table product-table" id="productsTable" style="width:100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<style>
    .product-page {
        background: #f6f8fb;
        min-height: calc(100vh - 70px);
        padding: 24px;
    }

    .product-header {
        align-items: center;
        background: #111827;
        border-radius: 8px;
        color: #fff;
        display: flex;
        justify-content: space-between;
        margin-bottom: 18px;
        padding: 22px 24px;
    }

    .product-header h2 {
        font-size: 26px;
        font-weight: 700;
        margin: 0 0 4px;
    }

    .product-header p,
    .product-panel-title p {
        margin: 0;
    }

    .product-header p {
        color: rgba(255,255,255,.72);
    }

    .product-eyebrow {
        color: #60a5fa;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .product-header-actions,
    .product-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .product-nav {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        gap: 8px;
        padding: 10px;
    }

    .product-nav a {
        border-radius: 6px;
        color: #4b5563;
        font-size: 13px;
        font-weight: 700;
        padding: 8px 12px;
        text-decoration: none;
    }

    .product-nav a:hover,
    .product-nav a.active {
        background: #111827;
        color: #fff;
    }

    .product-stat-card,
    .product-panel {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
    }

    .product-stat-card {
        align-items: center;
        display: flex;
        gap: 14px;
        min-height: 102px;
        padding: 18px;
    }

    .product-stat-card small {
        color: #6b7280;
        display: block;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .product-stat-card strong {
        color: #111827;
        display: block;
        font-size: 24px;
        line-height: 1;
    }

    .stat-icon {
        align-items: center;
        border-radius: 8px;
        display: inline-flex;
        flex: 0 0 46px;
        height: 46px;
        justify-content: center;
        width: 46px;
    }

    .stat-blue { background: #dbeafe; color: #1d4ed8; }
    .stat-green { background: #dcfce7; color: #15803d; }
    .stat-cyan { background: #cffafe; color: #0e7490; }
    .stat-amber { background: #fef3c7; color: #b45309; }

    .product-panel {
        padding: 18px;
    }

    .product-panel-title {
        align-items: center;
        display: flex;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 16px;
    }

    .product-panel-title h5 {
        color: #111827;
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 3px;
    }

    .product-panel-title p {
        color: #6b7280;
    }

    .product-page .form-label {
        color: #374151;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .product-page .form-control {
        border-color: #d1d5db;
        border-radius: 6px;
        min-height: 38px;
    }

    .product-table thead th {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        color: #4b5563;
        font-size: 12px;
        font-weight: 700;
        padding: 13px 12px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .product-table tbody td {
        border-top: 1px solid #edf0f4;
        color: #1f2937;
        padding: 13px 12px;
        vertical-align: middle;
    }

    .custom-switch .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #15803d;
        border-color: #15803d;
    }

    .product-table .btn {
        border-radius: 6px;
        margin: 0 1px;
    }

    @media (max-width: 767px) {
        .product-page {
            padding: 14px;
        }

        .product-header,
        .product-panel-title {
            align-items: flex-start;
            flex-direction: column;
        }

        .product-header-actions,
        .product-header-actions .btn {
            width: 100%;
        }
    }
</style>

<script>
$(document).ready(function() {
    const table = $('#productsTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('admin.products.getData') }}",
            data: function(data) {
                data.status = $('#status_filter').val();
                data.featured = $('#featured_filter').val();
                data.digital = $('#digital_filter').val();
                data.category = $('#category_filter').val();
                data.product_kind = $('#product_kind_filter').val();
                data.purchase_type = $('#purchase_type_filter').val();
            }
        },
        order: [[0, 'desc']],
        columns: [
            { width: '6%' },
            { orderable: false, searchable: false, width: '8%' },
            null,
            null,
            { width: '10%' },
            { width: '10%' },
            { orderable: false, searchable: false, width: '8%' },
            { orderable: false, searchable: false, width: '8%' },
            { orderable: false, searchable: false, width: '15%', className: 'text-center' }
        ],
        language: {
            processing: '<div class="py-4 text-center"><div class="spinner-border text-primary" role="status"></div><div class="mt-2 text-muted">Loading products...</div></div>',
            emptyTable: 'No products found',
            zeroRecords: 'No matching products found'
        }
    });

    $('#status_filter, #featured_filter, #digital_filter, #category_filter, #product_kind_filter, #purchase_type_filter').on('change', function() {
        table.ajax.reload();
    });

    $('#filter_reset').on('click', function() {
        $('#status_filter, #featured_filter, #digital_filter, #category_filter, #product_kind_filter, #purchase_type_filter').val('');
        table.ajax.reload();
    });

    $('#refreshProductsBtn').on('click', function() {
        const icon = $(this).find('i');
        icon.addClass('fa-spin');
        table.ajax.reload(function() {
            icon.removeClass('fa-spin');
        }, false);
    });

    $(document).on('change', '.status-toggle', function() {
        const checkbox = $(this);
        $.ajax({
            url: '{{ route("admin.products.toggle-status", ":id") }}'.replace(':id', checkbox.data('id')),
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function() {
                table.ajax.reload(null, false);
            },
            error: function() {
                checkbox.prop('checked', !checkbox.prop('checked'));
                showAlert('error', 'Failed to update product status.');
            }
        });
    });

    $(document).on('change', '.featured-toggle', function() {
        const checkbox = $(this);
        $.ajax({
            url: '{{ route("admin.products.toggle-featured", ":id") }}'.replace(':id', checkbox.data('id')),
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function() {
                table.ajax.reload(null, false);
            },
            error: function() {
                checkbox.prop('checked', !checkbox.prop('checked'));
                showAlert('error', 'Failed to update featured status.');
            }
        });
    });

    $(document).on('click', '.delete-product', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        confirmAction('Delete product?', 'This product and its uploaded files will be removed.', function() {
            $.ajax({
                url: '{{ route("admin.products.destroy", ":id") }}'.replace(':id', id),
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    table.ajax.reload(null, false);
                    showAlert('success', response.message || 'Product deleted successfully.');
                },
                error: function(xhr) {
                    showAlert('error', xhr.responseJSON?.message || 'Delete failed.');
                }
            });
        });
    });

    function confirmAction(title, text, onConfirm) {
        if (typeof Swal === 'undefined') {
            if (confirm(title)) {
                onConfirm();
            }
            return;
        }

        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#111827',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.isConfirmed) {
                onConfirm();
            }
        });
    }

    function showAlert(type, message) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type,
                title: type === 'success' ? 'Success' : 'Error',
                text: message,
                timer: type === 'success' ? 1800 : undefined,
                showConfirmButton: type !== 'success'
            });
            return;
        }

        alert(message);
    }
});
</script>
@endsection
