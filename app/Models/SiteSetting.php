<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_title',
        'site_description',
        'primary_color',
        'secondary_color',
        'font_family',
        'font_color',
        'background_color',
        'background_image',
        'custom_css',
        'home_page_content',
        'footer_text',
    ];
}
