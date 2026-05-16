@extends('admin.dashboard.master')

@section('title','Edit Subscription Plan')

@section('main_content')
<section class="content-body py-4" style="background:#fff">
<div class="container-fluid">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">
        <i class="fa fa-edit text-warning"></i>
        Edit Subscription Plan
    </h2>
    <a href="{{ route('admin.dashboard.plans.index') }}" class="btn btn-outline-secondary">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>

<form id="planForm" method="POST" action="{{ route('admin.dashboard.plans.update', $plan) }}">
@csrf
@method('PUT')

<div class="row">
    <!-- LEFT COLUMN - Basic Info -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-primary bg-gradient text-white rounded-top-4 py-3">
                <h5 class="mb-0"><i class="fa fa-info-circle"></i> Basic Information</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Plan Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ $plan->name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Slug <span class="text-danger">*</span></label>
                        <input type="text" name="slug" class="form-control" value="{{ $plan->slug }}" required>
                        <small class="text-muted">Unique identifier (lowercase, no spaces)</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Price (৳) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" value="{{ $plan->price }}" required min="0">
                        <small class="text-muted">Set 0 for Enterprise/Unlimited</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Billing Cycle <span class="text-danger">*</span></label>
                        <select name="billing_cycle" class="form-select" required>
                            <option value="monthly" {{ $plan->billing_cycle == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ $plan->billing_cycle == 'yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Driver Limit</label>
                        <input type="number" name="driver_limit" class="form-control" value="{{ $plan->driver_limit }}" placeholder="10">
                        <small class="text-muted">Leave empty for unlimited</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Monthly Reports</label>
                        <input type="number" name="monthly_reports" class="form-control" value="{{ $plan->monthly_reports }}" placeholder="50">
                        <small class="text-muted">AI Reports per month. Leave empty for unlimited</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Monthly Alerts</label>
                        <input type="number" name="monthly_alerts" class="form-control" value="{{ $plan->monthly_alerts }}" placeholder="100">
                        <small class="text-muted">AI Maintenance alerts per month. Leave empty for unlimited</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-success bg-gradient text-white rounded-top-4 py-3">
                <h5 class="mb-0"><i class="fa fa-star"></i> Plan Features</h5>
            </div>
            <div class="card-body p-4">
                <div id="feature-list">
                    @if(count($plan->features) > 0)
                        @foreach($plan->features as $feature)
                        <div class="feature-item input-group mb-2">
                            <input type="text" name="features[]" class="form-control" value="{{ $feature }}" placeholder="Feature">
                            <button type="button" class="btn btn-outline-danger" onclick="removeFeature(this)">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        @endforeach
                    @else
                    <div class="feature-item input-group mb-2">
                        <input type="text" name="features[]" class="form-control" placeholder="e.g., Fuel & Maintenance Management">
                        <button type="button" class="btn btn-outline-danger" onclick="removeFeature(this)">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    @endif
                </div>
                <button type="button" class="btn btn-outline-primary mt-2" onclick="addFeature()">
                    <i class="fa fa-plus"></i> Add Feature
                </button>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN - Settings -->
    <div class="col-lg-4">
        <!-- Plan Status -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-dark bg-gradient text-white rounded-top-4 py-3">
                <h5 class="mb-0"><i class="fa fa-cog"></i> Plan Settings</h5>
            </div>
            <div class="card-body">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_popular" value="1" id="is_popular" {{ $plan->is_popular ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="is_popular">
                        Mark as Popular
                    </label>
                    <small class="d-block text-muted">Highlights this plan on pricing page</small>
                </div>
                <hr>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ $plan->is_active ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="is_active">
                        Active Plan
                    </label>
                    <small class="d-block text-muted">Allow companies to subscribe to this plan</small>
                </div>
                <hr>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_trial" value="1" id="is_trial" {{ $plan->is_trial ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="is_trial">
                        Enable Trial
                    </label>
                    <small class="d-block text-muted">Allow free trial period</small>
                </div>
                <div class="mt-3" id="trial_days_field">
                    <label class="form-label fw-semibold">Trial Days</label>
                    <input type="number" name="trial_days" class="form-control" value="{{ $plan->trial_days }}" placeholder="14" min="1">
                </div>
            </div>
        </div>

        <!-- Limits Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-warning bg-gradient text-dark rounded-top-4 py-3">
                <h5 class="mb-0"><i class="fa fa-chart-bar"></i> Resource Limits</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Vehicle Limit</label>
                    <input type="number" name="vehicle_limit" class="form-control" value="{{ $plan->vehicle_limit }}" placeholder="25">
                    <small class="text-muted">Set 0 for unlimited vehicles</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">User Limit</label>
                    <input type="number" name="user_limit" class="form-control" value="{{ $plan->user_limit }}" placeholder="10">
                    <small class="text-muted">Set 0 for unlimited users</small>
                </div>
            </div>
        </div>

        <!-- Comparison Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-info bg-gradient text-white rounded-top-4 py-3">
                <h5 class="mb-0"><i class="fa fa-balance-scale"></i> Comparison Settings</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Recommended For</label>
                    <input type="text" name="recommended_for" class="form-control" value="{{ $plan->recommended_for }}" placeholder="e.g., Small businesses with up to 10 vehicles">
                    <small class="text-muted">Short description shown in comparison table</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Display Order</label>
                    <input type="number" name="display_order" class="form-control" value="{{ $plan->display_order }}" placeholder="0">
                    <small class="text-muted">Lower numbers appear first</small>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success btn-lg w-100 shadow">
            <i class="fa fa-save"></i> Update Plan
        </button>

        <a href="{{ route('admin.dashboard.plans.index') }}" class="btn btn-outline-secondary w-100 mt-2">
            <i class="fa fa-times"></i> Cancel
        </a>
    </div>
</div>

</form>

</div>
</section>

<!-- Preloader -->
<style>
#preloader {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.7);
    z-index: 9999;
    justify-content: center;
    align-items: center;
}
#preloader .spinner {
    width: 60px;
    height: 60px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #0d6efd;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
#preloader .loader-text {
    color: #fff;
    margin-top: 15px;
    font-size: 1.2rem;
    font-weight: 600;
}
</style>

