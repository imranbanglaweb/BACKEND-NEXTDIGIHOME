@extends('admin.dashboard.master')
@section('title', 'AI Reports Dashboard')

@section('main_content')
<style>
    .main-content {
        max-width: 100% !important;
        width: 100% !important;
        padding: 0 !important;
    }
    .container { padding-right: 15px; padding-left: 15px; }
    .stats-card { border-radius: 8px; padding: 20px; color: white; margin-bottom: 20px; }
    .stats-card h3 { font-size: 28px; margin: 0; }
    .stats-card p { margin: 5px 0 0; opacity: 0.9; }
</style>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">AI Reports Dashboard</h1>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('ai-reports.index') }}" class="btn btn-primary">
                <i class="fas fa-list"></i> All Reports
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card bg-info">
                <h3>0</h3>
                <p>Total Reports</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card bg-success">
                <h3>0</h3>
                <p>Completed</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card bg-warning">
                <h3>0</h3>
                <p>Generating</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card bg-danger">
                <h3>0</h3>
                <p>Failed</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Recent AI Insights</h6>
        </div>
        <div class="card-body">
            <p class="text-muted text-center py-5">No AI insights generated yet.</p>
        </div>
    </div>
</div>
@endsection