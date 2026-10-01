<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Language extends Model
{
    protected $fillable = [
        'code',
        'name',
        'native_name',
        'direction',
        'is_default',
        'is_active',
        'flag_icon',
        'sort_order'
    ];
    
    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
    
    public function translationValues()
    {
        return $this->hasMany(TranslationValue::class, 'language_code', 'code');
    }
}