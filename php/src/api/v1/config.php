<?php
$env = "development";

if ($env == "development") {
    define("DB_HOST", "db");
    define("DB_USER", "db");
    define("DB_PASS", "123456");
    // define("DB_HOST", "localhost");
    // define("DB_USER", "root");
    // define("DB_PASS", "");
    define("DB_NAME", "tadam-space");
    define("DB_PORT", 3306);
    define("SECRET", "0eac0f975db26f172e72522440a58ecca992a9a23348d8a1eded1f8eb168db5a");
    define("TURNSTILE_SECRET", "1x0000000000000000000000000000000AA");
} else {
    define("DB_HOST", "mariadb105.r1.websupport.sk");
    define("DB_USER", "hvmaymfz");
    define("DB_PASS", "Sm5H0Vz(cT");
    define("DB_NAME", "hvmaymfz");
    define("DB_PORT", 3313);
    define("SECRET", "0eac0f975db26f172e72522440a58ecca992a9a23348d8a1eded1f8eb168db5a");
    define("TURNSTILE_SECRET", "0x4AAAAAAAKQkRIqY6_edSxWD5pC-Xq8zTI");
}