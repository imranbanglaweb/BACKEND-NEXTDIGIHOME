@extends('admin.dashboard.master')

@section('title', 'Server Tracking Audit Logs - ' . config('app.name'))

@section('main_content')
<div class="dashboard-header mb-4">
    <div class="dashboard-header-left">
        <div class="dashboard-header-icon" style="background: linear-gradient(135deg, #00d4aa 0%, #38bdf8 100%); color: #070b14; width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fa fa-list"></i>
        </div>
        <div class="dashboard-header-content ml-3">
            <h1 class="h3 font-weight-bold mb-1" style="color: #ffffff;">Server Tracking Audit Logs</h1>
            <p class="text-muted small mb-0">Inspect real-time server-side tracking dispatches, API status codes, and payloads</p>
        </div>
    </div>
    <div class="dashboard-header-right">
        <a href="{{ route('admin.server-tracking.dashboard') }}" class="btn btn-outline-light btn-sm mr-2">
            <i class="fa fa-arrow-left mr-1"></i> Dashboard
        </a>
        <a href="{{ route('admin.server-tracking.config') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-cog mr-1"></i> Config
        </a>
    </div>
</div>

<!-- Filters Bar -->
<div class="card mb-4" style="background: #0f1523; border: 1px solid rgba(255,255,255,0.08); border-radius: 16px;">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.server-tracking.logs') }}" class="row align-items-center">
            <div class="col-md-3 mb-2 mb-md-0">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search event, lead ID, or event ID..." value="{{ request('search') }}" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <select name="provider" class="form-control form-control-sm" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                    <option value="">All Providers</option>
                    <option value="meta_capi" {{ request('provider') === 'meta_capi' ? 'selected' : '' }}>Meta CAPI</option>
                    <option value="ga4" {{ request('provider') === 'ga4' ? 'selected' : '' }}>Google Analytics 4</option>
                    <option value="tiktok" {{ request('provider') === 'tiktok' ? 'selected' : '' }}>TikTok Events API</option>
                    <option value="webhook" {{ request('provider') === 'webhook' ? 'selected' : '' }}>Webhook / sGTM</option>
                </select>
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <select name="status" class="form-control form-control-sm" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                    <option value="">All Statuses</option>
                    <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success (2xx)</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed / Rejected</option>
                    <option value="skipped" {{ request('status') === 'skipped' ? 'selected' : '' }}>Skipped (Disabled)</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-info w-100 mr-2">
                    <i class="fa fa-filter mr-1"></i> Filter
                </button>
                <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-sm btn-outline-secondary">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Logs Table Card -->
