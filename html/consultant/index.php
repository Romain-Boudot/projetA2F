<?php

    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Security.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Competence.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Consultant.php";
    
    session_start();

    Security::check_login(array(0, 1, 2));

    $id = $_SESSION['user']['id'];

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        if ($_SESSION['user']['type'] != 0) {
            echo "vous n'etes pas consultant";
            exit();
        }
    }

    $consultant = new Consultant($id);

    $pole = $consultant->get_pole();

    include_once $_SERVER['DOCUMENT_ROOT'] . "/../includes/splitstr.php";
    
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
                if ($pole == 0) echo "#06436f";
                if ($pole == 1) echo "#f7931e";
                if ($pole == 2) echo "#259225";
                if ($pole == 3) echo "#f05944";
            ?>;
            --main-color-light: <?php
                if ($pole == 0) echo "#06436f88";
                if ($pole == 1) echo "#f7931e88";
                if ($pole == 2) echo "#25922588";
                if ($pole == 3) echo "#f0594488";
            ?>;
            --auto-color: <?php
                if ($pole == 0) echo "white";
                else echo "inerit"
            ?>;
        }
    </style>
    <link rel="stylesheet" href="/cdn/main.css">
    <link rel="stylesheet" href="/consultant/main.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="/cdn/Chart.bundle.min.js"></script>
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
        <div class="profile-info bold" style="text-transform: uppercase;">pôle <?php echo $consultant->get_nom_pole(); ?></div>
        <div class="hr"></div>
        <div class="profile-info left">Prénom :</div>
        <div class="profile-info" data-info="prenom"><?php echo $consultant->get_prenom(); ?></div>
        <div class="profile-info left">Nom :</div>
        <div class="profile-info" data-info="nom"><?php echo $consultant->get_nom(); ?></div>
        <div class="profile-info left">Email :</div>
        <a href="mailto:<?php echo $consultant->get_email(); ?>" class="profile-info underline" data-info="email"><?php echo $consultant->get_email(); ?></a>
        <div class="profile-info left">Téléphone :</div>
        <div class="profile-info" data-info="telephone"><?php echo $consultant->get_telephone(); ?></div>
        <div class="profile-info left">LinkedIn :</div>
        <a href="<?php echo $consultant->get_linkedin(); ?>" class="profile-info underline" data-info="linkedin"><?php echo $consultant->get_linkedin(); ?></a>
        
        <?php if ($_SESSION['user']['type'] >= 1 || $_SESSION['user']['login'] == $consultant->get_login()) {?>
            <div class="hr"></div>
            <div class="profile-info salaire">salaire : <?php echo $consultant->get_salaire(); ?>€</div>
        <?php
        
        }

        if ($_SESSION['user']['login'] == $consultant->get_login()) {?>

        <a class="bottom btn h-56 modif-profile bold" href="/consultant/modifier">Modifier mon profil</a>

        <?php } ?>
    </nav>

    <div class="main-wrapper">
        <div class="relative-wrapper-container">
            <div style="width: 100%; margin-bottom: 20px; position: relative; height: 0px;overflow: hidden;">fixing div</div>
            <div id="onglets-wrapper">
                <div id="ot1" class="onglet-label ongletTrigger">Interventions</div><div id="ot2" class="onglet-label ongletTrigger">Qualifications</div><div id="ot3" class="onglet-label ongletTrigger">Compétences</div>
                <div id="oc1" class="onglet ongletContainer">
                    <div class="intervention">
                        <div class="infos">Date</div>
                        <div class="infos">Client</div>
                        <div class="details textCenter">
                            Détails
                        </div>
                    </div>

                    <?php

                        $tab = $consultant->get_interventions();
                        foreach ($tab as $int) {
                            ?>

                    <div class="hr"></div>
                    <div class="intervention">
                        <div class="infos"><?php echo $int['date']; ?></div>
                        <div class="infos"><?php echo $int['entreprise']; ?></div>
                        <div class="details"><?php echo $int['details']; ?></div>
                    </div>

                            <?php
                        }
                    ?>
                
                    <?php

                        //$tab = $consultant->get_qualifications();

                        //foreach ($tab as $int) {
                            
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
                    
                    $tab = $consultant->get_qualifications();
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

            <div id="chart-wrapper">

                <?php

                    $graph = $consultant->get_graphiques();
                    $graphG = array(
                        1 => array(
                            "label" => "",
                            "data" => "",
                            "length" => 0
                        ),
                        2 => array(
                            "label" => "",
                            "data" => "",
                            "length" => 0
                        ),
                        3 => array(
                            "label" => "",
                            "data" => "",
                            "length" => 0
                        )
                    );

                    foreach ($graph as $values) {

                        if ($values["niveau"] == null) $values["niveau"] = 0;

                        if ($graphG[$values['id_graphique']]['length'] > 0) {
                            $graphG[$values['id_graphique']]['label'] .= ",";
                            $graphG[$values['id_graphique']]['data'] .= ",";
                        }

                        $graphG[$values['id_graphique']]['label'] .= splitstr($values['nom']);
                        $graphG[$values['id_graphique']]['data'] .= $values['niveau'];
                        $graphG[$values['id_graphique']]['length'] += 1;

                    }

                if ($graphG[1]["length"] > 2) { ?>

                <canvas id="chart-p1" class="chartjs" width="200" height="200"></canvas>
                
                <script>  
                    var co1 = new chartOption();
                    co1.chart.data.datasets[0].data = [<?php echo $graphG[1]["data"]; ?>]
                    co1.chart.data.labels = [<?php echo $graphG[1]["label"]; ?>]
                    c1 = new Chart(document.getElementById("chart-p1"), co1.option);
                </script>

                <?php }
                
                if ($graphG[2]["length"] > 2) { ?>
                
                <canvas id="chart-p2" class="chartjs" width="200" height="200"></canvas>
                <script>
                    var co2 = new chartOption();
                    co2.chart.data.datasets[0].data = [<?php echo $graphG[2]["data"]; ?>]
                    co2.chart.data.labels = [<?php echo $graphG[2]["label"]; ?>]
                    c2 = new Chart(document.getElementById("chart-p2"), co2.option);
                </script>
                
                <?php }
                
                if ($graphG[3]["length"] > 2) { ?>

                <canvas id="chart-p3" class="chartjs" width="200" height="200"></canvas>
                <script>
                    var co3 = new chartOption();
                    co3.chart.data.datasets[0].data = [<?php echo $graphG[3]["data"]; ?>]
                    co3.chart.data.labels = [<?php echo $graphG[3]["label"]; ?>]
                    c3 = new Chart(document.getElementById("chart-p3"), co3.option);
                </script>

                <?php } ?>

            </div>   
        </div>
        <div style="text-align: right; margin-top: 50px">
            <div style="width: 200px; position: absolute; right:0; text-align: center;">
                <?php
                if ($pole == 1) {
                    ?><img class="logo" src="/images/schema-industrie-15.svg" alt="logo Indus" width="150"><?php
                } elseif ($pole == 2) {
                    ?><img class="logo" src="/images/visuel-si.svg" alt="logo Si" width="150"><?php
                } elseif ($pole == 3) {
                    ?><img class="logo" src="/images/schema-database-17.svg" alt="logo database" width="150"><?php
                }
                ?>
                <div class="logoTitle"><?php echo $consultant->get_nom_pole(); ?></div>
            </div>
        </div>
    </div>

</body>
</html>
