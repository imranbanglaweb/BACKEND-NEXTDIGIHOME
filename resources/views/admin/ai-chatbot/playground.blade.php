@extends('admin.dashboard.master')

@section('title', 'AI RAG Test Playground - ' . config('app.name'))

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
    .chip-sample {
        display: inline-block;
        font-size: 12px;
        padding: 4px 10px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        color: #334155;
        margin-right: 6px;
        margin-bottom: 6px;
        cursor: pointer;
        transition: all 0.15s;
    }
    .chip-sample:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
</style>

<div class="ai-root">
    <!-- Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
        <div>
            <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0;">AI Agent & RAG Test Playground</h1>
            <p style="font-size: 13.5px; color: #64748b; margin: 3px 0 0;">Inspect semantic retrieval scoring, real-time knowledge injection and LLM generation latency.</p>
        </div>
        <span class="badge bg-dark" style="font-size: 12px; padding: 6px 12px;">
            Active Engine: {{ strtoupper($settings->primary_provider) }} ({{ $settings->gemini_model ?: $settings->openai_model }})
        </span>
    </div>

    <!-- Navigation Tabs -->
    <div class="nav-tabs-ai">
        <a href="{{ route('admin.ai-chatbot.dashboard') }}"><i class="fa fa-chart-pie me-1"></i> Analytics Dashboard</a>
        <a href="{{ route('admin.ai-chatbot.conversations') }}"><i class="fa fa-comments me-1"></i> Conversation Logs</a>
        <a href="{{ route('admin.ai-chatbot.knowledge-base') }}"><i class="fa fa-brain me-1"></i> Knowledge Base & RAG</a>
        <a href="{{ route('admin.ai-chatbot.leads') }}"><i class="fa fa-user-check me-1"></i> Captured Leads</a>
        <a href="{{ route('admin.ai-chatbot.settings') }}"><i class="fa fa-sliders-h me-1"></i> Configuration</a>
        <a href="{{ route('admin.ai-chatbot.playground') }}" class="active"><i class="fa fa-terminal me-1"></i> Test Playground</a>
    </div>

    <div class="row g-4">
        <!-- Left Column: Test Input Console -->
        <div class="col-lg-5">
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);">
                <div style="font-size: 15px; font-weight: 750; color: #0f172a; margin-bottom: 14px;">
                    <i class="fa fa-paper-plane text-primary me-1"></i> Test Query Input
                </div>

                <div class="mb-3">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #475569;">Sample Prompts</label>
                    <div>
                        @foreach($sampleQueries as $sq)
                            <span class="chip-sample" onclick="setQuery('{{ addslashes($sq) }}')">{{ $sq }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #475569;">Language Override</label>
                    <select id="pgLang" class="form-select form-select-sm">
                        <option value="">Auto-Detect (Bangla, Banglish, English)</option>
                        <option value="bn">Force বাংলা (Bangla)</option>
                        <option value="banglish">Force Banglish</option>
                        <option value="en">Force English</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="font-size: 12.5px; font-weight: 700; color: #475569;">User Message / Query</label>
                    <textarea id="pgQuery" class="form-control" rows="4" placeholder="Type question in English, বাংলা or Banglish..."></textarea>
                </div>

                <button type="button" id="btnRunTest" class="btn btn-primary w-100" onclick="runPlaygroundTest()" style="background: #00d4aa; border-color: #00d4aa; color: #000; font-weight: 700; border-radius: 8px; padding: 10px;">
                    <i class="fa fa-bolt me-1"></i> Execute RAG & AI Query
                </button>
            </div>
        </div>

        <!-- Right Column: AI Output & RAG Context Inspector -->
        <div class="col-lg-7">
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04); min-height: 480px;">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 16px;">
                    <div style="font-size: 15px; font-weight: 750; color: #0f172a;">
                        <i class="fa fa-robot text-success me-1"></i> AI Output & Telemetry
                    </div>
                    <div id="pgTelemetry" style="font-size: 12px; color: #64748b;">Ready</div>
                </div>

                <!-- AI Response Bubble -->
                <div id="pgResponseContainer" style="display: none;">
                    <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; margin-bottom: 6px;">
                        Generated Agent Response
                    </div>
                    <div id="pgReplyText" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; font-size: 14px; line-height: 1.6; white-space: pre-wrap; color: #0f172a; margin-bottom: 16px;"></div>

                    <!-- Action Buttons Generated -->
                    <div id="pgActionsContainer" style="margin-bottom: 16px; display: none;">
                        <div style="font-size: 11.5px; font-weight: 700; color: #64748b; margin-bottom: 6px;">Generated Actions:</div>
                        <div id="pgActionsList" style="display: flex; gap: 8px; flex-wrap: wrap;"></div>
                    </div>

                    <!-- Retrieved RAG Chunks Inspector -->
                    <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; margin-bottom: 8px;">
                        <i class="fa fa-database text-purple me-1" style="color: #8b5cf6;"></i> Retrieved RAG Knowledge Chunks
                    </div>
                    <div id="pgChunksList"></div>
                </div>

                <div id="pgPlaceholder" class="text-center py-5 text-muted">
                    <i class="fa fa-terminal fa-3x" style="opacity: 0.3;"></i>
                    <div class="mt-3" style="font-size: 14px;">Select a prompt on the left or type your own question to test the RAG engine.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function setQuery(text) {
    document.getElementById('pgQuery').value = text;
}

