<?php
include_once '../core.php';
$auth = authorize(1);

$input = file_get_contents('php://input');
$req = json_decode($input, true);

if(!isset($req["id"]) || !$req["id"]) {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No id provided."));
}

$id = htmlspecialchars($req["id"]);

$user_id = $auth["id"];
try{
    $last_id = query(sprintf("SELECT MAX(id) as id FROM timers 
        WHERE owner=%s AND timer_id=%s AND end IS NOT NULL", $user_id, $req["id"]))[0]["id"];

    $old_data = query(sprintf("SELECT * FROM timers WHERE id=%s", $last_id));
    $name = $old_data[0]["name"];
    $description = $old_data[0]["description"];
    $tags = $old_data[0]["tags"];
    $project = $old_data[0]["project"];

    query(sprintf("INSERT INTO timers (name, description, tags, project, start, owner, timer_id) 
        VALUES ('%s', '%s', '%s', '%s', %s, %s, %s)",
        $name, $description, $tags, $project, time(), $user_id, $id));
} catch (Exception $e) {
    die(new ErrorMessage(ErrorType::SERVER_ERROR, 
        "An error occurred while pausing. Please try again later. If this keeps happening, please contact the Administrator."));
}

echo json_encode(["success"=>true]);
