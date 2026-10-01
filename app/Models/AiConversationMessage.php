<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiConversationMessage extends Model
{
    use HasFactory;

    protected $table = 'ai_conversation_messages';

    protected $fillable = [
        'conversation_id',
        'sender',
        'message',
        'language',
        'provider_used',
        'response_time_ms',
        'tokens_used',
        'retrieved_knowledge_ids',
        'feedback',
        'metadata',
    ];

    protected $casts = [
        'response_time_ms' => 'integer',
        'tokens_used' => 'integer',
        'retrieved_knowledge_ids' => 'array',
        'metadata' => 'array',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(AiConversation::class, 'conversation_id');
    }
}
