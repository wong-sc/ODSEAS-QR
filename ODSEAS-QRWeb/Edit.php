<?php require 'Connection/Connections.php';?>

<?php
session_start();
error_reporting(0);
if(isset($_SESSION["staff_id"])){
}else{
	header('Location: Login.php');
}

$course_id = "";
$course_name = "";
$exam_date = "";
$venue = "";

function getPosts(){
	$posts = array();
	$posts[0] = $_POST['course_id'];
	$posts[1] = $_POST['course_name'];
	$posts[2] = $_POST['exam_date'];
	$posts[3] = $_POST['venue'];
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
	echo($data[0]);
	
	$search_Query = "SELECT 
						course.course_id, course.course_name, exam_date, venue.venue_name 
						FROM course JOIN venue_handler ON course.course_id = venue_handler.course_id 
						JOIN (SELECT venue.venue_name, venue.venue_id FROM venue 
						JOIN venue_handler ON venue_handler.venue_id = venue.venue_id) as venue 
						ON venue.venue_id = venue_handler.venue_id WHERE course.course_id = '$data[0]'";
	
	$search_Result = mysqli_query($conn, $search_Query);
	var_dump(mysqli_fetch_array($search_Result));
	//echo $data[0];
	if($search_Result)
	{
		if(mysqli_num_rows($search_Result))
		{
			while($row = mysqli_fetch_array($search_Result))
			{
				$course_id = $row['course_id'];
				$course_name = $row['course_name'];
				$exam_date = $row['exam_date'];
				$venue = $row['venue'];
			}
		}else {
			echo 'no data for this course';
		}
	}else {
		echo 'Result error';
	}
}

if(isset($_POST['insert'])){
	$data = getPosts();
	$insert_Query = "INSERT INTO `course`(`course_id`, `course_name`, `exam_date`, `venue`) VALUES ('$data[0]','$data[1]','$data[2]','$data[3]')";
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
	$delete_Query = "DELETE FROM `course` WHERE `course_id` = '$data[0]'";
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
	$update_Query = "UPDATE `course` SET `course_id`='$data[0]',`course_name`='$data[1]',`exam_date`='$data[2]',`venue`='$data[3]' WHERE `course_id` = '$data[0]'";
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
<link href="ODSEAS-QR-css/Master.css" rel= "stylesheet" type="text/css"/>
<link href="ODSEAS-QR-css/Menu.css" rel= "stylesheet" type="text/css"/>
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
		<font size="4.5">Add new course:</font>  
			<div class="FormElement">
				<input type="text" required="required" class="TField" name="course_id" placeholder="Course Code" >
			</div>
			<div class="FormElement">
				<input type="text" required="required" class="TField" name="course_name" placeholder="Course Name" >
			</div>
			<div class="FormElement">
				<input type="text" required="required" class="TField" name="exam_date" placeholder="Exam Date Eg. 2016-01-01" >
			</div>
			<div class="FormElement">
				<input type="text" required="required" class="TField" name="venue" placeholder="Venue" >
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
		<font size="4.5">Delete Course:</font> 
			<div class="FormElement">
			<?php
		  		$sql = "SELECT * FROM course";
				$result = mysqli_query($conn,$sql);
				echo "<select id='selectList' name='course_id' onClick='showSelected(this)'>";
				while ($row = $result->fetch_object()) {
   					echo "<option value='" . $row->course_id . "'>" . $row->course_id, ' ', $row->course_name . "</option>";
				}
				echo "</select><br><br>"; 
			?>
			</div>
			<input type="hidden" id="course_id_delete" name="course_id_delete" />
			<input type="hidden" class="TField" name="fn3" id="fn3" value="">
			<button name="delete" type="submit">Delete</button>

		</form>
		
			<br>
			<form action="Edit.php" method="post" id="searchForm">
			<br>
			<br>
			<font size="4.5">Search Course Information:</font>  
				<div class="FormElement">
					<input type="text" class="TField" required="required" name="course_id" placeholder="Course Code">
				</div>
				<input type="hidden" class="TField" name="fn0" id="fn0" value="">
						<button name="search" type="submit">Search</button>
				
				<div class="FormElement">
					<font size="4"><?php echo "Course Code: ".$course_id; ?></font>  
				<br>
					<font size="4"><?php echo "Course Name: ".$course_name; ?></font>
				<br>
					<font size="4"><?php echo "Exam Date: ".$exam_date; ?></font>
				<br>
					<font size="4"><?php echo "Venue: ".$venue; ?></font>
				</div>
				<br>
				
				<br>


			</form>
			<form action="Edit.php" method="post" id="updateForm">
			<br>
			<br>
			<font size="4.5">Update Course:</font> 
			
				<div class="FormElement">
				<?php
					$sql = "SELECT * FROM course";
					$result = mysqli_query($conn,$sql);
					echo "<select id='selectList' name='course_id' onClick='showUpdateSelected(this)'>";
					while ($row = $result->fetch_object()) {
						echo "<option value='" . $row->course_id . "'>" . $row->course_id, ' ', $row->course_name . "</option>";
					}
					echo "</select><br><br>"; 
				?>
				</div>
				<input type="hidden" id="course_id_update" name="course_id_update" />
				
				<button name="search" type="submit">Choose</button>
				<div class="FormElement">
					<input type="text" class="TField" name="course_id_update" placeholder="Course Code" value="<?php echo $course_id; ?>">
				</div>
				<div class="FormElement">
					<input type="text" class="TField" name="course_name" placeholder="Course Name" value="<?php echo $course_name; ?>">
				</div>
				<div class="FormElement">
					<input type="text" class="TField" name="exam_date" placeholder="Exam Date Eg. 2016-01-01" value="<?php echo $exam_date; ?>">
				</div>
				<div class="FormElement">
					<input type="text" class="TField" name="venue" placeholder="Exam Location" value="<?php echo $venue; ?>">
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
 
  document.getElementById('course_id_delete').value = thisObj.options[thisObj.selectedIndex].text;
  

}

	function showUpdateSelected(thisObj)
{
 
  document.getElementById('course_id_update').value = thisObj.options[thisObj.selectedIndex].text;
  

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
