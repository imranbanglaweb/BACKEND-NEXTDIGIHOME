@extends('admin.dashboard.master')

@section('title', 'Generate AI Report')

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
            <h1 class="h3 mb-0">Generate AI-Powered Report</h1>
            <p class="text-muted">Let AI analyze your fleet data and generate insights</p>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('ai-reports.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('ai-reports.store') }}" method="POST">
                        @csrf

                        {{-- Report Type --}}
                        <div class="form-group mb-4">
                            <label for="report_type">Report Type <span class="text-danger">*</span></label>
                            <select class="form-control @error('report_type') is-invalid @enderror" id="report_type" name="report_type" required onchange="updateTypeDescription()">
                                <option value="">-- Select Report Type --</option>
                                @foreach($reportTypes as $key => $label)
                                    <option value="{{ $key }}" {{ old('report_type') === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted d-block mt-2" id="typeDescription"></small>
                            @error('report_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Title --}}
                        <div class="form-group mb-3">
                            <label for="title">Report Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required placeholder="Enter a descriptive title">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Optional: Add context or specific focus areas for this report">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Period --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="report_period_from">Report Period From <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('report_period_from') is-invalid @enderror" id="report_period_from" name="report_period_from" value="{{ old('report_period_from') }}" required>
                                @error('report_period_from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="report_period_to">Report Period To <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('report_period_to') is-invalid @enderror" id="report_period_to" name="report_period_to" value="{{ old('report_period_to') }}" required>
                                @error('report_period_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Quick Period Buttons --}}
                        <div class="form-group mb-4 text-center">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="setPeriodThisMonth()">This Month</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="setPeriodLastMonth()">Last Month</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="setPeriodThisQuarter()">This Quarter</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="setPeriodLastYear()">Last Year</button>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-magic"></i> Generate Report
                            </button>
                            <a href="{{ route('ai-reports.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Information Panel --}}
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle"></i> Report Types</h6>
                </div>
                <div class="card-body small">
                    <div class="mb-3">
                        <strong>Maintenance Analysis</strong>
                        <p class="text-muted mb-0">AI analyzes maintenance patterns and predicts future maintenance needs.</p>
                    </div>
                    <div class="mb-3">
                        <strong>Fuel Efficiency Report</strong>
                        <p class="text-muted mb-0">Identifies fuel consumption patterns and optimization opportunities.</p>
                    </div>
                    <div class="mb-3">
                        <strong>Driver Performance Report</strong>
                        <p class="text-muted mb-0">Analyzes driver behavior and performance metrics.</p>
                    </div>
                    <div class="mb-3">
                        <strong>Fleet Health Report</strong>
                        <p class="text-muted mb-0">Overall assessment of vehicle condition and readiness.</p>
                    </div>
                    <div>
                        <strong>Cost Analysis Report</strong>
                        <p class="text-muted mb-0">Breakdown of all fleet-related costs with optimization recommendations.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-lightbulb"></i> Tips</h6>
                </div>
                <div class="card-body small">
                    <ul class="mb-0">
                        <li>Reports are generated using AI analysis</li>
                        <li>Larger time periods may take longer to process</li>
                        <li>Once ready, you can download the report as PDF</li>
                        <li>All report data is stored for future reference</li>
                        <li>Use specific periods for more accurate analysis</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const typeDescriptions = {
        'maintenance': 'Analyzes maintenance requisitions, history, and patterns to predict future maintenance needs.',
        'fuel_efficiency': 'Examines fuel consumption trends and identifies opportunities to improve efficiency.',
        'driver_performance': 'Evaluates driver behavior, safety records, and performance metrics.',
        'fleet_health': 'Provides comprehensive assessment of all vehicles in your fleet.',
        'cost_analysis': 'Analyzes all operational costs including maintenance, fuel, and other expenses.',
        'custom': 'Create a custom report based on your specific criteria.'
    };

    function updateTypeDescription() {
        const type = $('#report_type').val();
        $('#typeDescription').text(typeDescriptions[type] || '');
    }

    function setDateRange(from, to) {
        $('#report_period_from').val(from.toISOString().split('T')[0]);
        $('#report_period_to').val(to.toISOString().split('T')[0]);
    }

    function setPeriodThisMonth() {
        const now = new Date();
        const from = new Date(now.getFullYear(), now.getMonth(), 1);
        setDateRange(from, now);
    }

    function setPeriodLastMonth() {
        const now = new Date();
        const to = new Date(now.getFullYear(), now.getMonth(), 0);
        const from = new Date(now.getFullYear(), now.getMonth() - 1, 1);
        setDateRange(from, to);
    }

    function setPeriodThisQuarter() {
        const now = new Date();
        const quarter = Math.floor(now.getMonth() / 3);
        const from = new Date(now.getFullYear(), quarter * 3, 1);
        setDateRange(from, now);
    }

    function setPeriodLastYear() {
        const now = new Date();
        const from = new Date(now.getFullYear() - 1, 0, 1);
        const to = new Date(now.getFullYear(), 0, 0);
        setDateRange(from, to);
    }
</script>
@endpush
@endsection
