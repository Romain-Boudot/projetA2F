<?php

    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Competence.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Consultant.php";

    session_start();

    if ($_SESSION['user']['type'] == 0) {
        $c = new Consultant($_SESSION['user']['id']);
    } else {
        echo "vous n'etes pas un consultant, vous n'avez pas de page de profil.";
        exit();
    }

    if (isset($_POST['modif'])) {
        include_once "traitement.php";
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/consultant/modifier/main.css">
    <link rel="stylesheet" href="/cdn/main.css">
    <script src="/cdn/Dropdown.js"></script>
    <script src="/cdn/Popup.js"></script>
    <title>A2F Advisior</title>
</head>
<body>
    <nav>
        <div onclick="Popup.open('InfoP')" class="onglet">Informations personnelles</div>
        <div onclick="Popup.open('Comp')" class="onglet">Compétences</div>
        <div onclick="Popup.open('Inter')" class="onglet">Interventions</div>
        <div onclick="Popup.open('Qual')" class="onglet">Qualifications</div>
        <div onclick="Popup.open('Graph')" class="onglet">Graphiques</div>
    </nav>
    <div class="mainWrapper">

        <div class="popup" id="Comp"><div class="nav">Compétences</div>
        
            <!-- // Comp section // -->
        
            <div onclick="competence.send()" class="submit">Envoyer</div>

            <div class="compListWrapper">

                <?php

                $cpt = 0;

                function tab($tab, $cpt) {

                    ?><div id="ddc<?php echo $cpt; ?>" class="dropdownContainer"><?php

                    $cpt += 1;
                    
                    foreach ($tab as $name => $value) {
                        
                        if ($value["enfant"] != null) {
                            
                            ?><div id="ddt<?php echo $cpt; ?>" class="dropdownTrigger"><?php echo $name; ?></div><?php
                            
                            $returned = tab($value["enfant"], $cpt);

                            $cpt = $returned["cpt"];

                        } else {

                            if ($value["niveau"] == null) $value["niveau"] = 0;

                            ?><div class="comp"><?php echo $name; ?> <span> </span> <input data-lvl="<?php echo $value["niveau"]; ?>" data-id="<?php echo $value["id_competence"]; ?>" min="0" max="3" type="number" class="compJs bold" value="<?php echo $value["niveau"]; ?>"></div><?php

                        }
                        
                    }

                    ?></div><?php

                    return array(
                        "cpt" => $cpt,
                    );

                };

                $comp = Competence::get_array($id);

                foreach ($comp as $name => $value) {

                    if (is_array($value)) {

                        ?><div id="ddt<?php echo $cpt; ?>" class="dropdownTrigger"><?php echo $name ?></div><?php
                        
                        $returned = tab($value["enfant"], $cpt);

                        $cpt = $returned["cpt"];

                    } else {

                        ?><div><?php echo $name; ?> - <?php echo $value; ?></div><?php

                    }

                }

                ?>

            </div>

        </div>
        <div class="popup" id="InfoP"><div class="nav">Informations personnelles</div>
        
            <!-- // infos section // -->

            <form action="/consultant/modifier" method="post">
            
                <input type="hidden" name="modif" value="info">

                <input type="text" name="nom" placeholder="Nom" value="<?php echo $c->get_nom(); ?>">
                <input type="text" name="prenom" placeholder="Prenom" value="<?php echo $c->get_prenom(); ?>">
                <input type="text" name="email" placeholder="Email" value="<?php echo $c->get_email(); ?>">
                <input type="text" name="tel" placeholder="Téléphone" value="<?php echo $c->get_telephone(); ?>">
                <input type="text" name="linkedin" placeholder="Linkedin" value="<?php echo $c->get_linkedin(); ?>">

                <input type="submit" value="Envoyer">

            </form>
        
        </div>
        <div class="popup" id="Inter"><div class="nav">Interventions</div>
        
            <!-- // Comp section // -->

        </div>
        <div class="popup" id="Qual"><div class="nav">Qualifications</div>
        
            <!-- // Comp section // -->

        </div>
        <div class="popup" id="Graph"><div class="nav">Graphiques</div>
        
            <!-- // Comp section // -->
        
        </div>

    </div>

    <script>
        Popup.open('InfoP');
        Dropdown.load();
    </script>

</body>
</html>