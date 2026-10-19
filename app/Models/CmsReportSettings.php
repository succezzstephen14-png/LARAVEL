<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;

class CmsReportSettings extends Model
{
    protected $table = 'cms_report_settings';
    
    protected $fillable = [
        'page_title',
        'page_description',
        'banner_image_url',
        'banner_color',
        'custom_css',
        'filter_settings',
        'show_export_buttons',
        'show_filters',
        'show_charts',
        'show_tables',
        'auto_refresh',
        'refresh_interval',
    ];

    protected $casts = [
        'filter_settings' => 'json',
        'show_export_buttons' => 'boolean',
        'show_filters' => 'boolean',
        'show_charts' => 'boolean',
        'show_tables' => 'boolean',
        'auto_refresh' => 'boolean',
        'refresh_interval' => 'integer',
    ];

    public static function getInstance()
    {
        return self::firstOrCreate([]);
    }
}
