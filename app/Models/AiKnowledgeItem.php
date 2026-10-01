<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiKnowledgeItem extends Model
{
    use HasFactory;

    protected $table = 'ai_knowledge_items';

    protected $fillable = [
        'title',
        'category',
        'keywords',
        'content_en',
        'content_bn',
        'content_banglish',
        'suggested_questions',
        'actions',
        'matched_items',
        'priority',
        'hit_count',
        'is_active',
    ];

    protected $casts = [
        'suggested_questions' => 'array',
        'actions' => 'array',
        'matched_items' => 'array',
        'priority' => 'integer',
        'hit_count' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get content based on requested language
     */
    public function getContentForLanguage(string $lang): string
    {
        if ($lang === 'bn' && !empty($this->content_bn)) {
            return $this->content_bn;
        }
        if ($lang === 'banglish' && !empty($this->content_banglish)) {
            return $this->content_banglish;
        }
        return $this->content_en ?? $this->content_bn ?? $this->content_banglish ?? '';
    }
}
