@extends('admin.dashboard.master')
@section('title', 'Generate AI Maintenance Alert')

@section('main_content')
<style>
    .main-content {
        max-width: 100% !important;
        width: 100% !important;
        padding: 0 !important;
    }
    .container { padding-right: 15px; padding-left: 15px; }
    .card { border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
    .card-header { background: #f8f9fa; padding: 15px 20px; border-radius: 8px 8px 0 0; font-weight: 600; }
    .card-body { padding: 20px; }
</style>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">Generate AI Maintenance Alert</h1>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('ai-maintenance-alerts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Alerts
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Select Vehicle for AI Analysis</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('ai-maintenance-alerts.generate') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Select Vehicle <span class="text-danger">*</span></label>
                            <select name="vehicle_id" class="form-control" required>
                                <option value="">-- Select Vehicle --</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->vehicle_name }} - {{ $vehicle->vehicle_number }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-magic"></i> Generate Alert
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection