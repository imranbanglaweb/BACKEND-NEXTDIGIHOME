<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KnowledgeBase extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'is_published',
        'tags',
        'view_count',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'tags' => 'array',
        'view_count' => 'integer',
    ];

    // Automatically generate slug from title
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('title') && empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(SupportCategory::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeDraft($query)
    {
        return $query->where('is_published', false);
    }

    // Accessor for excerpt
    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->content), 150);
    }

    // Method to increment view count
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }
}
