<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'group',
    ];

    /**
     * Get the roles that have this permission.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    /**
     * Get permissions by group.
     */
    public static function getByGroup(string $group): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('group', $group)->orderBy('display_name')->get();
    }

    /**
     * Get all permission groups.
     */
    public static function getGroups(): array
    {
        return static::distinct('group')->pluck('group')->toArray();
    }
}
