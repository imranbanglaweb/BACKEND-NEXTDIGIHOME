{{-- Meta Pixel Tracking Component --}}
@php
    $metapixelConfig = config('metapixel');
    $isAdmin = auth()->check() && (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'));
    $shouldTrackAdmin = $metapixelConfig['track_admin'] ?? true;
    $trackUserDetails = $metapixelConfig['track_user_details'] ?? true;
    $pixelId = $metapixelConfig['pixel_id'] ?? env('META_PIXEL_ID', '981230941262806');
    $isEnabled = $metapixelConfig['enabled'] ?? true;
    
    // Determine if we should track this page
    $currentRoute = request()->route() ? request()->route()->getName() : null;
    $excludedRoutes = $metapixelConfig['excluded_routes'] ?? [];
    $shouldExclude = in_array($currentRoute, $excludedRoutes);
    
    // Check if tracking is enabled for this route
    $trackEvents = $metapixelConfig['events'] ?? [];
    $trackedEvents = [];
    foreach ($trackEvents as $eventName => $eventConfig) {
        if (($eventConfig['enabled'] ?? false) && !empty($eventConfig['track_on'])) {
            if (in_array('*', $eventConfig['track_on']) || in_array($currentRoute, $eventConfig['track_on'])) {
                $trackedEvents[] = $eventName;
            }
        }
    }
@endphp

@if($isEnabled && !$shouldExclude)
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{{ $pixelId }}');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id={{ $pixelId }}&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

@if($isAdmin && $shouldTrackAdmin)
<!-- Admin User Tracking -->
<script>
    // Track admin user details
    @if($trackUserDetails && auth()->check())
    fbq('track', 'Lead', {
        content_name: '{{ auth()->user()->name }}',
        content_type: 'Admin User',
        role: '{{ auth()->user()->role ?? auth()->user()->roles()->first()->name ?? 'Admin' }}',
        email: '{{ auth()->user()->email }}',
        status: 'Logged In'
    });
    @endif

    // Track admin dashboard page view
    @if(request()->is('*admin*', 'dashboard*', 'admin/dashboard*'))
    fbq('track', 'ViewContent', {
        content_name: 'Admin Dashboard',
        content_type: 'Dashboard',
        status: 'Admin Access'
    });
    @endif

    // Track specific events for admin users
    @foreach($trackedEvents as $event)
        @switch($event)
            @case('view_item')
                @if(request()->is('*requisitions*', '*vehicles*', '*trips*'))
                fbq('track', 'ViewItem', {
                    content_name: '{{ request()->route()->getName() }}',
                    content_type: 'Admin View',
                    item_id: '{{ request()->id ?? request()->route()->parameter('id') ?? 'N/A' }}'
                });
                @endif
                @break
            
            @case('lead')
                @if(request()->is('*requisitions/create*', '*contact*'))
                fbq('track', 'Lead', {
                    content_name: 'New Requisition/Contact',
                    content_type: 'Lead Generation',
                    source: 'Admin Panel'
                });
                @endif
                @break
            
            @case('purchase')
                @if(request()->is('*subscription*', '*pricing*'))
                fbq('track', 'Purchase', {
                    content_name: 'Subscription Purchase',
                    content_type: 'Transaction',
                    value: 0,
                    currency: 'USD'
                });
                @endif
                @break
        @endswitch
    @endforeach

    // Track admin interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Track button clicks for important actions
        var trackableButtons = [
            '.btn-new-requisition',
            '.btn-refresh',
            '.quick-action-item',
            '.activity-btn',
            '.dropdown-item'
        ];

        trackableButtons.forEach(function(selector) {
            var buttons = document.querySelectorAll(selector);
            buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var actionName = this.innerText.trim() || this.getAttribute('href') || selector;
                    fbq('trackCustom', 'AdminInteraction', {
                        action: actionName,
                        element: selector,
                        timestamp: new Date().toISOString()
                    });
                });
            });
        });

        // Track table interactions
        var tables = document.querySelectorAll('.table, .dataTable');
        tables.forEach(function(table) {
            table.addEventListener('click', function(e) {
                var target = e.target.closest('a, button');
                if (target) {
                    fbq('trackCustom', 'TableInteraction', {
                        table_class: table.className,
                        action: target.innerText.trim(),
                        link: target.getAttribute('href') || ''
                    });
                }
            });
        });

        // Track form submissions
        var forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function() {
                fbq('trackCustom', 'FormSubmission', {
                    form_id: form.id || form.className,
                    form_action: form.action || '',
                    method: form.method || 'GET'
                });
            });
        });
    });

    // Track page performance for admins
    window.addEventListener('load', function() {
        var timing = performance.timing;
        var pageLoadTime = timing.loadEventEnd - timing.navigationStart;
        var domReadyTime = timing.domContentLoadedEventEnd - timing.navigationStart;
        
        fbq('trackCustom', 'PagePerformance', {
            page_url: window.location.href,
            page_load_time: pageLoadTime,
            dom_ready_time: domReadyTime,
            user_role: 'Admin'
        });
    });
</script>
<!-- End Admin Tracking -->
@endif

<!-- Standard Event Tracking -->
<script>
    @foreach($trackedEvents as $event)
        @if($event == 'page_view')
        fbq('track', 'PageView', {
            content_name: '{{ request()->path() }}',
            content_category: '{{ $currentRoute ?? 'general' }}'
        });
        @endif
    @endforeach
</script>
<!-- End Standard Events -->

@endif

<!-- Debug Info for Admins -->
@if($isAdmin && $shouldTrackAdmin && config('app.debug'))
<div style="position: fixed; bottom: 10px; right: 10px; background: rgba(0,0,0,0.8); color: white; padding: 10px; border-radius: 5px; font-size: 12px; z-index: 9999; max-width: 300px;">
    <strong>Meta Pixel Debug</strong><br>
    Pixel ID: {{ $pixelId }}<br>
    Status: {{ $isEnabled ? 'Enabled' : 'Disabled' }}<br>
    Admin Track: {{ $shouldTrackAdmin ? 'Yes' : 'No' }}<br>
    Route: {{ $currentRoute ?? 'N/A' }}<br>
    Tracked Events: {{ implode(', ', $trackedEvents) ?: 'None' }}
</div>
@endif