<div class="card" style="background: #0f1523; border: 1px solid rgba(255,255,255,0.08); border-radius: 16px;">
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="color: #cbd5e1;">
            <thead style="background: rgba(0,0,0,0.3); border-bottom: 1px solid rgba(255,255,255,0.08);">
                <tr>
                    <th style="font-size: 11px; text-transform: uppercase;">ID</th>
                    <th style="font-size: 11px; text-transform: uppercase;">Timestamp</th>
                    <th style="font-size: 11px; text-transform: uppercase;">Provider</th>
                    <th style="font-size: 11px; text-transform: uppercase;">Event</th>
                    <th style="font-size: 11px; text-transform: uppercase;">Lead / Order</th>
                    <th style="font-size: 11px; text-transform: uppercase;">Event ID</th>
                    <th style="font-size: 11px; text-transform: uppercase;">Status</th>
                    <th style="font-size: 11px; text-transform: uppercase;">HTTP</th>
                    <th style="font-size: 11px; text-transform: uppercase; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="small font-mono text-muted">#{{ $log->id }}</td>
                    <td class="small text-muted font-mono">{{ $log->created_at ? $log->created_at->format('Y-m-d H:i:s') : '—' }}</td>
                    <td>
                        <span class="badge badge-dark text-uppercase font-mono" style="font-size: 10px; border: 1px solid rgba(255,255,255,0.15);">
                            {{ $log->provider }}
                        </span>
                    </td>
                    <td><strong class="text-white">{{ $log->event_name }}</strong></td>
                    <td class="small font-mono text-info">{{ $log->lead_id ?: ($log->order_id ?: '—') }}</td>
                    <td class="small font-mono text-muted truncate" style="max-width: 140px;" title="{{ $log->event_id }}">{{ $log->event_id ?: '—' }}</td>
                    <td>
                        @if($log->status === 'success')
                            <span class="badge badge-success" style="font-size: 10px;">SUCCESS</span>
                        @elseif($log->status === 'failed')
                            <span class="badge badge-danger" style="font-size: 10px;">FAILED</span>
                        @else
                            <span class="badge badge-secondary" style="font-size: 10px;">SKIPPED</span>
                        @endif
                    </td>
                    <td class="font-mono small">{{ $log->http_code ?: '—' }}</td>
                    <td class="text-right">
                        <button type="button" class="btn btn-xs btn-outline-info view-payload-btn" 
                            data-log-id="{{ $log->id }}"
                            data-request="{{ json_encode($log->request_payload) }}"
                            data-response="{{ json_encode($log->response_payload) }}"
                            data-error="{{ $log->error_message }}"
                            style="font-size: 11px; padding: 2px 8px;">
                            <i class="fa fa-code mr-1"></i> Payload
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        No server tracking logs matching your criteria.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($logs, 'hasPages') && $logs->hasPages())
    <div class="card-footer d-flex justify-content-center" style="background: transparent; border-top: 1px solid rgba(255,255,255,0.08);">
        {{ $logs->links() }}
    </div>
    @endif
</div>

<!-- Payload Inspection Modal -->
<div class="modal fade" id="payloadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="background: #0d121f; border: 1px solid rgba(0,212,170,0.3); border-radius: 16px;">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                <h5 class="modal-title text-white font-weight-bold" id="payloadModalTitle">
                    <i class="fa fa-code mr-2 text-info"></i>Payload Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-error-box" class="alert alert-danger d-none mb-3" style="font-size: 12px;"></div>

                <label class="text-muted small uppercase font-weight-bold">Request Payload Sent</label>
                <pre id="modal-request-content" class="p-3 rounded mb-3 text-info font-mono small" style="background: #060911; border: 1px solid rgba(255,255,255,0.08); max-height: 200px; overflow-y: auto;"></pre>

                <label class="text-muted small uppercase font-weight-bold">API Response Received</label>
                <pre id="modal-response-content" class="p-3 rounded mb-0 text-success font-mono small" style="background: #060911; border: 1px solid rgba(255,255,255,0.08); max-height: 200px; overflow-y: auto;"></pre>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.08);">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.view-payload-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-log-id');
        const reqStr = this.getAttribute('data-request');
        const resStr = this.getAttribute('data-response');
        const errStr = this.getAttribute('data-error');

        document.getElementById('payloadModalTitle').innerHTML = `<i class="fa fa-code mr-2 text-info"></i>Log #${id} Inspection`;

        const errorBox = document.getElementById('modal-error-box');
        if (errStr && errStr.trim() !== '') {
            errorBox.classList.remove('d-none');
            errorBox.textContent = errStr;
        } else {
            errorBox.classList.add('d-none');
        }

        try {
            document.getElementById('modal-request-content').textContent = JSON.stringify(JSON.parse(reqStr), null, 2);
        } catch {
            document.getElementById('modal-request-content').textContent = reqStr || 'Empty';
        }

        try {
            document.getElementById('modal-response-content').textContent = JSON.stringify(JSON.parse(resStr), null, 2);
        } catch {
            document.getElementById('modal-response-content').textContent = resStr || 'Empty';
        }

        if (typeof $ !== 'undefined' && $('#payloadModal').modal) {
            $('#payloadModal').modal('show');
        } else {
            alert("Request:\n" + document.getElementById('modal-request-content').textContent + "\n\nResponse:\n" + document.getElementById('modal-response-content').textContent);
        }
    });
});
</script>
@endsection
