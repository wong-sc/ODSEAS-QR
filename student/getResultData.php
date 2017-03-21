<?php

 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 $course_id  = $_POST['course_id'];
 //$stud_id = $_GET['stud_id'];
 require_once('dbConnect.php');
 
 $sql = "SELECT student_id FROM enroll_handler WHERE course_id ='".$course_id."' AND ischecked ='0'";
 $res = mysqli_query($conn,$sql);
 
 $rowss = array();
 
 while ($row = mysqli_fetch_array($res)) {
    $student_id = $row['student_id'];
	//echo $stud_id;

	$sql2= "SELECT student_name FROM student WHERE student_id =".$student_id;
    
	$result = mysqli_query($conn,$sql2);

	$row_gid = mysqli_fetch_assoc($result);
	array_push($rowss,array(
		'student_id'=>$row[0],
		'student_name'=>$row_gid['student_name']));
}
echo json_encode(array("result"=>$rowss));
mysqli_close($conn);
 
 }