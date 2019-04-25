<?php
session_start();

if ($_SESSION['validUser'] !== "yes") {
	header('Location: adminIndex.php');
}
	
    //fields
    $event_name = "";
    $event_description = "";
    $event_date = "";
    $event_time = "";
    
    //error messages
    $nameErrMsg = "";
    $descriptionErrMsg = "";
    $dateErrMsg = "";
    $timeErrMsg = "";
    
    $validForm = false;
    
    $updateEvtID = $_GET['recId'];
				
	if(isset($_POST["submit"])) {	

		$event_name = $_POST['event_name'];
		$event_description = $_POST['event_description'];
		$event_date = $_POST['event_date'];
		$event_time = $_POST['event_time'];		

        function validateName($inValue) {
            global $validForm, $nameErrMsg;		
            $nameErrMsg = "";
            
            if($inValue == "") {
                $validForm = false;
                $nameErrMsg = "Name cannot be empty";
            }
		}//end validateName()
			
		function validateDescription($inValue) {
            global $validForm, $descriptionErrMsg;		
            $descriptionErrMsg = "";
            
            if($inValue == "")
            {
                $validForm = false;
                $descriptionErrMsg = "Name cannot be empty";
            }
        }//end validateDescription()
	
		$validForm = true;
		
		validateName($event_name);
		validateDescription($event_description);
		
		if($validForm) {

			$message = "All form data is good.";	
			
			try {
				
				require 'database/connectPDO.php';	//CONNECT to the database
				
				//Create the SQL command string
				$sql = "UPDATE coffee_events SET ";
				$sql .= "event_name='$event_name', ";
				$sql .= "event_description='$event_description', ";
				$sql .= "event_date='$event_date', ";
				$sql .= "event_time='$event_time' ";
				$sql .= "WHERE event_id='$updateEvtID'";
				
				//PREPARE the SQL statement
				$stmt = $conn->prepare($sql);
                
                //BIND
                // $stmt->bindParam(':name', $event_name);
				// $stmt->bindParam(':description', $event_description);				
				// $stmt->bindParam(':date', $event_date);					
                // $stmt->bindParam(':time', $event_time);	

				//EXECUTE the prepared statement
				$stmt->execute();	
				
				$message = "The Event has been Updated.";
			}
			
			catch(PDOException $e) {
				$message = "There has been a problem. The system administrator has been contacted. Please try again later.";
	
				error_log($e->getMessage());
				error_log(var_dump(debug_backtrace()));			
			}
		}
		else {
			$message = "Something went wrong";
		}//ends check for valid form		
	}
	else {

		try {
		  
		    require 'database/connectPDO.php';	
		
            //SQL STRING COMMANDS
            $sql = "SELECT ";
            $sql .= "event_name, ";
            $sql .= "event_description, ";
            $sql .= "event_date, ";
            $sql .= "event_time ";
            $sql .= "FROM coffee_events ";
            $sql .= "WHERE event_id=$updateEvtID";
		  
            //PREPARE
            $stmt = $conn->prepare($sql);
            
            //EXECUTE
            $stmt->execute();		
            
            $stmt->setFetchMode(PDO::FETCH_ASSOC);	
            
            $row=$stmt->fetch(PDO::FETCH_ASSOC);	 
				
            $event_name = $row['event_name'];
            $event_description = $row['event_description'];
            $event_date = $row['event_date'];
            $event_time = $row['event_time'];				
	    }
	  
	  catch(PDOException $e) {
		  $message = "There has been a problem. The system administrator has been contacted. Please try again later.";
		  error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
		  error_log($e->getLine());
		  error_log(var_dump(debug_backtrace()));	
      }	
      	
	}// ends if submit 
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>The Coffee Tree Cafe</title>
    <link rel="stylesheet" href="css/events.css">
  	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>    

	<script>
		$(function() {
			$('#event_date').datepicker({dateFormat: "yy-mm-dd"});	//set datepicker format to yyyy-mm-dd to match database expected format
		} );	
	</script>

    <script>
		function clearForm() {
			//alert("inside clearForm()");
			$('.errMsg').html("");				
			$('input:text').removeAttr('value');	
			$('textarea').html("");					
		}
	</script>
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
    
    <h1>Update Event</h1>
    
    <?php
        //If the form was submitted and valid and properly put into database display the INSERT result message
    	if($validForm) {
    ?>
    <h1><?php echo $message ?></h1>
        
    <?php } //end if 

        else { //display form
    ?>
    <form id="updateEventForm" name="updateEventForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?recId=$updateEvtID"; ?>">
        <fieldset>
            <p>
            <label for="event_name">Event Name: </label>
            <input type="text" name="event_name" id="event_name" value="<?php echo $event_name;  ?>" /> 
            <span class="errMsg"> <?php echo $nameErrMsg; ?></span>
            </p>
            <p>
            <label for="event_description">Event Description:</label>
                <textarea name="event_description" id="event_description" maxlength="700"><?php echo $event_description; ?></textarea>
            <span class="errMsg"><?php echo $descriptionErrMsg; ?></span>                
            </p>
            <p>
            <label for="event_date">Date: </label>
            <input type="text" name="event_date" id="event_date" value="<?php echo $event_date;  ?>" />
            <span class="errMsg"><?php echo $dateErrMsg; ?></span>                      
            </p>
            <p>
            <label for="event_time">Time: </label> 
            <input type="text" name="event_time" id="event_time" value="<?php echo $event_time;  ?>"/>
            <span class="errMsg"><?php echo $timeErrMsg; ?></span>      
            </p>
        </fieldset>
        <p>
            <input type="submit" class="btn" name="submit" id="submit" value="Update" />
            <input type="reset" class="btn" name="button2" id="button2" value="Clear" onClick="clearForm()" />
        </p>  
    </form>
    <?php
        } //end else
    ?>    	
</div> <!-- end container -->
</body>
</html>