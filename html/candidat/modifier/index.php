<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Competence.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/RH.php";    
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Candidat.php";

    session_start();

/*
    if(isset($_GET['id'])){

        $id = $_GET['id'];
    
        $c = new Candidat($id);
    }
    elseif(isset($_POST['id_cons'])){
        
        $id = $_POST['id_cons'];

        $c = new Candidat($id);
    }

    else{
        echo "Candidat introuvable";
        exit();
    
    }
 */
    $id = 1;

    $c = new Candidat($id);

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
    <link rel="stylesheet" href="/candidat/modifier/main.css">
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
        <div onclick="Popup.open('Inter')" class="onglet">Entretiens</div>
        <div onclick="Popup.open('Qual')" class="onglet">Qualifications</div>
    </nav>
    <div class="mainWrapper">

        <div onclick="location.href='/candidat/'" class="close">Retour</div>

        <div class="popup" id="Comp"><div class="nav">Compétences</div>
        
            <!-- // Comp section // -->
        
            <div onclick="Competence.send_candidat()" class="submit">Envoyer</div>

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

            <form action="/candidat/modifier/" method="post">
            
                <input type="hidden" name="modif" value="info">
<!--                <input type="hidden" name="id_cons" value="<?php echo $id; ?>">                -->

                <input type="text" name="nom" placeholder="Nom" value="<?php echo $c->get_nom(); ?>" required>
                <input type="text" name="prenom" placeholder="Prenom" value="<?php echo $c->get_prenom(); ?>" required>
                <input type="text" name="email" placeholder="Email" value="<?php echo $c->get_email(); ?>" required>
                <input type="text" name="tel" placeholder="Téléphone" value="<?php echo $c->get_telephone(); ?>" required>
                <input type="text" name="linkedin" placeholder="Linkedin" value="<?php echo $c->get_linkedin(); ?>">

                <input type="submit" value="Envoyer">

            </form>


        </div>
        <div class="popup" id="Inter"><div class="nav">Entretiens</div>
        
            <!-- // Inter section // -->

            <form action="/candidat/modifier/" method="post">

                <input type="hidden" name="modif" value="int">
                <input type="hidden" name="action" value="add">                
                <input type="hidden" name="id" value="<?php echo $id ?>">                
               
                     <div class="intervention">
                    <div class="infos">Date</div>
                    <div class="infos">RH</div>
                    <div class="details textCenter">
                        Détails
                    </div>
                </div>
                
                <div class="hr"></div>
                <div class="intervention">
                    <div class="infos"><input type="date" name="date" required></div>
                    <div class="infos"><select name="RH" required><option selected disabled>RH</option><?php
                    
                        $cl = RH::get_array();

                        foreach ($cl as $key => $value) {


                            ?><option value="<?php echo $value['id_rh']; ?>"><?php echo $value['nom']; echo " "; echo $value['prenom']; ?></option><?php

                        }

                    ?></select></div>
                    <div class="details textCenter">
                        <textarea placeholder="Détails de l'intervention" name="details" maxlength="500" rows="10" required></textarea>
                    </div>
                    <div class="InterSubmit"><input type="submit" value="Envoyer"></div>
                </div>

                <?php

                    $arr = $c->get_interviews();
                    foreach ($arr as $int) {

                ?>

                    <div class="hr"></div>
                    <div class="intervention">
                        <div class="infos"><?php echo $int['date_entretien']; ?></div>
                        <div class="infos"><?php echo $int['nom']; echo " "; echo $int['prenom']; ?></div>
                        <div class="details"><?php echo $int['details']; ?></div>
                        <div class="InterSubmit"><div onclick="Intervention.del_candidat(<?php echo $int['id_entretien']; ?>)" class="delInt">Supprimer</div></div>
                    </div>

                <?php

                    }

                ?>
            
            </form>

        </div>
        <div class="popup" id="Qual"><div class="nav">Qualifications</div>
        
            <!-- // qual section // -->

            <form action="/candidat/modifier/" method="post">

                <input type="hidden" name="modif" value="qual">
                <input type="hidden" name="action" value="add">
                
                <input type="hidden" name="id" value="<?php echo $id ?>">                

                <div class="qualification">
                    <div class="infos">Qualification</div>
                    <div class="infos">Date d'obtention</div>
                    <div class="details textCenter">
                        Détails
                    </div>
                </div>

                <div class="hr"></div>
                <div class="qualification">
                    <div class="infos"><input type="text" name="nom" placeholder="Nom de la qualification" required></div>
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
                        <div class="QualSubmit"><div onclick="Qualification.del_candidat(<?php echo $qual['id_qualification']; ?>)" class="delInt">Supprimer</div></div>
                    </div>

                <?php

                    }

                ?>

                </form>

        </div>

    </div>

    <script>
        Popup.open('InfoP');
        Dropdown.load();
    </script>

</body>
</html>
