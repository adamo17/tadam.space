<?php
include_once '../core.php';
$auth = authorize(1);

$input = file_get_contents('php://input');
$req = json_decode($input, true);

if(!isset($req["id"]) || !$req["id"]) {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No id provided."));
}

$id = htmlspecialchars($req["id"]);

$user_id = $auth["id"];
$timer = query(sprintf("SELECT * FROM timers 
    WHERE id=%s AND owner=%s", $id, $user_id));
if($timer == null) {
    die(new ErrorMessage(ErrorType::NOT_FOUND, sprintf("Timer with id %s not found.", $id)));
}

echo json_encode($timer["0"]);