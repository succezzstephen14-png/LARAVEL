<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index(): View
    {
        $roles = Role::with('permissions')->paginate(15);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        $permissions = Permission::groupBy('group')->get()->groupBy('group');

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name|max:255',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'priority' => 'integer|min:0|max:999',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'display_name' => $validated['display_name'],
            'description' => $validated['description'] ?? null,
            'priority' => $validated['priority'] ?? 0,
        ]);

        if (!empty($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        return redirect()->route('roles.show', $role)
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role): View
    {
        $role->load('permissions', 'users');

        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role): View
    {
        if ($role->is_system_role) {
            abort(403, 'System roles cannot be edited.');
        }

        $permissions = Permission::all()->groupBy('group');
        $rolePermissions = $role->permissions()->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        if ($role->is_system_role) {
            abort(403, 'System roles cannot be edited.');
        }

        $validated = $request->validate([
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'priority' => 'integer|min:0|max:999',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'display_name' => $validated['display_name'],
            'description' => $validated['description'] ?? null,
            'priority' => $validated['priority'] ?? 0,
        ]);

        $role->permissions()->sync($validated['permissions'] ?? []);

        return redirect()->route('roles.show', $role)
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        if ($role->is_system_role) {
            abort(403, 'System roles cannot be deleted.');
        }

        if ($role->users()->exists()) {
            return back()->with('error', 'Cannot delete role that is assigned to users.');
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    /**
     * Assign multiple permissions to a role.
     */
    public function assignPermissions(Request $request, Role $role): RedirectResponse
    {
        if ($role->is_system_role) {
            abort(403, 'System roles cannot be edited.');
        }

        $validated = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->permissions()->sync($validated['permissions'] ?? []);

        return back()->with('success', 'Permissions updated successfully.');
    }
}
