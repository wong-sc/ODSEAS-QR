<?php
error_reporting(0);
require 'Connection/Connections.php';

$subject_code = "";
$subject_name = "";

function getPosts(){
	$posts = array();
	$posts[0] = $_POST['subject_code'];
	$posts[1] = $_POST['subject_name'];
	return $posts;
}

if(isset($_POST['search'])){
	$data = getPosts();
	
	$search_Query = "SELECT subject_code, subject_name FROM subject_data WHERE subject_code = '$data[0]'";
	
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
	$insert_Query = "INSERT INTO `subject_data`(`subject_code`, `subject_name`) VALUES ('$data[0]','$data[1]')";
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
	$update_Query = "UPDATE `subject_data` SET `subject_code`='$data[0]',`subject_name`='$data[1]' WHERE `subject_code` = '$data[0]'";
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

<!DOCTYPE Html>
<html>
	<head>
		<title>PHP insert update delete</title>
	</head>
	<body>
		<form action="testgettingresult.php" method="post">
			<input type="text" name="subject_code" placeholder="subject code" value="<?php echo $subject_code; ?>"><br><br>
			<input type="text" name="subject_name" placeholder="subject name" value="<?php echo $subject_name; ?>"><br><br>
			<div>
				<input type="submit" name="insert" value="Add">
				<input type="submit" name="update" value="Update">
				<input type="submit" name="delete" value="Delete">
				<input type="submit" name="search" value="Find">
			</div>
		</form>
	</body>
		

</html>