<?php
include_once '../core.php';
$auth = authorize(1);

$data = query(sprintf("SELECT * FROM timers WHERE owner=%s ORDER BY id DESC", $auth["id"]));
echo json_encode($data);