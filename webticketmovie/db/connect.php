<?php
$mysqli = mysqli_connect("localhost","root","","ticketmovie");
mysqli_query($mysqli,"SET NAMES 'UTF8'");

// Check connection
if ($mysqli -> connect_errno) {
	mysqli_query($mysqli, "SET NAME 'UTF8'");
	echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	exit();
}
?>