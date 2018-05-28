<?php

    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Consultant.php";
    
    session_start();

    $_SESSION["user"] = array(
        'id' => 1,
        'login' => 'Jean-Didz',
        'type' => 2
    );

    $id = $_SESSION['user']['id'];

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $consultant = new Consultant($id);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="/cdn/Chart.bundle.min.js"></script>
    <script src="/cdn/Chart.js"></script>
    <script src="/cdn/Dropdown.js"></script>
    <title>A2F Advisor</title>
</head>
<body>
    <header>
        <div class="header-left">
            <img id="logo-a2f" src="/images/logo-a2f-blanc-02.svg" height="46">
        </div>
        <div class="header-right">
            <div class="btn bold" onclick="location.href='http://<?php echo $_SERVER['HTTP_HOST']; ?>'">Déconnexion</div>
        </div>
        <div class="header-right">
            <div>Bienvenue, <span><?php echo $_SESSION['user']['login']; ?></span></div>
        </div>
    </header>
    <nav>
        <div id="image-profile">
            <img src="/images/unknown.png" alt="profile image">
        </div>
        <div class="profile-info bold" style="text-transform: uppercase;">pôle <?php echo $consultant->get_nom_pole(); ?></div>
        <div class="hr"></div>
        <div class="profile-info" data-info="prenom"><?php echo $consultant->get_prenom(); ?></div>
        <div class="profile-info" data-info="nom"><?php echo $consultant->get_nom(); ?></div>
        <div class="profile-info" data-info="email"><?php echo $consultant->get_email(); ?></div></div>
        <div class="profile-info" data-info="telephone"><?php echo $consultant->get_telephone(); ?></div></div>
        <div class="profile-info" data-info="linkedin"><?php echo $consultant->get_linkedin(); ?></div></div>
        
        <?php if ($_SESSION['user']['type'] >= 1 || $_SESSION['user']['login'] == $consultant->get_login()) {?>
            <div class="hr"></div>
            <div class="profile-info salaire"> salaire : <?php echo $consultant->get_salaire(); ?>€</div></div>
        <?php } ?>
        
        <div class="bottom btn h-56 modif-profile bold" 
                onclick="location.href='#; ?>'">Modifier mon profil</div>
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
                            <div style="float: right;margin-right: 20px">
                                <i class="material-icons clickable">add</i>
                            </div>
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
                            <div style="float: right;margin-right: 20px">
                                <i class="material-icons clickable">add</i>
                            </div>
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
                        
                        function tab($name, $tab, $cpt) {

                            $html = array();

                            $html[] = "<div id=\"ddc" . $cpt . "\" class=\"dropdownContainer\" >";

                            $cpt += 1;
                            
                            foreach ($tab as $name => $value) {
                                
                                if (is_array($value)) {
                                    
                                    $html[] = "<div id=\"ddt" . $cpt . "\" class=\"dropdownTrigger\">" . $name . "</div>";
                                    
                                    $returned = tab($name, $value, $cpt);
    
                                    $cpt = $returned["cpt"];
    
                                    foreach ($returned["html"] as $line) {
    
                                        $html[] = $line;
    
                                    }
    
                                    foreach ($returned["script"] as $line) {
    
                                        $script[] = $line;
    
                                    }
    
                                } else {
    
                                    $html[] = "<div class=\"comp\">" . $name . " - " . $value . "</div>";
    
                                }
                                
                            }

                            $html[] = "</div>";

                            return array(
                                "cpt" => $cpt,
                                "html" => $html,
                                "script" => $script
                            );
                        
                        };

                        $html = array();
                        
                        foreach ($comp as $name => $value) {
                        
                            if (is_array($value)) {

                                $html[] = "<div id=\"ddt" . $cpt . "\" class=\"dropdownTrigger\">" . $name . "</div>";
                                
                                $returned = tab($name, $value, $cpt);

                                $cpt = $returned["cpt"];

                                foreach ($returned["html"] as $line) {

                                    $html[] = $line;

                                }

                            } else {

                                $html[] = "<div>" . $name . " - " . $value . "</div>";

                            }

                        }

                        foreach ($html as $line) {

                            echo $line . PHP_EOL;

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
                        if ($graphG[$values['id_graphique']]['length'] > 0) {
                            $graphG[$values['id_graphique']]['label'] .= ",";
                            $graphG[$values['id_graphique']]['data'] .= ",";
                        }
                        $graphG[$values['id_graphique']]['label'] .= "\"" . $values['nom'] . "\"";
                        $graphG[$values['id_graphique']]['data'] .= $values['niveau'];
                        $graphG[$values['id_graphique']]['length'] += 1;
                        

                    }  
                    //var_dump($graphG);

                if ($graphG[1]["length"] > 2) { ?>

                <canvas id="chart-p1" class="chartjs" width="200" height="200"></canvas>
                
                <script>  
                    var co1 = new chartOption();
                    co1.chart.data.datasets[0].data = [<?php echo $graphG[1]["data"]; ?>]
                    co1.chart.data.labels = [<?php echo $graphG[1]["label"]; ?>]
                    new Chart(document.getElementById("chart-p1"), co1.option);
                </script>

                <?php }
                
                if ($graphG[2]["length"] > 2) { ?>
                
                    <canvas id="chart-p2" class="chartjs" width="200" height="200"></canvas>
                    <script>
                    var co2 = new chartOption();
                    co2.chart.data.datasets[0].data = [<?php echo $graphG[2]["data"]; ?>]
                    co2.chart.data.labels = [<?php echo $graphG[2]["length"]; ?>]
                    new Chart(document.getElementById("chart-p2"), co2.option);
                    </script>
                
                <?php }
                
                if ($graphG[2]["length"] > 2) { ?>

                    <canvas id="chart-p3" class="chartjs" width="200" height="200"></canvas>
                    <script>
                    var co3 = new chartOption();
                    co3.chart.data.datasets[0].data = [<?php echo $graphG[3]["data"]; ?>]
                    co3.chart.data.labels = [<?php echo $graphG[3]["length"]; ?>]
                    new Chart(document.getElementById("chart-p3"), co3.option);
                </script>

                <?php } ?>

            </div>
            <div id="timeLine">
                <div class="line">
                    <div class="point">
                        <div class="tooltip">
                            Arriver dans l'entreprise
                        </div>
                        <div class="pointLabel">
                            14 mai 2018
                        </div>
                    </div>
                </div>
            </div>         
        </div>
    </div>

</body>
</html>