<?php
$db = new PDO('sqlite:database/database.sqlite');
$result = $db->query("SELECT id, name, email, role FROM users WHERE email = 'admin@example.com' LIMIT 1");
$user = $result->fetch(PDO::FETCH_ASSOC);
echo json_encode($user, JSON_PRETTY_PRINT) . "\n";
?>
