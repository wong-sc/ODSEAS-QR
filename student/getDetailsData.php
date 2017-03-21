<?php 

require_once('dbConnect.php');

 $course_id = $_POST['course_id'];

$sql = "SELECT staff.staff_name,course_handler.invigilator_position FROM course_handler JOIN staff ON course_handler.staff_id = staff.staff_id WHERE course_handler.course_id = '$course_id' ORDER BY FIELD(invigilator_position, 'CHIEF', 'INVIGILATOR')";

$r = mysqli_query($conn,$sql);

$result = array();

while($row = mysqli_fetch_array($r)){
    array_push($result,array(
        'staff_name'=>$row['staff_name'],
        'invigilator_position'=>$row['invigilator_position']
    ));
}

echo json_encode(array('result'=>$result));

mysqli_close($conn);

?>