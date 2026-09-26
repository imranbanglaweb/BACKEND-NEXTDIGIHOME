@extends('admin.dashboard.master')

@section('title', 'Server Tracking Audit Logs - ' . config('app.name'))

@section('main_content')
@include('admin.partials.premium-ui')

<style>
    .channel-meta { background: #eff6ff !important; color: #1d4ed8 !important; border: 1.5px solid #bfdbfe !important; font-size: 13px !important; font-weight: 700 !important; padding: 6px 12px !important; border-radius: 8px !important; }
    .channel-ga4 { background: #fffbeb !important; color: #b45309 !important; border: 1.5px solid #fde68a !important; font-size: 13px !important; font-weight: 700 !important; padding: 6px 12px !important; border-radius: 8px !important; }
    .channel-tiktok { background: #fff1f2 !important; color: #be123c !important; border: 1.5px solid #fecdd3 !important; font-size: 13px !important; font-weight: 700 !important; padding: 6px 12px !important; border-radius: 8px !important; }
    .channel-webhook { background: #f5f3ff !important; color: #6d28d9 !important; border: 1.5px solid #ddd6fe !important; font-size: 13px !important; font-weight: 700 !important; padding: 6px 12px !important; border-radius: 8px !important; }

    .filter-card label {
        font-size: 14px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        margin-bottom: 6px;
    }
    .filter-card .form-control {
        font-size: 14.5px !important;
        color: #0f172a !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 9px !important;
        height: 46px !important;
        font-weight: 500;
    }
    .filter-card .form-control:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.18) !important;
    }
    .status-badge {
        font-size: 13px !important;
        font-weight: 700 !important;
        padding: 6px 12px !important;
        border-radius: 8px !important;
        display: inline-flex;
        align-items: center;
    }
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
                <a href="{{ route('admin.server-tracking.export', ['format' => 'csv']) }}" class="btn btn-outline-light mr-2" title="Export Audit Logs as CSV">
                    <i class="fas fa-file-csv mr-1"></i> Export CSV
                </a>
                <a href="{{ route('admin.server-tracking.export', ['format' => 'json']) }}" class="btn btn-outline-light mr-2" title="Export Audit Logs as JSON">
                    <i class="fas fa-file-code mr-1"></i> Export JSON
                </a>
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
        <div class="card border-0 mb-4 filter-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);">
            <div class="card-body p-3 p-md-4">
                <form method="GET" action="{{ route('admin.server-tracking.logs') }}" class="row align-items-center">
                    <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                        <label class="mb-1">Search Keywords</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white" style="border: 1.5px solid #cbd5e1; border-right: none; color: #64748b; font-size: 15px;"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" name="search" class="form-control" placeholder="Search event, lead ID, or event ID..." value="{{ request('search') }}" style="border-left: none;">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-3 mb-lg-0">
                        <label class="mb-1">Target Channel</label>
                        <select name="provider" class="form-control">
                            <option value="">All Channels</option>
                            <option value="meta_capi" {{ request('provider') === 'meta_capi' ? 'selected' : '' }}>Meta CAPI</option>
                            <option value="ga4" {{ request('provider') === 'ga4' ? 'selected' : '' }}>Google Analytics 4</option>
                            <option value="webhook" {{ request('provider') === 'webhook' ? 'selected' : '' }}>Server Webhook / sGTM</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 mb-3 mb-lg-0">
                        <label class="mb-1">Delivery Status</label>
                        <select name="status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success (2xx Delivered)</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed / Rejected</option>
                            <option value="skipped" {{ request('status') === 'skipped' ? 'selected' : '' }}>Skipped (Disabled)</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12 d-flex align-items-end mt-2 mt-lg-0">
                        <div class="w-100 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 mr-2 font-weight-bold" style="height: 46px; font-size: 14.5px; border-radius: 9px;">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button>
                            @if(request('search') || request('provider') || request('status'))
                            <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" style="height: 46px; width: 46px; border-radius: 9px; font-size: 15px; flex-shrink: 0;" title="Reset filters">
                                <i class="fas fa-undo"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Logs Table Card -->
        <div class="card border-0 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05); overflow: hidden;">
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
                            <td class="font-mono text-muted" style="font-size: 14px; font-weight: 600;">#{{ $log->id }}</td>
                            <td class="font-mono" style="font-size: 14px; color: #475569; font-weight: 500;">
                                {{ $log->created_at ? $log->created_at->format('Y-m-d H:i:s') : '—' }}
                            </td>
                            <td>
                                @if($log->provider === 'meta_capi')
                                    <span class="badge channel-meta">
                                        <i class="fab fa-facebook mr-1"></i> META CAPI
                                    </span>
                                @elseif($log->provider === 'ga4')
                                    <span class="badge channel-ga4">
                                        <i class="fab fa-google mr-1"></i> GA4 PROTOCOL
                                    </span>
                                @elseif($log->provider === 'tiktok')
                                    <span class="badge channel-tiktok">
                                        <i class="fab fa-tiktok mr-1"></i> TIKTOK
                                    </span>
                                @else
                                    <span class="badge channel-webhook">
                                        <i class="fas fa-network-wired mr-1"></i> WEBHOOK
                                    </span>
                                @endif
                            </td>
                            <td>
                                <strong class="text-dark" style="font-size: 15px; font-weight: 700;">{{ $log->event_name }}</strong>
                            </td>
                            <td class="font-mono text-primary font-weight-bold" style="font-size: 14.5px;">
                                {{ $log->lead_id ?: ($log->order_id ?: '—') }}
                            </td>
                            <td class="font-mono text-muted" style="font-size: 13.5px; font-weight: 500;">
                                <span class="d-inline-block text-truncate" style="max-width: 140px;" title="{{ $log->event_id }}">
                                    {{ $log->event_id ?: '—' }}
                                </span>
                            </td>
                            <td>
                                @if($log->status === 'success')
                                    <span class="badge badge-success status-badge">
                                        <i class="fas fa-check-circle mr-1"></i> DELIVERED
                                    </span>
                                @elseif($log->status === 'failed')
                                    <span class="badge badge-danger status-badge">
                                        <i class="fas fa-times-circle mr-1"></i> FAILED
                                    </span>
                                @else
                                    <span class="badge badge-secondary status-badge">
                                        <i class="fas fa-minus-circle mr-1"></i> SKIPPED
                                    </span>
                                @endif
                            </td>
                            <td class="font-mono" style="font-size: 14.5px;">
                                <span class="{{ ($log->http_code >= 200 && $log->http_code < 300) ? 'text-success font-weight-bold' : ($log->http_code ? 'text-danger font-weight-bold' : 'text-muted') }}">
                                    {{ $log->http_code ?: '—' }}
                                </span>
                            </td>
                            <td class="text-right">
                                <button type="button" class="btn btn-outline-primary view-payload-btn" 
                                    data-log-id="{{ $log->id }}"
                                    data-provider="{{ strtoupper($log->provider ?? 'API') }}"
                                    data-event="{{ $log->event_name ?? 'Event' }}"
                                    data-status="{{ strtoupper($log->status ?? 'UNKNOWN') }}"
                                    data-http="{{ $log->http_code ?: '—' }}"
                                    data-ip="{{ $log->ip_address ?? 'N/A' }}"
                                    data-request="{{ json_encode($log->request_payload ?? []) }}"
                                    data-response="{{ json_encode($log->response_payload ?? []) }}"
                                    data-error="{{ $log->error_message ?? '' }}"
                                    onclick="openLogPayloadModal(this, event); return false;"
                                    style="border-radius: 8px; font-size: 13.5px; padding: 6px 14px; font-weight: 700; cursor: pointer;">
                                    <i class="fas fa-code mr-1"></i> Inspect
                                </button>
                                <script type="application/json" id="log-page-req-{{ $log->id }}">{!! json_encode($log->request_payload ?? [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
                                <script type="application/json" id="log-page-res-{{ $log->id }}">{!! json_encode($log->response_payload ?? [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <div class="mb-2" style="font-size: 36px; color: #94a3b8;"><i class="fas fa-search"></i></div>
                                <h6 class="text-dark font-weight-bold" style="font-size: 16px;">No server tracking logs matching your criteria</h6>
                                <p class="text-muted mb-0" style="font-size: 14px;">Try widening your search terms or clearing active filters.</p>
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
        <div class="modal-content" style="border: 1px solid #cbd5e1; border-radius: 16px; box-shadow: 0 25px 50px rgba(15, 23, 42, 0.18); overflow: hidden;">
            <div class="modal-header py-3 px-4" style="border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                <div class="d-flex align-items-center">
                    <div style="background: #eff6ff; color: #2563eb; width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;" class="mr-3">
                        <i class="fas fa-code"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold text-dark mb-0" id="payloadModalTitle" style="font-size: 18px; letter-spacing: -0.01em;">
                            Payload Telemetry Inspection
                        </h5>
                        <div class="text-muted" id="payloadModalSubtitle" style="font-size: 14px; font-weight: 500;">Raw JSON data transmitted to ad platform</div>
                    </div>
                </div>
                <button type="button" class="close text-muted" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" onclick="closeLogPayloadModal(); return false;" style="font-size: 22px; cursor: pointer;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div id="modal-error-box" class="alert alert-danger d-none mb-3 font-weight-500" style="background: #fff1f2; border: 1.5px solid #fecdd3; color: #be123c; border-radius: 10px; font-size: 13.5px;"></div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="text-dark font-weight-bold mb-0" style="font-size: 14px; text-transform: uppercase; letter-spacing: 0.04em;">
                        <i class="fas fa-arrow-up mr-1 text-primary"></i> Request Payload Sent
                    </label>
                    <button type="button" class="btn btn-link text-primary p-0 font-weight-bold" style="font-size: 13.5px;" onclick="copyModalContent('modal-request-content')">
                        <i class="fas fa-copy mr-1"></i> Copy Request JSON
                    </button>
                </div>
                <pre id="modal-request-content" class="p-3 mb-4 font-mono" style="background: #0f172a; color: #38bdf8; border: 1px solid #1e293b; border-radius: 12px; font-size: 14px; line-height: 1.6; max-height: 260px; overflow-y: auto; white-space: pre-wrap; word-break: break-all;"></pre>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="text-dark font-weight-bold mb-0" style="font-size: 14px; text-transform: uppercase; letter-spacing: 0.04em;">
                        <i class="fas fa-arrow-down mr-1 text-success"></i> Cloud API Response Received
                    </label>
                    <button type="button" class="btn btn-link text-success p-0 font-weight-bold" style="font-size: 13.5px;" onclick="copyModalContent('modal-response-content')">
                        <i class="fas fa-copy mr-1"></i> Copy Response JSON
                    </button>
                </div>
                <pre id="modal-response-content" class="p-3 mb-0 font-mono" style="background: #0f172a; color: #4ade80; border: 1px solid #1e293b; border-radius: 12px; font-size: 14px; line-height: 1.6; max-height: 260px; overflow-y: auto; white-space: pre-wrap; word-break: break-all;"></pre>
            </div>
            <div class="modal-footer py-3 px-4" style="border-top: 1px solid #e2e8f0; background: #f8fafc;">
                <button type="button" class="btn btn-secondary font-weight-bold px-4" data-dismiss="modal" data-bs-dismiss="modal" onclick="closeLogPayloadModal(); return false;" style="border-radius: 9px; font-size: 14.5px; cursor: pointer;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Clear Audit Logs Confirmation Modal -->
<div class="modal fade" id="clearLogsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 1px solid #fecdd3; border-radius: 16px; box-shadow: 0 25px 50px rgba(15, 23, 42, 0.18); overflow: hidden;">
            <div class="modal-header py-3 px-4" style="border-bottom: 1px solid #fecdd3; background: #fff1f2;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle text-danger mr-2" style="font-size: 22px;"></i>
                    <h5 class="modal-title font-weight-bold text-dark mb-0" style="font-size: 18px;">Clear Audit Logs</h5>
                </div>
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close" style="font-size: 22px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.server-tracking.clear-logs') }}">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-dark mb-3" style="font-size: 14.5px; line-height: 1.6; color: #334155;">
                        Are you sure you want to clear tracking audit logs? This action will permanently remove recorded dispatch entries from the database.
                    </p>
                    <div class="form-group mb-0">
                        <label class="text-dark font-weight-bold mb-2" style="font-size: 14.5px;">Select Scope to Clear</label>
                        <select name="provider" class="form-control" style="border: 1.5px solid #cbd5e1; border-radius: 9px; height: 46px; font-size: 14.5px; font-weight: 500;">
                            <option value="">Clear All Channels (Entire Log Table)</option>
                            <option value="meta_capi">Meta CAPI Only</option>
                            <option value="ga4">Google Analytics 4 Only</option>
                            <option value="webhook">Server Webhooks Only</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer py-3 px-4" style="border-top: 1px solid #edf0f4; background: #f8fafc;">
                    <button type="button" class="btn btn-outline-secondary font-weight-bold px-3" data-dismiss="modal" style="border-radius: 9px; font-size: 14.5px;">Cancel</button>
                    <button type="submit" class="btn btn-danger font-weight-bold px-4" style="border-radius: 9px; font-size: 14.5px; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);">
                        <i class="fas fa-trash-alt mr-1"></i> Confirm &amp; Purge
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function ensureLogModalOnBody() {
    const modal = document.getElementById('payloadModal');
    if (modal && modal.parentNode !== document.body) {
        document.body.appendChild(modal);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', ensureLogModalOnBody);
} else {
    ensureLogModalOnBody();
}

function openLogPayloadModal(btn, e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    if (!btn) return;
    ensureLogModalOnBody();

    const id = btn.getAttribute('data-log-id') || '';
    const provider = btn.getAttribute('data-provider') || 'API';
    const event = btn.getAttribute('data-event') || 'Event';
    const status = btn.getAttribute('data-status') || 'UNKNOWN';
    const http = btn.getAttribute('data-http') || 'N/A';
    const errStr = btn.getAttribute('data-error') || '';

    let reqData = null;
    let resData = null;

    const reqScript = document.getElementById('log-page-req-' + id);
    if (reqScript && reqScript.textContent.trim()) {
        try { reqData = JSON.parse(reqScript.textContent); } catch (err) {}
    }
    if (!reqData) {
        const rawReq = btn.getAttribute('data-request');
        if (rawReq) {
            try { reqData = JSON.parse(rawReq); } catch (err) { reqData = rawReq; }
        }
    }

    const resScript = document.getElementById('log-page-res-' + id);
    if (resScript && resScript.textContent.trim()) {
        try { resData = JSON.parse(resScript.textContent); } catch (err) {}
    }
    if (!resData) {
        const rawRes = btn.getAttribute('data-response');
        if (rawRes) {
            try { resData = JSON.parse(rawRes); } catch (err) { resData = rawRes; }
        }
    }

    const titleEl = document.getElementById('payloadModalTitle');
    if (titleEl) titleEl.innerHTML = `Log #${id}: [${provider}] &rarr; ${event}`;

    const subEl = document.getElementById('payloadModalSubtitle');
    if (subEl) subEl.innerHTML = `Status: ${status} | HTTP: ${http}`;

    const errorBox = document.getElementById('modal-error-box');
    if (errorBox) {
        if (errStr && errStr.trim() !== '') {
            errorBox.classList.remove('d-none');
            errorBox.style.display = 'block';
            errorBox.innerHTML = `<strong>Error Diagnostic:</strong> ${errStr}`;
        } else {
            errorBox.classList.add('d-none');
            errorBox.style.display = 'none';
        }
    }

    const reqContentEl = document.getElementById('modal-request-content');
    if (reqContentEl) {
        if (reqData && typeof reqData === 'object' && Object.keys(reqData).length > 0) {
            reqContentEl.textContent = JSON.stringify(reqData, null, 2);
        } else if (typeof reqData === 'string' && reqData.trim() && reqData !== '{}' && reqData !== '[]') {
            try {
                reqContentEl.textContent = JSON.stringify(JSON.parse(reqData), null, 2);
            } catch {
                reqContentEl.textContent = reqData;
            }
        } else {
            reqContentEl.textContent = '(Empty Request Payload)';
        }
    }

    const resContentEl = document.getElementById('modal-response-content');
    if (resContentEl) {
        if (resData && typeof resData === 'object' && Object.keys(resData).length > 0) {
            resContentEl.textContent = JSON.stringify(resData, null, 2);
        } else if (typeof resData === 'string' && resData.trim() && resData !== '[]' && resData !== '{}') {
            try {
                resContentEl.textContent = JSON.stringify(JSON.parse(resData), null, 2);
            } catch {
                resContentEl.textContent = resData;
            }
        } else if (errStr && errStr.trim()) {
            resContentEl.textContent = errStr;
        } else {
            resContentEl.textContent = '(Empty Response)';
        }
    }

    const modalEl = document.getElementById('payloadModal');
    if (modalEl) {
        modalEl.classList.add('show', 'in');
        modalEl.style.display = 'block';
        modalEl.style.zIndex = '10550';
        document.body.classList.add('modal-open');

        if (typeof $ !== 'undefined' && $('#payloadModal').modal) {
            try {
                $('#payloadModal').modal({
                    backdrop: true,
                    keyboard: true,
                    show: true
                });
            } catch (err) {}
        } else if (window.bootstrap && window.bootstrap.Modal) {
            try {
                bootstrap.Modal.getOrCreateInstance(modalEl, { backdrop: true, keyboard: true }).show();
            } catch (err) {}
        }

        let backdrop = document.querySelector('.modal-backdrop');
        if (!backdrop) {
            backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade in show';
            backdrop.style.cssText = 'position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: #000; opacity: 0.5; z-index: 10500;';
            backdrop.setAttribute('id', 'logCustomBackdrop');
            backdrop.onclick = closeLogPayloadModal;
            document.body.appendChild(backdrop);
        } else {
            backdrop.style.zIndex = '10500';
            backdrop.onclick = closeLogPayloadModal;
        }
    }
}

function closeLogPayloadModal() {
    const modalEl = document.getElementById('payloadModal');
    if (typeof $ !== 'undefined' && $('#payloadModal').modal) {
        try { $('#payloadModal').modal('hide'); } catch (e) {}
    }
    if (window.bootstrap && window.bootstrap.Modal) {
        try {
            const inst = bootstrap.Modal.getInstance(modalEl);
            if (inst) inst.hide();
        } catch (e) {}
    }
    if (modalEl) {
        modalEl.classList.remove('show', 'in');
        modalEl.style.display = 'none';
    }
    const customBackdrop = document.getElementById('logCustomBackdrop');
    if (customBackdrop) customBackdrop.remove();

    setTimeout(function() {
        const anyModal = document.querySelector('.modal.show:not(#payloadModal), .modal.in:not(#payloadModal)');
        if (!anyModal) {
            document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }
    }, 150);
}

document.addEventListener('click', function(e) {
    const btn = e.target.closest('.view-payload-btn');
    if (btn) {
        e.preventDefault();
        openLogPayloadModal(btn, e);
        return;
    }

    const modal = document.getElementById('payloadModal');
    if (modal && (modal.classList.contains('show') || modal.classList.contains('in') || modal.style.display === 'block')) {
        if (e.target === modal || e.target.closest('[data-dismiss="modal"]')) {
            closeLogPayloadModal();
        }
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' || e.keyCode === 27) {
        const modal = document.getElementById('payloadModal');
        if (modal && (modal.classList.contains('show') || modal.classList.contains('in') || modal.style.display === 'block')) {
            closeLogPayloadModal();
        }
    }
});

function copyModalContent(elementId) {
    const text = document.getElementById(elementId).textContent;
    navigator.clipboard.writeText(text).then(() => {
        alert('Copied to clipboard!');
    });
}
</script>
@endsection
