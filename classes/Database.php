<?php 

class Database {

    //connection a la BDD

    static public function connect() {


        try {

            return new PDO('mysql:host=romainbdt.fr;dbname=projetA2F', 'userA2F', 'A2FBDD@2018!');

        } catch (Exception $e) {

            echo $e;
            return false;

        }
    
    }

    public function login($login, $password) {

        sleep(1);

        $db = Database::connect();

        if ($db == false) return false;

        $statement = $db->prepare("SELECT * FROM consultants where login = :login AND mot_de_passe = :password");
        $statement->execute(array(
            ":login" => $login,
            ":password" => $password
        ));

        $answer = $statement->fetch();


        if ($answer != false) {
    
            $_SESSION['user'] = array(
                "connected" => true,
                "login" => $answer["login"],
                "id" => $answer["id_consultant"],
                "pole" => $answer["pole"],
                "type" => 0,
                "token" => array(0)
            );

            return true;
    
        }

        $statement = $db->prepare("SELECT * FROM BM WHERE login = :login AND mot_de_passe = :password");
        $statement->execute(array(
            ":login" => $login,
            ":password" => $password
        ));

        $answer = $statement->fetch();

    
        if ($answer != false) {
    
            $_SESSION['user'] = array(
                "connected" => true,
                "login" => $answer["login"],
                "id" => $answer["id_bm"],
                "pole" => 0,
                "type" => 1,
                "token" => array(0)
            );

            return true;
    
        }
    
        $statement = $db->prepare("SELECT * FROM RH WHERE login = :login AND mot_de_passe = :password");
        $statement->execute(array(
            ":login" => $login,
            ":password" => $password
        ));

        $answer = $statement->fetch();
    
        if ($answer != false) {

            $_SESSION['user'] = array(
                "connected" => true,
                "login" => $answer["login"],
                "id" => $answer["id_rh"],
                "pole" => 0,
                "type" => 2,
                "token" => array(0)
            );

            return true;

        }

        return false;

    }

}

