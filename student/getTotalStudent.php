<?php

 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 $course_id  = $_POST['course_id'];
 
 require_once('dbConnect.php');
 
 $sql = "SELECT student_id FROM enroll_handler WHERE course_id ='".$course_id."'";
 
  $res = mysqli_query($conn,$sql);
 
 //$res = mysqli_fetch_array($r);
 
 $result = array();
 $num_rows = mysqli_num_rows($res);
 //echo "$num_rows\n";
 
 /*
 while($row = mysqli_fetch_array($res)){
	array_push($result,
	array('stud_id'=>$row[0]
 )
 );
 }*/
array_push($result,
	array('total'=>$num_rows));

 echo json_encode(array("result"=>$result));
 
 mysqli_close($conn);
 
 }