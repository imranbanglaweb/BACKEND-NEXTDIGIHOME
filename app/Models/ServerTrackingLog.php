<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServerTrackingLog extends Model
{
    use HasFactory;

    protected $table = 'server_tracking_logs';

    protected $fillable = [
        'provider',
        'event_name',
        'event_id',
        'status',
        'http_code',
        'request_payload',
        'response_payload',
        'error_message',
        'ip_address',
        'lead_id',
        'order_id',
    ];

    protected $casts = [
        'request_payload' => 'array',
        'response_payload' => 'array',
        'http_code' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope to filter by provider.
     */
    public function scopeProvider($query, $provider)
    {
        return $query->where('provider', $provider);
    }

    /**
     * Scope to filter by status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get recent logs.
     */
    public function scopeRecent($query, $limit = 50)
    {
        return $query->orderBy('id', 'desc')->limit($limit);
    }
}
