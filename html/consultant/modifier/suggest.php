<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Client.php";

if (
    !isset($_POST["table"]) ||
    !isset($_POST["input"])
) {
    echo JSON_encode(array(
        "code" => -1,
        "message" => "missing params"
    ));
    exit();
}

if ($_POST["table"] == "client") {

    echo JSON_encode(array(
        "code" => 1,
        "arr" => Client::get_array($_POST["input"])
    ));
    exit();

} elseif ($_POST["table"] == "entreprise") {

    echo JSON_encode(array(
        "code" => 1,
        "arr" => Entreprise::get_array($_POST["input"])
    ));
    exit();

} else {

    echo JSON_encode(array(
        "code" => -1,
        "message" => "nom de table non reconnu"
    ));

}