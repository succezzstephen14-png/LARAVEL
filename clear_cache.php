<?php
chdir(__DIR__);
require 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

// Clear caches
$kernel->call('cache:clear');
$kernel->call('view:clear');

echo "✓ Cache and view cache cleared successfully\n";
?>
