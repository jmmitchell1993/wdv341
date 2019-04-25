<?php
session_start();
//Only allow a valid user access to this page
if ($_SESSION['validUser'] !== "yes") {
	header('Location: adminIndex.php');
}

	try {
	  
	  require 'database/connectPDO.php';
	  
	  //SQL STRING COMMANDS
	  $sql = "SELECT ";
	  $sql .= "event_id, ";
	  $sql .= "event_name, ";
	  $sql .= "event_description, ";
      $sql .= "event_date, ";
      $sql .= "event_time ";
	  $sql .= "FROM coffee_events";
	  
	  //PREPARE
	  $stmt = $conn->prepare($sql);
	  
	  //EXECUTE
	  $stmt->execute();		

	  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  }
  
  catch(PDOException $e) {
	  $message = "There has been a problem. The system administrator has been contacted. Please try again later.";

	  error_log($e->getMessage());
	  error_log($e->getLine());
	  error_log(var_dump(debug_backtrace()));			
  }

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>The Coffee Tree Cafe</title>

    <link rel="stylesheet" href="css/events.css">

</head>

<body>

<div id="container">
<header class="title-wrapper">
    <img src="images/ring.png" alt="ring" title="ring" height="8%"/>
    <div class="centered">TheCoffeeTreeCafe
        <span class="centered-below">ADMIN SYSTEM</span>
    </div>
</header>
    
<?php require 'includes/navigation.php'; ?>

    
    <main>
    
        <h1>Display Available Events</h1>
        
        <?php 
			while( $row=$stmt->fetch(PDO::FETCH_ASSOC)) {
		?>		
				<div class="eventBlock">
                    <div class="row evt_name">
                        <span class="eventName"><?php echo $row['event_name']; ?></span>
                    </div>
                    <div class="row">
                        <span class="eventDate">Date: <?php echo $row['event_date'] ?></span> &nbsp;|&nbsp; <span class="eventTime">Time: <?php echo $row['event_time'] ?></span>
                    </div>
                    <div class="row">
                        <span class="eventDescription"><?php echo $row['event_description']; ?></span>
                    </div> 
                    &nbsp;                 
                    <div class="row">
                    	<?php $event_id=$row['event_id'];	//put event_id into a variable for further processing  ?>
                    	<a href='updateEvent.php?recId=<?php echo $event_id; ?>'><button class="btn">Update</button></a>
                        <a href='deleteEvent.php?recId=<?php echo $event_id; ?>'><input class="btn btn-delete" type="button" value="Delete"></a>
                    </div>                
				</div><!-- Close Event Block -->
        <?php
			}
		?>	
  	
        
	</main>
    
	




</div>
</body>
</html>