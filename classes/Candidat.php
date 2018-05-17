<?php

class Candidat {
    private $id;
    private $nom;
    private $prenom;
    private $telephone;
    private $email;
    private $linkedin;


    public function __construct($id){
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM candidats WHERE id = :id");
        $statement->bindParam('id', $id);
        $statement->execute();

        $infos = $statement->fetch();

        if($statement){
            $this->id = $infos['id'];
            $this->nom = $infos['nom'];
            $this->prenom = $infos['prenom'];
            $this->telephone = $infos['telephone'];
            $this->email = $infos['email'];
            $this->linkedin = $infos['linkedin'];
        } elseif(!$statement){
            
//            header('location: ../search/');
//HEADER A CHANGER
        }
        $pdo = null;

    }


    public static function add($infos) {
        $pdo = Database::connect();

        $add_candidate = $pdo->prepare("INSERT INTO candidats (nom, prenom, telephone, email, linkedin) VALUES (:nom, :prenom, :telephone, :email, :linkedin)");
        $add_candidate->execute(array(':nom' => $infos['nom'], ':prenom' => $infos['prenom'], ':telephone' => $infos['telephone'], ':email' => $infos['email'], ':linkedin' => $infos['linkedin']);		

        $pdo =  null;
    }

    public function delete(){
        $pdo = Database::connect();

        $delete_candidate = $pdo->prepare("DELETE FROM candidats WHERE id_candidat = :id");
        $delete_candidate->bindParam('id', this->$id);
        $delete_candidate->execute();

        $pdo = null:
    }

    public function edit($infos){
        $pdo = Database::connect();
        $first = true;
        $statement = "UPDATE candidats SET ";
        if (isset($infos[':nom'])) {
            if (!$first) {
                $statement .= ",";
                $first = false;
            }
            $statement .= " nom = :nom";
        }

        if (isset($infos[':prenom'])) {
            if (!$first) {
                $statement .= ",";
                $first = false;
            }
            $statement .= " prenom = :prenom";
        }

        if (isset($infos[':telephone'])) {
            if (!$first) {
                $statement .= ",";
                $first = false;
            }
            $statement .= " telephone = :telephone";
        }

        if (isset($infos[':email'])) {
            if (!$first) {
                $statement .= ",";
                $first = false;
            }
            $statement .= " email = :email";
        }
        if (isset($infos[':linkedin'])) {
            if (!$first) {
                $statement .= ",";
                $first = false;
            }
            $statement .= " linkedin = :linkedin";
        }
        $statement .= " WHERE id_candidat = ".this->$id;
        $edit_candidate = $pdo->prepare($statement);
        $edit_candidate->execute($infos);		

        $pdo = null;

    }

    public function transfer(){

        //Consultant::add();
        delete();
    }

    public function add_interview($infos) {
        $pdo = Database::connect();
        if(isset($infos['details'])) {
            $temp = ", details";
            $temp1 = ", :details";
        }
        else {
            $temp = "";
            $temp1 = "";
        }
        $statement = $pdo->prepare("INSERT INTO entretiens (id_candidat, id_rh, date_entretien".$temp.") VALUES (:id_candidat, :id_rh, :date_entretien".$temp1.")"); 
        $statement->execute(array(':id_candidat' => $infos['id_candidat'], ':id_rh' => $infos['id_rh'], ':date_entretien' => $infos['date_entretien']);

        $pdo = null;

    }

    public function edit_interview($infos){
        $pdo = Database::connect();
        $first = true;

        $statement = "UPDATE entretiens SET ";
        if (isset($infos[':id_candidat'])) {
            if (!$first) {
                $statement .= ",";
                $first = false;
            }
            $statement .= " id_candidat = :id_candidat";
        }

        if (isset($infos[':id_rh'])) {
            if (!$first) {
                $statement .= ",";
                $first = false;
            }
            $statement .= " id_rh = :id_rh";
        }

        if (isset($infos[':date_entretien'])) {
            if (!$first) {
                $statement .= ",";
                $first = false;
            }
            $statement .= " date_entretien = :date_entretien";
        }

        if (isset($infos[':details'])) {
            if (!$first) {
                $statement .= ",";
                $first = false;
            }
            $statement .= " details = :details";
        }
        $statement .= " WHERE id_candidat = ".this->$id;
        $edit_candidate = $pdo->prepare($statement);
        $edit_candidate->execute($infos);		

        $pdo = null;


    }

    public function get_nom(){
        return $this->nom;
    }

    public function get_prenom(){
        return $this->prenom;
    }


    public function get_email(){
        return $this->email;
    }


    public function get_telephone(){
        return $this->telephone;
    }


    public function get_linkedin(){
        return $this->linkedin;
    }


}
