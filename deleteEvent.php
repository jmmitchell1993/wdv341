<?php
$sql = "DELETE FROM coffee_events WHERE event_id = :evtID";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':evtID', $_POST['evtID'], PDO::PARAM_INT);   
$stmt->execute();

?>