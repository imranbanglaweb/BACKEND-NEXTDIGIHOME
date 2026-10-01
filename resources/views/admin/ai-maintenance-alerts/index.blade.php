@extends('admin.dashboard.master')

@section('title', 'AI Maintenance Alerts')

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
        <div class="col-md-12">
            <h1 class="h3 mb-0">AI Maintenance Alerts</h1>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('ai-maintenance-alerts.generate') }}" class="btn btn-primary">
                <i class="fas fa-magic"></i> Generate New Alert
            </a>
        </div>
    </div>

    {{-- Alerts Statistics --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-0">Total</h6>
                            <h2 class="mb-0" id="total-alerts">0</h2>
                        </div>
                        <div class="text-right">
                            <i class="fas fa-bell fa-3x opacity-3"></i>
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
                            <h6 class="card-title text-uppercase mb-0">Pending</h6>
                            <h2 class="mb-0" id="pending-alerts">0</h2>
                        </div>
                        <div class="text-right">
                            <i class="fas fa-hourglass-half fa-3x opacity-3"></i>
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
                            <h6 class="card-title text-uppercase mb-0">Critical</h6>
                            <h2 class="mb-0" id="critical-alerts">0</h2>
                        </div>
                        <div class="text-right">
                            <i class="fas fa-exclamation-circle fa-3x opacity-3"></i>
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
                            <h2 class="mb-0" id="completed-alerts">0</h2>
                        </div>
                        <div class="text-right">
                            <i class="fas fa-check-circle fa-3x opacity-3"></i>
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
                <div class="col-md-3">
                    <label>Status</label>
                    <select class="form-control filter-select" data-filter="status">
                        <option value="">All Status</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Priority</label>
                    <select class="form-control filter-select" data-filter="priority">
                        <option value="">All Priorities</option>
                        @foreach($priorities as $key => $label)
                            <option value="{{ $key }}">{{ ucfirst($label) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Alert Type</label>
                    <select class="form-control filter-select" data-filter="alert_type">
                        <option value="">All Types</option>
                        @foreach($alertTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Vehicle</label>
                    <input type="text" class="form-control filter-input" data-filter="vehicle" placeholder="Search vehicle...">
                </div>
            </div>
        </div>
    </div>

    {{-- Alerts Table --}}
    <div class="card">
        <div class="card-body">
            <table id="alertsTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>Vehicle</th>
                        <th>Alert Type</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Urgency</th>
                        <th>Est. Cost</th>
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
        let table = $('#alertsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('ai-maintenance-alerts.index') }}",
                data: function(d) {
                    d.status = $('.filter-select[data-filter="status"]').val();
                    d.priority = $('.filter-select[data-filter="priority"]').val();
                    d.alert_type = $('.filter-select[data-filter="alert_type"]').val();
                    d.vehicle = $('.filter-input[data-filter="vehicle"]').val();
                }
            },
            columns: [
                {'data': 'vehicle'},
                {'data': 'alert_type'},
                {'data': 'priority', 'orderable': false},
                {'data': 'status', 'orderable': false},
                {'data': 'urgency_level', 'orderable': false},
                {'data': 'estimated_cost'},
                {'data': 'created_at'},
                {'data': 'actions', 'orderable': false}
            ]
        });

        // Apply filters
        $('.filter-select, .filter-input').on('change keyup', function() {
            table.draw();
        });

        updateStats();
    });

    function updateStats() {
        $.get("{{ route('ai-maintenance-alerts.stats') }}", function(data) {
            $('#total-alerts').text(data.total);
            $('#pending-alerts').text(data.pending);
            $('#critical-alerts').text(data.critical);
            $('#completed-alerts').text(data.completed);
        });
    }

    function markAsCompleted(alertId) {
        if (confirm('Mark this alert as completed?')) {
            $.post('{{ route("ai-maintenance-alerts.mark-completed", ":id") }}'.replace(':id', alertId), {
                _token: '{{ csrf_token() }}'
            }, function() {
                location.reload();
            });
        }
    }

    function deleteAlert(alertId) {
        if (confirm('Are you sure you want to delete this alert?')) {
            $.ajax({
                url: '{{ route("ai-maintenance-alerts.destroy", ":id") }}'.replace(':id', alertId),
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
