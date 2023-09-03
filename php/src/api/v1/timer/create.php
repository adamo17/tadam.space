<?php
include_once '../core.php';
$auth = authorize(1);

$input = file_get_contents('php://input');
$req = json_decode($input, true);

if(!isset($req["name"]) || !$req["name"]) {
    // die(new ErrorMessage(ErrorType::BAD_REQUEST, "No name provided."));
    $req["name"] = date("m/d/Y H:i:s", time());
}
if(!isset($req["description"]) || !$req["description"]) {
    // die(new ErrorMessage(ErrorType::BAD_REQUEST, "No description provided."));
    $req["description"] = null;
}
if(!isset($req["tags"]) || !$req["tags"]) {
    // die(new ErrorMessage(ErrorType::BAD_REQUEST, "No tags provided."));
    $req["tags"] = null;
}
if(!isset($req["project"]) || !$req["project"]) {
    // die(new ErrorMessage(ErrorType::BAD_REQUEST, "No project provided."));
    $req["project"] = null;
}

$name = @htmlspecialchars($req["name"]);
$description = @htmlspecialchars($req["description"]);
$tags = @htmlspecialchars($req["tags"]);
$project = @htmlspecialchars($req["project"]);

$user_id = $auth["id"];

$data = query(sprintf("SELECT * FROM timers WHERE name='%s' AND owner=%s", $name, $user_id));
if($data != null) {
    die(new ErrorMessage(ErrorType::ALREADY_EXISTS, "A timer with this name already exists."));
}

query(sprintf("INSERT INTO timers (name, description, tags, project, elapsed, owner) 
    VALUES ('%s', '%s', '%s', '%s', %s, %s)",
    $name, $description, $tags, $project, 0, $user_id));

$data = query(sprintf("SELECT * FROM timers WHERE name='%s' AND owner=%s", $name, $user_id));

echo json_encode(["id"=>$data["0"]["id"]]);