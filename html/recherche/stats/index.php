<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Database.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Security.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Competence.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Client.php";

session_start();

Security::check_login(array(0, 1, 2));

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        :root {
            --main-color: <?php
                if ($_SESSION['user']['pole'] == 0) echo "#06436f";
                if ($_SESSION['user']['pole'] == 1) echo "#f7931e";
                if ($_SESSION['user']['pole'] == 2) echo "#259225";
                if ($_SESSION['user']['pole'] == 3) echo "#f05944";
            ?>;
            --auto-color: <?php
                if ($_SESSION['user']['pole'] == 0) echo "white";
                else echo "inerit"
            ?>;
        }
    </style>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/cdn/main.css">
    <link rel="stylesheet" href="/recherche/stats/main.css">
    <script src="/cdn/Dropdown.js"></script>
    <script src="/cdn/Chart.bundle.js"></script>
    <script src="/cdn/Chart.js"></script>
    <script src="/cdn/Ajax.js"></script>
    <script src="/cdn/Stats.js"></script>
    <title>A2F Advisor</title>
</head>

<body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/../includes/header.php"; ?>

    <div class="compWrapper">
    
        <?php

            $comp = Competence::get_array();

            // parcour d'un tableau et ressort le nom de la competence et ses enfant ( recursion )
            function tab($tab, $cpt) {

                ?>
                    <div id="ddc<?php echo $cpt?>" class="dropdownContainer">
                <?php

                $cpt += 1;

                foreach ($tab as $name => $value) {
                
                    if ($value["enfant"] != null) {

                        ?>

                            <div id="ddt<?php echo $cpt?>" class="dropdownTrigger">
                                <?php echo $name; ?>
                                <div onclick="Stats.get_stats(<?php echo $value["id_competence"]; ?>)" data-name="<?php echo $name; ?>" data-id="<?php echo $value["id_competence"]; ?>" class="competence borderComp">voir stats</div>
                            </div>

                        <?php
                        
                        $returned = tab($value["enfant"], $cpt);

                        $cpt = $returned["cpt"];

                    } else {

                        ?>

                            <div data-name="<?php echo $name; ?>" data-id="<?php echo $value["id_competence"]; ?>" class="competence disabled">
                                <?php echo $name; ?>
                            </div>

                        <?php

                    }
                    
                }

                ?>
                    </div>
                <?php

                return array(
                    "cpt" => $cpt
                );

            };

            $cpt = 0;

            foreach ($comp as $name => $value) {

                if ($value["enfant"] != null) {

                    ?>
                        <div id="ddt<?php echo $cpt?>" class="dropdownTrigger">
                            <?php echo $name; ?>
                            <div onclick="Stats.get_stats(<?php echo $value["id_competence"]; ?>)" data-name="<?php echo $name; ?>" data-id="<?php echo $value["id_competence"]; ?>" class="competence borderComp">voir stats</div>
                        </div>
                    <?php
                    
                    $returned = tab($value["enfant"], $cpt);

                    $cpt = $returned["cpt"];

                }

            }

        ?>

        <script>
            Dropdown.load();
        </script>

    </div>

    <div class="graphWrapper">

    </div>

</body>
</html>