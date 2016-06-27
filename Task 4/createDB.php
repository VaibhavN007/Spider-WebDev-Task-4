<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Bulletin_Board_01";
$con = mysqli_connect($servername,$username,$password);

if(!$con){
	die("Connection failed: ".mysqli_connect_error());
}

$createDB = "CREATE DATABASE $dbname";

if(mysqli_query($con,$createDB)){
	echo "Database created successfully";
}
else{
	echo "Error creating databse: ".mysqli_error($con);
}

if(!mysqli_select_db($con,$dbname))
	echo nl2br("\nDatabase could not be selected");
else{
	
$createTB1 = "CREATE TABLE `spiderusers` (
 `id` int(100) NOT NULL AUTO_INCREMENT,
 `name` varchar(255) NOT NULL,
 `username` varchar(255) NOT NULL,
 `password` varchar(255) NOT NULL,
 `email` varchar(255) NOT NULL,
 `accessLevel` varchar(10) DEFAULT 'viewer',
 PRIMARY KEY (`id`),
 UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1
";

$createTB2 = "CREATE TABLE `posts` (
 `post_no` int(255) NOT NULL AUTO_INCREMENT,
 `message` varchar(255) NOT NULL,
 `user_id` int(100) NOT NULL,
 `name` varchar(255) NOT NULL,
 `date` datetime NOT NULL,
 PRIMARY KEY (`post_no`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1
";

if(mysqli_query($con,$createTB1))
{
	echo nl2br("\nTable spiderusers created successfully");
}
else
{
	echo nl2br("\nError creating table: ".mysqli_error($con));
}

if(mysqli_query($con,$createTB2))
{
	echo nl2br("\nTable posts created successfully\nWill redirect you to index in 5 seconds");
}
else
{
	echo nl2br("\nError creating table: ".mysqli_error($con));
}

echo "<script>window.setTimeout(function(){location.replace('index.php')},5000)</script>";
}
mysqli_close($con);
?>