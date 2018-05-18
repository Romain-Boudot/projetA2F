<?php

include_once "Database.php";

class Competence {

    public function get_array($id = null) {

        $db = Database::connect();
        
        if ($id == null) {

            $comp = array();

            $statement = $db->prepare("SELECT * FROM competences");
            $statement->execute();
            $answer = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($answer as $c) {
                if ($c["id_competence_mere"] == null) {
                    $comp[] = $c["nom"] => array(
                        "id_competence" => $c["id_competence"],
                        "id_competence_mere" => $c["id_competence_mere"]
                    )
                }
            }

            return $comp;
        
        }

    }

}

var_dump(Competence::get_array());
