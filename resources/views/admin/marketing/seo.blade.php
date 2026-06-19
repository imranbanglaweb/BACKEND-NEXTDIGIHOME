@extends('admin.dashboard.master')

@section('main_content')
@php
    $settings = $settings ?? (object) [];
    $siteTitle = $settings->site_title ?? $settings->admin_title ?? 'Next Digi Home';
    $metaTitle = $settings->seo_meta_title ?? $siteTitle;
    $metaDescription = $settings->seo_meta_description ?? $settings->site_description ?? 'Premium digital products, software, templates and online resources.';
    $canonicalUrl = $settings->canonical_url ?? url('/');
    $ogTitle = $settings->seo_og_title ?? $metaTitle;
    $ogDescription = $settings->seo_og_description ?? $metaDescription;
    $twitterTitle = $settings->seo_twitter_title ?? $metaTitle;
    $twitterDescription = $settings->seo_twitter_description ?? $metaDescription;
    $focusKeyword = $settings->seo_focus_keyword ?? '';
    $secondaryKeywords = $settings->seo_secondary_keywords ?? '';
    $contentScoreTarget = $settings->seo_content_score_target ?? 85;
    $schemaType = $settings->schema_type ?? 'Organization';
@endphp

@include('admin.marketing.partials.premium-styles')

