@extends('admin.dashboard.master')

@section('title', 'AI Chatbot Control & Intelligence Center - ' . config('app.name'))

@section('main_content')
@include('admin.partials.premium-ui')

<!-- Preconnect & Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

<style>
    .ai-root {
        font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
        color: #0f172a;
    }
    .ai-header-card {
        background: linear-gradient(135deg, #090d16 0%, #111827 50%, #0d1f2d 100%);
        border: 1px solid rgba(0, 212, 170, 0.2);
        border-radius: 16px;
        padding: 26px 30px;
        color: #ffffff;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.3);
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }
    .ai-header-card::after {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(0, 212, 170, 0.15) 0%, transparent 70%);
        pointer-events: none;
    }
    .ai-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px 22px;
        transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        position: relative;
        height: 100%;
    }
    .ai-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px -4px rgba(15, 23, 42, 0.08);
        border-color: #cbd5e1;
    }
    .ai-kpi-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748b;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .ai-kpi-val {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }
    .ai-kpi-sub {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 6px;
    }
    .ai-kpi-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }
    .ai-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 22px 24px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        margin-bottom: 25px;
    }
    .ai-panel-title {
        font-size: 16px;
        font-weight: 750;
        color: #0f172a;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .badge-provider {
        font-family: 'JetBrains Mono', monospace;
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 6px;
        font-weight: 600;
    }
    .badge-gemini { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .badge-openai { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-rag { background: #faf5ff; color: #7e22ce; border: 1px solid #e9d5ff; }

    .lang-pill {
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 12px;
        text-transform: uppercase;
    }
    .lang-bn { background: #ecfdf5; color: #047857; }
    .lang-banglish { background: #fffbeb; color: #b45309; }
    .lang-en { background: #eff6ff; color: #1d4ed8; }

    .table-ai {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .table-ai th {
        background: #f8fafc;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 14px;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-ai td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
        vertical-align: middle;
    }
    .table-ai tr:hover td {
        background: #fbfcfe;
    }
    .nav-tabs-ai {
        display: flex;
        gap: 8px;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 20px;
    }
    .nav-tabs-ai a {
        padding: 9px 16px;
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        border-radius: 8px 8px 0 0;
        border-bottom: 2px solid transparent;
        transition: all 0.2s;
    }
    .nav-tabs-ai a:hover {
        color: #0f172a;
    }
    .nav-tabs-ai a.active {
        color: #00b894;
        border-bottom-color: #00b894;
        background: rgba(0, 212, 170, 0.05);
    }
</style>

<div class="ai-root">
    <!-- Breadcrumb -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
        <div>
            <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0;">AI Chatbot & RAG Intelligence Suite</h1>
            <p style="font-size: 13.5px; color: #64748b; margin: 3px 0 0;">Dynamic multilingual conversational agent, conversation telemetry & real-time RAG knowledge base.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.ai-chatbot.playground') }}" class="btn btn-outline-primary" style="font-size: 13px; font-weight: 600; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-terminal"></i> RAG Playground
            </a>
            <a href="{{ route('admin.ai-chatbot.settings') }}" class="btn btn-dark" style="font-size: 13px; font-weight: 600; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa fa-sliders-h"></i> Bot Settings
            </a>
        </div>
    </div>

    <!-- AI Suite Navigation Tabs -->
    <div class="nav-tabs-ai">
        <a href="{{ route('admin.ai-chatbot.dashboard') }}" class="active"><i class="fa fa-chart-pie me-1"></i> Analytics Dashboard</a>
        <a href="{{ route('admin.ai-chatbot.conversations') }}"><i class="fa fa-comments me-1"></i> Conversation Logs</a>
        <a href="{{ route('admin.ai-chatbot.knowledge-base') }}"><i class="fa fa-brain me-1"></i> Knowledge Base & RAG</a>
        <a href="{{ route('admin.ai-chatbot.leads') }}"><i class="fa fa-user-check me-1"></i> Captured Leads</a>
        <a href="{{ route('admin.ai-chatbot.settings') }}"><i class="fa fa-sliders-h me-1"></i> Configuration</a>
        <a href="{{ route('admin.ai-chatbot.playground') }}"><i class="fa fa-terminal me-1"></i> Test Playground</a>
    </div>

    <!-- Hero Card -->
    <div class="ai-header-card">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; background: {{ $settings->bot_enabled ? 'rgba(0, 212, 170, 0.2)' : 'rgba(239, 68, 68, 0.2)' }}; color: {{ $settings->bot_enabled ? '#00d4aa' : '#ef4444' }};">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $settings->bot_enabled ? '#00d4aa' : '#ef4444' }};"></span>
                        {{ $settings->bot_enabled ? 'BOT ONLINE & SERVING CLIENTS' : 'BOT OFFLINE' }}
                    </span>
                    <span class="badge-provider {{ $settings->primary_provider === 'gemini' ? 'badge-gemini' : ($settings->primary_provider === 'openai' ? 'badge-openai' : 'badge-rag') }}">
                        Engine: {{ strtoupper($settings->primary_provider) }} ({{ $settings->primary_provider === 'gemini' ? $settings->gemini_model : ($settings->primary_provider === 'openai' ? $settings->openai_model : 'Dynamic RAG') }})
                    </span>
                </div>
                <h2 style="font-size: 22px; font-weight: 800; margin: 0 0 6px;">{{ $settings->bot_name }}</h2>
                <p style="font-size: 13.5px; opacity: 0.85; margin: 0; max-width: 620px;">
                    {{ $settings->bot_tagline }} &bull; Trained on NextDigi Solutions, 7 Enterprise ERPs (ParkPulse, MediCore, BillVibe, NetShield, Garibondhu) with auto-lead scoring and multilingual Bangla/Banglish/English understanding.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div style="background: rgba(255, 255, 255, 0.08); border-radius: 12px; padding: 14px 18px; display: inline-block; text-align: left;">
                    <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.7;">Avg Latency</div>
                    <div style="font-size: 20px; font-weight: 800; color: #00d4aa;">{{ $avgResponseTime > 0 ? $avgResponseTime . ' ms' : '~140 ms' }}</div>
                    <div style="font-size: 11px; opacity: 0.7;">Fallback: {{ strtoupper($settings->fallback_provider) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 6 KPI Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4 col-xl-2">
            <div class="ai-kpi-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <div class="ai-kpi-label"><i class="fa fa-comments text-primary"></i> Total Chats</div>
                        <div class="ai-kpi-val">{{ number_format($totalConversations) }}</div>
                        <div class="ai-kpi-sub">+{{ $todayConversations }} today</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-2">
            <div class="ai-kpi-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <div class="ai-kpi-label"><i class="fa fa-comment-dots text-info"></i> Messages</div>
                        <div class="ai-kpi-val">{{ number_format($totalMessages) }}</div>
                        <div class="ai-kpi-sub">+{{ $todayMessages }} today</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-2">
            <div class="ai-kpi-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <div class="ai-kpi-label"><i class="fa fa-user-tag text-success"></i> Leads</div>
                        <div class="ai-kpi-val" style="color: #059669;">{{ number_format($totalLeads) }}</div>
                        <div class="ai-kpi-sub">+{{ $todayLeads }} today</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-2">
            <div class="ai-kpi-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <div class="ai-kpi-label"><i class="fa fa-smile text-warning"></i> Satisfaction</div>
                        <div class="ai-kpi-val" style="color: #d97706;">{{ $satisfactionRate }}%</div>
                        <div class="ai-kpi-sub">{{ $thumbsUp }} 👍 / {{ $thumbsDown }} 👎</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-2">
            <div class="ai-kpi-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <div class="ai-kpi-label"><i class="fa fa-language text-secondary"></i> Bangla/Bg</div>
                        <div class="ai-kpi-val" style="color: #7c3aed;">{{ $bnCount + $banglishCount }}</div>
                        <div class="ai-kpi-sub">{{ $bnCount }} BN &bull; {{ $banglishCount }} Banglish</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-xl-2">
            <div class="ai-kpi-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <div class="ai-kpi-label"><i class="fa fa-bolt text-danger"></i> Speed</div>
                        <div class="ai-kpi-val" style="color: #0284c7;">{{ $avgResponseTime > 0 ? $avgResponseTime : 140 }}<span style="font-size: 15px;">ms</span></div>
                        <div class="ai-kpi-sub">Edge RAG speed</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row: 14-day Conversation Trends & Language Breakdown -->
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="ai-panel h-100">
                <div class="ai-panel-title">
                    <span><i class="fa fa-chart-line text-primary me-2"></i> 14-Day Chat & Message Volume</span>
                    <span style="font-size: 12px; font-weight: 500; color: #64748b;">Daily Activity</span>
                </div>
                <div style="height: 270px; position: relative;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ai-panel h-100">
                <div class="ai-panel-title">
                    <span><i class="fa fa-globe text-success me-2"></i> Language Breakdown</span>
                </div>
                <div style="height: 200px; position: relative;">
                    <canvas id="langChart"></canvas>
                </div>
                <div style="display: flex; justify-content: space-around; margin-top: 15px; text-align: center;">
                    <div>
                        <div style="font-size: 11px; color: #64748b; font-weight: 600;">Bangla (বাংলা)</div>
                        <div style="font-size: 16px; font-weight: 800; color: #059669;">{{ $bnCount }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: #64748b; font-weight: 600;">Banglish</div>
                        <div style="font-size: 16px; font-weight: 800; color: #d97706;">{{ $banglishCount }}</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: #64748b; font-weight: 600;">English</div>
                        <div style="font-size: 16px; font-weight: 800; color: #2563eb;">{{ $enCount }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column: Top Knowledge Base Chunks & Recent Conversations -->
    <div class="row g-3">
        <!-- Top Knowledge Chunks -->
        <div class="col-lg-6">
            <div class="ai-panel">
                <div class="ai-panel-title">
                    <span><i class="fa fa-brain text-purple me-2" style="color: #8b5cf6;"></i> Top Matched Knowledge Chunks</span>
                    <a href="{{ route('admin.ai-chatbot.knowledge-base') }}" style="font-size: 12px; color: #0284c7; text-decoration: none; font-weight: 600;">View All &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table-ai">
                        <thead>
                            <tr>
                                <th>Knowledge Item</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Hits</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topKnowledge as $chunk)
                            <tr>
                                <td>
                                    <div style="font-weight: 700; color: #0f172a; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $chunk->title }}">
                                        {{ $chunk->title }}
                                    </div>
                                    <small style="color: #64748b; font-size: 11px;">{{ \Illuminate\Support\Str::limit($chunk->keywords, 35) }}</small>
                                </td>
                                <td>
                                    <span style="font-size: 11px; font-weight: 700; background: #f1f5f9; padding: 2px 7px; border-radius: 4px; text-transform: uppercase;">
                                        {{ str_replace('_', ' ', $chunk->category) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $chunk->priority >= 9 ? 'bg-success' : 'bg-secondary' }}" style="font-size: 11px;">
                                        P{{ $chunk->priority }}
                                    </span>
                                </td>
                                <td style="font-weight: 700; color: #0284c7;">
                                    {{ number_format($chunk->hit_count) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No knowledge items hit yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Conversations -->
        <div class="col-lg-6">
            <div class="ai-panel">
                <div class="ai-panel-title">
                    <span><i class="fa fa-clock text-info me-2"></i> Recent Conversations</span>
                    <a href="{{ route('admin.ai-chatbot.conversations') }}" style="font-size: 12px; color: #0284c7; text-decoration: none; font-weight: 600;">Full Logs &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table-ai">
                        <thead>
                            <tr>
                                <th>Session / Query</th>
                                <th>Lang</th>
                                <th>Lead</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentConversations as $conv)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.ai-chatbot.conversations', ['search' => $conv->session_id]) }}" style="font-weight: 700; color: #0f172a; text-decoration: none; display: block; max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $conv->first_message ?: $conv->session_id }}
                                    </a>
                                    <small style="color: #94a3b8; font-size: 11px;">{{ $conv->messages_count }} msgs &bull; {{ $conv->device_type }}</small>
                                </td>
                                <td>
                                    <span class="lang-pill lang-{{ $conv->detected_language }}">{{ $conv->detected_language }}</span>
                                </td>
                                <td>
                                    @if(in_array($conv->lead_status, ['captured', 'converted']))
                                        <span style="font-size: 11px; font-weight: 700; background: #ecfdf5; color: #065f46; padding: 2px 7px; border-radius: 4px;">
                                            <i class="fa fa-check-circle"></i> {{ $conv->lead_phone ?: 'Lead' }}
                                        </span>
                                    @else
                                        <span style="font-size: 11px; color: #94a3b8;">None</span>
                                    @endif
                                </td>
                                <td style="font-size: 12px; color: #64748b; white-space: nowrap;">
                                    {{ $conv->updated_at->diffForHumans() }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No conversations recorded yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Trend Chart
    const ctxTrend = document.getElementById('trendChart').getContext('2d');
    new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: {!! json_encode($days) !!},
            datasets: [
                {
                    label: 'Conversations',
                    data: {!! json_encode($conversationTrends) !!},
                    borderColor: '#00d4aa',
                    backgroundColor: 'rgba(0, 212, 170, 0.1)',
                    tension: 0.35,
                    fill: true,
                    borderWidth: 2.5,
                    pointRadius: 3
                },
                {
                    label: 'Messages',
                    data: {!! json_encode($messageTrends) !!},
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139, 92, 246, 0.05)',
                    tension: 0.35,
                    fill: true,
                    borderWidth: 2,
                    pointRadius: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { boxWidth: 12, font: { family: 'Plus Jakarta Sans', size: 12 } } },
                tooltip: { padding: 10, cornerRadius: 8 }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Language Breakdown Doughnut Chart
    const ctxLang = document.getElementById('langChart').getContext('2d');
    new Chart(ctxLang, {
        type: 'doughnut',
        data: {
            labels: ['Bangla (বাংলা)', 'Banglish', 'English'],
            datasets: [{
                data: [{{ $bnCount }}, {{ $banglishCount }}, {{ $enCount }}],
                backgroundColor: ['#10b981', '#f59e0b', '#3b82f6'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
@endsection
