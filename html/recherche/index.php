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
                if ($_SESSION['user']['pole'] == 2) echo "#06436f";
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
    <link rel="stylesheet" href="/recherche/main.css">
    <script src="/cdn/Popup.js"></script>
    <script src="/cdn/Dropdown.js"></script>
    <script src="/recherche/Search.js"></script>
    <title>A2F Advisor</title>
</head>

<body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/../includes/header.php" ?>

    <div class="main-wrapper">

        <div onclick="Popup.oneOpen('help')" class="helpTrigger"><i class="material-icons">help_outline</i></div>
        <div onclick="Popup.close('help')" id="help" class="help">

            <div>
                Saisie :
                <div>
                    - Vous pouvez entrer :
                    <div>
                        <div>- des noms de consultants, séparés par des virgules,</div>
                        <div>- des compétences et des clients, cliquable dans les suggestions.</div>
                    </div>
                </div> 
            </div>

            <div>
                Niveaux :
                <div>
                    <div>- Niveau 0 : Aucune notion</div>
                    <div>- Niveau 1 : Débutant, peut prendre en main l'activité avec l'aide d'un expert</div>
                    <div>- Niveau 2 : Autonome sur l'activité</div>
                    <div>- Niveau 3 : Expert, peut transmettre son savoir</div>
                </div> 
            </div>
                

        </div>

        <?php

            if ($_SESSION['user']['type'] >= 1) {

        ?>

        <div class="btnSlideContainer">
            <div onclick="s.show_consultant()">Consultants</div><div onclick="s.show_candidat()">Candidats</div>
            <div></div>
        </div>

        <?php

            }

        ?>

        <div class="search">
    
            <div class="filterGrid">

                <div class="filterGridLarge consultantOnly">

                    Pôles :
                    <br>
                    <label for="poleIndus" class="pole">
                        <input type="checkbox" name="poleIndus" id="poleIndus">
                        <div class="checkbox">✔</div>
                        Indus
                    </label>
                    <label for="poleDatabase" class="pole">
                        <input type="checkbox" name="poleDatabase" id="poleDatabase">
                        <div class="checkbox">✔</div>
                        Database
                    </label>
                    <label for="poleSi" class="pole">
                        <input type="checkbox" name="poleSi" id="poleSi">
                        <div class="checkbox">✔</div>
                        Si
                    </label>

                </div>

                <div class="filterGridLarge candidatOnly">

                    Avancements :
                    <label for="av1" class="disp">
                        <input type="checkbox" name="av2" id="av1">
                        <div class="checkbox">✔</div>
                        1er appel
                    </label>
                    <label for="av2" class="disp">
                        <input type="checkbox" name="av2" id="av2">
                        <div class="checkbox">✔</div>
                        1ere entretien
                    </label>
                    <br>
                    <label for="av3" class="disp">
                        <input type="checkbox" name="av3" id="av3">
                        <div class="checkbox">✔</div>
                        2eme entretien
                    </label>
                    <label for="av4" class="disp">
                        <input type="checkbox" name="av4" id="av4">
                        <div class="checkbox">✔</div>
                        3eme entretien
                    </label>

                </div>

                <div class="filterGridLarge borderTop">

                    <div class="btn fakeComp consultantOnly" onclick="Popup.open('popupClient', s)">Selection des clients</div>
                    <div class="btn fakeComp ml" onclick="Popup.open('popupComp', s)">Selection des competences</div>

                </div>

            </div>

            <div class="searchBarContainer">
                <div>Recherche :</div><div id="input" class="searchBar">
                    <div id="inputFilter">
                        <div id="textInput">
                            <input type="text">
                        </div>
                    </div>
                </div><?php

                if ($_SESSION['user']['type'] == 2) {

                ?><label for="archive">
                    <input type="checkbox" name="archive" id="archive">
                    <div for="archive" class="checkbox">✔</div>
                    archive
                </label><?php

                } else {

                    ?><div></div><?php

                }

            ?></div>

            <div class="sugest">
                <div>
                    <label class="labelComp">Compétence(s)</label>
                    <label class="labelClient consultantOnly">Client(s)</label>
                </div>
                <div>
                    <div class="sugestedComp"></div>
                    <div class="sugestedClient borderLeft consultantOnly"></div>
                </div>
            </div>

        </div>

        <script>
            var s = new S;
        </script>

        <div class="searchBtn" onclick="s.send()">Rechercher</div>

    </div>

    <div class="popup" id="popupComp">

        <div class="compList">

            <div class="compListContainer">

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
                                    <div data-name="<?php echo $name; ?>" data-id="<?php echo $value["id_competence"]; ?>" class="competence borderComp">ajouter aux filtres</div>
                                </div>

                                <?php
                            
                            $returned = tab($value["enfant"], $cpt);

                            $cpt = $returned["cpt"];

                        } else {

                            ?>

                                <div class="competencefake">
                                    <?php echo $name; ?>
                                    <div data-name="<?php echo $name; ?>" data-id="<?php echo $value["id_competence"]; ?>" class="competence borderComp">ajouter aux filtres</div>
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

        </div>

        <div class="compSelectClose btn close" onclick="Popup.close('popupComp', s)">&times;</div>

    </div>

    <div class="popup" id="popupClient">

        <div class="clientListContainer">

            <?php

            $c = Client::get_array();

            foreach ($c as $client) {

                ?>

                <div data-name="<?php echo $client["entreprise"] ?>" data-id="<?php echo $client["id_client"]; ?>" class="client">
                    <?php echo $client["entreprise"] ?>
                </div>

                <?php
                
            }

            ?>

        </div>

        <div class="clientSelectClose btn close" onclick="Popup.close('popupClient', s)">&times;</div>

    </div>

    <script>
        s.load();
    </script>

</body>

</html>
