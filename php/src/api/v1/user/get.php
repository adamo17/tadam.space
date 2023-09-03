<?php
include_once '../core.php';
$auth = authorize(0);

$data = query(sprintf("SELECT id, username, email, type, disabled_until FROM users WHERE id=%s", $auth["id"]));
print_r($data[0]);
