<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CompanyScope;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'company_id',
        'user_id',
        'plan_id',
        'subscription_id',
        'method',
        'amount',
        'currency',
        'transaction_id',
        'sender_number',
        'note',
        'status',
        'paid_at',
        'created_by',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new CompanyScope);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
     public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }
}
