<?php 
$servername = "localhost:3307"; 
$dbusername = "root"; 
$dbpassword = "";
$dbName = "bus_booking";


// Create connection 
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbName); 

// Check connection
 if (!$conn) { 
 	die("Connection failed" . mysqli_connect_error()); 
 }

?>