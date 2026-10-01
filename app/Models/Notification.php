<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
class Notification extends DatabaseNotification
{
    protected $table = 'notifications';
    protected $keyType = 'string';
public $incrementing = false;

protected static function booted()
{
    static::creating(function ($notification) {
        $notification->id = (string) \Str::uuid();
    });
}

protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'url',
        'is_read',
    ];
}
