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
    private $pole;
    private $honoraires;

    public function __construct($id){
        $pdo = Databtase::connect();

        $statement = pdo->prepare("SELECT * FROM consultants WHERE id = :id");
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
            $this->pole = $infos['pole'];
            $this->honoraires = $infos['honoraires'];
        } elseif(!$statement){
    
            //            header('location: ../search/');
            //HEADER A CHANGER
        }
        $pdo = null;


    }




}
