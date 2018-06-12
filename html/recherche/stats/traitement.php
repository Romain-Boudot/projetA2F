<?php 

include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Database.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Competence.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../classes/Search.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/../includes/splitstr.php";

session_start();

$search = new Search();
$id_processing = $_GET["id"];
$g =  $search->show_graph($id_processing);

if (!$g) {
    echo "[-1]";
    exit();
}

?>
{
    "id":"idgraph<?php echo $id_processing; ?>",
    "G1":{ 
        "label": [<?php
            foreach ($g[0] as $k => $skill) {
                if ($k != 0) echo ","; 
                echo splitstr($skill["nom"]);
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
                echo splitstr($skill["nom"]);
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