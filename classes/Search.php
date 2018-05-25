<?php
include 'Database.php';

Class Search {

    static public function lookup(){
        $array = json_decode($_GET["filter"], true);
    

            $pdo = Database::connect();
        $where = 0;
        $bindparamcpt = 0;
        $bindparam = array();

        $statement = "SELECT c.* from consultants c JOIN interventions i ON i.id_consultant = c.id_consultant JOIN clients cl ON cl.id_client=i.id_client ";

        if(isset($array['disponibilites'])){
            if(sizeof($array['disponibilites']) > 0){ 
                $statement .= " JOIN disponibilite_consultant dc ON dc.id_consultant = c.id_consultant ";
            }
        }

        if(isset($array['competences'])){
            if (sizeof($array['competences']) > 0){           
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

                    $statement .= " EXISTS (SELECT * FROM competences_consultants ccc WHERE ccc.id_consultant = c.id_consultant AND ccc.id_competence = :bp" . $bindparamcpt . " AND ccc.niveau = :bp" . ($bindparamcpt + 1) . " ) ";

                    $bindparam[":bp" . $bindparamcpt] = $value;
                    $bindparam[":bp" . ($bindparamcpt + 1)] = $array["competences"]["niveau"][$key];
                    $bindparamcpt += 2;

                }
            }
        }

        if(isset($array["poles"])){

                  if(sizeof($array["poles"]) > 0){

            if ($where == 0) {
                $statement .= " WHERE ";
                $where = 1;
            } else{
                $statement .= " AND ";
                $where = 1;
            }

            foreach($array["poles"]["id_pole"] as $key => $value){

                if ($where != 0) {
                    if ($where == 1) {
                        $where = 2;
                    } else {
                        $statement .= " OR ";
                    }
                }
                $statement .= " c.pole = :bp" . $bindparamcpt . " ";

                $bindparam[":bp" . $bindparamcpt] = $value;

                $bindparamcpt ++ ;


            }
             }
             
        }
               
        if(isset($array["disponibilites"])){
            if(sizeof($array["disponibilites"]) > 0){

                if ($where == 0) {
                    $statement .= " WHERE ";
                    $where = 1;
                } else{
                    $statement .= " AND ";
                    $where = 1;
                }

                foreach($array["disponibilites"]["id_disponibilite"] as $key => $value){
                    
                    if ($where != 0) {
                        if ($where == 1) {
                            $where = 2;
                        } else {
                            $statement .= " OR ";
                        }
                    }

                    $statement .= " dc.id_disponibilite = :bp" . $bindparamcpt . " ";

                    $bindparam[":bp" . $bindparamcpt] = $value;
                    $bindparamcpt ++ ;
                }
            }
        }


        if(isset($array["clients"])){
            if(sizeof($array["clients"]) > 0){

                if ($where == 0) {
                    $statement .= " WHERE ";
                    $where = 1;
                } else{
                    $statement .= " AND ";
                    $where = 1;
                }

                foreach($array["clients"]["id_client"] as $key => $value){
                    
                    if ($where != 0) {
                        if ($where == 1) {
                            $where = 2;
                        } else {
                            $statement .= " AND ";
                        }
                    }

                    $statement .= " i.id_client = :bp" . $bindparamcpt . " ";

                    $bindparam[":bp" . $bindparamcpt] = $value;
                    $bindparamcpt ++ ;
                }
            }
        }


                $bindparam[":bp" . $bindparamcpt] = $value;
                $bindparam[":bp" . ($bindparamcpt + 1)] = $array["competences"]["niveau"][$key];
                $bindparamcpt += 2;

        if(isset($array["consultant"])){
            if(sizeof($array["consultant"]) > 0){

                if ($where == 0) {
                    $statement .= " WHERE ";
                    $where = 1;
                } else{
                    $statement .= " AND ";
                    $where = 1;
                }

                foreach($array["consultant"] as $key => $value){
                    
                    if ($where != 0) {
                        if ($where == 1) {
                            $where = 2;
                        } else {
                            $statement .= " OR ";
                        }
                    }

                    $statement .= " c.nom LIKE :bp" . $bindparamcpt . "  ";

                    $bindparam[":bp" . $bindparamcpt] = "%".$value."%";
                    $bindparamcpt ++ ;
                }
            }
        }
        var_dump($statement);
 //       $query->fetchAll();

        $statement .= " GROUP BY c.id_consultant";

        $query = $pdo->prepare($statement);
        $query->execute($bindparam);
       $result = $query->fetchAll(PDO::FETCH_ASSOC);
       

//   var_dump( $result);
 //       $query->fetchAll();
return $result;        
//        var_dump($bindparam);
//$query->debugDumpParams();
        //var_dump($query);
    } 

}





