<?php
// Simple script to update admin user
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');

// Access database
$pdo = $app['db']->connection()->getPdo();

// Update admin user
$pdo->exec("UPDATE users SET role = 'admin', onboarding_completed = 1 WHERE email = 'admin@example.com'");

echo "Admin user updated successfully!\n";
?>
