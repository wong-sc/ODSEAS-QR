<?php 

if($_SERVER['REQUEST_METHOD']=='POST'){

	$student_id = $_POST['student_id'];
	require_once('dbConnect.php');

	// $result = array();

	// array_push($result,array(
	// 		'stud_name'=>$$stud_id
	// 	));

	// return json_encode(array('result'=>$result));
	
	$sql = "SELECT student_name FROM student WHERE student_id ='".$student_id."'";

	$r = mysqli_query($conn,$sql);

	$result = array();

	while($row = mysqli_fetch_array($r)){
		array_push($result,array(
			'student_name'=>$row['student_name']
		));
	}

	echo json_encode(array('result'=>$result));

	mysqli_close($conn);
}
?>