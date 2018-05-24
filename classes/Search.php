<?php
error_reporting(E_ALL);
include 'Database.php';

Class Search {

    static public function lookup(){
        $array = json_decode($_GET["filter"], true);
    

            $pdo = Database::connect();
        $where = 0;
        $i = 0;
        $i2 = 0;
        $bindparamcpt = 0;
        $bindparam = array();

        $statement = "SELECT * from consultants c JOIN interventions i ON i.id_consultant = c.id_consultant JOIN clients cl ON cl.id_client=i.id_client ";


        if(isset($array['competence'])){
            $statement .= " JOIN competences_consultants cc ON cc.id_consultant = c.id_consultant JOIN competences comp ON comp.id_competence = cc.id_competence ";

        }

        if(isset($array['disponibilite'])){

            $statement .= " JOIN disponibilite_consultant dc ON dc.id_consultant = c.id_consultant ";

        }

        if(isset($array['competences'])){
            
            if ($where == 0) {
                $statement .= " WHERE ";
                $where = 1;
            }

            foreach($array["competences"]["id_competence"] as $key => $value){

                if ($where != 0) {
                    if ($where == 1) {
                        $where = 2;
                    } else {
                        $statement .= " AND ";
                    }
                }

                $statement .= " (cc.id_competence = :bp" . $bindparamcpt . " AND cc.niveau = :bp" . ($bindparamcpt + 1) . " ) ";

                $bindparam[":bp" . $bindparamcpt] = $value;
                $bindparam[":bp" . ($bindparamcpt + 1)] = $array["competences"]["niveau"][$key];
                $bindparamcpt += 2;

            }

        }
        var_dump($statement);
 //       $query->fetchAll();

        var_dump($bindparam);
//$query->debugDumpParams();
//        return $query;
    } 

}





