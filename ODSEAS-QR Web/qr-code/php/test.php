<?php
echo "<form id='form1' name='form1' method='post' action=''>
	Matric Number:
	<input type='text' name='matricNum' id='matricNum' />
	<br/>
	Number of subjects taken:
	<input type='number' name='numSub' id='numSub' />
	<br/>
	
	<input type='submit' name='submit' id='submit' value='submit' />
	<br/>
	<br/>
	<br/>
	
	<input type='submit' name='generate' id='generate' value='generate' />
	<br/>
	Number of Subjects (between 1 and 10):
  <input type='number' name='quantity' min='1' max='10'>
  <input type='submit'>
</form>";
//$output = 

for($x = 1; $x <= numSub; $x++){
echo "Subject $x: <input type='text' name='subject$x' id='subject$x' /><br>";
}


//$output = $_POST['matricNum'];
//$output2 = $_POST['numSub'];

//echo "<img src='qr_img.php?d=$output+$output2'>";
//echo "<br/> matricNum = $output <br/> subject = $output2";

?>