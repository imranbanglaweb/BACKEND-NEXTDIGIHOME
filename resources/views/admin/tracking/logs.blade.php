@extends('admin.dashboard.master')

@section('title', 'Server Tracking Audit Logs - ' . config('app.name'))

@section('main_content')
@include('admin.partials.premium-ui')

<style>
    .channel-meta { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .channel-ga4 { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .channel-tiktok { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
    .channel-webhook { background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe; }
</style>

<div class="premium-page">
    <div class="container-fluid">

        <!-- Hero Header -->
        <div class="premium-header">
            <div>
                <div class="premium-eyebrow">
                    <i class="fas fa-list-alt mr-1"></i> Conversion Audit Trail &amp; Telemetry
                </div>
                <h2>Server Tracking Audit Logs &amp; Inspector</h2>
                <p>Inspect real-time server-side tracking dispatches, API status codes, and payloads</p>
            </div>
            <div class="premium-actions">
                <button type="button" class="btn btn-outline-light text-danger mr-2" data-toggle="modal" data-target="#clearLogsModal" style="border-color: rgba(239, 68, 68, 0.4) !important;">
                    <i class="fas fa-trash-alt"></i> Clear Logs
                </button>
                <a href="{{ route('admin.server-tracking.dashboard') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
                <a href="{{ route('admin.server-tracking.config') }}" class="btn btn-outline-light">
                    <i class="fas fa-sliders-h"></i> Configuration
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 10px;">
                <i class="fas fa-check-circle mr-2" style="font-size: 16px;"></i>
                <div class="font-weight-500">{{ session('success') }}</div>
                <button type="button" class="close text-dark ml-auto" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="background: #fff1f2; border: 1px solid #fecdd3; color: #be123c; border-radius: 10px;">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                <button type="button" class="close text-dark ml-auto" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Navigation Tabs Bar -->
        <div class="premium-nav">
            <a href="{{ route('admin.server-tracking.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard Overview
            </a>
            <a href="{{ route('admin.server-tracking.config') }}">
                <i class="fas fa-sliders-h"></i> Pipeline Credentials
            </a>
            <a href="{{ route('admin.server-tracking.logs') }}" class="active">
                <i class="fas fa-list-alt"></i> Audit Logs &amp; Inspector
                @if(method_exists($logs, 'total'))
                <span class="badge badge-secondary ml-1">{{ number_format($logs->total()) }}</span>
                @endif
            </a>
        </div>

        <!-- Filter Toolbar Card -->
        <div class="card border-0 mb-4" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);">
            <div class="card-body p-3 p-md-4">
                <form method="GET" action="{{ route('admin.server-tracking.logs') }}" class="row align-items-center">
                    <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                        <label class="text-dark small font-weight-bold mb-1">Search Keywords</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white" style="border-color: #cbd5e1; color: #64748b;"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" name="search" class="form-control" placeholder="Search event, lead ID, or event ID..." value="{{ request('search') }}" style="border-color: #cbd5e1;">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-3 mb-lg-0">
                        <label class="text-dark small font-weight-bold mb-1">Target Channel</label>
                        <select name="provider" class="form-control" style="border-color: #cbd5e1;">
                            <option value="">All Channels</option>
                            <option value="meta_capi" {{ request('provider') === 'meta_capi' ? 'selected' : '' }}>Meta CAPI</option>
                            <option value="ga4" {{ request('provider') === 'ga4' ? 'selected' : '' }}>Google Analytics 4</option>
                            <option value="tiktok" {{ request('provider') === 'tiktok' ? 'selected' : '' }}>TikTok Events API</option>
                            <option value="webhook" {{ request('provider') === 'webhook' ? 'selected' : '' }}>Server Webhook / sGTM</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-3 mb-lg-0">
                        <label class="text-dark small font-weight-bold mb-1">Delivery Status</label>
                        <select name="status" class="form-control" style="border-color: #cbd5e1;">
                            <option value="">All Statuses</option>
                            <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success (2xx Delivered)</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed / Rejected</option>
                            <option value="skipped" {{ request('status') === 'skipped' ? 'selected' : '' }}>Skipped (Disabled)</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12 d-flex align-items-end mt-2 mt-lg-0">
                        <div class="w-100 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 mr-2 font-weight-bold" style="height: 38px;">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button>
                            @if(request('search') || request('provider') || request('status'))
                            <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-outline-secondary" style="height: 38px;" title="Reset filters">
                                <i class="fas fa-undo"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Logs Table Card -->
        <div class="card border-0 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);">
            <div class="table-responsive">
                <table class="table table-hover mb-0 premium-table">
                    <thead>
                        <tr>
                            <th>Log ID</th>
                            <th>Timestamp</th>
                            <th>Channel</th>
                            <th>Event Name</th>
                            <th>Reference</th>
                            <th>Deterministic ID</th>
                            <th>Status</th>
                            <th>HTTP Code</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td class="small font-mono text-muted">#{{ $log->id }}</td>
                            <td class="small text-muted font-mono">
                                {{ $log->created_at ? $log->created_at->format('Y-m-d H:i:s') : '—' }}
                            </td>
                            <td>
                                @if($log->provider === 'meta_capi')
                                    <span class="badge channel-meta" style="font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                        <i class="fab fa-facebook mr-1"></i> META CAPI
                                    </span>
                                @elseif($log->provider === 'ga4')
                                    <span class="badge channel-ga4" style="font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                        <i class="fab fa-google mr-1"></i> GA4 PROTOCOL
                                    </span>
                                @elseif($log->provider === 'tiktok')
                                    <span class="badge channel-tiktok" style="font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                        <i class="fab fa-tiktok mr-1"></i> TIKTOK
                                    </span>
                                @else
                                    <span class="badge channel-webhook" style="font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                                        <i class="fas fa-network-wired mr-1"></i> WEBHOOK
                                    </span>
                                @endif
                            </td>
                            <td>
                                <strong class="text-dark">{{ $log->event_name }}</strong>
                            </td>
                            <td class="small font-mono text-primary font-weight-bold">
                                {{ $log->lead_id ?: ($log->order_id ?: '—') }}
                            </td>
                            <td class="small font-mono text-muted">
                                <span class="d-inline-block text-truncate" style="max-width: 130px;" title="{{ $log->event_id }}">
                                    {{ $log->event_id ?: '—' }}
                                </span>
                            </td>
                            <td>
                                @if($log->status === 'success')
                                    <span class="badge badge-success" style="font-size: 11px; padding: 4px 8px; border-radius: 12px;">
                                        <i class="fas fa-check-circle mr-1"></i> DELIVERED
                                    </span>
                                @elseif($log->status === 'failed')
                                    <span class="badge badge-danger" style="font-size: 11px; padding: 4px 8px; border-radius: 12px;">
                                        <i class="fas fa-times-circle mr-1"></i> FAILED
                                    </span>
                                @else
                                    <span class="badge badge-secondary" style="font-size: 11px; padding: 4px 8px; border-radius: 12px;">
                                        <i class="fas fa-minus-circle mr-1"></i> SKIPPED
                                    </span>
                                @endif
                            </td>
                            <td class="font-mono small">
                                <span class="{{ ($log->http_code >= 200 && $log->http_code < 300) ? 'text-success font-weight-bold' : ($log->http_code ? 'text-danger font-weight-bold' : 'text-muted') }}">
                                    {{ $log->http_code ?: '—' }}
                                </span>
                            </td>
                            <td class="text-right">
                                <button type="button" class="btn btn-xs btn-outline-primary view-payload-btn" 
                                    data-log-id="{{ $log->id }}"
                                    data-provider="{{ strtoupper($log->provider) }}"
                                    data-event="{{ $log->event_name }}"
                                    data-status="{{ strtoupper($log->status) }}"
                                    data-http="{{ $log->http_code }}"
                                    data-ip="{{ $log->ip_address }}"
                                    data-request="{{ json_encode($log->request_payload) }}"
                                    data-response="{{ json_encode($log->response_payload) }}"
                                    data-error="{{ $log->error_message }}"
                                    style="border-radius: 6px; font-size: 11px; padding: 4px 10px; font-weight: 600;">
                                    <i class="fas fa-code mr-1"></i> Inspect
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <div class="mb-2" style="font-size: 32px;"><i class="fas fa-search text-muted"></i></div>
                                <h6 class="text-dark font-weight-bold">No server tracking logs matching your criteria</h6>
                                <p class="small text-muted mb-0">Try widening your search terms or clearing active filters.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($logs, 'hasPages') && $logs->hasPages())
            <div class="card-footer d-flex justify-content-center py-3 bg-white" style="border-top: 1px solid #edf0f4;">
                {{ $logs->links() }}
            </div>
            @endif
        </div>

    </div>
</div>

<!-- Payload Telemetry Inspection Modal -->
<div class="modal fade" id="payloadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 1px solid #e2e8f0; border-radius: 14px; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);">
            <div class="modal-header py-3 px-4" style="border-bottom: 1px solid #edf0f4; background: #f8fafc; border-radius: 14px 14px 0 0;">
                <div class="d-flex align-items-center">
                    <div style="background: #eff6ff; color: #2563eb; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px;" class="mr-3">
                        <i class="fas fa-code"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold text-dark mb-0" id="payloadModalTitle" style="font-size: 16px;">
                            Payload Telemetry Inspection
                        </h5>
                        <small class="text-muted" id="payloadModalSubtitle">Raw JSON data transmitted to ad platform</small>
                    </div>
                </div>
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div id="modal-error-box" class="alert alert-danger d-none mb-3" style="background: #fff1f2; border: 1px solid #fecdd3; color: #be123c; border-radius: 8px; font-size: 12px;"></div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="text-dark small uppercase font-weight-bold mb-0">
                        <i class="fas fa-arrow-up mr-1 text-primary"></i> Request Payload Sent
                    </label>
                    <button type="button" class="btn btn-link btn-xs text-primary p-0" onclick="copyModalContent('modal-request-content')">
                        <i class="fas fa-copy mr-1"></i> Copy Request JSON
                    </button>
                </div>
                <pre id="modal-request-content" class="p-3 rounded mb-4 font-mono small" style="background: #0f172a; color: #38bdf8; border: 1px solid #1e293b; max-height: 220px; overflow-y: auto; white-space: pre-wrap; word-break: break-all;"></pre>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="text-dark small uppercase font-weight-bold mb-0">
                        <i class="fas fa-arrow-down mr-1 text-success"></i> Cloud API Response Received
                    </label>
                    <button type="button" class="btn btn-link btn-xs text-success p-0" onclick="copyModalContent('modal-response-content')">
                        <i class="fas fa-copy mr-1"></i> Copy Response JSON
                    </button>
                </div>
                <pre id="modal-response-content" class="p-3 rounded mb-0 font-mono small" style="background: #0f172a; color: #4ade80; border: 1px solid #1e293b; max-height: 220px; overflow-y: auto; white-space: pre-wrap; word-break: break-all;"></pre>
            </div>
            <div class="modal-footer py-3 px-4" style="border-top: 1px solid #edf0f4; background: #f8fafc; border-radius: 0 0 14px 14px;">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Clear Audit Logs Confirmation Modal -->
<div class="modal fade" id="clearLogsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 1px solid #fecdd3; border-radius: 14px; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);">
            <div class="modal-header py-3 px-4" style="border-bottom: 1px solid #fecdd3; background: #fff1f2; border-radius: 14px 14px 0 0;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle text-danger mr-2" style="font-size: 20px;"></i>
                    <h5 class="modal-title font-weight-bold text-dark mb-0" style="font-size: 16px;">Clear Audit Logs</h5>
                </div>
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.server-tracking.clear-logs') }}">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-dark small mb-3">
                        Are you sure you want to clear tracking audit logs? This action will permanently remove recorded dispatch entries from the database.
                    </p>
                    <div class="form-group mb-0">
                        <label class="text-dark small font-weight-bold">Select Scope to Clear</label>
                        <select name="provider" class="form-control" style="border-color: #cbd5e1;">
                            <option value="">Clear All Channels (Entire Log Table)</option>
                            <option value="meta_capi">Meta CAPI Only</option>
                            <option value="ga4">Google Analytics 4 Only</option>
                            <option value="tiktok">TikTok Events API Only</option>
                            <option value="webhook">Server Webhooks Only</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer py-3 px-4" style="border-top: 1px solid #edf0f4; background: #f8fafc; border-radius: 0 0 14px 14px;">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger font-weight-bold px-3">
                        <i class="fas fa-trash-alt mr-1"></i> Confirm &amp; Purge
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.view-payload-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-log-id');
        const provider = this.getAttribute('data-provider');
        const event = this.getAttribute('data-event');
        const status = this.getAttribute('data-status');
        const http = this.getAttribute('data-http');
        const reqStr = this.getAttribute('data-request');
        const resStr = this.getAttribute('data-response');
        const errStr = this.getAttribute('data-error');

        document.getElementById('payloadModalTitle').innerHTML = `Log #${id}: [${provider}] &rarr; ${event}`;
        document.getElementById('payloadModalSubtitle').innerHTML = `Status: ${status} | HTTP: ${http || 'N/A'}`;

        const errorBox = document.getElementById('modal-error-box');
        if (errStr && errStr.trim() !== '') {
            errorBox.classList.remove('d-none');
            errorBox.innerHTML = `<strong>Error Diagnostic:</strong> ${errStr}`;
        } else {
            errorBox.classList.add('d-none');
        }

        try {
            document.getElementById('modal-request-content').textContent = JSON.stringify(JSON.parse(reqStr), null, 2);
        } catch {
            document.getElementById('modal-request-content').textContent = reqStr || '(Empty Payload)';
        }

        try {
            document.getElementById('modal-response-content').textContent = JSON.stringify(JSON.parse(resStr), null, 2);
        } catch {
            document.getElementById('modal-response-content').textContent = resStr || '(Empty Response)';
        }

        if (typeof $ !== 'undefined' && $('#payloadModal').modal) {
            $('#payloadModal').modal('show');
        }
    });
});

function copyModalContent(elementId) {
    const text = document.getElementById(elementId).textContent;
    navigator.clipboard.writeText(text).then(() => {
        alert('Copied to clipboard!');
    });
}
</script>
@endsection
