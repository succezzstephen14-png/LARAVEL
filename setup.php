<?php
// Simple setup script to initialize the Laravel application
// This bypasses composer dependency issues

// Check if bootstrap files exist
if (!file_exists(__DIR__ . '/bootstrap/app.php')) {
    echo "Error: bootstrap/app.php not found\n";
    exit(1);
}

// Require the bootstrap file
require_once __DIR__ . '/bootstrap/app.php';

// Get the application
$app = require_once __DIR__ . '/bootstrap/app.php';

// Bind the kernel
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

// Handle the migration
$exitCode = $kernel->call('migrate', [
    '--force' => true,
    '--quiet' => false,
]);

echo "Migrations completed with exit code: $exitCode\n";

// If migrations succeeded, seed the database
if ($exitCode === 0) {
    echo "Running seeders...\n";
    $exitCode = $kernel->call('db:seed', [
        '--force' => true,
        '--quiet' => false,
    ]);
    echo "Seeding completed with exit code: $exitCode\n";
}

exit($exitCode);
?>
