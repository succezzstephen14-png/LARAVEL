<?php
require 'bootstrap/app.php';
$app = app();
$columns = DB::connection()->getSchemaBuilder()->getColumns('cms_sections');
$names = array_map(fn($col) => $col['name'], $columns);
echo json_encode($names, JSON_PRETTY_PRINT);
