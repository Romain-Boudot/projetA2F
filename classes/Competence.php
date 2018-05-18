<?php

include_once "Database.php";

function tab_search($id, $tab) {

    $comp = array();

    foreach($tab as $c) {

        if ($c["id_competence_mere"] == $id) {

            $comp[$c["nom"]] = array(
                "id_competence" => $c["id_competence"],
                "id_competence_mere" => $c["id_competence_mere"],
                "enfant" => tab_search($c["id_competence"], $tab)
            );

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

                    $comp[$c["nom"]] = array(
                        "id_competence" => $c["id_competence"],
                        "enfant" => tab_search($c["id_competence"], $answer)
                    );

                }

            }

            return $comp;
        
        }

    }

}

var_dump(Competence::get_array());
