<?php
$serverName = "localhost";
$username = "jessmitchell_php";
$password = "wdv341";
$database = "jessmitchell_php";
// $serverName = "localhost";
// $username = "root";
// $password = "";
// $database = "coffee_users";


    $conn = new PDO("mysql:host=$serverName;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);		//Forces MySQL to create the PDO prepared statements instead of letting PDO make them.  Better SQL Injection protection
    //echo "Connected successfully"; 	//TESTING ONLY!


?>