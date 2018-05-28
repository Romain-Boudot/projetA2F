<?php

    session_start();

    function login_redirect() {
        header('location: http://' . $_SERVER['HTTP_HOST'] . "/identification");
        exit();
    }

    if (isset($_SESSION['user']['connected'])) {

        if ($_SESSION['user']['connected'] != true) login_redirect();

    } else login_redirect();


    header("location: http://" . $_SERVER['HTTP_HOST'] . "/recherche");
    exit();

?>