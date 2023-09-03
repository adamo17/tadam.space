<?php
include_once '../core.php';
$auth = authorize(1);

$url = 'https://www.gravatar.com/avatar/';
$url .= md5(strtolower(trim(b64url_decode($auth["email"]))));
$url .= "?s=32&d=identicon&r=g";

echo json_encode(["url" => $url]);
