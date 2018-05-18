<?php
    var_dump($_POST);

    if (isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST["type"])) {

        // password check

        if ($_POST['type'] == 0 && $_POST['login'] == "A2F") {

            session_start();
            $_SESSION['user']['type'] = 0;
            $_SESSION['user']['id'] = 0;
            $_SESSION['user']['connected'] = true;

        }

        if ($_POST['type'] == 1 && $_POST['login'] == "A2F") {

            session_start();
            $_SESSION['user']['type'] = 1;
            $_SESSION['user']['id'] = 1;
            $_SESSION['user']['connected'] = true;

        }

        if ($_POST['type'] == 2 && $_POST['login'] == "A2F") {

            session_start();
            $_SESSION['user']['type'] = 2;
            $_SESSION['user']['id'] = 2;
            $_SESSION['user']['connected'] = true;

        }

        if (isset($_SESSION['user']['connected'])) {

            if ($_SESSION['user']['connected'] == true) {

                header('location: http://' . $_SERVER['HTTP_HOST']);

            }

        } 

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion</title>
</head>
<body>
    <form action="http://<?php echo $_SERVER['HTTP_HOST'];?>/identification" method="post">
        <span>Consultant</span>
        <input name="type" type="hidden" value="0">
        <input name="login" type="text" placeholder="identifiant">
        <input name="password" type="password" placeholder="mot de passe">
        <input type="submit" value="Connexion">
    </form>
    <br>
    <form action="http://<?php echo $_SERVER['HTTP_HOST'];?>/identification" method="post">
        <span>business manager</span>
        <input name="type" type="hidden" value="1">
        <input name="login" type="text" placeholder="identifiant">
        <input name="password" type="password" placeholder="mot de passe">
        <input type="submit" value="Connexion">
    </form>
    <br>
    <form action="http://<?php echo $_SERVER['HTTP_HOST'];?>/identification" method="post">
        <span>ressources humaines</span>
        <input name="type" type="hidden" value="2">
        <input name="login" type="text" placeholder="identifiant">
        <input name="password" type="password" placeholder="mot de passe">
        <input type="submit" value="Connexion">
    </form>
</body>
</html>