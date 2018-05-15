<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Git pull</title>
</head>
<body>

<?php

ini_set('display_errors', 1);

if (isset($_GET["gitbranch"])) {
    $output = array();
    exec("cd /srv/www/projetA2F/ && git pull origin " . $_GET["gitbranch"], $output);
    foreach($output as $line) {
        echo $line . "<br>";
    }
    exit();
} else {
?>
    <form action="/gitpull.php" method="get">
        <input name="gitbranch" type="text" value="" placeholder="branch">
        <input type="submit" value="Pull">
    </form>

<?php 
}
?>
</body>
</html>