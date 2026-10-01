<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'billing_cycle',
        'vehicle_limit',
        'user_limit',
        'driver_limit',
        'monthly_reports',
        'monthly_alerts',
        'features',
        'is_trial',
        'trial_days',
        'is_popular',
        'is_active',
        'recommended_for',
        'display_order',
        'last_updated_at',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'vehicle_limit' => 'integer',
        'user_limit' => 'integer',
        'driver_limit' => 'integer',
        'monthly_reports' => 'integer',
        'monthly_alerts' => 'integer',
        'features' => 'array',
        'is_trial' => 'boolean',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'display_order' => 'integer',
        'trial_days' => 'integer',
        'last_updated_at' => 'datetime',
    ];

    /**
     * Get the subscriptions for the plan.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
