<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'employee_code',
        'email',
        'phone',
        'designation',
        'employee_type',
        'status',
        'address',
        'date_of_birth',
        'joining_date',
        'photo',
        'employee_order',
        'department_id',
        'unit_id',
        'location_id',
        'company_id',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joining_date' => 'date',
        'employee_order' => 'integer',
    ];

    // Relationships
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'employee_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'Inactive');
    }

    public function scopePermanent($query)
    {
        return $query->where('employee_type', 'Permanent');
    }

    public function scopeContract($query)
    {
        return $query->where('employee_type', 'Contract');
    }

    // Accessor for full name (same as name for now)
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    // Accessor for photo URL
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/employees/' . $this->photo) : asset('images/default-avatar.png');
    }
}
