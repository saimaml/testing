<?php
$server_path = "http://www.discovermypet.in/pet/";
date_default_timezone_set("Asia/Kolkata");
error_reporting(E_ALL);
ini_set('display_errors', 1);
function Encrypt($password, $data)
	{
		global $link;
	  
		$sql = "SELECT key1 FROM tbl_key";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		
		$row["key1"];
		 if($data === $row["key1"])
		 {		 
			 return true;
		 }
		 else
		 {
			return false;
		 }
	} 
	function getaddress($latitude,$longitude)
	{
	$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false';
	$json = @file_get_contents($url);
	$data=json_decode($json);
	$status = $data->status;
	if($status=="OK")
	return $data->results[0]->formatted_address;
	else
	return false;
	}
	function send_sms_otp($user_msg, $mobile)
	{
		$sms_url = "http://smshorizon.co.in/api/sendsms.php?user=discovermp&apikey=Z8e1gC6QFBzXuGcpZ1qI&mobile=$mobile&message=$user_msg&senderid=PETAPP&type=txt";	
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$sms_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch); 		
	}
	function send_sms($user_msg, $mobile)
	{
		$sms_url = "http://smslane.com/vendorsms/pushsms.aspx?user=discovermypet&password=abcdefg@1234&msisdn=$mobile&sid=PETAPP&msg=$user_msg&fl=0&gwid=2";	
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$sms_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch); 			
	} 
	 

$db="DMP";
$db_password="vistart3";
$db_user="root";
$db_host="172.31.20.191";
  

$link = new mysqli($db_host, $db_user, $db_password, $db);
if ($link->connect_error) {
    die('Connect Error (' . $link->connect_errno . ') '
            . $link->connect_error);
}

?>