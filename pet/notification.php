<?php
include_once('config/config.php');
	//generic php function to send GCM push notification
	
   function sendPushNotificationToGCM($gcmRegID, $message) {
   
		//Google cloud messaging GCM-API url
       $url = 'https://android.googleapis.com/gcm/send';
	   
		
		$fcmRegIds = array();
		array_push($fcmRegIds, $gcmRegID);
		$fdata = array();
		array_push($fdata, $message);
		
        $fields = array(
            'registration_ids' => $fcmRegIds,
            'data' => array("message" =>$message)
        );
		//print_r($fields);
	//echo "<br/>";
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
		//echo $result;		
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
		//echo $result;
        return $result;
    }
	
?>
