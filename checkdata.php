<?php
include_once('config/config.php'); 
if(isset($_POST['email']))
{
	$emailId=$_POST['email'];

	$sql="SELECT id,name FROM app_users WHERE email ='$emailId' ";	

	$result =mysqli_query($con,$sql);
	$item = mysqli_num_rows($result);


	if($item > 0)
	{
	echo "Email Already Exist";
	}
	else
	{
	echo "OK";
	}
exit();
}
?>