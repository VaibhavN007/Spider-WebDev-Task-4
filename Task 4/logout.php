<?php
session_start();
/*
if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
else if(isset($_SESSION['user'])!="")
{
 header("Location: home.php");
}
*/
//if(isset($_GET['logout']))
//{
 session_destroy();
 unset($_SESSION['user']);        //maybe use session_unset() here then session_destroy();
 header("Location: index.php");
//}
?>