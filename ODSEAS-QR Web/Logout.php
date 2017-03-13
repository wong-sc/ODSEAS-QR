<?php require 'Connection/Connections.php';?>

<?php
session_start();

unset($_SESSION["staff_id"]);
session_destroy();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="ODSEAS-QR-css/Master.css" rel= "stylesheet" type="text/css"/>
<link href="ODSEAS-QR-css/Menu.css" rel= "stylesheet" type="text/css"/>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>You've logged out!</title>
<style type="text/css">
<!--
.style1 {font-size: 72px}
-->
</style>
</head>

<body>
	<div class="Container">
		<div class="Header style1">
		  <div align="left"></div>
		</div>
		<div class="Menu">
			<div id="Menu">
 				<nav>
					<ul class="cssmenu">
		
  	  				  <li><a href="Register.php">Register</a></li>	
  	    		
  	  				  <li><a href="Login.php">Login</a></li>	
  	    
					</ul>
				</nav>
		  </div>
		</div>
		<div align="center"><br><h1>You have logged out!</h1><br> </div>
		<div class="LeftBody"></div>
		<div class="Footer">
		  <div class="RightBody"> 
		  <br> 
		  	
		  </div>
		</div>
	</div>
</body>
</html>
