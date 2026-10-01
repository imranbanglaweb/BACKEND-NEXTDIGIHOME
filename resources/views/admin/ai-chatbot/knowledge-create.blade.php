@extends('admin.dashboard.master')

@section('title', 'Add Knowledge Chunk - ' . config('app.name'))

@section('main_content')
@include('admin.partials.premium-ui')

<div style="max-width: 960px; margin: 0 auto; font-family: 'Plus Jakarta Sans', sans-serif;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
        <div>
            <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0;">Add AI Knowledge Base Chunk</h1>
            <p style="font-size: 13.5px; color: #64748b; margin: 3px 0 0;">Create a new knowledge unit for RAG retrieval and automated responses.</p>
        </div>
        <a href="{{ route('admin.ai-chatbot.knowledge-base') }}" class="btn btn-outline-secondary" style="border-radius: 8px; font-size: 13px; font-weight: 600;">
            &larr; Back to Catalog
        </a>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger" style="border-radius: 10px;">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 26px; box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);">
        <form action="{{ route('admin.ai-chatbot.knowledge-base.store') }}" method="POST">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-8">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Title / Topic <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. ParkPulse 360™ - Smart Parking Management" value="{{ old('title') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Category <span class="text-danger">*</span></label>
                    <select name="category" class="form-select" required>
                        <option value="software_catalog" {{ old('category') == 'software_catalog' ? 'selected' : '' }}>Enterprise Software</option>
                        <option value="solutions" {{ old('category') == 'solutions' ? 'selected' : '' }}>NextDigi Solutions</option>
                        <option value="pricing" {{ old('category') == 'pricing' ? 'selected' : '' }}>Pricing & Quotation</option>
                        <option value="company" {{ old('category') == 'company' ? 'selected' : '' }}>Company & Contact</option>
                        <option value="faq" {{ old('category') == 'faq' ? 'selected' : '' }}>General FAQ</option>
                        <option value="custom" {{ old('category') == 'custom' ? 'selected' : '' }}>Custom Knowledge</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Search Triggers & Keywords (Comma-separated in English, Bangla & Banglish)</label>
                <input type="text" name="keywords" class="form-control" placeholder="e.g. parking, anpr, car parking, barrier, gari parking, parking erp, barrier gate" value="{{ old('keywords') }}">
                <small class="text-muted" style="font-size: 12px;">Add phonetics and common misspellings to guarantee high match accuracy.</small>
            </div>

            <!-- Multilingual Content Tabs -->
            <div class="mb-3">
                <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Answer / Knowledge Content (Markdown supported)</label>
                <ul class="nav nav-tabs" id="langTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="en-tab" data-bs-toggle="tab" data-bs-target="#en-content" type="button" role="tab" style="font-weight: 600;">English <span class="text-danger">*</span></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bn-tab" data-bs-toggle="tab" data-bs-target="#bn-content" type="button" role="tab" style="font-weight: 600;">বাংলা (Bangla)</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bg-tab" data-bs-toggle="tab" data-bs-target="#bg-content" type="button" role="tab" style="font-weight: 600;">Banglish</button>
                    </li>
                </ul>
                <div class="tab-content border border-top-0 rounded-bottom p-3" id="langTabsContent" style="background: #fafafa;">
                    <div class="tab-pane fade show active" id="en-content" role="tabpanel">
                        <textarea name="content_en" class="form-control" rows="8" placeholder="English detailed answer or feature specifications..." required>{{ old('content_en') }}</textarea>
                    </div>
                    <div class="tab-pane fade" id="bn-content" role="tabpanel">
                        <textarea name="content_bn" class="form-control" rows="8" placeholder="বাংলা বিস্তারিত বিবরণ ও উত্তর...">{{ old('content_bn') }}</textarea>
                    </div>
                    <div class="tab-pane fade" id="bg-content" role="tabpanel">
                        <textarea name="content_banglish" class="form-control" rows="8" placeholder="Banglish detailed reply with bullet points...">{{ old('content_banglish') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Follow-up suggested questions -->
            <div class="mb-3">
                <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Suggested Follow-Up Chips (1 per line)</label>
                <textarea name="suggested_questions" class="form-control" rows="3" placeholder="How much does it cost?&#10;Can I see a live demo?&#10;Talk with support on WhatsApp">{{ old('suggested_questions') }}</textarea>
            </div>

            <!-- Actions and Priority -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #334155;">Priority Rank (0 to 10)</label>
                    <input type="number" name="priority" class="form-control" min="0" max="10" value="{{ old('priority', 5) }}">
                    <small class="text-muted" style="font-size: 12px;">Higher numbers take precedence when matching ambiguous questions.</small>
                </div>
                <div class="col-md-6 d-flex align-items-center pt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActiveCheck" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActiveCheck" style="font-weight: 700; font-size: 13px; color: #334155;">
                            Publish this Knowledge Chunk to AI Agent immediately
                        </label>
                    </div>
                </div>
            </div>

            <div style="border-top: 1px solid #e2e8f0; padding-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
                <a href="{{ route('admin.ai-chatbot.knowledge-base') }}" class="btn btn-outline-secondary" style="border-radius: 8px;">Cancel</a>
                <button type="submit" class="btn btn-primary" style="background: #00d4aa; border-color: #00d4aa; color: #000; font-weight: 700; border-radius: 8px; padding: 8px 24px;">
                    Save Knowledge Chunk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
