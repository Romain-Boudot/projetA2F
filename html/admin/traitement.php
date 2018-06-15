<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Security.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Competence.php";

session_start();
Security::check_login(array(0, 1, 2));

if (!isset($_POST['action']) || !isset($_POST["id"])) exit();
$id_comp = $_POST["id"];

if ($_POST['action'] == "delete"){
    if (Competence::is_last($id_comp)){
        $pdo = Database::connect();

        $statement = $pdo->prepare("DELETE FROM competences WHERE id_competence = :idcomp");
        $statement->execute(array(":idcomp" => $id_comp));
        
        $pdo = null;
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
        exit();

    } else { 
        exit(); 
    }

} elseif ($_POST['action'] == "add") {
    
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $pdo->prepare("INSERT INTO competences (nom, id_competence_mere) VALUES (:nom, :idcompmere)");
    $statement->execute(array(":nom" => $_POST['nom'], ":idcompmere" => $id_comp));

    $pdo = null;
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();

} elseif($_POST['action'] == "add_bm"){
    $pdo = Database::connect();
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $pdo->prepare("INSERT INTO competences (nom, id_competence_mere) VALUES (:nom, :idcompmere)");
    $statement->execute(array(":nom" => $_POST['nom'], ":idcompmere" => $id_comp));

    $pdo = null;
    exit();

}elseif($_POST['action'] == "add_rh"){
    $pdo = Database::connect();
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $pdo->prepare("INSERT INTO competences (nom, id_competence_mere) VALUES (:nom, :idcompmere)");
    $statement->execute(array(":nom" => $_POST['nom'], ":idcompmere" => $id_comp));

    $pdo = null;
    exit();

}elseif($_POST['action'] == "add_client"){
    $pdo = Database::connect();
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $pdo->prepare("INSERT INTO competences (nom, id_competence_mere) VALUES (:nom, :idcompmere)");
    $statement->execute(array(":nom" => $_POST['nom']));

    $pdo = null;
    exit();

}elseif($_POST['action'] == "add_consultant"){
    $pdo = Database::connect();
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $pdo->prepare("INSERT INTO competences (nom, id_competence_mere) VALUES (:nom, :idcompmere)");
    $statement->execute(array(":nom" => $_POST['nom'], ":idcompmere" => $id_comp));

    $pdo = null;
    exit();

}elseif($_POST['action'] == "add_candidat"){
    $pdo = Database::connect();
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $pdo->prepare("INSERT INTO competences (nom, id_competence_mere) VALUES (:nom, :idcompmere)");
    $statement->execute(array(":nom" => $_POST['nom'], ":idcompmere" => $id_comp));

    $pdo = null;
    exit();

}else { 
    exit(); 
}