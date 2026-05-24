@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 30px 0;">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1">
                            <i class="fas fa-search me-3"></i>SEO Settings
                        </h2>
                        <p class="text-white-50 mb-0">Optimize your site for search engines and improve visibility</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light" onclick="runSeoAudit()">
                            <i class="fas fa-search-plus me-2"></i>Run SEO Audit
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO Overview Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-search text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">85</h3>
                        <p class="text-muted mb-0">SEO Score</p>
                        <small class="text-success">+5 this month</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-link text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">1,247</h3>
                        <p class="text-muted mb-0">Backlinks</p>
                        <small class="text-info">+23 this week</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-keyboard text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">456</h3>
                        <p class="text-muted mb-0">Keywords</p>
                        <small class="text-warning">12 optimized</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-chart-line text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">23</h3>
                        <p class="text-muted mb-0">Indexed Pages</p>
                        <small class="text-primary">+3 this month</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO Settings Tabs -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <ul class="nav nav-tabs card-header-tabs" id="seoTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">General</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="meta-tab" data-bs-toggle="tab" data-bs-target="#meta" type="button" role="tab">Meta Tags</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="sitemap-tab" data-bs-toggle="tab" data-bs-target="#sitemap" type="button" role="tab">Sitemap</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="analytics-tab" data-bs-toggle="tab" data-bs-target="#analytics" type="button" role="tab">Analytics</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="seoTabContent">
                            <!-- General SEO Settings -->
                            <div class="tab-pane fade show active" id="general" role="tabpanel">
                                <h5 class="mb-3">General SEO Settings</h5>
                                <form id="seoGeneralForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="seo_section" value="general">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">SEO Meta Title</label>
                                            <input type="text" class="form-control" name="seo_meta_title" value="{{ $settings->seo_meta_title ?? 'Next Digi Home - Premium Digital Products Marketplace' }}">
                                            <small class="text-muted">Recommended: 50-60 characters</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">SEO Meta Description</label>
                                            <textarea class="form-control" name="seo_meta_description" rows="2">{{ $settings->seo_meta_description ?? 'Discover premium digital products, software, templates and courses at Next Digi Home.' }}</textarea>
                                            <small class="text-muted">Recommended: 150-160 characters</small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Default Meta Keywords</label>
                                            <input type="text" class="form-control" name="seo_meta_keywords" value="{{ $settings->seo_meta_keywords ?? 'digital products, software, templates, marketplace, online courses' }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Robots Meta Tag</label>
                                            <select class="form-select" name="robots_meta">
                                                <option value="index, follow" {{ ($settings->robots_meta ?? 'index, follow') == 'index, follow' ? 'selected' : '' }}>index, follow</option>
                                                <option value="noindex, follow" {{ ($settings->robots_meta ?? '') == 'noindex, follow' ? 'selected' : '' }}>noindex, follow</option>
                                                <option value="index, nofollow" {{ ($settings->robots_meta ?? '') == 'index, nofollow' ? 'selected' : '' }}>index, nofollow</option>
                                                <option value="noindex, nofollow" {{ ($settings->robots_meta ?? '') == 'noindex, nofollow' ? 'selected' : '' }}>noindex, nofollow</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Canonical URL</label>
                                            <input type="url" class="form-control" name="canonical_url" value="{{ $settings->canonical_url ?? 'https://nextdigihome.com' }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check mt-4">
                                                <input class="form-check-input" type="checkbox" id="seo_enabled" name="seo_enabled" value="1" {{ ($settings->seo_enabled ?? 1) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="seo_enabled">
                                                    Enable SEO for Frontend Site
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" onclick="saveSeoSettings('seoGeneralForm')" class="btn btn-primary">Save General SEO</button>
                                        <button type="button" onclick="resetForm(this)" class="btn btn-outline-secondary">Reset</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Social Media / OG Tags -->
                            <div class="tab-pane fade" id="meta" role="tabpanel">
                                <h5 class="mb-3">Open Graph & Social Media Tags</h5>
                                <form id="seoSocialForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">OG Title</label>
                                            <input type="text" class="form-control" name="seo_og_title" value="{{ $settings->seo_og_title ?? ($settings->seo_meta_title ?? '') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">OG Description</label>
                                            <textarea class="form-control" name="seo_og_description" rows="2">{{ $settings->seo_og_description ?? ($settings->seo_meta_description ?? '') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">OG Image (1200x630 recommended)</label>
                                            @if(!empty($settings->seo_og_image))
                                                <div class="mb-2">
                                                    <img src="{{ asset('public/admin_resource/assets/images/'.$settings->seo_og_image) }}" alt="OG Image" class="img-thumbnail" style="max-height: 120px;">
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" name="seo_og_image" accept="image/*">
                                            <small class="text-muted">Used for Facebook, LinkedIn shares etc.</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Twitter Card Title</label>
                                            <input type="text" class="form-control" name="seo_twitter_title" value="{{ $settings->seo_twitter_title ?? ($settings->seo_meta_title ?? '') }}">
                                            <label class="form-label mt-2">Twitter Description</label>
                                            <textarea class="form-control" name="seo_twitter_description" rows="2">{{ $settings->seo_twitter_description ?? ($settings->seo_meta_description ?? '') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Twitter Image (1200x600)</label>
                                            @if(!empty($settings->seo_twitter_image))
                                                <div class="mb-2">
                                                    <img src="{{ asset('public/admin_resource/assets/images/'.$settings->seo_twitter_image) }}" alt="Twitter Image" class="img-thumbnail" style="max-height: 100px;">
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" name="seo_twitter_image" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" onclick="saveSeoSettings('seoSocialForm')" class="btn btn-primary">Save Social SEO</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Sitemap Settings -->
                            <div class="tab-pane fade" id="sitemap" role="tabpanel">
                                <h5 class="mb-3">XML Sitemap Configuration</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card border">
                                            <div class="card-body">
                                                <h6>Sitemap Status</h6>
                                                <p class="text-success mb-2"><i class="fas fa-check-circle me-2"></i>Sitemap Generated</p>
                                                <p class="mb-2">Last Updated: 2024-01-15 14:30</p>
                                                <p class="mb-0">Total URLs: 247</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border">
                                            <div class="card-body">
                                                <h6>Sitemap URL</h6>
                                                <input type="text" class="form-control mb-2" value="https://nextdigihome.com/sitemap.xml" readonly>
                                                <button class="btn btn-outline-primary btn-sm">Copy URL</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <h6>Included Content Types</h6>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Pages</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Products</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" checked>
                                                <label class="form-check-label">Categories</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox">
                                                <label class="form-check-label">Blog Posts</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary">Regenerate Sitemap</button>
                                    <button class="btn btn-outline-secondary ms-2">Submit to Search Engines</button>
                                </div>
                            </div>

                            <!-- Analytics Settings -->
                            <div class="tab-pane fade" id="analytics" role="tabpanel">
                                <h5 class="mb-3">Analytics & Tracking</h5>
                                <form id="seoAnalyticsForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Google Analytics ID (GA4)</label>
                                            <input type="text" class="form-control" name="google_analytics_id" value="{{ $settings->google_analytics_id ?? '' }}" placeholder="G-XXXXXXXXXX">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Google Search Console Verification</label>
                                            <input type="text" class="form-control" name="google_search_console_verification" value="{{ $settings->google_search_console_verification ?? '' }}" placeholder="Verification meta content">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Bing Webmaster Tools Verification</label>
                                            <input type="text" class="form-control" name="bing_webmaster_verification" value="{{ $settings->bing_webmaster_verification ?? '' }}" placeholder="Verification code">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Custom Head Scripts (e.g. verification pixels)</label>
                                            <textarea class="form-control" name="custom_head_scripts" rows="3" placeholder="Paste additional meta tags or scripts here (will be output in <head>)">{{ $settings->custom_head_scripts ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" onclick="saveSeoSettings('seoAnalyticsForm')" class="btn btn-primary">Save Analytics Settings</button>
                                        <button type="button" onclick="testTracking()" class="btn btn-outline-info">Test Tracking Code</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function runSeoAudit() {
    const btn = event.currentTarget;
    Swal.fire({
        title: 'SEO Audit',
        text: 'SEO Audit feature coming soon! This will analyze your site for SEO improvements.',
        icon: 'info',
        confirmButtonText: 'OK'
    });
}

function saveSeoSettings(formId) {
    const form = document.getElementById(formId);
    if (!form) {
        console.error('Form not found:', formId);
        return;
    }

    const formData = new FormData(form);
    const url = '{{ route("admin.marketing.seo.update") }}';

    // Show loading
    const submitBtns = form.querySelectorAll('button[type="button"]');
    submitBtns.forEach(btn => btn.disabled = true);

    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message || 'SEO settings saved successfully.',
                timer: 2000,
                showConfirmButton: false
            });
            // Optionally reload to show updated images etc.
            setTimeout(() => location.reload(), 1500);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to save settings.'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An unexpected error occurred while saving SEO settings.'
        });
    })
    .finally(() => {
        submitBtns.forEach(btn => btn.disabled = false);
    });
}

function resetForm(element) {
    const form = element.closest('form');
    if (form) form.reset();
}

function testTracking() {
    Swal.fire({
        title: 'Testing Tracking',
        text: 'In a real implementation this would validate your Google Analytics / Search Console setup.',
        icon: 'info'
    });
}

// Enable tab persistence if needed
document.addEventListener('DOMContentLoaded', function() {
    // Any init code
    console.log('%c[SEO] Frontend SEO Management panel initialized', 'color:#667eea');
});
</script>
@endsection