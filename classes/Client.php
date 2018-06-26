<?php

class Client {

    static public function get_name($id = null) {
        if ($id != null) {
            $db = Database::connect();
            $statement = $db->prepare("SELECT entreprise FROM clients WHERE id_client = :id");
            $statement->execute(array(":id" => $id));
            return $statement->fetch()["entreprise"];
        } else return false;
    }

    static public function get_array($like = "") {

        $db = Database::connect();

        $statement = $db->prepare("SELECT * FROM clients WHERE entreprise LIKE :like ORDER BY entreprise");
        $statement->execute(array(":like" => "%" . $like . "%"));
        $answer = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $answer;

    }

    static public function delete($id) {
        $pdo = Database::connect();
 
        $statement = $pdo->prepare("DELETE FROM clients WHERE id_client = :id");
        $statement->execute(array(
            ':id' => $id
        ));
 
        $pdo = null;
    } 

}

class Entreprise {

    static public function get_array($like = "") {

        $db = Database::connect();

        $statement = $db->prepare("SELECT * FROM entreprises WHERE nom LIKE :like ORDER BY nom");
        // * = id_entreprise, nom
        $statement->execute(array(":like" => "%" . $like . "%"));
        $answer = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $answer;

    }

}