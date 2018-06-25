<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Database.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Security.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Competence.php";

session_start();

Security::check_login(array(1, 2));

if (!isset($_GET['id'])) {
    include $_SERVER["DOCUMENT_ROOT"] . "/erreurs/404.php";
    exit();
}

$consultant = new Consultant($_GET['id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>

    </style>
    <title>A2F Advisor</title>
</head>
<body>
    
</body>
</html>