<div id="preloader" class="d-flex flex-column">
    <div class="spinner"></div>
    <div class="loader-text">Updating Plan...</div>
</div>

<div id="form-errors" class="alert alert-danger d-none"></div>

<script>
function showPreloader() {
    document.getElementById('preloader').style.display = 'flex';
}
function hidePreloader() {
    document.getElementById('preloader').style.display = 'none';
}

document.getElementById('planForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const url = form.action;
    const formData = new FormData(form);
    const errorBox = document.getElementById('form-errors');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Show preloader
    showPreloader();
    
    // Disable submit button
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Updating...';
    }
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        hidePreloader();
        window.location.href = data.redirect || "{{ route('admin.dashboard.plans.index') }}";
    })
    .catch(err => {
        hidePreloader();
        errorBox.classList.remove('d-none');
        if (err.errors) {
            let html = '<ul class="mb-0">';
            Object.values(err.errors).forEach(messages => {
                messages.forEach(msg => {
                    html += `<li>${msg}</li>`;
                });
            });
            html += '</ul>';
            errorBox.innerHTML = html;
        } else {
            errorBox.innerHTML = 'Something went wrong. Please try again.';
        }
        // Re-enable submit button
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa fa-save"></i> Update Plan';
        }
    });
});

// Trial toggle
document.getElementById('is_trial').addEventListener('change', function() {
    const trialField = document.getElementById('trial_days_field');
    trialField.style.display = this.checked ? 'block' : 'none';
});

// Set initial state on page load
document.addEventListener('DOMContentLoaded', function() {
    const trialCheckbox = document.getElementById('is_trial');
    const trialField = document.getElementById('trial_days_field');
    if (trialCheckbox && trialField) {
        trialField.style.display = trialCheckbox.checked ? 'block' : 'none';
    }
});

// Add feature
function addFeature() {
    const container = document.getElementById('feature-list');
    const div = document.createElement('div');
    div.className = 'feature-item input-group mb-2';
    div.innerHTML = `
        <input type="text" name="features[]" class="form-control" placeholder="New Feature">
        <button type="button" class="btn btn-outline-danger" onclick="removeFeature(this)">
            <i class="fa fa-times"></i>
        </button>
    `;
    container.appendChild(div);
}

// Remove feature
function removeFeature(btn) {
    const container = document.getElementById('feature-list');
    if (container.children.length > 1) {
        btn.closest('.feature-item').remove();
    }
}
</script>

@endsection
