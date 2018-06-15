<?php 
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Consultant.php"; 
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php"; 
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Candidat.php"; 
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Security.php"; 
 
session_start(); 
 
//Security::check_login(array(0, 1, 2)); 
 
//if (!isset($_GET["id"]) || !isset($_GET["action"])) exit(); 
 echo "nice";
$candidat = new Candidat($_GET["id"]); 
 echo "nice2";
if ($_GET["action"] == "timeline") { 
 
    if (!isset($_GET["lvl"])) exit(); 
 
    $candidat->set_etape($_GET["lvl"]); 
 
    echo "[" . $_GET["lvl"] . "]"; 
    exit(); 
 
}elseif ($_GET["action"] == "transfer") {

    

    $candidat->transfer();    

        echo "nice3";

}

