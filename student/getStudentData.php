<?php 

if($_SERVER['REQUEST_METHOD']=='GET'){

	$stud_id = $_GET['stud_id'];
	require_once('dbConnect.php');
	
	$sql = "SELECT student_name FROM student WHERE student_id ='".$stud_id."'";

	$r = mysqli_query($conn,$sql);

	$result = array();

	while($row = mysqli_fetch_array($r)){
		array_push($result,array(
			'stud_name'=>$row['student_name']
		));
	}

	echo json_encode(array('result'=>$result));

	mysqli_close($conn);
}
?>