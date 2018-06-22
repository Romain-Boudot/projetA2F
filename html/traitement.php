<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Database.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Security.php";

session_start();

Security::check_login(array(0, 1, 2));

if (!isset($_POST["action"])) {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/erreurs/404.php";
    exit();
}

if ($_POST["action"] == "login_validity") {

    if (!isset($_POST["login"])) {
        echo '{"code": -2, "message": "Pas de login donné"}';
        exit();
    }

    if (Security::login_validity($_POST["login"])) {
        echo '{"code": 1, "message": "login libre"}';
        exit();
    } else {
        echo '{"code": -1, "message": "login déjà utilisé"}';
        exit();
    }

}