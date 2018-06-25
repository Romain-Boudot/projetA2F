<?php

class BM {

    private $login;

    public function __construct($id){
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM BM c WHERE c.id_bm = :id");
        $statement->bindParam('id', $id);
        $statement->execute();

        $infos = $statement->fetch();

        if($statement) {

            $this->login = $infos['login'];
        
        } elseif (!$statement) {
    
            //            header('location: ../search/');
            //HEADER A CHANGER
        }

        $pdo = null;

    }

    static public function get_array() {
    
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * from BM ORDER BY nom");
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
        
        $statement = $pdo->prepare("INSERT INTO BM (nom, prenom, login, token) VALUES (:nom, :prenom, :login, :token)");
        $statement->execute(array(
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':login' => $login,
            ':token' => $token
        ));

        $id = $pdo->lastInsertID();

        $pdo = null;

        $url = "http://" . $_SERVER["HTTP_HOST"] . "/identification/?token=" . $token;

        return array(
            "url" => $url,
            "id" => $id);

    }

   static public function delete($id) {
       $pdo = Database::connect();

       $statement = $pdo->prepare("DELETE FROM BM WHERE id_bm = :id");
       $statement->execute(array(
           ':id' => $id
       ));

       $pdo = null;
   } 

    static public function reset_password($id_bm){
        $pdo = Database::connect();

        $token = bin2hex(random_bytes(32));

        $statement = $pdo->prepare("UPDATE BM SET mot_de_passe = NULL, token = :token WHERE id_bm = :id");
        $statement->execute(array(
            ":id" => $id_bm,
            ":token" => $token
        ));

        return $token;
    }

    static public function get_bm_via_token($token){

        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM BM WHERE token = :token");
        $statement->execute(array(
            ":token" => $token
        ));

        $answer = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($answer == false || sizeof($answer) > 1) return false;

        $pdo = null;

        return new BM($answer[0]["id_bm"]);

    }

    public function set_password($pwd, $pwd_verif) {

        if ($pwd != $pwd_verif) return false;

        $pdo = Database::connect();

        $statement = $pdo->prepare("UPDATE BM SET mot_de_passe = :pwd, token = null WHERE login = :login");
        $statement->execute(array(
            ":pwd" => $pwd,
            ":login" => $this->login,
        ));

        //hash("sha256", $pwd)

        $pdo = null;

        return true;
            
    }

    public function get_login() {
        return $this->login;
    }

}
