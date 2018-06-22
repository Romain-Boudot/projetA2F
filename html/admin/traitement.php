<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Security.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Competence.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Client.php";    
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Consultant.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Candidat.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/BM.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/RH.php";


session_start();

Security::check_token($_POST['token'], '42');
Security::check_login(array(1, 2));

if (!isset($_POST['action']) ){
    exit();
}

// ===================== PARTIE COMPETENCE ===================

if ($_POST['action'] == "delete") {


    if(isset($_POST["id"])){

        $id_comp = $_POST["id"];
        
    } else {
        
        exit();
    
    }

    if (Competence::is_last($id_comp)) {
        $pdo = Database::connect();

        $statement = $pdo->prepare("DELETE FROM competences WHERE id_competence = :idcomp");
        $statement->execute(array(":idcomp" => $id_comp));
        
        $pdo = null;
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
        exit();

    } else { 

        exit(); 
    
    }

} elseif ($_POST['action'] == "add") {
    
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $pdo->prepare("INSERT INTO competences (nom, id_competence_mere) VALUES (:nom, :idcompmere)");
    $statement->execute(array(":nom" => $_POST['nom'], ":idcompmere" => $_POST["id"]));

    $pdo = null;
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();

}

// ================== PARTIE BM ====================

elseif ($_POST['action'] == "delete_bm") {

    BM::delete($_POST['id_bm']);
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();

} elseif ($_POST['action'] == "add_bm") {
    
    $data = BM::register($_POST['nom'], $_POST['prenom']);
    
?>     
    <form name='reset_password' action='/admin/index.php' method='POST'>  
        <input type='hidden' name='url' value=" <?php echo $data["url"]; ?> " >
    </form>
    <script>
        document.reset_password.submit();
    </script>

<?php

exit();

}

// ====================== PARTIE RH ========================

elseif ($_POST['action'] == "delete_rh") {

    RH::delete($_POST['id_rh']);
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();

} elseif ($_POST['action'] == "add_rh") {
    
    $data = RH::register($_POST['nom'], $_POST['prenom']);

?>     
    <form name='reset_password' action='/admin/index.php' method='POST'>  
        <input type='hidden' name='url' value=" <?php echo $data["url"]; ?> " >
    </form>
    <script>
        document.reset_password.submit();
    </script>

<?php

exit();

}

// =================== PARTIE CLIENT =========================

elseif ($_POST['action'] == "delete_client") {


    Client::delete($_POST['id_client']);
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();

} elseif ($_POST['action'] == "add_client") {


    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $pdo->prepare("INSERT INTO clients (entreprise) VALUES (:entreprise)");
    $statement->execute(array(":entreprise" => $_POST['entreprise']));

    $pdo = null;
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();
    
}

// ==================== PARTIE CONSULTANT =====================

elseif ($_POST['action'] == "delete_consultant") {


    $c = new Consultant($_POST['id_consultant']);

    $c->delete();
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();

} elseif ($_POST['action'] == "add_consultant") {


    $data = Consultant::register($_POST['nom'], $_POST['prenom'], $_POST['pole']);
    ?>
        <form name='add_cons' action='/admin/index.php' method='POST'>  
            <input type='hidden' name='url' value=" <?php echo $data['url']; ?> " >
        </form>
        <script>
            document.add_cons.submit();
        </script>
    <?php

    exit();
    
}

// ========================= PARTIE CANDIDAT =================== 

elseif ($_POST['action'] == "delete_candidat") {


    $cand = new Candidat($_POST['id_candidat']);
    $cand->delete();

    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();
    
}  elseif ($_POST['action'] == "add_candidat") {

    $infos = array(
        "nom" => $_POST['nom'],
        "prenom" => $_POST['prenom']
    );
    var_dump($infos);
    Candidat::add($infos);

    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();

}

// reset passwords

elseif ($_POST['action'] == "reset_password") {


    if (!isset($_POST['id'])) {
        exit();
    }

    if(!isset($_POST["who"])) {
        exit();
    }

    if ($_POST['who'] == "consultant") {
        $token = Consultant::reset_password($_POST['id']);
    } elseif ($_POST["who"] == "RH") {
        $token = RH::reset_password($_POST['id']);
    } elseif ($_POST["who"] == "BM") {
        $token = BM::reset_password($_POST['id']);
    }

    $token = "http://" . $_SERVER["HTTP_HOST"] . "/identification/?token=" . $token;
    
    ?>     
        <form name='reset_password' action='/admin/index.php' method='POST'>  
            <input type='hidden' name='url' value=" <?php echo $token; ?> " >
        </form>
        <script>
            document.reset_password.submit();
        </script>
    
    <?php

    exit();

}