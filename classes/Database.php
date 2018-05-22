<?php 

class Database {

    //connection a la BDD

    public function connect() {

        try {

            return new PDO('mysql:host=localhost;dbname=projetA2F', 'userA2F', 'A2FBDD@2018!');

        } catch (Exception $e) {

            return false;

        }
    
    }

    public function login($type, $login, $password) {

        if ($type = 0) {

            $table = "consultant";

        } elseif ($type = 1) {

            $table = "BM";

        } elseif ($type = 2) {

            $table = "RH";

        }

        $db = Database::connect();

        if ($db == false) return false;

        $statement = $db->prepare("SELECT * FROM " . $table . "where login = :login");
        $statement->execute(array(
            ":login" => $login
        ));

        $answer = $statement->fetch();


        // verification du identifiant + mdp

        if ($answer == false) {
    
            return false;
    
        } else {
    
            if ($answer['mot_de_passe'] == $password) {
    
                return true;
    
            } else {
    
                return false;
    
            }
    
        }
    
    }

}

