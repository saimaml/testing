<?php
 include_once('config/config.php'); 

	
// Retrieve data from Query String
$user_id = $_GET['user_id'];
$package_id = $_GET['package_id'];
$quantity = $_GET['quantity'];
$rate = $_GET['rate'];
$is_active = $_GET['is_active'];
$is_paid = $_GET['is_paid'];
	
// Escape User Input to help prevent SQL Injection
$user_id = mysqli_real_escape_string($con,$user_id);
$package_id = mysqli_real_escape_string($con,$package_id);
$quantity = mysqli_real_escape_string($con,$quantity);
$rate = mysqli_real_escape_string($con,$rate);
$is_active = mysqli_real_escape_string($con,$is_active);
$is_paid = mysqli_real_escape_string($con,$is_paid);
	
//build query
$query = "INSERT into tbl_cart (user_id,package_id,quantity,rate,is_active,is_paid) values('$user_id','$package_id','$quantity','$rate','$is_active','$is_paid')";

//Execute query
$qry_result = mysqli_query($con,$query) or die(mysql_error());
 if(mysql_error() == "")
	 echo "suceesfully";
 else
	 echo "not";