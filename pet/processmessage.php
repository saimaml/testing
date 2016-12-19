<?php
include('config/config.php');
	//generic php function to send GCM push notification
	$gcmRegID = "fCpwedqmbS0:APA91bFbMnI9D5_qvIz7MdPOXqz8aIZyMNbBl__3Jyp8EAJcxfLoUjCcB9ymfES41oyfVYFwvIBVGftokXrDT-G3WUlS0HClHQLZ5cZ3v0vPmuEvpPrTt890CsQZ_mNziRHwtxfWG_Bv";
	$message = "Hello Friend";
	sendPushNotificationToGCM($gcmRegID, $message);
   function sendPushNotificationToGCM($gcmRegID, $message) {
		//Google cloud messaging GCM-API url
       $url = 'https://android.googleapis.com/gcm/send';
	   
		echo "<br/>";
		$fcmRegIds = array();
		array_push($fcmRegIds, $gcmRegID);
		$fdata = array();
		array_push($fdata, $message);
		
        $fields = array(
            'registration_ids' => $fcmRegIds,
            'data' => array("message" =>$message)
        );
		print_r($fields);
		echo "<br/>";
		// Google Cloud Messaging GCM API Key
		define("GOOGLE_API_KEY", "AIzaSyDL_2nRnXC_6W4U1xAu4zPa1OXGnNp47Ks"); 		
		
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);	
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);		
echo $result;		
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
		//echo $result;
        return $result;
    }
	die();
?>
<?php
	
	//this block is to post message to GCM on-click
	$pushStatus = "";	
	if(!empty($_GET["push"])) {	
	//	$gcmRegID  = file_get_contents("GCMRegId.txt");
	
	$sql_gcm = "Select gcm_id FROM app_users WHERE id = '1439'";
	$result_gcm = mysqli_query($link,$sql_gcm);
	$row_gcm = mysqli_fetch_array($result_gcm);
	$gcmRegID = $row_gcm['gcm_id'];
	
		$pushMessage = $_POST["message"];	
		if (isset($gcmRegID) && isset($pushMessage)) {		
			 //$gcmRegIds = array($gcmRegID);
			 //print_r($gcmRegIds);
			 
			$message = array("m" => $pushMessage);	
			$pushStatus = sendPushNotificationToGCM($gcmRegID, $message);
		}		
	}
	
	//this block is to receive the GCM regId from external (mobile apps)
	if(!empty($_GET["shareRegId"])) {
		$gcmRegID  = $_POST["regId"]; 
		echo $gcmRegID;
		//file_put_contents("GCMRegId.txt",$gcmRegID);
		echo "Ok!";
		exit;
	}	
?>
<html>
    <head>
        <title>Google Cloud Messaging (GCM) Server in PHP</title>
    </head>
	<body>
		<h1>Google Cloud Messaging (GCM) Server in PHP</h1>	
		<form method="post" action="processmessage.php/?push=1">					                             
			<div>                                
				<textarea rows="2" name="message" cols="23" placeholder="Message to transmit via GCM"></textarea>
			</div>
			<div><input type="submit"  value="Send Push Notification via GCM" /></div>
		</form>
		<p><h3><?php echo $pushStatus; ?></h3></p>        
    </body>
</html>