function runPlaygroundTest() {
    const query = document.getElementById('pgQuery').value.trim();
    if (!query) {
        alert('Please enter a query to test');
        return;
    }

    const lang = document.getElementById('pgLang').value;
    const btn = document.getElementById('btnRunTest');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Running RAG Engine...';

    document.getElementById('pgPlaceholder').style.display = 'none';
    document.getElementById('pgResponseContainer').style.display = 'block';
    document.getElementById('pgTelemetry').innerHTML = '<span class="text-primary"><i class="fa fa-spinner fa-spin"></i> Processing...</span>';

    fetch('{{ route("admin.ai-chatbot.playground.execute") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ query: query, language: lang })
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-bolt me-1"></i> Execute RAG & AI Query';

        if (!data.success) {
            document.getElementById('pgTelemetry').innerHTML = '<span class="text-danger">Failed</span>';
            document.getElementById('pgReplyText').innerText = 'Error running test.';
            return;
        }

        document.getElementById('pgTelemetry').innerHTML = '<span class="badge bg-success">' + data.provider.toUpperCase() + '</span> <span class="ms-1" style="font-weight:700;">' + data.responseTimeMs + 'ms</span> <span class="badge bg-light text-dark ms-1">' + data.detectedLanguage.toUpperCase() + '</span>';
        document.getElementById('pgReplyText').innerText = data.aiResponse;

        // Actions
        const actionsCont = document.getElementById('pgActionsContainer');
        const actionsList = document.getElementById('pgActionsList');
        actionsList.innerHTML = '';
        if (data.actions && data.actions.length > 0) {
            actionsCont.style.display = 'block';
            data.actions.forEach(act => {
                const btn = document.createElement('a');
                btn.href = act.url;
                btn.target = act.isExternal ? '_blank' : '_self';
                btn.className = 'btn btn-sm btn-outline-dark';
                btn.style.borderRadius = '6px';
                btn.style.fontSize = '12px';
                btn.innerText = act.label;
                actionsList.appendChild(btn);
            });
        } else {
            actionsCont.style.display = 'none';
        }

        // Chunks
        const chunksList = document.getElementById('pgChunksList');
        chunksList.innerHTML = '';
        if (data.retrievedChunks && data.retrievedChunks.length > 0) {
            data.retrievedChunks.forEach(chunk => {
                const div = document.createElement('div');
                div.style.background = '#f1f5f9';
                div.style.border = '1px solid #e2e8f0';
                div.style.borderRadius = '8px';
                div.style.padding = '10px 14px';
                div.style.marginBottom = '8px';
                div.style.fontSize = '12px';

                div.innerHTML = '<div style="display:flex; justify-content:space-between; font-weight:700; color:#0f172a;">' +
                                '<span>' + escapeHtml(chunk.title) + '</span>' +
                                '<span class="badge bg-secondary">P' + chunk.priority + '</span>' +
                                '</div>' +
                                '<div style="color:#64748b; margin-top:3px;">' + escapeHtml(chunk.content_preview) + '</div>';
                chunksList.appendChild(div);
            });
        } else {
            chunksList.innerHTML = '<div class="text-muted" style="font-size:12px;">No matching knowledge chunks retrieved (generic fallback used).</div>';
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-bolt me-1"></i> Execute RAG & AI Query';
        document.getElementById('pgTelemetry').innerHTML = '<span class="text-danger">Error: ' + err.message + '</span>';
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
