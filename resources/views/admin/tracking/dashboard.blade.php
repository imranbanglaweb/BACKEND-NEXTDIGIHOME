@extends('admin.dashboard.master')

@section('title', 'Server-Side Tracking & CAPI Console - ' . config('app.name'))

@section('main_content')
@include('admin.partials.premium-ui')

<style>
    .tracking-pipeline-step {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px;
        height: 100%;
        transition: all 0.2s ease;
        position: relative;
    }
    .tracking-pipeline-step:hover {
        border-color: #cbd5e1;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
        transform: translateY(-2px);
    }
    .tracking-pipeline-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-bottom: 12px;
    }
    .provider-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        padding: 22px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.2s ease;
    }
    .provider-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        transform: translateY(-2px);
    }
    .provider-icon-badge {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
    .copy-pill-btn {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569;
        border-radius: 6px;
        padding: 2px 8px;
        font-size: 11px;
        font-family: monospace;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .copy-pill-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .status-badge-active {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .status-badge-disabled {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
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
                    <i class="fas fa-satellite-dish mr-1"></i> Cloud Conversion Architecture
                </div>
                <h2>Server-Side Tracking &amp; CAPI Console</h2>
                <p>Real-time edge deduplication, SHA-256 privacy normalization &amp; direct cloud conversion dispatch</p>
            </div>
            <div class="premium-actions">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#quickTestModal">
                    <i class="fas fa-bolt"></i> Live Test Dispatch
                </button>
                <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-outline-light">
                    <i class="fas fa-list"></i> Audit Logs
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

        <!-- Navigation Tabs Bar -->
        <div class="premium-nav">
            <a href="{{ route('admin.server-tracking.dashboard') }}" class="active">
                <i class="fas fa-tachometer-alt"></i> Dashboard Overview
            </a>
            <a href="{{ route('admin.server-tracking.config') }}">
                <i class="fas fa-sliders-h"></i> Pipeline Credentials
            </a>
            <a href="{{ route('admin.server-tracking.logs') }}">
                <i class="fas fa-list-alt"></i> Audit Logs &amp; Inspector
                <span class="badge badge-secondary ml-1">{{ number_format($totalEvents) }}</span>
            </a>
        </div>

        <!-- 4-Stage Architecture Diagram Card -->
        <div class="card border-0 mb-4" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-uppercase small font-weight-bold" style="color: #0284c7; letter-spacing: 0.5px;">
                        <i class="fas fa-project-diagram mr-1"></i> Dual-Tagging Hybrid Tracking Pipeline
                    </span>
                    <span class="badge badge-pill badge-light text-muted border font-mono" style="font-size: 11px;">
                        Zero Signal Loss &bull; SHA-256 Hashing &bull; Deduplicated
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                        <div class="tracking-pipeline-step">
                            <div class="tracking-pipeline-icon" style="background: #eff6ff; color: #2563eb;">
                                <i class="fas fa-desktop"></i>
                            </div>
                            <h6 class="font-weight-bold text-dark mb-1" style="font-size: 14px;">1. Client Browser</h6>
                            <p class="text-muted small mb-0">Captures pixel hits, cookies (<code>_fbp</code>, <code>_fbc</code>, <code>_ga</code>) &amp; campaign UTMs</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                        <div class="tracking-pipeline-step">
                            <div class="tracking-pipeline-icon" style="background: #ecfdf5; color: #059669;">
                                <i class="fas fa-server"></i>
                            </div>
                            <h6 class="font-weight-bold text-dark mb-1" style="font-size: 14px;">2. NextDigiHome Edge</h6>
                            <p class="text-muted small mb-0">Ingests conversion requests &amp; assigns deterministic <code>event_id</code> for deduplication</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                        <div class="tracking-pipeline-step">
                            <div class="tracking-pipeline-icon" style="background: #fffbeb; color: #d97706;">
                                <i class="fas fa-fingerprint"></i>
                            </div>
                            <h6 class="font-weight-bold text-dark mb-1" style="font-size: 14px;">3. Privacy Normalization</h6>
                            <p class="text-muted small mb-0">Normalizes and hashes customer emails &amp; phones via SHA-256 (GDPR/CCPA compliant)</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                        <div class="tracking-pipeline-step">
                            <div class="tracking-pipeline-icon" style="background: #f5f3ff; color: #7c3aed;">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <h6 class="font-weight-bold text-dark mb-1" style="font-size: 14px;">4. Direct Cloud APIs</h6>
                            <p class="text-muted small mb-0">Delivers encrypted payloads straight to Meta CAPI, GA4 Protocol, TikTok &amp; Webhooks</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Metrics Row -->
        @php
            $successRate = $totalEvents > 0 ? round(($totalSuccess / $totalEvents) * 100, 1) : 100;
            $activePipelines = 0;
            if (!empty($metaConfig['enabled'])) $activePipelines++;
            if (!empty($ga4Config['enabled'])) $activePipelines++;
            if (!empty($tiktokConfig['enabled'])) $activePipelines++;
            if (!empty($webhookConfig['enabled'])) $activePipelines++;
        @endphp
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="premium-stat">
                    <div class="premium-icon premium-blue">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div>
                        <small>Total Server Dispatches</small>
                        <strong>{{ number_format($totalEvents) }}</strong>
                        <span class="text-muted" style="font-size: 11px;">Recorded edge transactions</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="premium-stat">
                    <div class="premium-icon premium-green">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center">
                            <small class="mb-0 mr-2">Delivery Success</small>
                            <span class="badge badge-success" style="font-size: 10px; border-radius: 10px;">{{ $successRate }}%</span>
                        </div>
                        <strong>{{ number_format($totalSuccess) }}</strong>
                        <div class="progress mt-1" style="height: 4px; width: 110px; background: #e2e8f0;">
                            <div class="progress-bar bg-success" style="width: {{ $successRate }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="premium-stat">
                    <div class="premium-icon {{ $totalFailed > 0 ? 'premium-red' : 'premium-amber' }}">
                        <i class="fas {{ $totalFailed > 0 ? 'fa-exclamation-triangle' : 'fa-shield-alt' }}"></i>
                    </div>
                    <div>
                        <small>Failed / Dropped</small>
                        <strong class="{{ $totalFailed > 0 ? 'text-danger' : 'text-dark' }}">{{ number_format($totalFailed) }}</strong>
                        <span class="text-muted" style="font-size: 11px;">
                            {{ $totalFailed > 0 ? 'Review audit logs for details' : 'Clean pipeline, zero drops' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="premium-stat">
                    <div class="premium-icon premium-purple">
                        <i class="fas fa-broadcast-tower"></i>
                    </div>
                    <div>
                        <small>Active Cloud Channels</small>
                        <strong>{{ $activePipelines }} <span style="font-size: 14px; color: #64748b; font-weight: normal;">/ 4 Active</span></strong>
                        <span class="text-muted" style="font-size: 11px;">Meta, GA4, TikTok, sGTM</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Provider Control & Status Cards -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="font-weight-bold text-dark mb-0">
                <i class="fas fa-cubes text-primary mr-1"></i> Conversion Dispatch Channels
            </h5>
            <span class="text-muted small">Instant test dispatch and channel status</span>
        </div>

        <div class="row mb-4">
            <!-- Meta CAPI Card -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="provider-card">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="provider-icon-badge" style="background: #eff6ff;">
                                <i class="fab fa-facebook text-primary"></i>
                            </div>
                            @if(!empty($metaConfig['enabled']))
                                <span class="status-badge-active"><i class="fas fa-circle" style="font-size: 7px;"></i> Active</span>
                            @else
                                <span class="status-badge-disabled"><i class="fas fa-circle" style="font-size: 7px;"></i> Disabled</span>
                            @endif
                        </div>
                        <h5 class="font-weight-bold text-dark mb-1">Meta Conversions API</h5>
                        <p class="text-muted small mb-3">Meta Graph API v{{ $metaConfig['version'] ?? '18.0' }}</p>

                        <div class="p-2 rounded mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <span class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 700;">Pixel / Dataset ID</span>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="font-mono text-dark small text-truncate" style="max-width: 140px;">
                                    {{ !empty($metaConfig['pixel_id']) ? $metaConfig['pixel_id'] : 'Not Configured' }}
                                </span>
                                @if(!empty($metaConfig['pixel_id']))
                                <button type="button" class="copy-pill-btn" onclick="navigator.clipboard.writeText('{{ $metaConfig['pixel_id'] }}'); alert('Pixel ID copied!');">
                                    <i class="fas fa-copy"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top" style="border-color: #f1f5f9 !important;">
                            <div>
                                <span class="text-muted small">Dispatched:</span>
                                <strong class="text-dark ml-1">{{ number_format($metaCount) }}</strong>
                            </div>
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-xs btn-outline-primary trigger-test-btn" data-provider="meta_capi" data-provider-name="Meta CAPI" style="border-radius: 6px; padding: 4px 10px; font-weight: 600;">
                                    <i class="fas fa-bolt mr-1"></i> Test
                                </button>
                                <a href="{{ route('admin.server-tracking.config') }}" class="btn btn-xs btn-outline-secondary ml-1" style="border-radius: 6px; padding: 4px 8px;">
                                    <i class="fas fa-cog"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GA4 Measurement Protocol Card -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="provider-card">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="provider-icon-badge" style="background: #fffbeb;">
                                <i class="fab fa-google text-warning"></i>
                            </div>
                            @if(!empty($ga4Config['enabled']))
                                <span class="status-badge-active"><i class="fas fa-circle" style="font-size: 7px;"></i> Active</span>
                            @else
                                <span class="status-badge-disabled"><i class="fas fa-circle" style="font-size: 7px;"></i> Disabled</span>
                            @endif
                        </div>
                        <h5 class="font-weight-bold text-dark mb-1">Google Analytics 4</h5>
                        <p class="text-muted small mb-3">Measurement Protocol API</p>

                        <div class="p-2 rounded mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <span class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 700;">Measurement ID</span>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="font-mono text-dark small text-truncate" style="max-width: 140px;">
                                    {{ !empty($ga4Config['measurement_id']) ? $ga4Config['measurement_id'] : 'Not Configured' }}
                                </span>
                                @if(!empty($ga4Config['measurement_id']))
                                <button type="button" class="copy-pill-btn" onclick="navigator.clipboard.writeText('{{ $ga4Config['measurement_id'] }}'); alert('GA4 ID copied!');">
                                    <i class="fas fa-copy"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top" style="border-color: #f1f5f9 !important;">
                            <div>
                                <span class="text-muted small">Dispatched:</span>
                                <strong class="text-dark ml-1">{{ number_format($ga4Count) }}</strong>
                            </div>
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-xs btn-outline-warning text-dark trigger-test-btn" data-provider="ga4" data-provider-name="GA4 Protocol" style="border-radius: 6px; padding: 4px 10px; font-weight: 600;">
                                    <i class="fas fa-bolt mr-1"></i> Test
                                </button>
                                <a href="{{ route('admin.server-tracking.config') }}" class="btn btn-xs btn-outline-secondary ml-1" style="border-radius: 6px; padding: 4px 8px;">
                                    <i class="fas fa-cog"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TikTok Events API Card -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="provider-card">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="provider-icon-badge" style="background: #fff1f2;">
                                <i class="fab fa-tiktok text-danger"></i>
                            </div>
                            @if(!empty($tiktokConfig['enabled']))
                                <span class="status-badge-active"><i class="fas fa-circle" style="font-size: 7px;"></i> Active</span>
                            @else
                                <span class="status-badge-disabled"><i class="fas fa-circle" style="font-size: 7px;"></i> Disabled</span>
                            @endif
                        </div>
                        <h5 class="font-weight-bold text-dark mb-1">TikTok Events API</h5>
                        <p class="text-muted small mb-3">Business API v1.3</p>

                        <div class="p-2 rounded mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <span class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 700;">Pixel Code</span>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="font-mono text-dark small text-truncate" style="max-width: 140px;">
                                    {{ !empty($tiktokConfig['pixel_code']) ? $tiktokConfig['pixel_code'] : 'Not Configured' }}
                                </span>
                                @if(!empty($tiktokConfig['pixel_code']))
                                <button type="button" class="copy-pill-btn" onclick="navigator.clipboard.writeText('{{ $tiktokConfig['pixel_code'] }}'); alert('TikTok Code copied!');">
                                    <i class="fas fa-copy"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top" style="border-color: #f1f5f9 !important;">
                            <div>
                                <span class="text-muted small">Dispatched:</span>
                                <strong class="text-dark ml-1">{{ number_format($tiktokCount) }}</strong>
                            </div>
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-xs btn-outline-danger trigger-test-btn" data-provider="tiktok" data-provider-name="TikTok Events API" style="border-radius: 6px; padding: 4px 10px; font-weight: 600;">
                                    <i class="fas fa-bolt mr-1"></i> Test
                                </button>
                                <a href="{{ route('admin.server-tracking.config') }}" class="btn btn-xs btn-outline-secondary ml-1" style="border-radius: 6px; padding: 4px 8px;">
                                    <i class="fas fa-cog"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Webhook / sGTM Card -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="provider-card">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="provider-icon-badge" style="background: #f5f3ff;">
                                <i class="fas fa-network-wired text-purple" style="color: #7c3aed;"></i>
                            </div>
                            @if(!empty($webhookConfig['enabled']))
                                <span class="status-badge-active"><i class="fas fa-circle" style="font-size: 7px;"></i> Active</span>
                            @else
                                <span class="status-badge-disabled"><i class="fas fa-circle" style="font-size: 7px;"></i> Disabled</span>
                            @endif
                        </div>
                        <h5 class="font-weight-bold text-dark mb-1">Server Webhook / sGTM</h5>
                        <p class="text-muted small mb-3">Stape, Make, Zapier &amp; Cloud</p>

                        <div class="p-2 rounded mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <span class="text-muted d-block" style="font-size: 10px; text-transform: uppercase; font-weight: 700;">Endpoint URL</span>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="font-mono text-dark small text-truncate" style="max-width: 140px;">
                                    {{ !empty($webhookConfig['url']) ? $webhookConfig['url'] : 'No URL Configured' }}
                                </span>
                                @if(!empty($webhookConfig['url']))
                                <button type="button" class="copy-pill-btn" onclick="navigator.clipboard.writeText('{{ $webhookConfig['url'] }}'); alert('Webhook URL copied!');">
                                    <i class="fas fa-copy"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top" style="border-color: #f1f5f9 !important;">
                            <div>
                                <span class="text-muted small">Dispatched:</span>
                                <strong class="text-dark ml-1">{{ number_format($webhookCount) }}</strong>
                            </div>
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-xs btn-outline-info trigger-test-btn" data-provider="webhook" data-provider-name="Custom Webhook" style="border-radius: 6px; padding: 4px 10px; font-weight: 600;">
                                    <i class="fas fa-bolt mr-1"></i> Test
                                </button>
                                <a href="{{ route('admin.server-tracking.config') }}" class="btn btn-xs btn-outline-secondary ml-1" style="border-radius: 6px; padding: 4px 8px;">
                                    <i class="fas fa-cog"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Telemetry Console (Reveals when test is run) -->
        <div id="live-console-card" class="card border-0 mb-4 d-none" style="background: #0f172a; border-radius: 12px; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.2);">
            <div class="card-header d-flex justify-content-between align-items-center py-3 px-4" style="background: rgba(0,0,0,0.25); border-bottom: 1px solid rgba(255,255,255,0.08);">
                <div class="d-flex align-items-center">
                    <span class="spinner-grow spinner-grow-sm text-success mr-2" role="status"></span>
                    <span class="font-weight-bold text-white font-mono small" id="console-title">
                        <i class="fas fa-terminal mr-2 text-info"></i>Telemetry Console Output
                    </span>
                    <span class="badge badge-pill badge-dark ml-3 font-mono" id="console-latency" style="border: 1px solid rgba(255,255,255,0.2); font-size: 11px;">-- ms</span>
                </div>
                <div>
                    <button type="button" class="btn btn-xs btn-outline-light mr-2" onclick="copyConsoleOutput()" style="font-size: 11px;">
                        <i class="fas fa-copy mr-1"></i> Copy Response JSON
                    </button>
                    <button type="button" class="btn btn-xs btn-link text-white p-0" onclick="document.getElementById('live-console-card').classList.add('d-none');">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-3">
                <pre id="console-output-pre" class="mb-0 text-success font-mono small" style="font-size: 12px; white-space: pre-wrap; word-break: break-all; max-height: 260px; overflow-y: auto;"></pre>
            </div>
        </div>

        <!-- Recent Tracking Activity Table Card -->
        <div class="card border-0 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);">
            <div class="card-header d-flex justify-content-between align-items-center py-3 px-4" style="background: #ffffff; border-bottom: 1px solid #edf0f4; border-radius: 12px 12px 0 0;">
                <div>
                    <h5 class="card-title text-dark font-weight-bold mb-0" style="font-size: 16px;">
                        <i class="fas fa-stream mr-2 text-primary"></i> Recent Server Dispatches
                    </h5>
                    <small class="text-muted">Live audit stream of outgoing conversion transmissions</small>
                </div>
                <div>
                    <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-sm btn-outline-primary" style="font-size: 12px; border-radius: 6px;">
                        View All Logs ({{ number_format($totalEvents) }}) <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 premium-table">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Channel</th>
                            <th>Event Name</th>
                            <th>Lead / Order Ref</th>
                            <th>Status</th>
                            <th>HTTP Code</th>
                            <th>Diagnostics</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLogs as $log)
                        <tr>
                            <td class="small text-muted font-mono">
                                {{ $log->created_at ? $log->created_at->format('M d, H:i:s') : 'N/A' }}
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
                            <td class="small text-muted text-truncate" style="max-width: 240px;" title="{{ $log->error_message }}">
                                {{ $log->error_message ?: '200 OK — Successfully delivered' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="mb-2" style="font-size: 32px;"><i class="fas fa-inbox text-muted"></i></div>
                                <h6 class="text-dark font-weight-bold">No server tracking events recorded yet</h6>
                                <p class="small text-muted mb-3">Launch a test conversion event using the button below to verify cloud connectivity.</p>
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#quickTestModal">
                                    <i class="fas fa-bolt mr-1"></i> Launch First Test Event
                                </button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Interactive Live Test Dispatch Modal -->
<div class="modal fade" id="quickTestModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 1px solid #e2e8f0; border-radius: 14px; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);">
            <div class="modal-header py-3 px-4" style="border-bottom: 1px solid #edf0f4; background: #f8fafc; border-radius: 14px 14px 0 0;">
                <div class="d-flex align-items-center">
                    <div style="background: #eff6ff; color: #2563eb; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px;" class="mr-3">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold text-dark mb-0" style="font-size: 16px;">Live Test Event Dispatcher</h5>
                        <small class="text-muted">Transmit synthetic conversion payload to ad cloud endpoints</small>
                    </div>
                </div>
                <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form id="liveTestForm">
                    <div class="form-group mb-3">
                        <label class="text-dark small font-weight-bold">Target Channel</label>
                        <select class="form-control" id="modal-provider" style="border-color: #cbd5e1; height: 42px;">
                            <option value="meta_capi">Meta Conversions API (CAPI)</option>
                            <option value="ga4">Google Analytics 4 Measurement Protocol</option>
                            <option value="tiktok">TikTok Events API</option>
                            <option value="webhook">Server Webhook / sGTM Container</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-dark small font-weight-bold">Standard Conversion Event</label>
                        <select class="form-control" id="modal-event-name" style="border-color: #cbd5e1; height: 42px;">
                            <option value="Lead" selected>Lead (Generate Lead)</option>
                            <option value="Purchase">Purchase (Order Transaction)</option>
                            <option value="ViewContent">ViewContent (Portfolio View)</option>
                            <option value="AddToCart">AddToCart (Service Package)</option>
                            <option value="InitiateCheckout">InitiateCheckout (Checkout Started)</option>
                            <option value="Contact">Contact (WhatsApp / Form Click)</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-dark small font-weight-bold">
                            Ad Manager Test Event Code <span class="text-muted font-weight-normal">(Optional Override)</span>
                        </label>
                        <input type="text" class="form-control font-mono" id="modal-test-code" placeholder="e.g. TEST12345 (Leave empty to use saved setting)" style="border-color: #cbd5e1; height: 42px;">
                        <small class="text-muted">Matches the real-time test event screen in Meta or TikTok Events Manager.</small>
                    </div>

                    <div class="p-3 rounded mb-0" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 12px; color: #475569;">
                        <i class="fas fa-shield-alt text-success mr-1"></i> Dispatches include realistic customer metadata (normalized phone, SHA-256 hashed email, client IP, User-Agent &amp; unique deterministic <code>event_id</code>).
                    </div>
                </form>
            </div>
            <div class="modal-footer py-3 px-4" style="border-top: 1px solid #edf0f4; background: #f8fafc; border-radius: 0 0 14px 14px;">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-primary px-3 font-weight-bold" id="executeTestBtn">
                    <i class="fas fa-paper-plane mr-1"></i> Transmit Test Event
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.trigger-test-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const provider = this.getAttribute('data-provider');
        const select = document.getElementById('modal-provider');
        if (select) {
            select.value = provider;
        }
        if (typeof $ !== 'undefined' && $('#quickTestModal').modal) {
            $('#quickTestModal').modal('show');
        }
    });
});

document.getElementById('executeTestBtn').addEventListener('click', function() {
    const provider = document.getElementById('modal-provider').value;
    const eventName = document.getElementById('modal-event-name').value;
    const testCode = document.getElementById('modal-test-code').value;

    const origHtml = this.innerHTML;
    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Transmitting...';
    this.disabled = true;

    fetch('{{ route("admin.server-tracking.test") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            provider: provider,
            event_name: eventName,
            test_event_code: testCode
        })
    })
    .then(res => res.json())
    .then(data => {
        if (typeof $ !== 'undefined' && $('#quickTestModal').modal) {
            $('#quickTestModal').modal('hide');
        }

        const card = document.getElementById('live-console-card');
        const pre = document.getElementById('console-output-pre');
        const latencyBadge = document.getElementById('console-latency');
        const title = document.getElementById('console-title');

        card.classList.remove('d-none');
        title.innerHTML = `<i class="fas fa-terminal mr-2 text-info"></i>Telemetry Console: [${provider.toUpperCase()}] &rarr; ${eventName}`;
        
        const latency = (data.result && data.result.latency_ms) ? data.result.latency_ms + ' ms' : 'Completed';
        latencyBadge.textContent = latency;

        pre.textContent = JSON.stringify(data, null, 2);
        card.scrollIntoView({ behavior: 'smooth' });
    })
    .catch(err => {
        alert('Test dispatch network error: ' + err);
    })
    .finally(() => {
        this.innerHTML = origHtml;
        this.disabled = false;
    });
});

function copyConsoleOutput() {
    const text = document.getElementById('console-output-pre').textContent;
    navigator.clipboard.writeText(text).then(() => {
        alert('Console response JSON copied to clipboard!');
    });
}
</script>
@endsection
