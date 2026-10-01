@extends('admin.dashboard.master')

@section('main_content')
<div class="content-body" style="background: #fff;">
    <section class="content-body-card p-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold text-dark mb-1">
                            <i class="fas fa-id-card text-primary me-2"></i>
                            Driver Performance Report
                        </h4>
                        <p class="text-muted mb-0 small">Track and analyze driver performance metrics</p>
                    </div>
                    @if(auth()->user()->hasRole(['Super Admin','Admin']))
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-download me-1"></i> Export
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('reports.driver_performance.excel') }}">
                                <i class="fas fa-file-excel text-success me-2"></i> Excel
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.driver_performance.pdf') }}">
                                <i class="fas fa-file-pdf text-danger me-2"></i> PDF
                            </a></li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-stats-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 text-muted small">Total Drivers</p>
                                <h4 class="mb-0 fw-bold">{{ $drivers->count() }}</h4>
                            </div>
                            <div class="stats-icon bg-primary-subtle">
                                <i class="fas fa-id-card text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stats-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 text-muted small">Active</p>
                                <h4 class="mb-0 fw-bold">{{ $drivers->where('status', 'active')->count() }}</h4>
                            </div>
                            <div class="stats-icon bg-success-subtle">
                                <i class="fas fa-user-check text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stats-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 text-muted small">Total Trips</p>
                                <h4 class="mb-0 fw-bold">{{ $drivers->sum('total_trips') }}</h4>
                            </div>
                            <div class="stats-icon bg-warning-subtle">
                                <i class="fas fa-route text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-filter text-primary me-2"></i>Filters
                        </h6>
                    </div>
                    <div class="card-body">
                        <form id="filterForm" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-medium">Driver</label>
                                <select name="driver_id" class="form-select form-select-sm select2">
                                    <option value="">All Drivers</option>
                                    @foreach($drivers as $d)
                                        <option value="{{ $d->id }}">{{ $d->driver_name }} - {{ $d->license_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-medium">From Date</label>
                                <input type="date" name="from_date" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-medium">To Date</label>
                                <input type="date" name="to_date" class="form-control form-control-sm">
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-sm me-2">
                                    <i class="fas fa-search me-1"></i> Apply
                                </button>
                                <button type="button" id="resetBtn" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-redo me-1"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-table text-primary me-2"></i>Performance Data
                        </h6>
                        <span class="badge bg-secondary">{{ $drivers->count() }} Drivers</span>
                    </div>
                    <div class="card-body p-0">
                        <div id="loading" class="text-center py-5" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 text-muted small">Loading data...</p>
                        </div>
                        <div id="reportTable" style="display: block;">
                            @include('admin.dashboard.reports.driver_performance.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.content-body { background: #fff !important; min-height: 100vh; }
.content-body-card { background: transparent; }
.card-stats-card { border: none; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
.stats-icon { width: 48px; height: 48px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }
.bg-primary-subtle { background-color: rgba(102, 126, 234, 0.15); }
.bg-success-subtle { background-color: rgba(56, 239, 125, 0.15); }
.bg-warning-subtle { background-color: rgba(247, 182, 75, 0.15); }
</style>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
$(function() {
    // Initialize Select2
    $('.select2').select2({ width: '100%' });
    function fetchData(page) {
        $('#loading').show();
        $('#reportTable').hide();
        
        // Safety timeout - ensure loading hides after 10 seconds regardless
        var safetyTimeout = setTimeout(function() {
            $('#loading').hide();
            $('#reportTable').show();
        }, 10000);
        
        $.ajax({
            url: "{{ route('reports.driver_performance.ajax') }}",
            type: "GET",
            data: $('#filterForm').serialize() + '&page=' + (page || 1),
            success: function(res) {
                clearTimeout(safetyTimeout);
                $('#reportTable').html(res).show();
                $('#loading').hide();
            },
            error: function(xhr, status, error) {
                clearTimeout(safetyTimeout);
                console.error('Error loading data:', error);
                $('#loading').hide();
                $('#reportTable').show();
            },
            complete: function() {
                clearTimeout(safetyTimeout);
                $('#loading').hide();
            }
        });
    }
    $('#filterForm').on('submit', function(e) { e.preventDefault(); fetchData(1); });
    $('#resetBtn').on('click', function() { 
        $('#filterForm')[0].reset();
        $('.select2').val(null).trigger('change');
        fetchData(1); 
    });
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        fetchData(page);
    });
});
</script>
@endpush
