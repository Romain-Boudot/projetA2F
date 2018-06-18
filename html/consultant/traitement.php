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

        if (isset($files[0])) unlink($_SERVER["DOCUMENT_ROOT"] . "/images/profil/" . $files[0]["nom_serveur"]);

        $fileName = bin2hex(random_bytes(32)) . "." . $extension_upload;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . "/images/profil/" . $fileName)) {

            if (isset($files[0])) $consultant->del_file($files[0]["nom_serveur"]);
            $consultant->add_file($_FILES['file']['name'], $fileName, "img");
            echo '{"code": 1, "message": "Transfert réussi", "name": "' . $fileName . '"}';

        } else {

            echo '[null]';

        }

    } elseif ($_GET["action"] == "pdfadd") {

        if (sizeof($consultant->get_files("pdf")) >= 5) {
            echo '{"code": -2, "message": "Nombre maximum de fichiers par profil atteint"}';
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

        if (!in_array($extension_upload, $extensions_valides)) {
            echo '{"code": -3, "message": "Extension incorrecte (pdf)"}';
            exit();
        }

        $fileName = bin2hex(random_bytes(32)) . ".pdf";

        if (move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . "/../files/" . $fileName)) {
            $consultant->add_file($_FILES['file']['name'], $fileName, "pdf");
            echo '{"code": 1, "message": "Transfert réussi", "infos": {"servername": "' . $fileName . '", "truename": "' . $_FILES['file']['name'] . '"}}';
            exit();
        }

    } elseif ($_GET["action"] == "pdfdel") {

        if (!isset($_POST["token"])) {
            echo '{"code": -10, "message": "Missing token"}';
            exit();
        }

        if (!isset($_POST["filename"])) {
            echo '{"code": -10, "message": "Missing file name"}';
            exit();
        }

        if (Security::check_token($_POST["token"], 5000)) {

            $consultant->del_file($_POST["filename"]);
            unlink($_SERVER["DOCUMENT_ROOT"] . "/../files/" . $_POST["filename"]);
            echo '{"code": 1, "message": "Suppression réussie", "infos":{
                "servername": "' . $_POST["filename"] . '"
            }}';
            exit();

        }

    } elseif ($_GET["action"] == "gettoken") {

        echo '{"code": 1, "token": "' . Security::gen_token(5000) . '"}';
        exit();

    }