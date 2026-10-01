<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlider extends Model
{
    use HasFactory;

    protected $appends = [
        'image_url',
        'image_alt',
        'image_display',
    ];

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'cta_text',
        'cta_link',
        'image',
        'background_color',
        'text_color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (preg_match('/^(https?:)?\/\//', $this->image) || str_starts_with($this->image, 'data:')) {
            return $this->image;
        }

        $path = ltrim($this->image, '/');

        if (str_starts_with($path, 'public/')) {
            return asset($path);
        }

        if (str_starts_with($path, 'images/')) {
            return asset('public/'.$path);
        }

        return asset('public/storage/'.$path);
    }

    public function getImageAltAttribute(): string
    {
        return $this->title ?: $this->subtitle ?: 'Homepage slider image';
    }

    public function getImageDisplayAttribute(): array
    {
        return [
            'width' => 1440,
            'height' => 720,
            'aspect_ratio' => '2/1',
            'object_fit' => 'cover',
            'sizes' => '(max-width: 640px) 100vw, (max-width: 1200px) 100vw, 1440px',
            'container' => [
                'width' => '100%',
                'max_width' => '1440px',
                'min_height_mobile' => '360px',
                'min_height_desktop' => '520px',
            ],
        ];
    }
}
