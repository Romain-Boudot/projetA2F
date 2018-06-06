<?php 

include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Search.php";

session_start();

$search = new Search();
$id_processing = 34;
$g =  $search->show_graph($id_processing);
echo "<pre>";
var_dump($g);
echo "</pre>";

if (!$g) {
    echo "[-1]";
    exit();
}


?>
{
    "G1":{ 
        "label": [<?php
            foreach ($g[0] as $k => $skill) {
                if ($k != 0) echo ","; 
                echo "\"" . $skill["nom"] . "\"";
            }
        ?>],
        "data": [<?php 
            foreach ($g[0] as $k => $skill) {
                if ($k != 0) echo ",";
                echo $skill["count"]; 
            }
        ?>]
    },
    "G2":{ 
        "label": [<?php 
            foreach ($g[1] as $k => $skill) {
                if ($k != 0) echo ",";
                echo "\"" . $skill["nom"] . "\"";
            }
        ?>],
        "data": [<?php 
            foreach ($g[1] as $k => $skill) {
                if ($k != 0) echo ",";
                if ($skill["average"] == NULL) {
                    echo 0;
                } else {
                    echo $skill["average"];
                }
                
        }
        ?>]
    }
}