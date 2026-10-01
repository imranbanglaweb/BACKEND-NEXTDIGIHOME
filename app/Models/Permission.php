<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
     protected $table = 'permissions';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'id',
        'key ',
        'name',
        'table_name',
        'guard_name',
        'created_by',
    ];
}
