<?php 



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'classes/Search.php';
?>
<pre>
<?php
Search::show_graph(6);




?></pre>

<?php

?>




<?php

session_start();

function login_redirect() {
    header('location: http://' . $_SERVER['HTTP_HOST'] . "/login");
    exit();
}

if (isset($_SESSION['user']['connected'])) {

    if (!$_SESSION['user']['connected']) login_redirect();

} else login_redirect();

?>