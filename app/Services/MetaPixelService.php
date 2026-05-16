<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class MetaPixelService
{
    /**
     * Get the Meta Pixel ID from configuration.
     *
     * @return string
     */
    public function getPixelId()
    {
        return config('metapixel.pixel_id', env('META_PIXEL_ID', '981230941262806'));
    }

    /**
     * Check if Meta Pixel tracking is enabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return config('metapixel.enabled', true) && env('META_PIXEL_ENABLED', true);
    }

    /**
     * Check if admin tracking is enabled.
     *
     * @return bool
     */
    public function shouldTrackAdmin()
    {
        return config('metapixel.track_admin', true) && env('META_PIXEL_TRACK_ADMIN', true);
    }

    /**
     * Check if user detail tracking is enabled.
     *
     * @return bool
     */
    public function shouldTrackUserDetails()
    {
        return config('metapixel.track_user_details', true) && env('META_PIXEL_TRACK_USER_DETAILS', true);
    }

    /**
     * Determine if the current user is an admin.
     *
     * @return bool
     */
    public function isAdminUser()
    {
        if (! Auth::check()) {
            return false;
        }

        $user = Auth::user();

        return $user->hasRole('Super Admin') || $user->hasRole('Admin');
    }

    /**
     * Get the current route name.
     *
     * @return string|null
     */
    public function getCurrentRoute()
    {
        return request()->route() ? request()->route()->getName() : null;
    }

    /**
     * Check if the current route should be excluded from tracking.
     *
     * @return bool
     */
    public function shouldExcludeCurrentRoute()
    {
        $currentRoute = $this->getCurrentRoute();
        $excludedRoutes = config('metapixel.excluded_routes', []);

        return in_array($currentRoute, $excludedRoutes);
    }

    /**
     * Get events that should be tracked on the current page.
     *
     * @return array
     */
    public function getTrackedEvents()
    {
        $currentRoute = $this->getCurrentRoute();
        $trackEvents = config('metapixel.events', []);
        $trackedEvents = [];

        foreach ($trackEvents as $eventName => $eventConfig) {
            if (($eventConfig['enabled'] ?? false) && ! empty($eventConfig['track_on'])) {
                if (in_array('*', $eventConfig['track_on']) || in_array($currentRoute, $eventConfig['track_on'])) {
                    $trackedEvents[] = $eventName;
                }
            }
        }

        return $trackedEvents;
    }

    /**
     * Track a custom event via Meta Pixel (client-side).
     * This method generates JavaScript code to track custom events.
     *
     * @param  string  $eventName
     * @param  array  $parameters
     * @return string
     */
    public function trackCustomEvent($eventName, $parameters = [])
    {
        if (! $this->isEnabled()) {
            return '';
        }

        $params = json_encode($parameters);

        return "fbq('trackCustom', '{$eventName}', {$params});";
    }

    /**
     * Get user details for tracking (if enabled).
     *
     * @return array|null
     */
    public function getUserDetails()
    {
        if (! $this->shouldTrackUserDetails() || ! Auth::check()) {
            return null;
        }

        $user = Auth::user();

        return [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role ?? ($user->roles()->first()->name ?? 'User'),
            'id' => $user->id,
        ];
    }

    /**
     * Check if we should track page views.
     *
     * @return bool
     */
    public function shouldTrackPageViews()
    {
        $events = config('metapixel.events', []);

        return $events['page_view']['enabled'] ?? true;
    }
}
