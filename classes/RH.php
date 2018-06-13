<?php

class RH {

    static public function get_array() {
    
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * from RH ORDER BY nom");
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $array;


    }



}
