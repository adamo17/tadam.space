<?php
include_once '../core.php';
$auth = authorize(50);

$data = query("SELECT * FROM users");
print_r($data);
