<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create system roles
        $superAdmin = Role::create([
            'name' => 'super_admin',
            'display_name' => 'Super Admin',
            'description' => 'Full system access with all permissions',
            'is_system_role' => true,
            'priority' => 100,
        ]);

        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'Administrative access to most system features',
            'is_system_role' => true,
            'priority' => 80,
        ]);

        $editor = Role::create([
            'name' => 'editor',
            'display_name' => 'Editor',
            'description' => 'Content creation and editing permissions',
            'is_system_role' => true,
            'priority' => 60,
        ]);

        $moderator = Role::create([
            'name' => 'moderator',
            'display_name' => 'Moderator',
            'description' => 'Content moderation and user management',
            'is_system_role' => true,
            'priority' => 40,
        ]);

        // Assign permissions to Super Admin (all permissions)
        $allPermissions = Permission::all();
        $superAdmin->permissions()->sync($allPermissions->pluck('id'));

        // Assign permissions to Admin
        $adminPermissions = Permission::whereIn('group', [
            'users', 'drivers', 'vehicles', 'bookings', 'payments',
            'cms', 'website', 'system'
        ])->get();
        $admin->permissions()->sync($adminPermissions->pluck('id'));

        // Assign permissions to Editor
        $editorPermissions = Permission::whereIn('name', [
            'view_cms', 'manage_posts', 'manage_pages', 'manage_categories',
            'manage_tags', 'manage_media', 'publish_content',
            'view_website_settings', 'manage_appearance'
        ])->get();
        $editor->permissions()->sync($editorPermissions->pluck('id'));

        // Assign permissions to Moderator
        $moderatorPermissions = Permission::whereIn('name', [
            'view_users', 'edit_users', 'view_drivers', 'edit_drivers',
            'approve_drivers', 'view_bookings', 'edit_bookings',
            'approve_bookings', 'view_payments', 'view_cms',
            'manage_posts', 'manage_categories', 'manage_tags'
        ])->get();
        $moderator->permissions()->sync($moderatorPermissions->pluck('id'));
    }
}
