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

        if(isset($array['candidats'])){
            if($array['candidats'] == false){

                $statement = "SELECT c.* from consultants c ";

                if(isset($array['disponibilites'])){
                    if(sizeof($array['disponibilites']['id_disponibilite']) > 0){ 
                        $statement .= " JOIN disponibilite_consultant dc ON dc.id_consultant = c.id_consultant ";
                    }
                }

                if(isset($array['clients'])){
                    if(sizeof($array['clients']['id_client']) > 0){
                        $statement .= " JOIN interventions i ON i.id_consultant = c.id_consultant JOIN clients cl ON cl.id_client=i.id_client ";
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

            }elseif($array['candidats'] == true){

                $statement = "SELECT c.* from candidats c ";

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

                $statement .= " GROUP BY c.id_candidat ORDER BY c.nom";


            }
        }

        $query = $pdo->prepare($statement);
        $query->execute($bindparam);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        var_dump($statement);
        return $result;        

    } 

    static public function graph_query($id, $first_lvl) {

        $pdo = Database::connect();
        $returned = array();
        
        if (Competence::is_last($id)) {
                        
            $statement = $pdo->prepare("SELECT c.nom, (SELECT COUNT(*) FROM competences_consultants cc WHERE cc.niveau >= 2 AND cc.id_competence = c.id_competence) as count FROM competences c WHERE c.id_competence = :id_comp");
            $statement->execute(array(":id_comp" => $id));
            $returned["count"] = $statement->fetch();

            $statement = $pdo->prepare("SELECT AVG(CAST(COALESCE((SELECT AVG(cc.niveau) FROM competences_consultants cc WHERE cc.id_competence = :id_comp AND cc.id_consultant = c.id_consultant), 0) as DECIMAL(6, 3))) as average FROM consultants c");
            $statement->execute(array("id_comp" => $id));
            $returned["average"] = $statement->fetch();

            return $returned;

        } else {

            if (!$first_lvl) {
                
                $statement = $pdo->prepare("SELECT count(id_consultant) as count FROM consultants c1 WHERE CAST(( SELECT  AVG(COALESCE((SELECT cc.niveau FROM competences_consultants cc WHERE cc.id_competence = c.id_competence AND cc.id_consultant = c1.id_consultant), 0 ) ) FROM competences c WHERE id_competence_mere = :id_comp_mere) as DECIMAL(6, 3)) >= 2");
                $statement->execute(array(":id_comp_mere" => $id));
                $returned["count"] = $statement->fetch(); 
                
                $statement = $pdo->prepare("SELECT AVG(CAST(( SELECT  AVG(COALESCE((SELECT cc.niveau FROM competences_consultants cc WHERE cc.id_competence = c.id_competence AND cc.id_consultant = c1.id_consultant), 0)) FROM competences c WHERE id_competence_mere = :id_comp_mere) as DECIMAL(6, 3))) as average FROM consultants c1");
                $statement->execute(array(":id_comp_mere" => $id));
                $returned["average"] = $statement->fetch();
                
                return $returned;
                
            } else {
            
                $first_level_check = $pdo->prepare("SELECT nom, id_competence FROM competences WHERE id_competence_mere = :id_comp_mere");
                $first_level_check->execute(array(":id_comp_mere" => $id));
                $filles = $first_level_check->fetchAll(PDO::FETCH_ASSOC);   

                foreach ($filles as $key => $value) {

                    $statement = $pdo->prepare("SELECT AVG(CAST(( SELECT  AVG(COALESCE((SELECT cc.niveau FROM competences_consultants cc WHERE cc.id_competence = c.id_competence AND cc.id_consultant = c1.id_consultant), 0)) FROM competences c WHERE id_competence_mere = :id_comp_mere) as DECIMAL(6, 3))) as average FROM consultants c1");
                    $statement->execute(array(":id_comp_mere" => $id));
                    $average += $statement->fetch();

                }
                
            }

        }

    }

    static public function graph_query_v2($id) {

        $pdo = Database::connect();
        $returned = array();

        if (Competence::is_last($id)) {
                        
            $statement = $pdo->prepare("SELECT c.nom, (SELECT COUNT(*) FROM competences_consultants cc WHERE cc.niveau >= 2 AND cc.id_competence = c.id_competence) as count FROM competences c WHERE c.id_competence = :id_comp");
            $statement->execute(array(":id_comp" => $id));
            $returned["count"] = $statement->fetch();

            $statement = $pdo->prepare("SELECT AVG(CAST(COALESCE((SELECT AVG(cc.niveau) FROM competences_consultants cc WHERE cc.id_competence = :id_comp AND cc.id_consultant = c.id_consultant), 0) as DECIMAL(6, 3))) as average FROM consultants c");
            $statement->execute(array("id_comp" => $id));
            $returned["average"] = $statement->fetch();

            return $returned;

        } else {

            $statement = $pdo->prepare("SELECT COUNT(id_consultant) as count
            FROM consultants co
            WHERE ((
                SELECT AVG(COALESCE((SELECT cc.niveau FROM competences_consultants cc WHERE cc.id_competence = c1.id_competence AND cc.id_consultant = co.id_consultant ), 0))
                FROM competences c1 WHERE NOT EXISTS (SELECT * FROM competences c2 WHERE c2.id_competence_mere = c1.id_competence) AND
                (
                    c1.id_competence_mere = :id_comp
                    OR
                    EXISTS (SELECT * FROM competences tmp1 WHERE c1.id_competence_mere = tmp1.id_competence AND tmp1.id_competence_mere = :id_comp )
                )
            )) >= 2");
            $statement->execute(array(":id_comp" => $id));
            $returned["count"] = $statement->fetch();

            $statement = $pdo->prepare("SELECT AVG((
                SELECT AVG(COALESCE((SELECT cc.niveau FROM competences_consultants cc WHERE cc.id_competence = c1.id_competence AND cc.id_consultant = co.id_consultant ), 0))
                FROM competences c1 WHERE NOT EXISTS (SELECT * FROM competences c2 WHERE c2.id_competence_mere = c1.id_competence) AND
                (
                    c1.id_competence_mere = :id_comp
                    OR
                    EXISTS (SELECT * FROM competences tmp1 WHERE c1.id_competence_mere = tmp1.id_competence AND tmp1.id_competence_mere = :id_comp )
                )
            )) as average
            FROM consultants co");
            $statement->execute(array("id_comp" => $id));
            $returned["average"] = $statement->fetch();

            return $returned;
        
        }

    }

    static public function show_graph($id_post){

        if (Competence::is_last($id_post)) return false;

        $graphs = array(
            0 => array(),
            1 => array()
        );

        $pdo = Database::connect();

        $first_level_check = $pdo->prepare("SELECT nom, id_competence FROM competences WHERE id_competence_mere = :id_comp_mere");
        $first_level_check->execute(array(":id_comp_mere" => $id_post));
        $filles = $first_level_check->fetchAll(PDO::FETCH_ASSOC);   

        foreach ($filles as $key => $value) {
   
            $arr = Search::graph_query_v2($value["id_competence"]);
        
            $graphs[0][] = array(
                "nom" => $value["nom"],
                "count" => $arr["count"]["count"]
            );
            $graphs[1][] = array(
                "nom" => $value["nom"],
                "average" => $arr["average"]["average"]
            );
        
        }
        
        return $graphs;

    }

}

/* 
$statement = $pdo->prepare("SELECT c.nom, (SELECT COUNT(*) FROM competences_consultants cc WHERE cc.niveau >= 2 AND cc.id_competence = c.id_competence) as count FROM competences c WHERE c.id_competence_mere = :id_comp_mere");
            $statement->execute(array(":id_comp_mere" => $id_post));
            $graph1 = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            
            $statement = $pdo->prepare("SELECT c.nom, (SELECT AVG(cc.niveau) FROM competences_consultants cc WHERE cc.id_competence = c.id_competence) as average FROM competences c WHERE c.id_competence_mere = :id_comp_mere");
            $statement->execute(array("id_comp_mere" => $id_post));
            $graph2 = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            SELECT * FROM competences c1 WHERE NOT EXISTS (SELECT * FROM competences c2 WHERE c2.id_competence_mere = c1.id_competence) AND
(
	c1.id_competence_mere = 191
    OR
    EXISTS (SELECT * FROM competences tmp1 WHERE c1.id_competence_mere = tmp1.id_competence AND tmp1.id_competence_mere = 191 )
)
            
            
            */
