<?php

session_start();

if(isset($_SESSION['user'])=="")
{
	header("Location: index.php");
}

include_once "connect.php";

$user_id = $_SESSION['user'];
$name="";
$user="";
$userType="";

if($result = mysqli_query($con,"SELECT * FROM spiderusers WHERE id=$user_id"))
{

	while($row = mysqli_fetch_row($result))
	{
		$name = $row[1];
		$user = $row[2];
		$userType = $row[5];
		
	}
	
}
else
{
	?><script>alert('You have been logged out!');</script><?php
	session_destroy();
	unset($_SESSION['user']);  
}



?>
<html>
<head>
<title>Spider Posts</title>
<style>

p{
	margin:0;
	padding:0;
	display:inline;
}

table
{
 border:solid 1px #4dff4d;
 padding:25px;
 box-shadow: 2px 2px 3px #33ff33;
 border-radius:40px;
}
table tr,td
{
 padding:15px;
 font-family:Verdana, Geneva, sans-serif;
 font-size:16px;
 color:#000000;
}





.delete
{
 height:45px;
 border:solid 1px #e1e1e1;
 border-radius:40px;
 color:#0055ff;
 padding-left:20px;
 padding-right:20px;
 margin-top:7px;
 background:#4d88ff;
 font-family:Verdana, Geneva, sans-serif;
 font-size:16px;
 background:#f9f9f9;
 box-shadow: 1px 0px 2px #f8f8f8;
}

.delete:active{
	position:relative;
	top:2px;
	outline:none;
}
.delete:focus{
	outline:none;
	border:1px solid #f8f8f8;
	box-shadow:1px 1px 3px #4d88ff;
}



