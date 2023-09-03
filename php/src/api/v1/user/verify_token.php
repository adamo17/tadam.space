<?php
include_once '../core.php';
if (jwt_verify(getAuthToken())) {
    $data = authorize(0);
    echo json_encode(["valid"=>$data["type"]]);
} else {
    echo json_encode(["valid"=>false]);
}
