<?php

include_once "Database.php";

function tab_search($id, $tab) {

    $comp = array();

    foreach($tab as $c) {

        if ($c["id_competence_mere"] == $id) {

            $comp[$c["nom"]] = tab_search($c["id"], $tab);

        }

    }

    return $comp;

}

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

                    $comp[$c["nom"]] = tab_search($c["id"], $tab);

                }

            }

            foreach($comp)

            return $comp;
        
        }

    }

}

var_dump(Competence::get_array());
