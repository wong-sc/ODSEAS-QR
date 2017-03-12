<?php 

if($_SERVER['REQUEST_METHOD']=='POST'){
	$staff_id = $_POST['staff_id'];
	$staff_password = $_POST['staff_password'];
	
	require_once('dbConnect.php');
	
	$sql = "SELECT * FROM staff WHERE staff_id = '$staff_id' AND staff_password = '$staff_password'";
	
	$result = mysqli_query($conn,$sql);
	
	$check = mysqli_fetch_array($result);
	
	if(isset($check)){
	echo 'Successfully Login';
	}else {
	echo 'Fail to Login';
	}
}

?>