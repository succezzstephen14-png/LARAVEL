<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CmsPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'published_at',
        'scheduled_at',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'author_name',
        'reading_time',
        'is_featured',
        'view_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'seo_keywords' => 'array',
        'is_featured' => 'boolean',
    ];

    public function categories()
    {
        return $this->belongsToMany(CmsCategory::class, 'cms_category_post');
    }

    public function tags()
    {
        return $this->belongsToMany(CmsTag::class, 'cms_post_tag');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('categories', function ($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    public function scopeByTag($query, $tagSlug)
    {
        return $query->whereHas('tags', function ($q) use ($tagSlug) {
            $q->where('slug', $tagSlug);
        });
    }
}
