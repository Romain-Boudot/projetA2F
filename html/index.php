<?php

    session_start();

    function login_redirect() {
        header('location: http://' . $_SERVER['HTTP_HOST'] . "/identification");
        exit();
    }

    if (isset($_SESSION['user']['connected'])) {

        if ($_SESSION['user']['connected'] != true) login_redirect();

    } else login_redirect();

    if ($_SESSION['user']['type'] == 0) {
        header("location: http://" . $_SERVER['HTTP_HOST'] . "/consultant");
        exit();
    } else {
        header("location: http://" . $_SERVER['HTTP_HOST'] . "/recherche");
        exit();
    }

?>