<section role="main" class="content-body marketing-page seo-page">
    <div class="container-fluid">
        <div class="marketing-header seo-header">
            <div>
                <div class="marketing-eyebrow seo-eyebrow">Marketing</div>
                <h2>SEO Settings</h2>
                <p>Manage metadata, keyword focus, schema, sitemaps, search verification, and audit-tool integrations.</p>
            </div>
            <div class="marketing-header-actions seo-header-actions">
                <button type="button" class="btn btn-light" id="auditBtn">
                    <i class="fas fa-search-plus me-2"></i>Check SEO
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-xl-3 col-md-6">
                <div class="seo-stat-card">
                    <span class="stat-icon stat-green"><i class="fas fa-toggle-on"></i></span>
                    <div>
                        <small>SEO Status</small>
                        <strong>{{ ($settings->seo_enabled ?? 1) ? 'Enabled' : 'Disabled' }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="seo-stat-card">
                    <span class="stat-icon stat-blue"><i class="fas fa-heading"></i></span>
                    <div>
                        <small>Title Length</small>
                        <strong><span id="titleStat">{{ strlen($metaTitle) }}</span> chars</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="seo-stat-card">
                    <span class="stat-icon stat-amber"><i class="fas fa-align-left"></i></span>
                    <div>
                        <small>Description Length</small>
                        <strong><span id="descriptionStat">{{ strlen($metaDescription) }}</span> chars</strong>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="seo-stat-card">
                    <span class="stat-icon stat-cyan"><i class="fas fa-chart-line"></i></span>
                    <div>
                        <small>Tracking</small>
                        <strong>{{ !empty($settings->google_analytics_id) ? 'Configured' : 'Not Set' }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <form id="seoSettingsForm" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-xl-8">
                    <div class="seo-panel mb-3">
                        <div class="seo-panel-title">
                            <div>
                                <h5>Search Result Metadata</h5>
                                <p>These values are used as the default title, description, robots rule, and canonical URL.</p>
                            </div>
                            <div class="form-check form-switch seo-switch">
                                <input class="form-check-input" type="checkbox" id="seo_enabled" name="seo_enabled" value="1" {{ ($settings->seo_enabled ?? 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="seo_enabled">Enable SEO</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="seo_meta_title">Meta Title</label>
                                <small class="counter" data-counter-for="seo_meta_title">0 / 60</small>
                            </div>
                            <input type="text" class="form-control" id="seo_meta_title" name="seo_meta_title" maxlength="70" value="{{ $metaTitle }}" placeholder="Example: Next Digi Home - Premium Digital Products">
                            <small class="text-muted">Best range: 50-60 characters.</small>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="seo_meta_description">Meta Description</label>
                                <small class="counter" data-counter-for="seo_meta_description">0 / 160</small>
                            </div>
                            <textarea class="form-control" id="seo_meta_description" name="seo_meta_description" rows="3" maxlength="180" placeholder="Short search result description">{{ $metaDescription }}</textarea>
                            <small class="text-muted">Best range: 150-160 characters.</small>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="seo_meta_keywords">Meta Keywords</label>
                                <input type="text" class="form-control" id="seo_meta_keywords" name="seo_meta_keywords" value="{{ $settings->seo_meta_keywords ?? '' }}" placeholder="digital products, software, templates">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="robots_meta">Robots Meta</label>
                                <select class="form-control" id="robots_meta" name="robots_meta">
                                    <option value="index, follow" {{ ($settings->robots_meta ?? 'index, follow') == 'index, follow' ? 'selected' : '' }}>Index, Follow</option>
                                    <option value="noindex, follow" {{ ($settings->robots_meta ?? '') == 'noindex, follow' ? 'selected' : '' }}>Noindex, Follow</option>
                                    <option value="index, nofollow" {{ ($settings->robots_meta ?? '') == 'index, nofollow' ? 'selected' : '' }}>Index, Nofollow</option>
                                    <option value="noindex, nofollow" {{ ($settings->robots_meta ?? '') == 'noindex, nofollow' ? 'selected' : '' }}>Noindex, Nofollow</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="canonical_url">Canonical URL</label>
                                <input type="url" class="form-control" id="canonical_url" name="canonical_url" value="{{ $canonicalUrl }}" placeholder="https://example.com">
                            </div>
                        </div>
                    </div>

                    <div class="seo-panel mb-3">
                        <div class="seo-panel-title">
                            <div>
                                <span class="seo-tool-badge"><i class="fas fa-feather-alt"></i> Yoast-style optimization</span>
                                <h5>Content Focus & Readability</h5>
                                <p>Set the primary keyword, related terms, and content quality targets used by your audit checklist.</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="seo_focus_keyword">Focus Keyphrase</label>
                                <input type="text" class="form-control" id="seo_focus_keyword" name="seo_focus_keyword" value="{{ $focusKeyword }}" placeholder="best digital products marketplace">
                                <small class="text-muted">Used to evaluate title, description, and snippet relevance.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="seo_content_score_target">SEO Score Target</label>
                                <input type="number" class="form-control" id="seo_content_score_target" name="seo_content_score_target" min="0" max="100" value="{{ $contentScoreTarget }}" placeholder="85">
                                <small class="text-muted">Common target range: 80-90.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="seo_readability_target">Readability Target</label>
                                <select class="form-control" id="seo_readability_target" name="seo_readability_target">
                                    @foreach(['Easy', 'Standard', 'Advanced', 'Technical'] as $level)
                                        <option value="{{ $level }}" {{ ($settings->seo_readability_target ?? 'Standard') === $level ? 'selected' : '' }}>{{ $level }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="seo_secondary_keywords">Secondary Keywords</label>
                                <textarea class="form-control" id="seo_secondary_keywords" name="seo_secondary_keywords" rows="3" placeholder="software templates, online resources, premium downloads">{{ $secondaryKeywords }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="seo-panel mb-3">
                        <div class="seo-panel-title">
                            <div>
                                <h5>Social Sharing</h5>
                                <p>Control how links appear on Facebook, LinkedIn, X, and messaging apps.</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="seo_og_title">Open Graph Title</label>
                                <input type="text" class="form-control" id="seo_og_title" name="seo_og_title" maxlength="95" value="{{ $ogTitle }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="seo_twitter_title">Twitter Card Title</label>
                                <input type="text" class="form-control" id="seo_twitter_title" name="seo_twitter_title" maxlength="95" value="{{ $twitterTitle }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="seo_og_description">Open Graph Description</label>
                                <textarea class="form-control" id="seo_og_description" name="seo_og_description" rows="3" maxlength="220">{{ $ogDescription }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="seo_twitter_description">Twitter Card Description</label>
                                <textarea class="form-control" id="seo_twitter_description" name="seo_twitter_description" rows="3" maxlength="220">{{ $twitterDescription }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="seo_og_image">Open Graph Image</label>
                                <div class="image-preview" id="ogPreview">
                                    @if(!empty($settings->seo_og_image))
                                        <img src="{{ asset('public/admin_resource/assets/images/'.$settings->seo_og_image) }}" alt="Open Graph image">
                                    @else
                                        <span>No image uploaded</span>
                                    @endif
                                </div>
                                <input type="file" class="form-control" id="seo_og_image" name="seo_og_image" accept="image/*">
                                <small class="text-muted">Recommended: 1200x630, JPG/WebP/PNG.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="seo_twitter_image">Twitter Card Image</label>
                                <div class="image-preview" id="twitterPreview">
                                    @if(!empty($settings->seo_twitter_image))
                                        <img src="{{ asset('public/admin_resource/assets/images/'.$settings->seo_twitter_image) }}" alt="Twitter card image">
                                    @else
                                        <span>No image uploaded</span>
                                    @endif
                                </div>
                                <input type="file" class="form-control" id="seo_twitter_image" name="seo_twitter_image" accept="image/*">
                                <small class="text-muted">Recommended: 1200x600, JPG/WebP/PNG.</small>
                            </div>
                        </div>
                    </div>

                    <div class="seo-panel">
                        <div class="seo-panel-title">
                            <div>
                                <h5>Analytics & Verification</h5>
                                <p>Add tracking IDs, search console tokens, and custom head scripts for the frontend.</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="google_analytics_id">Google Analytics ID</label>
                                <input type="text" class="form-control" id="google_analytics_id" name="google_analytics_id" value="{{ $settings->google_analytics_id ?? '' }}" placeholder="G-XXXXXXXXXX">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="google_search_console_verification">Google Search Console Verification</label>
                                <input type="text" class="form-control" id="google_search_console_verification" name="google_search_console_verification" value="{{ $settings->google_search_console_verification ?? '' }}" placeholder="Verification content value">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="bing_webmaster_verification">Bing Webmaster Verification</label>
                                <input type="text" class="form-control" id="bing_webmaster_verification" name="bing_webmaster_verification" value="{{ $settings->bing_webmaster_verification ?? '' }}" placeholder="Verification code">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="custom_head_scripts">Custom Head Scripts</label>
                                <textarea class="form-control code-field" id="custom_head_scripts" name="custom_head_scripts" rows="5" placeholder="Paste trusted meta tags or analytics scripts">{{ $settings->custom_head_scripts ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="seo-panel mt-3">
                        <div class="seo-panel-title">
                            <div>
                                <span class="seo-tool-badge"><i class="fas fa-plug"></i> Semrush / Ahrefs / technical SEO</span>
                                <h5>Schema, Sitemap & Audit Integrations</h5>
                                <p>Configure structured data, crawler files, and links to your external SEO tools.</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="schema_type">Default Schema Type</label>
                                <select class="form-control" id="schema_type" name="schema_type">
                                    @foreach(['Organization', 'LocalBusiness', 'WebSite', 'Store', 'SoftwareApplication', 'Product', 'Course'] as $type)
                                        <option value="{{ $type }}" {{ $schemaType === $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="organization_name">Organization Name</label>
                                <input type="text" class="form-control" id="organization_name" name="organization_name" value="{{ $settings->organization_name ?? $siteTitle }}" placeholder="Next Digi Home">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="organization_phone">Organization Phone</label>
                                <input type="text" class="form-control" id="organization_phone" name="organization_phone" value="{{ $settings->organization_phone ?? '' }}" placeholder="+880 1XXX XXXXXX">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="sitemap_url">XML Sitemap URL</label>
                                <input type="url" class="form-control" id="sitemap_url" name="sitemap_url" value="{{ $settings->sitemap_url ?? url('/sitemap.xml') }}" placeholder="https://example.com/sitemap.xml">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="organization_address">Organization Address</label>
                                <textarea class="form-control" id="organization_address" name="organization_address" rows="2" placeholder="Street, city, region, country">{{ $settings->organization_address ?? '' }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="robots_txt_rules">Robots.txt Rules</label>
                                <textarea class="form-control code-field" id="robots_txt_rules" name="robots_txt_rules" rows="4" placeholder="User-agent: *&#10;Allow: /&#10;Sitemap: https://example.com/sitemap.xml">{{ $settings->robots_txt_rules ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="semrush_project_url">Semrush Project URL</label>
                                <input type="url" class="form-control" id="semrush_project_url" name="semrush_project_url" value="{{ $settings->semrush_project_url ?? '' }}" placeholder="https://www.semrush.com/projects/...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="semrush_api_key">Semrush API Key</label>
                                <input type="password" class="form-control" id="semrush_api_key" name="semrush_api_key" value="{{ $settings->semrush_api_key ?? '' }}" placeholder="Paste API key">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="ahrefs_site_audit_url">Ahrefs Site Audit URL</label>
                                <input type="url" class="form-control" id="ahrefs_site_audit_url" name="ahrefs_site_audit_url" value="{{ $settings->ahrefs_site_audit_url ?? '' }}" placeholder="https://app.ahrefs.com/site-audit/...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="facebook_domain_verification">Facebook Domain Verification</label>
                                <input type="text" class="form-control" id="facebook_domain_verification" name="facebook_domain_verification" value="{{ $settings->facebook_domain_verification ?? '' }}" placeholder="Meta verification content">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="pinterest_domain_verification">Pinterest Verification</label>
                                <input type="text" class="form-control" id="pinterest_domain_verification" name="pinterest_domain_verification" value="{{ $settings->pinterest_domain_verification ?? '' }}" placeholder="Pinterest verification content">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="seo-panel sticky-preview">
                        <div class="seo-panel-title">
                            <div>
                                <h5>Live Preview</h5>
                                <p>Preview search and social snippets before saving.</p>
                            </div>
                        </div>

                        <div class="preview-block">
                            <div class="preview-label">Google Result</div>
                            <div class="google-preview">
                                <div class="preview-url" id="previewUrl">{{ $canonicalUrl }}</div>
                                <div class="preview-title" id="previewTitle">{{ $metaTitle }}</div>
                                <div class="preview-description" id="previewDescription">{{ $metaDescription }}</div>
                            </div>
                        </div>

                        <div class="preview-block">
                            <div class="preview-label">Social Card</div>
                            <div class="social-preview">
                                <div class="social-image" id="socialImagePreview">
                                    @if(!empty($settings->seo_og_image))
                                        <img src="{{ asset('public/admin_resource/assets/images/'.$settings->seo_og_image) }}" alt="Social preview image">
                                    @else
                                        <i class="fas fa-image"></i>
                                    @endif
                                </div>
                                <div class="social-body">
                                    <strong id="previewOgTitle">{{ $ogTitle }}</strong>
                                    <p id="previewOgDescription">{{ $ogDescription }}</p>
                                    <span>{{ parse_url($canonicalUrl, PHP_URL_HOST) ?: request()->getHost() }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="seo-checklist" id="seoChecklist">
                            <div class="check-item" data-check="title"><i class="fas fa-circle"></i><span>Meta title length is in the recommended range.</span></div>
                            <div class="check-item" data-check="description"><i class="fas fa-circle"></i><span>Meta description length is in the recommended range.</span></div>
                            <div class="check-item" data-check="canonical"><i class="fas fa-circle"></i><span>Canonical URL is configured.</span></div>
                            <div class="check-item" data-check="social"><i class="fas fa-circle"></i><span>Social title and description are configured.</span></div>
                            <div class="check-item" data-check="analytics"><i class="fas fa-circle"></i><span>Google Analytics ID is configured.</span></div>
                            <div class="check-item" data-check="keyword"><i class="fas fa-circle"></i><span>Focus keyphrase appears in title or description.</span></div>
                            <div class="check-item" data-check="schema"><i class="fas fa-circle"></i><span>Structured data schema is selected.</span></div>
                            <div class="check-item" data-check="sitemap"><i class="fas fa-circle"></i><span>XML sitemap URL is configured.</span></div>
                        </div>

                        <div class="seo-actions">
                            <button type="submit" class="btn btn-primary w-100" id="saveSeoBtn">
                                <i class="fas fa-save me-2"></i>Save SEO Settings
                            </button>
                            <button type="button" class="btn btn-outline-secondary w-100" id="resetSeoBtn">
                                <i class="fas fa-undo me-2"></i>Reset Form
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<style>
    .seo-page {
        background: #f4f7fb;
        color: #172033;
        font-size: 14px;
        min-height: calc(100vh - 70px);
        padding: 24px;
    }

    .seo-header {
        align-items: center;
        background: linear-gradient(135deg, #0f172a 0%, #123047 58%, #0f766e 100%);
        border-radius: 8px;
        box-shadow: 0 24px 70px rgba(15, 23, 42, .2);
        color: #fff;
        display: flex;
        justify-content: space-between;
        margin-bottom: 18px;
        overflow: hidden;
        padding: 26px 28px;
        position: relative;
    }

    .seo-header::after {
        background: linear-gradient(90deg, #22c55e, #38bdf8, #f59e0b);
        bottom: 0;
        content: '';
        height: 4px;
        left: 0;
        position: absolute;
        right: 0;
    }

    .seo-header h2 {
        font-size: 30px;
        font-weight: 900;
        letter-spacing: 0;
        line-height: 1.1;
        margin: 0 0 7px;
    }

    .seo-header p,
    .seo-panel-title p {
        margin: 0;
    }

    .seo-header p {
        color: rgba(255, 255, 255, 0.78);
        font-size: 15px;
        line-height: 1.55;
        max-width: 760px;
    }

    .seo-eyebrow {
        color: #a7f3d0;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .08em;
        margin-bottom: 6px;
        text-transform: uppercase;
    }

    .seo-header-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .seo-stat-card,
    .seo-panel {
        background: #fff;
        border: 1px solid rgba(203, 213, 225, .82);
        border-radius: 8px;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.07);
    }

    .seo-stat-card {
        align-items: center;
        display: flex;
        gap: 14px;
        min-height: 102px;
        padding: 18px;
    }

    .seo-stat-card small {
        color: #64748b;
        display: block;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .05em;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .seo-stat-card strong {
        color: #0f172a;
        display: block;
        font-size: 23px;
        font-weight: 900;
        line-height: 1.05;
    }

    .stat-icon {
        align-items: center;
        border-radius: 8px;
        display: inline-flex;
        flex: 0 0 46px;
        height: 46px;
        justify-content: center;
        width: 46px;
    }

    .stat-blue { background: #dbeafe; color: #1d4ed8; }
    .stat-green { background: #dcfce7; color: #15803d; }
    .stat-amber { background: #fef3c7; color: #b45309; }
    .stat-cyan { background: #cffafe; color: #0e7490; }

    .seo-panel {
        padding: 22px;
    }

    .seo-panel-title {
        align-items: center;
        display: flex;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }

    .seo-panel-title h5 {
        color: #0f172a;
        font-size: 20px;
        font-weight: 900;
        letter-spacing: 0;
        line-height: 1.2;
        margin: 0 0 5px;
    }

    .seo-panel-title p {
        color: #64748b;
        font-size: 14px;
        line-height: 1.55;
    }

    .seo-page .form-label {
        color: #1f2937;
        font-size: 13px;
        font-weight: 900;
        letter-spacing: 0;
        margin-bottom: 7px;
    }

    .seo-page .form-control,
    .seo-page .form-select {
        background-color: #fff;
        border-color: #cbd5e1;
        border-radius: 6px;
        color: #111827;
        font-size: 14px;
        font-weight: 650;
        min-height: 42px;
    }

    .seo-page .form-control:focus,
    .seo-page .form-select:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, .14);
    }

    .seo-page .form-control::placeholder,
    .seo-page textarea.form-control::placeholder {
        color: #4b5563;
        font-weight: 700;
        opacity: 1;
    }

    .seo-page textarea.form-control {
        min-height: auto;
    }

    .seo-switch {
        background: #f8fafc;
        border: 1px solid #dbe3ef;
        border-radius: 8px;
        font-weight: 800;
        padding: 10px 12px 10px 42px;
        white-space: nowrap;
    }

    .seo-tool-badge {
        align-items: center;
        background: #ecfdf5;
        border: 1px solid #bbf7d0;
        border-radius: 999px;
        color: #047857;
        display: inline-flex;
        font-size: 12px;
        font-weight: 900;
        gap: 7px;
        letter-spacing: .04em;
        margin-bottom: 8px;
        padding: 6px 10px;
        text-transform: uppercase;
    }

    .counter {
        color: #6b7280;
        font-weight: 700;
    }

    .counter.is-good { color: #15803d; }
    .counter.is-warning { color: #b45309; }
    .counter.is-bad { color: #b91c1c; }

    .image-preview {
        align-items: center;
        background: #f9fafb;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
        color: #6b7280;
        display: flex;
        height: 138px;
        justify-content: center;
        margin-bottom: 10px;
        overflow: hidden;
    }

    .image-preview img,
    .social-image img {
        height: 100%;
        object-fit: cover;
        width: 100%;
    }

    .code-field {
        font-family: Consolas, Monaco, monospace;
        font-size: 13px;
    }

    .sticky-preview {
        position: sticky;
        top: 92px;
    }

    .preview-block {
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 16px;
        padding-bottom: 16px;
    }

    .preview-label {
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .google-preview {
        background: #fff;
        border: 1px solid #dbe3ef;
        border-radius: 8px;
        box-shadow: 0 12px 26px rgba(15, 23, 42, .06);
        padding: 16px;
    }

    .preview-url {
        color: #047857;
        font-size: 13px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .preview-title {
        color: #1a0dab;
        font-size: 20px;
        font-weight: 500;
        line-height: 1.25;
        margin: 4px 0;
    }

    .preview-description {
        color: #4b5563;
        font-size: 14px;
        line-height: 1.45;
    }

    .social-preview {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        overflow: hidden;
    }

    .social-image {
        align-items: center;
        background: #eef2f7;
        color: #94a3b8;
        display: flex;
        font-size: 32px;
        height: 170px;
        justify-content: center;
    }

    .social-body {
        padding: 12px;
    }

    .social-body strong {
        color: #111827;
        display: block;
        font-size: 16px;
        font-weight: 900;
        line-height: 1.35;
    }

    .social-body p {
        color: #4b5563;
        font-size: 13px;
        margin: 6px 0;
    }

    .social-body span {
        color: #6b7280;
        font-size: 12px;
        text-transform: uppercase;
    }

    .seo-checklist {
        display: grid;
        gap: 9px;
        margin-bottom: 16px;
    }

    .check-item {
        align-items: flex-start;
        background: #f8fafc;
        border: 1px solid #e5edf6;
        border-radius: 8px;
        color: #64748b;
        display: flex;
        font-size: 13px;
        font-weight: 750;
        gap: 8px;
        padding: 10px;
    }

    .check-item i {
        font-size: 9px;
        margin-top: 5px;
    }

    .check-item.is-good {
        color: #15803d;
    }

    .check-item.is-bad {
        color: #b91c1c;
    }

    .seo-actions {
        display: grid;
        gap: 10px;
    }

    .seo-actions .btn {
        border-radius: 6px;
        font-size: 14px;
        font-weight: 900;
        min-height: 42px;
    }

    @media (max-width: 991px) {
        .sticky-preview {
            position: static;
        }
    }

    @media (max-width: 767px) {
        .seo-page {
            padding: 14px;
        }

        .seo-header,
        .seo-panel-title {
            align-items: flex-start;
            flex-direction: column;
        }

        .seo-header-actions,
        .seo-header-actions .btn {
            width: 100%;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('seoSettingsForm');
    const saveBtn = document.getElementById('saveSeoBtn');
    const resetBtn = document.getElementById('resetSeoBtn');
    const auditBtn = document.getElementById('auditBtn');

    const fields = {
        title: document.getElementById('seo_meta_title'),
        description: document.getElementById('seo_meta_description'),
        canonical: document.getElementById('canonical_url'),
        focusKeyword: document.getElementById('seo_focus_keyword'),
        scoreTarget: document.getElementById('seo_content_score_target'),
        schemaType: document.getElementById('schema_type'),
        sitemap: document.getElementById('sitemap_url'),
        ogTitle: document.getElementById('seo_og_title'),
        ogDescription: document.getElementById('seo_og_description'),
        twitterTitle: document.getElementById('seo_twitter_title'),
        twitterDescription: document.getElementById('seo_twitter_description'),
        analytics: document.getElementById('google_analytics_id')
    };

    function textValue(element) {
        return element && element.value ? element.value.trim() : '';
    }

    function updateCounter(inputId, idealMin, idealMax) {
        const input = document.getElementById(inputId);
        const counter = document.querySelector('[data-counter-for="' + inputId + '"]');
        if (!input || !counter) {
            return;
        }

        const length = input.value.length;
        counter.textContent = length + ' / ' + idealMax;
        counter.classList.remove('is-good', 'is-warning', 'is-bad');

        if (length >= idealMin && length <= idealMax) {
            counter.classList.add('is-good');
        } else if (length > 0 && length < idealMin) {
            counter.classList.add('is-warning');
        } else {
            counter.classList.add('is-bad');
        }
    }

    function setCheck(name, passed) {
        const item = document.querySelector('[data-check="' + name + '"]');
        if (!item) {
            return;
        }

        item.classList.toggle('is-good', passed);
        item.classList.toggle('is-bad', !passed);
        const icon = item.querySelector('i');
        icon.className = passed ? 'fas fa-check-circle' : 'fas fa-times-circle';
    }

    function updatePreview() {
        const title = textValue(fields.title) || @json($siteTitle);
        const description = textValue(fields.description) || 'No description configured.';
        const canonical = textValue(fields.canonical) || @json(url('/'));
        const focusKeyword = textValue(fields.focusKeyword).toLowerCase();
        const ogTitle = textValue(fields.ogTitle) || title;
        const ogDescription = textValue(fields.ogDescription) || description;
        const searchableSnippet = (title + ' ' + description).toLowerCase();

        document.getElementById('previewTitle').textContent = title;
        document.getElementById('previewDescription').textContent = description;
        document.getElementById('previewUrl').textContent = canonical;
        document.getElementById('previewOgTitle').textContent = ogTitle;
        document.getElementById('previewOgDescription').textContent = ogDescription;
        document.getElementById('titleStat').textContent = title.length;
        document.getElementById('descriptionStat').textContent = description.length;

        updateCounter('seo_meta_title', 50, 60);
        updateCounter('seo_meta_description', 150, 160);
        setCheck('title', title.length >= 50 && title.length <= 60);
        setCheck('description', description.length >= 150 && description.length <= 160);
        setCheck('canonical', canonical.length > 0 && /^https?:\/\//i.test(canonical));
        setCheck('social', ogTitle.length > 0 && ogDescription.length > 0);
        setCheck('analytics', textValue(fields.analytics).length > 0);
        setCheck('keyword', focusKeyword.length > 0 && searchableSnippet.indexOf(focusKeyword) !== -1);
        setCheck('schema', textValue(fields.schemaType).length > 0);
        setCheck('sitemap', textValue(fields.sitemap).length > 0 && /^https?:\/\//i.test(textValue(fields.sitemap)));
    }

    function previewImage(input, previewId, socialPreview) {
        const file = input.files && input.files[0];
        if (!file) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function(event) {
            const imageHtml = '<img src="' + event.target.result + '" alt="Selected SEO image">';
            document.getElementById(previewId).innerHTML = imageHtml;
            if (socialPreview) {
                document.getElementById('socialImagePreview').innerHTML = imageHtml;
            }
        };
        reader.readAsDataURL(file);
    }

    Object.values(fields).forEach(function(field) {
        if (field) {
            field.addEventListener('input', updatePreview);
        }
    });

    document.getElementById('seo_og_image').addEventListener('change', function() {
        previewImage(this, 'ogPreview', true);
    });

    document.getElementById('seo_twitter_image').addEventListener('change', function() {
        previewImage(this, 'twitterPreview', false);
    });

    resetBtn.addEventListener('click', function() {
        form.reset();
        updatePreview();
    });

    auditBtn.addEventListener('click', function() {
        updatePreview();
        const passed = document.querySelectorAll('.check-item.is-good').length;
        const total = document.querySelectorAll('.check-item').length;
        const message = passed + ' of ' + total + ' checks passed. Review red items before publishing.';

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: passed === total ? 'success' : 'info',
                title: 'SEO Check',
                text: message
            });
        } else {
            alert(message);
        }
    });

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(form);
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';

        fetch('{{ route("admin.marketing.seo.update") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(function(response) {
            return response.json().then(function(data) {
                if (!response.ok) {
                    throw data;
                }
                return data;
            });
        })
        .then(function(data) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Saved',
                    text: data.message || 'SEO settings updated successfully.',
                    timer: 1800,
                    showConfirmButton: false
                });
            }
        })
        .catch(function(error) {
            const message = error && error.message ? error.message : 'Failed to save SEO settings.';
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Unable to Save',
                    text: message
                });
            } else {
                alert(message);
            }
        })
        .finally(function() {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fas fa-save me-2"></i>Save SEO Settings';
        });
    });

    updatePreview();
});
</script>
@endsection
