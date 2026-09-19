@extends('admin.dashboard.master')

@section('title', 'Server-Side Tracking & CAPI Dashboard - ' . config('app.name'))

@section('main_content')
<div class="dashboard-header mb-4">
    <div class="dashboard-header-left">
        <div class="dashboard-header-icon" style="background: linear-gradient(135deg, #00d4aa 0%, #38bdf8 100%); color: #070b14; width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fa fa-satellite-dish"></i>
        </div>
        <div class="dashboard-header-content ml-3">
            <h1 class="h3 font-weight-bold mb-1" style="color: #ffffff;">Server-Side Tracking &amp; CAPI</h1>
            <p class="text-muted small mb-0">Google Analytics 4 Measurement Protocol • Meta Conversions API • TikTok Events API</p>
        </div>
    </div>
    <div class="dashboard-header-right d-flex gap-2">
        <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-outline-info btn-sm mr-2">
            <i class="fa fa-list mr-1"></i> Audit Logs
        </a>
        <a href="{{ route('admin.server-tracking.config') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-cog mr-1"></i> Tracking Config
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success d-flex align-items-center mb-4" style="background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #10b981;">
    <i class="fa fa-check-circle mr-2"></i>
    <div>{{ session('success') }}</div>
</div>
@endif

<!-- Provider Connection Status Cards -->
<div class="row mb-4">
    <!-- Meta CAPI Card -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card h-100" style="background: #0f1523; border: 1px solid {{ !empty($metaConfig['enabled']) ? 'rgba(0,212,170,0.35)' : 'rgba(255,255,255,0.08)' }}; border-radius: 16px;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge {{ !empty($metaConfig['enabled']) ? 'badge-success' : 'badge-secondary' }}" style="font-size: 10px; padding: 4px 8px;">
                        {{ !empty($metaConfig['enabled']) ? '● Active' : '○ Disabled' }}
                    </span>
                    <i class="fab fa-facebook text-primary" style="font-size: 22px;"></i>
                </div>
                <h6 class="font-weight-bold text-white mb-1">Meta Conversions API</h6>
                <div class="small text-muted mb-2 font-mono">Pixel: {{ ($metaConfig['pixel_id'] ?? '') ?: 'Not set' }}</div>
                <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-white-10">
                    <span class="small text-muted">Sent: <strong class="text-white">{{ $metaCount }}</strong></span>
                    <button class="btn btn-sm btn-outline-success test-btn" data-provider="meta_capi" style="font-size: 11px; padding: 2px 8px;">
                        <i class="fa fa-paper-plane mr-1"></i> Test
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- GA4 Card -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card h-100" style="background: #0f1523; border: 1px solid {{ !empty($ga4Config['enabled']) ? 'rgba(56,189,248,0.35)' : 'rgba(255,255,255,0.08)' }}; border-radius: 16px;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge {{ !empty($ga4Config['enabled']) ? 'badge-info' : 'badge-secondary' }}" style="font-size: 10px; padding: 4px 8px;">
                        {{ !empty($ga4Config['enabled']) ? '● Active' : '○ Disabled' }}
                    </span>
                    <i class="fab fa-google text-warning" style="font-size: 22px;"></i>
                </div>
                <h6 class="font-weight-bold text-white mb-1">GA4 Measurement Protocol</h6>
                <div class="small text-muted mb-2 font-mono">{{ ($ga4Config['measurement_id'] ?? '') ?: 'ID Not set' }}</div>
                <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-white-10">
                    <span class="small text-muted">Sent: <strong class="text-white">{{ $ga4Count }}</strong></span>
                    <button class="btn btn-sm btn-outline-info test-btn" data-provider="ga4" style="font-size: 11px; padding: 2px 8px;">
                        <i class="fa fa-paper-plane mr-1"></i> Test
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- TikTok Card -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card h-100" style="background: #0f1523; border: 1px solid {{ !empty($tiktokConfig['enabled']) ? 'rgba(244,63,94,0.35)' : 'rgba(255,255,255,0.08)' }}; border-radius: 16px;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge {{ !empty($tiktokConfig['enabled']) ? 'badge-danger' : 'badge-secondary' }}" style="font-size: 10px; padding: 4px 8px;">
                        {{ !empty($tiktokConfig['enabled']) ? '● Active' : '○ Disabled' }}
                    </span>
                    <i class="fab fa-tiktok text-light" style="font-size: 20px;"></i>
                </div>
                <h6 class="font-weight-bold text-white mb-1">TikTok Events API</h6>
                <div class="small text-muted mb-2 font-mono">{{ ($tiktokConfig['pixel_code'] ?? '') ?: 'Code Not set' }}</div>
                <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-white-10">
                    <span class="small text-muted">Sent: <strong class="text-white">{{ $tiktokCount }}</strong></span>
                    <button class="btn btn-sm btn-outline-light test-btn" data-provider="tiktok" style="font-size: 11px; padding: 2px 8px;">
                        <i class="fa fa-paper-plane mr-1"></i> Test
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Webhook Card -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card h-100" style="background: #0f1523; border: 1px solid {{ !empty($webhookConfig['enabled']) ? 'rgba(139,92,246,0.35)' : 'rgba(255,255,255,0.08)' }}; border-radius: 16px;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge {{ !empty($webhookConfig['enabled']) ? 'badge-primary' : 'badge-secondary' }}" style="font-size: 10px; padding: 4px 8px;">
                        {{ !empty($webhookConfig['enabled']) ? '● Active' : '○ Disabled' }}
                    </span>
                    <i class="fa fa-network-wired text-info" style="font-size: 20px;"></i>
                </div>
                <h6 class="font-weight-bold text-white mb-1">Server Webhook / sGTM</h6>
                <div class="small text-muted mb-2 truncate" style="max-width: 180px;">{{ ($webhookConfig['url'] ?? '') ?: 'No URL' }}</div>
                <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-white-10">
                    <span class="small text-muted">Sent: <strong class="text-white">{{ $webhookCount }}</strong></span>
                    <button class="btn btn-sm btn-outline-primary test-btn" data-provider="webhook" style="font-size: 11px; padding: 2px 8px;">
                        <i class="fa fa-paper-plane mr-1"></i> Test
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Overall Metrics Row -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card p-3 text-center" style="background: #0f1523; border: 1px solid rgba(255,255,255,0.08); border-radius: 16px;">
            <span class="text-muted small uppercase font-weight-bold">Total Server Dispatches</span>
            <h2 class="font-weight-bold text-white mt-1 mb-0">{{ number_format($totalEvents) }}</h2>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card p-3 text-center" style="background: #0f1523; border: 1px solid rgba(16,185,129,0.25); border-radius: 16px;">
            <span class="text-muted small uppercase font-weight-bold text-success">Successful Deliveries</span>
            <h2 class="font-weight-bold text-success mt-1 mb-0">{{ number_format($totalSuccess) }}</h2>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card p-3 text-center" style="background: #0f1523; border: 1px solid rgba(244,63,94,0.25); border-radius: 16px;">
            <span class="text-muted small uppercase font-weight-bold text-danger">Failed / Dropped</span>
            <h2 class="font-weight-bold text-danger mt-1 mb-0">{{ number_format($totalFailed) }}</h2>
        </div>
    </div>
