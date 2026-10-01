@extends('admin.dashboard.master')

@section('title', 'AI Chatbot Settings & Persona - ' . config('app.name'))

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
    .config-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }
    .config-title {
        font-size: 16px;
        font-weight: 750;
        color: #0f172a;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 12px;
    }
</style>

<div class="ai-root" style="max-width: 1040px; margin: 0 auto;">
    <!-- Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
        <div>
            <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0;">AI Chatbot Control & Engine Settings</h1>
            <p style="font-size: 13.5px; color: #64748b; margin: 3px 0 0;">Manage AI models (Gemini / OpenAI), RAG fallbacks, system prompt, multilingual greetings & WhatsApp routing.</p>
        </div>
        <a href="{{ route('admin.ai-chatbot.playground') }}" class="btn btn-outline-primary" style="font-size: 13px; font-weight: 600; border-radius: 8px;">
            <i class="fa fa-terminal me-1"></i> Open Test Playground
        </a>
    </div>

    <!-- Navigation Tabs -->
    <div class="nav-tabs-ai">
        <a href="{{ route('admin.ai-chatbot.dashboard') }}"><i class="fa fa-chart-pie me-1"></i> Analytics Dashboard</a>
        <a href="{{ route('admin.ai-chatbot.conversations') }}"><i class="fa fa-comments me-1"></i> Conversation Logs</a>
        <a href="{{ route('admin.ai-chatbot.knowledge-base') }}"><i class="fa fa-brain me-1"></i> Knowledge Base & RAG</a>
        <a href="{{ route('admin.ai-chatbot.leads') }}"><i class="fa fa-user-check me-1"></i> Captured Leads</a>
        <a href="{{ route('admin.ai-chatbot.settings') }}" class="active"><i class="fa fa-sliders-h me-1"></i> Configuration</a>
        <a href="{{ route('admin.ai-chatbot.playground') }}"><i class="fa fa-terminal me-1"></i> Test Playground</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
        <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger" style="border-radius: 10px;">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.ai-chatbot.settings.update') }}" method="POST">
        @csrf

        <!-- 1. General & Status -->
        <div class="config-card">
            <div class="config-title">
                <i class="fa fa-toggle-on text-success"></i> 1. Bot Activation & Persona
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <div class="form-check form-switch p-2 ps-5 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <input class="form-check-input" type="checkbox" name="bot_enabled" id="botEnabled" value="1" {{ old('bot_enabled', $settings->bot_enabled) ? 'checked' : '' }} style="cursor: pointer;">
                        <label class="form-check-label" for="botEnabled" style="font-weight: 700; color: #0f172a; cursor: pointer;">
                            Enable AI Chatbot on Website Frontend
                        </label>
                        <div style="font-size: 12px; color: #64748b;">When turned off, the chatbot will show a polite offline support notice with direct WhatsApp routing.</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Bot Display Name <span class="text-danger">*</span></label>
                    <input type="text" name="bot_name" class="form-control" value="{{ old('bot_name', $settings->bot_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Bot Tagline / Role</label>
                    <input type="text" name="bot_tagline" class="form-control" value="{{ old('bot_tagline', $settings->bot_tagline) }}">
                </div>
            </div>
        </div>

        <!-- 2. AI Engine & Provider -->
        <div class="config-card">
            <div class="config-title">
                <i class="fa fa-brain text-primary"></i> 2. Intelligence Provider & LLM Engine
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Primary Provider <span class="text-danger">*</span></label>
                    <select name="primary_provider" class="form-select" required>
                        <option value="gemini" {{ old('primary_provider', $settings->primary_provider) == 'gemini' ? 'selected' : '' }}>Google Gemini (Recommended - Multilingual & Fast)</option>
                        <option value="openai" {{ old('primary_provider', $settings->primary_provider) == 'openai' ? 'selected' : '' }}>OpenAI (GPT-4o / GPT-4o-mini)</option>
                        <option value="local_rag" {{ old('primary_provider', $settings->primary_provider) == 'local_rag' ? 'selected' : '' }}>Local Dynamic RAG Only (No external AI API)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Fallback Provider <span class="text-danger">*</span></label>
                    <select name="fallback_provider" class="form-select" required>
                        <option value="local_rag" {{ old('fallback_provider', $settings->fallback_provider) == 'local_rag' ? 'selected' : '' }}>Local Knowledge Base RAG (100% Uptime Guaranteed)</option>
                        <option value="openai" {{ old('fallback_provider', $settings->fallback_provider) == 'openai' ? 'selected' : '' }}>OpenAI Fallback</option>
                        <option value="none" {{ old('fallback_provider', $settings->fallback_provider) == 'none' ? 'selected' : '' }}>None</option>
                    </select>
                </div>

                <!-- Gemini Config -->
                <div class="col-md-6">
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px;">
                        <label class="form-label" style="font-weight: 700; font-size: 13px; color: #1d4ed8;">
                            <i class="fab fa-google text-primary me-1"></i> Gemini API Key
                        </label>
                        <input type="password" name="gemini_api_key" class="form-control form-control-sm font-monospace" placeholder="{{ $settings->gemini_api_key ? '••••••••••••••••••••••••••••' : 'AIzaSy...' }}" value="{{ old('gemini_api_key', $settings->gemini_api_key ? substr($settings->gemini_api_key, 0, 6) . '***' : '') }}">
                        <div class="mt-2">
                            <label class="form-label" style="font-size: 12px; color: #64748b;">Gemini Model</label>
                            <input type="text" name="gemini_model" class="form-control form-control-sm font-monospace" value="{{ old('gemini_model', $settings->gemini_model ?: 'gemini-1.5-flash') }}">
                        </div>
                    </div>
                </div>

                <!-- OpenAI Config -->
                <div class="col-md-6">
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px;">
                        <label class="form-label" style="font-weight: 700; font-size: 13px; color: #15803d;">
                            <i class="fas fa-robot text-success me-1"></i> OpenAI API Key
                        </label>
                        <input type="password" name="openai_api_key" class="form-control form-control-sm font-monospace" placeholder="{{ $settings->openai_api_key ? '••••••••••••••••••••••••••••' : 'sk-...' }}" value="{{ old('openai_api_key', $settings->openai_api_key ? substr($settings->openai_api_key, 0, 6) . '***' : '') }}">
                        <div class="mt-2">
                            <label class="form-label" style="font-size: 12px; color: #64748b;">OpenAI Model</label>
                            <input type="text" name="openai_model" class="form-control form-control-sm font-monospace" value="{{ old('openai_model', $settings->openai_model ?: 'gpt-4o-mini') }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Temperature (0.0 to 1.0)</label>
                    <input type="number" step="0.05" min="0" max="1" name="temperature" class="form-control" value="{{ old('temperature', $settings->temperature) }}">
                    <small class="text-muted" style="font-size: 12px;">Lower values (0.3-0.7) are more factual and consistent; higher values are more creative.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Max Output Tokens</label>
                    <input type="number" name="max_tokens" class="form-control" min="100" max="4000" value="{{ old('max_tokens', $settings->max_tokens) }}">
                </div>

                <div class="col-12">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">System Prompt & Business Instructions <span class="text-danger">*</span></label>
                    <textarea name="system_prompt" class="form-control font-monospace" rows="10" style="font-size: 13px;" required>{{ old('system_prompt', $settings->system_prompt) }}</textarea>
                    <small class="text-muted" style="font-size: 12px;">The RAG retrieval engine dynamically injects retrieved knowledge context chunks into this prompt on every request.</small>
                </div>
            </div>
        </div>

        <!-- 3. Multilingual Welcome Messages & Suggested Chips -->
        <div class="config-card">
            <div class="config-title">
                <i class="fa fa-comment-alt text-warning"></i> 3. Welcome Greetings & Suggested Quick Chips
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Welcome Message (English) <span class="text-danger">*</span></label>
                    <textarea name="welcome_msg_en" class="form-control" rows="3" required>{{ old('welcome_msg_en', $settings->welcome_msg_en) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">স্বাগতম বার্তা (বাংলা - Bangla) <span class="text-danger">*</span></label>
                    <textarea name="welcome_msg_bn" class="form-control" rows="3" required>{{ old('welcome_msg_bn', $settings->welcome_msg_bn) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Welcome Message (Banglish) <span class="text-danger">*</span></label>
                    <textarea name="welcome_msg_banglish" class="form-control" rows="3" required>{{ old('welcome_msg_banglish', $settings->welcome_msg_banglish) }}</textarea>
                </div>
                <div class="col-12">
                    @php
                        $chipsText = is_array($settings->suggested_chips) ? implode("\n", $settings->suggested_chips) : '';
                    @endphp
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Default Suggested Prompt Chips (1 per line)</label>
                    <textarea name="suggested_chips_text" class="form-control" rows="4">{{ old('suggested_chips_text', $chipsText) }}</textarea>
                </div>
            </div>
        </div>

        <!-- 4. Lead Capture & Direct Contact Routing -->
        <div class="config-card">
            <div class="config-title">
                <i class="fa fa-user-check text-info"></i> 4. Contact Details & Lead Capture
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">WhatsApp Number <span class="text-danger">*</span></label>
                    <input type="text" name="whatsapp_number" class="form-control" value="{{ old('whatsapp_number', $settings->whatsapp_number) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Support Email <span class="text-danger">*</span></label>
                    <input type="email" name="support_email" class="form-control" value="{{ old('support_email', $settings->support_email) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Helpline Phone</label>
                    <input type="text" name="support_phone" class="form-control" value="{{ old('support_phone', $settings->support_phone) }}">
                </div>
                <div class="col-md-6">
                    <div class="form-check form-switch p-2 ps-5 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <input class="form-check-input" type="checkbox" name="auto_capture_leads" id="autoCaptureLeads" value="1" {{ old('auto_capture_leads', $settings->auto_capture_leads) ? 'checked' : '' }}>
                        <label class="form-check-label" for="autoCaptureLeads" style="font-weight: 700; color: #0f172a;">
                            Auto-Detect & Sync Customer Phone/Email to Project Inquiries
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check form-switch p-2 ps-5 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <input class="form-check-input" type="checkbox" name="sound_enabled_by_default" id="soundDefault" value="1" {{ old('sound_enabled_by_default', $settings->sound_enabled_by_default) ? 'checked' : '' }}>
                        <label class="form-check-label" for="soundDefault" style="font-weight: 700; color: #0f172a;">
                            Enable Text-To-Speech Audio by Default
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-bottom: 50px;">
            <a href="{{ route('admin.ai-chatbot.dashboard') }}" class="btn btn-outline-secondary" style="border-radius: 8px;">Cancel</a>
            <button type="submit" class="btn btn-primary" style="background: #00d4aa; border-color: #00d4aa; color: #000; font-weight: 700; border-radius: 8px; padding: 10px 28px;">
                Save Bot Settings
            </button>
        </div>
    </form>
</div>
@endsection
