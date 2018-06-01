<?php

class Pole {

    static public function get_name($id = null) {
        if ($id != null) {
            $db = Database::connect();
            $statement = $db->prepare("SELECT nom_pole FROM poles WHERE id_pole = :id");
            $statement->execute(array(":id" => $id));
            return $statement->fetch()["nom_pole"];
        } else return false;
    }

}