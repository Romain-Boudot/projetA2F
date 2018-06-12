<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Database.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Competence.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Pole.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Client.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Search.php";

    session_start();

    Security::check_login(array(0, 1, 2));

    $result = Search::lookup();

    $filter = JSON_decode($_GET['filter'], true);

    // echo "<pre>";
    // var_dump(JSON_decode($_GET['filter'], true);
    // echo "</pre>";
    // exit();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/cdn/main.css">
    <link rel="stylesheet" href="main.css">
    <title>A2F Advisior</title>
</head>
<body>

    <?php 

        include $_SERVER["DOCUMENT_ROOT"] . "/../includes/header.php";

        $first = true;

        $lvl_array = array(
            "=0" => "égale à 0",
            "m=1" => "inf./égal à 1",
            "p=1" => "sup./égal à 1",
            "m=2" => "inf./égal à 2",
            "p=2" => "sup./égal à 2",
            "=3" => "égal à 3"
        );

        if (isset($filter["competences"]["id_competence"])) if (!empty($filter["competences"]["id_competence"])) {

            if ($first) {
                $first = false;
                echo '<div class="filter">';
            } else {
                echo "<br>";
            }

            ?>
                Competence(s) : 
            <?php

            foreach ($filter["competences"]["id_competence"] as $key => $value) {
                
                if ($key > 0) echo " ";
                echo "<span>" . Competence::get_name($value) . " - niv. " . $lvl_array[$filter["competences"]["niveau"][$key]] . "</span>";

            }

        }

        if (isset($filter["clients"]["id_client"])) if (!empty($filter["clients"]["id_client"])) {

            if ($first) {
                $first = false;
                echo '<div class="filter">';
            } else {
                echo "<br>";
            }

            ?>
                Client(s) : 
            <?php

            foreach ($filter["clients"]["id_client"] as $key => $value) {
                
                if ($key > 0) echo " ";
                echo "<span>" . Client::get_name($value) . "</span>";

            }

        }

        if (isset($filter["poles"]["id_pole"])) if (!empty($filter["poles"]["id_pole"])) {

            if ($first) {
                $first = false;
                echo '<div class="filter">';
            } else {
                echo "<br>";
            }

            ?>
                Pôle(s) : 
            <?php

            foreach ($filter["poles"]["id_pole"] as $key => $value) {
                
                if ($key > 0) echo " ";
                echo "<span>" . Pole::get_name($value) . "</span>";

            }

        }

        if (isset($filter["disponibilites"]["id_disponibilite"])) if (!empty($filter["disponibilites"]["id_disponibilite"])) {

            if ($first) {
                $first = false;
                echo '<div class="filter">';
            } else {
                echo "<br>";
            }

            ?>
                Disponibilitée(s) : 
            <?php

            $disp = array(
                "1" => "maintenant",
                "2" => "dans un mois",
                "3" => "dans deux mois",
                "4" => "dans trois mois ou plus"
            );

            foreach ($filter["disponibilites"]["id_disponibilite"] as $key => $value) {
                
                if ($key > 0) echo " ";
                echo "<span>" . $disp[$value] . "</span>";

            }

        }

        if (isset($filter["consultant"])) if (!empty($filter["consultant"])) {

            if ($first) {
                $first = false;
                echo '<div class="filter">';
            } else {
                echo "<br>";
            }

            ?>
                Recherche par nom : 
            <?php

            foreach ($filter["consultant"] as $key => $value) {
                
                if ($key > 0) echo " ";
                echo "<span>" . $value . "</span>";

            }

        }

        if (!$first) {
            echo "</div>";
        } else {
            echo '<div style="height:56px;position:relative;"></div>';
        }

    ?>


    <div class="profileWrapper">
        
        <div onclick="location.href='/recherche/'" class="fixedSearchReturn">Retourner à la recherche</div>
    
        <?php

            foreach ($result as $key => $value) {

        ?>
        <div onclick="location.href='http://<?php echo $_SERVER['HTTP_HOST'] . '/consultant/?id=' . $value['id_consultant']; ?>'" class="profile">

            <img src="/images/unknown.png" alt="profile photo">

            <div class="nom"><?php echo $value["nom"]; ?></div>
            <div class="prenom"><?php echo $value["prenom"]; ?></div>
            <div class="email"><?php echo $value["email"]; ?></div>
            <div class="telephone"><?php echo $value["telephone"]; ?></div>

        </div>
        <?php

            }

        ?>

    </div>

</body>
</html>
