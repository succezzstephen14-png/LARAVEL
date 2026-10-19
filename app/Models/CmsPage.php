<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'seo_title',
        'seo_description',
        'template',
        'is_published',
        'is_home',
        'order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_home' => 'boolean',
    ];

    public function sections()
    {
        return $this->hasMany(CmsSection::class)->orderBy('order');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
