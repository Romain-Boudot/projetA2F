<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Database.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Competence.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Client.php";

session_start();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/cdn/main.css">
    <link rel="stylesheet" href="/recherche/stats/main.css">
    <script src="/cdn/Dropdown.js"></script>
    <script src="/cdn/Stats.js"></script>
    <title>A2F Advisor</title>
</head>

<body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/../includes/header.php"; ?>

    <div class="compWrapper"></div>

    <div class="graphWrapper"></div>

</body>
</html>