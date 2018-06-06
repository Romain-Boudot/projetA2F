<?php

    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Competence.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Client.php";    
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
<html lang="fr">
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
    <title>A2F Advisor</title>
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

        <div onclick="location.href='/consultant/'" class="close">Retour</div>

        <div class="popup" id="Comp"><div class="nav">Compétences</div>
        
            <!-- // Comp section // -->
        
            <div onclick="Competence.send()" class="submit">Envoyer</div>

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

                            ?><div class="comp"><?php echo $name; ?> <input data-lvl="<?php echo $value["niveau"]; ?>" data-id="<?php echo $value["id_competence"]; ?>" min="0" max="3" type="number" class="compJs bold" value="<?php echo $value["niveau"]; ?>"></div><?php

                        }
                        
                    }

                    ?></div><?php

                    return array(
                        "cpt" => $cpt,
                    );

                };

                $comp = Competence::get_array($_SESSION['user']['id']);

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

            <form action="/consultant/modifier/" method="post">
            
                <input type="hidden" name="modif" value="info">

                <input type="text" name="nom" placeholder="Nom" value="<?php echo $c->get_nom(); ?>" required>
                <input type="text" name="prenom" placeholder="Prenom" value="<?php echo $c->get_prenom(); ?>" required>
                <input type="text" name="email" placeholder="Email" value="<?php echo $c->get_email(); ?>" required>
                <input type="text" name="tel" placeholder="Téléphone" value="<?php echo $c->get_telephone(); ?>" required>
                <input type="text" name="linkedin" placeholder="Linkedin" value="<?php echo $c->get_linkedin(); ?>">

                <input type="submit" value="Envoyer">

            </form>
        
        </div>
        <div class="popup" id="Inter"><div class="nav">Interventions</div>
        
            <!-- // Inter section // -->

            <form action="/consultant/modifier/" method="post">

                <input type="hidden" name="modif" value="int">
                <input type="hidden" name="action" value="add">                

                <div class="intervention">
                    <div class="infos">Date</div>
                    <div class="infos">Client</div>
                    <div class="details textCenter">
                        Détails
                    </div>
                </div>
                
                <div class="hr"></div>
                <div class="intervention">
                    <div class="infos"><input type="date" name="date" required></div>
                    <div class="infos"><select name="client" required><option selected disabled>Client</option><?php
                    
                        $cl = Client::get_array();

                        foreach ($cl as $key => $value) {
                            
                            ?><option value="<?php echo $value['id_client']; ?>"><?php echo $value['entreprise']; ?></option><?php

                        }

                    ?></select></div>
                    <div class="details textCenter">
                        <textarea placeholder="Détails de l'intervention" name="details" maxlength="500" rows="10" required></textarea>
                    </div>
                    <div class="InterSubmit"><input type="submit" value="Envoyer"></div>
                </div>

                <?php

                    $arr = $c->get_interventions();
                    foreach ($arr as $int) {

                ?>

                    <div class="hr"></div>
                    <div class="intervention">
                        <div class="infos"><?php echo $int['date']; ?></div>
                        <div class="infos"><?php echo $int['entreprise']; ?></div>
                        <div class="details"><?php echo $int['details']; ?></div>
                        <div class="InterSubmit"><div onclick="Intervention.del(<?php echo $int['id_intervention']; ?>)" class="delInt">Supprimer</div></div>
                    </div>

                <?php

                    }

                ?>
            
            </form>

        </div>
        <div class="popup" id="Qual"><div class="nav">Qualifications</div>
        
            <!-- // qual section // -->

            <form action="/consultant/modifier/" method="post">

                <input type="hidden" name="modif" value="qual">
                <input type="hidden" name="action" value="add">

                <div class="qualification">
                    <div class="infos">Qualification</div>
                    <div class="infos">Date d'obtention</div>
                    <div class="details textCenter">
                        Détails
                    </div>
                </div>

                <div class="hr"></div>
                <div class="qualification">
                    <div class="infos"><input type="text" name="nom" placeholder="Nom de Qualification" required></div>
                    <div class="infos"><input type="date" name="date" required></div>
                    <div class="details textCenter">
                        <textarea placeholder="Détails de l'intervention" name="details" maxlength="500" rows="10" required></textarea>
                    </div>
                    <div class="QualSubmit"><input type="submit" value="Envoyer"></div>
                </div>

                <?php

                    $arr = $c->get_qualifications();
                    foreach ($arr as $qual) {

                ?>

                    <div class="hr"></div>
                    <div class="qualification">
                        <div class="infos"><?php echo $qual['nom_qualification']; ?></div>
                        <div class="infos"><?php echo $qual['date_obtention']; ?></div>
                        <div class="details"><?php echo $qual['details']; ?></div>
                        <div class="QualSubmit"><div onclick="Qualification.del(<?php echo $qual['id_qualification']; ?>)" class="delInt">Supprimer</div></div>
                    </div>

                <?php

                    }

                ?>

                </form>

        </div>
        <div class="popup" id="Graph"><div class="nav">Graphiques</div>
        
            <!-- // Graph section // -->

            <div onclick="g.send()" class="submit">Envoyer</div>

            <div class="compListWrapper w-50">

                <?php

                    function tab_2($tab, $cpt) {

                        ?><div id="ddc<?php echo $cpt; ?>" class="dropdownContainer"><?php

                        $cpt += 1;
                        
                        foreach ($tab as $name => $value) {
                            
                            if ($value["enfant"] != null) {
                                
                                ?><div id="ddt<?php echo $cpt; ?>" class="dropdownTrigger"><?php echo $name; ?></div><?php
                                
                                $returned = tab_2($value["enfant"], $cpt);

                                $cpt = $returned["cpt"];

                            } else {

                                if ($value["niveau"] == null) $value["niveau"] = 0;

                                ?><div class="comp">
                                    <?php echo $name; ?> - <span><?php echo $value["niveau"]; ?></span>
                                    <span onclick="g.addG3(<?php echo $value["id_competence"]; ?>, <?php echo $value["niveau"]; ?>, '<?php echo $name; ?>')" class="floatRight">Graph 3</span>
                                    <span onclick="g.addG2(<?php echo $value["id_competence"]; ?>, <?php echo $value["niveau"]; ?>, '<?php echo $name; ?>')" class="floatRight">Graph 2</span>
                                    <span onclick="g.addG1(<?php echo $value["id_competence"]; ?>, <?php echo $value["niveau"]; ?>, '<?php echo $name; ?>')" class="floatRight">Graph 1</span>
                                </div><?php

                            }
                            
                        }

                        ?></div><?php

                        return array(
                            "cpt" => $cpt,
                        );

                    };

                    $comp = Competence::get_array($_SESSION['user']['id']);

                    foreach ($comp as $name => $value) {

                        if (is_array($value)) {

                            ?><div id="ddt<?php echo $cpt; ?>" class="dropdownTrigger"><?php echo $name ?></div><?php
                            
                            $returned = tab_2($value["enfant"], $cpt);

                            $cpt = $returned["cpt"];

                        } else {

                            ?><div><?php echo $name; ?> - <?php echo $value; ?></div><?php

                        }

                    }

                ?>

            </div>

            <?php

                $graph = $c->get_graphiques();
                $graphG = array(
                    1 => array(
                        "label" => array(),
                        "data" => array(),
                        "id" => array()
                    ), 2 => array(
                        "label" => array(),
                        "data" => array(),
                        "id" => array()
                    ), 3 => array(
                        "label" => array(),
                        "data" => array(),
                        "id" => array()
                    )
                );

                foreach ($graph as $values) {

                    if ($values['niveau'] == null) $values['niveau'] = "0";

                    $graphG[$values['id_graphique']]['label'][] = $values['nom'];
                    $graphG[$values['id_graphique']]['data'][] = $values['niveau'];
                    $graphG[$values['id_graphique']]['id'][] = $values['id_competence'];                    

                }
                // echo '<pre style="text-align: left;">';
                // var_dump($graphG);
                // echo '</pre>';

            ?>

            <div class="graph">

                <div class="graph1"><span>Graphique 1</span>
                    <?php
                        foreach ($graphG[1]["label"] as $key => $value) {
                            ?><div class="graphComp" data-id="<?php echo $graphG[1]["id"][$key]; ?>" data-lvl="<?php echo $graphG[1]["niveau"][$key]; ?>"><?php echo $value; ?><div onclick='g.delG1(<?php echo $graphG[1]["id"][$key]; ?>)' class='del'>&times;</div></div><?php
                        }
                    ?>
                </div>

                <div class="graph2"><span>Graphique 2</span>
                    <?php
                        foreach ($graphG[2]["label"] as $key => $value) {
                            ?><div class="graphComp" data-id="<?php echo $graphG[2]["id"][$key]; ?>" data-lvl="<?php echo $graphG[2]["niveau"][$key]; ?>"><?php echo $value; ?><div onclick='g.delG2(<?php echo $graphG[2]["id"][$key]; ?>)' class='del'>&times;</div></div><?php
                        }
                    ?>
                </div>

                <div class="graph3"><span>Graphique 3</span>
                    <?php
                        foreach ($graphG[3]["label"] as $key => $value) {
                            ?><div class="graphComp" data-id="<?php echo $graphG[3]["id"][$key]; ?>" data-lvl="<?php echo $graphG[3]["niveau"][$key]; ?>"><?php echo $value; ?><div onclick='g.delG3(<?php echo $graphG[3]["id"][$key]; ?>)' class='del'>&times;</div></div><?php
                        }
                    ?>
                </div>

            </div>

            <script>

                var g = new Graph;
                g.load();
        
            </script>
        
        </div>

    </div>

    <script>
        Popup.open('InfoP');
        Dropdown.load();
    </script>

</body>
</html>

<!-- 

 bouton envoier graph
 load les graph deja present dans la base de données

-->