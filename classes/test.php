<?php

include "Database.php";
include "Security.php";

if (Security::login_validity("dpriouuuuu")) {
    echo 'libre' . PHP_EOL;
} else {
    echo 'deja utiliser' . PHP_EOL;
}