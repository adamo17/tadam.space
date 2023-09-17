<?php
include_once "../core.php";

$input = file_get_contents('php://input');
$req = json_decode($input, true);
if(empty($req["email"]) || !isset($req["email"])) {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No email provided."));
}
$email = htmlspecialchars($req["email"]);

$result = query(sprintf("SELECT * FROM users WHERE email='%s'", $email));
if(!$result) {
    echo json_encode(["exists"=>false]);
} else {
    echo json_encode(["exists"=>true]);
}
