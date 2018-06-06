<?php 

include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Search.php";

session_start();

$search = new Search();

//$g =  $search->show_graph($id_processing);

$g = array(
    "G1" => array(
        "nom" => array("comp1", "comp2", "comp3"),
        "count" => array(1, 2, 3)
    ),
    "G2" => array(
        "nom" => array("comp1", "comp2", "comp3"),
        "average" => array(1, 2, 3)
    )
);

?>
{
    "G1":{ 
        "label": [<?php
            foreach ($g["G1"]["nom"] as $k => $skill) {
                if ($k != 0) echo ","; 
                echo "\"" . $skill . "\"";
            }
        ?>],
        "data": [<?php 
            foreach ($g["G1"]["count"] as $k => $skill) {
                if ($k != 0) echo ",";
                echo $skill; 
            }
        ?>]
    },
    "G2":{ 
        "label": [<?php 
            foreach ($g["G2"]["nom"] as $k => $skill) {
                if ($k != 0) echo ",";
                echo "\"" . $skill . "\"";
            }
        ?>],
        "data": [<?php 
            foreach ($g["G2"]["average"] as $k => $skill) {
                if ($k != 0) echo ",";
                echo $skill;
        }
        ?>]
    }
}