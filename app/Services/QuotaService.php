<?php

namespace App\Services;

use App\Models\Company;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Cache;

class QuotaService
{
    /**
     * Check if company can perform action based on quota
     */
    public function canPerformAction(Company $company, string $action, int $count = 1): bool
    {
        $plan = $company->subscription?->plan;

        if (!$plan) {
            return false; // No active subscription
        }

        $currentUsage = $this->getCurrentUsage($company, $action);

        $limit = $this->getLimit($plan, $action);

        return ($currentUsage + $count) <= $limit;
    }

    /**
     * Get current usage for a specific action
     */
    public function getCurrentUsage(Company $company, string $action): int
    {
        return Cache::remember(
            "quota:{$company->id}:{$action}",
            3600, // Cache for 1 hour
            function () use ($company, $action) {
                switch ($action) {
                    case 'vehicles':
                        return $company->vehicles()->count();
                    case 'users':
                        return $company->users()->count();
                    case 'drivers':
                        return $company->drivers()->count();
                    case 'reports':
                        return $company->aiReports()->whereMonth('created_at', now()->month)->count();
                    case 'maintenance_alerts':
                        return $company->aiMaintenanceAlerts()->whereMonth('created_at', now()->month)->count();
                    default:
                        return 0;
                }
            }
        );
    }

    /**
     * Get limit for a specific action from plan
     */
    public function getLimit(SubscriptionPlan $plan, string $action): int
    {
        $limits = [
            'vehicles' => $plan->vehicle_limit ?? 0,
            'users' => $plan->user_limit ?? 0,
            'drivers' => $plan->driver_limit ?? 10,
            'reports' => $plan->monthly_reports ?? 50,
            'maintenance_alerts' => $plan->monthly_alerts ?? 100,
        ];

        return $limits[$action] ?? 0;
    }

    /**
     * Increment usage counter
     */
    public function incrementUsage(Company $company, string $action, int $count = 1): void
    {
        $current = $this->getCurrentUsage($company, $action);
        Cache::put("quota:{$company->id}:{$action}", $current + $count, 3600);
    }

    /**
     * Get usage statistics for dashboard
     */
    public function getUsageStats(Company $company): array
    {
        $plan = $company->subscription?->plan;

        if (!$plan) {
            return [];
        }

        $stats = [];
        $actions = ['vehicles', 'users', 'drivers', 'reports', 'maintenance_alerts'];

        foreach ($actions as $action) {
            $current = $this->getCurrentUsage($company, $action);
            $limit = $this->getLimit($plan, $action);

            $stats[$action] = [
                'current' => $current,
                'limit' => $limit,
                'percentage' => $limit > 0 ? round(($current / $limit) * 100, 1) : 0,
                'remaining' => max(0, $limit - $current),
                'status' => $this->getStatus($current, $limit),
            ];
        }

        return $stats;
    }

    /**
     * Get quota status
     */
    private function getStatus(int $current, int $limit): string
    {
        if ($limit === 0) return 'unlimited';
        if ($current === 0) return 'none';
        if ($current >= $limit) return 'exceeded';

        $percentage = ($current / $limit) * 100;

        if ($percentage >= 90) return 'critical';
        if ($percentage >= 75) return 'warning';

        return 'normal';
    }

    /**
     * Check if company is approaching quota limits
     */
    public function getQuotaAlerts(Company $company): array
    {
        $stats = $this->getUsageStats($company);
        $alerts = [];

        foreach ($stats as $resource => $data) {
            if ($data['status'] === 'critical') {
                $alerts[] = [
                    'type' => 'warning',
                    'resource' => $resource,
                    'message' => "You are approaching your {$resource} limit ({$data['current']}/{$data['limit']})",
                ];
            } elseif ($data['status'] === 'exceeded') {
                $alerts[] = [
                    'type' => 'error',
                    'resource' => $resource,
                    'message' => "You have exceeded your {$resource} limit. Upgrade your plan to continue.",
                ];
            }
        }

        return $alerts;
    }

    /**
     * Clear usage cache (useful after plan changes)
     */
    public function clearUsageCache(Company $company): void
    {
        $actions = ['vehicles', 'users', 'drivers', 'reports', 'maintenance_alerts'];

        foreach ($actions as $action) {
            Cache::forget("quota:{$company->id}:{$action}");
        }
    }

    /**
     * Check if company has unlimited access to a resource
     */
    public function hasUnlimitedAccess(Company $company, string $action): bool
    {
        $plan = $company->subscription?->plan;
        return $plan && $this->getLimit($plan, $action) === 0; // 0 means unlimited
    }
}