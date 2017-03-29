<?php

 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 $student_id = $_POST['student_id'];
 $course_id = $_POST['course_id'];
 
 require_once('dbConnect.php');
 
 $sql = "SELECT ischecked FROM enroll_handler WHERE student_id ='".$student_id."' AND course_id ='".$course_id."'";

 $res = mysqli_query($conn,$sql);

 $result = array();
 
 while($row = mysqli_fetch_array($res)){
		array_push($result,array(
			'ischecked'=>$row['ischecked']
		));
	}

// // if($result['isScanned'] == 1)
 echo json_encode($result);
 
 mysqli_close($conn);
 
 }