<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslationValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'translation_id',
        'language_code',
        'value',
    ];

    public $timestamps = false;

    /**
     * Get the translation that owns the value.
     */
    public function translation()
    {
        return $this->belongsTo(Translation::class);
    }
}
