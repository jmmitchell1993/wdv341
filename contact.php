    <?php
				
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
			
        	}
      	
    }// ends if submit 
    
    if($_POST) {

        $toEmail = "jessmitchell@jessicammitchell.com";	
        
        $subject = "Contact Form Inquiries";
    
        $fromEmail = "jessmitchell@jessicammitchell.com";	
    
        $emailBody = "Form Data\n\n ";		
        foreach($_POST as $key => $value)					
        {
            $emailBody.= $key."=".$value."\n";
        } 
        
      $headers = "From: $fromEmail" . "\r\n";	
      
      $honeypot = $_POST['firstname'];
    
      if( $honeypot > 1 ) {
            return;
      } 
      else {
        mail($toEmail,$subject,$emailBody,$headers);
        }
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
    
    <h1>Contact Us</h1>
    
    <?php
        //If the form was submitted and valid and properly put into database display the INSERT result message
    	if($validForm) {
    ?>
    <h1><?php echo $message ?></h1>
        
    <?php } //end if 
        else { //display form
    ?>
    <form id="contact" name="contact" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <fieldset>
            <p>
            <label for="name">Name: </label>
            <input type="text" name="name" id="name" /> 
            <span class="errMsg"></span>
            </p>
            <p>
            <label for="email">Email: </label>
            <input type="text" name="email" id="email" /> 
            <span class="errMsg"></span>
            </p>
            <p>
            <label for="message">Message:</label>
                <textarea name="message" id="message" maxlength="700"></textarea>
            <span class="errMsg"></span>                
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