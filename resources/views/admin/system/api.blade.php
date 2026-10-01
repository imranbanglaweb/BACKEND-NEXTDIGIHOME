@extends('admin.dashboard.master')

@section('title', 'API Settings')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page">
    <div class="container-fluid">
        <div class="premium-header"><div><div class="premium-eyebrow">System</div><h2>API Settings</h2><p>Review API access, authentication, rate limiting, and CORS status.</p></div></div>
        <div class="premium-nav"><a href="{{ route('admin.system.info') }}">Info</a><a href="{{ route('admin.system.logs') }}">Logs</a><a href="{{ route('admin.system.cache') }}">Cache</a><a href="{{ route('admin.system.backup') }}">Backup</a><a href="{{ route('admin.system.api') }}" class="active">API</a></div>
        <div class="row g-3 mb-3">
            <div class="col-xl-3 col-md-6"><div class="premium-stat"><span class="premium-icon premium-blue"><i class="fas fa-plug"></i></span><div><small>API Access</small><strong>{{ $apiSettings['api_enabled'] ? 'Enabled' : 'Disabled' }}</strong></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="premium-stat"><span class="premium-icon premium-amber"><i class="fas fa-key"></i></span><div><small>API Key</small><strong>{{ $apiSettings['api_key_required'] ? 'Required' : 'Optional' }}</strong></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="premium-stat"><span class="premium-icon premium-green"><i class="fas fa-tachometer-alt"></i></span><div><small>Rate Limit</small><strong>{{ $apiSettings['rate_limiting'] ? 'On' : 'Off' }}</strong></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="premium-stat"><span class="premium-icon premium-cyan"><i class="fas fa-globe"></i></span><div><small>CORS</small><strong>{{ $apiSettings['cors_enabled'] ? 'Enabled' : 'Disabled' }}</strong></div></div></div>
        </div>
        <div class="premium-card">
            <div class="premium-card-title"><div><h5>Configuration Status</h5><p>These values are currently read from application configuration.</p></div></div>
            <table class="table premium-table mb-0"><tbody>
                <tr><td>API Enabled</td><td><span class="badge bg-{{ $apiSettings['api_enabled'] ? 'success' : 'secondary' }}">{{ $apiSettings['api_enabled'] ? 'Enabled' : 'Disabled' }}</span></td></tr>
                <tr><td>API Key Required</td><td><span class="badge bg-{{ $apiSettings['api_key_required'] ? 'warning' : 'info' }}">{{ $apiSettings['api_key_required'] ? 'Required' : 'Optional' }}</span></td></tr>
                <tr><td>Rate Limiting</td><td><span class="badge bg-{{ $apiSettings['rate_limiting'] ? 'success' : 'secondary' }}">{{ $apiSettings['rate_limiting'] ? 'Enabled' : 'Disabled' }}</span></td></tr>
                <tr><td>CORS Enabled</td><td><span class="badge bg-{{ $apiSettings['cors_enabled'] ? 'success' : 'danger' }}">{{ $apiSettings['cors_enabled'] ? 'Enabled' : 'Disabled' }}</span></td></tr>
            </tbody></table>
        </div>
    </div>
</section>
@endsection
