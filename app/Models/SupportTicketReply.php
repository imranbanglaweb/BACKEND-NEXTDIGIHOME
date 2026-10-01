<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicketReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'message',
        'is_internal',
        'attachments',
        'created_by',
    ];

    protected $casts = [
        'is_internal' => 'boolean',
        'attachments' => 'array',
    ];

    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
