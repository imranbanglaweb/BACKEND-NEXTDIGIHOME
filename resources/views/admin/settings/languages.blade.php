@extends('admin.dashboard.master')

@section('title', 'Languages Settings')

@section('main_content')
@include('admin.partials.premium-ui')
<section role="main" class="content-body premium-page premium-form">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-language"></i> Language Management
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Language Settings:</strong> Configure multilingual support, translation settings, and language preferences.
                    </div>

                    <form id="languageSettingsForm">
                        @csrf
                        <div class="row">
                            <!-- Language Configuration -->
                            <div class="col-md-8">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h5 class="card-title">Language Configuration</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="default_language">Default Language *</label>
                                            <select class="form-control" id="default_language" name="default_language" required>
                                                @foreach($languages as $lang)
                                                    <option value="{{ $lang->code }}"
                                                            {{ ($settings->default_language ?? 'en') == $lang->code ? 'selected' : '' }}>
                                                        {{ $lang->native_name }} ({{ strtoupper($lang->code) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted">This will be the fallback language for untranslated content</small>
                                        </div>

                                        <div class="form-group">
                                            <label>Available Languages</label>
                                            <div class="border rounded p-3 bg-light">
                                                @php
                                                    $availableLanguages = json_decode($settings->available_languages ?? '["en"]', true);
                                                @endphp
                                                @foreach($languages as $lang)
                                                    <div class="form-check d-inline-block me-4 mb-2">
                                                        <input class="form-check-input" type="checkbox"
                                                               name="available_languages[]" value="{{ $lang->code }}"
                                                               id="lang_{{ $lang->code }}"
                                                               {{ in_array($lang->code, $availableLanguages) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="lang_{{ $lang->code }}">
                                                            <span class="flag-icon flag-icon-{{ strtolower($lang->flag_icon ?? 'us') }} me-1"></span>
                                                            {{ $lang->native_name }} ({{ strtoupper($lang->code) }})
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small class="form-text text-muted">Select which languages users can choose from</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Translation Settings -->
                            <div class="col-md-4">
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h5 class="card-title">Translation Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox"
                                                   name="auto_translate" value="1" id="auto_translate"
                                                   {{ ($settings->auto_translate ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="auto_translate">
                                                <strong>Enable Auto Translation</strong>
                                            </label>
                                            <small class="form-text text-muted d-block">Automatically translate new content using Google Translate API</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="translation_cache_duration">Cache Duration (hours)</label>
                                            <input type="number" class="form-control" id="translation_cache_duration"
                                                   name="translation_cache_duration" min="1" max="168"
                                                   value="{{ $settings->translation_cache_duration ?? 24 }}">
                                            <small class="form-text text-muted">How long to cache translations</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="translation_service">Translation Service</label>
                                            <select class="form-control" id="translation_service" name="translation_service">
                                                <option value="google" {{ ($settings->translation_service ?? 'google') == 'google' ? 'selected' : '' }}>Google Translate</option>
                                                <option value="azure" {{ ($settings->translation_service ?? '') == 'azure' ? 'selected' : '' }}>Azure Translator</option>
                                                <option value="deepl" {{ ($settings->translation_service ?? '') == 'deepl' ? 'selected' : '' }}>DeepL</option>
                                                <option value="manual" {{ ($settings->translation_service ?? '') == 'manual' ? 'selected' : '' }}>Manual Only</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Language Statistics -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h5 class="card-title">Language Statistics</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="info-box bg-light">
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Total Languages</span>
                                                        <span class="info-box-number">{{ $languages->count() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="info-box bg-light">
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Active Languages</span>
                                                        <span class="info-box-number">
                                                            @php
                                                                $availableLanguages = json_decode($settings->available_languages ?? '["en"]', true);
                                                                echo count($availableLanguages);
                                                            @endphp
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="info-box bg-light">
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Default Language</span>
                                                        <span class="info-box-number">
                                                            @php
                                                                $defaultLang = $languages->where('code', $settings->default_language ?? 'en')->first();
                                                                echo $defaultLang ? $defaultLang->native_name : 'English';
                                                            @endphp
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="info-box bg-light">
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Cache Status</span>
                                                        <span class="info-box-number">
                                                            @if(Cache::has('translations'))
                                                                <span class="badge badge-success">Cached</span>
                                                            @else
                                                                <span class="badge badge-warning">Empty</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h5 class="card-title">Quick Actions</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex gap-2 flex-wrap">
                                            <button type="button" class="btn btn-outline-primary" onclick="clearTranslationCache()">
                                                <i class="fas fa-trash"></i> Clear Translation Cache
                                            </button>
                                            <button type="button" class="btn btn-outline-info" onclick="syncLanguages()">
                                                <i class="fas fa-sync"></i> Sync Languages
                                            </button>
                                            <a href="{{ route('admin.translations') }}" class="btn btn-outline-secondary" target="_blank">
                                                <i class="fas fa-list"></i> Manage Translations
                                            </a>
                                            <button type="button" class="btn btn-outline-success" onclick="testTranslations()">
                                                <i class="fas fa-vial"></i> Test Translations
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> Save Language Settings
                                </button>
                                <button type="button" class="btn btn-secondary btn-lg ml-2" onclick="resetForm()">
                                    <i class="fas fa-undo"></i> Reset Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#languageSettingsForm').submit(function(e) {
    e.preventDefault();

    let submitBtn = $(this).find('button[type="submit"]');
    let originalText = submitBtn.html();

    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

    $.ajax({
        type: 'POST',
        url: '{{ route("admin.settings.languages.update") }}',
        data: $(this).serialize(),
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
            } else {
                toastr.error('Failed to save language settings');
            }
        },
        error: function(xhr) {
            let errors = xhr.responseJSON?.errors || ['An error occurred'];
            errors.forEach(error => toastr.error(error));
        },
        complete: function() {
            submitBtn.prop('disabled', false).html(originalText);
        }
    });
});

function clearTranslationCache() {
    if (!confirm('Are you sure you want to clear the translation cache? This may temporarily slow down the site.')) {
        return;
    }

    $.ajax({
        type: 'POST',
        url: '{{ route("admin.language.clear-cache") }}',
        data: { _token: '{{ csrf_token() }}' },
        success: function(response) {
            toastr.success('Translation cache cleared successfully');
            setTimeout(() => location.reload(), 1000);
        },
        error: function() {
            toastr.error('Failed to clear translation cache');
        }
    });
}

function syncLanguages() {
    if (!confirm('Are you sure you want to sync languages with the database?')) {
        return;
    }

    $.ajax({
        type: 'POST',
        url: '{{ route("admin.language.sync") }}',
        data: { _token: '{{ csrf_token() }}' },
        success: function(response) {
            toastr.success('Languages synchronized successfully');
            setTimeout(() => location.reload(), 1000);
        },
        error: function() {
            toastr.error('Failed to sync languages');
        }
    });
}

function testTranslations() {
    // Simple translation test
    toastr.info('Translation testing feature coming soon');
}

function resetForm() {
    if (confirm('Are you sure you want to reset all changes?')) {
        $('#languageSettingsForm')[0].reset();
    }
}
</script>
</section>
@endsection
