<?php

Class Consultant {
    private $id;
    private $nom;
    private $prenom;
    private $date_de_recrutement;
    private $salaire;
    private $login;
    private $mot_de_passe;
    private $email;
    private $telephone;
    private $linkedin;
    private $nom_pole;
    private $pole;
    private $honoraires;

    public function __construct($id){
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT *,( SELECT nom_pole FROM poles WHERE id_pole = c.pole) AS nom_pole FROM consultants c WHERE c.id_consultant = :id");
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
            $this->nom_pole = $infos['nom_pole'];
            $this->pole = $infos['pole'];
            $this->honoraires = $infos['honoraires'];
            $this->login = $infos['login'];
            $this->salaire = $infos['salaire'];
        } elseif(!$statement){
    
            //            header('location: ../search/');
            //HEADER A CHANGER
        }
        $pdo = null;


    }

    public static function add($infos){
        $pdo = Database::connect();
        
        $statement = $pdo->prepare("INSERT INTO consultants (nom, prenom, telephone, email, linkedin, pole, honoraires) VALUES (:nom, :prenom, :email, :linkedin, :pole, :honoraires)");
        $statement->execute(array(':nom' => $infos['nom'], ':prenom' => $infos['prenom'], ':email' => $infos['email'], ':linkedin' => $infos['linkedin'], ':pole' => $infos['pole'], ':honoraires' => $infos['honoraires']));

        $pdo = null;
    }


    public function archive(){
        $pdo = Database::connect();

        $statement = $pdo->prepare("UPDATE consultants SET archive = TRUE");
        $statement->execute();

        $pdo = null;
    }

    public function delete(){
        $pdo = Database::connect();

        $statement = $pdo->prepare("DELETE FROM consultants WHERE id_consultant = :id");
        $statement->bindParam('id', $this->id);
        $statement->execute();

        $pdo = null;
    }

    public function edit($infos){
        $pdo = Database::connect();
        $first = true;
        $statement = "UPDATE consultants SET ";
        if (isset($infos[':nom'])) {
            if (!$first) {
                $statement .= ",";
            }
            $statement .= " nom = :nom";

            $first = false;
        }

        if (isset($infos[':prenom'])) {
            if (!$first) {
                $statement .= ",";
            }
            $statement .= " prenom = :prenom";
            $first = false;
        }

        if (isset($infos[':telephone'])) {
            if (!$first) {
                $statement .= ",";
            }
            $statement .= " telephone = :telephone";
            $first = false;
        }

        if (isset($infos[':email'])) {
            if (!$first) {
                $statement .= ",";
            }
            $statement .= " email = :email";
            $first = false;
        }
        if (isset($infos[':linkedin'])) {
            if (!$first) {
                $statement .= ",";
            }
            $statement .= " linkedin = :linkedin";
            $first = false;

        }
    
        if (isset($infos[':pole'])) {
            if (!$first) {
                $statement .= ",";
            }
            $statement .= " pole = :pole";
            $first = false;

        }

        if (isset($infos[':honoraires'])) {
            if (!$first) {
                $statement .= ",";
            }
            $statement .= " honoraires = :honoraires";
            $first = false;

        }


    }

    public function add_intervention($infos){
        $pdo = Database::connect();

        $statement = $pdo->prepare("INSERT INTO interventions (id_consultant, id_client, date, details) VALUES (:id_consultant, :id_client, :date, :details)");
        $statement->execute(array(':id_consultant' => $this->id, ':id_client' => $infos['id_client'], ':date' => $infos['date'], ':details' => $infos['details']));

        $pdo =null;
    }

    public function delete_intervention($id){
        $pdo = Database::connect();

        $statement = $pdo->prepare("DELETE FROM interventions WHERE id_interventions = :id_intervention");
        $statement->bindParam('id_intervention', $id);
        $statement->execute();

    }
    
    public function add_qualification($infos){
        $pdo = Database::connect();

        $statement = $pdo->prepare("INSERT INTO diplomes_obtenus (id_diplome,id_consultant, date_obtention) VALUES (:id_diplome, :id_consultant, :date_obtention)");
        $statement->execute(array(':id_diplome' => $infos['id_diplome'], ':id_consultant' => $this->id, ':date_obtention' => $infos['date_obtention']));

        $pdo =null;


    }

    public function delete_qualification($id){
        $pdo = Database::connect();

        $statement = $pdo->prepare("DELETE FROM diplomes_obtenus WHERE id_diplome = :id_diplome AND id_consultant = :id_consultant");
        $statement->execute(array(':id_diplome' => $id, ':id_consultant' => $this->id));

        $pdo = null;
    }

    public function add_competence($infos){
        $pdo = Database::connect();

        $statement = $pdo->prepare("INSERT INTO competences_consultants(id_competence, id_consultant, niveau) VALUES (:id_competence, :id_consultant, :niveau)");
        $statement->execute(array(':id_competence' => $infos['id_competence'], ':id_consultant' => $this->id, ':niveau' => $infos['niveau']));

        $pdo = null;

    }

    public function edit_competence($infos){
        $pdo = Database::connect();

        $statement = $pdo->prepare("UPDATE competences_consultants SET niveau = :niveau WHERE id_competence = :id_competence AND id_consultant = :id_consultant");
        $statement->execute(array(':niveau' => $infos['niveau'], ':id_consultant' => $this->id, ':id_competence' => $infos['id_competence']));

       $pdo = null; 
    }

    public function delete_competence($id){
        $pdo = Database::connect();

        $statement = $pdo->prepare("DELETE FROM competences_consultants WHERE id_competence = :id_competence AND id_consultant = :id_consultant");
        $statement->execute(array(':id_competence' => $id, ':id_consultant' => $this->id));

        $pdo = null;

    }

    public function add_graphique($number, $infos){
        $pdo = Database::connect();

        $statement = $pdo->prepare("INSERT INTO graphiques (id_graphique, id_consultant, id_competence) VALUES (:number, id_consultant, id_competence)");
        $statement->execute(array(':number'=> $number, ':id_consultant' => $infos['id_consultant'], ':id_competence' => $infos['id_competence']));

$pdo = null;        
        


    }

    public function delete_graphique($number){
        $pdo = Database::connect();

        $statement = $pdo->prepare("DELETE FROM graphiques WHERE id_graphique = :id_graphique AND id_consultant = :id_consultant");
        $statement->execute(array(':id_graphique' => $number, ':id_consultant' => $this->id));

        $pdo = null;
    }

    public function edit_graphique($number, $infos){

        $this->delete_graphique($number);
        $this->add_graphique($number, $infos);

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

    public function get_pole(){
        return $this->pole;
    }

    public function get_nom_pole(){
        return $this->nom_pole;
    }

    public function get_honoraires(){
        return $this->honoraires;
    }

    public function get_login() {
        return $this->login;
    }

    public function get_salaire() {
        return $this->salaire;
    }

}


