<?php require 'Connection/Connections.php';?>

<?php
session_start();

if(isset($_SESSION["staff_id"])){
}else{
	header('Location: Login.php');
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="seas-css/Master.css" rel= "stylesheet" type="text/css"/>
<link href="seas-css/Menu.css" rel= "stylesheet" type="text/css"/>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SEAS View Attendance</title>
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
		
					  <li><a href="#">View Attendance *</a></li>	
					  <li><a href="Edit.php">Edit SEAS</a></li>	
  	    		  	  <li><a href="qr-code/php/index.php">Generate QR Code</a></li>	
					  <li><a href="Logout.php">Logout</a></li>
  	    
					</ul>
				</nav>
		  </div>
		</div>
		<div class="LeftBody"></div>
		
		  <div class="RightBody">
		  <form action="form.php" method="post">
		  
		  
		  <br>
		  <font size="5">Select Course:</font>  
		  <br>
		  <br>
		  <?php
		  		$sql = "SELECT course_id,course_name FROM course";
				$result = mysqli_query($conn,$sql);
				echo "<select id='selectList' name='course_id' onClick='showSelected(this)'>";
				while ($row = $result->fetch_object()) {
   					echo "<option value='" . $row->course_id . "'>" . $row->course_id, ' ', $row->course_name . "</option>";
				}
				echo "</select><br><br>"; 
		  ?>

		  <input type="hidden" id="course_code" name="course_id" />
		  <p>
			
		  	<div class="FormElement">
				  <label>
				  <input name="Generate" type="submit" class="button" value="Generate Report" />
				  </label>
		  	</div>
			
			
		  </form>
		  </div>
		  <div class="Footer">
		</div>
	</div>
</body>




<script type="text/javascript">

	function showSelected(thisObj)
{
 
  document.getElementById('course_id').value = thisObj.options[thisObj.selectedIndex].text;
  

}

</script>
</html>
