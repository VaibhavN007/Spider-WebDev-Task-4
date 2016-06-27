<?php

session_start();
include_once "connect.php";

if(isset($_SESSION['user'])==1)
{
	header("Location: posts.php");
}

?>
<html>
<head>
<title>Spider Task 4</title>
<style>
#login_form
{
 margin-top:50px;
}
table
{
 border:solid 1px #4d88ff;
 padding:25px;
 box-shadow: 2px 2px 3px #4d88ff;
 border-radius:40px;
}
table tr,td
{
 padding:15px;
}
table tr td input
{
 width:100%;
 height:45px;
 border:solid 1px #e1e1e1;
 border-radius:40px;
 color:#0055ff;
 padding-left:20px;
 font-family:Verdana, Geneva, sans-serif;
 font-size:16px;
 background:#f9f9f9;
 box-shadow: 1px 0px 2px #f8f8f8;
}
table tr td input:active{
	position:relative;
	top:2px;
}
table tr td input:focus{
	outline:none;
	border:1px solid #f8f8f8;
	box-shadow:1px 1px 3px #4d88ff;
}
table tr td button
{
 width:100%;
 height:45px;
 border:0px;
 background:#4d88ff;
 border-radius:40px;
 box-shadow: 1px 1px 1px rgba(1,0,0,0.2);
 color:#f9f9f9;
 font-family:Verdana, Geneva, sans-serif;
 font-size:18px;
 font-weight:bolder;
}

table tr td button:active
{
 position:relative;
 top:2px;
 outline:none;
}

table tr td a
{
 text-decoration:none;
 color:#00a2d1;
 font-family:Verdana, Geneva, sans-serif;
 font-size:18px;
}
</style>

</head>

<body>
<center>
<div id="login_form">


<form method="post">

<table align="center" width="30%" border="0">

<tr>
	<td>
		<input type="text" name="username" placeholder="Username" required autofocus />
	</td>
</tr>

<tr>
	<td>
		<input type="password" name="pass" placeholder="Password" required />
	</td>
</tr>

<tr>
	<td>
		<button type="submit" name="login_button">LOGIN</button>
	</td>
</tr>

<tr>
	<td style="text-align:center;">
		<a href="signup.php" >Sign Up Here</a>
	</td>
</tr>

</table>

</form>

<?php

if(isset($_POST['login_button']))
{
	$user = mysqli_real_escape_string($con,$_POST['username']);
	$pass = mysqli_real_escape_string($con,$_POST['pass']);

	$result = mysqli_query($con,"SELECT id,password FROM spiderusers WHERE username='".$user."'");
	$row=mysqli_fetch_row($result);

	if($row[1]==sha1($pass))
	{
		$_SESSION['user'] = $row[0];
		header("Location: posts.php");
	}
	else
	{
	?>
		<script>alert('Wrong details');</script>
	<?php
	}

}
?>

</div>
</center>
</body>
</html>