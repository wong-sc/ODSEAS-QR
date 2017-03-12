<?php require 'Connection/Connections.php';?>

<?php
	if(isset($_POST['Login'])) {
	
		$staff_id = $_POST['staff_id'];
		$staff_password = $_POST['staff_password'];
		
		$result = $conn -> query("select * from staff where staff_id='$staff_id' AND staff_password='$staff_password'");
		
		$row = $result -> fetch_array(MYSQLI_BOTH);
		
		session_start();
		
		$_SESSION["staff_id"] = $row['staff_id'];
		
		header('Location: ViewAttendance.php');
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="seas-css/Master.css" rel= "stylesheet" type="text/css"/>
<link href="seas-css/Menu.css" rel= "stylesheet" type="text/css"/>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SEAS Login</title>
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
  	    		
  	  				  <li><a href="#">Login *</a></li>	
  	    
					</ul>
				</nav>
		  </div>
		</div>
		<div class="LeftBody"></div>
		
		  <div class="RightBody"><br>
		  	<form name="Login" method="post" action="">
				<div class="FormElement">
				  <input name="staff_id" type="text" required="required" class="TField" id="staff_id" placeholder= "Staff ID"/>
				</div>
				
				<div class="FormElement">
				  <input name="staff_password" type="password" required="required" class="TField" id="staff_password" placeholder= "Password"/>
				</div>
				
				<div class="FormElement">
				  <label>
				  <input name="Login" type="submit" class="button" value="Login" />
				  </label>
				</div>
			</form>
		  </div>
		  <div class="Footer">
		</div>
	</div>
</body>
</html>
