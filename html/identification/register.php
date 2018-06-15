<?php

if (isset($pass)) {
    if (!$pass) {
        include_once $_SERVER["DOCUMENT_ROOT"] . "/erreurs/403.php";
        exit();
    }
} else {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/erreurs/403.php";
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>A2F Advisor</title>
</head>
<body>
    
</body>
</html>