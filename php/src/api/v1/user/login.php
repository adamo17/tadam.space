<?php
require_once "../core.php";

// Getting the vars from the POST req
if(!isset($_POST["username"]) || $_POST["username"] == "") {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No username provided."));
}
if(!isset($_POST["password"]) || $_POST["password"] == "") {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No password provided."));
}
$username = htmlspecialchars($_POST["username"]);
$password = htmlspecialchars($_POST["password"]);

// Getting the pwd from the db
$data = query(sprintf("SELECT password FROM users WHERE username = '%s'", $username));

// verifying
if(@$data[0]["password"] == $password) {
    $id = query(sprintf("SELECT id FROM users WHERE username = '%s'", $username))[0]["id"];
    echo json_encode(["id" => $id]);
} else {
    die(new ErrorMessage(ErrorType::FORBIDDEN, "Invalid username or password."));
}
