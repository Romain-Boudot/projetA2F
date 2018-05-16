<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="main.css">
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
        <div class="profile-info" data-info="linkedin">monlienverslinkedin</div>
        <div class="bottom btn h-56 modif-profile bold">Modifier mon profil</div>
    </nav>

    <div class="main-wrapper">
        <div class="relative-wrapper-container">
            <div style="width: 100%; margin-bottom: 20px; position: relative; height: 0px;overflow: hidden;">fixing div</div>
            <div id="onglets-wrapper">
                <div id="ongletInt" class="onglet-label">Interventions</div><div id="ongletQual" class="onglet-label">Qualifications</div><div id="ongletComp" class="onglet-label">Compétences</div>
                <div id="ongletIntContent" class="onglet">
                    <div class="intervention">
                        <div class="infos"><span>17 mai 2018</span><span>A2F advisor</span></div>
                        <div class="details">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.
                        </div>
                    </div>
                    <div class="intervention">
                        <div class="infos"><span>17 mai 2018</span><span>A2F advisor</span></div>
                        <div class="details">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.
                        </div>
                    </div>
                </div>
                <div id="ongletQualContent" class="onglet">
                    <ul>
                        <li>DES QUALIFICATION DE QUALITEY</li>
                        <li>en elevage de bovin</li>
                        <li>peche a la ligne</li>
                        <li>chasse a l'autruche</li>
                    </ul>
                </div>
                <div id="ongletCompContent" class="onglet">
                    <ul>
                        <li>comp 1</li>
                        <li>comp 2</li>
                        <li>comp 3</li>
                        <li>comp 4</li>
                        <li>comp 1</li>
                        <li>comp 2</li>
                        <li>comp 3</li>
                        <li>comp 4</li>
                        <li>comp 1</li>
                        <li>comp 2</li>
                        <li>comp 3</li>
                        <li>comp 4</li>
                        <li>comp 1</li>
                        <li>comp 2</li>
                        <li>comp 3</li>
                        <li>comp 4</li>
                        <li>comp 1</li>
                        <li>comp 2</li>
                        <li>comp 3</li>
                        <li>comp 4</li>
                        <li>comp 1</li>
                        <li>comp 2</li>
                        <li>comp 3</li>
                        <li>comp 4</li>
                        <li>comp 1</li>
                        <li>comp 2</li>
                        <li>comp 3</li>
                        <li>comp 4</li>
                        <li>comp 1</li>
                        <li>comp 2</li>
                        <li>comp 3</li>
                        <li>comp 4</li>
                        <li>comp 1</li>
                        <li>comp 2</li>
                        <li>comp 3</li>
                        <li>comp 4</li>
                        <li>comp 1</li>
                        <li>comp 2</li>
                        <li>comp 3</li>
                        <li>comp 4</li>
                        <li>comp 1</li>
                        <li>comp 2</li>
                        <li>comp 3</li>
                        <li>comp 4</li>
                    </ul>
                </div>

                <script>
                    
                    var ongletInt = new Dropdown(
                        document.getElementById("ongletInt"),
                        document.getElementById("ongletIntContent"),
                        false
                    );

                    var ongletQual = new Dropdown(
                        document.getElementById("ongletQual"),
                        document.getElementById("ongletQualContent"),
                        false
                    );

                    var ongletComp = new Dropdown(
                        document.getElementById("ongletComp"),
                        document.getElementById("ongletCompContent"),
                        false
                    );

                    ongletInt.trigger.addEventListener("click", function() {
                        ongletInt.switch_status();
                    });

                    ongletQual.trigger.addEventListener("click", function() {
                        ongletQual.switch_status();
                    });

                    ongletComp.trigger.addEventListener("click", function() {
                        ongletComp.switch_status();
                    });

                    ongletInt.toHideElem = [ongletQual, ongletComp];
                    ongletQual.toHideElem = [ongletInt, ongletComp];
                    ongletComp.toHideElem = [ongletInt, ongletQual];

                </script>

            </div>
            <div id="chart-wrapper">
                <canvas id="chart-p1" class="chartjs" width="200" height="200"></canvas>
                <script>
                    var co1 = new chartOption();
                    co1.chart.data.datasets[0].data = [3,2,3]
                    co1.chart.data.labels = ["bonjour","hola","hello"]
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