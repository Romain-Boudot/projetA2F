<?php

Class Consultant {
    private $id;
    private $nom;
    private $prenom;
    private $date_de_recrutement;
    private $login;
    private $mot_de_passe;
    private $email;
    private $telephone;
    private $linkedin;
    private $nom_pole;
    private $pole;
    private $honoraires;
    private $archive;

    public function __construct($id){
        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT *,( SELECT nom_pole FROM poles WHERE id_pole = c.pole) AS nom_pole FROM consultants c WHERE c.id_consultant = :id");
        $statement->bindParam('id', $id);
        $statement->execute();

        $infos = $statement->fetch();

        if ($statement) {
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
            $this->archive = $infos['archive'];
        } elseif (!$statement) {
    
            // nop
            
        }

        $pdo = null;


    }

    public static function add($infos) { // deprecated

        $pdo = Database::connect();

        $statement = $pdo->prepare("INSERT INTO `consultants` (`nom`, `prenom`, `login`, `mot_de_passe`, `email`, `telephone`, `linkedin`, `pole`) VALUES (:nom, :prenom, :login, :mdp, :email, :telephone, :linkedin, :pole)");
        $statement->execute(array(':nom' => $infos['nom'], ':prenom' => $infos['prenom'], ':email' => $infos['email'], ':linkedin' => $infos['linkedin'], ':pole' => $infos['pole'], ':telephone' => $infos['telephone'], ':login' => $infos['login'], ':mdp' => $infos['mot_de_passe']));
        //   $last = $pdo->lastInsertId(); 

        $pdo = null;

    }


    public function archive($status = null) {

        $status == null ? $status = !$this->get_archive() : null;

        $pdo = Database::connect();

        $statement = $pdo->prepare("UPDATE consultants SET archive = :archive WHERE id_consultant = :id");
        $statement->execute(array(
            ":archive" => $status,
            ":id" => $this->id
        ));

        $pdo = null;

    }

    public function delete() {

        $pdo = Database::connect();

        $files = $this->get_files();

        foreach ($files as $key => $value) {
            unlink($_SERVER["DOCUMENT_ROOT"] . "/../files/" . $value["nom_serveur"]);
        }

        $statement = $pdo->prepare("DELETE FROM consultants WHERE id_consultant = :id");
        $statement->bindParam('id', $this->id);
        $statement->execute();

        $pdo = null;
    }

    public function send_modif() {

        $db = Database::connect();
        $statement = $db->prepare("UPDATE consultants SET login = :login, nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, linkedin = :linkedin WHERE id_consultant = :id");
        $statement->execute(array(
            ":nom" => $this->nom,
            ":prenom" => $this->prenom,
            ":login" => $this->login,
            ":email" => $this->email,
            ":telephone" => $this->telephone,
            ":linkedin" => $this->linkedin,
            ":id" => $this->id
        ));

    }

    public function add_client($nom) {
        $pdo = Database::connect();

        $statement = $pdo->prepare("INSERT INTO clients (entreprise) VALUES (:nom_client)");
        $statement->execute(array(':nom_client' => $nom));

        $id = $pdo->lastInsertId();

        $pdo = null;

        return $id;
    }    

    public function add_entreprise($nom){

        $pdo = Database::connect();

        $statement = $pdo->prepare("INSERT INTO entreprises (nom) VALUES (:nom_entreprise)");
        $statement->execute(array(':nom_entreprise' => $nom));

        $id = $pdo->lastInsertId();

        $pdo = null;

        return $id;

    }

    public function add_intervention($infos){

            $pdo = Database::connect();

            $statement = $pdo->prepare("INSERT INTO interventions (id_consultant, id_entreprise, id_client, date, date_fin, details) VALUES (:id_consultant, :id_entreprise, :id_client, :date, :date_fin, :details)");
            
            $statement->execute(array(
                ':id_consultant' => $this->id,
                ':id_entreprise'=> $infos['id_entreprise'],
                ':id_client' => $infos['id_client'],
                ':date' => $infos['date'],
                ':date_fin' => $infos['date_fin'],
                ':details' => $infos['details']
            ));      

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

    public function add_graphique($number, $id){
        $pdo = Database::connect();

        $statement = $pdo->prepare("INSERT INTO graphiques (id_graphique, id_consultant, id_competence) VALUES (:number, :id_consultant, :id_competence)");
        $statement->execute(array(':number'=> $number, ':id_consultant' => $this->id, ':id_competence' => $id));

        $pdo = null;        

    }

    public function delete_graphique($number){
        $pdo = Database::connect();

        $statement = $pdo->prepare("DELETE FROM graphiques WHERE id_graphique = :id_graphique AND id_consultant = :id_consultant");
        $statement->execute(array(':id_graphique' => $number, ':id_consultant' => $this->id));

        $pdo = null;
    }

    public function edit_graphique($number, $infos){ // deprecated

        $this->delete_graphique($number);
        $this->add_graphique($number, $infos);

    }

    public function get_nom() {
        return $this->nom;
    }

    public function set_nom($nom) {
        $this->nom = $nom;
    }

    public function get_prenom() {
        return $this->prenom;
    }

    public function set_prenom($prenom) {
        $this->prenom = $prenom;
    }

    public function get_email() {
        return $this->email;
    }

    public function set_email($email) {
        $this->email = $email;
    }

    public function get_telephone() {
        return $this->telephone;
    }

    public function set_telephone($tel) {
        $this->telephone = $tel;
    }

    public function get_linkedin() {
        return $this->linkedin;
    }

    public function set_linkedin($linkedin) {
        $this->linkedin = $linkedin;
    }

    public function get_pole() {
        return $this->pole;
    }

    public function get_nom_pole() {
        return $this->nom_pole;
    }

    public function get_honoraires() {
        return $this->honoraires;
    }

    public function get_archive() {
        return ($this->archive == "1" ? true : false);
    }

    public function get_files($type = "") {

        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM fichiers_consultants WHERE id_consultant = :id AND type LIKE :type");
        $statement->execute(array(
            ":id" => $this->id,
            ":type" => "%" . $type . "%"
        ));

        $pdo = null;

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    public function add_file($trueName, $serverName, $type) {

        $pdo = Database::connect();
        
        $statement = $pdo->prepare("INSERT INTO fichiers_consultants VALUES (?, ?, ?, ?)");
        $statement->execute(array(
            $serverName,
            $this->id,
            $trueName,
            $type
        ));

        $pdo = null;

    }

    public function del_file($serverFileName) {

        $pdo = Database::connect();
        
        $statement = $pdo->prepare("DELETE FROM fichiers_consultants WHERE id_consultant = :id AND nom_serveur = :name");
        $statement->execute(array(
            ":id" => $this->id,
            ":name" => $serverFileName
        ));

        $pdo = null;

    }

    public function get_interventions(){ 
        $pdo = Database::connect(); 

        $statement = $pdo->prepare("SELECT i.id_intervention, i.date, i.date_fin, i.details, c.entreprise, e.nom FROM interventions i LEFT JOIN clients c ON c.id_client = i.id_client JOIN entreprises e ON e.id_entreprise = i.id_entreprise WHERE id_consultant = :id ORDER BY i.date"); 
        $statement->execute(array(":id" => $this->id));

        $pdo = null; 

        return $statement->fetchAll(PDO::FETCH_ASSOC);    

    } 

    public function get_qualifications(){ 

        $pdo = Database::connect(); 

        $statement = $pdo->prepare("SELECT * FROM qualifications WHERE id_consultant = :id ORDER BY date_obtention"); 
        $statement->execute(array(":id" => $this->id)); 

        $pdo = null; 

        return $statement->fetchAll(PDO::FETCH_ASSOC);    


    } 


    public function get_graphiques(){ 

        $pdo = Database::connect(); 

        $statement = $pdo->prepare("SELECT g.id_graphique, g.id_competence, c.nom, ( SELECT niveau FROM competences_consultants cc WHERE cc.id_competence = g.id_competence AND cc.id_consultant = g.id_consultant ) as niveau from graphiques g JOIN competences c ON c.id_competence = g.id_competence WHERE g.id_consultant = :id"); 
        $statement->execute(array(":id" => $this->id)); 

        $pdo = null; 

        return $statement->fetchAll(PDO::FETCH_ASSOC); 

    } 

    public function get_login() {
        return $this->login;
    }

    public function set_login($login) {
        if (Security::login_validity($login)) {
            $this->login = $login;
            $_SESSION['user']['login'] = $login;
        }
    }

    public function get_id() {
        return $this->id;
    }
    
    static public function get_array() {

        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * from consultants c join poles p on c.pole=p.id_pole ORDER BY nom");
        $statement->execute();
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $array;
      
    }
    
    static public function register($nom, $prenom, $pole) {

        $login = strtolower(substr($prenom, 0, 1) . $nom);

        $cpt = 0;
        while (!Security::login_validity($login)) {
            $cpt++;
            $login = strtolower(substr($prenom, 0, 1) . $nom . $cpt);
        }

        $token = hash("sha256", $login . bin2hex(random_bytes(50)) . $pole);

        $pdo = Database::connect();
        
        $statement = $pdo->prepare("INSERT INTO consultants (nom, prenom, pole, login, token) VALUES (:nom, :prenom, :pole, :login, :token)");
        $statement->execute(array(
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':pole' => $pole,
            ':login' => $login,
            ':token' => $token
        ));

        $id = $pdo->lastInsertID();

        $pdo = null;

        $url = "http://" . $_SERVER["HTTP_HOST"] . "/identification/?token=" . $token;

        return array(
            "url" => $url,
            "id" => $id);

    }

    public function set_password($pwd, $pwd_verif) {

        if ($pwd != $pwd_verif) return false;

        $pdo = Database::connect();

        $statement = $pdo->prepare("UPDATE consultants SET mot_de_passe = :pwd, token = null WHERE login = :login");
        $statement->execute(array(
            ":pwd" => $pwd,
            ":login" => $this->login,
        ));

        //hash("sha256", $pwd)

        $pdo = null;

        return true;
            
    }

    static public function get_consultant_via_token($token){

        $pdo = Database::connect();

        $statement = $pdo->prepare("SELECT * FROM consultants WHERE token = :token");
        $statement->execute(array(
            ":token" => $token
        ));

        $answer = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($answer == false || sizeof($answer) > 1) return false;

        $pdo = null;

        return new Consultant($answer[0]["id_consultant"]);

    }

    static public function reset_password($id_consultant){
        $pdo = Database::connect();

        $token = bin2hex(random_bytes(32));

        $statement = $pdo->prepare("UPDATE consultants SET mot_de_passe = NULL, token = :token WHERE id_consultant = :id");
        $statement->execute(array(
            ":id" => $id_consultant,
            ":token" => $token
        ));

        return $token;
    }

}
