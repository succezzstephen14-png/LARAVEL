<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CmsMedia extends Model
{
    protected $fillable = [
        'name',
        'file_name',
        'mime_type',
        'path',
        'disk',
        'file_size',
        'dimensions',
        'alt_text',
        'description',
        'folder',
        'is_public',
    ];

    protected $casts = [
        'dimensions' => 'array',
        'is_public' => 'boolean',
    ];

    protected $appends = ['url', 'thumbnail_url'];

    public function getUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function getThumbnailUrlAttribute()
    {
        // For images, return a thumbnail version if it exists
        if (str_starts_with($this->mime_type, 'image/')) {
            $thumbnailPath = str_replace('/uploads/', '/uploads/thumbnails/', $this->path);
            if (Storage::disk($this->disk)->exists($thumbnailPath)) {
                return Storage::disk($this->disk)->url($thumbnailPath);
            }
        }
        return $this->url;
    }

    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function scopeImages($query)
    {
        return $query->where('mime_type', 'like', 'image/%');
    }

    public function scopeVideos($query)
    {
        return $query->where('mime_type', 'like', 'video/%');
    }

    public function scopeDocuments($query)
    {
        return $query->whereIn('mime_type', [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'text/plain',
        ]);
    }

    public function scopeByFolder($query, $folder)
    {
        return $query->where('folder', $folder);
    }
}
