<?php
include_once 'core.php';

function b64url_encode($string)
{
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($string));
}

function b64url_decode($string)
{
    return base64_decode(str_replace(['-', '_'], ['+', '/'], $string));
}

function jwt_make($id, $user, $email, $type)
{
    $header = json_encode([
        "alg" => "HS256",
        "typ" => "JWT"
    ]);
    $payload = json_encode([
        "id" => $id,
        "user" => $user,
        "email" => $email,
        "type" => $type,
        "iat" => time(),
        "exp" => time() + 604800,
    ]);
    $headerHash = b64url_encode($header);
    $payloadHash = b64url_encode($payload);
    $signature = hash_hmac("sha256", $headerHash . "." . $payloadHash, SECRET, true);
    $signatureHash = b64url_encode($signature);
    $jwt = $headerHash . "." . $payloadHash . "." . $signatureHash;
    query(sprintf("INSERT INTO sessions (token, uid) VALUES ('%s', %s)", $jwt, $id));
    return $jwt;
}

function jwt_verify($token)
{
    try {
        $tokenParts = explode('.', $token);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $sig = $tokenParts[2];
        $exp = json_decode($payload)->exp;
        $tokenExpired = true ? $exp <= time() : false;
        $signature = hash_hmac("sha256", b64url_encode($header) . "." . b64url_encode($payload), SECRET, true);
        $signatureHash = b64url_encode($signature);
        $signatureValid = ($signatureHash == $sig);
        @$data = query(sprintf("SELECT * FROM sessions WHERE token='%s'", $token));
        if ($data != null) {
            if ($signatureValid && !$tokenExpired) {
                $user = query(sprintf("SELECT * FROM users WHERE id=%s", intval(json_decode($payload)->id)));
                if($user == null) {
                    die(new ErrorMessage(ErrorType::NOT_FOUND, "Account not found."));
                }
                if ($user[0]["disabled_until"] > time()) {
                    if ($user[0]["disabled_until"] > 11693582062) {
                        die(new ErrorMessage(ErrorType::ACCOUNT_DISABLED, "This account is disabled indefinitely."));
                    }
                    die(
                        new ErrorMessage(
                            ErrorType::ACCOUNT_DISABLED,
                            sprintf("This account is disabled until %s.", date("m/d/Y H:i:s", $user[0]["disabled_until"]))
                        )
                    );
                }
                $pl = json_decode($payload, true);
                $pl["type"] = $user[0]["type"];
                return $pl;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}