</div>

<!-- Live Test Result Output Box -->
<div id="test-output-container" class="card mb-4 d-none" style="background: #080d1a; border: 1px solid rgba(0,212,170,0.4); border-radius: 16px;">
    <div class="card-header d-flex justify-content-between align-items-center" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.08);">
        <span class="font-weight-bold text-white"><i class="fa fa-terminal mr-2 text-info"></i>Live Test Dispatch Response</span>
        <button type="button" class="btn btn-sm btn-link text-muted p-0" onclick="document.getElementById('test-output-container').classList.add('d-none');">
            <i class="fa fa-times"></i>
        </button>
    </div>
    <div class="card-body">
        <pre id="test-output-content" class="mb-0 text-success font-mono small" style="white-space: pre-wrap; word-break: break-all; max-height: 250px; overflow-y: auto;"></pre>
    </div>
</div>

<!-- Recent Event Stream -->
<div class="card" style="background: #0f1523; border: 1px solid rgba(255,255,255,0.08); border-radius: 16px;">
    <div class="card-header d-flex justify-content-between align-items-center" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.08);">
        <h5 class="card-title text-white font-weight-bold mb-0">
            <i class="fa fa-stream mr-2 text-info"></i>Recent Server Tracking Activity
        </h5>
        <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-sm btn-outline-secondary" style="font-size: 11px;">
            View Full Logs &rarr;
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="color: #cbd5e1;">
            <thead style="background: rgba(0,0,0,0.3); border-bottom: 1px solid rgba(255,255,255,0.08);">
                <tr>
                    <th style="font-size: 11px; text-transform: uppercase;">Time</th>
                    <th style="font-size: 11px; text-transform: uppercase;">Provider</th>
                    <th style="font-size: 11px; text-transform: uppercase;">Event</th>
                    <th style="font-size: 11px; text-transform: uppercase;">Lead / Order</th>
                    <th style="font-size: 11px; text-transform: uppercase;">Status</th>
                    <th style="font-size: 11px; text-transform: uppercase;">HTTP</th>
                    <th style="font-size: 11px; text-transform: uppercase;">Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLogs as $log)
                <tr>
                    <td class="small text-muted font-mono">{{ $log->created_at ? $log->created_at->format('M d, H:i:s') : 'N/A' }}</td>
                    <td>
                        <span class="badge badge-dark text-uppercase font-mono" style="font-size: 10px; border: 1px solid rgba(255,255,255,0.15);">
                            {{ $log->provider }}
                        </span>
                    </td>
                    <td><strong class="text-white">{{ $log->event_name }}</strong></td>
                    <td class="small font-mono text-info">{{ $log->lead_id ?: ($log->order_id ?: '—') }}</td>
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
                    <td class="small text-muted truncate" style="max-width: 250px;">
                        {{ $log->error_message ?: 'Delivered' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        No server tracking dispatches recorded yet. Use the <strong>Test</strong> buttons above to trigger your first conversion!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
document.querySelectorAll('.test-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const provider = this.getAttribute('data-provider');
        const origHtml = this.innerHTML;
        this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Testing...';
        this.disabled = true;

        fetch('{{ route("admin.server-tracking.test") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ provider: provider, event_name: 'Lead' })
        })
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('test-output-container');
            const content = document.getElementById('test-output-content');
            container.classList.remove('d-none');
            content.textContent = JSON.stringify(data, null, 2);
            content.scrollIntoView({ behavior: 'smooth' });
        })
        .catch(err => {
            alert('Error running test dispatch: ' + err);
        })
        .finally(() => {
            this.innerHTML = origHtml;
            this.disabled = false;
        });
    });
});
</script>
@endsection
