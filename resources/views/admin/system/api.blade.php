@extends('admin.dashboard.master')

@section('title', 'API Settings')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plug"></i> API Settings & Configuration
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
                        <strong>API Configuration:</strong> Configure API access, authentication, and security settings for your application.
                    </div>

                    <div class="row">
                        <!-- API Status -->
                        <div class="col-md-6">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h5 class="card-title">API Status</h5>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-6">API Enabled:</dt>
                                        <dd class="col-sm-6">
                                            <span class="badge badge-{{ $apiSettings['api_enabled'] ? 'success' : 'secondary' }}">
                                                {{ $apiSettings['api_enabled'] ? 'Enabled' : 'Disabled' }}
                                            </span>
                                        </dd>

                                        <dt class="col-sm-6">API Key Required:</dt>
                                        <dd class="col-sm-6">
                                            <span class="badge badge-{{ $apiSettings['api_key_required'] ? 'warning' : 'info' }}">
                                                {{ $apiSettings['api_key_required'] ? 'Required' : 'Optional' }}
                                            </span>
                                        </dd>

                                        <dt class="col-sm-6">Rate Limiting:</dt>
                                        <dd class="col-sm-6">
                                            <span class="badge badge-{{ $apiSettings['rate_limiting'] ? 'success' : 'secondary' }}">
                                                {{ $apiSettings['rate_limiting'] ? 'Enabled' : 'Disabled' }}
                                            </span>
                                        </dd>

                                        <dt class="col-sm-6">CORS Enabled:</dt>
                                        <dd class="col-sm-6">
                                            <span class="badge badge-{{ $apiSettings['cors_enabled'] ? 'success' : 'danger' }}">
                                                {{ $apiSettings['cors_enabled'] ? 'Enabled' : 'Disabled' }}
                                            </span>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <!-- API Configuration -->
                        <div class="col-md-6">
                            <div class="card card-outline card-warning">
                                <div class="card-header">
                                    <h5 class="card-title">API Configuration</h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="api_enabled">API Access</label>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                       class="custom-control-input"
                                                       id="api_enabled"
                                                       {{ $apiSettings['api_enabled'] ? 'checked' : '' }}
                                                       disabled>
                                                <label class="custom-control-label" for="api_enabled">
                                                    Enable API access
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="api_key_required">API Key Authentication</label>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                       class="custom-control-input"
                                                       id="api_key_required"
                                                       {{ $apiSettings['api_key_required'] ? 'checked' : '' }}
                                                       disabled>
                                                <label class="custom-control-label" for="api_key_required">
                                                    Require API key for access
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="rate_limiting">Rate Limiting</label>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                       class="custom-control-input"
                                                       id="rate_limiting"
                                                       {{ $apiSettings['rate_limiting'] ? 'checked' : '' }}
                                                       disabled>
                                                <label class="custom-control-label" for="rate_limiting">
                                                    Enable rate limiting
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="cors_enabled">CORS Support</label>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                       class="custom-control-input"
                                                       id="cors_enabled"
                                                       {{ $apiSettings['cors_enabled'] ? 'checked' : '' }}
                                                       disabled>
                                                <label class="custom-control-label" for="cors_enabled">
                                                    Enable CORS for cross-origin requests
                                                </label>
                                            </div>
                                        </div>

                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Configuration changes require server restart and code modifications.
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- API Documentation -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card card-outline card-success">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-book"></i> API Documentation & Testing
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Available Endpoints:</h6>
                                            <div class="list-group">
                                                <a href="#" class="list-group-item list-group-item-action disabled">
                                                    <i class="fas fa-users"></i> /api/users - User management
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action disabled">
                                                    <i class="fas fa-box"></i> /api/products - Product management
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action disabled">
                                                    <i class="fas fa-shopping-cart"></i> /api/orders - Order management
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action disabled">
                                                    <i class="fas fa-chart-line"></i> /api/reports - Reports & analytics
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>API Tools:</h6>
                                            <div class="d-grid gap-2">
                                                <button type="button" class="btn btn-outline-primary" disabled>
                                                    <i class="fas fa-play"></i> Test API Endpoints
                                                </button>
                                                <button type="button" class="btn btn-outline-info" disabled>
                                                    <i class="fas fa-file-code"></i> View API Documentation
                                                </button>
                                                <button type="button" class="btn btn-outline-success" disabled>
                                                    <i class="fas fa-key"></i> Generate API Key
                                                </button>
                                                <button type="button" class="btn btn-outline-warning" disabled>
                                                    <i class="fas fa-shield-alt"></i> API Security Settings
                                                </button>
                                            </div>
                                            <div class="alert alert-info mt-3">
                                                <i class="fas fa-info-circle"></i>
                                                API endpoints and documentation will be available once API routes are implemented.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- API Security -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card card-outline card-danger">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-shield-alt"></i> API Security Best Practices
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><i class="fas fa-check-circle text-success"></i> Security Measures</h6>
                                            <ul>
                                                <li>Use HTTPS for all API communications</li>
                                                <li>Implement proper authentication (API keys, OAuth)</li>
                                                <li>Enable rate limiting to prevent abuse</li>
                                                <li>Validate and sanitize all input data</li>
                                                <li>Use API versioning for backward compatibility</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6><i class="fas fa-exclamation-triangle text-warning"></i> Security Risks</h6>
                                            <ul>
                                                <li>Exposing sensitive data through APIs</li>
                                                <li>Insufficient rate limiting leading to DoS</li>
                                                <li>Weak authentication mechanisms</li>
                                                <li>Missing input validation</li>
                                                <li>Inadequate error handling revealing system info</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <small class="text-muted">
                        <i class="fas fa-clock"></i> Configuration last checked: {{ now()->format('Y-m-d H:i:s') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection