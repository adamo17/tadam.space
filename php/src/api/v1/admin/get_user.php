<?php
include_once '../core.php';
$auth = authorize(50);

$input = file_get_contents('php://input');
$req = json_decode($input, true);

if(!isset($req["id"]) || !$req["id"]) {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No id provided."));
}
@$data = query(sprintf("SELECT * FROM users WHERE id=%s", $req["id"]));
if($data != null) {
    print_r($data[0]);
} else {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "The specified user does not exist."));
}
