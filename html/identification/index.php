<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Database.php";

    session_start();

    if (isset($_GET["token"])) {

        $pass = true;
        include_once "register.php";
        exit();

    }

    if (isset($_POST["login"]) && isset($_POST["password"])) {

        if (Database::login($_POST["login"], $_POST["password"])) {

            header('location: http://' . $_SERVER['HTTP_HOST']);

        }

    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/cdn/main.css">
    <link rel="stylesheet" href="/identification/main.css">
    <title>A2F Advisor</title>
</head>
<body>
    
    <div class="login-wrapper">

        <img src="/images/logo-a2f-blanc-02.svg" alt="logo a2f" height="60">
        <h3 class="white">Connexion</h3><br>

        <form action="http://<?php echo $_SERVER['HTTP_HOST'];?>/identification/" method="post">
            <i class="material-icons">account_box</i>
            <input name="login" type="text" placeholder="identifiant"><br>
            <i class="material-icons">lock</i>
            <input name="password" type="password" placeholder="mot de passe"><br>
            <input type="submit" value="Se connecter">
        </form>

    </div>

</body>
</html>
