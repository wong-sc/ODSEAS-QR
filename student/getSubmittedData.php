<?php 

if($_SERVER['REQUEST_METHOD']=='POST'){
require_once('dbConnect.php');

$course_id = $_POST['course_id'];

$sql = "SELECT * FROM enroll_handler WHERE course_id = '".$course_id."' AND checkout_time IS NOT NULL ORDER BY student_id ASC";

$r = mysqli_query($conn,$sql);

$result = array();

while($row = mysqli_fetch_array($r))
{
	$sql2 = "SELECT * FROM student WHERE student_id = '".$row['student_id']."'";
	$r2 = mysqli_query($conn,$sql2);

	while ($row2 = mysqli_fetch_array($r2)) 
	{
		 array_push($result,array(
        'student_id'=>$row['student_id'],
        'student_name'=>$row2['student_name']));
    }
}

echo json_encode($result);

mysqli_close($conn);
}
?>