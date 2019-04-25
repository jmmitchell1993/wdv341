<?php
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

<!DOCTYPE html>
<html>

<head>

	<title>EVENTS</title>
	
<meta name = "description" content = "events, coffee, tree, upcoming, artist, games, shows">
<meta name = "keywords" content = "events, music, band, college, student, hangout, live, artist">  

<link rel="stylesheet" type="text/css" href="stylesheet.css">
<link rel="stylesheet" href="css/events.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style>
	
	.container {
   	position: relative;
   	text-align: center;
   	}
   	
   	.centered {
    	position: absolute;
    	top: 50%;
    	left: 50%;
    	transform: translate(-50%, -50%);
	}

	table 			{
					width: 80%;
   					border-collapse: collapse;
    					margin-left: 10%;
					}

	td 				{
					font-family: helvetica;
					font-size: 16px;
    					text-align: left;
    					border-bottom: .05em solid #ddd;
								 padding: 1.2em;
								 line-height: 1.6;
					}

	th				{
					padding: .5em;
    					text-align: left;
    					letter-spacing: .1em;
    					border-bottom: .07em solid #ddd;
    					font-size: 1.5em;
    					font-family: prada;
    					background-color: #d3d3d3;
   					color: black;
    					text-transform: lowercase;
					}

	tr:hover 		{
					background-color: #F5F5F5;
					}

	a.ticket:link, a.ticket:visited {
					font-weight: bold;
					font-size: 1em;
					letter-spacing: .1em;
					color: #ae6661;
					text-decoration: none;
					margin-left: 1%;
					} 
	
	a.ticket:hover	{
					color: #618685;
					}
	
	a.name:link, a.name:visited	{
					font-weight: bold;
					letter-spacing: .03em;
					font-size: 1em;
					color: #ae6661;
					text-decoration: none;
					line-height: 2em;
					}

	a.name:hover	{
					color: #618685;
					}

	#myBtn 			{
  					display: none;
  					position: fixed;
  					bottom: .6em;
  					right: 1em;
 					z-index: 99;
  					border: none;
  					outline: none;
  					background-color: #ae6661;
  					color: white;
  					cursor: pointer;
  					padding: .5em;
  					border-radius: .5em;
					}

	#myBtn:hover 	{
  					background-color: #618685;
					}
					
	#map 		{
        		height: 35%;
       			width: 100%;
       			border: thin solid black;
       			}
       			
       	.fa 	{
  		padding: 1%;
 		font-size: 1.5em;
  		width: 5%;
 		text-align: center;
  		text-decoration: none;
  		margin: 2% 6%;
  		box-shadow: .4em .4em .4em 0 rgba(0,0,0, .5);
		}

	.fa:hover {
    		opacity: 0.7;
		}

	.fa-facebook {
  		background: #484848;
  		color: white;
		}

	.fa-instagram {
  		background: #484848;
  		color: white;
		}

	.fa-pinterest {
  		background: #484848;
  		color: white;
		}
	</style>
	
</head>
<body>

	<aside>
	
		<a href="index.html">HOME</a>
  		<a href="about.html">ABOUT</a>
  		<a href="menu.html">MENU</a>
  		<a href="events.html">EVENTS</a>
  		<a href="contact.html">CONTACT</a>  	
			<a href="login.php">LOGIN</a>  

    	 <div id="map"></div>
	 <script>
      function initMap() {
        var uluru = {lat: 44.901768, lng: -93.063949};
        
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGBM0Z4xP4A1ytfMnZ5Y4HSPx0UyE5A2M&callback=initMap">
    </script>
 
   <p>
   <span style="text-transform: none; letter-spacing: .22em; padding-top: 4%;">604 24th St.<br /> St. Paul, Minnesota</span><Br />
   
   <span style="font-size: 1.7em; letter-spacing: .3em;">&#9743;</span> <span style="font-size: 1em; letter-spacing: .2em; padding-top: 3%;">702-971-1154</span></p>
   <Br />
   <Br />
   <br />
</aside>

<main>

	<button style="font-size: 2em;" onclick="topFunction()" id="myBtn" title="Go to top">&#8679;</button>
  
	 <header class="container">
  <img src="images/ring.png" alt="ring" title="ring" height="9%" width="9%">
  <div class="centered">Upcoming Events</div>
  </header>
  
 <table>
  <tr>
			<th>Event</th>
			<th>Description</th>
    	<th>Date</th>
    	<th>Time</th>
  </tr>
	
	<?php 
			while( $row=$stmt->fetch(PDO::FETCH_ASSOC)) {
		?>		
			
					<tr>
					
						<td><span class="evt_name"><?php echo $row['event_name']; ?></span></td>
			
						<td><span class="eventDescription"><?php echo $row['event_description']; ?></span></td>
			
						
							<td><span class="eventDate"><?php echo $row['event_date'] ?></span></td>
				
			
              <td><span class="eventTime"><?php echo $row['event_time'] ?></span></td>
        
			</tr>               
		
        <?php
			}
		?>
</table>
  
 <br />
 
 <script>

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}


function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
</script> 
  
</main>

 <footer>
   	<a href="https://www.facebook.com" class="fa fa-facebook"></a>
	<a href="https://www.instagram.com" class="fa fa-instagram"></a>
	<a href="https://www.pinterest.com" class="fa fa-pinterest"></a><br />
	<span style="bottom:0; font-family: prada; letter-spacing: .1em;">M|T|W|TR 6:00 am - 10:00 pm F|S 6:00 am - 11:00 pm S 7:00 - 9:00 pm</p>
	</footer>
     
  
</body>
</html>