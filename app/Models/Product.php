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
        'product_kind',
        'purchase_type',
        'validity_days',
        'validity_label',
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
        'validity_days' => 'integer',
        'robots_index' => 'boolean',
        'robots_follow' => 'boolean'
    ];

    public function purchases()
    {
        return $this->hasMany(ProductPurchase::class);
    }

    public function getPurchaseTypeLabelAttribute(): string
    {
        return [
            'one_time' => 'One-time purchase',
            'monthly_subscription' => 'Monthly subscription',
            'yearly_subscription' => 'Yearly subscription',
            'lifetime' => 'Lifetime access',
        ][$this->purchase_type] ?? ucfirst(str_replace('_', ' ', (string) $this->purchase_type));
    }

    public function getProductKindLabelAttribute(): string
    {
        return [
            'digital_download' => 'Digital download',
            'website_template' => 'Website template',
            'ecommerce_template' => 'Ecommerce template',
            'saas' => 'SaaS product',
            'course' => 'Course',
            'service' => 'Service',
            'physical' => 'Physical product',
            'other' => 'Other',
        ][$this->product_kind] ?? ucfirst(str_replace('_', ' ', (string) $this->product_kind));
    }

    public function getAccessLabelAttribute(): string
    {
        if ($this->validity_label) {
            return $this->validity_label;
        }

        if ($this->purchase_type === 'lifetime') {
            return 'Lifetime validity';
        }

        if ($this->validity_days) {
            return $this->validity_days . ' days validity';
        }

        return $this->purchase_type_label;
    }
}
