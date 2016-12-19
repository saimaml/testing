<?php 
include('config/config.php');
if(isset($_POST["submit"]))
{
	global $link;
	$image = $_POST["image"];
	$imagename ="1.png";
	
	$path = "uploads/pet_pics/$imagename";	 	
	$image1 = "http://www.discovermypet.in/pet/$path";			
	file_put_contents($path,base64_decode($image));	

	$sql="UPDATE pet_master SET image = '".$image1."' WHERE id = '1' ";				
	$result = mysqli_query($link,$sql);
	if(mysql_error() == "")	
	{
		echo "Succesfully";
	}		
	else
	{
		echo "Not Succesfully ";
	}
		
	
}
	
?>


<?php

$path = '1.gif';
$data = file_get_contents($path);
$imageContent_user = base64_encode($data);
?>	
<html>
<body>
<form method="POST">
Image Content: <textarea name="image"><?php echo $imageContent_user; ?></textarea><br>
<input type="submit" name="submit">
</form>
</body>
</html>