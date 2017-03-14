<?php 

if($_SERVER['REQUEST_METHOD']=='POST'){
require_once('dbConnect.php');

$courseCode = $_POST['subject_code'];

$sql = "SELECT * FROM enroll_handler WHERE course_id = '".$courseCode."' AND checkout_time IS NOT NULL";

$r = mysqli_query($conn,$sql);

$result = array();

while($row = mysqli_fetch_array($r))
{
	$sql2 = "SELECT * FROM student WHERE student_id = '".$row['student_id']."'";
	$r2 = mysqli_query($conn,$sql2);

	while ($row2 = mysqli_fetch_array($r2)) 
	{
		 array_push($result,array(
        'matricno'=>$row['student_id'],
        'studentname'=>$row2['student_name']));
    }
}

echo json_encode(array('result'=>$result));

mysqli_close($conn);
}
?>