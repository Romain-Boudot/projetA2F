<?php

function tab_search($id, $tab) {

    $comp = null;

    foreach($tab as $c) {

        if ($c["id_competence_mere"] == $id) {            

            $comp[$c["nom"]] = array(
                "id_competence" => $c["id_competence"],
                "id_competence_mere" => $c["id_competence_mere"],
                "niveau" => (isset($c["niveau"]) ? $c["niveau"] : null),
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
                        "id_competence" => $c["id_competence"],
                        "enfant" => tab_search($c["id_competence"], $answer),
                    );

                }

            }

            return $comp;

        }
 
    }

}