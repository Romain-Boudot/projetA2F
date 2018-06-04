<?php 

include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Search.php";

session_start();

$search = new Search();

$g =  $search->show_graph($id_processing);

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