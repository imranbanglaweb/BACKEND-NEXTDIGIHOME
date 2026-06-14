@extends('admin.dashboard.master')

@section('title', 'System Logs')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page">
    <div class="container-fluid">
        <div class="premium-header"><div><div class="premium-eyebrow">System</div><h2>System Logs</h2><p>Review the latest Laravel log entries for operational issues.</p></div><div class="premium-actions"><a href="{{ route('admin.system.logs') }}" class="btn btn-primary"><i class="fas fa-sync me-2"></i>Refresh</a></div></div>
        <div class="premium-nav"><a href="{{ route('admin.system.info') }}">Info</a><a href="{{ route('admin.system.logs') }}" class="active">Logs</a><a href="{{ route('admin.system.cache') }}">Cache</a><a href="{{ route('admin.system.backup') }}">Backup</a><a href="{{ route('admin.system.api') }}">API</a></div>
        <div class="premium-card">
            <div class="premium-card-title"><div><h5>Recent Entries</h5><p>Showing the latest log lines from <code>storage/logs/laravel.log</code>.</p></div></div>
            @if(empty($logs))
                <div class="alert alert-info mb-0">No log entries found or the log file is empty.</div>
            @else
                <div class="table-responsive">
                    <table class="table premium-table">
                        <thead><tr><th>Timestamp</th><th>Level</th><th>Message</th></tr></thead>
                        <tbody>
                        @foreach($logs as $log)
                            @php
                                $levelClass = in_array(strtolower($log['level']), ['error','critical','alert','emergency']) ? 'danger' : (strtolower($log['level']) === 'warning' ? 'warning' : (in_array(strtolower($log['level']), ['notice','info']) ? 'info' : 'secondary'));
                            @endphp
                            <tr><td><small class="premium-muted">{{ $log['timestamp'] }}</small></td><td><span class="badge bg-{{ $levelClass }}">{{ $log['level'] }}</span></td><td><code style="white-space:pre-wrap">{{ Str::limit($log['message'], 260) }}</code></td></tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
