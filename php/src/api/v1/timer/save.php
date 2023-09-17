<?php
include_once '../core.php';
$auth = authorize(1);

$input = file_get_contents('php://input');
$req = json_decode($input, true);

if(!isset($req["id"]) || !$req["id"]) {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No id provided."));
}
if(!isset($req["elapsed"]) || !$req["elapsed"]) {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "Didn't provide elapsed time."));
}

$id = htmlspecialchars($req["id"]);
$elapsed = htmlspecialchars($req["elapsed"]);

$user_id = $auth["id"];
try {
    query(sprintf("UPDATE timers SET elapsed='%s' WHERE id=%s AND owner=%s", $elapsed, $id, $user_id));
} catch (Exception $e) {
    die(new ErrorMessage(ErrorType::SERVER_ERROR, 
        "An error occurred while saving progress. Please try again later. 
If this keeps happening, please contact the Administrator."));
}

echo json_encode(["success"=>true]);
