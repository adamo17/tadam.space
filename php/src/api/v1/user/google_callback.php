<?php

include_once './google_config.php';

$login_url = $client->createAuthUrl();
if (isset($_GET['code'])) {

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (isset($token['error'])) {
        print_r($token);
        exit;
    }
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $fist_name = $google_account_info["given_name"];
    $last_name = $google_account_info["family_name"];
    

}