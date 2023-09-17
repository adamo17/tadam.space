<?php
include_once '../core.php';
$auth = authorize(0);

if ($auth["type"] != 0) {
    die(new ErrorMessage(ErrorType::FORBIDDEN, "Already verified."));
}

$input = file_get_contents('php://input');
$req = json_decode($input, true);
if(empty($req["code"]) || !isset($req["code"])) {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No code provided."));
}
$code = htmlspecialchars($req["code"]);

$result = query(sprintf("SELECT * FROM verification_codes WHERE code='%s' AND user_id=%s", "ts_".$code, $auth["id"]));
if($result == null) {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "Invalid code."));
}
if($result[0]["valid_until"] >= time()) {
    query(sprintf("DELETE FROM verification_codes WHERE code='%s'", "ts_".$code));
    query(sprintf("UPDATE users SET type=1 WHERE id=%s", $auth["id"]));
    die(new ErrorMessage(ErrorType::SUCCESS, "Successfully verified."));
} else {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "Expired code."));
}