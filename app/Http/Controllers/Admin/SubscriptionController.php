<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display active subscriptions
     */
    public function active()
    {
        return view('admin.subscriptions.active');
    }

    /**
     * Display expired subscriptions
     */
    public function expired()
    {
        $expiredSubscriptions = \App\Models\Subscription::with(['company', 'plan', 'payments'])
            ->where(function ($query) {
                $query->where('status', '!=', 'active')
                      ->orWhere('end_date', '<', now());
            })
            ->orderBy('end_date', 'desc')
            ->paginate(15);

        // Calculate additional data for each subscription
        $expiredSubscriptions->getCollection()->transform(function ($subscription) {
            $subscription->days_expired = $subscription->end_date
                ? now()->diffInDays($subscription->end_date)
                : 0;

            // Determine reactivation status based on some logic
            // For now, using a simple heuristic
            if ($subscription->status === 'active') {
                $subscription->reactivation_status = 'Active';
            } elseif ($subscription->days_expired < 30) {
                $subscription->reactivation_status = 'Eligible';
            } elseif ($subscription->days_expired < 90) {
                $subscription->reactivation_status = 'Contacted';
            } else {
                $subscription->reactivation_status = 'Lost';
            }

            return $subscription;
        });

        // Calculate stats
        $totalExpired = \App\Models\Subscription::where(function ($query) {
            $query->where('status', '!=', 'active')
                  ->orWhere('end_date', '<', now());
        })->count();

        $recentlyExpired = \App\Models\Subscription::where(function ($query) {
            $query->where('status', '!=', 'active')
                  ->orWhere('end_date', '<', now());
        })->where('end_date', '>=', now()->subDays(30))->count();

        $reactivated = \App\Models\Subscription::where('status', 'active')
            ->where('updated_at', '>=', now()->subDays(30))
            ->count();

        $lostRevenue = \App\Models\Subscription::with('payments')
            ->where(function ($query) {
                $query->where('status', '!=', 'active')
                      ->orWhere('end_date', '<', now());
            })
            ->get()
            ->sum(function ($subscription) {
                return $subscription->payments->last() ? $subscription->payments->last()->amount : 0;
            });

        return view('admin.subscriptions.expired', compact(
            'expiredSubscriptions',
            'totalExpired',
            'recentlyExpired',
            'reactivated',
            'lostRevenue'
        ));
    }

    /**
     * Display billing history
     */
    public function billing()
    {
        $payments = \App\Models\Payment::with(['company', 'plan', 'subscription'])
            ->orderBy('paid_at', 'desc')
            ->paginate(15);

        // Calculate stats
        $totalRevenue = \App\Models\Payment::where('status', 'paid')->sum('amount');
        $monthlyRevenue = \App\Models\Payment::where('status', 'paid')
            ->where('paid_at', '>=', now()->startOfMonth())
            ->sum('amount');
        $pendingPayments = \App\Models\Payment::where('status', 'pending')->count();
        $failedPayments = \App\Models\Payment::where('status', 'failed')->count();

        return view('admin.subscriptions.billing', compact(
            'payments',
            'totalRevenue',
            'monthlyRevenue',
            'pendingPayments',
            'failedPayments'
        ));
    }
}