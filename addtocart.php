<?php
session_start();
include_once('config/config.php'); 

$session_id = session_id();	
// Retrieve data from Query String
$user_id=0;
$product_id = $_GET['product_id'];
$qty = $_GET['qty'];  

// Escape User Input to help prevent SQL Injection
$product_id = mysqli_real_escape_string($con,$product_id);
$quantity = mysqli_real_escape_string($con,$qty);

if(isset($_GET['at_id']))
{
	$at_id = $_GET['at_id'];
	$at_id = mysqli_real_escape_string($con,$at_id);
}
else
{
	$at_id =0;
	
}






if($at_id !=0)
{
	$sql_vendor = "SELECT vendor_id,rate FROM tbl_service_plans WHERE id = '".$product_id."'";
	$result_vendor = mysqli_query($con,$sql_vendor);
	$row_vendor = mysqli_fetch_array($result_vendor);
	$vendor_id = $row_vendor["vendor_id"];
	
	$sql_attribute = "SELECT price FROM tbl_product_attribute WHERE id = '".$at_id."'";
	$result_attribute = mysqli_query($con,$sql_attribute);
	$row_attribute = mysqli_fetch_array($result_attribute);	
	$rate = $row_attribute["price"];
}
else
{
	$sql_vendor = "SELECT vendor_id,rate FROM tbl_service_plans WHERE id = '".$product_id."'";
	$result_vendor = mysqli_query($con,$sql_vendor);
	$row_vendor = mysqli_fetch_array($result_vendor);
	$vendor_id = $row_vendor["vendor_id"];
	$rate = $row_vendor["rate"];
}


	
//build query

if(isset($_SESSION["user_id"]))
	$user_id = $_SESSION['user_id'];
	$date = date("Y-m-d H:i:s");

$query = "select session_id from tbl_cart where session_id = '".$session_id."' and product_id = '".$product_id."' and attribute_id = '".$at_id."'";
$result = mysqli_query($con,$query);

$query_master = "select id,session_id from tbl_cart_master where session_id = '".$session_id."' ";
$result_master = mysqli_query($con,$query_master);

if(mysqli_num_rows($result_master) == 0)
{
	$query = "INSERT into tbl_cart_master (user_id,session_id,date_purchase) values('$user_id','$session_id','$date')";
	$qry_result = mysqli_query($con,$query) or die(mysql_error());
	$cart_master_id = mysqli_insert_id($con);
	$_SESSION["cart_master_id"] = $cart_master_id ;
	
	if(mysqli_num_rows($result) > 0)
	{
		$query1 = "update tbl_cart set quantity = quantity +  $quantity where session_id = '".$session_id."' and product_id = '".$product_id."'";	
	}
	else
	{
	$query1 = "INSERT into tbl_cart (cart_master_id,user_id,session_id,product_id,quantity,rate, service_id,vendor_id,type,attribute_id) values('".$cart_master_id."','$user_id','$session_id','$product_id','$quantity','$rate', '2','$vendor_id','product','$at_id')";
	}
}
else
{
	if(mysqli_num_rows($result) > 0)
	{
		$query1 = "update tbl_cart set quantity = quantity +  $quantity where session_id = '".$session_id."' and product_id = '".$product_id."'";	
	}
	else 
	{
		$row = mysqli_fetch_array($result_master);
		$query1 = "INSERT into tbl_cart (cart_master_id,user_id,session_id,product_id,quantity,rate, service_id,vendor_id,type,attribute_id) values('".$row['id']."','$user_id','$session_id','$product_id','$quantity','$rate','2','$vendor_id','product','$at_id')";
	}
}
//Execute query
$qry_result = mysqli_query($con,$query1) or die(mysql_error());

$query = "select session_id from tbl_cart where session_id = '".$session_id."'";
$result = mysqli_query($con,$query);
echo mysqli_num_rows($result);
/* if(mysql_error() == "")
	echo "Added suceesfully";
else
	echo "Some error. Please try again!"; */