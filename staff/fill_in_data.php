<?php 
 require_once('dbConnect.php');
 
 for ($i=0; $i < 150; $i++) { 

 	$id = 41000 + $i;
 	$sql = "INSERT INTO 
 	 			enroll_handler (student_id, course_id, is_checked, checkin_staffID, checkout_staffID)
			 VALUES ($id, 'TMC3042',0,0,0)";

	$res = mysqli_query($conn,$sql);

 }
 
 mysqli_close($conn);
 ?>