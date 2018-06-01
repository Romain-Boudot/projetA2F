
<?php

error_reporting(E_ALL);

include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Competence.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Candidat.php";

session_start();

// var_dump($_SESSION);
// var_dump($_GET);

$id = $_GET['id'];

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
        
        <a class="bottom btn h-56 modif-profile bold" href="/candidat/modifier">Modifier le profil</a>

    </nav>

    <div class="main-wrapper">
        <div class="relative-wrapper-container">
            <div style="width: 100%; margin-bottom: 20px; position: relative; height: 0px;overflow: hidden;">fixing div</div>

            <div id="onglets-wrapper">
                <div id="ot1" class="onglet-label ongletTrigger">Entretiens</div>
       <div id="oc1" class="onglet ongletContainer">
                    <div class="intervention">
                        <div class="infos">Date</div>
                        <div class="infos">RH</div>
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
                        <div class="infos"><?php echo $int['prenom'];
echo " ";
echo $int['nom']; ?></div>

                        <div class="details"><?php echo $int['details']; ?></div>
                    </div>

<?php
}
?>


                </div>
            </div>

        </div>
    </div>

</body>
</html>
