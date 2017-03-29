<?php

if($_SERVER['REQUEST_METHOD']=='POST'){

	$studentData = $_POST['student_data'];
	$data = json_decode($studentData);
	foreach($data as $json){
		$sql = "UPDATE enroll_handler WHERE staff_id = '$staff_id' AND staff_password = '$staff_password'";
		$json->enroll_handler_id;
	}
	// echo json_encode($data);
	echo json_encode($data);
	// $staff_id = $_GET['staff_id'];
	// $staff_password = $_GET['staff_password'];
	
	// require_once('dbConnect.php');
	
	// $sql = "SELECT * FROM staff WHERE staff_id = '$staff_id' AND staff_password = '$staff_password'";
	
	// $result = mysqli_query($conn,$sql);
	
	// $check = mysqli_fetch_array($result);
	// // echo "hello";
	// // echo $check['staff_id'];
	
	// if(isset($check)){
	// echo ['status' => 'Successfully Login', 'staff_id' => $check['staff_id']];
	// }else {
	// echo ['status' => 'Fail to Login'];
	// }
	/*[{"enroll_handler_id":"1","student_id":"44648","course_id":"TMN2053","ischecked":"1","checkin_time":"2017-03-14 23:00:57","checkout_time":"2017-03-14 23:01:19","status":"0","created_date":"2017-03-14 23:01:19","updated_date":"2017-03-14 23:01:19"},{"enroll_handler_id":"2","student_id":"44648","course_id":"TMC1214","ischecked":"0","checkin_time":"null","checkout_time":"null","status":"0","created_date":"2017-03-11 14:58:56","updated_date":"2017-03-11 14:58:56"},{"enroll_handler_id":"3","student_id":"44571","course_id":"TMN2053","ischecked":"1","checkin_time":"2017-03-15 01:40:30","checkout_time":"2017-03-27 15:11:35","status":"0","created_date":"2017-03-27 15:11:35","updated_date":"2017-03-27 15:11:35"},{"enroll_handler_id":"4","student_id":"44571","course_id":"TMC1214","ischecked":"0","checkin_time":"null","checkout_time":"null","status":"0","created_date":"2017-03-12 16:58:54","updated_date":"2017-03-12 16:58:54"},{"enroll_handler_id":"5","student_id":"41123","course_id":"TMN2053","ischecked":"1","checkin_time":" time('now') ","checkout_time":" time('now') ","checkin_staffID":"null","checkout_staffID":"null","status":"0","created_date":"2017-03-13 15:20:47","updated_date":"2017-03-13 15:20:47"},{"enroll_handler_id":"6","student_id":"41853","course_id":"TMN2053","ischecked":"1","checkin_time":" time('now') ","checkout_time":"2017-03-27 10:08:32","checkin_staffID":"1","checkout_staffID":"1","status":"0","created_date":"2017-03-14 22:57:49","updated_date":"2017-03-14 22:57:49"},{"enroll_handler_id":"7","student_id":"40840","course_id":"TMN2053","ischecked":"1","checkin_time":"2017-03-13 15:48:01","checkout_time":"2017-03-13 15:49:01","status":"0","created_date":"2017-03-13 15:49:01","updated_date":"2017-03-13 15:49:01"},{"enroll_handler_id":"8","student_id":"44375","course_id":"TMN2053","ischecked":"0","checkin_time":"null","checkout_time":"null","status":"0","created_date":"2017-03-12 16:58:14","updated_date":"2017-03-12 16:58:14"},{"enroll_handler_id":"9","student_id":"42682","course_id":"TMN2053","ischecked":"1","checkin_time":"2017-03-13 15:49:08","checkout_time":"2017-03-13 15:49:15","status":"0","created_date":"2017-03-13 15:49:15","updated_date":"2017-03-13 15:49:15"}]*/
}

?>