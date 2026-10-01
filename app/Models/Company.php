<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_name',
        'company_code',
        'email',
        'phone',
        'contact_number',
        'address',
        'logo',
        'status',
        'stripe_customer_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_trial' => 'boolean',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'features' => 'array',
    ];

    /**
     * Get the users for the company.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the units for the company.
     */
    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    /**
     * Get the departments for the company.
     */
    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get the locations for the company.
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Get the drivers for the company.
     */
    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    /**
     * Get the vehicles for the company (assuming a Vehicle model exists).
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    /**
     * Get the subscription for the company.
     */
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    /**
     * Get the AI reports for the company.
     */
    public function aiReports()
    {
        return $this->hasMany(AIReport::class);
    }

    /**
     * Get the AI maintenance alerts for the company.
     */
    public function aiMaintenanceAlerts()
    {
        return $this->hasMany(AIMaintenanceAlert::class);
    }
}
