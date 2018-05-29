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
        if ((sizeof($array['competences']['id_competence']) > 0) && (sizeof($array['competences']['niveau']) > 0)){           
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

        if(sizeof($array["poles"]["id_pole"]) > 0){

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
        if(sizeof($array["disponibilites"]["id_disponibilite"]) > 0){

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
        if(sizeof($array["clients"]["id_client"]) > 0){

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

    $statement .= " GROUP BY c.id_consultant ORDER BY c.nom";

    var_dump($statement);
    $query = $pdo->prepare($statement);
    $query->execute($bindparam);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);


    return $result;        

} 

    static public function show_graph($id_post){

        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);


        $pdo = Database::connect();

        $first_level_check = $pdo->prepare("SELECT id_competence FROM competences WHERE id_competence_mere = :id_comp_mere");
        $first_level_check->execute(array(":id_comp_mere" => $id_post));

        $check = $first_level_check->fetchAll(PDO::FETCH_ASSOC);
        echo "check";
        var_dump($check);
        if(sizeof($check) > 0){         
            foreach ($check as $numero => $array){
                echo "array";
                foreach($array as $key => $value){
                
                var_dump($array);
                    $c = 1;
                    $second_level_check = $pdo->prepare("SELECT id_competence FROM competences WHERE id_competence_mere = :id_second");
                    $second_level_check->execute(array(":id_second" => $key));

                    $check_again = $second_level_check->fetchAll(PDO::FETCH_ASSOC);
                    if(sizeof($check_again) == 0){
                            
                        echo "1"    ;
                        $statement = $pdo->prepare("SELECT c.nom, (SELECT COUNT(*) FROM competences_consultants cc WHERE cc.niveau >= 2 AND cc.id_competence = c.id_competence) as count FROM competences c WHERE c.id_competence_mere = :id_comp_mere");
                        $statement->execute(array(":id_comp_mere" => $id_post));
                        $graph1 = $statement->fetchAll(PDO::FETCH_ASSOC);

                        echo "2";

                        $statement = $pdo->prepare("SELECT c.nom, (SELECT AVG(cc.niveau) FROM competences_consultants cc WHERE cc.id_competence = c.id_competence) as average FROM competences c WHERE c.id_competence_mere = :id_comp_mere");
                        $statement->execute(array("id_comp_mere" => $id_post));
                        $graph2 = $statement->fetchAll(PDO::FETCH_ASSOC);

                        $graphs = array($graph1, $graph2);

                        var_dump($graphs);
                    } else{

                    }
                }
            }
        } else{


        }
        

    }
}





