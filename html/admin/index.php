<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Competence.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Client.php";    
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Consultant.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Candidat.php";

session_start();

if ($_SESSION['user']['type'] == 0 && 0) {
    echo "vous n'avez pas accès à la page d'administration en tant que consultant";
        exit();
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
    <script src="/cdn/Profile.js"></script>
    <script src="/cdn/Post.js"></script>
    <title>A2F advisor</title>
</head>
<body>
    <nav>
        <div onclick="Popup.open('Comp')" class="onglet">Compétences</div>
        <div onclick="Popup.open('rh')" class="onglet">Ressources humaines</div>
        <div onclick="Popup.open('bm')" class="onglet">Business manager</div>
        <div onclick="Popup.open('cons')" class="onglet">Consultants</div>
        <div onclick="Popup.open('iencli')" class="onglet">Clients</div>
    </nav>
    <div class="mainWrapper">

        <div  onclick="location.href='/'" class="close">Retour</div>

        <div class="popup" id="Comp"><div class="nav">Compétences</div>
            <div class="main-wrapper">
                <div class="relative-wrapper-container">
                    <div style="width: 100%; margin-bottom: 20px; position: relative; height: 0px;overflow: hidden;">fixing div</div>
                    <div id="onglets-wrapper">
                        <div id="oc3" class="onglet ongletContainer">
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

                                            ?><div class="comp"><?php echo $name; ?></div><?php

                                        }
                                        
                                    }

                                    ?></div><?php

                                    return array(
                                        "cpt" => $cpt,
                                    );
                                
                                };

                                $comp = Competence::get_array();
                                
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
                </div>
            </div>
        </div>

        <div class="popup" id="rh"><div class="nav">Ressources humaines</div>

        </div>

        <div class="popup" id="bm"><div class="nav">Business manager</div>

        </div>

        <div class="popup" id="cons"><div class="nav">Consultants</div>

        </div>

        <div class="popup" id="iencli"><div class="nav">Clients</div>
        
        </div>
    </div> 

    <script>
        Popup.open('Comps');
        Dropdown.load();
    </script>   

</body>
</html>