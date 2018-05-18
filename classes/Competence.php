<?php

class Competence {

    public get_array() {

        $db = Database::connect();

        $statement = $db->prepare("SELECT * FROM competences");
        $statement->execute();
        $answer = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $answer;

    }

}

var_dump(Competence::get_array());
