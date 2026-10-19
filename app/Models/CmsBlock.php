<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsBlock extends Model
{
    protected $fillable = [
        'name',
        'title',
        'description',
        'content',
        'block_type',
        'settings',
        'thumbnail',
        'usage_count',
    ];

    protected $casts = [
        'settings' => 'json',
    ];
}
