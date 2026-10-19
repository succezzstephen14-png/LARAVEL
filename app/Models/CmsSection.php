<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsSection extends Model
{
    protected $fillable = [
        'cms_page_id',
        'title',
        'type',
        'content',
        'background_image',
        'background_color',
        'text_color',
        'button_text',
        'button_link',
        'button_color',
        'button_text_color',
        'image_url',
        'image_alt',
        'heading_style',
        'heading_size',
        'padding',
        'text_alignment',
        'layout_style',
        'order',
        'metadata',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'metadata' => 'json',
    ];

    public function page()
    {
        return $this->belongsTo(CmsPage::class, 'cms_page_id');
    }
}
