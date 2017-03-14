<?php 

if($_SERVER['REQUEST_METHOD']=='POST'){
    $staff_id = $_POST['staff_id'];
    $sql = "SELECT * FROM course_handler JOIN course ON course_handler.course_id = course.course_id WHERE course_handler.staff_id ='". $staff_id. "'";

    require_once('dbConnect.php');

    $r = mysqli_query($conn,$sql);

    $result = array();

    while($row = mysqli_fetch_array($r)){
        $sql2 = "SELECT * FROM venue_handler JOIN venue ON venue_handler.venue_id = venue.venue_id WHERE venue_handler.course_id ='". $row['course_id']."'";
        $r2 = mysqli_query($conn, $sql2);
        while($row2 = mysqli_fetch_array($r2)){
            array_push($result,array(
            'subject_code'=>$row['course_id'],
            'subject_name'=>$row['course_name'],
            'no_students' =>$row['student_number'],
            'exam_date'=>$row['exam_date'],
            'start_time'=>$row['start_time'],
            'end_time'=>$row['end_time'],
            'venue_name' => $row2['venue_name']
        ));
    }
        
}

echo json_encode(array('result'=>$result));

mysqli_close($conn);
}

?>

<!-- SELECT * FROM `course` 
JOIN 
(
	SELECT 
    venue_handler.venue_handler_id, venue_handler.venue_id, venue_handler.course_id, 
    venue.venue_id as venueID, venue.venue_name, venue.venue_capacity 
    FROM venue_handler 
    JOIN venue 
    ON venue_handler.venue_id = venue.venue_id
) as venueH ON course.course_id = venueH.course_id
JOIN
(
	SELECT
    course_handler.staff_id, course_handler.course_id, course_handler.invigilator_position, 
    staff.staff_id as staffID, staff.staff_name
    FROM course_handler
    JOIN staff
    ON course_handler.staff_id = staff.staff_id
) as course2 ON course.course_id = course2.course_id -->