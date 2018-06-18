<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Security.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Competence.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Client.php";    
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Consultant.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Candidat.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/BM.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/RH.php";


session_start();

Security::check_token($_POST['token'], '42');
Security::check_login(array(0, 1, 2));

if (!isset($_POST['action']) ){
     exit();
}


if ($_POST['action'] == "delete") {
    if(isset($_POST["id"])){
        $id_comp = $_POST["id"];

    }else{
        exit();
    }


    if (Competence::is_last($id_comp)) {
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

} elseif ($_POST['action'] == "delete_bm") {

    BM::delete($_POST['id_bm']);
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();

} elseif ($_POST['action'] == "add_bm") {
    
    BM::register($_POST['nom'], $_POST['prenom']);
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();

} elseif ($_POST['action'] == "delete_rh") {

    BM::delete($_POST['id_rh']);
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();

} elseif ($_POST['action'] == "add_rh") {
    
    RH::register($_POST['nom'], $_POST['prenom']);

    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();

} elseif ($_POST['action'] == "delete_client") {

    BM::delete($_POST['id_client']);
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();

} elseif ($_POST['action'] == "add_client") {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $pdo->prepare("INSERT INTO clients (entreprise) VALUES (:entreprise)");
    $statement->execute(array(":entreprise" => $_POST['entreprise']));

    $pdo = null;
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();

} elseif ($_POST['action'] == "delete_consultant") {

    BM::delete($_POST['id_consultant']);
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();

} elseif ($_POST['action'] == "add_consultant") {

    Consultant::register($_POST['nom'], $_POST['prenom'], $_POST['pole']);
    
    //header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    //exit();

} elseif ($_POST['action'] == "delete_candidat") {

    BM::delete($_POST['id_candidat']);
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();
    
} elseif ($_POST['action'] == "add_candidat") {

    $infos = array(
        "nom" => $_POST['nom'],
        "prenom" => $_POST['prenom']
    );

    Candidat::add($infos);

    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();

} else { 
    exit(); 
}