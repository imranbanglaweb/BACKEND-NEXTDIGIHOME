<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureActiveSubscription
{

//     public function handle($request, Closure $next, string $feature)
// {
//     $plan = auth()->user()->company->plan;

//     if (!$plan || !in_array($feature, $plan->features ?? [])) {
//         abort(403, "Feature '{$feature}' not allowed in your plan");
//     }

//     return $next($request);
// }

    public function handle(Request $request, Closure $next)
    {
        // Not logged in → let auth middleware handle it
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // 🔐 Super Admin bypass
        if ($user->hasRole('Super Admin')) {
            return $next($request);
        }

        $company = $user->company;

        if (!$company || !$company->subscription) {
            abort(403, 'No active subscription found');
        }

        $subscription = $company->subscription;

        // ❌ Inactive or unpaid
        if (!$subscription->is_active || $subscription->payment_status !== 'paid') {
            abort(403, 'Subscription inactive');
        }

        // ⏰ Expired
        if (now()->greaterThan($subscription->ends_at)) {
            abort(403, 'Subscription expired');
        }

        return $next($request);
    }
}
