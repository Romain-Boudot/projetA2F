<?php

class Client {

    static public function get_array() {

        $db = Database::connect();

        $statement = $db->prepare("SELECT * FROM clients ORDER BY entreprise");
        $statement->execute();
        $answer = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $answer;

    }

}