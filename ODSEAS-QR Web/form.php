<?php require 'Connection/Connections.php';?>


<?php
if(!empty($_POST['Generate']))
{
	//$name = $_POST['name'];
	//$mobile	= $_POST['mobile'];
	//$email = $_POST['email'];
	//$staff_id = $_POST['staff_id'];

	$data = explode(" ", $_POST['subject_code']);
	$subject_code = $data[0];
	
	
	require("fpdf/fpdf.php");
	
	$pdf = new FPDF();
	$pdf -> AddPage();

	// Logo
	$pdf->Image('ODSEAS-QR-images/logo.jpg',20,8,25);

	$pdf -> Cell(8,25,"",0,1);
	
	$pdf -> SetFont("Arial","B",16);
	$pdf -> Cell(0,15,"Student Examination Attendance Report UNIMAS session 2015/2016",1,1,'C');

	$pdf -> SetFont("Arial","",14);
	$pdf -> Cell(80,15," Subject Code :",1,0);
	$pdf -> Cell(0,15," ".$subject_code,1,1);
	
	//search subject name query
	$search_Query = "SELECT subject_name FROM subject_data WHERE subject_code = '$subject_code'";
	$search_Result = mysqli_query($conn, $search_Query);
	if($search_Result)
	{
		if(mysqli_num_rows($search_Result))
		{
			while($row = mysqli_fetch_array($search_Result))
			{
				$subject_name = $row['subject_name'];	
				//echo $stud_name;		
			}
		}else{
			echo 'no data';
		}
	}
	
	$pdf -> Cell(80,15," Subject Name :",1,0);
	$pdf -> Cell(0,15," ".$subject_name,1,1);
	
	//search subject exam date
	$search_date_Query = "SELECT subject_date FROM subject_data WHERE subject_code = '$subject_code'";
	$search_date_Result = mysqli_query($conn, $search_date_Query);
	if($search_date_Result)
	{
		if(mysqli_num_rows($search_date_Result))
		{
			while($row = mysqli_fetch_array($search_date_Result))
			{
				$subject_date = $row['subject_date'];	
				//echo $stud_name;		
			}
		}else{
			echo 'no data';
		}
	}
	
	$pdf -> Cell(80,15," Date :",1,0);
	$pdf -> Cell(0,15," ".$subject_date,1,1);
	
	//search subject exam location
	$search_location_Query = "SELECT subject_location FROM subject_data WHERE subject_code = '$subject_code'";
	$search_location_Result = mysqli_query($conn, $search_location_Query);
	if($search_location_Result)
	{
		if(mysqli_num_rows($search_location_Result))
		{
			while($row = mysqli_fetch_array($search_location_Result))
			{
				$subject_location = $row['subject_location'];	
				//echo $stud_name;		
			}
		}else{
			echo 'no data';
		}
	}
	
	$pdf -> Cell(80,15," Location :",1,0);
	$pdf -> Cell(0,15," ".$subject_location,1,1);
	
	//search total student query
	$search_total_query = "SELECT student_id FROM enroll_handler WHERE course_id ='".$subject_code."'";
	$search_total_result = mysqli_query($conn,$search_total_query);
 	$total_num = mysqli_num_rows($search_total_result);
	
	$pdf -> Cell(80,15," Number of Students :",1,0);
	$pdf -> Cell(0,15," ".$total_num,1,1);
	
	//search attendance query
	$search_attended_query = "SELECT stduent_id FROM enroll_handler WHERE course_id ='".$subject_code."' AND ischecked ='1'";
	$search_attended_result = mysqli_query($conn,$search_attended_query);
	$attended_num = mysqli_num_rows($search_attended_result);
	
	$pdf -> Cell(80,15," Attendance :",1,0);
	$pdf -> Cell(0,15," ".$attended_num,1,1);
	
	//calculate percentage
	$percentage = $attended_num / $total_num * 100;
	//percentage in two decimal places
	$percen_two_decimal = number_format($percentage,2,'.','');
	
	$pdf -> Cell(80,15," Percentage of attendance :",1,0);
	$pdf -> Cell(0,15," ".$percen_two_decimal."%",1,1);
	
	//calculate number of absentee
	$absentee_num = $total_num - $attended_num;
	
	$pdf -> Cell(80,15," Absentee :",1,0);
	$pdf -> Cell(0,15," ".$absentee_num,1,1);
	$pdf -> SetFont("Arial","",11);
		
	//array of student absent
		$sql = "SELECT student_id FROM enroll_handler WHERE course_id ='".$subject_code."' AND ischecked='0'";
		$res = mysqli_query($conn,$sql);
		
		$i = 1;
		while ($row = mysqli_fetch_array($res)) {
		
			$pdf -> Cell(10,10," ".$i,1,0);
			
			$pdf -> Cell(15,10," ".$row['student_id'],1,0);
			
			$sql2= "SELECT student_name FROM student WHERE student_id =".$row['student_id'];
    
			$result = mysqli_query($conn,$sql2);

			$row_gid = mysqli_fetch_assoc($result);
			
			$pdf -> Cell(0,10," ".$row_gid['student_name'],1,1);
			$i++;
		}	
		
		
	$pdf -> SetFont("Arial","",14);
	$pdf -> Cell(80,15," ",0,1);
	$pdf -> Cell(80,15," Attended :",1,0);
	$pdf -> Cell(0,15," ".$attended_num,1,1);
	$pdf -> SetFont("Arial","",11);
		
	//array student attended
		$sql_attended = "SELECT student_id FROM WHERE course_id ='".$subject_code."' AND ischecked ='1'";
		$res_attended = mysqli_query($conn,$sql_attended);
		 
		
		$j = 1;
		while ($row = mysqli_fetch_array($res_attended)) {
		
			$pdf -> Cell(10,10," ".$j,1,0);
			
			$pdf -> Cell(15,10," ".$row['student_id'],1,0);
			
			$sql2= "SELECT student_name FROM student WHERE student_id =".$row['student_id'];
    
			$result = mysqli_query($conn,$sql2);

			$row_gid = mysqli_fetch_assoc($result);
			
			$pdf -> Cell(0,10," ".$row_gid['student_name'],1,1);
			$j++;
		}
		
	
	$pdf -> output('',$subject_code.'_Attendance_Report.pdf');
}
?>