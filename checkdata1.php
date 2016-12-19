<?php
include_once('config/config.php'); 
if(isset($_POST['mobile']))
{
	//$mobile="91".$_POST['mobile'];
	$mobile=$_POST['mobile'];

	$sql="SELECT id,name FROM app_users WHERE mobile ='$mobile' ";

	$result =mysqli_query($con,$sql);
	$item = mysqli_num_rows($result);


	if($item > 0)
	{
	echo "Mobile Already Exist";
	}
	 else
	{
	//echo $mobile;
	} 
exit();
}
?>