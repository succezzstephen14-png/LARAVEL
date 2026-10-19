<?php
// Minimal Laravel migration runner
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->handle($input = new Symfony\Component\Console\Input\ArrayInput(['command' => 'migrate']), new Symfony\Component\Console\Output\BufferedOutput());
