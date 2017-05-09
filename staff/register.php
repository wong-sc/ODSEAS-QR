<?php
 
if($_SERVER['REQUEST_METHOD']=='POST'){
$staff_id = $_POST['staff_id'];
$staff_password = $_POST['staff_password'];
$staff_email = $_POST['staff_name'];

require_once('dbConnect.php');
$sql = "INSERT INTO staff (staff_id,staff_password,staff_name) VALUES ('$staff_id','$staff_password','$staff_name')";
if(mysqli_query($conn,$sql)){
echo "Successfully Registered";
}else{
echo "Could not register";
}
}else{
echo 'error';
}