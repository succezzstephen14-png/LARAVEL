$columns = DB::connection()->getSchemaBuilder()->getColumns('cms_sections');
echo json_encode(array_map(fn($col) => $col['name'], $columns), JSON_PRETTY_PRINT);
