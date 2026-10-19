<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'is_system_role',
        'priority',
    ];

    protected $casts = [
        'is_system_role' => 'boolean',
        'priority' => 'integer',
    ];

    /**
     * Get the users that belong to this role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }

    /**
     * Get the permissions that belong to this role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    /**
     * Check if the role has a specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    /**
     * Assign a permission to this role.
     */
    public function assignPermission(string|Permission $permission): void
    {
        $permissionId = $permission instanceof Permission ? $permission->id : Permission::where('name', $permission)->first()?->id;

        if ($permissionId && !$this->permissions()->where('permission_id', $permissionId)->exists()) {
            $this->permissions()->attach($permissionId);
        }
    }

    /**
     * Remove a permission from this role.
     */
    public function revokePermission(string|Permission $permission): void
    {
        $permissionId = $permission instanceof Permission ? $permission->id : Permission::where('name', $permission)->first()?->id;

        if ($permissionId) {
            $this->permissions()->detach($permissionId);
        }
    }

    /**
     * Sync permissions for this role.
     */
    public function syncPermissions(array $permissions): void
    {
        $permissionIds = collect($permissions)->map(function ($permission) {
            return $permission instanceof Permission ? $permission->id : Permission::where('name', $permission)->first()?->id;
        })->filter()->toArray();

        $this->permissions()->sync($permissionIds);
    }
}
