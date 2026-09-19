@extends('admin.dashboard.master')

@section('title', 'Server Tracking Audit Logs - ' . config('app.name'))

@section('main_content')
<section class="content-body py-4" style="background: linear-gradient(135deg, #0b0d14 0%, #111827 50%, #0d1322 100%); min-height: 100vh; color: #f1f5f9;">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: rgba(255,255,255,0.07) !important;">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div style="background: linear-gradient(135deg, #06b6d4 0%, #0284c7 100%); color: #070b14; width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; box-shadow: 0 0 24px rgba(6, 182, 212, 0.35);">
                    <i class="fas fa-list-alt"></i>
                </div>
                <div class="ml-3">
                    <h3 class="font-weight-bold text-white mb-0" style="letter-spacing: -0.5px;">
                        Server Tracking Audit Logs &amp; Inspector
                    </h3>
                    <p class="text-muted small mb-0 mt-1">
                        Real-time edge event dispatch history, API response codes &amp; payload telemetry
                    </p>
                </div>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-outline-danger mr-2" data-toggle="modal" data-target="#clearLogsModal" style="border-radius: 8px; padding: 7px 14px;">
                    <i class="fas fa-trash-alt mr-1"></i> Clear Logs
                </button>
                <a href="{{ route('admin.server-tracking.dashboard') }}" class="btn btn-sm btn-outline-light mr-2" style="border-radius: 8px; padding: 7px 14px; border-color: rgba(255,255,255,0.2);">
                    <i class="fas fa-arrow-left mr-1"></i> Dashboard
                </a>
                <a href="{{ route('admin.server-tracking.config') }}" class="btn btn-sm btn-primary" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border: none; border-radius: 8px; padding: 7px 16px; font-weight: 600;">
                    <i class="fas fa-sliders-h mr-1"></i> Config
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.35); color: #34d399; border-radius: 12px;">
                <i class="fas fa-check-circle mr-2" style="font-size: 18px;"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="close text-white ml-auto" data-dismiss="alert" aria-label="Close" style="opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="background: rgba(244, 63, 94, 0.15); border: 1px solid rgba(244, 63, 94, 0.35); color: #fb7185; border-radius: 12px;">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                <button type="button" class="close text-white ml-auto" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Filter and Search Toolbar -->
        <div class="card border-0 mb-4" style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(10px); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <div class="card-body p-3 p-md-4">
                <form method="GET" action="{{ route('admin.server-tracking.logs') }}" class="row align-items-center">
                    <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                        <label class="text-muted small font-weight-bold mb-1">Search Keywords</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #94a3b8;"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" name="search" class="form-control" placeholder="Search event, lead ID, or event ID..." value="{{ request('search') }}" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-3 mb-lg-0">
                        <label class="text-muted small font-weight-bold mb-1">Target Channel</label>
                        <select name="provider" class="form-control" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                            <option value="">All Channels</option>
                            <option value="meta_capi" {{ request('provider') === 'meta_capi' ? 'selected' : '' }}>Meta CAPI</option>
                            <option value="ga4" {{ request('provider') === 'ga4' ? 'selected' : '' }}>Google Analytics 4</option>
                            <option value="tiktok" {{ request('provider') === 'tiktok' ? 'selected' : '' }}>TikTok Events API</option>
                            <option value="webhook" {{ request('provider') === 'webhook' ? 'selected' : '' }}>Server Webhook / sGTM</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-3 mb-lg-0">
                        <label class="text-muted small font-weight-bold mb-1">Delivery Status</label>
                        <select name="status" class="form-control" style="background: #080d1a; border-color: rgba(255,255,255,0.15); color: #fff;">
                            <option value="">All Statuses</option>
                            <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success (2xx Delivered)</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed / Rejected</option>
                            <option value="skipped" {{ request('status') === 'skipped' ? 'selected' : '' }}>Skipped (Disabled)</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12 d-flex align-items-end mt-2 mt-lg-0">
                        <div class="w-100 d-flex gap-2">
                            <button type="submit" class="btn btn-info w-100 mr-2 font-weight-bold" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none; height: 38px;">
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
        <div class="card border-0 shadow-sm" style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(10px); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="color: #cbd5e1;">
                    <thead style="background: rgba(0,0,0,0.35); border-bottom: 1px solid rgba(255,255,255,0.08);">
                        <tr>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;">Log ID</th>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;">Timestamp</th>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;">Channel</th>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;">Event Name</th>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;">Reference</th>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;">Deterministic ID</th>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;">Status</th>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;">HTTP</th>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px; text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
                            <td class="small font-mono text-muted" style="padding: 14px 16px;">#{{ $log->id }}</td>
                            <td class="small text-muted font-mono" style="padding: 14px 16px;">
                                {{ $log->created_at ? $log->created_at->format('Y-m-d H:i:s') : '—' }}
                            </td>
                            <td style="padding: 14px 16px;">
                                @if($log->provider === 'meta_capi')
                                    <span class="badge" style="background: rgba(24, 119, 242, 0.2); color: #60a5fa; border: 1px solid rgba(24, 119, 242, 0.4); font-size: 10px; padding: 4px 8px; border-radius: 6px;">
                                        <i class="fab fa-facebook mr-1"></i> META CAPI
                                    </span>
                                @elseif($log->provider === 'ga4')
                                    <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); font-size: 10px; padding: 4px 8px; border-radius: 6px;">
                                        <i class="fab fa-google mr-1"></i> GA4 PROTOCOL
                                    </span>
                                @elseif($log->provider === 'tiktok')
                                    <span class="badge" style="background: rgba(254, 44, 85, 0.2); color: #fda4af; border: 1px solid rgba(254, 44, 85, 0.4); font-size: 10px; padding: 4px 8px; border-radius: 6px;">
                                        <i class="fab fa-tiktok mr-1"></i> TIKTOK
                                    </span>
                                @else
                                    <span class="badge" style="background: rgba(139, 92, 246, 0.2); color: #c4b5fd; border: 1px solid rgba(139, 92, 246, 0.4); font-size: 10px; padding: 4px 8px; border-radius: 6px;">
                                        <i class="fas fa-network-wired mr-1"></i> WEBHOOK
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 14px 16px;">
                                <strong class="text-white">{{ $log->event_name }}</strong>
                            </td>
                            <td class="small font-mono text-info" style="padding: 14px 16px;">
                                {{ $log->lead_id ?: ($log->order_id ?: '—') }}
                            </td>
                            <td class="small font-mono text-muted" style="padding: 14px 16px;">
                                <span class="d-inline-block text-truncate" style="max-width: 130px;" title="{{ $log->event_id }}">
                                    {{ $log->event_id ?: '—' }}
                                </span>
                            </td>
                            <td style="padding: 14px 16px;">
                                @if($log->status === 'success')
                                    <span class="badge badge-pill badge-success" style="font-size: 10px; padding: 4px 10px;">
                                        <i class="fas fa-check-circle mr-1"></i> DELIVERED
                                    </span>
                                @elseif($log->status === 'failed')
                                    <span class="badge badge-pill badge-danger" style="font-size: 10px; padding: 4px 10px;">
                                        <i class="fas fa-times-circle mr-1"></i> FAILED
                                    </span>
                                @else
                                    <span class="badge badge-pill badge-secondary" style="font-size: 10px; padding: 4px 10px;">
                                        <i class="fas fa-minus-circle mr-1"></i> SKIPPED
                                    </span>
                                @endif
                            </td>
                            <td class="font-mono small" style="padding: 14px 16px;">
                                <span class="{{ ($log->http_code >= 200 && $log->http_code < 300) ? 'text-success font-weight-bold' : ($log->http_code ? 'text-danger font-weight-bold' : 'text-muted') }}">
                                    {{ $log->http_code ?: '—' }}
                                </span>
                            </td>
                            <td class="text-right" style="padding: 14px 16px;">
                                <button type="button" class="btn btn-xs btn-outline-info view-payload-btn" 
                                    data-log-id="{{ $log->id }}"
                                    data-provider="{{ strtoupper($log->provider) }}"
                                    data-event="{{ $log->event_name }}"
                                    data-status="{{ strtoupper($log->status) }}"
                                    data-http="{{ $log->http_code }}"
                                    data-ip="{{ $log->ip_address }}"
                                    data-request="{{ json_encode($log->request_payload) }}"
                                    data-response="{{ json_encode($log->response_payload) }}"
                                    data-error="{{ $log->error_message }}"
                                    style="border-radius: 6px; font-size: 11px; padding: 4px 10px;">
                                    <i class="fas fa-code mr-1"></i> Inspect
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <div class="mb-2" style="font-size: 32px;"><i class="fas fa-search text-muted"></i></div>
                                <h6 class="text-white">No server tracking logs matching your criteria</h6>
                                <p class="small text-muted mb-0">Try widening your search terms or clearing the filter.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($logs, 'hasPages') && $logs->hasPages())
            <div class="card-footer d-flex justify-content-center py-3" style="background: transparent; border-top: 1px solid rgba(255,255,255,0.08);">
                {{ $logs->links() }}
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Payload Telemetry Inspection Modal -->
<div class="modal fade" id="payloadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="background: #0d121f; border: 1px solid rgba(0,212,170,0.35); border-radius: 18px; box-shadow: 0 20px 50px rgba(0,0,0,0.6);">
            <div class="modal-header py-3 px-4" style="border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="d-flex align-items-center">
                    <div style="background: linear-gradient(135deg, #0284c7 0%, #00d4aa 100%); color: #070b14; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px;" class="mr-3">
                        <i class="fas fa-code"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-white font-weight-bold mb-0" id="payloadModalTitle">
                            Payload Telemetry Inspection
                        </h5>
                        <small class="text-muted" id="payloadModalSubtitle">Raw JSON data transmitted to ad platform</small>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div id="modal-error-box" class="alert alert-danger d-none mb-3" style="background: rgba(244, 63, 94, 0.15); border: 1px solid rgba(244, 63, 94, 0.35); color: #fb7185; border-radius: 10px; font-size: 12px;"></div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="text-white small uppercase font-weight-bold mb-0">
                        <i class="fas fa-arrow-up mr-1 text-info"></i> Request Payload Sent
                    </label>
                    <button type="button" class="btn btn-link btn-xs text-info p-0" onclick="copyModalContent('modal-request-content')">
                        <i class="fas fa-copy mr-1"></i> Copy Request JSON
                    </button>
                </div>
                <pre id="modal-request-content" class="p-3 rounded mb-4 text-info font-mono small" style="background: #060911; border: 1px solid rgba(255,255,255,0.08); max-height: 220px; overflow-y: auto; white-space: pre-wrap; word-break: break-all;"></pre>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="text-white small uppercase font-weight-bold mb-0">
                        <i class="fas fa-arrow-down mr-1 text-success"></i> Cloud API Response Received
                    </label>
                    <button type="button" class="btn btn-link btn-xs text-success p-0" onclick="copyModalContent('modal-response-content')">
                        <i class="fas fa-copy mr-1"></i> Copy Response JSON
                    </button>
                </div>
                <pre id="modal-response-content" class="p-3 rounded mb-0 text-success font-mono small" style="background: #060911; border: 1px solid rgba(255,255,255,0.08); max-height: 220px; overflow-y: auto; white-space: pre-wrap; word-break: break-all;"></pre>
            </div>
            <div class="modal-footer py-3 px-4" style="border-top: 1px solid rgba(255, 255, 255, 0.08);">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Clear Audit Logs Confirmation Modal -->
<div class="modal fade" id="clearLogsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background: #0d121f; border: 1px solid rgba(244, 63, 94, 0.35); border-radius: 18px;">
            <div class="modal-header py-3 px-4" style="border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle text-danger mr-2" style="font-size: 20px;"></i>
                    <h5 class="modal-title text-white font-weight-bold mb-0">Clear Audit Logs</h5>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.server-tracking.clear-logs') }}">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-white small mb-3">
                        Are you sure you want to clear tracking audit logs? This action will permanently remove recorded dispatch entries from the database.
                    </p>
                    <div class="form-group mb-0">
                        <label class="text-white small font-weight-bold">Select Scope to Clear</label>
                        <select name="provider" class="form-control" style="background: #060911; border-color: rgba(255,255,255,0.15); color: #fff;">
                            <option value="">Clear All Channels (Entire Log Table)</option>
                            <option value="meta_capi">Meta CAPI Only</option>
                            <option value="ga4">Google Analytics 4 Only</option>
                            <option value="tiktok">TikTok Events API Only</option>
                            <option value="webhook">Server Webhooks Only</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer py-3 px-4" style="border-top: 1px solid rgba(255, 255, 255, 0.08);">
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
