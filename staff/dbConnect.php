<?php
$servername = "localhost"; //replace it with your database server name
$username = "root";  
$password = "";  
$dbname = "odseas-qr";
// Create connection
//global $conn;

$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if($conn) {
//echo "connection goodgood";
}
else {
echo "connection not success";
}
?>