<?php
include_once '../core.php';

$input = file_get_contents('php://input');
$req = json_decode($input, true);

if(!isset($req["username"]) || trim($req["username"]) == "") {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No username provided."));
}
if(!isset($req["email"]) || trim($req["email"]) == "") {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No email provided."));
}
if(!isset($req["password"]) || trim($req["password"]) == "") {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No password provided."));
}

$username = htmlspecialchars($req["username"]);
$email = htmlspecialchars($req["email"]);
$password = htmlspecialchars($req["password"]);

// echo $username . "<br/>" . $email . "<br/>" . $password;

$data = query(sprintf("SELECT id FROM users WHERE username='%s'", $username));
if($data != null) {
    die(new ErrorMessage(ErrorType::ALREADY_EXISTS, "An user with this username already exists."));
}
$data = query(sprintf("SELECT id FROM users WHERE email='%s'", $email));
if($data != null) {
    die(new ErrorMessage(ErrorType::ALREADY_EXISTS, "An user with this email already exists."));
}

// if(strlen($password) < 8) {
//     die(new ErrorMessage(ErrorType::BAD_REQUEST, "Password needs to be at least 8 in length."));
// }

query(sprintf("INSERT INTO users (username, email, password) VALUES ('%s', '%s', '%s')", $username, $email, $password));

$data = query(sprintf("SELECT * FROM users WHERE username='%s'", $username));
echo json_encode(["token" => jwt_make($data[0]["id"], $data[0]["username"], $data[0]["email"], $data[0]["type"])]);
