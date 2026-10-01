@extends('admin.dashboard.master')

<style>
body { background:#ffffff !important; }
.content-body { padding:20px 25px !important; }
.card { border-radius:12px; }
</style>

@section('main_content')
<section role="main" class="content-body" style="background:#ffffff; padding:20px; border-radius:8px;">
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">
            <i class="fa fa-plus-circle me-2"></i> Create Trip Sheet
        </h3>
        <a href="{{ route('trip-sheets.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('trip-sheets.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Vehicle</label>
                        <select name="vehicle_id" class="form-select" required>
                            <option value="">Select Vehicle</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Driver</label>
                        <select name="driver_id" class="form-select" required>
                            <option value="">Select Driver</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Requisition</label>
                        <select name="requisition_id" class="form-select">
                            <option value="">Select Requisition</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Start Location</label>
                        <input type="text" name="start_location" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">End Location</label>
                        <input type="text" name="end_location" class="form-control" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Create Trip
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
</section>
@endsection