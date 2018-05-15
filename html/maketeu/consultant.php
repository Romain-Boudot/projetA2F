<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="main.css">
    <script src="/cdn/Chart.bundle.min.js"></script>
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
        <div class="hr"></div>
        <div class="profile-info" data-info="prenom">Romain</div>
        <div class="profile-info" data-info="nom">Boudot</div>
        <div class="profile-info" data-info="email">romain.boudot@epsi.fr</div>
        <div class="profile-info" data-info="linkedin">monlienverslinkedin</div>
        <div class="bottom btn w-100 h-56 modif-profile bold">Modifier mon profil</div>
    </nav>

    <div class="main-wrapper">
        <div id="chart-wrapper">
            <canvas id="chart-test" class="chartjs" width="400" height="400"></canvas>
            <script>
                new Chart(document.getElementById("chart-test"),{
                    "type":"radar",
                    "data":{
                        "labels": ["Eating","Drinking","Sleeping","Designing","Coding","Cycling","Running"],
                        "datasets":[
                            {
                                "data": [0,1,1,3,2,2,1],
                                "tension": 0,
                                "backgroundColor": "rgba(255, 99, 132, 0.2)",
                                "borderColor": "rgb(255, 99, 132)",
                                "pointBackgroundColor": "rgb(255, 99, 132)",
                                "pointBorderColor": "#fff",
                                "pointHoverBackgroundColor": "#fff",
                                "pointHoverBorderColor": "rgb(255, 99, 132)"
                            }
                        ]
                    },
                    "options":{
                        "scale": {
                            "ticks": {
                                "max": 3,
                                "min": 0,
                                "stepSize": 1
                            }
                        },
                        "legend":{
                            "display": false
                        },
                        "layout":{
                            "padding": {
                                "top": 20,
                                "left": 20,
                                "right": 20,
                                "bottom": 20
                            }
                        },
                        "elements":{
                            "line":{
                                "borderWidth":3
                            }
                        }
                    }
                });
            </script>
        </div>
    </div>

</body>
</html>