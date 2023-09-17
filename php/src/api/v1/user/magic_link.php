<?php
include_once '../core.php';

if(empty($_GET["code"]) || !isset($_GET["code"])) {
    header('Location: /verification/magic_link_error.html?error=No%20code%20provided.');
}
if(empty($_GET["token"]) || !isset($_GET["token"])) {
    header('Location: /verification/magic_link_error.html?error=No%20MLT%20provided.');
}

$code = htmlspecialchars($_GET["code"]);
$token = htmlspecialchars($_GET["token"]);

$result = query(sprintf("SELECT * FROM verification_codes WHERE code='%s' AND magic_link_token='%s'", "ts_".$code, $token));
if($result == null) {
    header('Location: /verification/magic_link_error.html?error=Invalid%20code.');
}
if($result[0]["valid_until"] >= time()) {
    $user_id = $result[0]["user_id"];
    query(sprintf("DELETE FROM verification_codes WHERE code=%s", $code));
    query(sprintf("UPDATE users SET type=1 WHERE id=%s", $user_id));
    header('Location: /verification/magic_link.html');
} else {
    header('Location: /verification/magic_link_error.html?error=Expired%20code.');
}