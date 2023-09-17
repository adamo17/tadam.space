<?php
include_once '../core.php';
$auth = authorize(1);

$input = file_get_contents('php://input');
$req = json_decode($input, true);

if (!isset($req["id"]) || $req["id"] == "") {
    die(new ErrorMessage(ErrorType::BAD_REQUEST, "No id provided."));
}
if (!isset($req["name"]) || $req["name"] == "") {
    $req["name"] = "Untitled Stopwatch";
}
if (!isset($req["description"]) || $req["description"] == "") {
    $req["description"] = null;
}
if (!isset($req["tags"]) || $req["tags"] == "") {
    $req["tags"] = null;
}
if (!isset($req["project"]) || $req["project"] == "") {
    $req["project"] = null;
}

$id = @htmlspecialchars($req["id"]);
$name = @htmlspecialchars($req["name"]);
$description = @htmlspecialchars($req["description"]);
$tags = @htmlspecialchars($req["tags"]);
$project = @htmlspecialchars($req["project"]);

$user_id = $auth["id"];
try {
    query(sprintf("UPDATE timers SET name='%s', description='%s', project='%s', tags='%s' WHERE id=%s AND owner=%s", $name, $description, $project, $tags, $id, $user_id));
} catch (Exception $e) {
    die(
        new ErrorMessage(
            ErrorType::SERVER_ERROR,
            "An error occurred while saving progress. Please try again later. 
If this keeps happening, please contact the Administrator."
        )
    );
}

echo json_encode(["success" => true]);