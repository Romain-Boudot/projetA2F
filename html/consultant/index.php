<?php

    //include_once "/srv/www/projetA2F/class/Database.php";
    //include_once "/srv/www/projetA2F/class/Consultant.php";

    session_start();

    function login_redirect() {
        header('location: http://' . $_SERVER['HTTP_HOST'] . "/login");
        exit();
    }
    
    if (isset($_SESSION['user']['connected'])) {
    
        if (!$_SESSION['user']['connected']) login_redirect();
    
    } else login_redirect();

    if (!isset($_POST['id'])) {
        $id = $_SESSION['user']['id'];
    } else {
        if ($_SESSION['user']['type'] != 0) {
            $id = -1;
        } else {
            $id = $_POST['id'];
        }
    }

    if ($id == -1) {
        echo "vous n'etes pas un consultant";
        exit();
    }

    //$consultant = new Consultant($id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile consultant</title>
</head>
<body>
    Page consultant <?php echo $id; ?><br>
    <a href="http://<?php echo $_SERVER['HTTP_HOST'];?>">accueil</a>
    <a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/recherche">Recherche</a>
    <a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/disconnect.php">Déconnexion</a>
</body>
</html>