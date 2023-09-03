<?php
include_once '../core.php';
$auth = authorize(99);

$input = file_get_contents('php://input');
$req = json_decode($input, true);

if(!isset($req["id"]) || !$req["id"]) {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No id provided."));
}
if(!isset($req["time"]) || $req["time"] == "") {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "Didn't provide time."));
}

$until = time() + $req["time"];
query(sprintf("UPDATE users SET disabled_until=%s WHERE id=%s", $until, $req["id"]));

echo json_encode(["disabled_until" => $until]);
