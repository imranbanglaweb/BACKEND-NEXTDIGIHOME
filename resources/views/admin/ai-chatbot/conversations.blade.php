@extends('admin.dashboard.master')

@section('title', 'AI Chat Conversations & History - ' . config('app.name'))

@section('main_content')
@include('admin.partials.premium-ui')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    .ai-root {
        font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
        color: #0f172a;
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
    .nav-tabs-ai a:hover { color: #0f172a; }
    .nav-tabs-ai a.active {
        color: #00b894;
        border-bottom-color: #00b894;
        background: rgba(0, 212, 170, 0.05);
    }
    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }
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
        padding: 13px 16px;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-ai td {
        padding: 13px 16px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
        vertical-align: middle;
    }
    .table-ai tr:hover td {
        background: #fbfcfe;
    }
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

    /* Interactive Chat Drawer / Modal */
    .chat-bubble {
        padding: 10px 14px;
        border-radius: 12px;
        margin-bottom: 12px;
        max-width: 82%;
        font-size: 13.5px;
        line-height: 1.5;
        position: relative;
    }
    .chat-bubble.user {
        background: #0284c7;
        color: #ffffff;
        margin-left: auto;
        border-bottom-right-radius: 3px;
    }
    .chat-bubble.bot {
        background: #f1f5f9;
        color: #0f172a;
        margin-right: auto;
        border-bottom-left-radius: 3px;
        border: 1px solid #e2e8f0;
    }
    .chat-meta {
        font-size: 10.5px;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
        opacity: 0.75;
    }
</style>

<div class="ai-root">
    <!-- Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
        <div>
            <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0;">AI Chat Conversations & History</h1>
            <p style="font-size: 13.5px; color: #64748b; margin: 3px 0 0;">Inspect user queries, full multi-turn chat sessions, latency metrics, and lead conversions.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.ai-chatbot.conversations.export') }}" class="btn btn-outline-secondary" style="font-size: 13px; font-weight: 600; border-radius: 8px;">
                <i class="fa fa-file-export me-1"></i> Export CSV
            </a>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="nav-tabs-ai">
        <a href="{{ route('admin.ai-chatbot.dashboard') }}"><i class="fa fa-chart-pie me-1"></i> Analytics Dashboard</a>
        <a href="{{ route('admin.ai-chatbot.conversations') }}" class="active"><i class="fa fa-comments me-1"></i> Conversation Logs</a>
        <a href="{{ route('admin.ai-chatbot.knowledge-base') }}"><i class="fa fa-brain me-1"></i> Knowledge Base & RAG</a>
        <a href="{{ route('admin.ai-chatbot.leads') }}"><i class="fa fa-user-check me-1"></i> Captured Leads</a>
        <a href="{{ route('admin.ai-chatbot.settings') }}"><i class="fa fa-sliders-h me-1"></i> Configuration</a>
        <a href="{{ route('admin.ai-chatbot.playground') }}"><i class="fa fa-terminal me-1"></i> Test Playground</a>
    </div>

    <!-- Filter Form -->
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.ai-chatbot.conversations') }}" class="row g-2 align-items-center">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search session, phone, email, message..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="language" class="form-select form-select-sm">
                    <option value="">All Languages</option>
                    <option value="bn" {{ request('language') == 'bn' ? 'selected' : '' }}>বাংলা (Bangla)</option>
                    <option value="banglish" {{ request('language') == 'banglish' ? 'selected' : '' }}>Banglish</option>
                    <option value="en" {{ request('language') == 'en' ? 'selected' : '' }}>English</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="lead_status" class="form-select form-select-sm">
                    <option value="">All Lead Statuses</option>
                    <option value="captured" {{ request('lead_status') == 'captured' ? 'selected' : '' }}>Captured</option>
                    <option value="converted" {{ request('lead_status') == 'converted' ? 'selected' : '' }}>Converted</option>
                    <option value="none" {{ request('lead_status') == 'none' ? 'selected' : '' }}>No Lead</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary w-100" style="border-radius: 6px;">Filter</button>
                <a href="{{ route('admin.ai-chatbot.conversations') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 6px;">Reset</a>
            </div>
        </form>
    </div>

    <!-- Conversations Table -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);">
        <div class="table-responsive">
            <table class="table-ai">
                <thead>
                    <tr>
                        <th>Session ID / First Query</th>
                        <th>Lang</th>
                        <th>Msgs</th>
                        <th>Captured Lead</th>
                        <th>Device & IP</th>
                        <th>Rating</th>
                        <th>Date & Time</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($conversations as $conv)
                    <tr>
                        <td>
                            <div style="font-weight: 700; color: #0f172a; max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $conv->first_message }}">
                                {{ $conv->first_message ?: 'New Session' }}
                            </div>
                            <small style="font-family: 'JetBrains Mono', monospace; font-size: 11px; color: #64748b;">{{ $conv->session_id }}</small>
                        </td>
                        <td>
                            <span class="lang-pill lang-{{ $conv->detected_language }}">{{ $conv->detected_language }}</span>
                        </td>
                        <td>
                            <span style="font-weight: 700; font-size: 13px; color: #0284c7;">{{ $conv->messages_count }}</span>
                        </td>
                        <td>
                            @if(in_array($conv->lead_status, ['captured', 'converted']))
                                <div style="font-weight: 700; color: #059669; font-size: 12px;">
                                    <i class="fa fa-phone-alt me-1"></i> {{ $conv->lead_phone ?: 'Lead Captured' }}
                                </div>
                                @if($conv->lead_email)
                                    <small style="color: #64748b; font-size: 11px;">{{ $conv->lead_email }}</small>
                                @endif
                            @else
                                <span style="font-size: 12px; color: #94a3b8;">None</span>
                            @endif
                        </td>
                        <td>
                            <span style="font-size: 12px; color: #475569; text-transform: capitalize;">{{ $conv->device_type ?: 'Desktop' }}</span>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 11px; color: #94a3b8;">{{ $conv->user_ip ?: 'Local' }}</div>
                        </td>
                        <td>
                            @if($conv->satisfaction_score === 1)
                                <span class="badge bg-success" style="font-size: 11px;">👍 Helpful</span>
                            @elseif($conv->satisfaction_score === -1)
                                <span class="badge bg-danger" style="font-size: 11px;">👎 Unhelpful</span>
                            @else
                                <span style="color: #cbd5e1;">-</span>
                            @endif
                        </td>
                        <td style="font-size: 12px; color: #64748b; white-space: nowrap;">
                            {{ $conv->created_at->format('M d, Y h:i A') }}
                        </td>
                        <td class="text-end">
                            <button type="button" class="btn btn-sm btn-outline-primary me-1" onclick="openTranscriptModal({{ $conv->id }}, '{{ $conv->session_id }}')" style="border-radius: 6px; padding: 4px 10px; font-size: 12px;">
                                <i class="fa fa-eye me-1"></i> View Chat
                            </button>
                            <form action="{{ route('admin.ai-chatbot.conversations.destroy', $conv->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Delete this conversation log?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px; font-size: 12px;" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No conversation logs match the current filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 15px 20px; border-top: 1px solid #f1f5f9;">
            {{ $conversations->links() }}
        </div>
    </div>
