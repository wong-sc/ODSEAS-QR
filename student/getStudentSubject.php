<?php

 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 $stud_id = $_POST['stud_id'];
 
 require_once('dbConnect.php');
 
 $sql = "SELECT course_id FROM enroll_handler WHERE student_id ='".$stud_id."'";

 $res = mysqli_query($conn,$sql);

 $result = array();
 
 while($row = mysqli_fetch_array($res)){
		array_push($result,array(
			'subject_code'=>$row['course_id']
		));
	}
	
 echo json_encode(array("result"=>$result));
 
 mysqli_close($conn);
 
 }
 ?>