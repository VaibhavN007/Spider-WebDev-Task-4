<?php

session_start();

if(isset($_SESSION['user'])=="")
{
	header("Location: index.php");
}

if(isset($_SESSION['user_type'])!="admin")
{
	header("Location: posts.php");
}

include_once "connect.php";

$user_id = $_SESSION['user'];
$name="";
$user="";
$access_level="";

if($result = mysqli_query($con,"SELECT * FROM spiderusers WHERE id=$user_id"))
{

	while($row = mysqli_fetch_row($result))
	{
		$name = $row[1];
		$user = $row[2];
		$access_level = $row[5];
		
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
<title>Admin Panel</title>
<style>
table
{
 border:solid 1px #00dcff;
 padding:25px;
 box-shadow: 2px 2px 3px #00dcff;
 border-radius:40px;
}
table tr,td
{
 padding:15px;
 font-family:Verdana, Geneva, sans-serif;
 font-size:16px;
 color:#000000;
}
table tr th{
	width:230px;
	font-size:18px;
	border-right:3px solid #00dcff;
	
}
.check{
	width:100px;
}
input[type=submit],#logout,#Bulletin_board
{
 width:200px;
 height:45px;
 margin-top:10px;
 border:0px;
 cursor:pointer;
 background:#4d88ff;
 border-radius:40px;
 box-shadow: 1px 1px 1px rgba(1,0,0,0.2);
 color:#f9f9f9;
 font-family:Verdana, Geneva, sans-serif;
 font-size:18px;
 font-weight:bolder;
 
}
input[type=submit]:active,#logout:active,#Bulletin_board:active
{
 position:relative;
 top:2px;
 outline:none;
}
input[type=submit]:focus,#logout:focus,#Bulletin_board:focus
{
	outline:none;
}

.dropbtn{
	background-color:#21dc09;
	width:150px;
	color:white;
	padding:16px;
	font-size:16px;
	border:none;
	corsor:pointer;
	border-radius:30px;
}
.dropbtn:hover{
	background-color:#1cff00;
}
.dropbtn:focus{
	outline:none;
}
.dropbtn:active{
	outline:none;
}
.dropdown{
	position:static;
	display:inline-block;
}
.dropdown-content{
	position:absolute;
	margin-left:26px;
	display:none;
	background-color:#e3e3e3;
	width:100px;
}
.dropdown-content button{
	border:none;
	width:100px;
	color:black;
	padding:12px 16 px;
	position:relative;
	height:30px;
	font-size:19px;
	padding-top:4px;
	font-family:Georgia, Geneva, sans-serif;
}
.dropdown-content button:hover {
	background-color:#ffbc00;
}

</style>
</head>

<body>
<center>

<button id="Bulletin_board" onclick="location.replace('posts.php')">Bulletin Board</button>
<br>
<form name='delete_form' method='post'>
<input type='hidden' name='checked_users'/>
<input name='delete_users' type='submit' value='Delete Selected'/>
</form>

<table>
<tr>
	<th class="check">
		select
	</th>
	
	<th>
		Name
	</th>
	
	<th>
		Username
	</th>
	
	<th>
		Access Level
	</th>
	
	<th style="border-right:none;">
		Change Access Level
	</th>
</tr>

<?php

if($result = mysqli_query($con,"SELECT id,name,username,accessLevel FROM spiderusers ORDER BY id")){
	
	while($row = mysqli_fetch_array($result))
	{
		$li_name = $row['name'];
		$li_username = $row['username'];
		$li_accessLevel = $row['accessLevel'];
		$li_id = $row['id'];
		$drop_id = 'drop'.$li_id;
		
		if($li_accessLevel == 'admin')
		echo "<tr class='spacer'></tr>
			<tr id='$li_id' style='margin-top=100px'>
			<td class='check'>
				
			</td>
			<td>
				<center><b>$li_name</b></center>
			</td>
			<td>
				<center><b>$li_username</b></center>
			</td>
			<td>
				<center><b>$li_accessLevel</b></center>
			</td>
			<td>
				
			</td>
			</tr>";
		
		else 
		echo "<tr id='$li_id'>
			<td class='check'>
				<center><input type='checkbox' name='users[]' onclick='add()' class='user_checkboxes' value='$li_id'></center>
			</td>
			<td>
				<center>$li_name</center>
			</td>
			<td>
				<center>$li_username</center>
			</td>
			<td>
				<center>$li_accessLevel</center>
			</td>
			<td style='border-right:none;'>
				<center>
				<div class='dropdown'>
					<button class='dropbtn' onclick='showMenu(this)'>Change</button>
					
					<div class='dropdown-content' id='$drop_id'>
						<button onclick='getConfirmation(this)' value='admin'>admin</button>
						<button onclick='getConfirmation(this)' value='editor'>editor</button>
						<button onclick='getConfirmation(this)' value='viewer'>viewer</button>
					</div>
					
				</div>
				
				</center>
			</td>
			</tr>";
	}
	
}

?>

</table>

<form method="post" name="cng_access">
<input type="hidden" name="userID"/>
<input type="hidden" name="newAccessLevel"/>
<input type="submit" name="confirmed" style="display:none;"/>
</form>

<button id="logout" onclick="location.replace('logout.php')" style="background-color:#ff0000">LOGOUT</button>

</center>

<script>
/*
<div class='dropdown' id='$drop_id'>
					<button class='dropbtn'>Change Access Level</button>
					<div class='dropdown-content'>
						<p>admin</p>
						<p>editor</p>
						<p>viewer</p>
					</div>
				
				</div>
*/

function add(){
document.delete_form.checked_users.value=null;
var checkedValues = [];

var count=0;

var inputElements = document.getElementsByClassName('user_checkboxes');

if(inputElements){
	for(var i=0;inputElements[i];i++)
	{
		if(inputElements[i].checked){
			checkedValues[count] = inputElements[i].value;
			count++;
		}
	}
}
console.log(count);

if(count!=0){
	
	for(var k=0;k<count;k++){
		document.delete_form.checked_users.value+=checkedValues[k]+",";
	}

}
else
	document.delete_form.checked_users.value=null;





/*
if(checkedValues){
for(var j=0;checkedValues[j];j++){
	document.delete_form.checked_users.value+="--"+checkedValues;
	
}
*/
}

function showMenu(o){
	var parent_id = o.parentElement.parentElement.parentElement.parentElement.id;
	var drop_id = 'drop'+parent_id;
	if(drop_id)
	{
		document.getElementById(drop_id).style.display='block';
		document.getElementById(drop_id).onmouseover = function()
		{
			document.getElementById(drop_id).style.display='block';
			o.style='background-color:#1cff00';
		}
		document.getElementById(drop_id).onmouseout = function(){
			document.getElementById(drop_id).style.display='none';
			o.style='background-color:#21dc09';
		}
	}
	//console.log(o.parentNode.parentNode.parentNode.parentNode.nodeName);
}

function getConfirmation(o){
	var really = confirm('Confirm changing access level to '+o.value);
	if(really){
		document.cng_access.userID.value=o.parentElement.parentElement.parentElement.parentElement.parentElement.id;
		document.cng_access.newAccessLevel.value=o.value;
		document.cng_access.confirmed.click();
	}
}


</script>

<?php

if(isset($_POST['delete_users'])){
	
	$values = $_POST['checked_users'];
	$values_array=[];
	
	if($values){
		
		$values = substr($values,0,strlen($values)-1);
			
		$values_array = explode(',',$values);
		
		$i=0;
		
		$delete_sql = '';
		
		while($i<sizeOf($values_array)){
			//echo nl2br($values_array[$i]."\n");
			
			$access_level_sql = "SELECT accessLevel from spiderusers WHERE id=".$values_array[$i];
			$access_level_user;
			
			$result1=null;
			$row1="";
			
			if($result1 = mysqli_query($con,$access_level_sql)){
				
				while($row1 = mysqli_fetch_row($result1))
					$access_level_user = $row1[0];
					
					if($access_level_user!='admin'){
						$delete_sql .= "DELETE FROM spiderusers WHERE id=".$values_array[$i].";";
						//generates the whole delete user multi statement sql query after this loop
					}
					
			}
			else
				echo "could not do so ";
			
			//$delete_sql = "DELETE FROM spiderusers WHERE ID=".$values_array[$i];
			
			$i++;
		}
		
		if(!mysqli_multi_query($con,$delete_sql))
			echo "<script>alert('Error while deleting users');</script>";
		else
			echo "<script>location.replace('admin_panel.php');</script>";
	}
	else
		echo "<script>alert('No user selected');</script>";
	
	//return false;
}

if(isset($_POST['confirmed'])){
	$cng_user_id = $_POST['userID'];
	$cng_access_level = $_POST['newAccessLevel'];
	
	$change_sql = "UPDATE spiderusers SET accessLevel = '".$cng_access_level."' WHERE id = ".$cng_user_id;
	
	if(!mysqli_query($con,$change_sql))
		echo "<script>alert('Could not change access level..');</script>";
	else
		echo "<script>location.replace('admin_panel.php');</script>";
	
}

?>
</body>

</html>