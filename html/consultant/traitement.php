<?php

    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Security.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Competence.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Consultant.php";
    
    session_start();

    Security::check_login(array(0));
    
    if(!isset($_GET["action"])) {
        echo '{"code": -1}';
        exit();
    }

    $id = $_SESSION['user']['id'];
    $consultant = new Consultant($id);
    
    if ($_GET["action"] == "img") {

        if (!isset($_FILES["file"])) {
            echo '{"code": -2, "message": "Erreur inconnue"}';
            exit();
        }

        if ($_FILES['file']['error'] > 0) {
            echo '{"code": -2, "message": "Erreur inconnue"}';
            exit();
        }

        if ($_FILES['file']['size'] > 1000000) {
            echo '{"code": -2, "message": "Fichier trop volumineux"}';
            exit();
        }

        $extensions_valides = array( 'jpg' , 'jpeg' , 'png' );

        $extension_upload = strtolower(substr(strrchr($_FILES['file']['name'], '.'), 1));
        if (!in_array($extension_upload, $extensions_valides)) {
            echo '{"code": -3, "message": "Extension incorrecte (jpg, jpeg, png)"]';
            exit();
        }

        $files = $consultant->get_files("img");

        unlink($_SERVER["DOCUMENT_ROOT"] . "/images/profil/" . $files[0]["nom_serveur"]);

        $fileName = bin2hex(random_bytes(32)) . "." . $extension_upload;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . "/images/profil/" . $fileName)) {

            $consultant->del_file($files[0]["nom_serveur"]);
            $consultant->add_file($_FILES['file']['name'], $fileName, "img");
            echo '{"code": 1, "message": "Transfert réussi", "name": "' . $fileName . '"}';

        } else {

            echo '[null]';

        }

    } elseif ($_GET["action"] == "pdfadd") {

        if (sizeof($consultant->get_files("pdf")) >= 5) {
            echo '{"code": -2, "message": "Nombre maximum de fichier par profile atteind"}';
            exit();
        }
        
        if (!isset($_FILES["file"])) {
            echo '{"code": -2, "message": "Erreur inconnue"}';
            exit();
        }

        if ($_FILES['file']['error'] > 0) {
            echo '{"code": -2, "message": "Erreur inconnue"}';
            exit();
        }

        if ($_FILES['file']['size'] > 1000000) {
            echo '{"code": -2, "message": "Fichier trop volumineux"}';
            exit();
        }

        $extensions_valides = array( 'pdf' );

        $extension_upload = strtolower(substr(strrchr($_FILES['file']['name'], '.'), 1));
        echo $extension_upload;
        if (!in_array($extension_upload, $extensions_valides)) {
            echo '[-3, "Extension incorrecte (pdf)"]';
            exit();
        }

        $fileName = bin2hex(random_bytes(32)) . ".pdf";

        if (move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . "/images/profil/" . $fileName)) {
            $consultant->add_file($_FILES['file']['name'], $fileName, "pdf");
            echo '[1, "Transfert réussi"]';
        }

    }