<?php include('../Crypto.php')?>
<?php

	error_reporting(0);
	
	$workingKey='98C3524FB252561E9E22CA480E8147B3';		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	echo "<center>";

	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		
		if($i==1)	$order_id=$information[1];
		if($i==3)	$order_status=$information[1];
		
		if($i==10)   $amount=$information[1];
		if($i==11)   $billing_name=$information[1];
		if($i==17)   $billing_tel=$information[1];
		
	}

	if($order_status==="Success")
	{
		
		
		$admin_mob = "919011855666";
		$user_msg = urlencode("Congratulations, Customer $billing_name has placed an order of Rs. $amount. Kindly deliver the product in time.");
		send_sms_otp($user_msg, $admin_mob);
	
		$user_msg = urlencode("Thank you for placing order at Discover My Pet. Your product shall be dispatched within 5 working days");
		send_sms_otp($user_msg, $billing_tel);		
					
		include_once('email/mail.php');	
		//mail_booking($order_id); // For User
		mail_booking1($order_id); // For Admin
		mail_vendor($order_id); // For Vendor
			 
		
		echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
	
		
	}
	else if($order_status==="Aborted")
	{
		echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
	
	}
	else if($order_status==="Failure")
	{
		echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
	}
	else
	{
		echo "<br>Security Error. Illegal access detected";
	
	}

	echo "<br><br>";

	echo "<table cellspacing=4 cellpadding=4>";
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
	    	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	}

	echo "</table><br>";
	echo "</center>";
	
	function send_sms_otp($user_msg, $mobile)
	{
		$sms_url = "http://smshorizon.co.in/api/sendsms.php?user=discovermp&apikey=Z8e1gC6QFBzXuGcpZ1qI&mobile=$mobile&message=$user_msg&senderid=PETAPP&type=txt";	
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$sms_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch); 
	}
?>
