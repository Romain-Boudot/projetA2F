<?php

Class Search {

    public static function search(){
        $pdo = Database::connect();
        $where = false;
        $i = 0;


        $statement = "SELECT * from consultants c JOIN interventions i ON i.id_consultant = c.id_consultant JOIN client cl ON cl.id_client=i.id_client ";


        if(isset($_GET['competence'])){
            $statement .= " JOIN competences_consultants cc ON cc.id_consultant = c.id_consultant JOIN competences comp ON comp.id_competence = cc.id_competence "

        }

        if(isset($_GET['disponibilite'])){

            $statement .= " JOIN disponibilite_consultant dc ON dc.id_consultant = c.id_consultant ";

        }

        if(isset($_GET){
            $statement .= " WHERE ";

            foreach($_GET as $name => $value){
                
                if ($i != 0){
                    $statement .= " AND ";
                } 
               
                $statement .= " :getname = :value "

            }

            


        }


    }






?>
