<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/../classes/Database.php";

    session_start();

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
    <link rel="stylesheet" href="/cdn/main.css">
    <link rel="stylesheet" href="/identification/main.css">
    <title>Connexion</title>
</head>
<body>
    
    <div class="login-wrapper">

        <img src="/images/logo-a2f-blanc-02.svg" alt="logo a2f" height="60">

        <form action="http://<?php echo $_SERVER['HTTP_HOST'];?>/identification/" method="post">
            <h3>Connexion</h3><br>
            <input name="login" type="text" placeholder="identifiant"><br>
            <input name="password" type="password" placeholder="mot de passe"><br>
            <input type="submit" value="Se connecter">
        </form>

    </div>

</body>
</html>
