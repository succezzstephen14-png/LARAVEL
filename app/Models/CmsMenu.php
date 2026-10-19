<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsMenu extends Model
{
    protected $fillable = [
        'name',
        'location',
        'items',
        'order',
    ];

    protected $casts = [
        'items' => 'json',
    ];
}
