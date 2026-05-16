<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Meta Pixel Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration file manages the Meta Pixel settings for the
    | application. You can enable/disable the pixel and configure tracking
    | for admin users to see detailed analytics.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Meta Pixel ID
    |--------------------------------------------------------------------------
    |
    | This is your Meta Pixel ID. You can find this in your Facebook Events
    | Manager. The pixel will only be loaded if enabled is set to true.
    |
    */

    'pixel_id' => env('META_PIXEL_ID', '981230941262806'),

    /*
    |--------------------------------------------------------------------------
    | Enable Meta Pixel
    |--------------------------------------------------------------------------
    |
    | This option controls whether the Meta Pixel is loaded on the frontend
    | and admin dashboard. Set to false to disable tracking completely.
    |
    */

    'enabled' => env('META_PIXEL_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Track Admin Users
    |--------------------------------------------------------------------------
    |
    | When enabled, admin users will have detailed tracking including page
    | views, user interactions, and dashboard analytics events sent to Meta.
    |
    */

    'track_admin' => env('META_PIXEL_TRACK_ADMIN', true),

    /*
    |--------------------------------------------------------------------------
    | Track User Details
    |--------------------------------------------------------------------------
    |
    | When enabled, user details (role, name, email) are passed to Meta for
    | advanced audience targeting and conversion tracking. Only applies to
    | admin users when track_admin is enabled.
    |
    */

    'track_user_details' => env('META_PIXEL_TRACK_USER_DETAILS', true),

    /*
    |--------------------------------------------------------------------------
    | Tracked Events
    |--------------------------------------------------------------------------
    |
    | Define custom events to track on specific pages. Each event can include
    | custom parameters for detailed analytics.
    |
    */

    'events' => [
        'page_view' => [
            'enabled' => true,
            'track_on' => ['*'],
        ],
        'view_item' => [
            'enabled' => true,
            'track_on' => ['requisitions.show', 'vehicles.show', 'trips.show'],
        ],
        'add_to_cart' => [
            'enabled' => false,
            'track_on' => [],
        ],
        'purchase' => [
            'enabled' => true,
            'track_on' => ['subscription.purchase'],
        ],
        'lead' => [
            'enabled' => true,
            'track_on' => ['requisitions.create', 'contact.store'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Excluded Routes
    |--------------------------------------------------------------------------
    |
    | List of route names that should NOT have Meta Pixel tracking.
    |
    */

    'excluded_routes' => [
        'login',
        'register',
        'password.request',
        'password.reset',
    ],

];
