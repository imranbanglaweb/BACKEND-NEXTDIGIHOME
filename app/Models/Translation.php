<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $table = 'translations';

    protected $fillable = [
        'group',
        'key',
        'text',
    ];

    public $timestamps = false;

    /**
     * Get the values for the translation.
     */
    public function values()
    {
        return $this->hasMany(TranslationValue::class, 'translation_id');
    }
}
