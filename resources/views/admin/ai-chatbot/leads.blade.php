@extends('admin.dashboard.master')

@section('title', 'AI Chatbot Captured Leads - ' . config('app.name'))

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
</style>

<div class="ai-root">
    <!-- Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
        <div>
            <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0;">Captured AI Leads & Customer Inquiries</h1>
            <p style="font-size: 13.5px; color: #64748b; margin: 3px 0 0;">High-intent customer contacts, phone numbers and consultation inquiries collected 24/7 by the chatbot.</p>
        </div>
        <a href="{{ Route::has('admin.inquiries.index') ? route('admin.inquiries.index') : (Route::has('inquiries.index') ? route('inquiries.index') : url('inquiries')) }}" class="btn btn-outline-primary" style="font-size: 13px; font-weight: 600; border-radius: 8px;">
            <i class="fa fa-envelope-open-text me-1"></i> Go to Project Inquiries
        </a>
    </div>

    <!-- Navigation Tabs -->
    <div class="nav-tabs-ai">
        <a href="{{ route('admin.ai-chatbot.dashboard') }}"><i class="fa fa-chart-pie me-1"></i> Analytics Dashboard</a>
        <a href="{{ route('admin.ai-chatbot.conversations') }}"><i class="fa fa-comments me-1"></i> Conversation Logs</a>
        <a href="{{ route('admin.ai-chatbot.knowledge-base') }}"><i class="fa fa-brain me-1"></i> Knowledge Base & RAG</a>
        <a href="{{ route('admin.ai-chatbot.leads') }}" class="active"><i class="fa fa-user-check me-1"></i> Captured Leads</a>
        <a href="{{ route('admin.ai-chatbot.settings') }}"><i class="fa fa-sliders-h me-1"></i> Configuration</a>
        <a href="{{ route('admin.ai-chatbot.playground') }}"><i class="fa fa-terminal me-1"></i> Test Playground</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
        <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert" style="border-radius: 10px;">
        <i class="fa fa-info-circle me-1"></i> {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Leads Table -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);">
        <div class="table-responsive">
            <table class="table-ai">
                <thead>
                    <tr>
                        <th>Lead Contact</th>
                        <th>Interest / Service</th>
                        <th>First Message / Session</th>
                        <th>Sync Status</th>
                        <th>Captured At</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                    <tr>
                        <td>
                            <div style="font-weight: 800; color: #0f172a; font-size: 14px;">
                                <i class="fa fa-phone-alt text-success me-1"></i> {{ $lead->lead_phone ?: 'Phone not provided' }}
                            </div>
                            @if($lead->lead_name)
                                <div style="font-weight: 600; font-size: 12px; color: #334155;">{{ $lead->lead_name }}</div>
                            @endif
                            @if($lead->lead_email)
                                <small style="color: #64748b; font-size: 11.5px;">{{ $lead->lead_email }}</small>
                            @endif
                        </td>
                        <td>
                            <span style="font-size: 12px; font-weight: 700; background: #eff6ff; color: #1e40af; padding: 3px 8px; border-radius: 6px;">
                                {{ $lead->lead_service_interest ?: 'General Consultation' }}
                            </span>
                        </td>
                        <td>
                            <div style="max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 13px; color: #334155;" title="{{ $lead->first_message }}">
                                {{ $lead->first_message ?: 'Chat Session' }}
                            </div>
                            <small style="font-family: 'JetBrains Mono', monospace; font-size: 10.5px; color: #94a3b8;">{{ $lead->session_id }}</small>
                        </td>
                        <td>
                            @if($lead->lead_synced_to_inquiries)
                                <span class="badge bg-success" style="font-size: 11px;">
                                    <i class="fa fa-check-circle"></i> Synced to Inquiries
                                </span>
                            @else
                                <span class="badge bg-warning text-dark" style="font-size: 11px;">
                                    <i class="fa fa-clock"></i> Captured in Chat
                                </span>
                            @endif
                        </td>
                        <td style="font-size: 12px; color: #64748b; white-space: nowrap;">
                            {{ $lead->updated_at->format('M d, Y h:i A') }}
                        </td>
                        <td class="text-end">
                            @if(!$lead->lead_synced_to_inquiries)
                                <form action="{{ route('admin.ai-chatbot.leads.sync-inquiry', $lead->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success" style="border-radius: 6px; font-size: 12px; font-weight: 600;">
                                        <i class="fa fa-share me-1"></i> Sync to Inquiries
                                    </button>
                                </form>
                            @else
                                <a href="{{ Route::has('admin.inquiries.index') ? route('admin.inquiries.index', ['search' => $lead->lead_phone]) : (Route::has('inquiries.index') ? route('inquiries.index', ['search' => $lead->lead_phone]) : url('inquiries?search=' . urlencode($lead->lead_phone))) }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 6px; font-size: 12px;">
                                    View in Inquiries
                                </a>
                            @endif
                            <a href="{{ route('admin.ai-chatbot.conversations', ['search' => $lead->session_id]) }}" class="btn btn-sm btn-outline-primary ms-1" style="border-radius: 6px; font-size: 12px;">
                                View Chat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No leads captured yet. When visitors submit contact details or ask for pricing, leads will appear here.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 15px 20px; border-top: 1px solid #f1f5f9;">
            {{ $leads->links() }}
        </div>
    </div>
</div>
@endsection
