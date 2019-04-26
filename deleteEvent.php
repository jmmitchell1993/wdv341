<?php
$updateEvtID = $_GET['recId'];

require 'database/connectPDO.php';	

$sql = "DELETE FROM coffee_events WHERE event_id = $updateEvtID";
$stmt = $conn->prepare($sql);
$stmt->execute();		

header('Location: displayEvents.php');
?>