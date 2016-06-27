<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demo_form";

$con = mysqli_connect($servername, $username, $password);

if (!$con) {
    die("Not connected to server");
}

if(!mysqli_select_db($con,$dbname))
{
	die("Database not selected");
}

?>