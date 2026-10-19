<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Recruitment;
use App\Models\User;

try {
    // Try to find a user with admin role
    $admin = User::whereHas('roles', function($q){ $q->whereIn('name', ['admin', 'super_admin']); })->first();
    if (! $admin) {
        $admin = User::firstWhere('role', 'admin');
    }
    if (! $admin) {
        $admin = User::first();
    }

    if (! $admin) {
        throw new Exception('No users present in users table to assign as creator.');
    }

    $r = Recruitment::create([
        'user_id' => $admin->id,
        'title' => 'CLI Admin Test Position',
        'description' => 'Created from terminal using admin user id for testing admin create route.',
        'position_type' => 'driver',
        'location' => 'Test City',
        'status' => 'open',
        'approval_status' => 'pending',
        'salary_range_min' => 1000,
        'salary_range_max' => 2000,
    ]);
    echo "CREATED: " . ($r->id ?? 'unknown') . " by user_id=" . $admin->id . "\n";
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
