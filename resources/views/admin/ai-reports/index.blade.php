@extends('admin.dashboard.master')
@section('title', 'AI Reports')

@section('main_content')
<style>
    .main-content {
        max-width: 100% !important;
        width: 100% !important;
        padding: 0 !important;
    }
    .container {
        padding-right: 15px;
        padding-left: 15px;
    }
</style>
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">AI-Powered Reporting</h1>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('ai-reports.create') }}" class="btn btn-primary">
                <i class="fas fa-file-alt"></i> Generate New Report
            </a>
        </div>
    </div>

    {{-- Reports Statistics --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-0">Total Reports</h6>
                            <h2 class="mb-0" id="total-reports">0</h2>
                        </div>
                        <div class="text-right">
                            <i class="fas fa-chart-bar fa-3x opacity-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-0">Completed</h6>
                            <h2 class="mb-0" id="completed-reports">0</h2>
                        </div>
                        <div class="text-right">
                            <i class="fas fa-check-circle fa-3x opacity-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-0">Generating</h6>
                            <h2 class="mb-0" id="generating-reports">0</h2>
                        </div>
                        <div class="text-right">
                            <i class="fas fa-spinner fa-3x opacity-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-0">Failed</h6>
                            <h2 class="mb-0" id="failed-reports">0</h2>
                        </div>
                        <div class="text-right">
                            <i class="fas fa-exclamation-circle fa-3x opacity-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0">Filters</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label>Report Type</label>
                    <select class="form-control filter-select" data-filter="report_type">
                        <option value="">All Types</option>
                        @foreach($reportTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Status</label>
                    <select class="form-control filter-select" data-filter="status">
                        <option value="">All Status</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>&nbsp;</label>
                    <button class="btn btn-secondary btn-block" id="clearFilters">
                        <i class="fas fa-redo"></i> Clear Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Reports Table --}}
    <div class="card">
        <div class="card-body">
            <table id="reportsTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Report Type</th>
                        <th>Period</th>
                        <th>Status</th>
                        <th>Records</th>
                        <th>Created By</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(function() {
        let table = $('#reportsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('ai-reports.index') }}",
                data: function(d) {
                    d.report_type = $('.filter-select[data-filter="report_type"]').val();
                    d.status = $('.filter-select[data-filter="status"]').val();
                }
            },
            columns: [
                {'data': 'title'},
                {'data': 'report_type'},
                {'data': 'period', 'orderable': false},
                {'data': 'status', 'orderable': false},
                {'data': 'total_records'},
                {'data': 'created_by'},
                {'data': 'created_at'},
                {'data': 'actions', 'orderable': false}
            ]
        });

        // Apply filters
        $('.filter-select').on('change', function() {
            table.draw();
        });

        // Clear filters
        $('#clearFilters').on('click', function() {
            $('.filter-select').val('').change();
        });

        updateStats();
    });

    function updateStats() {
        $.get("{{ route('ai-reports.stats') }}", function(data) {
            $('#total-reports').text(data.total);
            $('#completed-reports').text(data.completed);
            $('#generating-reports').text(data.generating);
            $('#failed-reports').text(data.failed);
        });
    }

    function deleteReport(reportId) {
        if (confirm('Are you sure you want to delete this report?')) {
            $.ajax({
                url: '{{ route("ai-reports.destroy", ":id") }}'.replace(':id', reportId),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function() {
                    location.reload();
                }
            });
        }
    }
</script>
@endpush
@endsection
