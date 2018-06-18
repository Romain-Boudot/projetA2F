<?php 
 
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Consultant.php"; 
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php"; 
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Candidat.php"; 
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Security.php"; 
 
session_start(); 
 
//Security::check_login(array(0, 1, 2)); 
 
//if (!isset($_GET["id"]) || !isset($_GET["action"])) exit(); 
$candidat = new Candidat($_GET["id"]); 
if ($_GET["action"] == "timeline") { 
 
    if (!isset($_GET["lvl"])) exit(); 
 
    $candidat->set_etape($_GET["lvl"]); 
 
    echo "[" . $_GET["lvl"] . "]"; 
    exit(); 
 
}elseif ($_GET["action"] == "transfer") {

    

    $candidat->transfer(3);    


}

