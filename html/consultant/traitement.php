<?php

    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Security.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Competence.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Consultant.php";
    
    session_start();

    Security::check_login(array(0));
    
    if(!isset($_GET["action"])) {
        header("location: http://" . $_SERVER["HTTP_HOST"] . "/consultant/");
        exit();
    }

    $id = $_SESSION['user']['id'];
    $consultant = new Consultant($id);
    
    if ($_GET["action"] == "img") {

        var_dump($_FILES);
        var_dump($_POST);
        var_dump($_GET);

        if (!isset($_FILES["file"])) {
            echo "probleme de type inconnue";
            exit();
        }

        if ($_FILES['file']['error'] > 0) {
            echo "Une erreur est survenue pendant l'envoi";
            exit();
        }

        if ($_FILES['file']['size'] > 1000000) {
            echo "Fichier trop volumineux (1Mo max)";
            exit();
        }

        $extensions_valides = array( 'jpg' , 'jpeg' , 'png' );

        $extension_upload = strtolower(substr(strrchr($_FILES['file']['name'], '.'), 1));
        echo $extension_upload;
        if (!in_array($extension_upload, $extensions_valides)) {
            echo "Extension incorrecte (jpg, jpeg, png)";
            exit();
        }

        if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/images/profil/" . $id . ".jpg"))
            unlink($_SERVER["DOCUMENT_ROOT"] . "/images/profil/" . $id . ".jpg");
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/images/profil/" . $id . ".jpeg"))
            unlink($_SERVER["DOCUMENT_ROOT"] . "/images/profil/" . $id . ".jpeg");
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/images/profil/" . $id . ".png"))
            unlink($_SERVER["DOCUMENT_ROOT"] . "/images/profil/" . $id . ".png");

        if (move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . "/images/profil/" . $id . "." . $extension_upload)) {
            echo "Transfert réussi";
        }

    }