<?php 
	include_once('config/config.php');
	function nearby($origLat,$origLon)
	{	
		global $link; 
		$i = 0;
		$dist = 1000; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
		
		$query = "SELECT id,name,clinic_name,address1,address2,city,phone_no,person_image, latitude, longitude, 3956 * 2 * 
		ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
		+COS($origLat*pi()/180 )*COS(latitude*pi()/180)
		*POWER(SIN(($origLon-longitude)*pi()/180/2),2))) 
		as distance FROM tbl_service_details WHERE service_cat_id = '0' and
		longitude between ($origLon-$dist/cos(radians($origLat))*69) 
		and ($origLon+$dist/cos(radians($origLat))*69) 
		and latitude between ($origLat-($dist/69)) 
		and ($origLat+($dist/69)) 
		having distance < $dist ORDER BY distance "; 
		$result = mysqli_query($link,$query) or die(mysql_error());
		while($row = mysqli_fetch_assoc($result)) 
		{
			if($row['person_image'] =="NULL")
			{
				$img = "http://www.discovermypet.in/pet/uploads/socialprofile/default-user-image.png";
			}
			else
			{
				$img = $row['person_image'];
			}		
			
			$name = strtolower($row["name"]);
			$name = ucwords($name);		
			$name = "Dr. ".$name;
			
			$address = $row["address1"].",".$row["address2"].",".$row["city"];
			
			$address = strtolower($address);
			$address = ucwords($address);		
			
			 $app_info[$i] = array("doctor_id" => $row["id"],"clinicName"=>$row["clinic_name"],"dr_img" => $img,"doctor_name" => $name, "dr_address" => $address, "time_1" => "9 to 1", "time_2" => "5 to 9", "contact_no" => $row["phone_no"], "latitude" => $row["latitude"], "longitude" => $row["longitude"]);
			$i++;
		}
		
		if(empty($app_info))
		{
			$app_info = array("success" => 0,"error"=>"no records found");
			return $app_info;
		}
		else
		{
			$app_list = array("success" => 1,"result" => $app_info);
			return $app_list;
		}	
	}
		function nearby_str($address)
	{
		global $link;
	//	$app_info =array;
		$url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyDL_2nRnXC_6W4U1xAu4zPa1OXGnNp47Ks&address=$address&sensor=false&region=India";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);
		$response_a = json_decode($response);

		$origLat = $response_a->results[0]->geometry->location->lat;
		
		$origLon = $response_a->results[0]->geometry->location->lng;
		  
		$i = 0;
		$dist = 50; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
		$query = "SELECT id, name,address1,address2,city,phone_no, latitude, longitude, 3956 * 2 * 
		ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
		+COS($origLat*pi()/180 )*COS(latitude*pi()/180)
		*POWER(SIN(($origLon-longitude)*pi()/180/2),2))) 
		as distance FROM tbl_service_details WHERE service_cat_id = '0' and
		longitude between ($origLon-$dist/cos(radians($origLat))*69) 
		and ($origLon+$dist/cos(radians($origLat))*69) 
		and latitude between ($origLat-($dist/69)) 
		and ($origLat+($dist/69)) 
		having distance < $dist ORDER BY distance limit 100"; 
		$result = mysqli_query($link,$query) or die(mysql_error());
		$img = "http://www.discovermypet.in/pet/uploads/socialprofile/default-user-image.png";
		while($row = mysqli_fetch_assoc($result)) 
		{
			 $name = strtolower($row["name"]);
			  $name = ucwords($name);
			
			$name = "Dr. ".$name;
			$address = $row["address1"].",".$row["address2"].",".$row["city"];
			
			 $address = strtolower($address);
			 $address = ucwords($address);
			
			 $app_info[$i] = array("doctor_id" => $row["id"],"dr_img" => $img,"doctor_name" => $name, "dr_address" => $address, "contact_no" => $row["phone_no"], "latitude" => $row["latitude"], "longitude" => $row["longitude"]);
			$i++;
		}
		if(empty($app_info))
		{
			$app_info = array("success" => 0,"error"=>"no records found");
			return $app_info;
		}
		else
		{
			$app_list = array("success" => 1,"result" => $app_info);
			return $app_list;
		}

	}

	
	$possible_url = array("nearby","nearby_str");

	$value = "An error has occurred";
	
	
	if (isset($_POST["action"]) && in_array($_POST["action"], $possible_url))
	{
		
		switch ($_POST["action"])
		{
			case "nearby_str":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = nearby_str($_POST["address"]);
						}
						else
						{
							$value = "Sorry..Something went wrong..!!";						
						}
					}
					else
					{
						$value = "Sorry..Something went wrong..!!";
					}			
			break; 
			case "nearby":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = nearby($_POST["latitude"],$_POST["longitude"]);  
						}
						else
						{
							$value = "Sorry..Something went wrong..!!";						
						}
					}
					else
					{
						$value = "Sorry..Something went wrong..!!";
					}			
			break;
		}
	}


	//return JSON array
	exit(json_encode($value));
	?>

	<!--localhost/offers/api.php?action=add_project_recordsimage= -->