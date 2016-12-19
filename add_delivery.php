<?php
session_start();
include_once('config/config.php'); 
// Retrieve data from Query String

$fname = $_GET['fname'];
$lname = $_GET['lname'];
$city = $_GET['city'];
$state = $_GET['state'];
$address1 = $_GET['address1'];
$address2 = $_GET['address2'];
$user_id = $_GET['user_id'];


// Escape User Input to help prevent SQL Injection
$fname = mysqli_real_escape_string($con,$fname);
$lname = mysqli_real_escape_string($con,$lname);
$city = mysqli_real_escape_string($con,$city);
$state = mysqli_real_escape_string($con,$state);
$address1 = mysqli_real_escape_string($con,$address1);
$address2 = mysqli_real_escape_string($con,$address2);
$user_id = mysqli_real_escape_string($con,$user_id);

	
//build query

$sql = "UPDATE tbl_cart_master SET d_fname = '".$fname."',d_lname = '".$lname."',d_city = '".$city."',d_state = '".$state."',d_address1 = '".$address1."',d_address2 = '".$address2."' where user_id = '$user_id' ";
$result = mysqli_query($con,$sql);
if(mysql_error() == "")
	echo $fname." ".$lname."<br/>".$address1."".$address2."<br/>".$city;
else
	echo "Some error. Please try again!";