<?php
include_once "../core.php";

$input = file_get_contents('php://input');
$req = json_decode($input, true);
if(empty($req["username"]) || !isset($req["username"])) {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No username provided."));
}
$username = htmlspecialchars($req["username"]);

$result = query(sprintf("SELECT * FROM users WHERE username='%s'", $username));
if(!$result) {
    echo json_encode(["exists"=>false]);
} else {
    echo json_encode(["exists"=>true]);
}
