@extends('admin.dashboard.master')

@section('title', 'System Logs')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt"></i> System Logs
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.system.logs') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-sync"></i> Refresh
                        </a>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(empty($logs))
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No log entries found or log file is empty.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Level</th>
                                        <th>Message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                    <tr>
                                        <td>
                                            <small class="text-muted">{{ $log['timestamp'] }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $levelClass = 'secondary';
                                                switch(strtolower($log['level'])) {
                                                    case 'error':
                                                    case 'critical':
                                                    case 'alert':
                                                    case 'emergency':
                                                        $levelClass = 'danger';
                                                        break;
                                                    case 'warning':
                                                        $levelClass = 'warning';
                                                        break;
                                                    case 'notice':
                                                    case 'info':
                                                        $levelClass = 'info';
                                                        break;
                                                    case 'debug':
                                                        $levelClass = 'secondary';
                                                        break;
                                                }
                                            @endphp
                                            <span class="badge badge-{{ $levelClass }}">
                                                {{ $log['level'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <code style="word-wrap: break-word; white-space: pre-wrap;">
                                                {{ Str::limit($log['message'], 200) }}
                                            </code>
                                            @if(strlen($log['message']) > 200)
                                                <button class="btn btn-xs btn-outline-secondary ml-2" onclick="showFullLog('{{ addslashes($log['raw']) }}')">
                                                    <i class="fas fa-eye"></i> Full
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i>
                                Showing last 100 log entries. Log file: <code>storage/logs/laravel.log</code>
                            </small>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Log Levels:</h6>
                            <div class="d-flex flex-wrap">
                                <span class="badge badge-danger mr-2">ERROR</span>
                                <span class="badge badge-warning mr-2">WARNING</span>
                                <span class="badge badge-info mr-2">INFO</span>
                                <span class="badge badge-secondary mr-2">DEBUG</span>
                                <span class="badge badge-success mr-2">NOTICE</span>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('admin.system.logs') }}" class="btn btn-primary">
                                <i class="fas fa-sync"></i> Refresh Logs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for full log message -->
<div class="modal fade" id="logModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Full Log Message</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <pre id="fullLogContent" style="white-space: pre-wrap; word-wrap: break-word;"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function showFullLog(content) {
    document.getElementById('fullLogContent').textContent = content;
    $('#logModal').modal('show');
}
</script>
@endsection