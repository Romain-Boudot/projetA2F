<?php

    

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
    <title>Profile Consultant</title>
</head>
<body>
    <header>
        <div class="header-left">
            <img id="logo-a2f" src="/images/logo-a2f-blanc-02.svg" height="46">
        </div>
        <div class="header-right">
            <div class="btn bold">Déconnexion</div>
        </div>
        <div class="header-right">
            <div>Bienvenue, <span>romain.boudot</span></div>
        </div>
    </header>
    <nav>
        <div id="image-profile">
            <img src="/images/unknown.png" alt="profile image">
        </div>
        <div class="profile-info bold">PÔLE DATABASE</div>
        <div class="hr"></div>
        <div class="profile-info" data-info="prenom">Romain</div>
        <div class="profile-info" data-info="nom">Boudot</div>
        <div class="profile-info" data-info="email">romain.boudot@epsi.fr</div>
        <div class="profile-info" data-info="telephone">06 01 02 01 03</div>
        <div class="profile-info" data-info="linkedin">monlienverslinkedin</div>
        <div class="hr"></div>
        <div class="profile-info salaire"> salaire : 2.000€</div>

        <div class="bottom btn h-56 modif-profile bold">Modifier mon profil</div>
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
                    <div class="hr"></div>
                    <div class="intervention">
                        <div class="infos">17 mai 2018</div>
                        <div class="infos">A2F advisor</div>
                        <div class="details">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.                                                            
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="intervention">
                        <div class="infos">17 mai 2018</div>
                        <div class="infos">A2F advisor</div>
                        <div class="details">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.
                        </div>
                    </div>
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
                    <div class="hr"></div>
                    <div class="qualification">
                        <div class="infos">
                            DES QUALIFICATION DE QUALITE
                        </div>
                        <div class="infos">
                            15 mai 2018
                        </div>
                        <div class="details">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.                                
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="qualification">
                        <div class="infos">
                            chasse a l'autruche
                        </div>
                        <div class="infos">
                            11 juin 2013
                        </div>
                        <div class="details">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.                                
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="qualification">
                        <div class="infos">
                            peche a la ligne
                        </div>
                        <div class="infos">
                            28 février 2001
                        </div>
                        <div class="details">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.                                
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="qualification">
                        <div class="infos">
                            elevage de bovin
                        </div>
                        <div class="infos">
                            18 septembre 1952
                        </div>
                        <div class="details">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.                                
                        </div>
                    </div>
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
                <canvas id="chart-p1" class="chartjs" width="200" height="200"></canvas>
                <script>
                    var co1 = new chartOption();
                    co1.chart.data.datasets[0].data = [3,2,3,2,1,3,1,2,3,2,2,3,2,1,3,1,2,3,2,2,3,2,1,3,1,2,3,2]
                    co1.chart.data.labels = ["bonjour","hola","hello","test","test","test","test","test","test","test","hola","hello","test","test","test","test","test","test","test","hola","hello","test","test","test","test","test","test","test"]
                    new Chart(document.getElementById("chart-p1"), co1.option);
                </script>
                <canvas id="chart-p2" class="chartjs" width="200" height="200"></canvas>
                <script>
                    var co2 = new chartOption();
                    co2.chart.data.datasets[0].data = [1,2,1]
                    co2.chart.data.labels = ["bonjour","hola","hello"]
                    new Chart(document.getElementById("chart-p2"), co2.option);
                </script>
                <canvas id="chart-p3" class="chartjs" width="200" height="200"></canvas>
                <script>
                    var co3 = new chartOption();
                    co3.chart.data.datasets[0].data = [3,2,1]
                    co3.chart.data.labels = ["bonjour","hola","hello"]
                    new Chart(document.getElementById("chart-p3"), co3.option);
                </script>
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