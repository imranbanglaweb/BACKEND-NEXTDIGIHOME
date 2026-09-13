<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInquiry extends Model
{
    use HasFactory;

    protected $table = 'project_inquiries';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'service',
        'budget',
        'timeline',
        'message',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeStatus($query, $status)
    {
        if (!empty($status) && $status !== 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
