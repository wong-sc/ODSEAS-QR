<?php

 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 $subject_code = $_POST['subject_code'];
 
 require_once('dbConnect.php');
 
 // $sql = "SELECT student_id FROM enroll_handler WHERE course_id ='".$subject_code."' AND ischecked ='1'";
 $sql = "SELECT * FROM enroll_handler WHERE course_id='".$subject_code."' AND checkin_time IS NOT NULL";

 $res = mysqli_query($conn,$sql);

 $result = array();
 $num_rows = mysqli_num_rows($res);
 array_push($result,
	array('attended'=>$num_rows));

 echo json_encode(array("result"=>$result));
 
 mysqli_close($conn);
 
 }
 ?>