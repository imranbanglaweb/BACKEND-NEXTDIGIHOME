<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'detailed_description',
        'price',
        'compare_price',
        'stock',
        'digital',
        'file_url',
        'preview_url',
        'video_type',
        'video_url',
        'category',
        'tags',
        'thumbnail',
        'images',
        'featured',
        'active',
        'published_at',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'robots_index',
        'robots_follow'
    ];

    protected $casts = [
        'images' => 'array',
        'tags' => 'array',
        'published_at' => 'datetime',
        'featured' => 'boolean',
        'active' => 'boolean',
        'digital' => 'boolean',
        'robots_index' => 'boolean',
        'robots_follow' => 'boolean'
    ];

    public function purchases()
    {
        return $this->hasMany(ProductPurchase::class);
    }
}
