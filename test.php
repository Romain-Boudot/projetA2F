<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'classes/Search.php';

$r = Search::lookup();




?><pre>

<?php
var_dump($r);
?>
</pre>
