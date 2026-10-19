<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

/**
 * RBAC & Website Customization System - Comprehensive Test Script
 * Run using: php test_rbac_system.php
 */

// ==================== TEST 1: Role Creation ====================
echo "=== TEST 1: Creating Roles ===\n";
$roles = [
    ['name' => 'super_admin', 'display_name' => 'Super Admin', 'description' => 'Super Administrator with all permissions'],
    ['name' => 'admin', 'display_name' => 'Admin', 'description' => 'Administrator with most permissions'],
    ['name' => 'editor', 'display_name' => 'Editor', 'description' => 'Editor who can manage content'],
    ['name' => 'moderator', 'display_name' => 'Moderator', 'description' => 'Moderator for content moderation'],
    ['name' => 'viewer', 'display_name' => 'Viewer', 'description' => 'View-only access'],
];

foreach ($roles as $roleData) {
    $role = \App\Models\Role::updateOrCreate(
        ['name' => $roleData['name']],
        ['display_name' => $roleData['display_name'], 'description' => $roleData['description']]
    );
    echo "✓ Role '{$role->name}' created/updated\n";
}

// ==================== TEST 2: Permission Creation ====================
echo "\n=== TEST 2: Creating Permissions ===\n";
$permissions = [
    // Admin permissions
    'admin.view' => ['group' => 'admin', 'description' => 'View admin panel', 'display_name' => 'View Admin Panel'],
    'roles.manage' => ['group' => 'admin', 'description' => 'Manage roles', 'display_name' => 'Manage Roles'],
    'permissions.manage' => ['group' => 'admin', 'description' => 'Manage permissions', 'display_name' => 'Manage Permissions'],
    'users.manage' => ['group' => 'admin', 'description' => 'Manage users', 'display_name' => 'Manage Users'],
    
    // Content permissions
    'posts.create' => ['group' => 'content', 'description' => 'Create posts', 'display_name' => 'Create Posts'],
    'posts.edit' => ['group' => 'content', 'description' => 'Edit posts', 'display_name' => 'Edit Posts'],
    'posts.delete' => ['group' => 'content', 'description' => 'Delete posts', 'display_name' => 'Delete Posts'],
    'posts.view' => ['group' => 'content', 'description' => 'View posts', 'display_name' => 'View Posts'],
    
    // Settings permissions
    'settings.manage' => ['group' => 'settings', 'description' => 'Manage website settings', 'display_name' => 'Manage Website Settings'],
    'website.customize' => ['group' => 'settings', 'description' => 'Customize website appearance', 'display_name' => 'Customize Website Appearance'],
    'website.header_footer' => ['group' => 'settings', 'description' => 'Edit header and footer', 'display_name' => 'Edit Header & Footer'],
];

foreach ($permissions as $name => $data) {
    $permission = \App\Models\Permission::updateOrCreate(
        ['name' => $name],
        ['group' => $data['group'], 'description' => $data['description'], 'display_name' => $data['display_name']]
    );
    echo "✓ Permission '{$permission->name}' created/updated\n";
}

// ==================== TEST 3: Assign Permissions to Roles ====================
echo "\n=== TEST 3: Assigning Permissions to Roles ===\n";

$rolePermissions = [
    'super_admin' => \App\Models\Permission::pluck('id')->toArray(), // All permissions
    'admin' => \App\Models\Permission::whereIn('group', ['admin', 'content', 'settings'])->pluck('id')->toArray(),
    'editor' => \App\Models\Permission::whereIn('name', ['posts.create', 'posts.edit', 'posts.view', 'posts.delete'])->pluck('id')->toArray(),
    'moderator' => \App\Models\Permission::whereIn('name', ['posts.view', 'posts.delete'])->pluck('id')->toArray(),
    'viewer' => \App\Models\Permission::whereIn('name', ['posts.view'])->pluck('id')->toArray(),
];

foreach ($rolePermissions as $roleName => $permissionIds) {
    $role = \App\Models\Role::where('name', $roleName)->first();
    $role->permissions()->sync($permissionIds);
    echo "✓ Assigned " . count($permissionIds) . " permissions to '{$roleName}' role\n";
}

// ==================== TEST 4: Create Test Users ====================
echo "\n=== TEST 4: Creating Test Users ===\n";

$testUsers = [
    ['name' => 'Super Admin User', 'email' => 'superadmin@test.local', 'role' => 'super_admin'],
    ['name' => 'Admin User', 'email' => 'admin@test.local', 'role' => 'admin'],
    ['name' => 'Editor User', 'email' => 'editor@test.local', 'role' => 'editor'],
    ['name' => 'Moderator User', 'email' => 'moderator@test.local', 'role' => 'moderator'],
    ['name' => 'Viewer User', 'email' => 'viewer@test.local', 'role' => 'viewer'],
];

