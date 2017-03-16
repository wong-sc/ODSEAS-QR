<?php 

if($_SERVER['REQUEST_METHOD']=='POST'){
require_once('dbConnect.php');  

$staff_id = $_POST['staff_id'];

$sql = "SELECT * FROM course_handler JOIN course ON course_handler.course_id = course.course_id WHERE course_handler.staff_id ='". $staff_id. "'";

$r = mysqli_query($conn,$sql);

$result = array();

while($row = mysqli_fetch_array($r))
{
   $sql2 = "SELECT * FROM venue_handler JOIN venue ON venue_handler.venue_id = venue.venue_id WHERE venue_handler.course_id ='". $row['course_id']."'";
    
    $r2 = mysqli_query($conn, $sql2);

    while($row2 = mysqli_fetch_array($r2))
    {
            array_push($result,array(
            'course_id'=>$row['course_id'],
            'course_name'=>$row['course_name'],
            'student_number' =>$row['student_number'],
            'exam_date'=>$row['exam_date'],
            'start_time'=>$row['start_time'],
            'end_time'=>$row['end_time'],
            'venue_name' => $row2['venue_name']));
    }        
}

echo json_encode(array('result'=>$result));

mysqli_close($conn);
}

?>