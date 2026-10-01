@extends('admin.dashboard.master')

@section('title', 'System Information')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page">
    <div class="container-fluid">
        <div class="premium-header">
            <div><div class="premium-eyebrow">System</div><h2>System Information</h2><p>Review application, server, database, and disk status.</p></div>
            <div class="premium-actions"><a href="{{ route('admin.system.cache') }}" class="btn btn-primary"><i class="fas fa-memory me-2"></i>Cache</a></div>
        </div>
        <div class="premium-nav">
            <a href="{{ route('admin.system.info') }}" class="active">Info</a>
            <a href="{{ route('admin.system.logs') }}">Logs</a>
            <a href="{{ route('admin.system.cache') }}">Cache</a>
            <a href="{{ route('admin.system.backup') }}">Backup</a>
            <a href="{{ route('admin.system.api') }}">API</a>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-xl-3 col-md-6"><div class="premium-stat"><span class="premium-icon premium-blue"><i class="fas fa-server"></i></span><div><small>Server</small><strong>Online</strong></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="premium-stat"><span class="premium-icon premium-green"><i class="fas fa-database"></i></span><div><small>Database</small><strong>{{ $databaseInfo['connection_status'] }}</strong></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="premium-stat"><span class="premium-icon premium-cyan"><i class="fas fa-code-branch"></i></span><div><small>Laravel</small><strong>{{ $systemInfo['laravel_version'] }}</strong></div></div></div>
            <div class="col-xl-3 col-md-6"><div class="premium-stat"><span class="premium-icon premium-amber"><i class="fas fa-shield-alt"></i></span><div><small>Debug</small><strong>{{ $systemInfo['debug_mode'] }}</strong></div></div></div>
        </div>
        <div class="row g-3">
            <div class="col-lg-6"><div class="premium-card"><div class="premium-card-title"><div><h5>Application</h5><p>Core runtime configuration.</p></div></div>
                <table class="table premium-table mb-0"><tbody>
                    <tr><td>PHP Version</td><td class="fw-bold">{{ $systemInfo['php_version'] }}</td></tr>
                    <tr><td>Environment</td><td><span class="badge bg-{{ $systemInfo['environment'] == 'production' ? 'danger' : 'info' }}">{{ $systemInfo['environment'] }}</span></td></tr>
                    <tr><td>Maintenance Mode</td><td><span class="badge bg-{{ $systemInfo['maintenance_mode'] == 'Enabled' ? 'danger' : 'success' }}">{{ $systemInfo['maintenance_mode'] }}</span></td></tr>
                    <tr><td>Timezone</td><td>{{ $systemInfo['timezone'] }}</td></tr>
                    <tr><td>Locale</td><td>{{ $systemInfo['locale'] }}</td></tr>
                </tbody></table>
            </div></div>
            <div class="col-lg-6"><div class="premium-card"><div class="premium-card-title"><div><h5>Server & Storage</h5><p>Database, cache, session, and disk details.</p></div></div>
                <table class="table premium-table mb-0"><tbody>
                    <tr><td>Server Software</td><td>{{ $systemInfo['server_software'] }}</td></tr>
                    <tr><td>Database</td><td>{{ $databaseInfo['database_name'] }}</td></tr>
                    <tr><td>Cache Driver</td><td>{{ $systemInfo['cache_driver'] }}</td></tr>
                    <tr><td>Session Driver</td><td>{{ $systemInfo['session_driver'] }}</td></tr>
                    <tr><td>Disk Used</td><td>{{ $diskInfo['used_space'] }} of {{ $diskInfo['total_space'] }}</td></tr>
                    <tr><td>Free Disk</td><td>{{ $diskInfo['free_space'] }}</td></tr>
                </tbody></table>
            </div></div>
        </div>
    </div>
</section>
@endsection
