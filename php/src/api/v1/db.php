<?php
require_once "core.php";

function connect()
{
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    } catch (Exception $e) {
        $err = new ErrorMessage(ErrorType::SERVER_ERROR, "Could not connect to the database.");
        die($err);
    }
    return $conn;
}

function query($query) {
    $conn = connect();
    $data = null;
    try {
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } catch (Exception $e) {
        $err = new ErrorMessage(ErrorType::SERVER_ERROR, "An error occurred while querying the database.");
        die($err);
    }
    return $data;
}
