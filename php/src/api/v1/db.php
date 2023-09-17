<?php
require_once "core.php";

function connect()
{
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    } catch (Exception $e) {
        $err = new ErrorMessage(ErrorType::SERVER_ERROR, "Could not connect to the database. Please try again or contact the administrator.");
        die($err);
    }
    return $conn;
}

function query($query)
{
    $conn = connect();
    $data = null;
    if (explode(" ", $query)[0] == "SELECT") {
        // try {
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        // } catch (Exception $e) {
        //     $err = new ErrorMessage(ErrorType::SERVER_ERROR, "An error occurred while querying the database. Please try again or contact the administrator.");
        //     die($err);
        // }
    } else {
        // try {
            $result = $conn->query($query);
            $data = True;
        // } catch (Exception $e) {
        //     $err = new ErrorMessage(ErrorType::SERVER_ERROR, "An error occurred while querying the database. Please try again or contact the administrator.");
        //     die($err);
        // }
    }
    return $data;
}