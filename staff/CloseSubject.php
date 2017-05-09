<?php 

if($_SERVER['REQUEST_METHOD']=='POST'){

	$course_id = $_POST['course_id'];
	
	require_once('dbConnect.php');
	
	$sql = "UPDATE course SET status = 1 WHERE course_id = '$course_id'";
	
	if (mysqli_query($conn, $sql)) {
    	echo "success";
    } else {
    	echo "fail";
    }
}

?>