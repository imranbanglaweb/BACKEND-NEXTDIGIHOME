<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'plan_id',
        'stripe_subscription_id',
        'stripe_customer_id',
        'status',
        'payment_status',
        'start_date',
        'end_date',
        'trial_ends_at',
        'cancelled_at',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'trial_ends_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Get the company that owns the subscription.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the plan associated with the subscription.
     */
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    /**
     * Get the payments for the subscription.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
