<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Unique credentials
$name = 'System Administrator';
$email = 'system.admin@dashboard.local';
$password = 'SysAdm@2026!';

// Check if admin already exists
$existing = User::where('email', $email)->first();
if ($existing) {
    $existing->update([
        'name' => $name,
        'password' => Hash::make($password),
        'role' => 'admin',
    ]);
    echo "Admin user updated successfully!\n";
} else {
    // Create the admin user
    $user = User::create([
        'name' => $name,
        'email' => $email,
        'password' => Hash::make($password),
        'role' => 'admin',
    ]);
    echo "Admin user created successfully!\n";
}
echo "Name: $name\n";
echo "Email: $email\n";
echo "Password: $password\n";
echo "Role: admin\n";