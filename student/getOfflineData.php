<?php

require_once('dbConnect.php');
$staff_id = $_GET['staff_id'];

$getAllData = "SELECT * FROM staff WHERE staff_id = '". $staff_id ."'";

$rowData = mysqli_query($conn,$getAllData);

$result = array();
$relatedStaff = array();

// while($row = mysqli_fetch_array($rowData)){
// 	$getStaffInviCourse = "SELECT * FROM course_handler WHERE staff_id = '". $row['staff_id']."'";
// 	$rowData2 = mysqli_query($conn,$getStaffInviCourse);
// 	while ($row2 = mysqli_fetch_array($rowData2)) {
// 		array_push($relatedStaff, array($row2['']));
// 	}
	
// }

// $row = mysqli_fetch_array($rowData);
// array_push($result, array('staff' => $row));
// $i = 0;
// while($i < count($row)){
// 	echo count($row);
// 	$
// }

 while($row = mysqli_fetch_assoc($rowData)){
 	// array_push($result, array('staff' => $row));
		$getStaffInviCourse = "SELECT * FROM course_handler WHERE staff_id = '". $row['staff_id']."'";
		$rowData2 = mysqli_query($conn,$getStaffInviCourse);
		// array_push($result, array());
		while ($row2 = mysqli_fetch_assoc($rowData2)) {
			$getCourse = "SELECT * FROM course WHERE course_id = '". $row2['course_id']."'";
			$rowData3 = mysqli_query($conn, $getCourse);
			while ($row3 = mysqli_fetch_assoc($rowData3)) {
				$getCourseHandler = "SELECT * FROM enroll_handler WHERE course_id = '". $row3['course_id']."'";
				$rowData4 = mysqli_query($conn, $getCourseHandler);
				while ($row4 = mysqli_fetch_assoc($rowData4)) {
					array_push($result, array(
						'staff' => $row,
						'course_handler' => $row2,
						'course' => $row3,
						'enroll_handler' => $row4
						));
				}
			}
		}
	}

 // echo json_encode(array($result));
echo json_encode(array("result" => $result));
 
 mysqli_close($conn);

?>