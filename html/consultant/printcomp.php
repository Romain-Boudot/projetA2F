<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Database.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Security.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Consultant.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Competence.php";

session_start();

Security::check_login(array(1, 2));

if (!isset($_GET['id'])) {
    include $_SERVER["DOCUMENT_ROOT"] . "/erreurs/404.php";
    exit();
}

$consultant = new Consultant($_GET['id']);


function arr_explorer($arr) {
    
    $parentAverage = 0;
    $cpt = 0;
    $html = "";

    foreach ($arr as $name => $value) {

        $cpt++;

        if ($value["enfant"] == null) {
            
            $value["niveau"] == NULL ? $value["niveau"] = 0 : $value["niveau"] = intval($value["niveau"]);

            $parentAverage += $value["niveau"];
            
            // $html .= '<div class="hr"></div>';
            $html .= '<div class="m' . $value["depth"] . '">' . $name . '<div class="niv">Niveau : ' . $value["niveau"] . '</div></div>';

        } else {

            $rt = arr_explorer($value["enfant"]);

            // $html .= '<div class="hr m' . $value["depth"] . '"></div>';
            $html .= '<div class="m' . $value["depth"] . '">' . $name . '<div class="niv">Moyenne : ' . $rt["niveau"] . '</div></div>';
            $html .= $rt["html"];

        }
        
    }

    return array(
        "niveau" => round($parentAverage / $cpt, 2),
        "html" => $html
    );

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/cdn/main.css">
    <style>
        body {
            display: grid;
            width: calc(80vw - 100px);
            grid-template-columns: repeat(10, calc(100% / 10));
            padding: 50px;
            grid-gap: 5px 0;
            justify-items: center;
            align-items: center;
        }
        body>* {
            width: 100%;
        }
        .m1 {
            grid-column: 1 / 4;
            margin: 5px 0;
            font-weight: bold;
        }
        .m2 {
            grid-column: 2 / 5;
            margin: 5px 0;
            font-weight: bold;
        }
        .m3 {
            grid-column: 3 / 6;
            margin: 5px 0;
        }
        .last {
            border-bottom: 1px solid rgba(0, 0, 0, .5);
            text-align: center;
        }
        .niv {
            float: right;
        }
        .hr {
            margin: 0;
        }
        .large {
            grid-column: 1 / 6;
        }
        .space {
            margin: 20px;
        }
    </style>
    <title>A2F Advisor</title>
</head>
<body>
    <div><?php echo $consultant->get_nom() . " " . $consultant->get_prenom(); ?></div>
    <div>Pôle : <?php echo $consultant->get_nom_pole(); ?></div>
    <div class="hr large"></div>
    <div class="large space"></div>
    <!--div class="hr"></div-->

    <?php 
    
        $comp = Competence::get_array($consultant->get_id());
        foreach($comp as $pole) {
            if ($pole['id_competence'] == $consultant->get_pole()) {
                echo arr_explorer($pole["enfant"], 1)["html"];
            }
        }
    
    ?>

</body>
</html>