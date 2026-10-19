<?php

namespace App\Models;

use App\Models\Concerns\HasAlphanumericId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory, HasAlphanumericId;

    public $incrementing = false;

    protected $keyType = 'string';

    protected function getIdPrefix(): string
    {
        return 'DRV';
    }

    protected $fillable = [
        'user_id',
        'dob',
        'license_number',
        'license_file',
        'license_expiry',
        'license_class',
        'ghana_card_no',
        'ghana_card_file',
        'passport_file',
        'experience_years',
        'guarantor',
        'guarantor_phone',
        'g_ghana_card_no',
        'guarantor_ghana_card_file',
        'relationship',
        'emergency_person',
        'emergency_phone',
        'status',
        'approval_status',
        'approved_at',
        'rejection_reason',
        'bio',
        'profile_picture',
        'rating',
        'total_trips',
        'payment_status',
        'payment_reference',
        'tracking_status',
        'tracking_location',
        'tracking_notes',
        'tracking_updated_at',
        'latitude',
        'longitude',
        'last_location_update',
    ];

    protected $casts = [
        'license_expiry' => 'date',
        'approved_at' => 'datetime',
        'rating' => 'float',
        'total_trips' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'last_location_update' => 'datetime',
        'tracking_updated_at' => 'datetime',
    ];

    /**
     * Get the user that is the driver.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get profile picture URL with fallback.
     */
    public function getProfilePictureUrl()
    {
        if ($this->profile_picture && file_exists(storage_path('app/public/' . $this->profile_picture))) {
            return asset('storage/' . $this->profile_picture);
        }
        // Fallback to initials avatar
        return null;
    }

    /**
     * Check if driver has a profile picture.
     */
    public function hasProfilePicture(): bool
    {
        return !is_null($this->profile_picture) && file_exists(storage_path('app/public/' . $this->profile_picture));
    }

    /**
     * Get all available drivers.
     */
    public static function available()
    {
        return self::where('status', 'available');
    }

    /**
     * Scope a query to only approved drivers.
     */
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    /**
     * Check if driver license is expired.
     */
    public function isLicenseExpired(): bool
    {
        return $this->license_expiry < now();
    }

    /**
     * Update driver rating.
     */
    public function updateRating($newRating)
    {
        $this->rating = ($this->rating + $newRating) / 2;
        $this->save();
    }
}
