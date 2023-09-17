<?php

include_once '../gapi/vendor/autoload.php';

# Add your client ID and Secret
$client_id = "109055279343-1hr7p52emk6ogbrnl3uv4a4st33kcbhm.apps.googleusercontent.com";
$client_secret = "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";

$client = new Google\Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);

# redirection location is the path to login.php
$redirect_uri = 'http://localhost:8000/api/v1/user/google_callback.php';
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");