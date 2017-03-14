<?php

 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 $subject_code  = $_POST['subject_code'];
 //$stud_id = $_GET['stud_id'];
 require_once('dbConnect.php');
 
 $sql = "SELECT student_id FROM enroll_handler WHERE course_id ='".$subject_code."' AND ischecked ='0'";
 $res = mysqli_query($conn,$sql);
 
 $rowss = array();
 
 while ($row = mysqli_fetch_array($res)) {
    $stud_id = $row['student_id'];
	//echo $stud_id;

	$sql2= "SELECT student_name FROM student WHERE student_id =".$stud_id;
    
	$result = mysqli_query($conn,$sql2);

	$row_gid = mysqli_fetch_assoc($result);
	array_push($rowss,
	array('stud_id'=>$row[0],'stud_name'=>$row_gid['student_name']
 )

);
}
echo json_encode(array("result"=>$rowss));
//print json_encode($rowss);
 
	/*
	$row_gid = mysqli_fetch_array($result);
    if ($row_gid == TRUE){

        $sl_dise = mysqli_query($conn,"SELECT Diseases_type, id FROM diseases WHERE id = '$diseases_id'");

        while($r = mysqli_fetch_assoc($row_gid)) {
            $rowss[] = $r;
        }
    }*/

 
 
 //$sql2 = "SELECT stud_name FROM student_data WHERE stud_id ='".$stud_id."'";
 
 /*
 $sql = "SELECT stud_id FROM student_subject WHERE subject_code ='".$subject_code."' AND isScanned ='0'";
 //$sql .= "SELECT stud_name FROM student_data WHERE stud_id ='35770'";
 $res = mysqli_query($conn,$sql);

 $result = array();
 //$num_rows = mysqli_num_rows($res);
 //echo "$num_rows Rows\n";
 
 while($row = mysqli_fetch_array($res)){
	array_push($result,
	array('stud_id'=>$row[0],
	'stud_name'=>$row[1]

 )
 );
 }
 
 
 
 echo json_encode(array("result"=>$result));
 */
 mysqli_close($conn);
 
 }