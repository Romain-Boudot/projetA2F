<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Security.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Consultant.php";

session_start();

Security::check_login(array(0, 1, 2));

if (!isset($_GET['file'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/erreurs/404.php";
    exit();
} elseif (!file_exists($_SERVER["DOCUMENT_ROOT"] . "/../files/" . $_GET["file"])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/erreurs/404.php";
    exit();
}

if ($_SESSION['user']['type'] == 0) {
    if (!Security::check_file($_GET['file'])) {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/erreurs/403.php";
        exit();
    }
}

header('Content-Type: application/pdf');

readfile($_SERVER["DOCUMENT_ROOT"] . '/../files/' . $_GET['file']);