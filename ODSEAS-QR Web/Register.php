<?php
require 'Connection/Connections.php';
?>
<?php
	if(isset($_POST['Register'])) {
	//if($_SERVER['REQUEST_METHOD']=='POST'){
		session_start();
		$staff_id = $_POST['staff_id'];
		$staff_password = $_POST['staff_password'];
		$staff_email = $_POST['staff_email'];
	
		$sql = $conn -> query("INSERT INTO staff_data (staff_id,staff_password,staff_email) VALUES ('$staff_id','$staff_password','$staff_email')");
		
		header('Location: Login.php');
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="seas-css/Master.css" rel= "stylesheet" type="text/css"/>
<link href="seas-css/Menu.css" rel= "stylesheet" type="text/css"/>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SEAS Register</title>
<style type="text/css">
<!--
.style1 {font-size: 72px}
-->
</style>
</head>

<body>
	<form id="form1" name="form1" method="post" action="">
    </form>
	<div class="Container">
		<div class="Header style1">
		  <div align="left"></div>
		</div>
		<div class="Menu">
			<div id="Menu">
 				<nav>
					<ul class="cssmenu">
		
  	  				  <li><a href="#">Register *</a></li>	
  	    		
  	  				  <li><a href="Login.php">Login</a></li>	
  	    
					</ul>
				</nav>
		  </div>
		</div>
		<div class="LeftBody"></div>
		
		  <div class="RightBody"><br>
		    <form id="RegisterForm" name="RegisterForm" method="post" action="">
				<div class="FormElement">
				  <input name="staff_id" type="text" required="required" class="TField" id="staff_id" placeholder= "Staff ID"/>
				</div>
				
				<div class="FormElement">
				  <input name="staff_email" type="text" required="required" class="TField" id="staff_email" placeholder= "Email"/>
				</div>
				<div class="FormElement">
				  <input name="staff_password" type="password" required="required" class="TField" id="staff_password" placeholder= "Password"/>
				</div>
				<div class="FormElement">
				  <label>
				  <input name="Register" type="submit" class="button" value="Register" />
				  </label>
				</div>
            </form>
	      </div>
		  <div class="Footer">
		</div>
	</div>
</body>
</html>
