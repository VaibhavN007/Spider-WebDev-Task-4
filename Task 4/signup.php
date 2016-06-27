<?php
session_start();

$name="";
$user="";
$user_error="";
$pass="";
$password_error="";
$email="";
$email_error="";

if(isset($_SESSION['user'])!="")
{
 header("Location: posts.php");
}
include_once 'connect.php';

if(isset($_POST['signup_button']))
{
 $name = mysqli_real_escape_string($con,$_POST['name']);
 $user = mysqli_real_escape_string($con,$_POST['username']);
 
 if($_POST['pass']==$_POST['repass'])
	$pass = sha1(mysqli_real_escape_string($con,$_POST['pass']));
 else
	$password_error = "Passwords do not match";
 $email = mysqli_real_escape_string($con,$_POST['email']);
 	
	$see_username_email_sql = "SELECT username,email FROM spiderusers"; 
	$li_user="";
	$li_email="";
	$match=0;
	
	if($result = mysqli_query($con,$see_username_email_sql))
	{
		while($row = mysqli_fetch_assoc($result))
		{
			if($row['username']==$user)
			{
				$match++;
				$user_error = "Username already exists";
			}
				
			if($row['email']==$email)
			{
				$match++;
				$email_error = "Email already exists";
			}
		}
	}
	else{
		echo "<script>alert('error while registering you...');</script>";
		$match++;
	}
	
	
	if($match==0 && empty($password_error))
	{
		$count=0;
		
		if($res = mysqli_query($con,"SELECT COUNT(*) FROM spiderusers"))
		{
			while($row = mysqli_fetch_row($res))
			{
				$count = $row[0];
			}
		}
		if($count>0){
			if(mysqli_query($con,"INSERT INTO spiderusers(name,username,password,email) VALUES('$name','$user','$pass','$email')"))
			{
				echo "<script>alert('successfully registered');</script>";
				echo "<script>location.replace('index.php');</script>";
			}
			else
				echo "<script>alert('error while registering you...');</script>";	

		}
		else if($count==0){
			if(mysqli_query($con,"INSERT INTO spiderusers(name,username,password,email,accessLevel) VALUES('$name','$user','$pass','$email','admin')"))
			{
				echo "<script>alert('successfully registered');</script>";
				echo "<script>location.replace('index.php');</script>";
			}
			else
				echo "<script>alert('error while registering you...');</script>";
		}
	}
	
 
 
}
?>
<html>
<head>
<title>Spider Task 4</title>
<style>

.error{
	color:red;
	margin-top:2px;
}
#profile{
 color:#0055ff;
 margin-top:0px;
 padding-left:40px;
 font-family:Verdana, Geneva, sans-serif;
 font-size:16px;
 
}
p{
	margin:0;
	padding:0;
	display:inline;
}
#signup_form
{
 margin-top:5px;
}
table
{
 border:solid 1px #4dff4d;
 padding:25px;
 box-shadow: 2px 2px 3px #33ff33;
 border-radius:40px;
}
img{
	margin-top:20px;
	margin-left:110px;
	margin-right:100px;
}
#profile_data{
	padding:18px;
	border:1px solid #e2e2e2;
	background:#f9f9f9;
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
#uploadImg	{
	display:none;
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

<div id="signup_form">

<form method="post">

<table align="center" width="30%" border="0">
<tr>
	<td>
		<input type="text" name="name" placeholder="Name" value="<?php echo $name;?>" required autofocus/>
	</td>
</tr>
<tr>
	<td>
		<input type="text" name="username" placeholder="Username" value="<?php echo $user;?>" required/>
		<span class='error'><?php echo $user_error;?></span>
	</td>
</tr>
<tr>
	<td>
		<input type="password" name="pass" placeholder="Password" required />
	</td>
</tr>
<tr>
	<td>
		<input type="password" name="repass" placeholder="Re-enter Password" required />
		<span class='error'><?php echo $password_error;?></span>
	</td>
</tr>
<tr>
	<td>
		<input type="email" name="email" placeholder="Email Address" value="<?php echo $email;?>" required />
		<span class='error'><?php echo $email_error;?></span>
	</td>
</tr>
<tr>
	<td>
		<button  style="margin-top:20;" type="submit" name="signup_button">Sign Me Up</button>
	</td>
</tr>
<tr>
	<td style="text-align:center;">
		<a href="index.php">Login Here</a>
	</td>
</tr>

</table>

</form>

</div>

</center>
</body>
</html>