@extends('admin.dashboard.master')
@section('title', 'Document History')

@section('main_content')
<div class="content-header content-body">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Document History</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Document History</li>
                </ol>
            </div>
        </div>

        <!-- Search Panel -->
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Search History</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form id="searchForm">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date Range</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" name="date_from" id="date_from">
                                    <div class="input-group-append">
                                        <span class="input-group-text">to</span>
                                    </div>
                                    <input type="date" class="form-control" name="date_to" id="date_to">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Action Type</label>
                                <select class="form-control" name="action" id="action">
                                    <option value="">All Actions</option>
                                    <option value="created">Created</option>
                                    <option value="updated">Updated</option>
                                    <option value="returned">Returned</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>User</label>
                                <select class="form-control select2" name="user_id" id="user_id">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                    <button type="button" class="btn btn-default" onclick="resetSearch()">
                                        <i class="fa fa-undo"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- History Table -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">History Log</h3>
                <div class="card-tools">
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-download"></i> Export
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" onclick="exportHistory('excel')">
                                <i class="fa fa-file-excel-o"></i> Excel
                            </a>
                            <a class="dropdown-item" href="#" onclick="exportHistory('pdf')">
                                <i class="fa fa-file-pdf-o"></i> PDF
                            </a>
                            <a class="dropdown-item" href="#" onclick="exportHistory('csv')">
                                <i class="fa fa-file-text-o"></i> CSV
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Document</th>
                                <th>Action</th>
                                <th>Details</th>
                                <th>Performed By</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody">
                            @include('admin.dashboard.documents.history.table')
                        </tbody>
                    </table>
                    {{ $histories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container .select2-selection--single {
    height: 38px;
    line-height: 38px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2
    try {
        $('.select2').select2({
            width: '100%',
            placeholder: 'Select an option'
        });
    } catch (e) {
        console.warn('Select2 initialization error:', e);
    }

    // Initialize sortable if needed
    try {
        if ($.fn.sortable) {
            $('#historyTableBody').sortable({
                handle: '.sort-handle',
                helper: function(e, tr) {
                    var $originals = tr.children();
                    var $helper = tr.clone();
                    $helper.children().each(function(index) {
                        $(this).width($originals.eq(index).width());
                    });
                    return $helper;
                },
                update: function(event, ui) {
                    // Add your sort update logic here if needed
                }
            });
        }
    } catch (e) {
        console.warn('Sortable initialization error:', e);
    }

    // Form submission
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        searchHistory();
    });
});

function searchHistory() {
    $.ajax({
        url: "{{ route('document.history.search') }}",
        type: 'GET',
        data: $('#searchForm').serialize(),
        beforeSend: function() {
            toggleLoading(true);
        },
        success: function(response) {
            if (response.success) {
                $('#historyTableBody').html(response.view);
            } else {
                showAlert('error', response.message || 'Error loading history');
            }
        },
        error: function(xhr, status, error) {
            console.error('Search error:', error);
            showAlert('error', 'Error searching history: ' + error);
        },
        complete: function() {
            toggleLoading(false);
        }
    });
}

function resetSearch() {
    $('#searchForm')[0].reset();
    $('.select2').val('').trigger('change');
    searchHistory();
}

function exportHistory(type) {
    try {
        const searchData = $('#searchForm').serialize();
        window.location.href = `{{ route('document.history.export') }}?type=${type}&${searchData}`;
    } catch (e) {
        console.error('Export error:', e);
        showAlert('error', 'Error exporting history');
    }
}

// Add global error handler
window.onerror = function(msg, url, lineNo, columnNo, error) {
    console.error('Global error:', {msg, url, lineNo, columnNo, error});
    return false;
};
</script>
@endpush
@endsection 