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
            $this->id = $infos['id_consultant'];
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

    public function send_modif(){
        
        var_dump($this);

        $db = Database::connect();
        $statement = $db->prepare("UPDATE consultants SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, linkedin = :linkedin WHERE id_consultant = :id");
        $statement->execute(array(
            ":nom" => $this->nom,
            ":prenom" => $this->prenom,
            ":email" => $this->email,
            ":telephone" => $this->telephone,
            ":linkedin" => $this->linkedin,
            ":id" => $this->id
        ));

    }

    public function add_intervention($infos){
        $pdo = Database::connect();

        $statement = $pdo->prepare("INSERT INTO interventions (id_consultant, id_client, date, details) VALUES (:id_consultant, :id_client, :date, :details)");
        $statement->execute(array(':id_consultant' => $this->id, ':id_client' => $infos['id_client'], ':date' => $infos['date'], ':details' => $infos['details']));

        $pdo =null;
    }

    public function delete_intervention($id){
        $pdo = Database::connect();

        $statement = $pdo->prepare("DELETE FROM interventions WHERE id_intervention = :id_intervention AND id_consultant = :id_consultant");
        $statement->execute(array(':id_intervention' => $id, ':id_consultant' => $this->id));

    }
    
    public function add_qualification($infos){
        $pdo = Database::connect();

        $statement = $pdo->prepare("INSERT INTO qualifications ( nom_qualification, id_consultant, date_obtention, details) VALUES (:nom_qualification, :id_consultant, :date_obtention, :details)");
        $statement->execute(array(':nom_qualification' => $infos['nom_qualification'], ':id_consultant' => $this->id, ':date_obtention' => $infos['date_obtention'], ':details' => $infos['details']));

    }

    public function delete_qualification($id){
        $pdo = Database::connect();

        $statement = $pdo->prepare("DELETE FROM qualifications WHERE id_qualification = :id_qualification AND id_consultant = :id_consultant");
        $statement->execute(array(':id_qualification' => $id, ':id_consultant' => $this->id));

    }

    public function add_competence($infos){ // deprecated

        $pdo = Database::connect();

        $statement = $pdo->prepare("INSERT INTO competences_consultants(id_competence, id_consultant, niveau) VALUES (:id_competence, :id_consultant, :niveau)");
        $statement->execute(array(':id_competence' => $infos['id_competence'], ':id_consultant' => $this->id, ':niveau' => $infos['niveau']));

    }

    public function edit_competence($infos){

        $pdo = Database::connect();

        $statement = $pdo->prepare("DELETE FROM competences_consultants WHERE id_competence = :id_competence AND id_consultant = :id_consultant");
        $statement->execute(array(
            ":id_consultant" => $this->id,
            ":id_competence" => $infos['id_competence']
        ));
        if ($infos["niveau"] == 0) return;
        $statement = $pdo->prepare("INSERT INTO competences_consultants (niveau, id_consultant, id_competence) VALUES (?, ?, ?)");
        $statement->execute(array(
            $infos['niveau'],
            $this->id,
            $infos['id_competence']
        ));

        $pdo = null; 
    
    }

    public function delete_competence($id){ // deprecated
        
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

    public function set_nom($nom) {
        $this->nom = $nom;
    }

    public function get_prenom(){
        return $this->prenom;
    }

    public function set_prenom($prenom){
        $this->prenom = $prenom;
    }

    public function get_email(){
        return $this->email;
    }

    public function set_email($email){
        $this->email = $email;
    }

    public function get_telephone(){
        return $this->telephone;
    }

    public function set_telephone($tel){
        $this->telephone = $tel;
    }

    public function get_linkedin(){
        return $this->linkedin;
    }

    public function set_linkedin($linkedin){
        $this->linkedin = $linkedin;
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

    public function get_interventions(){ 
        $pdo = Database::connect(); 

        $statement = $pdo->prepare("SELECT i.id_intervention, i.date, i.details, c.entreprise FROM interventions i JOIN clients c ON c.id_client = i.id_client WHERE id_consultant = :id"); 
        $statement->execute(array(":id" => $this->id)); 


        $pdo = null; 

        return $statement->fetchAll(PDO::FETCH_ASSOC);    

    } 

    public function get_qualifications(){ 

        $pdo = Database::connect(); 

        $statement = $pdo->prepare("SELECT * FROM qualifications WHERE id_consultant = :id"); 
        $statement->execute(array(":id" => $this->id)); 

        $pdo = null; 

        return $statement->fetchAll(PDO::FETCH_ASSOC);    


    } 


    public function get_graphiques(){ 

        $pdo = Database::connect(); 

        $statement = $pdo->prepare("SELECT g.id_graphique, g.id_competence, c.nom, cc.niveau from graphiques g JOIN competences c ON c.id_competence = g.id_competence JOIN competences_consultants cc ON cc.id_competence = g.id_competence WHERE g.id_consultant = :id"); 
        $statement->execute(array(":id" => $this->id)); 

        $pdo = null; 

        return $statement->fetchAll(PDO::FETCH_ASSOC); 

    } 

    public function get_login() {
        return $this->login;
    }

    public function get_salaire() {
        return $this->salaire;
    }

    public function get_id() {
        return $this->id;
    }

}


