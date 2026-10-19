<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_logs';

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'model_type',
        'model_id',
        'previous_value',
        'new_value',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'previous_value' => 'array',
        'new_value' => 'array',
    ];

    /**
     * Get the user that performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log an audit event.
     */
    public static function log($action, $description, $modelType = null, $modelId = null, $previousValue = null, $newValue = null)
    {
        return static::create([
            'user_id' => auth()->id() ?? null,
            'action' => $action,
            'description' => $description,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'previous_value' => $previousValue,
            'new_value' => $newValue,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
