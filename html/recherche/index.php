<?php

    session_start();

    function login_redirect() {
        header('location: http://' . $_SERVER['HTTP_HOST'] . "/login");
        exit();
    }

    if (isset($_SESSION['user']['connected'])) {

        if (!$_SESSION['user']['connected']) login_redirect();

    } else login_redirect();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recherche</title>
</head>
<body>
    Page de Recherche <br>
    <a href="http://<?php echo $_SERVER['HTTP_HOST'];?>">accueil</a>
    <?php
        if ($_SESSION['user']['type'] == 0) {
            ?>
    <a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/consultant">Profile consultant</a>
            <?php
        }
    ?>
    <a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/disconnect.php">Déconnexion</a>
</body>
</html>