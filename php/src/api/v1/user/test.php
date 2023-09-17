<?php
include_once '../core.php';
print_r(query(sprintf("SELECT * FROM users WHERE email='%s'", "asdsad")));