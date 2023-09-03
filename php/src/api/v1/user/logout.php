<?php
include_once '../core.php';
$auth = authorize(0);

query(sprintf("DELETE FROM sessions WHERE token='%s'", getAuthToken()));