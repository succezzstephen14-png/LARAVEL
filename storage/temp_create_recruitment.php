<?php
// Temporary script to create a recruitment via Laravel bootstrap for testing
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Recruitment;

try {
    $r = Recruitment::create([
        'user_id' => null,
        'title' => 'CLI Test Position',
        'description' => 'Created from terminal for testing admin create route.',
        'position_type' => 'driver',
        'location' => 'Test City',
        'status' => 'open',
        'approval_status' => 'pending',
        'salary_range_min' => 1000,
        'salary_range_max' => 2000,
    ]);
    echo "CREATED: " . ($r->id ?? 'unknown') . "\n";
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
