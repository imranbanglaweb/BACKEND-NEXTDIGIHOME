# Meta Pixel Tracking Setup

## Overview

This document describes the Meta Pixel tracking implementation for the backend application. The Meta Pixel is integrated with dynamic tracking capabilities, allowing admin users to see detailed analytics and user interactions.

## Features

1. **Standard Page View Tracking** - Tracks all page views across the application
2. **Admin User Tracking** - Enhanced tracking for admin users with detailed analytics
3. **Custom Event Tracking** - Configurable events for specific routes
4. **User Detail Integration** - Passes user information to Meta for audience targeting
5. **Performance Monitoring** - Tracks page load times and user interactions
6. **Debug Mode** - Shows tracking information for admins in development mode
7. **Menu Integration** - Full menu system for Meta Pixel Analytics in admin panel

## Installation

### 1. Configuration Files

The following files have been added/modified:

- `config/metapixel.php` - Main Meta Pixel configuration
- `app/Services/MetaPixelService.php` - Service for managing Meta Pixel operations
- `resources/views/components/metapixel.blade.php` - Blade component for tracking code
- `database/seeders/MenuSeeder.php` - Menu entries for Meta Pixel Analytics
- `.env` (modified) - Added Meta Pixel configuration variables
- `.env.example` (modified) - Added example Meta Pixel variables

### 2. Modified Layouts

The Meta Pixel component is included in:

- `resources/views/layouts/app.blade.php` - Frontend layout
- `resources/views/admin/dashboard/master.blade.php` - Admin dashboard layout

### 3. Menu System

The Meta Pixel Analytics menu has been added to the admin panel with the following structure:

**Main Menu Items (Order 17):**
- Meta Pixel Analytics (fa-chart-pie)

**Sub-Menus:**
1. Dashboard Overview (fa-chart-pie) - `metapixel.dashboard`
2. Page Analytics (fa-file-alt) - `metapixel.pages`
3. User Events (fa-user) - `metapixel.events`
4. Traffic Sources (fa-external-link-alt) - `metapixel.sources`
5. Conversion Tracking (fa-chart-line) - `metapixel.conversions`
6. Pixel Configuration (fa-cog) - `metapixel.config`

**Required Permissions:**
- `analytics-view` - View analytics dashboards
- `system-configure` - Access pixel configuration

## Configuration

### Environment Variables

Add or modify the following variables in your `.env` file:

```env
# Meta Pixel Configuration
META_PIXEL_ID=981230941262806
META_PIXEL_ENABLED=true
META_PIXEL_TRACK_ADMIN=true
META_PIXEL_TRACK_USER_DETAILS=true
```

### Config File Options

Edit `config/metapixel.php` to customize tracking behavior:

```php
'pixel_id' => env('META_PIXEL_ID', '981230941262806'),  // Your Meta Pixel ID
'enabled' => env('META_PIXEL_ENABLED', true),           // Enable/disable tracking
'track_admin' => env('META_PIXEL_TRACK_ADMIN', true),   // Track admin users
track_user_details' => env('META_PIXEL_TRACK_USER_DETAILS', true),  // Track user details

'events' => [
    'page_view' => [
        'enabled' => true,
        'track_on' => ['*'],  // Track on all routes
    ],
    'view_item' => [
        'enabled' => true,
        'track_on' => ['requisitions.show', 'vehicles.show', 'trips.show'],
    ],
    'lead' => [
        'enabled' => true,
        'track_on' => ['requisitions.create', 'contact.store'],
    ],
    'purchase' => [
        'enabled' => true,
        'track_on' => ['subscription.purchase'],
    ],
],

'excluded_routes' => [
    'login',
    'register',
    'password.request',
    'password.reset',
],
```

## What Gets Tracked

### For All Users:

1. **Page Views** - Every page visit is tracked with `fbq('track', 'PageView')`
2. **Standard Events** - Configured events based on current route

### For Admin Users (when enabled):

1. **User Details** - Name, email, role, and status
2. **Dashboard Access** - When admin views the dashboard
3. **Item Views** - When viewing specific items (requisitions, vehicles, trips)
4. **Form Submissions** - All form submissions are tracked
5. **Button Clicks** - Important action buttons
6. **Table Interactions** - Clicking on table rows/links
7. **Page Performance** - Load times and DOM ready times

