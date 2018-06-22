<?php

function tab_search($id, $tab, $depth) {

    $comp = null;

    foreach($tab as $c) {

        if ($c["id_competence_mere"] == $id) {            

            $comp[$c["nom"]] = array(
                "depth" => $depth,
                "id_competence" => $c["id_competence"],
                "id_competence_mere" => $c["id_competence_mere"],
                "niveau" => (isset($c["niveau"]) ? $c["niveau"] : null),
                "enfant" => tab_search($c["id_competence"], $tab, $depth + 1)
            );
 
        }
 
    }
 
    return $comp;
 
}
 
class Competence {

    static public function is_last($id) {

        $db = Database::connect();
        $statement = $db->prepare("SELECT nom FROM competences WHERE id_competence_mere = :id");
        $statement->execute(array(":id" => $id));
        $answer = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!$answer) return true;
        if ($answer > 0) return false;
        else return true;

    }

    static public function get_children($id) {

        $db = Database::connect();
        $statement = $db->prepare("SELECT id_competence FROM competences WHERE id_competence_mere = :id");
        $statement->execute(array(":id" => $id));
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    static public function get_name($id) {

        $db = Database::connect();
        $statement = $db->prepare("SELECT nom FROM competences WHERE id_competence = :id");
        $statement->execute(array(":id" => $id));
        return $statement->fetch()["nom"];

    }
 
    static public function get_array($id = null) {
 
        $db = Database::connect();

        if ($id == null) {
 
            $comp = array();
 
            $statement = $db->prepare("SELECT * FROM competences");
            $statement->execute();
            $answer = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($answer as $c) {
 
                if ($c["id_competence_mere"] == null) {
 
                    $comp[$c["nom"]] = array(
                        "depth" => 0,
                        "id_competence" => $c["id_competence"],
                        "enfant" => tab_search($c["id_competence"], $answer, 1)
                    );
 
                }
 
            }
 
            return $comp;
        
        } else {

            $comp = array();

            $statement = $db->prepare("SELECT c.*,(
                SELECT niveau FROM competences_consultants cc WHERE c.id_competence = cc.id_competence AND cc.id_consultant = :id
            ) as niveau FROM competences c");
            $statement->execute(array(
                ":id" => $id
            ));
            $answer = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach($answer as $c) {

                if ($c["id_competence_mere"] == null) {

                    $comp[$c["nom"]] = array(
                        "depth" => 0,
                        "id_competence" => $c["id_competence"],
                        "enfant" => tab_search($c["id_competence"], $answer, 1),
                    );

                }

            }

            return $comp;

        }
 
    }

}