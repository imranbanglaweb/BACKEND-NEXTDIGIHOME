@extends('admin.dashboard.master')

@section('title', 'AI Report - ' . $report->title)

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
            <h1 class="h3 mb-0">{{ $report->title }}</h1>
        </div>
        <div class="col-md-4 text-right">
            @if($report->isReady())
                <a href="{{ route('ai-reports.download', $report->id) }}" class="btn btn-success">
                    <i class="fas fa-download"></i> Download PDF
                </a>
            @endif
            <a href="{{ route('ai-reports.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    {{-- Status Alert --}}
    @if($report->isGenerating())
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-spinner fa-spin"></i> Report is being generated. Please check back in a few moments...
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @elseif($report->status === 'failed')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <strong>Report generation failed:</strong> {{ $report->error_message }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        {{-- Main Content --}}
        <div class="col-md-8">
            {{-- Report Information --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Report Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted">Report Type</label>
                            <p class="mb-0">
                                <strong>{{ App\Models\AIReport::getReportTypes()[$report->report_type] }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted">Status</label>
                            <p class="mb-0">
                                <span class="badge bg-{{ $report->getStatusBadgeColor() }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="text-muted">Period</label>
                            <p class="mb-0">
                                <strong>{{ $report->report_period_from->format('M d, Y') }} - {{ $report->report_period_to->format('M d, Y') }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted">Records</label>
                            <p class="mb-0">
                                <strong>{{ number_format($report->total_records) }}</strong>
                            </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="text-muted">Created By</label>
                            <p class="mb-0">
                                <strong>{{ $report->createdBy->name ?? 'System' }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted">Created At</label>
                            <p class="mb-0">
                                <strong>{{ $report->created_at->format('M d, Y H:i') }}</strong>
                            </p>
                        </div>
                    </div>
                    @if($report->description)
                    <div class="mt-3">
                        <label class="text-muted">Description</label>
                        <p class="mb-0">{{ $report->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- AI Summary --}}
            @if($report->ai_summary && is_array($report->ai_summary))
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-brain"></i> AI Executive Summary</h6>
                    </div>
                    <div class="card-body">
                        @if(is_string($report->ai_summary))
                            <p>{{ $report->ai_summary }}</p>
                        @else
                            @foreach($report->ai_summary as $item)
                                <p>{{ $item }}</p>
                            @endforeach
                        @endif
                    </div>
                </div>
            @elseif($report->ai_summary && is_string($report->ai_summary))
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-brain"></i> AI Executive Summary</h6>
                    </div>
                    <div class="card-body">
                        <p>{{ $report->ai_summary }}</p>
                    </div>
                </div>
            @endif

            {{-- Key Findings --}}
            @if($report->ai_findings)
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-search"></i> Key Findings</h6>
                    </div>
                    <div class="card-body">
                        @if(is_array($report->ai_findings))
                            <ul>
                                @foreach($report->ai_findings as $finding)
                                    <li>{{ $finding }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>{{ $report->ai_findings }}</p>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Recommendations --}}
            @if($report->ai_recommendations)
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-lightbulb"></i> AI Recommendations</h6>
                    </div>
                    <div class="card-body">
                        @if(is_array($report->ai_recommendations))
                            <ul>
                                @foreach($report->ai_recommendations as $rec)
                                    <li>{{ $rec }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>{{ $report->ai_recommendations }}</p>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Raw Data --}}
            @if($report->raw_data && count($report->raw_data) > 0)
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Raw Data</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        @if(is_array($report->raw_data[0]))
                                            @foreach(array_keys($report->raw_data[0]) as $key)
                                                <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                                            @endforeach
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(is_array($report->raw_data[0]))
                                        @foreach($report->raw_data as $row)
                                            <tr>
                                                @foreach($row as $value)
                                                    <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="col-md-4">
            {{-- Actions --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Actions</h6>
                </div>
                <div class="card-body">
                    @if($report->isReady())
                        <a href="{{ route('ai-reports.download', $report->id) }}" class="btn btn-success btn-block mb-2">
                            <i class="fas fa-download"></i> Download PDF
                        </a>
                    @endif

                    <button type="button" class="btn btn-danger btn-block" onclick="deleteReport({{ $report->id }})">
                        <i class="fas fa-trash"></i> Delete Report
                    </button>
                </div>
            </div>

            {{-- Report Details --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Details</h6>
                </div>
                <div class="card-body small">
                    <div class="mb-3">
                        <label class="text-muted">Report Type</label>
                        <p class="mb-0">{{ App\Models\AIReport::getReportTypes()[$report->report_type] ?? $report->report_type }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Status</label>
                        <p class="mb-0">
                            <span class="badge bg-{{ $report->getStatusBadgeColor() }}">{{ ucfirst($report->status) }}</span>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Total Records</label>
                        <p class="mb-0">{{ number_format($report->total_records) }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Period</label>
                        <p class="mb-0">{{ $report->report_period_from->format('M d, Y') }} to {{ $report->report_period_to->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <label class="text-muted">Generated</label>
                        <p class="mb-0">{{ $report->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            {{-- AI Analysis JSON --}}
            @if($report->ai_analysis)
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Full AI Analysis</h6>
                    </div>
                    <div class="card-body">
                        <pre class="bg-light p-3 rounded small" style="max-height: 400px; overflow-y: auto;">{{ json_encode($report->ai_analysis, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function deleteReport(reportId) {
        if (confirm('Are you sure you want to delete this report? This action cannot be undone.')) {
            $.ajax({
                url: '{{ route("ai-reports.destroy", ":id") }}'.replace(':id', reportId),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function() {
                    window.location.href = '{{ route("ai-reports.index") }}';
                }
            });
        }
    }

    // Auto-reload if report is still generating
    @if($report->isGenerating())
        setTimeout(function() {
            location.reload();
        }, 3000);
    @endif
</script>
@endpush
@endsection
