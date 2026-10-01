@extends('admin.dashboard.master')

@section('title', 'Cache Management')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page">
    <div class="container-fluid">
        <div class="premium-header">
            <div><div class="premium-eyebrow">System</div><h2>Cache Management</h2><p>Inspect cache configuration and clear generated application caches.</p></div>
            <div class="premium-actions"><button type="button" class="btn btn-outline-light" onclick="window.location.reload()"><i class="fas fa-sync me-2"></i>Refresh</button></div>
        </div>
        <div class="premium-nav">
            <a href="{{ route('admin.system.info') }}">Info</a><a href="{{ route('admin.system.logs') }}">Logs</a><a href="{{ route('admin.system.cache') }}" class="active">Cache</a><a href="{{ route('admin.system.backup') }}">Backup</a><a href="{{ route('admin.system.api') }}">API</a>
        </div>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        <div class="row g-3 mb-3">
            <div class="col-xl-4 col-md-6"><div class="premium-stat"><span class="premium-icon premium-blue"><i class="fas fa-memory"></i></span><div><small>Driver</small><strong>{{ $cacheInfo['driver'] }}</strong></div></div></div>
            <div class="col-xl-4 col-md-6"><div class="premium-stat"><span class="premium-icon premium-green"><i class="fas fa-plug"></i></span><div><small>Status</small><strong>{{ $cacheInfo['status'] }}</strong></div></div></div>
            <div class="col-xl-4 col-md-6"><div class="premium-stat"><span class="premium-icon premium-cyan"><i class="fas fa-file"></i></span><div><small>Files / Keys</small><strong>{{ number_format($cacheStats['cache_files'] ?? $cacheStats['keys_count'] ?? 0) }}</strong></div></div></div>
        </div>
        <div class="row g-3">
            <div class="col-lg-6"><div class="premium-card"><div class="premium-card-title"><div><h5>Cache Details</h5><p>Current backend cache state.</p></div></div>
                @if(isset($cacheStats['error']))<div class="alert alert-warning">{{ $cacheStats['error'] }}</div>@endif
                <table class="table premium-table mb-0"><tbody>
                    <tr><td>Cache Driver</td><td><span class="badge bg-info">{{ $cacheInfo['driver'] }}</span></td></tr>
                    <tr><td>Status</td><td><span class="badge bg-{{ $cacheInfo['status'] == 'Connected' ? 'success' : 'danger' }}">{{ $cacheInfo['status'] }}</span></td></tr>
                    @if(isset($cacheStats['memory_used']))<tr><td>Memory Used</td><td>{{ $cacheStats['memory_used'] }}</td></tr>@endif
                </tbody></table>
            </div></div>
            <div class="col-lg-6"><div class="premium-card"><div class="premium-card-title"><div><h5>Operations</h5><p>Clear app, config, route, and view caches.</p></div></div>
                <form action="{{ route('admin.system.cache.clear') }}" method="POST">@csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Clear all application caches?')"><i class="fas fa-trash me-2"></i>Clear All Caches</button>
                </form>
                <div class="alert alert-info mt-3 mb-0">Clears application cache, configuration cache, route cache, and compiled views.</div>
            </div></div>
        </div>
    </div>
</section>
@endsection
