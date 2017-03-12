<?php

 if($_SERVER['REQUEST_METHOD']=='GET'){
 
 $staff_id = $_GET['staff_id'];
 
 require_once('dbConnect.php');
 
 $sql = "SELECT course_id FROM course_handler WHERE staff_id ='" .$staff_id ."'";
 // $sql = "SELECT ischecked FROM enroll_handler WHERE student_id ='".$stud_id."' AND course_id ='".$subject_code."'";

 $res = mysqli_query($conn,$sql);

 $result = array();
 
 while($row = mysqli_fetch_array($res)){
 	 $studentData = "SELECT student_id, course_id FROM enroll_handler WHERE course_id = '".$row['course_id']."'";
 	 $rawResult = mysqli_query($conn,$studentData);
 	 while ($rowData = mysqli_fetch_array($rawResult)) {
 	 	array_push($result,array($rowData['student_id'] => $rowData['course_id']));
 	 }
	}
	
 echo json_encode(array("result"=>$result));
 
 mysqli_close($conn);
 
 }