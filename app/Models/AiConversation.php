<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiConversation extends Model
{
    use HasFactory;

    protected $table = 'ai_conversations';

    protected $fillable = [
        'session_id',
        'user_ip',
        'user_agent',
        'device_type',
        'detected_language',
        'message_count',
        'lead_name',
        'lead_phone',
        'lead_email',
        'lead_service_interest',
        'lead_status',
        'lead_synced_to_inquiries',
        'inquiry_id',
        'satisfaction_score',
        'first_message',
        'last_message',
    ];

    protected $casts = [
        'message_count' => 'integer',
        'lead_synced_to_inquiries' => 'boolean',
        'satisfaction_score' => 'integer',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(AiConversationMessage::class, 'conversation_id')->orderBy('created_at', 'asc');
    }

    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(ProjectInquiry::class, 'inquiry_id');
    }
}
