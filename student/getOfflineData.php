<?php

require_once('dbConnect.php');

$getStaffData = "SELECT * FROM staff";
$getCourseHandlerData = "SELECT * FROM course_handler";
$getCourseData = "SELECT * FROM course";
$getVenueHandlerData = "SELECT * FROM venue_handler";
$getVenueData = "SELECT * FROM venue";
$getEnrollHandlerData = "SELECT * FROM enroll_handler";
$getStudentData = "SELECT * FROM student";
$getAttendanceStyle = "SELECT * FROM take_attendance_style";

$rawStaff = mysqli_query($conn,$getStaffData);
$rawCourseHandler = mysqli_query($conn, $getCourseHandlerData);
$rawCourse = mysqli_query($conn, $getCourseData);
$rawVenueHandler = mysqli_query($conn, $getVenueHandlerData);
$rawVenue = mysqli_query($conn, $getVenueData);
$rawEnrollHandler = mysqli_query($conn, $getEnrollHandlerData);
$rawStudent = mysqli_query($conn, $getStudentData);
$rawStyle = mysqli_query($conn, $getAttendanceStyle);

$result = array();

$staffArray = array();
$course_handlerArray = array();
$courseArray = array();
$venue_handlerArray = array();
$venueArray = array();
$enroll_handlerArray = array();
$studentArray = array();
$styleArray = array();

//select the staff_id
while ($row = mysqli_fetch_assoc($rawStaff)) {
	array_push($staffArray, $row);
}

while ($row2 = mysqli_fetch_assoc($rawCourseHandler)) {
	array_push($course_handlerArray, $row2);
}

while ($row3 = mysqli_fetch_assoc($rawCourse)) {
	array_push($courseArray, $row3);
}

while ($row4 = mysqli_fetch_assoc($rawVenueHandler)) {
	array_push($venue_handlerArray, $row4);
}

while ($row5 = mysqli_fetch_assoc($rawVenue)) {
	array_push($venueArray, $row5);
}

while ($row6 = mysqli_fetch_assoc($rawEnrollHandler)) {
	array_push($enroll_handlerArray, $row6);
}

while ($row7 = mysqli_fetch_assoc($rawStudent)) {
	array_push($studentArray, $row7);
}

while ($row8 = mysqli_fetch_assoc($rawStyle)) {
	array_push($styleArray, $row8);
}

$result['staff'] = $staffArray;
$result['course_handler'] = $course_handlerArray;
$result['course'] = $courseArray;
$result['venue_handler'] = $venue_handlerArray;
$result['venue'] = $venueArray;
$result['enroll_handler'] = $enroll_handlerArray;
$result['student'] = $studentArray;
$result['attendance_style'] = $styleArray;

echo json_encode($result);
 
 mysqli_close($conn);

?>