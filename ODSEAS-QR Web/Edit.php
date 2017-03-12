<?php require 'Connection/Connections.php';?>

<?php
session_start();
error_reporting(0);
if(isset($_SESSION["staff_id"])){
}else{
	header('Location: Login.php');
}

$subject_code = "";
$subject_name = "";
$subject_date = "";
$subject_location = "";

function getPosts(){
	$posts = array();
	$posts[0] = $_POST['subject_code'];
	$posts[1] = $_POST['subject_name'];
	$posts[2] = $_POST['subject_date'];
	$posts[3] = $_POST['subject_location'];
	return $posts;
}
if(isset($_POST['fn0'])){
	$fn = $_POST['fn0'];
}
else if(isset($_POST['fn1'])){
	$fn = $_POST['fn1'];
}
else if(isset($_POST['fn2'])){
	$fn = $_POST['fn2'];
}
else if(isset($_POST['fn3'])){
	$fn = $_POST['fn3'];
}
else{
	$fn = "";
}
if(isset($_POST['search'])){
//echo "you at search?";
	$data = getPosts();
	
	$search_Query = "SELECT subject_code, subject_name, subject_date, subject_location FROM subject_data WHERE subject_code = '$data[0]'";
	
	$search_Result = mysqli_query($conn, $search_Query);
	//echo $data[0];
	if($search_Result)
	{
		if(mysqli_num_rows($search_Result))
		{
			while($row = mysqli_fetch_array($search_Result))
			{
				$subject_code = $row['subject_code'];
				$subject_name = $row['subject_name'];
				$subject_date = $row['subject_date'];
				$subject_location = $row['subject_location'];
			}
		}else {
			echo 'no data for this subject code';
		}
	}else {
		echo 'Result error';
	}
}

if(isset($_POST['insert'])){
	$data = getPosts();
	$insert_Query = "INSERT INTO `subject_data`(`subject_code`, `subject_name`, `subject_date`, `subject_location`) VALUES ('$data[0]','$data[1]','$data[2]','$data[3]')";
	try{
		$insert_Result = mysqli_query($conn, $insert_Query);
		
		if($insert_Result)
		{
			if(mysqli_affected_rows($conn) > 0)
			{
				echo 'Data Inserted';
			} else {
				echo 'Data Not Inserted';
			}
		}
	} catch (Exception $ex) {
		echo 'Error Insert '.$ex->getMesage();
	}
}

if(isset($_POST['delete'])){
//echo 'are you here';
	$data = getPosts();
	$delete_Query = "DELETE FROM `subject_data` WHERE `subject_code` = '$data[0]'";
	try{
		$delete_Result = mysqli_query($conn, $delete_Query);
		
		if($delete_Result)
		{
			if(mysqli_affected_rows($conn) > 0)
			{
				echo 'Data Deleted';
			} else {
				echo 'Data Not Deleted';
			}
		}
	} catch (Exception $ex) {
		echo 'Error Delete '.$ex->getMesage();
	}
}

