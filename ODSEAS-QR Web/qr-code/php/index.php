<?php require "dbConnect.php";?>
<?php
session_start();

if(isset($_SESSION["staff_id"])){
}else{
	header('Location: ../../Login.php');
}
// set id to session
if(isset($_POST['EnterNumber'])) {
	$_SESSION['id'] = $_POST['student_id'];
}
// get data from db
$sql = "SELECT * FROM course";
$result = mysqli_query($conn,$sql);
$obID = [];
$obNm =[];
while ($row = $result->fetch_object()) {
	array_push($obID, $row->course_id);
	array_push($obNm, $row->course_name);					
}
$ID = implode(',',$obID);
$name =   implode(',',$obNm);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link href="../../seas-css/Master.css" rel= "stylesheet" type="text/css"/>
		<link href="../../seas-css/Menu.css" rel= "stylesheet" type="text/css"/>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>SEAS Generate QR Code</title>
		<style type="text/css">
		<!--
		.style1 {font-size: 72px}
		-->
		</style>
	</head>

	<body>
		<div class="Container">
			<div class="Header style1">
			  <div align="left"></div>
			</div>
			<div class="Menu">
				<div id="Menu">
	 				<nav>
						<ul class="cssmenu">
			
						  <li><a href="../../viewAttendance.php">View Attendance</a></li>	
						  <li><a href="../../Edit.php">Edit SEAS</a></li>	
	  	    		  	  <li><a href="#">Generate QR Code *</a></li>	
						  <li><a href="../../Logout.php">Logout</a></li>
	  	    
						</ul>
					</nav>
			  </div>
			</div>
			<div class="LeftBody">
				<br>
				
					<div class="FormElement">
						<input name="stud_id" type="text" class="TField" id="stud_id" placeholder= "Student ID" />
					</div>
					<div class="FormElement">
						<input name='numSub' type='number' class="TField" id='numSub'placeholder= "Number of Subjects Taken (max=10)" min='1' max='10' />
					</div>
					<div class="FormElement">
						<label>
							<button onclick="createField()">Enter</button>
						</label>
					</div>
					<div class="FormElement" id='dynamicDiv'>
						<br>
						
					</div>
					<br>
			
			</div>
			
				<div class="RightBody">
				
					<form action="../../ExamSlipform.php" method="post">
		  
		  			<br><br>
					<input type="hidden" name="codeid" id="codeid"  value="<?php echo $ID;?>"></input>
					<input type="hidden" name="name" id="name"  value="<?php echo $name;?>"></input>
					<input type="hidden" name="selected" id="selected"  value=""></input>
					<div id="barcode"></div>
					<div id="studentid"></div>
					<div id="subjects"></div>
					
					<div class="FormElement">
				  	<label id="generateBtn">
				  	
				  	</label>
		  			</div>

		  			</form>
					
				</div>
				<div class="Footer">
	        </div>
		</div>

		<script type="text/javascript">
	        function getbarcode(){
		        var bcArray = [];
		        var barcodeVar;
		        bcArray[0] = document.getElementById('stud_id').value; 
		        console.log(bcArray);
		        var length = document.getElementsByTagName('select').length; 
		        for(var i=1; i<=length; i++){
		            var e  = document.getElementById('subject_code'+i);
		            bcArray[i] = e.options[e.selectedIndex].value;
		        }
				document.getElementById('selected').value = bcArray;
		        var arraylen = bcArray.length;
		        for(var j=0; j< arraylen; j++){
		            if(j== 0){
		             barcodeVar = bcArray[j];
		            }
		            else{
		             barcodeVar = barcodeVar + '+' + bcArray[j];
		            }
		        }   
		        document.getElementById('barcode').innerHTML = "";
	            var elem = document.createElement("img"); 
	            elem.setAttribute("src", "qr_img.php?d="+barcodeVar);  
	            document.getElementById("barcode").appendChild(elem);
				var studidP = document.createElement("p"); 
				var node = document.createTextNode("Student ID: "+bcArray[0]);
				studidP.appendChild(node);
				document.getElementById("studentid").appendChild(studidP);
				//document.getElementById("studentid").innerHTML= bcArray[0];
				for(var j=1; j< arraylen; j++){
					var subP = document.createElement("p"); 
					var node = document.createTextNode("Subject "+j+": "+bcArray[j]);
					subP.appendChild(node);
					document.getElementById("subjects").appendChild(subP); 
		        }
				var generateBtn = document.createElement("input");
				generateBtn.setAttribute("type", "submit");
				generateBtn.setAttribute("class", "button");
				generateBtn.setAttribute("value", "Generate Report");
				document.getElementById("generateBtn").appendChild(generateBtn); 
				//document.write(barcodeVar);
	        };
	        function createField(){
				$checked=false;
	        	document.getElementById('barcode').innerHTML = "";
	            document.getElementById('dynamicDiv').innerHTML = "";
	            var loop = document.getElementById('numSub').value;
				if(loop >10){
					alert('Subject number cannot be more than 10.');
				}
				else{
	            var codeArr = document.getElementById('codeid').value.split(",");
	            var subArr = document.getElementById('name').value.split(",");
	            var size = codeArr.length;
	            for(var i=1; i<=loop; i++){
					$checked=true;
	            	var elem = document.createElement("select"); 
		            elem.setAttribute("id", "subject_code"+i);  
		            document.getElementById('dynamicDiv').appendChild(elem);
		            for(var j=0; j<size; j++){
		            	var option = document.createElement("option");
		            	option.setAttribute("value", codeArr[j]);
		            	option.text = codeArr[j]+" "+subArr[j];
						document.getElementById("subject_code"+i).add(option); 
		            }
		            var br = document.createElement("br");
		            document.getElementById('dynamicDiv').appendChild(br);
					var br = document.createElement("br");
		            document.getElementById('dynamicDiv').appendChild(br);							
	            }
			
				if($checked==true){
	            	var button = document.createElement("button"); 
		            button.setAttribute("onclick", "getbarcode()");  
		            var t = document.createTextNode("Generate");       // Create a text node
					button.appendChild(t); 
		            document.getElementById('dynamicDiv').appendChild(button);
				}
				else{
					alert('Please enter a number.');
				}
				$checked=false;
				}
	        };
	    </script>
	</body>
</html>


