<?php
require_once "../core.php";

$input = file_get_contents('php://input');
$req = json_decode($input, true);

// print_r($req);
// print_r(getallheaders());

if(!isset($req["username"]) || $req["username"] == "") {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No username provided."));
}
if(!isset($req["password"]) || $req["password"] == "") {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No password provided."));
}
$username = htmlspecialchars($req["username"]);
$password = htmlspecialchars($req["password"]);

$data = query(sprintf("SELECT * FROM users WHERE username = '%s'", $username));

// die(new ErrorMessage(ErrorType::LOCKED, "This resource is locked."));

// verifying
if(@$data[0]["password"] == $password) {
    if($data[0]["disabled_until"] > time()) {
        if($data[0]["disabled_until"] > 11693582062) {
            die(new ErrorMessage(ErrorType::ACCOUNT_DISABLED, "This account is disabled indefinitely."));
        }
        die(new ErrorMessage(ErrorType::ACCOUNT_DISABLED,
            sprintf("This account is disabled until %s.", date("m/d/Y H:i:s", $data[0]["disabled_until"]))));
    }
    // echo b64url_decode($data[0]["username"]);
    echo json_encode(["token" => jwt_make($data[0]["id"], $data[0]["username"], $data[0]["email"], $data[0]["type"])]);
} else {
    die(new ErrorMessage(ErrorType::FORBIDDEN, "Invalid username or password."));
}
