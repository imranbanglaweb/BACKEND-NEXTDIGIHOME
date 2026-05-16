@extends('admin.dashboard.master')

@section('main_content')
<div class="content-body" style="background: #fff;">
    <section class="content-body-card p-4">
        <div class="row g-4">
            <!-- Page Header -->
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold text-dark mb-1">
                            <i class="fas fa-clipboard-list text-primary me-2"></i>
                            @if(isset($canViewOwnOnly) && $canViewOwnOnly)
                                My Requisition Reports
                            @else
                                Requisition Reports
                            @endif
                        </h4>
                        <p class="text-muted mb-0 small">
                            @if(isset($canViewOwnOnly) && $canViewOwnOnly)
                                View your own requisition reports
                            @else
                                View and manage all requisition reports
                            @endif
                        </p>
                    </div>
                    @if(!isset($canViewOwnOnly) || !$canViewOwnOnly)
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-download me-1"></i> Export
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('reports.requisitions.excel') }}">
                                <i class="fas fa-file-excel text-success me-2"></i> Excel
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.requisitions.pdf') }}">
                                <i class="fas fa-file-pdf text-danger me-2"></i> PDF
                            </a></li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            @if(!isset($canViewOwnOnly) || !$canViewOwnOnly)
            <!-- Stats Cards -->
            <div class="col-md-3">
                <div class="card card-stats-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 text-muted small">Total</p>
                                <h4 class="mb-0 fw-bold">{{ $requisitions->total() }}</h4>
                            </div>
                            <div class="stats-icon bg-primary-subtle">
                                <i class="fas fa-clipboard-list text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 text-muted small">Pending</p>
                                <h4 class="mb-0 fw-bold">{{ $requisitions->where('status', 'pending')->count() }}</h4>
                            </div>
                            <div class="stats-icon bg-warning-subtle">
                                <i class="fas fa-clock text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 text-muted small">Approved</p>
                                <h4 class="mb-0 fw-bold">{{ $requisitions->where('status', 'approved')->count() }}</h4>
                            </div>
                            <div class="stats-icon bg-success-subtle">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 text-muted small">Rejected</p>
                                <h4 class="mb-0 fw-bold">{{ $requisitions->where('status', 'rejected')->count() }}</h4>
                            </div>
                            <div class="stats-icon bg-danger-subtle">
                                <i class="fas fa-times-circle text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Filters Card -->
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-filter text-primary me-2"></i>Filters
                        </h6>
                    </div>
                    <div class="card-body">
                        <form id="filterForm" class="row g-3">
                            @if(!isset($canViewOwnOnly) || !$canViewOwnOnly)
                            <div class="col-md-3">
                                <label class="form-label small fw-medium">Department</label>
                                <select name="department_id" class="form-select form-select-sm">
                                    <option value="">All Departments</option>
                                    @foreach($departments as $d)
                                        <option value="{{ $d->id }}">{{ $d->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-medium">Unit</label>
                                <select name="unit_id" class="form-select form-select-sm">
                                    <option value="">All Units</option>
                                    @foreach($units as $u)
                                        <option value="{{ $u->id }}">{{ $u->unit_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-medium">Status</label>
                                <select name="status" class="form-select form-select-sm">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-medium">From Date</label>
                                <input type="date" name="from_date" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-medium">To Date</label>
                                <input type="date" name="to_date" class="form-control form-control-sm">
                            </div>
                            @endif
                            <div class="col-md-4">
                                <label class="form-label small fw-medium">Search</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                                    <input type="text" name="keyword" class="form-control" placeholder="Req No, Employee...">
                                </div>
                            </div>
                            <div class="col-md-8 d-flex align-items-end">
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

            <!-- Table Card -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-table text-primary me-2"></i>Report Data
                        </h6>
                        <span class="badge bg-secondary">{{ $requisitions->total() }} Records</span>
                    </div>
                    <div class="card-body p-0">
                        <!-- Loading -->
                        <div id="loading" class="text-center py-5" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 text-muted small">Loading data...</p>
                        </div>

                        <!-- Table -->
                        <div id="reportTable" style="display: block;">
                            @include('admin.dashboard.reports.requisitions.table')
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
.bg-warning-subtle { background-color: rgba(247, 182, 75, 0.15); }
.bg-success-subtle { background-color: rgba(56, 239, 125, 0.15); }
.bg-danger-subtle { background-color: rgba(245, 87, 108, 0.15); }
</style>


<script>
$(function() {
    var timer;
    
    function fetchData(page) {
        $('#loading').show();
        $('#reportTable').hide();
        
        // Safety timeout - ensure loading hides after 10 seconds regardless
        var safetyTimeout = setTimeout(function() {
            $('#loading').hide();
            $('#reportTable').show();
        }, 10000);
        
        $.ajax({
            url: "{{ route('reports.requisitions') }}",
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
    $('#resetBtn').on('click', function() { $('#filterForm')[0].reset(); fetchData(1); });
    $('input[name="keyword"]').on('keyup', function() {
        clearTimeout(timer);
        timer = setTimeout(function() { fetchData(1); }, 500);
    });
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        fetchData(page);
    });
});
</script>
@endsection
