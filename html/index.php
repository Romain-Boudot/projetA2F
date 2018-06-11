<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Security.php";

    session_start();

    Security::check_login(array(0, 1, 2));

    header("location: http://" . $_SERVER['HTTP_HOST'] . "/recherche/");
    exit();

?>