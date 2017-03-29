<?php
// load the 'fpdf' extension
require('fpdf/fpdf.php');



// create a simple pdf document to prove this is very well possible: 
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello Image!');
$pdf->Image('http://localhost/ODSEAS-QR/ODSEAS-QR Web/qr-code/php/qr_img.php?d=35770',60,30,90,0,'PNG');
$pdf->Output();