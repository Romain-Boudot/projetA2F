<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Competence.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Candidat.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/RH.php"; 
    session_start();


    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    else{
        echo "Candidat non reconnu";
        exit();
    }

    $candidat = new Candidat($id);
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/cdn/main.css">
    <link rel="stylesheet" href="/candidat/main.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="/cdn/Chart.bundle.min.js"></script>
    <script src="/cdn/Ajax.js"></script>
    <script src="/cdn/url_get.js"></script>
    <script src="/cdn/Candidat.js"></script>
    <script src="/cdn/Chart.js"></script>
    <script src="/cdn/Dropdown.js"></script>
    <title>A2F Advisor</title>
</head>
<body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . "/../includes/header.php" ?>
    
    <nav>
        <div id="image-profile">
            <img src="/images/unknown.png" alt="profile image">
        </div>
        <div class="hr"></div>
        <div class="profile-info" data-info="prenom"><?php echo $candidat->get_prenom(); ?></div>
        <div class="profile-info" data-info="nom"><?php echo $candidat->get_nom(); ?></div>
        <div class="profile-info" data-info="email"><?php echo $candidat->get_email(); ?></div></div>
        <div class="profile-info" data-info="telephone"><?php echo $candidat->get_telephone(); ?></div></div>
        <div class="profile-info" data-info="linkedin"><?php echo $candidat->get_linkedin(); ?></div></div>

            <form action="/candidat/traitement.php" method="get">
    
                    <input type="hidden" name="action" value="transfer"> 
                <input type="hidden" name="id" value=" <?php echo $id; ?> ">
    
                <input type="submit" value="Envoyer">

            </form>

        <a class="bottom btn h-56 modif-profile bold" href='/candidat/modifier?id=<?php echo $id; ?>'>Modifier mon profil</a>

    </nav>

    <div class="main-wrapper">
        <div class="relative-wrapper-container">
            <div style="width: 100%; margin-bottom: 20px; position: relative; height: 0px;overflow: hidden;">fixing div</div>
            <div id="onglets-wrapper">
                <div id="ot1" class="onglet-label ongletTrigger">Entretiens</div><div id="ot2" class="onglet-label ongletTrigger">Qualifications</div><div id="ot3" class="onglet-label ongletTrigger">Compétences</div>
                <div id="oc1" class="onglet ongletContainer">
                    <div class="intervention">
                        <div class="infos">Date</div>
                        <div class="infos">Responsable</div>
                        <div class="details textCenter">
                            Détails
                        </div>
                    </div>

                    <?php

                        $tab = $candidat->get_interviews();
                        foreach ($tab as $int) {
                            ?>

                    <div class="hr"></div>
                    <div class="intervention">
                        <div class="infos"><?php echo $int['date_entretien']; ?></div>
                        <div class="infos"><?php echo $int['nom']; echo " "; echo $int['prenom']; ?></div>
                        <div class="details"><?php echo $int['details']; ?></div>
                    </div>

                            <?php
                        }
                    ?>
                
                </div>
                <div id="oc2" class="onglet ongletContainer">
                    <div class="qualification">
                        <div class="infos">Qualification</div>
                        <div class="infos">Date d'obtention</div>
                        <div class="details textCenter">
                            Détails
                        </div>
                    </div>

                    <?php           
                    
                    $tab = $candidat->get_qualifications();
                    foreach ($tab as $int) {
                    
                    ?>

                    <div class="hr"></div>
                    <div class="qualification">
                        <div class="infos"><?php echo $int['nom_qualification']; ?></div>
                        <div class="infos"><?php echo $int['date_obtention']; ?></div>
                        <div class="details"><?php echo $int['details']; ?></div>
                    </div>   

                    <?php
                        }
                    ?>           
                    
                </div>
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
    
                                    if ($value["niveau"] == null) $value["niveau"] = 0;

                                    ?><div class="comp"><?php echo $name; ?> - <?php echo $value["niveau"]; ?></div><?php
    
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
                
                <script>
                    Dropdown.load();
                </script>

            </div>
            <?php
                $step = $candidat->get_etape();
            ?>

<?php
                        $step = $candidat->get_etape();
?>

        <div id="timeLine">
            <div class="line">
                <div class="coloredLine step<?php echo $step; ?>"></div>
                <div class="point<?php if ($step >= 1) echo " colored"; ?>">
                    <div class="pointLabel">
                        1er appel téléphonique
                    </div>
                    <div onclick="C.ajust_tm(2)" class="point<?php if ($step >= 2) echo " colored"; ?>">
                        <div class="pointLabel">
                            1er entretien
                        </div>
                    </div>
                    <div onclick="C.ajust_tm(3)" class="point<?php if ($step >= 3) echo " colored"; ?>">
                        <div class="pointLabel">
                            2nd entretien
                        </div>
                    </div>
                    <div onclick="C.ajust_tm(4)" class="point<?php if ($step >= 4) echo " colored"; ?>">
                        <div class="pointLabel">
                            3ème entretien
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
