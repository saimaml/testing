<?php
session_start();
require 'config/config.php';
function checkuser($fuid,$ffname,$femail){
    	$check = mysqli_query($con,"select * from Users where Fuid='$fuid'");
	$check = mysqli_num_rows($check);
	if (empty($check)) { // if new user . Insert a new record		
	$query = "INSERT INTO Users (Fuid,Ffname,Femail) VALUES ('$fuid','$ffname','$femail')";
	mysqli_query($con,$query);	
	$query1 = "INSERT INTO app_users (name,email) VALUES ('$ffname','$femail')";
	mysqli_query($con,$query1);	
	$user_id = mysqli_insert_id($con);
	$_SESSION['user_id'] = $user_id;
	$_SESSION['login'] = "1";
	
	} else {   // If Returned user . update the user record		
	$query = "UPDATE Users SET Ffname='$ffname', Femail='$femail' where Fuid='$fuid'";
	mysqli_query($con,$query);
	
	//$query1 = "UPDATE app_users SET Ffname='$ffname', Femail='$femail' where Fuid='$fuid'";
	//mysql_query($query1);
	}
}?>
