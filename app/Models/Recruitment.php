<?php

namespace App\Models;

use App\Models\Concerns\HasAlphanumericId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    use HasFactory, HasAlphanumericId;

    public $incrementing = false;

    protected $keyType = 'string';

    protected function getIdPrefix(): string
    {
        return 'REC';
    }

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'position_type',
        'location',
        'requirements',
        'job_brief',
        'offer_document',
        'salary_range_min',
        'salary_range_max',
        'status',
        'approval_status',
        'payment_status',
        'payment_reference',
        'posted_at',
        'tracking_status',
        'tracking_location',
        'tracking_notes',
        'tracking_updated_at',
    ];

    protected $casts = [
        'salary_range_min' => 'decimal:2',
        'salary_range_max' => 'decimal:2',
        'posted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tracking_updated_at' => 'datetime',
    ];

    /**
     * Get the user that posted the recruitment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all open recruitment positions.
     */
    public static function open()
    {
        return self::where('status', 'open');
    }

    /**
     * Scope a query to only approved recruitments.
     */
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    /**
     * Get salary range as formatted string.
     */
    public function getSalaryRangeAttribute()
    {
        if ($this->salary_range_min && $this->salary_range_max) {
            $currency = config('app.currency_label', 'GHC');

            return $currency . ' ' . number_format($this->salary_range_min, 2)
                . ' - ' . $currency . ' ' . number_format($this->salary_range_max, 2);
        }
        return 'Not specified';
    }
}
