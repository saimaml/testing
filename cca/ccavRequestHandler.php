<html>
<head>
<title> Non-Seamless-kit</title>
</head>
<body>
<center>

<?php include('Crypto.php'); ?> 
<?php 

	error_reporting(0); 
	
	$merchant_data='';
	$working_key='98C3524FB252561E9E22CA480E8147B3';//Shared by CCAVENUES
	$access_code='AVMJ64DD89BF71JMFB';//Shared by CCAVENUES
	
	foreach ($_POST as $key => $value){
		
		$merchant_data.=$key.'='.$value.'&';
	}
	
	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.

?>
<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";


?>
</form>
</center>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>

