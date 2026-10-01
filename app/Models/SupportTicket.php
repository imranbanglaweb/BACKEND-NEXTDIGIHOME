<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'subject',
        'description',
        'status',
        'priority',
        'category_id',
        'customer_id',
        'assigned_to',
        'created_by',
        'updated_by',
        'last_reply_at',
        'tags',
    ];

    protected $casts = [
        'last_reply_at' => 'datetime',
        'tags' => 'array',
    ];

    // Automatically generate ticket number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = 'TICK-' . strtoupper(Str::random(8));
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(SupportCategory::class, 'category_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function replies()
    {
        return $this->hasMany(SupportTicketReply::class, 'ticket_id')->orderBy('created_at', 'asc');
    }

    public function latestReply()
    {
        return $this->hasOne(SupportTicketReply::class, 'ticket_id')->latestOfMany();
    }

    // Status scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    // Priority scopes
    public function scopeLowPriority($query)
    {
        return $query->where('priority', 'low');
    }

    public function scopeMediumPriority($query)
    {
        return $query->where('priority', 'medium');
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }

    public function scopeUrgentPriority($query)
    {
        return $query->where('priority', 'urgent');
    }
}
