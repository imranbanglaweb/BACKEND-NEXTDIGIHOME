@extends('admin.dashboard.master')

@section('title', 'Server-Side Tracking & CAPI Console - ' . config('app.name'))

@section('main_content')
<section class="content-body py-4" style="background: linear-gradient(135deg, #0b0d14 0%, #111827 50%, #0d1322 100%); min-height: 100vh; color: #f1f5f9;">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom" style="border-color: rgba(255,255,255,0.07) !important;">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div style="background: linear-gradient(135deg, #00d4aa 0%, #0284c7 100%); color: #070b14; width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; box-shadow: 0 0 24px rgba(0, 212, 170, 0.35);">
                    <i class="fas fa-satellite-dish"></i>
                </div>
                <div class="ml-3">
                    <h3 class="font-weight-bold text-white mb-0" style="letter-spacing: -0.5px;">
                        Server-Side Tracking &amp; CAPI Console
                    </h3>
                    <p class="text-muted small mb-0 mt-1">
                        Edge deduplication &bull; SHA-256 data normalization &bull; Direct cloud dispatch to Meta CAPI, Google Analytics 4, TikTok &amp; sGTM
                    </p>
                </div>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2">
                <button type="button" class="btn btn-sm mr-2" data-toggle="modal" data-target="#quickTestModal" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; border: none; font-weight: 600; padding: 7px 16px; border-radius: 8px; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);">
                    <i class="fas fa-bolt mr-1"></i> Live Test Dispatch
                </button>
                <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-sm btn-outline-info mr-2" style="border-radius: 8px; padding: 7px 14px; border-color: rgba(56, 189, 248, 0.4);">
                    <i class="fas fa-list mr-1"></i> Audit Logs
                </a>
                <a href="{{ route('admin.server-tracking.config') }}" class="btn btn-sm btn-primary" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border: none; border-radius: 8px; padding: 7px 16px; font-weight: 600;">
                    <i class="fas fa-sliders-h mr-1"></i> Pipeline Config
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

        <!-- Visual Tracking Pipeline Architecture Flow -->
        <div class="card border-0 mb-4" style="background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(12px); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-uppercase small font-weight-bold" style="color: #38bdf8; letter-spacing: 1px;">
                        <i class="fas fa-project-diagram mr-1"></i> Dual-Tagging Architecture Pipeline
                    </span>
                    <span class="badge badge-pill badge-dark font-mono text-muted" style="border: 1px solid rgba(255, 255, 255, 0.1); font-size: 11px;">
                        Zero Ad-Blocker Loss &bull; Deduplication Enabled
                    </span>
                </div>

                <div class="row text-center position-relative">
                    <!-- Step 1 -->
                    <div class="col-md-3 col-6 mb-3 mb-md-0">
                        <div class="p-3 rounded-lg h-100" style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px;">
                            <div class="mb-2" style="color: #60a5fa; font-size: 20px;"><i class="fas fa-desktop"></i></div>
                            <h6 class="font-weight-bold text-white mb-1" style="font-size: 13px;">1. Client Browser</h6>
                            <p class="text-muted mb-0" style="font-size: 11px;">Pixel + Cookies (<code>_fbp</code>, <code>_fbc</code>, <code>_ga</code>) + UTM params</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="col-md-3 col-6 mb-3 mb-md-0">
                        <div class="p-3 rounded-lg h-100" style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px;">
                            <div class="mb-2" style="color: #34d399; font-size: 20px;"><i class="fas fa-server"></i></div>
                            <h6 class="font-weight-bold text-white mb-1" style="font-size: 13px;">2. NextDigiHome Server</h6>
                            <p class="text-muted mb-0" style="font-size: 11px;">Inquiry &amp; order ingestion, deterministic <code>event_id</code> assignment</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="col-md-3 col-6 mb-3 mb-md-0">
                        <div class="p-3 rounded-lg h-100" style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px;">
                            <div class="mb-2" style="color: #fbbf24; font-size: 20px;"><i class="fas fa-fingerprint"></i></div>
                            <h6 class="font-weight-bold text-white mb-1" style="font-size: 13px;">3. Privacy Normalization</h6>
                            <p class="text-muted mb-0" style="font-size: 11px;">SHA-256 hashed emails/phones, IP &amp; User Agent sanitization</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="col-md-3 col-6 mb-3 mb-md-0">
                        <div class="p-3 rounded-lg h-100" style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px;">
                            <div class="mb-2" style="color: #a78bfa; font-size: 20px;"><i class="fas fa-cloud-upload-alt"></i></div>
                            <h6 class="font-weight-bold text-white mb-1" style="font-size: 13px;">4. Direct Cloud APIs</h6>
                            <p class="text-muted mb-0" style="font-size: 11px;">Meta CAPI, GA4 Measurement Protocol, TikTok Events API &amp; Webhook</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Metrics Grid -->
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
                <div class="card border-0 h-100 p-3" style="background: rgba(15, 23, 42, 0.85); border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.07); box-shadow: 0 8px 24px rgba(0,0,0,0.25);">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small uppercase font-weight-bold" style="letter-spacing: 0.5px;">Total Dispatches</span>
                        <div style="background: rgba(56, 189, 248, 0.12); color: #38bdf8; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                    </div>
                    <h2 class="font-weight-bold text-white mb-1">{{ number_format($totalEvents) }}</h2>
                    <span class="text-muted small"><i class="fas fa-history mr-1"></i> Recorded server transactions</span>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 h-100 p-3" style="background: rgba(15, 23, 42, 0.85); border-radius: 14px; border: 1px solid rgba(16, 185, 129, 0.25); box-shadow: 0 8px 24px rgba(0,0,0,0.25);">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small uppercase font-weight-bold" style="color: #34d399; letter-spacing: 0.5px;">Delivery Success</span>
                        <div style="background: rgba(16, 185, 129, 0.12); color: #34d399; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check-double"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline mb-1">
                        <h2 class="font-weight-bold mb-0 text-white mr-2">{{ number_format($totalSuccess) }}</h2>
                        <span class="badge badge-pill badge-success" style="font-size: 11px;">{{ $successRate }}%</span>
                    </div>
                    <div class="progress" style="height: 4px; background: rgba(255,255,255,0.1); border-radius: 2px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $successRate }}%"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 h-100 p-3" style="background: rgba(15, 23, 42, 0.85); border-radius: 14px; border: 1px solid rgba(244, 63, 94, 0.25); box-shadow: 0 8px 24px rgba(0,0,0,0.25);">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small uppercase font-weight-bold" style="color: #fb7185; letter-spacing: 0.5px;">Failed / Dropped</span>
                        <div style="background: rgba(244, 63, 94, 0.12); color: #fb7185; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <h2 class="font-weight-bold mb-1" style="color: {{ $totalFailed > 0 ? '#f43f5e' : '#ffffff' }};">{{ number_format($totalFailed) }}</h2>
                    <span class="text-muted small">
                        @if($totalFailed > 0)
                            <span class="text-danger"><i class="fas fa-times-circle mr-1"></i> Check logs for error diagnostics</span>
                        @else
                            <span class="text-success"><i class="fas fa-shield-alt mr-1"></i> Clean pipeline, zero drops</span>
                        @endif
                    </span>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 h-100 p-3" style="background: rgba(15, 23, 42, 0.85); border-radius: 14px; border: 1px solid rgba(139, 92, 246, 0.25); box-shadow: 0 8px 24px rgba(0,0,0,0.25);">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small uppercase font-weight-bold" style="color: #a78bfa; letter-spacing: 0.5px;">Active Cloud Channels</span>
                        <div style="background: rgba(139, 92, 246, 0.12); color: #a78bfa; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-broadcast-tower"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline mb-1">
                        <h2 class="font-weight-bold text-white mb-0 mr-2">{{ $activePipelines }} / 4</h2>
                        <span class="badge badge-pill badge-info" style="font-size: 11px;">Pipelines Active</span>
                    </div>
                    <span class="text-muted small"><i class="fas fa-plug mr-1"></i> Meta, GA4, TikTok, sGTM</span>
                </div>
            </div>
        </div>

        <!-- Provider Status & Control Cards -->
        <h5 class="font-weight-bold text-white mb-3 d-flex align-items-center">
            <i class="fas fa-cubes mr-2 text-primary"></i> Tracking Pipelines &amp; Dispatch Status
        </h5>
        <div class="row mb-4">
            <!-- Meta CAPI Card -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 h-100" style="background: #0f1523; border: 1px solid {{ !empty($metaConfig['enabled']) ? 'rgba(0,212,170,0.35)' : 'rgba(255,255,255,0.08)' }} !important; border-radius: 16px; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div style="background: rgba(24, 119, 242, 0.15); width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fab fa-facebook" style="font-size: 24px; color: #1877f2;"></i>
                                </div>
                                <span class="badge {{ !empty($metaConfig['enabled']) ? 'badge-success' : 'badge-secondary' }}" style="font-size: 11px; padding: 5px 10px; border-radius: 20px;">
                                    {{ !empty($metaConfig['enabled']) ? '● Active' : '○ Disabled' }}
                                </span>
                            </div>

                            <h5 class="font-weight-bold text-white mb-1">Meta CAPI</h5>
                            <p class="text-muted small mb-2">Conversions API v{{ $metaConfig['version'] ?? '18.0' }}</p>

                            <div class="p-2 rounded mb-3" style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.06);">
                                <span class="text-muted d-block" style="font-size: 10px; text-transform: uppercase;">Pixel / Dataset ID</span>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="font-mono text-white small text-truncate" style="max-width: 150px;">{{ !empty($metaConfig['pixel_id']) ? $metaConfig['pixel_id'] : 'Not Configured' }}</span>
                                    @if(!empty($metaConfig['pixel_id']))
                                    <button type="button" class="btn btn-link btn-xs text-muted p-0" onclick="navigator.clipboard.writeText('{{ $metaConfig['pixel_id'] }}'); alert('Pixel ID copied!');">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top" style="border-color: rgba(255,255,255,0.08) !important;">
                                <div>
                                    <span class="text-muted" style="font-size: 11px;">Dispatched:</span>
                                    <span class="font-weight-bold text-white ml-1">{{ number_format($metaCount) }}</span>
                                </div>
                                <button type="button" class="btn btn-sm trigger-test-btn" data-provider="meta_capi" data-provider-name="Meta CAPI" style="background: rgba(0, 212, 170, 0.15); border: 1px solid rgba(0, 212, 170, 0.4); color: #00d4aa; border-radius: 6px; font-weight: 600; font-size: 11px; padding: 4px 10px;">
                                    <i class="fas fa-bolt mr-1"></i> Test
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GA4 Measurement Protocol Card -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 h-100" style="background: #0f1523; border: 1px solid {{ !empty($ga4Config['enabled']) ? 'rgba(56,189,248,0.35)' : 'rgba(255,255,255,0.08)' }} !important; border-radius: 16px; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div style="background: rgba(245, 158, 11, 0.15); width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fab fa-google" style="font-size: 22px; color: #f59e0b;"></i>
                                </div>
                                <span class="badge {{ !empty($ga4Config['enabled']) ? 'badge-info' : 'badge-secondary' }}" style="font-size: 11px; padding: 5px 10px; border-radius: 20px;">
                                    {{ !empty($ga4Config['enabled']) ? '● Active' : '○ Disabled' }}
                                </span>
                            </div>

                            <h5 class="font-weight-bold text-white mb-1">Google Analytics 4</h5>
                            <p class="text-muted small mb-2">Measurement Protocol API</p>

                            <div class="p-2 rounded mb-3" style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.06);">
                                <span class="text-muted d-block" style="font-size: 10px; text-transform: uppercase;">Measurement ID</span>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="font-mono text-white small text-truncate" style="max-width: 150px;">{{ !empty($ga4Config['measurement_id']) ? $ga4Config['measurement_id'] : 'Not Configured' }}</span>
                                    @if(!empty($ga4Config['measurement_id']))
                                    <button type="button" class="btn btn-link btn-xs text-muted p-0" onclick="navigator.clipboard.writeText('{{ $ga4Config['measurement_id'] }}'); alert('GA4 ID copied!');">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top" style="border-color: rgba(255,255,255,0.08) !important;">
                                <div>
                                    <span class="text-muted" style="font-size: 11px;">Dispatched:</span>
                                    <span class="font-weight-bold text-white ml-1">{{ number_format($ga4Count) }}</span>
                                </div>
                                <button type="button" class="btn btn-sm trigger-test-btn" data-provider="ga4" data-provider-name="GA4 Protocol" style="background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.4); color: #38bdf8; border-radius: 6px; font-weight: 600; font-size: 11px; padding: 4px 10px;">
                                    <i class="fas fa-bolt mr-1"></i> Test
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TikTok Events API Card -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 h-100" style="background: #0f1523; border: 1px solid {{ !empty($tiktokConfig['enabled']) ? 'rgba(244,63,94,0.35)' : 'rgba(255,255,255,0.08)' }} !important; border-radius: 16px; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div style="background: rgba(254, 44, 85, 0.15); width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fab fa-tiktok" style="font-size: 22px; color: #fe2c55;"></i>
                                </div>
                                <span class="badge {{ !empty($tiktokConfig['enabled']) ? 'badge-danger' : 'badge-secondary' }}" style="font-size: 11px; padding: 5px 10px; border-radius: 20px;">
                                    {{ !empty($tiktokConfig['enabled']) ? '● Active' : '○ Disabled' }}
                                </span>
                            </div>

                            <h5 class="font-weight-bold text-white mb-1">TikTok Events API</h5>
                            <p class="text-muted small mb-2">Business Open API v1.3</p>

                            <div class="p-2 rounded mb-3" style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.06);">
                                <span class="text-muted d-block" style="font-size: 10px; text-transform: uppercase;">Pixel Code</span>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="font-mono text-white small text-truncate" style="max-width: 150px;">{{ !empty($tiktokConfig['pixel_code']) ? $tiktokConfig['pixel_code'] : 'Not Configured' }}</span>
                                    @if(!empty($tiktokConfig['pixel_code']))
                                    <button type="button" class="btn btn-link btn-xs text-muted p-0" onclick="navigator.clipboard.writeText('{{ $tiktokConfig['pixel_code'] }}'); alert('TikTok Code copied!');">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top" style="border-color: rgba(255,255,255,0.08) !important;">
                                <div>
                                    <span class="text-muted" style="font-size: 11px;">Dispatched:</span>
                                    <span class="font-weight-bold text-white ml-1">{{ number_format($tiktokCount) }}</span>
                                </div>
                                <button type="button" class="btn btn-sm trigger-test-btn" data-provider="tiktok" data-provider-name="TikTok Events API" style="background: rgba(244, 63, 94, 0.15); border: 1px solid rgba(244, 63, 94, 0.4); color: #fb7185; border-radius: 6px; font-weight: 600; font-size: 11px; padding: 4px 10px;">
                                    <i class="fas fa-bolt mr-1"></i> Test
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Webhook / sGTM Card -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 h-100" style="background: #0f1523; border: 1px solid {{ !empty($webhookConfig['enabled']) ? 'rgba(139,92,246,0.35)' : 'rgba(255,255,255,0.08)' }} !important; border-radius: 16px; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div style="background: rgba(139, 92, 246, 0.15); width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-network-wired" style="font-size: 20px; color: #a78bfa;"></i>
                                </div>
                                <span class="badge {{ !empty($webhookConfig['enabled']) ? 'badge-primary' : 'badge-secondary' }}" style="font-size: 11px; padding: 5px 10px; border-radius: 20px;">
                                    {{ !empty($webhookConfig['enabled']) ? '● Active' : '○ Disabled' }}
                                </span>
                            </div>

                            <h5 class="font-weight-bold text-white mb-1">Server Webhook / sGTM</h5>
                            <p class="text-muted small mb-2">Stape, Make, Zapier &amp; Cloud</p>

                            <div class="p-2 rounded mb-3" style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.06);">
                                <span class="text-muted d-block" style="font-size: 10px; text-transform: uppercase;">Endpoint URL</span>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="font-mono text-white small text-truncate" style="max-width: 150px;">{{ !empty($webhookConfig['url']) ? $webhookConfig['url'] : 'No URL Configured' }}</span>
                                    @if(!empty($webhookConfig['url']))
                                    <button type="button" class="btn btn-link btn-xs text-muted p-0" onclick="navigator.clipboard.writeText('{{ $webhookConfig['url'] }}'); alert('Webhook URL copied!');">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top" style="border-color: rgba(255,255,255,0.08) !important;">
                                <div>
                                    <span class="text-muted" style="font-size: 11px;">Dispatched:</span>
                                    <span class="font-weight-bold text-white ml-1">{{ number_format($webhookCount) }}</span>
                                </div>
                                <button type="button" class="btn btn-sm trigger-test-btn" data-provider="webhook" data-provider-name="Custom Webhook" style="background: rgba(139, 92, 246, 0.15); border: 1px solid rgba(139, 92, 246, 0.4); color: #c4b5fd; border-radius: 6px; font-weight: 600; font-size: 11px; padding: 4px 10px;">
                                    <i class="fas fa-bolt mr-1"></i> Test
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Dispatch Output Console Box -->
        <div id="live-console-card" class="card border-0 mb-4 d-none" style="background: #080d1a; border: 1px solid rgba(0, 212, 170, 0.4) !important; border-radius: 16px; box-shadow: 0 10px 30px rgba(0, 212, 170, 0.1);">
            <div class="card-header d-flex justify-content-between align-items-center py-3" style="background: rgba(0,0,0,0.3); border-bottom: 1px solid rgba(255,255,255,0.08);">
                <div class="d-flex align-items-center">
                    <span class="spinner-grow spinner-grow-sm text-success mr-2" id="console-pulse" role="status"></span>
                    <span class="font-weight-bold text-white font-mono" id="console-title"><i class="fas fa-terminal mr-2 text-info"></i>Dispatch Telemetry Console</span>
                    <span class="badge badge-pill badge-dark ml-3 font-mono" id="console-latency" style="border: 1px solid rgba(255,255,255,0.15); font-size: 11px;">-- ms</span>
                </div>
                <div>
                    <button type="button" class="btn btn-xs btn-outline-secondary mr-2" onclick="copyConsoleOutput()" style="font-size: 11px;">
                        <i class="fas fa-copy mr-1"></i> Copy Response
                    </button>
                    <button type="button" class="btn btn-xs btn-link text-muted" onclick="document.getElementById('live-console-card').classList.add('d-none');">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-3">
                <pre id="console-output-pre" class="mb-0 text-success font-mono" style="font-size: 12px; white-space: pre-wrap; word-break: break-all; max-height: 280px; overflow-y: auto;"></pre>
            </div>
        </div>

        <!-- Recent Tracking Activity Stream Table -->
        <div class="card border-0 shadow-sm" style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(10px); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.08);">
            <div class="card-header d-flex justify-content-between align-items-center py-3 px-4" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.07);">
                <div>
                    <h5 class="card-title text-white font-weight-bold mb-0">
                        <i class="fas fa-stream mr-2 text-info"></i> Recent Server Dispatches
                    </h5>
                    <small class="text-muted">Real-time edge event delivery audit trail</small>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.server-tracking.logs') }}" class="btn btn-sm btn-outline-info" style="border-radius: 8px; font-size: 12px; padding: 5px 14px;">
                        View All Logs ({{ $totalEvents }}) <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="color: #cbd5e1;">
                    <thead style="background: rgba(0,0,0,0.35); border-bottom: 1px solid rgba(255,255,255,0.08);">
                        <tr>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;">Timestamp</th>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;">Channel</th>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;">Event Name</th>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;">Lead / Order Ref</th>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;">Delivery Status</th>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;">HTTP Code</th>
                            <th style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px;">Diagnostics</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLogs as $log)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
                            <td class="small text-muted font-mono" style="padding: 14px 16px;">
                                {{ $log->created_at ? $log->created_at->format('M d, H:i:s') : 'N/A' }}
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
                                <span class="{{ ($log->http_code >= 200 && $log->http_code < 300) ? 'text-success' : ($log->http_code ? 'text-danger' : 'text-muted') }}">
                                    {{ $log->http_code ?: '—' }}
                                </span>
                            </td>
                            <td class="small text-muted truncate" style="max-width: 250px; padding: 14px 16px;" title="{{ $log->error_message }}">
                                {{ $log->error_message ?: '200 OK — Delivered via edge pipeline' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="mb-2" style="font-size: 32px;"><i class="fas fa-inbox text-muted"></i></div>
                                <h6 class="text-white">No server tracking events recorded yet</h6>
                                <p class="small text-muted mb-3">Trigger your first conversion event using the <strong>Live Test Dispatch</strong> button above.</p>
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
</section>

<!-- Interactive Live Test Dispatch Modal -->
<div class="modal fade" id="quickTestModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background: #0d121f; border: 1px solid rgba(0, 212, 170, 0.35); border-radius: 18px; box-shadow: 0 20px 50px rgba(0,0,0,0.6);">
            <div class="modal-header py-3 px-4" style="border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="d-flex align-items-center">
                    <div style="background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%); color: #070b14; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px;" class="mr-3">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-white font-weight-bold mb-0">Live Test Event Dispatcher</h5>
                        <small class="text-muted">Transmit synthetic conversion to edge ad endpoints</small>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form id="liveTestForm">
                    <div class="form-group mb-3">
                        <label class="text-white small font-weight-bold">Select Target Ad Platform</label>
                        <select class="form-control" id="modal-provider" style="background: #060911; border-color: rgba(255,255,255,0.15); color: #fff; height: 42px;">
                            <option value="meta_capi">Meta Conversions API (CAPI)</option>
                            <option value="ga4">Google Analytics 4 Measurement Protocol</option>
                            <option value="tiktok">TikTok Events API</option>
                            <option value="webhook">Server Webhook / sGTM Container</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-white small font-weight-bold">Standard Conversion Event Name</label>
                        <select class="form-control" id="modal-event-name" style="background: #060911; border-color: rgba(255,255,255,0.15); color: #fff; height: 42px;">
                            <option value="Lead" selected>Lead (Generate Lead)</option>
                            <option value="Purchase">Purchase (Order Transaction)</option>
                            <option value="ViewContent">ViewContent (Project Portfolio View)</option>
                            <option value="AddToCart">AddToCart (Package Selection)</option>
                            <option value="InitiateCheckout">InitiateCheckout (Checkout Started)</option>
                            <option value="Contact">Contact (WhatsApp / Form Click)</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-white small font-weight-bold">
                            Ad Manager Test Event Code <span class="text-muted font-weight-normal">(Optional Override)</span>
                        </label>
                        <input type="text" class="form-control font-mono" id="modal-test-code" placeholder="e.g. TEST12345 (Leave empty to use configured code)" style="background: #060911; border-color: rgba(255,255,255,0.15); color: #fff; height: 42px; font-size: 13px;">
                        <small class="text-muted">Directly matches the real-time test event screen in Meta or TikTok Events Manager.</small>
                    </div>

                    <div class="p-3 rounded mb-0" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); font-size: 12px; color: #94a3b8;">
                        <i class="fas fa-shield-alt text-success mr-1"></i> Dispatches include realistic customer metadata (normalized phone, SHA-256 hashed email, client IP, User-Agent &amp; unique deterministic <code>event_id</code>).
                    </div>
                </form>
            </div>
            <div class="modal-footer py-3 px-4" style="border-top: 1px solid rgba(255, 255, 255, 0.08);">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-success px-3 font-weight-bold" id="executeTestBtn" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none;">
                    <i class="fas fa-paper-plane mr-1"></i> Transmit Test Event
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Click on provider card Test button preselects provider in modal
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

// Execute live test dispatch
document.getElementById('executeTestBtn').addEventListener('click', function() {
    const provider = document.getElementById('modal-provider').value;
    const eventName = document.getElementById('modal-event-name').value;
    const testCode = document.getElementById('modal-test-code').value;

    const origHtml = this.innerHTML;
    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Dispatching...';
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
        // Hide modal
        if (typeof $ !== 'undefined' && $('#quickTestModal').modal) {
            $('#quickTestModal').modal('hide');
        }

        // Show console card
        const card = document.getElementById('live-console-card');
        const pre = document.getElementById('console-output-pre');
        const latencyBadge = document.getElementById('console-latency');
        const title = document.getElementById('console-title');

        card.classList.remove('d-none');
        title.innerHTML = `<i class="fas fa-terminal mr-2 text-info"></i>Dispatch Telemetry: [${provider.toUpperCase()}] &rarr; ${eventName}`;
        
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
