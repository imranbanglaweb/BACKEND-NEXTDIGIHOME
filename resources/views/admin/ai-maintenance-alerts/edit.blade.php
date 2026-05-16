@extends('admin.dashboard.master')

@section('title', 'Edit AI Maintenance Alert')

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
            <h1 class="h3 mb-0">Edit Maintenance Alert</h1>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('ai-maintenance-alerts.show', $alert->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('ai-maintenance-alerts.update', $alert->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Alert Type --}}
                        <div class="form-group mb-3">
                            <label for="alert_type">Alert Type <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ App\Models\AIMaintenanceAlert::getAlertTypes()[$alert->alert_type] }}" disabled>
                            <small class="text-muted">Cannot be changed</small>
                        </div>

                        {{-- Priority --}}
                        <div class="form-group mb-3">
                            <label for="priority">Priority <span class="text-danger">*</span></label>
                            <select class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                @foreach($priorities as $key => $label)
                                    <option value="{{ $key }}" {{ $alert->priority === $key ? 'selected' : '' }}>
                                        {{ ucfirst($label) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="form-group mb-3">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}" {{ $alert->status === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Urgency Level --}}
                        <div class="form-group mb-3">
                            <label for="urgency_level">Urgency Level (1-5) <span class="text-danger">*</span></label>
                            <input type="range" class="form-control-range" id="urgency_level" name="urgency_level" min="1" max="5" value="{{ $alert->urgency_level }}" required>
                            <small class="text-muted">Current: <span id="urgency_value">{{ $alert->urgency_level }}</span>/5</small>
                        </div>

                        {{-- Estimated Cost --}}
                        <div class="form-group mb-3">
                            <label for="estimated_cost">Estimated Cost ($)</label>
                            <input type="number" step="0.01" class="form-control @error('estimated_cost') is-invalid @enderror" id="estimated_cost" name="estimated_cost" value="{{ $alert->estimated_cost }}">
                            @error('estimated_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Recommendation --}}
                        <div class="form-group mb-3">
                            <label for="recommendation">Recommendation <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('recommendation') is-invalid @enderror" id="recommendation" name="recommendation" rows="4" required>{{ $alert->recommendation }}</textarea>
                            @error('recommendation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Scheduled Date --}}
                        <div class="form-group mb-3">
                            <label for="scheduled_date">Scheduled Maintenance Date</label>
                            <input type="datetime-local" class="form-control @error('scheduled_date') is-invalid @enderror" id="scheduled_date" name="scheduled_date" value="{{ $alert->scheduled_date ? $alert->scheduled_date->format('Y-m-d\TH:i') : '' }}">
                            @error('scheduled_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div class="form-group mb-3">
                            <label for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ $alert->notes }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                            <a href="{{ route('ai-maintenance-alerts.show', $alert->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Information Panel --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Alert Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Vehicle</label>
                        <p class="mb-0">
                            <strong>{{ $alert->vehicle->registration_number }}</strong>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Generated By</label>
                        <p class="mb-0">
                            <strong>{{ $alert->createdBy->name ?? 'System' }}</strong>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Created On</label>
                        <p class="mb-0">
                            <strong>{{ $alert->created_at->format('M d, Y H:i') }}</strong>
                        </p>
                    </div>
                    <div>
                        <label class="text-muted small">Last Updated</label>
                        <p class="mb-0">
                            <strong>{{ $alert->updated_at->format('M d, Y H:i') }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $('#urgency_level').on('change', function() {
        $('#urgency_value').text($(this).val());
    });
</script>
@endpush
@endsection
