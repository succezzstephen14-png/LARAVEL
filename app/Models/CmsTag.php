<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CmsTag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'color',
        'usage_count',
    ];

    public function posts()
    {
        return $this->belongsToMany(CmsPost::class, 'cms_post_tag');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });

        static::updating(function ($tag) {
            if ($tag->isDirty('name') && empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }
}
