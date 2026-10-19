<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference',
        'amount',
        'type',
        'data',
        'status',
        'approval_status',
        'rejection_reason',
        'approved_at',
    ];

    protected $casts = [
        'data' => 'json',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the user that owns the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
