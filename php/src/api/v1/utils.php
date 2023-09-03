<?php
include_once 'core.php';

function authorize(int $min_level = 1) {
    $headers = getallheaders();
    if (!array_key_exists('Authorization', $headers)) {
        die(new ErrorMessage(ErrorType::FORBIDDEN, "Authorization not specified."));
    }
    if (substr($headers['Authorization'], 0, 7) !== 'Bearer ') {
        die(new ErrorMessage(ErrorType::FORBIDDEN, "Invalid authorization header."));
    }
    $token = trim(substr($headers['Authorization'], 6));
    $data = jwt_verify($token);
    if(!$data){
        die(new ErrorMessage(ErrorType::FORBIDDEN, "Invalid token."));
    }
    if(!($data["type"] >= $min_level)) {
        die(new ErrorMessage(ErrorType::UNAUTHORIZED, "You are not permitted to access this resource."));
    }
    return $data;
}

function getAuthToken() {
    $headers = getallheaders();
    if (!array_key_exists('Authorization', $headers)) {
        die(new ErrorMessage(ErrorType::FORBIDDEN, "Authorization not specified."));
    }
    if (substr($headers['Authorization'], 0, 7) !== 'Bearer ') {
        die(new ErrorMessage(ErrorType::FORBIDDEN, "Invalid authorization header."));
    }
    return trim(substr($headers['Authorization'], 6));
}