</div>

<!-- Interactive Transcript Modal -->
<div class="modal fade" id="transcriptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden;">
            <div class="modal-header" style="background: #0f172a; color: #ffffff; padding: 16px 20px;">
                <div>
                    <h5 class="modal-title" style="font-size: 16px; font-weight: 700; margin: 0;" id="transcriptModalTitle">Chat Replay</h5>
                    <small id="transcriptModalSubtitle" style="color: #94a3b8; font-size: 11.5px;"></small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="transcriptModalBody" style="background: #f8fafc; max-height: 480px; overflow-y: auto; padding: 20px;">
                <div class="text-center py-4 text-muted">Loading chat messages...</div>
            </div>
            <div class="modal-footer" style="background: #ffffff; padding: 12px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between;">
                <div id="transcriptFooterInfo" style="font-size: 12px; color: #64748b;"></div>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" style="border-radius: 6px;">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function openTranscriptModal(convId, sessionId) {
    const modal = new bootstrap.Modal(document.getElementById('transcriptModal'));
    document.getElementById('transcriptModalTitle').innerText = 'Session: ' + sessionId;
    document.getElementById('transcriptModalSubtitle').innerText = 'Loading telemetry...';
    document.getElementById('transcriptModalBody').innerHTML = '<div class="text-center py-5 text-muted"><i class="fa fa-spinner fa-spin fa-2x"></i><div class="mt-2">Fetching messages...</div></div>';
    modal.show();

    fetch('{{ url("admin/ai-chatbot/conversations") }}/' + convId, {
        headers: { 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            document.getElementById('transcriptModalBody').innerHTML = '<div class="alert alert-danger">Failed to load conversation.</div>';
            return;
        }

        const conv = data.conversation;
        const messages = data.messages || [];

        document.getElementById('transcriptModalSubtitle').innerText = 'Language: ' + conv.detected_language.toUpperCase() + ' | Messages: ' + messages.length + ' | IP: ' + (conv.user_ip || 'N/A');

        let html = '';
        if (messages.length === 0) {
            html = '<div class="text-center text-muted py-4">No messages recorded in this session.</div>';
        } else {
            messages.forEach(msg => {
                const isUser = msg.sender === 'user';
                const bubbleClass = isUser ? 'user' : 'bot';
                const senderName = isUser ? 'User' : 'NextDigi AI';
                const providerBadge = !isUser && msg.provider_used ? '<span class="badge bg-dark" style="font-size: 9.5px; margin-left: 6px;">' + msg.provider_used.toUpperCase() + '</span>' : '';
                const latencyBadge = !isUser && msg.response_time_ms ? '<span style="font-size: 10px; color: #64748b;">(' + msg.response_time_ms + 'ms)</span>' : '';

                html += '<div class="chat-bubble ' + bubbleClass + '">';
                html += '<div style="font-weight: 700; font-size: 11px; margin-bottom: 4px; opacity: 0.85;">' + senderName + providerBadge + '</div>';
                html += '<div style="white-space: pre-wrap;">' + escapeHtml(msg.message) + '</div>';
                html += '<div class="chat-meta">';
                html += '<span>' + new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + '</span>';
                html += latencyBadge;
                if (msg.feedback === 'like') html += '<span class="text-success ms-1">👍</span>';
                if (msg.feedback === 'dislike') html += '<span class="text-danger ms-1">👎</span>';
                html += '</div>';
                html += '</div>';
            });
        }

        document.getElementById('transcriptModalBody').innerHTML = html;
        document.getElementById('transcriptFooterInfo').innerHTML = conv.lead_phone ? '<strong>Captured Contact:</strong> ' + conv.lead_phone : 'No lead contact submitted.';
    })
    .catch(err => {
        document.getElementById('transcriptModalBody').innerHTML = '<div class="alert alert-danger">Error loading conversation: ' + err.message + '</div>';
    });
}

function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
</script>
@endsection