if(isset($_POST['update'])){
//echo 'are you here';
	$data = getPosts();
	$update_Query = "UPDATE `subject_data` SET `subject_code`='$data[0]',`subject_name`='$data[1]',`subject_date`='$data[2]',`subject_location`='$data[3]' WHERE `subject_code` = '$data[0]'";
	try{
		$update_Result = mysqli_query($conn, $update_Query);
		
		if($update_Result)
		{
			if(mysqli_affected_rows($conn) > 0)
			{
				echo 'Data Updated';
			} else {
				echo 'Data Not Updated';
			}
		}
	} catch (Exception $ex) {
		echo 'Error Update '.$ex->getMesage();
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="seas-css/Master.css" rel= "stylesheet" type="text/css"/>
<link href="seas-css/Menu.css" rel= "stylesheet" type="text/css"/>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SEAS Edit</title>
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
		
					  <li><a href="viewAttendance.php">View Attendance</a></li>	
					  <li><a href="#">Edit SEAS *</a></li>	
  	    		  	  <li><a href="qr-code/php/index.php">Generate QR Code</a></li>	
					  <li><a href="Logout.php">Logout</a></li>
  	    
					</ul>
				</nav>
			</div>
		</div>
		<div class="CenterBody" onload="gethidden()">
		<input type="hidden" id="hiddenFormName" value="<?php echo $fn?>">
		<select id="selectForm">
		  <option value="0">Search</option>
		  <option value="1">Add</option>
		  <option value="2">Update</option>
		  <option value="3">Delete</option>
		</select>
		<button onClick="showForm()">Submit</button>
		<br>
		<form action="Edit.php" method="post" id="addForm">
		<br>
			<br>
		<font size="4.5">Add new subject:</font>  
			<div class="FormElement">
				<input type="text" required="required" class="TField" name="subject_code" placeholder="Subject Code" >
			</div>
			<div class="FormElement">
				<input type="text" required="required" class="TField" name="subject_name" placeholder="Subject Name" >
			</div>
			<div class="FormElement">
				<input type="text" required="required" class="TField" name="subject_date" placeholder="Exam Date Eg. 2016-01-01" >
			</div>
			<div class="FormElement">
				<input type="text" required="required" class="TField" name="subject_location" placeholder="Exam Location" >
			</div>
			<input type="hidden" class="TField" name="fn1" id="fn1" value="">
			<div class="FormElement">
				<label>
					<button name="insert" type="submit">Add</button>
				</label>
			</div>
		</form>	
		<form action="Edit.php" method="post" id="deleteForm">
		<br>
			<br>
		<font size="4.5">Delete Subject:</font> 
			<div class="FormElement">
			<?php
		  		$sql = "SELECT * FROM subject_data";
				$result = mysqli_query($conn,$sql);
				echo "<select id='selectList' name='subject_code' onClick='showSelected(this)'>";
				while ($row = $result->fetch_object()) {
   					echo "<option value='" . $row->subject_code . "'>" . $row->subject_code, ' ', $row->subject_name . "</option>";
				}
				echo "</select><br><br>"; 
			?>
			</div>
			<input type="hidden" id="subject_code_delete" name="subject_code_delete" />
			<input type="hidden" class="TField" name="fn3" id="fn3" value="">
			<button name="delete" type="submit">Delete</button>

		</form>
		
			<br>
			<form action="Edit.php" method="post" id="searchForm">
			<br>
			<br>
			<font size="4.5">Search Subject Information:</font>  
				<div class="FormElement">
					<input type="text" class="TField" required="required" name="subject_code" placeholder="Subject Code">
				</div>
				<input type="hidden" class="TField" name="fn0" id="fn0" value="">
						<button name="search" type="submit">Search</button>
				
				<div class="FormElement">
					<font size="4"><?php echo "Subject Code: ".$subject_code; ?></font>  
				<br>
					<font size="4"><?php echo "Subject Name: ".$subject_name; ?></font>
				<br>
					<font size="4"><?php echo "Exam Date: ".$subject_date; ?></font>
				<br>
					<font size="4"><?php echo "Exam Location: ".$subject_location; ?></font>
				</div>
				<br>
				
				<br>


			</form>
			<form action="Edit.php" method="post" id="updateForm">
			<br>
			<br>
			<font size="4.5">Update Subject:</font> 
			
				<div class="FormElement">
				<?php
					$sql = "SELECT * FROM subject_data";
					$result = mysqli_query($conn,$sql);
					echo "<select id='selectList' name='subject_code' onClick='showUpdateSelected(this)'>";
					while ($row = $result->fetch_object()) {
						echo "<option value='" . $row->subject_code . "'>" . $row->subject_code, ' ', $row->subject_name . "</option>";
					}
					echo "</select><br><br>"; 
				?>
				</div>
				<input type="hidden" id="subject_code_update" name="subject_code_update" />
				
				<button name="search" type="submit">Choose</button>
				<div class="FormElement">
					<input type="text" class="TField" name="subject_code_update" placeholder="Subject Code" value="<?php echo $subject_code; ?>">
				</div>
				<div class="FormElement">
					<input type="text" class="TField" name="subject_name" placeholder="Subject Name" value="<?php echo $subject_name; ?>">
				</div>
				<div class="FormElement">
					<input type="text" class="TField" name="subject_date" placeholder="Exam Date Eg. 2016-01-01" value="<?php echo $subject_date; ?>">
				</div>
				<div class="FormElement">
					<input type="text" class="TField" name="subject_location" placeholder="Exam Location" value="<?php echo $subject_location; ?>">
				</div>
				<input type="hidden" class="TField" name="fn2" id="fn2" value="">
				<button name="update" type="submit">Update</button>
			</form>
		</div>
		<div class="Footer">
		</div>
	</div>
</body>

<script type="text/javascript">

	function showSelected(thisObj)
{
 
  document.getElementById('subject_code_delete').value = thisObj.options[thisObj.selectedIndex].text;
  

}

	function showUpdateSelected(thisObj)
{
 
  document.getElementById('subject_code_update').value = thisObj.options[thisObj.selectedIndex].text;
  

}
function showForm(){
	var e = document.getElementById("selectForm");
	var value = e.options[e.selectedIndex].value;
	if(value == 0){
		document.getElementById("addForm").style.display = "none";
		document.getElementById("deleteForm").style.display = "none";
		document.getElementById("searchForm").style.display = "block";
		document.getElementById("updateForm").style.display = "none";
		
		document.getElementById("fn0").value = "0";
	}
	else if(value == 1){
		document.getElementById("addForm").style.display = "block";
		document.getElementById("deleteForm").style.display = "none";
		document.getElementById("searchForm").style.display = "none";
		document.getElementById("updateForm").style.display = "none";
		
		document.getElementById("fn1").value = "1";
	}
	else if(value == 2){
		document.getElementById("addForm").style.display = "none";
		document.getElementById("deleteForm").style.display = "none";
		document.getElementById("searchForm").style.display = "none";
		document.getElementById("updateForm").style.display = "block";
		
		document.getElementById("fn2").value = "2";
	}
	else if(value == 3){
		document.getElementById("addForm").style.display = "none";
		document.getElementById("deleteForm").style.display = "block";
		document.getElementById("searchForm").style.display = "none";
		document.getElementById("updateForm").style.display = "none";
		
		document.getElementById("fn3").value = "3";
	}
}
	function gethidden() {
        var fn = document.getElementById("hiddenFormName").value;
		if(fn == 0){
			document.getElementById("searchForm").style.display = "block";
		}
		else if(fn == 1){
			document.getElementById("addForm").style.display = "block";
		}
		else if(fn == 2){
			document.getElementById("updateForm").style.display = "block";
		}
		else if(fn == 3){
			document.getElementById("deleteForm").style.display = "block";
		}
    }
    window.onload = gethidden;
</script>

</html>
