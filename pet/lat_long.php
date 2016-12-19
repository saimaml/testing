<?php 

	include('config/config.php');
		global $link;
		
	$sql = "SELECT id,address1,address2,city FROM tbl_service_details";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			echo $address = $row['address1']." ".$row['address2']." ".$row['city'];
			
			// Get JSON results from this request
			$geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');
			
			// Convert the JSON to an array
			$geo = json_decode($geo, true);

			if ($geo['status'] == 'OK') {
			  // Get Lat & Long
			 echo  $latitude = $geo['results'][0]['geometry']['location']['lat'];
			 echo  $longitude = $geo['results'][0]['geometry']['location']['lng'];
			 
			$sql_update = "UPDATE tbl_service_details SET latitude = '$latitude',longitude= '$longitude' where id='".$row['id']."'  ";
			 $result_update = mysqli_query($link,$sql_update);
			
			}
			
		
		
			 
		
		}

	
?>