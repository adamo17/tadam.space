<?php
include_once '../core.php';

$input = file_get_contents('php://input');
$req = json_decode($input, true);

if(!isset($req["username"]) || $req["username"] == "") {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No username provided."));
}
if(!isset($req["email"]) || $req["email"] == "") {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No email provided."));
}

$username = htmlspecialchars($req["username"]);
$email = htmlspecialchars($req["email"]);

$isAvailableData = query(sprintf("SELECT * FROM users WHERE username=%s", $username));
if($isAvailableData != "") {
    die(new ErrorMessage(ErrorType::ALREADY_EXISTS, "Username already exists."));
}

$alreadyHasUsernameData = query(sprintf("SELECT * FROM users WHERE email=%s", $username));
if($alreadyHasUsernameData == "") {
    die(new ErrorMessage(ErrorType::NOT_FOUND, "Account not found."));
}
if($alreadyHasUsernameData[0]["username"] != "") {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "Account already has an username."));
}

query(sprintf("UPDATE users SET username=%s WHERE email=%s", $username, $email));

$data = query(sprintf("SELECT * FROM users WHERE username=%s", $username))[0];
$token = jwt_make($data["id"], $data["username"], $data["email"], $data["type"]);

echo json_encode(["token"=>$token]);
