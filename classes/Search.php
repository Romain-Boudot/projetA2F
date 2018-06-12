<?php

function debug($var) {

    echo "<div style='width:90vw'><pre style='width:100%;white-space:pre-wrap'>";
    var_dump($var);
    echo "</pre></div>";

}

function average_skill($bind, $id, $lvl = null) {

    $str = ""; // bout de statement a return

    $is_last = Competence::is_last($id); // si la competence a des enfant (bool)

    if ($is_last == null) $is_last = false;

    if ($is_last) {

        if ($lvl != null) {
        
            $str .= " EXISTS (SELECT niveau FROM competences_consultants ccc WHERE ccc.id_consultant = c.id_consultant AND ccc.id_competence = :bp" . $bind["bindparamcpt"] . " AND ccc.niveau " . $bind["lvl"][$lvl] . " ) ";
            $bind["bindparam"][":bp" . $bind["bindparamcpt"]] = $id;
            $bind["bindparamcpt"] += 1;

        } else {

            $str .= " (SELECT niveau FROM competences_consultants ccc WHERE ccc.id_consultant = c.id_consultant AND ccc.id_competence = :bp" . $bind["bindparamcpt"] . " ) ";
            $bind["bindparam"][":bp" . $bind["bindparamcpt"]] = $id;
            $bind["bindparamcpt"] += 1;

        }

    } else {

        $children = Competence::get_children($id);       

        $str .= " ( ( ";
        $cpt = 0;

        foreach ($children as $key => $value) {

            $value = $value["id_competence"];

            $cpt = $key + 1;

            if ($key != 0) $str .= " + ";
            $str .= " CAST( ";
            $returned = average_skill($bind, $value);
            $str .= $returned["statement"];
            $bind["bindparam"] = $returned["bindparam"];
            $bind["bindparamcpt"] = $returned["bindparamcpt"];
            $str .= " as int ) ";

        }

        $str .= " ) / " . $cpt . " ) ";

        if ($lvl != null) {
            
            $str .= $bind["lvl"][$lvl] . " ";

        }

    }

    return array(
        "statement" => $str,
        "bindparam" => $bind["bindparam"],
        "bindparamcpt" => $bind["bindparamcpt"]
    );

}

Class Search {

    static public function lookup(){

        $array = json_decode($_GET["filter"], true);

        $pdo = Database::connect();
        $where = 0;
        $bindparamcpt = 0;
        $bindparam = array();
        $lvl_array = array(
            "=0" => " = 0 ",
            "m=1" => " <= 1 ",
            "p=1" => " >= 1 ",
            "m=2" => " <= 2 ",
            "p=2" => " >= 2 ",
            "=3" => " = 3 "
        );

        $statement = "SELECT c.* from consultants c JOIN interventions i ON i.id_consultant = c.id_consultant JOIN clients cl ON cl.id_client=i.id_client ";

        if(isset($array['disponibilites'])){
            if(sizeof($array['disponibilites']) > 0){ 
                $statement .= " JOIN disponibilite_consultant dc ON dc.id_consultant = c.id_consultant ";
            }
        }

        if(isset($array['competences'])) {

            if ((sizeof($array['competences']['id_competence']) > 0) && (sizeof($array['competences']['niveau']) > 0)) {
                
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

                    $returned = average_skill(
                        array(
                            "bindparamcpt" => $bindparamcpt,
                            "bindparam" => $bindparam,
                            "lvl" => $lvl_array
                        ),
                        $value,
                        $array["competences"]["niveau"][$key]
                    );

                    debug($returned);

                    $statement .= $returned["statement"];
                    $bindparam = $returned["bindparam"];
                    $bindparamcpt = $returned["bindparamcpt"];

                    // $statement .= " EXISTS (SELECT * FROM competences_consultants ccc WHERE ccc.id_consultant = c.id_consultant AND ccc.id_competence = :bp" . $bindparamcpt . " AND ccc.niveau = :bp" . ($bindparamcpt + 1) . " ) ";

                    // $bindparam[":bp" . $bindparamcpt] = $value;
                    // $bindparam[":bp" . ($bindparamcpt + 1)] = $array["competences"]["niveau"][$key];
                    // $bindparamcpt += 2;

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

                $statement .= " ( ";

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
            
                $statement .= " ) ";
            
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


        if(isset($array["consultant"])) if (sizeof($array["consultant"])) {

            if ($where == 0) {
                $statement .= " WHERE ";
                $where = 1;
            } else{
                $statement .= " AND ";
                $where = 1;
            }

            $statement .= " ( ";

            foreach ($array["consultant"] as $key => $value) {
                
                if ($key > 0) $statement .= " OR ";

                $statement .= " c.nom LIKE :bp" . $bindparamcpt . "  ";
                
                $bindparam[":bp" . $bindparamcpt] = "%".$value."%";
                $bindparamcpt ++ ;
            
            }

            $statement .= " ) ";

        }

        $statement .= " GROUP BY c.id_consultant ORDER BY c.nom";
        debug($statement);
        debug($bindparam);
        $query = $pdo->prepare($statement);
        $query->execute($bindparam);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        debug($result);
        exit();

        return $result;        

    } 

    static public function show_graph($id_post){

        $valid = 0;

        $pdo = Database::connect();

        $first_level_check = $pdo->prepare("SELECT id_competence FROM competences WHERE id_competence_mere = :id_comp_mere");
        $first_level_check->execute(array(":id_comp_mere" => $id_post));

        $check = $first_level_check->fetchAll(PDO::FETCH_ASSOC);
        if(sizeof($check) > 0){         
            foreach($check as $list => $array){
                foreach($array as $key => $id){

                    $second_level_check = $pdo->prepare("SELECT id_competence FROM competences WHERE id_competence_mere = :id_comp_mere");
                    $second_level_check->execute(array(":id_comp_mere" => $id));

                    $check_two = $second_level_check->fetchAll(PDO::FETCH_ASSOC);

                    if(sizeof($check_two) != 0){
                        $valid++;
                    }

                }

            }            


            if($valid == 0){

                $statement = $pdo->prepare("SELECT c.nom, (SELECT COUNT(*) FROM competences_consultants cc WHERE cc.niveau >= 2 AND cc.id_competence = c.id_competence) as count FROM competences c WHERE c.id_competence_mere = :id_comp_mere");
                $statement->execute(array(":id_comp_mere" => $id_post));
                $graph1 = $statement->fetchAll(PDO::FETCH_ASSOC);


                $statement = $pdo->prepare("SELECT c.nom, (SELECT AVG(cc.niveau) FROM competences_consultants cc WHERE cc.id_competence = c.id_competence) as average FROM competences c WHERE c.id_competence_mere = :id_comp_mere");
                $statement->execute(array("id_comp_mere" => $id_post));
                $graph2 = $statement->fetchAll(PDO::FETCH_ASSOC);

                $graphs = array($graph1, $graph2);

                return $graphs;
            }else {
                return false;        
            }



        } else{
            return false;
        } 


    }

}

