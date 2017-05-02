<?php 

if($_SERVER['REQUEST_METHOD']=='POST'){
	$staff_id = $_POST['staff_id'];
	$staff_password = $_POST['staff_password'];
	
	require_once('dbConnect.php');
	
	$sql = "SELECT * FROM staff WHERE staff_id = '$staff_id' AND staff_password = '$staff_password'";
	$fetchuser = "SELECT * staff WHERE staff_id = $staff_id";
	
	$result = mysqli_query($conn,$sql);
	
	$check = mysqli_fetch_array($result);
	// echo "hello";
	// echo $check['staff_id'];
	
	if(isset($check)){
		echo json_encode(['status' => 'Successfully Login', 'staff_id' => $check['staff_id'], 'staff_name' => $check['staff_name']]);
	}else {
		echo json_encode(['status' => 'Fail to Login']);
	}
}

?>