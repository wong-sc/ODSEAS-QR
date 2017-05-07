<?php require 'qr-code/php/dbConnect.php';?>
<?php 
//get data from database


$data = explode(",", $_POST['selected']);
$dataimage = implode("+", $data);

echo $_POST['selected'];
echo "<img src='qr-code/php/qr_img.php?d=$dataimage'>";
$search_Query = "SELECT student_name FROM student WHERE student_id = $data[0]";
$search_Result = mysqli_query($conn, $search_Query);
if($search_Result)
{
	if(mysqli_num_rows($search_Result))
	{
		while($row = mysqli_fetch_array($search_Result))
		{
			$stud_name = $row['student_name'];	
			//echo $stud_name;		
		}
	}else{
		echo 'no data';
	}
}

$search_prod_code_Query = "SELECT student_major FROM student WHERE student_id = $data[0]";
$search_prod_code_Result = mysqli_query($conn, $search_prod_code_Query);
if($search_prod_code_Result)
{
	if(mysqli_num_rows($search_prod_code_Result))
	{
		while($row = mysqli_fetch_array($search_prod_code_Result))
		{
			$stud_prog = $row['student_major'];	
			//echo $stud_name;		
		}
	}else{
		echo 'no data';
	}
}

?>

<?php
//if(!empty($_POST['GenerateReport']))
//{
ob_start();
require("fpdf/fpdf.php");
class PDF extends FPDF
{

// Page header
function Header()
{
	// Logo
	$this->Image('ODSEAS-QR-images/logo.jpg',20,25,25);
	// Arial bold 15
	$this->SetFont('Arial','B',15);
	// Move to the right
	//$this->Cell(80);
	// Title
	$this -> Cell(8,19,"",0,1);
	$this -> Cell(40,8,"",0,0);
	$this->Cell(30,8,'FINAL EXAMINATION SLIP',0,1);
	$this->SetFont('Arial','b',12);
	//$this -> Cell(30,8,"",1,1);
	$this -> Cell(40,8,"",0,0);
	$this->Cell(30,8,'SEMESTER 2, SESSION 2016/2017 ',0,1);
	// Line break
	$this->Ln(10);
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Page number
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class

$pdf = new PDF();
$pdf -> AliasNbPages();
$pdf -> AddPage();
$pdf -> SetFont('Times','',12);
//$pdf -> Cell(0,15,$data[0],1,1,'C');

$pdf -> Cell(25,2,"",0,1,'C');

$pdf -> SetFillColor(0,0,0);
$pdf -> Cell(132,0.5,"",0,1,'L',true);

$pdf -> Cell(25,8,"",0,1,'C');

$pdf -> Cell(8,6,"",0,0);
$pdf -> Cell(0,6,$stud_name." (".$data[0].")",0,1);

$pdf -> Cell(8,6,"",0,0);
$pdf -> Cell(0,6,"Faculty of Computer Science and Information Technology",0,1);

//search program name query
$search_prog_name_Query = "SELECT student_major FROM student WHERE student_id = '$data[0]'";
$search_prog_name_Result = mysqli_query($conn, $search_prog_name_Query);
if($search_prog_name_Result)
{
	if(mysqli_num_rows($search_prog_name_Result))
	{
		while($row = mysqli_fetch_array($search_prog_name_Result))
		{
			$prog_name = $row['student_major'];	
			//echo $stud_name;		
		}
	}else{
		echo 'no data';
	}
}

$pdf -> Cell(8,6,"",0,0);
$pdf -> Cell(0,6,$prog_name,0,1);

//$pdf -> Image('seas-images/logo.jpg',150,60,25);
$pdf -> Image('http://localhost/ODSEAS-QR/ODSEAS-QRWeb/qr-code/php/qr_img.php?d='.$dataimage,150,22,45,0,'PNG');

$pdf -> Cell(80,10,"",0,1);

//$pdf -> SetFillColor(0,0,0);
//$pdf -> Cell(0,0.5,"",0,1,'L',true);

$pdf -> SetFont('Times','B',10);
$pdf -> Cell(5,8,"",0,0);
$pdf -> Cell(10,8,"No",1,0);
$pdf -> Cell(22,8,"Course Code",1,0);
$pdf -> Cell(80,8,"Course Name",1,0);
$pdf -> Cell(13,8,"Credit",1,0);
$pdf -> Cell(16,8,"Category",1,0);
$pdf -> Cell(0,8,"Remarks",1,1);

//$pdf -> SetFillColor(0,0,0);
//$pdf -> Cell(0,0.5,"",0,1,'L',true);

$pdf -> SetFont('Times','',10);

foreach ($data as $k => $value)
{
	if ($k <1) continue;
	
	$search_Subject_Query = "SELECT course_name FROM course WHERE course_id = '$value'";
	$search_Subject_Result = mysqli_query($conn, $search_Subject_Query);
	if($search_Subject_Result)
	{
		if(mysqli_num_rows($search_Subject_Result))
		{
			while($row = mysqli_fetch_array($search_Subject_Result))
			{
				$subject_name = $row['course_name'];
			}
		}else{
			echo 'no data';
		}
	}
	
	$search_Category_Query = "SELECT course_id FROM enroll_handler WHERE student_id = $data[0]";
	$search_Category_Result = mysqli_query($conn, $search_Category_Query);
	if($search_Category_Result)
	{
		if(mysqli_num_rows($search_Category_Result))
		{
			while($row = mysqli_fetch_array($search_Category_Result))
			{
				$stud_cc = $row['course_id'];
			}
		}else{
			echo 'no data';
		}
	}
	
	$pdf -> Cell(5,8,"",0,0);
	$pdf -> Cell(10,8,$k,1,0);
	$pdf -> Cell(22,8,$value,1,0);
	$pdf -> Cell(80,8,$subject_name,1,0);
	$pdf -> Cell(13,8,"4",1,0);
	$pdf -> Cell(16,8,$stud_cc,1,0);
	$pdf -> Cell(0,8,"",1,1);
	
}

//$pdf -> SetFillColor(0,0,0);
//$pdf -> Cell(0,0.5,"",0,1,'L',true);

$pdf -> Cell(25,10,"",0,1,'C');
$pdf ->SetFont('Times','B',11);
$pdf -> Cell(5,10,"",0,0);
$pdf -> Cell(0,10,"ATTENTION",0,1);
$pdf -> SetFont('Times','',10);
$pdf -> Cell(5,7,"",0,0);
$pdf -> Cell(0,7,"1. You are eligible to sit for final exam of registered courses only.",0,1);
$pdf -> Cell(5,7,"",0,0);
$pdf -> Cell(0,7,"2. Students without exam slips will be barred from sitting the examination.",0,1);
$pdf -> Cell(5,7,"",0,0);
$pdf -> Cell(0,7,"3. Students are not allowed to scribble anything on the examination slip.",0,1);

$pdf -> SetFont('Times','B',11);
$pdf -> Cell(0,8,"",0,1);
$pdf -> Cell(5,7,"",0,0);
$pdf -> Cell(0,7,"(This is computer generated. Signature is not required)",0,1);

$pdf -> SetFillColor(0,0,0);
$pdf -> Cell(0,2,"",0,1,'L',true);

$pdf -> Output('',$data[0].'_Examination_Slip.pdf');
ob_end_flush();	
//}
?>