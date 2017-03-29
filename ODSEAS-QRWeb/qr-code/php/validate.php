<?php

 if($_SERVER['REQUEST_METHOD']=='GET'){
 
 $barcodeValue = $_GET['barcodeValue'];
 $student_id = $barcodeValue[0];
 $response = array();
 
 require_once('dbConnect.php');

for ($x = 1; $x < count($barcodeValue); $x++) {
    // echo json_encode($barcodeValue[$x]);
    $sql = "SELECT student_id FROM enroll_handler WHERE student_id = '$student_id' AND course_id = '$barcodeValue[$x]'";
    $result = mysqli_query($conn,$sql);
    $num_rows = mysqli_num_rows($result);
    if($num_rows == 0){
    	array_push($response, ['course_id' => $barcodeValue[$x], 'status' => 'fail']);
    	break;
    } else {
    	array_push($response, ['status' => 'success']);
    }
}
echo json_encode($response);
}
mysqli_close($conn);
?>