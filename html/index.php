<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Database.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Security.php";

    session_start();

    Security::check_login(array(0, 1, 2));

    if (isset($_GET['file'])) {

        if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/../files/" . $_GET["file"])) {
            
            if ($_SESSION['user']['type'] == 0) {
                if (!Security::check_file($_GET['file'])) {
                    include_once $_SERVER['DOCUMENT_ROOT'] . "/erreurs/403.php";
                    exit();
                }
            }
            
            header('Content-Type: application/pdf');
            
            readfile($_SERVER["DOCUMENT_ROOT"] . '/../files/' . $_GET['file']);
            exit();
            
        }
    
    }

    if ($_SESSION['user']['type'] == 0) {
        header("location: http://" . $_SERVER['HTTP_HOST'] . "/consultant/");
        exit();
    } else {
        header("location: http://" . $_SERVER['HTTP_HOST'] . "/recherche/");
        exit();
    }

?>
