<?php
session_start();
	  
	  require 'database/connectPDO.php';
	  
	  //SQL STRING COMMANDS
	  $sql = "SELECT ";
	  $sql .= "event_name, ";
	  $sql .= "event_description, ";
	  $sql .= "event_date, "; 	  
	  $sql .= "event_time "; //Last column does NOT have a comma after it.
	  $sql .= "FROM coffee_events";
	  
	  //PREPARE SQL
	  $stmt = $conn->prepare($sql);
	  
	  //EXECUTE
	  $stmt->execute();		

	  $stmt->setFetchMode(PDO::FETCH_ASSOC);
 

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
    
        <h1>Events</h1>
        
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
				</div><!-- Close Event Block -->
        <?php
			}
		?>	
  	
        
	</main>
   




</div>
</body>
</html>