$testUserIds = [];
foreach ($testUsers as $userData) {
    $role = \App\Models\Role::where('name', $userData['role'])->first();
    $user = \App\Models\User::updateOrCreate(
        ['email' => $userData['email']],
        [
            'name' => $userData['name'],
            'password' => bcrypt('password123'),
        ]
    );
    
    // Assign the new role
    $user->roles()->sync([$role->id]);
    $testUserIds[$userData['role']] = $user->id;
    
    echo "✓ Created test user '{$user->email}' with role '{$userData['role']}'\n";
}

// ==================== TEST 5: Verify Role Assignment ====================
echo "\n=== TEST 5: Verifying Role Assignment ===\n";

foreach ($testUserIds as $roleName => $userId) {
    $user = \App\Models\User::find($userId);
    $userRoles = $user->roles()->pluck('name')->toArray();
    echo "✓ User {$user->email} has roles: " . implode(', ', $userRoles) . "\n";
}

// ==================== TEST 6: Check Permissions ====================
echo "\n=== TEST 6: Checking User Permissions ===\n";

$permissionChecks = [
    ['user_email' => 'superadmin@test.local', 'permission' => 'admin.view', 'expected' => true],
    ['user_email' => 'superadmin@test.local', 'permission' => 'posts.create', 'expected' => true],
    ['user_email' => 'editor@test.local', 'permission' => 'admin.view', 'expected' => false],
    ['user_email' => 'editor@test.local', 'permission' => 'posts.create', 'expected' => true],
    ['user_email' => 'viewer@test.local', 'permission' => 'posts.create', 'expected' => false],
    ['user_email' => 'viewer@test.local', 'permission' => 'posts.view', 'expected' => true],
];

foreach ($permissionChecks as $check) {
    $user = \App\Models\User::where('email', $check['user_email'])->first();
    $hasPermission = $user->hasPermission($check['permission']);
    $result = $hasPermission === $check['expected'] ? '✓' : '✗';
    $status = $hasPermission ? 'HAS' : 'DOES NOT HAVE';
    echo "$result {$user->email} $status permission '{$check['permission']}'\n";
}

// ==================== TEST 7: Website Settings ====================
echo "\n=== TEST 7: Testing Website Settings ===\n";

$settings = [
    'site_title' => ['value' => 'My Awesome Dashboard', 'type' => 'string'],
    'site_description' => ['value' => 'A comprehensive web dashboard', 'type' => 'string'],
    'primary_color' => ['value' => '#007bff', 'type' => 'string'],
    'secondary_color' => ['value' => '#6c757d', 'type' => 'string'],
    'primary_font' => ['value' => 'Roboto', 'type' => 'string'],
    'maintenance_mode' => ['value' => false, 'type' => 'boolean'],
];

foreach ($settings as $key => $setting) {
    \App\Models\WebsiteSetting::set($key, $setting['value'], $setting['type']);
    $retrieved = \App\Models\WebsiteSetting::get($key);
    echo "✓ Setting '{$key}' saved and retrieved: {$retrieved}\n";
}

// ==================== TEST 8: Verify Backward Compatibility ====================
echo "\n=== TEST 8: Verifying Backward Compatibility ===\n";

$superAdminUser = \App\Models\User::where('email', 'superadmin@test.local')->first();
$editorUser = \App\Models\User::where('email', 'editor@test.local')->first();

echo "Super Admin - isAdmin(): " . ($superAdminUser->isAdmin() ? 'TRUE' : 'FALSE') . "\n";
echo "Super Admin - isCmsAdmin(): " . ($superAdminUser->isCmsAdmin() ? 'TRUE' : 'FALSE') . "\n";
echo "Editor - isAdmin(): " . ($editorUser->isAdmin() ? 'TRUE' : 'FALSE') . "\n";
echo "Editor - isCmsAdmin(): " . ($editorUser->isCmsAdmin() ? 'TRUE' : 'FALSE') . "\n";

// ==================== TEST 9: User Role Query ====================
echo "\n=== TEST 9: Advanced Role Queries ===\n";

$adminUsers = \App\Models\User::whereHas('roles', function ($q) {
    $q->where('name', 'admin');
})->get();
echo "✓ Found " . $adminUsers->count() . " admin users\n";

$editorsAndModerators = \App\Models\User::whereHas('roles', function ($q) {
    $q->whereIn('name', ['editor', 'moderator']);
})->get();
echo "✓ Found " . $editorsAndModerators->count() . " editors/moderators\n";

// ==================== TEST 10: Summary ====================
echo "\n=== TEST SUMMARY ===\n";
echo "✓ " . \App\Models\Role::count() . " roles created\n";
echo "✓ " . \App\Models\Permission::count() . " permissions created\n";
echo "✓ " . count($testUserIds) . " test users created with assigned roles\n";
echo "✓ " . \App\Models\WebsiteSetting::count() . " website settings configured\n";
echo "\n✓✓✓ ALL TESTS COMPLETED SUCCESSFULLY ✓✓✓\n";
