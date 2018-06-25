<?php

class RH {

    private $login;

    public function __construct($id){
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM RH c WHERE c.id_rh = :id");
        $statement->bindParam('id', $id);
        $statement->execute();

        $infos = $statement->fetch();

        if($statement) {

            $this->login = $infos['login'];
        
        } elseif(!$statement) {
    
            //            header('location: ../search/');
            //HEADER A CHANGER
        }

        $pdo = null;

    }

    static public function get_array() {
    
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * from RH ORDER BY nom");
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $array;


    }


    static public function register($nom, $prenom) {

        $login = substr($prenom, 0, 1) . $nom;

        $cpt = 0;
        while (!Security::login_validity($login)) {
            $cpt++;
            $login = substr($prenom, 0, 1) . $nom . $cpt;
        }

        $token = hash("sha256", $login . bin2hex(random_bytes(50)));

        $pdo = Database::connect();
        
        $statement = $pdo->prepare("INSERT INTO RH (nom, prenom, login, token) VALUES (:nom, :prenom, :login, :token)");
        $statement->execute(array(
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':login' => $login,
            ':token' => $token
        ));

        $id = $pdo->lastInsertID();

        $pdo = null;

        $url = "http://" . $_SERVER["HTTP_HOST"] . "/register/?token=" . $token;

        return array(
            "url" => $url,
            "id" => $id);

    }

    static public function delete($id) {
        $pdo = Database::connect();
 
        $statement = $pdo->prepare("DELETE FROM RH WHERE id_rh = :id");
        $statement->execute(array(
            ':id' => $id
        ));
 
        $pdo = null;
    } 

    static public function reset_password($id_rh){
        $pdo = Database::connect();

        $token = bin2hex(random_bytes(32));

        $statement = $pdo->prepare("UPDATE RH SET mot_de_passe = NULL, token = :token WHERE id_rh = :id");
        $statement->execute(array(
            ":id" => $id_rh,
            ":token" => $token
        ));

        return $token;
    }

    public function set_password($pwd, $pwd_verif) {

        if ($pwd != $pwd_verif) return false;

        $pdo = Database::connect();

        $statement = $pdo->prepare("UPDATE RH SET mot_de_passe = :pwd, token = null WHERE login = :login");
        $statement->execute(array(
            ":pwd" => $pwd,
            ":login" => $this->login,
        ));

        //hash("sha256", $pwd)

        $pdo = null;

        return true;
            
    }

    static public function get_rh_via_token($token){

        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM RH WHERE token = :token");
        $statement->execute(array(
            ":token" => $token
        ));

        $answer = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        if ($answer == false || sizeof($answer) > 1) return false;

        $pdo = null;

        return new RH($answer[0]["id_rh"]);

    }

    public function get_login() {
        return $this->login;
    }

}