### Custom Events Tracked:

- `Lead` - New requisitions or contact form submissions
- `ViewItem` - Viewing specific items/details
- `ViewContent` - Admin dashboard access
- `Purchase` - Subscription purchases
- `AdminInteraction` - Custom admin button clicks
- `TableInteraction` - Table row clicks
- `FormSubmission` - Form submissions
- `PagePerformance` - Page load metrics

## Using the MetaPixelService

You can inject and use the `MetaPixelService` in your controllers:

```php
use App\Services\MetaPixelService;

class SomeController extends Controller
{
    protected $pixelService;

    public function __construct(MetaPixelService $pixelService)
    {
        $this->pixelService = $pixelService;
    }

    public function index()
    {
        // Check if tracking is enabled
        if ($this->pixelService->isEnabled()) {
            // Get current user details
            $userDetails = $this->pixelService->getUserDetails();
            
            // Get tracked events for current page
            $events = $this->pixelService->getTrackedEvents();
        }
    }
}
```

## Debug Mode

When `APP_DEBUG=true` in your `.env` file, admins will see a debug panel in the bottom-right corner showing:

- Pixel ID
- Tracking status
- Current route
- Tracked events

## Testing

### Verify Installation

1. Log in as an admin user
2. Open browser developer tools (F12)
3. Go to the Network tab
4. Filter for "collect" or "facebook" requests
5. You should see requests to `https://www.facebook.com/tr`

### Test Admin Tracking

1. Navigate to the admin dashboard
2. Click on various buttons and links
3. Check that custom events are being sent
4. Verify form submissions are tracked

### Test User Detail Tracking

1. Log in as admin
2. Check the debug panel (bottom-right) for user details
3. Verify events contain user information

## Troubleshooting

### Pixel Not Loading

1. Check that `META_PIXEL_ENABLED=true` in `.env`
2. Verify `config/metapixel.php` has `'enabled' => true`
3. Check that the component is included in the layout:
   ```blade
   @include('components.metapixel')
   ```

### Admin Tracking Not Working

1. Verify user has Admin or Super Admin role
2. Check `META_PIXEL_TRACK_ADMIN=true` in `.env`
3. Ensure user is logged in

### No Events Being Tracked

1. Check that the route is listed in `'track_on'` for the event
2. Verify the event has `'enabled' => true`
3. Check that the route name matches exactly

### Debug Panel Not Showing

1. Ensure `APP_DEBUG=true` in `.env`
2. Verify you're logged in as admin
3. Check browser console for errors

## Privacy Considerations

⚠️ **Important**: Make sure you:

1. Have user consent for tracking (GDPR/CCPA compliance)
2. Anonymize or hash personal data before sending to Meta
3. Provide opt-out mechanisms for users
4. Only track necessary information
5. Update your privacy policy to reflect tracking

## Maintenance

### Adding New Events

1. Add event configuration to `config/metapixel.php`:

```php
'custom_event' => [
    'enabled' => true,
    'track_on' => ['route.name'],
],
```

2. Add tracking code in the blade component for the event
3. Test the event is being tracked

### Updating Pixel ID

Simply update the `META_PIXEL_ID` in your `.env` file:

```env
META_PIXEL_ID=your_new_pixel_id_here
```

## Menu Management

### Accessing Meta Pixel Analytics

1. Log in to the admin panel
2. Navigate to **Meta Pixel Analytics** in the sidebar
3. Use the sub-menu items to view different analytics reports

### Menu Permissions

The Meta Pixel Analytics parent menu is visible to all authenticated users.

Individual sub-menus require specific permissions:
- `analytics-view` - View analytics dashboards (Dashboard, Pages, Events, Sources, Conversions)
- `system-configure` - Access pixel configuration (for settings)

## Support

For issues or questions about Meta Pixel tracking:

1. Check the Facebook Pixel documentation: https://developers.facebook.com/docs/meta-pixel
2. Review the debug panel for error messages
3. Check browser console for JavaScript errors
4. Verify network requests in developer tools

## Changelog

### Version 1.0.0

- Initial Meta Pixel integration
- Admin user tracking
- Custom event tracking
- User detail integration
- Page performance monitoring
- Debug panel for admins
- Menu system integration
- Analytics dashboard routes registered