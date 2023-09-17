<?php

include_once '../core.php';
include_once './google_config.php';

echo json_encode(["url"=>$client->createAuthUrl()]);