<?php 
session_cache_limiter('none');
session_start();
 
	$message = "";
	$errMessage = ""; 
 
	if ($_SESSION['validUser'] == "yes")				//is this already a valid user?
	{
		//User is already signed on.  Skip the rest.
		$message = "Welcome Back!";	//Create greeting for VIEW area		
	}
	else
	{
		if (isset($_POST['submitLogin']) )			//Was this page called from a submitted form?
		{
			$inUsername = $_POST['loginUsername'];	//pull the username from the form
			$inPassword = $_POST['loginPassword'];	//pull the password from the form

// echo "Username: " . $inUsername;
// echo "Password: " . $inPassword;

			try {
			  
			  require 'database/connectPDO.php';	//CONNECT to the database
			  
			  //mysql DATE stores data in a YYYY-MM-DD format
			  $todaysDate = date("Y-m-d");		//use today's date as the default input to the date( )
			  
			  //Create the SQL command string
			  $sql = "SELECT ";
			  $sql .= "coffee_username, ";
			  $sql .= "coffee_password, ";  	  
			  $sql .= "coffee_permission "; //Last column does NOT have a comma after it.
			  $sql .= "FROM coffee_users ";
			  $sql .= "WHERE coffee_username = :username  AND coffee_password = :password";

//echo "Sql Command: " . $sql;

			  //PREPARE the SQL statement
			  $stmt = $conn->prepare($sql);
			  
			  //BIND the values to the input parameters of the prepared statement
			  $stmt->bindParam(':username', $inUsername);
			  $stmt->bindParam(':password', $inPassword);
							  			  
			  //EXECUTE the prepared statement
			  $stmt->execute();		
			  
			  //RESULT object contains an associative array
			  $stmt->setFetchMode(PDO::FETCH_ASSOC);
		  }
		  
		  catch(PDOException $e) {
			  $message = "There has been a problem. The system administrator has been contacted. Please try again later.";
		
			  error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
			  error_log($e->getLine());
			  error_log(var_dump(debug_backtrace()));
		  				
		  }
		  
		  	$row = $stmt->fetch();
			
// echo "<h1>Username: " . $row['coffee_username'] . "</h1>";
// echo "<h1>Password: " . $row['coffee_password'] . "</h1>";
// echo "<h1>Permissions: " . $row['coffee_permissions'] . "</h1>";
			
			if ($row['coffee_username'] === $inUsername)
			{
				//echo "<h1>VALID USER!!!</h1>";
				$_SESSION['validUser'] = "yes";				//this is a valid user so set your SESSION variable
				$message = "Welcome Back! $inUsername";					
			}
			else
			{
				//echo "<h1>Try again</h1>";
				//error in processing login.  Logon Not Found...
				$_SESSION['validUser'] = "no";					
                $errMessage = "Sorry, there was a problem with your username or password. Please try again.";					
			}			
		}
		else
		{
			
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Coffee Tree Login</title>

<link rel="stylesheet" href="css/events.css">

<!--  User Login Page
            
if user is valid (Session variable - already logged on)
	display admin options
else
    if form has been submitted
        Get input from $_POST
        Create SELECT QUERY
        Run SELECT to determine if they are valid username/password
        if user if valid
            set Session variable to true
            display admin options
        else
            display error message
            display login form
    else
    display login form
         
-->
</head>

<body>
<header class="title-wrapper">
    <img src="images/ring.png" alt="ring" title="ring" height="8%"/>
    <div class="centered">TheCoffeeTreeCafe
        <span class="centered-below">ADMIN SYSTEM</span>
    </div>
</header>

<?php

	if ( !empty($message) ) {
		echo "<h2>$message</h2>";	
	}
	else {
		echo "<p class='errMsg'>$errMessage</p>";	
	}
	
?>
<?php
	if ($_SESSION['validUser'] == "yes") {
?>
		<div class="admin-options">
            <h3>Admin Options:</h3>
            <nav>
                <ul class="nav-login">
                    <li><a href="setupEvent.php">Setup a New Event</a></li>
                    <li><a href="listEvents.php">Update an Event</a></li>
                    <li><a href="displayEvents.php">Display Events</a></li>
                    <li><a href="logout.php">Sign Out</a></li>	
                </ul>
            </nav>
        </div>			
<?php
	}
	else {
?>
        <h2>Please login to the Admin System</h2>
            <form method="post" class="login-form" name="loginForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <p>Username: <input name="loginUsername" type="text" /></p>
                <p>Password: <input name="loginPassword" type="password" /></p>
                <p><input class="btn" name="submitLogin" value="Login" type="submit" />
            </form>
                
<?php 
	}		
?>

<!-- <p>Return to <a href='adminIndex.php'>Admin Home</a></p> -->

</body>
</html>