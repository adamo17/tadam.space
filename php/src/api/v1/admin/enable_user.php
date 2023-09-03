<?php
include_once '../core.php';
$auth = authorize(99);

$input = file_get_contents('php://input');
$req = json_decode($input, true);

if(!isset($req["id"]) || !$req["id"]) {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No id provided."));
}

query(sprintf("UPDATE users SET disabled_until=%s WHERE id=%s", time(), $req["id"]));

echo json_encode(["success" => true]);
