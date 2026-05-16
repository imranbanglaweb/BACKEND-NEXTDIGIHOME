@extends('admin.dashboard.master')

@section('title', 'Meta Pixel Configuration - ' . config('app.name'))

@section('main_content')
<div class="dashboard-header">
    <div class="dashboard-header-left">
        <div class="dashboard-header-icon">
            <i class="fa fa-cog"></i>
        </div>
        <div class="dashboard-header-content">
            <h1>Meta Pixel Configuration</h1>
            <p>Manage Meta Pixel tracking settings and parameters</p>
        </div>
    </div>
    <div class="dashboard-header-right">
        <a href="{{ route('metapixel.dashboard') }}" class="btn-new-requisition">
            <i class="fa fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

<div class="role-indicator mb-4">
    <div class="alert alert-info alert-role d-flex align-items-center">
        <i class="fa fa-cog mr-2"></i>
        <div>
            <strong>Meta Pixel Settings</strong>
            <p class="mb-0 small">Configure tracking behavior, events, and excluded routes</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-sliders-h mr-2"></i>General Settings</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <form method="POST" action="{{ route('metapixel.config.update') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">Meta Pixel ID</label>
                        <input type="text" class="form-control" name="pixel_id" value="{{ $pixel_id }}" placeholder="Enter Pixel ID">
                        <small class="form-text text-muted">Your Facebook Pixel identification number</small>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="enabled" value="1" {{ $is_enabled ? 'checked' : '' }} id="enabled">
                        <label class="form-check-label" for="enabled">Enable Meta Pixel Tracking</label>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="track_admin" value="1" {{ $track_admin ? 'checked' : '' }} id="track_admin">
                        <label class="form-check-label" for="track_admin">Track Admin Users</label>
                        <small class="form-text text-muted">Enable detailed tracking for admin users</small>
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="track_user_details" value="1" {{ $track_user_details ? 'checked' : '' }} id="track_user_details">
                        <label class="form-check-label" for="track_user_details">Track User Details</label>
                        <small class="form-text text-muted">Send user name and role to Meta (requires admin tracking)</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save mr-2"></i> Save Settings
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-code mr-2"></i>Current Configuration</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle mr-2"></i>
                    <strong>Pixel ID:</strong> {{ $pixel_id }}
                </div>
                
                <h6 class="mt-4">Enabled Events:</h6>
                <ul class="list-group list-group-flush">
                    @forelse($events as $event => $config)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ ucfirst(str_replace('_', ' ', $event)) }}</span>
                            <span class="badge {{ $config['enabled'] ? 'bg-success' : 'bg-secondary' }}">
                                {{ $config['enabled'] ? 'Active' : 'Inactive' }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No events configured</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card dashboard-card">
    <div class="card-header dashboard-card-header">
        <h4 class="card-title"><i class="fa fa-exclude mr-2"></i>Excluded Routes</h4>
    </div>
    <div class="card-body dashboard-card-body">
        <p class="text-muted small">Routes that will not have Meta Pixel tracking:</p>
        <div class="row">
            @forelse($excluded_routes as $route)
                <div class="col-md-4 col-sm-6 mb-2">
                    <span class="badge bg-light text-dark border">{{ $route }}</span>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted">No routes excluded from tracking</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div class="card dashboard-card">
    <div class="card-header dashboard-card-header">
        <h4 class="card-title"><i class="fa fa-code mr-2"></i>Implementation Code</h4>
    </div>
    <div class="card-body dashboard-card-body">
        <p class="text-muted">The Meta Pixel is automatically included in all pages via the layout files.</p>
        <div class="code-snippet">
            <pre class="bg-light p-3 rounded"><code>&lt;!-- Include in blade template --&gt;
@include('components.metapixel')

&lt;!-- Or add manually before &lt;/head&gt; --&gt;
&lt;script&gt;
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{{ $pixel_id }}');
fbq('track', 'PageView');
&lt;/script&gt;</code></pre>
        </div>
    </div>
</div>

<style>
.form-group { margin-bottom: 1.5rem; }
.form-label { font-weight: 600; color: #333; }
.form-control { border-radius: 8px; border: 1px solid #d1d5db; }
.form-check-input { cursor: pointer; }
.code-snippet { background: #f8f9fa; border-radius: 8px; overflow: hidden; }
.code-snippet pre { margin: 0; font-size: 13px; overflow-x: auto; }
.list-group-item { border: none; border-bottom: 1px solid #f3f4f6; }
.list-group-item:last-child { border-bottom: none; }
</style>
@endsection
