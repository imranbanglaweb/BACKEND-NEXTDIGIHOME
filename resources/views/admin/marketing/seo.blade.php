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
                                <form>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Site Title</label>
                                            <input type="text" class="form-control" value="Next Digi Home - Digital Marketplace">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Site Description</label>
                                            <input type="text" class="form-control" value="Premium digital products marketplace">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Default Meta Keywords</label>
                                            <input type="text" class="form-control" value="digital products, software, templates, marketplace">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Robots Meta Tag</label>
                                            <select class="form-select">
                                                <option>index, follow</option>
                                                <option>noindex, follow</option>
                                                <option>index, nofollow</option>
                                                <option>noindex, nofollow</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Canonical URL</label>
                                        <input type="url" class="form-control" value="https://nextdigihome.com">
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                        <button type="button" class="btn btn-outline-secondary">Reset to Defaults</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Meta Tags Settings -->
                            <div class="tab-pane fade" id="meta" role="tabpanel">
                                <h5 class="mb-3">Meta Tags Management</h5>
                                <div class="mb-3">
                                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMetaModal">
                                        <i class="fas fa-plus me-2"></i>Add Meta Tag
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Page/Section</th>
                                                <th>Meta Title</th>
                                                <th>Meta Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Home Page</td>
                                                <td>Next Digi Home - Premium Digital Products</td>
                                                <td>Discover amazing digital products...</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">Edit</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Products Page</td>
                                                <td>Browse Digital Products - Next Digi Home</td>
                                                <td>Explore our collection of digital products...</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">Edit</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
                                <form>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Google Analytics ID</label>
                                            <input type="text" class="form-control" placeholder="GA4-MEASUREMENT-ID">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Google Search Console</label>
                                            <input type="text" class="form-control" placeholder="Verification Code">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Facebook Pixel ID</label>
                                            <input type="text" class="form-control" placeholder="Pixel ID">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Bing Webmaster Tools</label>
                                            <input type="text" class="form-control" placeholder="Verification Code">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" checked>
                                            <label class="form-check-label">Enable Enhanced E-commerce Tracking</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" checked>
                                            <label class="form-check-label">Track 404 Errors</label>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">Save Analytics Settings</button>
                                        <button type="button" class="btn btn-outline-info">Test Tracking Code</button>
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

<!-- Add Meta Tag Modal -->
<div class="modal fade" id="addMetaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Meta Tag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Page/Section</label>
                        <select class="form-select">
                            <option>Home Page</option>
                            <option>Products Page</option>
                            <option>About Page</option>
                            <option>Contact Page</option>
                            <option>Custom Page</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" class="form-control" placeholder="Enter meta title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea class="form-control" rows="3" placeholder="Enter meta description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" class="form-control" placeholder="Enter keywords separated by commas">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Add Meta Tag</button>
            </div>
        </div>
    </div>
</div>

<script>
function runSeoAudit() {
    alert('SEO Audit feature coming soon! This will analyze your site for SEO improvements.');
}
</script>
@endsection