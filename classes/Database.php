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

    public function login($login, $password) {

        $db = Database::connect();

        if ($db == false) return false;

        $statement = $db->prepare("SELECT * FROM consultants where login = :login AND mot_de_passe = :password");
        $statement->execute(array(
            ":login" => $login,
            ":password" => $password
        ));

        $answer = $statement->fetch();


        if ($answer == true) {
    
            return true;
    
        } else {
    
            $statement = $db->prepare("SELECT * FROM BM WHERE login = :login AND mot_de_passe = :password");
            $statement->execute(array(
                ":login" => $login,
                ":password" => $password
            ));

            $answer = $statement->fetch();
        }
    
        if ($answer == true) {
    
            return true;
    
        } else {
    
            $statement = $db->prepare("SELECT * FROM RH WHERE login = :login AND mot_de_passe = :password");
            $statement->execute(array(
                ":login" => $login,
                ":password" => $password
            ));

            $answer = $statement->fetch();
        }
    
        if ($answer == true) {

            return true;

        } else {

            return false;

        }


    }

}

