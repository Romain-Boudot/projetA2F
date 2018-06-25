<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Consultant.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/RH.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/BM.php";

if (isset($pass)) {
    if (!$pass) {
        echo '1';
        include_once $_SERVER["DOCUMENT_ROOT"] . "/erreurs/403.php";
        exit();
    }
} else {
        echo '2';
        include_once $_SERVER["DOCUMENT_ROOT"] . "/erreurs/403.php";
    exit();
}

$consultant = Consultant::get_consultant_via_token($_GET["token"]);
$bm = BM::get_bm_via_token($_GET["token"]);
$rh = RH::get_rh_via_token($_GET["token"]);

if (!$consultant && !$bm && !$rh) {
        echo '3';
        include_once $_SERVER["DOCUMENT_ROOT"] . "/erreurs/403.php";
    exit();
}

if (!(!$consultant)) {

    $login = $consultant->get_login();

} elseif (!(!$bm)) {

    $login = $bm->get_login();

} elseif (!(!$rh)) {

    $login = $rh->get_login();

}

if (isset($_POST["action"])) {

    if ($_POST["action"] == "setpassword" && (isset($_POST["pwd"]) || isset($_POST["pwd_verif"]))) {
        $_POST['pwd'] = hash('sha256', $_POST['pwd']);
        $_POST['pwd_verif'] = hash('sha256', $_POST['pwd_verif']);    

        var_dump($_POST['pwd'];
        var_dump($_POST['pwd_verif'];
        exit();
        if (!(!$consultant)) {

            if ($consultant->set_password($_POST["pwd"], $_POST["pwd_verif"])) {
                header("location: http://" . $_SERVER["HTTP_HOST"]);
                exit();
            }

        } elseif (!(!$bm)) {

            if ($bm->set_password($_POST["pwd"], $_POST["pwd_verif"])) {
                header("location: http://" . $_SERVER["HTTP_HOST"]);
                exit();
            }

        } elseif (!(!$rh)) {

            if ($rh->set_password($_POST["pwd"], $_POST["pwd_verif"])) {
                header("location: http://" . $_SERVER["HTTP_HOST"]);
                exit();
            }

        }
    
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
    <script>
        function send() {
            var pwd_verif = document.querySelector("input[name='pwd_verif']");
            var pwd = document.querySelector("input[name='pwd']");
            if (pwd_verif.value != pwd.value || pwd.value == "" || pwd_verif.value == "") {
                document.querySelectorAll(".pwd").forEach(elem => {
                    elem.classList.add("wrong");
                });
            } else {
                document.querySelector("form").submit();
            }
        }
    </script>
    <title>A2F Advisor</title>
</head>
<body>

    <div class="login-wrapper">

        <img src="/images/logo-a2f-blanc-02.svg" alt="logo a2f" height="60">
        <h4 class="white">Changement de <br> mot de passe</h4><br>

        <form action="http://<?php echo $_SERVER['HTTP_HOST'];?>/identification/?token=<?php echo $_GET["token"]; ?>" method="post">
        
            <input type="hidden" name="action" value="setpassword">

            <i class="material-icons">account_box</i>
            <input type="text" name="login" value="<?php echo $login; ?>" disabled autocomplete="off"> <br>

            <i class="material-icons">done</i>
            <input class="pwd" name="pwd" type="password" placeholder="Nouveau mot de passe" autocomplete="off" required><br>
            
            <i class="material-icons">done_all</i>
            <input class="pwd" name="pwd_verif" type="password" placeholder="Confirmer le mot de passe" autocomplete="off" required><br>

            <div class="submit" onclick="send()">Confirmer</div>
        
        </form>



    </div>

    <script>
        document.querySelectorAll("input").forEach(e => {
            e.onkeypress = function(e) {
                if (e.keyCode == 13) {
                    send();
                }
            }
        });
        document.querySelector("input[name='pwd_verif']").onblur = function() {
            if (document.querySelector("input[name='pwd_verif']").value != document.querySelector("input[name='pwd']").value) {
                document.querySelectorAll(".pwd").forEach(elem => {
                    elem.classList.add("wrong");
                });
            } else {
                document.querySelectorAll(".pwd").forEach(elem => {
                    elem.classList.remove("wrong");
                });
            }
        }
    </script>

</body>
</html>
