@php
    $contentItem = $pageContent;
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="page">Page <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="page" name="page" value="{{ old('page', $contentItem->page ?? '') }}" placeholder="home" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="section">Section <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="section" name="section" value="{{ old('section', $contentItem->section ?? '') }}" placeholder="hero" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $contentItem->title ?? '') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="subtitle">Subtitle</label>
            <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ old('subtitle', $contentItem->subtitle ?? '') }}">
        </div>
    </div>
</div>

<div class="form-group">
    <label for="content">Content</label>
    <textarea class="form-control" id="content" name="content" rows="8">{{ old('content', $contentItem->content ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            @if($contentItem && $contentItem->image)
                <small class="form-text text-muted">Current image: {{ $contentItem->image }}</small>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="sort_order">Sort Order</label>
            <input type="number" class="form-control" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $contentItem->sort_order ?? 0) }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="link_text">Link Text</label>
            <input type="text" class="form-control" id="link_text" name="link_text" value="{{ old('link_text', $contentItem->link_text ?? '') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="link_url">Link URL</label>
            <input type="url" class="form-control" id="link_url" name="link_url" value="{{ old('link_url', $contentItem->link_url ?? '') }}" placeholder="https://example.com/page">
        </div>
    </div>
</div>

<div class="form-group">
    <input type="hidden" name="is_active" value="0">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $contentItem->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
    </div>
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save me-2"></i>{{ $submitLabel }}
    </button>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancel</a>
</div>
