<?php

class Competence {

    public function get_array($id = null) {

        $db = Database::connect();
        
        if ($id == null) {

            $statement = $db->prepare("SELECT * FROM competences");
            $statement->execute();
            $answer = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            return $answer;
        
        }

    }

}

var_dump(Competence::get_array());
