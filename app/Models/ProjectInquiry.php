<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInquiry extends Model
{
    use HasFactory;

    protected $table = 'project_inquiries';

    protected $fillable = [
        'lead_id',
        'name',
        'email',
        'phone',
        'whatsapp',
        'company',
        'website',
        'service',
        'service_details',
        'budget',
        'timeline',
        'contact_method',
        'lead_source',
        'landing_page',
        'referrer',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content',
        'utm_term',
        'first_touch_json',
        'last_touch_json',
        'event_id',
        'message',
        'file_name',
        'file_size',
        'file_type',
        'status',
        'priority',
        'lead_score',
        'score_reasons',
        'notes',
        'follow_up',
        'assigned_to',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'service_details' => 'array',
        'first_touch_json' => 'array',
        'last_touch_json' => 'array',
        'score_reasons' => 'array',
        'notes' => 'array',
        'follow_up' => 'array',
        'lead_score' => 'integer',
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

    public function scopePriority($query, $priority)
    {
        if (!empty($priority) && $priority !== 'all') {
            return $query->where('priority', $priority);
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
