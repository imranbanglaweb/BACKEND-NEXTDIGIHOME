@extends('admin.dashboard.master')

@section('title', 'AI Maintenance Alert - ' . $alert->alert_type)

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
            <h1 class="h3 mb-0">Maintenance Alert Details</h1>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('ai-maintenance-alerts.edit', $alert->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('ai-maintenance-alerts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Alert Information --}}
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Alert Information</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted">Vehicle</label>
                            <p class="mb-0">
                                <strong>{{ $alert->vehicle->registration_number }}</strong> - {{ $alert->vehicle->vehicle_name }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted">Alert Type</label>
                            <p class="mb-0">
                                <strong>{{ App\Models\AIMaintenanceAlert::getAlertTypes()[$alert->alert_type] }}</strong>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted">Priority</label>
                            <p class="mb-0">
                                <span class="badge bg-{{ $alert->getPriorityBadgeColor() }}">
                                    {{ ucfirst($alert->priority) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted">Status</label>
                            <p class="mb-0">
                                <span class="badge bg-{{ $alert->getStatusBadgeColor() }}">
                                    {{ ucfirst(str_replace('_', ' ', $alert->status)) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted">Urgency Level</label>
                            <div>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar" style="width: {{ ($alert->urgency_level / 5) * 100 }}%">
                                        {{ $alert->urgency_level }}/5
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted">Estimated Cost</label>
                            <p class="mb-0">
                                <strong>${{ $alert->estimated_cost ? number_format($alert->estimated_cost, 2) : 'Not specified' }}</strong>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted">Created By</label>
                            <p class="mb-0">
                                <strong>{{ $alert->createdBy->name ?? 'System' }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted">Created At</label>
                            <p class="mb-0">
                                <strong>{{ $alert->created_at->format('M d, Y H:i') }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recommendation --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">AI Recommendation</h6>
                </div>
                <div class="card-body">
                    <p>{{ $alert->recommendation }}</p>
                </div>
            </div>

            {{-- Notes --}}
            @if($alert->notes)
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Additional Notes</h6>
                </div>
                <div class="card-body">
                    <p>{{ $alert->notes }}</p>
                </div>
            </div>
            @endif

            {{-- AI Analysis Details --}}
            @if($alert->ai_analysis)
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">AI Analysis Details</h6>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded">{{ json_encode($alert->ai_analysis, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="col-md-4">
            {{-- Quick Actions --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Actions</h6>
                </div>
                <div class="card-body">
                    @if($alert->status !== 'completed')
                    <form action="{{ route('ai-maintenance-alerts.mark-completed', $alert->id) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-check"></i> Mark as Completed
                        </button>
                    </form>
                    @endif

                    <a href="{{ route('ai-maintenance-alerts.edit', $alert->id) }}" class="btn btn-warning btn-block mb-2">
                        <i class="fas fa-edit"></i> Edit Alert
                    </a>

                    <button type="button" class="btn btn-danger btn-block" onclick="deleteAlert({{ $alert->id }})">
                        <i class="fas fa-trash"></i> Delete Alert
                    </button>
                </div>
            </div>

            {{-- Scheduled Date --}}
            @if($alert->scheduled_date)
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Scheduled Maintenance</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">
                        <strong>{{ $alert->scheduled_date->format('M d, Y H:i') }}</strong>
                    </p>
                </div>
            </div>
            @endif

            {{-- Related Vehicle Info --}}
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Vehicle Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Make & Model</label>
                        <p class="mb-0">{{ $alert->vehicle->make_model }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Current Mileage</label>
                        <p class="mb-0">{{ number_format($alert->vehicle->current_mileage ?? 0) }} km</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Age</label>
                        <p class="mb-0">{{ $alert->vehicle->age ?? 'N/A' }} years</p>
                    </div>
                    <div>
                        <label class="text-muted small">Last Service</label>
                        <p class="mb-0">{{ $alert->vehicle->last_service_date ? $alert->vehicle->last_service_date->format('M d, Y') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function deleteAlert(alertId) {
        if (confirm('Are you sure you want to delete this alert?')) {
            $.ajax({
                url: '{{ route("ai-maintenance-alerts.destroy", ":id") }}'.replace(':id', alertId),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function() {
                    window.location.href = '{{ route("ai-maintenance-alerts.index") }}';
                }
            });
        }
    }
</script>
@endpush
@endsection
