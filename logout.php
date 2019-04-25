<?php
session_start();

$_SESSION['validUser'] = "no";
session_unset();	//remove all session variables related to current session
session_destroy();	

header('Location: login.php');


?>