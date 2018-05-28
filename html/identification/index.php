<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Databse.php";

    if (isset($_POST["login"]) && isset($_POST["password"])) {



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
    <link rel="stylesheet" href="/cdn/main.css">
    <link rel="stylesheet" href="/identification/main.css">
    <title>Connexion</title>
</head>
<body>
    
    <div class="login-wrapper">

        <img src="/images/logo-a2f-blanc-02.svg" alt="logo a2f" height="60">

        <form action="http://<?php echo $_SERVER['HTTP_HOST'];?>/identification" method="post">
            <h3>Connexion</h3><br>
            <input name="login" type="text" placeholder="identifiant"><br>
            <input name="password" type="password" placeholder="mot de passe"><br>
            <input type="submit" value="Se connecter">
        </form>

    </div>

</body>
</html>
<!--
<form action="http://<?php //echo $_SERVER['HTTP_HOST'];?>/identification" method="post">
    <span>Consultant</span>
    <input name="type" type="hidden" value="0">
    <input name="login" type="text" placeholder="identifiant">
    <input name="password" type="password" placeholder="mot de passe">
    <input type="submit" value="Connexion">
</form>
<br>
<form action="http://<?php //echo $_SERVER['HTTP_HOST'];?>/identification" method="post">
    <span>business manager</span>
    <input name="type" type="hidden" value="1">
    <input name="login" type="text" placeholder="identifiant">
    <input name="password" type="password" placeholder="mot de passe">
    <input type="submit" value="Connexion">
</form>
<br>
<form action="http://<?php //echo $_SERVER['HTTP_HOST'];?>/identification" method="post">
    <span>ressources humaines</span>
    <input name="type" type="hidden" value="2">
    <input name="login" type="text" placeholder="identifiant">
    <input name="password" type="password" placeholder="mot de passe">
    <input type="submit" value="Connexion">
</form> -->