<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Database.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Search.php";

    session_start();

    var_dump($_GET);
    echo "<br>";

    $result = Search::lookup();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/cdn/main.css">
    <link rel="stylesheet" href="main.css">
    <title>A2F Advisior</title>
</head>
<body>
    <?php
    
        var_dump($result);

    ?>
</body>
</html>