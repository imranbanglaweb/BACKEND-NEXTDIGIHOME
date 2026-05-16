<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    const STATUS_SENT = 'sent';
    const STATUS_FAILED = 'failed';
    const STATUS_PENDING = 'pending';

    protected $fillable = [
        'requisition_id',
        'recipient_email',
        'subject',
        'body',
        'status',
        'error_message',
        'sent_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];
}