#admin_panel,#add_post_btn,#logout
{
 cursor:pointer;
 width:250px;
 margin-top:10px;
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

#admin_panel:active,#add_post_btn:active,#logout:active
{
 position:relative;
 top:2px;
 outline:none;
}
#admin_panel:focus,#add_post_btn:focus,#logout:focus
{
	outline:none;
}

table tr td a
{
 text-decoration:none;
 color:#00a2d1;
 font-family:Verdana, Geneva, sans-serif;
 font-size:18px;
}

.sender{
	font-size:14px;
	color:#5f5f5f;
}
.message{
	font-size:21px;
	margin-left:15px;
	margin-right:15px;
	font-family:Bookman old style,Georgia;
}
hr{
	height:0px;
	box-shadow:0px 0px 5px #07fdfd;
}
textarea{
	
	width:350px;
	
	overflow:hidden;
	
	padding:20px;
	outline:none;
	resize:none;
	border:solid 1px #e1e1e1;
	border-radius:40px;
	color:#0055ff;
	font-family:Verdana, Geneva, sans-serif;
	font-size:16px;
	background:#f9f9f9;
	box-shadow: 1px 0px 2px #f8f8f8;
	
}


</style>
</head>

<body>
<script>
window.onresize = function(){
	var x = window.innerWidth;
	x=x-200;
	document.getElementById('logout').style="background-color:red;width:150px;margin-left:"+x+"px";
};
window.onload =function(){
	var x = window.innerWidth;
	x=x-200;
	document.getElementById('logout').style="background-color:red;width:150px;margin-left:"+x+"px";
};

</script>
<button id="logout" onclick="location.replace('logout.php')">LOGOUT</button>
<br><br>
<center>

<table>
<tr>
	<th style="color:#4d88ff;border-bottom:1px solid #4d88ff;color:#0a36de">
		<h3>Hello <?php echo $name;?></h3>
		<h3>Welcome to Spider posts</h3>
	</th>
<tr>
<tr>
	<td>
	<form name="addPost_form" method="post">
		<center>
		<textarea name="message" id="post_text" placeholder="Your message here" rows=1 onkeyup="adjustHeight(this)"></textarea>
		<br>
		<input type="submit" name="add" id="add_post_btn" value="Add Post"/>
		<br>
		<button id="admin_panel" name="admin_panel">Admin Panel</button>
		</center>
	</form>
	
	</td>


<?php

if($userType=='admin'){
	echo "<script>
		document.getElementById('post_text').style.display='visible';
		document.getElementById('admin_panel').style.display='visible';
		document.getElementById('add_post_btn').style.display='visible';
	</script>";
}
else if($userType=='editor'){
	echo "<script>
		document.getElementById('post_text').style.display='visible';
		document.getElementById('admin_panel').style.display='none';
		document.getElementById('add_post_btn').style.display='visible';
	</script>";
}
else{
	echo "<script>
		document.getElementById('post_text').style.display='none';
		document.getElementById('admin_panel').style.display='none';
		document.getElementById('add_post_btn').style.display='none';
	</script>";
}

/*$no_of_posts = 0;
$result = "";
$row=[];

if($result = mysqli_query($con,"SELECT COUNT(*) FROM spiderusers"))
{
	while($row=mysqli_fetch_row($result))
	{
		$no_of_posts = $row[0];
	}
}*/
$no_of_rows=0;
$rowCount="";
$count = [];

if($rowCount = mysqli_query($con,"SELECT COUNT(*) FROM posts")){
	while($count = mysqli_fetch_row($rowCount)){
		$no_of_rows = $count[0];
	}
}
if($no_of_rows==0){
	echo "<tr>
				<td>
					<hr/>
						<span class='message'>No posts to show</span>
				</td>
			</tr>";
}

$message_sender = "";
$message = "";
$post_id="";
$post_date;

if($result = mysqli_query($con,"SELECT message,name,post_no,date FROM posts ORDER BY date DESC")){
	
	while($row = mysqli_fetch_array($result))
	{
		$message = $row['message'];
		$message_sender = $row['name'];
		$post_id = $row['post_no'];
		$post_date = $row['date'];
		$rowid = "row".$post_id;
		
		if($userType=='admin')
			echo "<tr id='$rowid'>
			<td>
				<hr/>
					<span class='sender'><b>$message_sender</b> added a post</span>
					<br>
					<span class='sender' text-align='right'>$post_date</span>
					<br><br>
					<span class='message'>$message</span>
					<br>
					<button class='delete' onclick='getConfirmation($post_id)'>Delete post</button>
					
					<form name='delete_form' method='post' action=''>
					
						<input type='hidden' name='delete_this_post' value='$post_id'/>
						
						<input type='submit' id='$post_id' name='deletePost' style='display:none;' />
					
					</form>
					<br>
			</td>
		</tr>";
		else
			echo "<tr>
				<td>
					<hr/>
						<span class='sender'><b>$message_sender</b> added a post</span>
						<br>
						<span class='sender' text-align='right'>$post_date</span>
						<br><br>
						<span class='message'>$message</span>
				</td>
			</tr>";
	}
	
}

if(isset($_POST['deletePost'])){
	
	$delete_sql = "DELETE FROM posts WHERE post_no=".$_POST['delete_this_post'];
	
	echo "<script>console.log('$delete_sql');</script>";
	if(!mysqli_query($con,$delete_sql))
		echo "<script>alert('Could not delete this post');</script>";
	else
		echo "<script>location.replace('posts.php');</script>";
	
}

if(isset($_POST['add'])){
	
	$input_message =  mysqli_real_escape_string($con,$_POST['message']);
	
	$add_sql = "INSERT INTO posts(message,user_id,name,date) VALUES('$input_message','$user_id','$name',now())";
	if($input_message!="" || $input_message!=null ){
		
		if(!mysqli_query($con,$add_sql))
			echo "<script>alert('Could not add the post');</script>";
		else{
			echo "<script>location.replace('posts.php');</script>";
		}
	}
		
	
}

if(isset($_POST['admin_panel']))
{
	if($userType=='admin')   //just a quick check on userType
	{
		$_SESSION['user_type'] = 'admin';
		echo "<script>location.replace('admin_panel.php');</script>";
	}
	
}

?>
<script>

function getConfirmation(postid){
	
	var really = confirm("Confirm delete this post");
	
	var rowId = "row"+postid;
	
	if(really)
	{
		document.getElementById(postid).click();
		
	}
	
}
function adjustHeight(elmt){
	elmt.style.height = "1px";
	elmt.style.height = (15+elmt.scrollHeight)+"px";
	//console.log(location.protocol+"//"+location.hostname+location.pathname);
}

</script>
<br>

</table>


</center>
</body>

</html>