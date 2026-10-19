<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_name',
        'guest_email',
        'guest_phone',
        'title',
        'description',
        'position_type',
        'location',
        'requirements',
        'documents',
        'status',
    ];

    protected $casts = [
        'documents' => 'array',
    ];
}
