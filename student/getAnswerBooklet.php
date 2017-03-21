<?php

 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 $course_id = $_POST['course_id'];
 
 require_once('dbConnect.php');
 
 // $sql = "SELECT student_id FROM enroll_handler WHERE course_id ='".$subject_code."' AND ischecked ='1'";
 $sql = "SELECT * FROM enroll_handler WHERE course_id='".$course_id."' AND checkout_time IS NOT NULL";

 $res = mysqli_query($conn,$sql);

 $result = array();
 $num_rows = mysqli_num_rows($res);
 array_push($result, array(
 	'booklet'=>$num_rows));

 echo $result[0]['booklet'];
 
 mysqli_close($conn);
 
 }
 ?>