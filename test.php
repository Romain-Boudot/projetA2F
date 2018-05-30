<?php 



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'classes/Search.php';
?>
<pre>
<?php
$id = 1;
while ($id < 305){
Search::show_graph($id);
$id++;
}



?></pre>

<?php

?>




