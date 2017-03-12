<?php

 if($_SERVER['REQUEST_METHOD']=='GET'){
 
 $stud_id = $_GET['stud_id'];
 $subject_code = $_GET['subject_code'];
 
 require_once('dbConnect.php');
 
 $sql = "SELECT ischecked FROM enroll_handler WHERE student_id ='".$stud_id."' AND course_id ='".$subject_code."'";

 $res = mysqli_query($conn,$sql);

 $result = array();
 
 while($row = mysqli_fetch_array($res)){
		array_push($result,array(
			'isScanned'=>$row['ischecked']
		));
	}

// // if($result['isScanned'] == 1)
 echo json_encode(array("result"=>$result));
 
 mysqli_close($conn);
 
 }