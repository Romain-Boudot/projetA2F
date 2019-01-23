<?php

class Security {

    static public function check_file($fileName) {

        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM fichiers_consultants WHERE id_consultant = :id AND nom_serveur = :nom");
        $statement->execute(array(":id" => $_SESSION['user']['id'], ":nom" => $fileName));
        if ($statement->fetch() != false) {
            return true;
        } else {
            return false;
        }

    }

    static public function login_validity($login) {

        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM consultants WHERE login = :login");
        $statement->execute(array(":login" => $login));
        $cons = $statement->fetch();
        $statement = $pdo->prepare("SELECT * FROM BM WHERE login = :login");
        $statement->execute(array(":login" => $login));
        $bm = $statement->fetch();
        $statement = $pdo->prepare("SELECT * FROM RH WHERE login = :login");
        $statement->execute(array(":login" => $login));
        $rh = $statement->fetch();

        if (!$bm && !$rh && !$cons) {
            return true;
        } else {
            return false;
        }

    }

    static public function gen_token($id) {

        $token = bin2hex(random_bytes(32));
        
        $cpt = $_SESSION['user']['token'][0];

        if ($cpt = 3) {
            
            $cpt1 = 1;
            while(isset($_SESSION['user']['token'][$cpt1 + 1]) && $cpt1 < 3) {
                $_SESSION['user']['token'][$cpt1] = $_SESSION['user']['token'][$cpt1 + 1];
                $cpt1++;
            }

            $_SESSION['user']['token'][$cpt1 + 1] = array(
                "token" => $token,
                "id" => $id
            );

        } else {
    
            $_SESSION['user']['token'][$cpt + 1] = array(
                "token" => $token,
                "id" => $id
            );
            
            $_SESSION['user']['token'][0] += 1;

        }

        return $token;

    }

    static public function check_token($token, $id) {

        for($cpt = 1; $cpt < sizeof($_SESSION['user']['token']); $cpt++) {

            if (!isset($_SESSION['user']['token'][$cpt]['token'])) continue;

            if ($_SESSION['user']['token'][$cpt]['token'] == $token) {

                if ($_SESSION['user']['token'][$cpt]['id'] == $id) {

                    $cpt1 = $cpt;

                    while(isset($_SESSION['user']['token'][$cpt1 + 1])) {

                        $_SESSION['user']['token'][$cpt1 + 1] = $_SESSION['user']['token'][$cpt1];
                        $cpt1++;

                    }

                    $_SESSION['user']['token'][0] -= 1;

                    return true;

                } else {

                    $cpt1 = $cpt;

                    while(isset($_SESSION['user']['token'][$cpt1 + 1])) {

                        $_SESSION['user']['token'][$cpt1 + 1] = $_SESSION['user']['token'][$cpt1];
                        $cpt1++;

                    }

                    $_SESSION['user']['token'][0] -= 1;

                }
                
            }

        }

        return false;

    }

    static public function check_login($lvl) {

        if (isset($_SESSION['user']['connected'])) {

            if (!$_SESSION['user']['connected']) {
            
                header("Location: http://" . $_SERVER['HTTP_HOST'] . "/identification/");
                exit();
                
            }

        } else {

            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/identification/");
            exit();

        }

        if (!in_array($_SESSION['user']['type'], $lvl)) {

            include_once $_SERVER['DOCUMENT_ROOT'] . "/erreurs/403.php";
            exit();

        }

    }

}
