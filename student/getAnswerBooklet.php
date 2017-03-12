<?php

 if($_SERVER['REQUEST_METHOD']=='GET'){
 
 $subject_code = $_GET['subject_code'];
 
 require_once('dbConnect.php');
 
 // $sql = "SELECT student_id FROM enroll_handler WHERE course_id ='".$subject_code."' AND ischecked ='1'";
 $sql = "SELECT * FROM attendance WHERE course_id='".$subject_code."' AND checkout_time IS NOT NULL";

 $res = mysqli_query($conn,$sql);

 $result = array();
 $num_rows = mysqli_num_rows($res);
 array_push($result,
	array('booklet'=>$num_rows));

 echo json_encode(array("result"=>$result));
 
 mysqli_close($conn);
 
 }
 ?>