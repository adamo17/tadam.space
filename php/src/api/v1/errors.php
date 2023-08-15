<?php

enum ErrorType {
    case SUCCESS;
    case SERVER_ERROR;
    case BAD_REQUEST;
    case FORBIDDEN;
    case METHOD_NOT_ALLOWED;
    case LOCKED;
    case TOO_MANY_REQUESTS;
    case NOT_IMPLEMENTED;
}

class ErrorMessage {
    private $json = null;
    public $errorCode = "0x0";

    public function __construct(ErrorType $error, String $message) {
        switch ($error) {

            case ErrorType::SUCCESS:
                $this->errorCode = "0x0";
                $this->json = json_encode(["code" => $this->errorCode, "message" => $message]);
                http_response_code(200);
                break;

            case ErrorType::SERVER_ERROR:
                $this->errorCode = "0x1";
                $this->json = json_encode(["code" => $this->errorCode, "message" => $message]);
                http_response_code(500);
                break;

            case ErrorType::BAD_REQUEST:
                $this->errorCode = "0x2";
                $this->json = json_encode(["code" => $this->errorCode, "message" => $message]);
                http_response_code(400);
                break;

            case ErrorType::FORBIDDEN:
                $this->errorCode = "0x3";
                $this->json = json_encode(["code" => $this->errorCode, "message" => $message]);
                http_response_code(403);
                break;

            case ErrorType::METHOD_NOT_ALLOWED:
                $this->errorCode = "0x4";
                $this->json = json_encode(["code" => $this->errorCode, "message" => $message]);
                http_response_code(405);
                break;

            case ErrorType::LOCKED:
                $this->errorCode = "0x5";
                $this->json = json_encode(["code" => $this->errorCode, "message" => $message]);
                http_response_code(403);
                break;

            case ErrorType::TOO_MANY_REQUESTS:
                $this->errorCode = "0x6";
                $this->json = json_encode(["code" => $this->errorCode, "message" => $message]);
                http_response_code(429);
                break;

            case ErrorType::NOT_IMPLEMENTED:
                $this->errorCode = "0x7";
                $this->json = json_encode(["code" => $this->errorCode, "message" => $message]);
                http_response_code(501);
                break;
        }
    }

    public function __toString() {
        return $this->json;
    }
}
