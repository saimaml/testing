<?php 
	include('config/config.php');
	
	function get_pet($id)  /**** MEDICAL RECORDS ****/
	{
	global $link;	
	$str="";
	$months = "";
	$year="";
		$i = 0;
		$sql = "SELECT image, pet_name,allergy, weight, gender, pet_type, pet_food, breed,birthdate, DATE_FORMAT(`birthdate` , '%e %b %Y' )AS birthday FROM pet_master WHERE id = '".$id."'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		
		$weight=$row["weight"]." Kg";
		
		 $days = date_diff(new DateTime(), new DateTime($row['birthdate']));
		 $day = $days->format("%a");
		 
		if($day > 30)
		{
			$months = floor($day / 30);
					
			if($months > 12)
			{		
				$year = floor($months / 12);			
			}
			elseif($months < 12)
			{				
				$year = "";
			}
		}
		else if($day < 30)
		{		
			$months = "";
			$day = $day;
		} 
		if($year != "")
			$str = $year." Years ";
		elseif($months != "")
			$str .= $months." Months ";
		elseif($days != "")
			$str .= $day." Days";		
		$app_info[0] = array("image" => $row["image"],"pet_name" => $row["pet_name"],"allergy" => $row["allergy"],"weight" => $weight,"gender" => $row["gender"],"pet_type" => $row["pet_type"],"pet_food" => $row["pet_food"],"breed" => $row["breed"],"birthdate" => $row["birthday"],"age" => $str);
		if (empty($app_info)) 
		{
			$app_list[0] = array("success" => 0, "error" => "no records found");
			return $app_list;	
		}

		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
	}
	function list_pet_of_user($user_id)
	{		
		global $link;
		$i = 0;
		$app_info = array();
		$sql = "SELECT id, thub, pet_name, pet_type FROM pet_master where user_id = '".$user_id."' and is_active = 1 ";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$pet_name = $row["pet_name"];
			$pet_name = ucwords($pet_name);
			
			$app_info[$i] = array("id" => $row["id"], "pet_name" => $pet_name, "pet_type" => $row["pet_type"],"image" => $row["thub"]);
			$i++;
		}
		if(empty($app_info))
		{
			$app_list = array("success" => 0,"error"=>"no records found");
			return $app_list;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
	}
	function delete_pet($user_id,$pet_id)
	{
		global $link;
		$sql = "DELETE FROM `pet_master` WHERE `id` = '".$pet_id."' and `user_id` ='".$user_id."'";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
		{ 
			if(mysqli_affected_rows($link) != 0)
				$returnarr = array("success" => 1, "error" => "0");
			else
				$returnarr = array("success" => 0, "error" => "1");	
		}		
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function add_pet($pet_type, $gender,$user_id) /**** ADD PET (GENDER , TYPE) ****/
	{		
		global $link;
		$sql = "INSERT into pet_master(pet_type,gender,user_id,date_created) values ('".$pet_type."','".$gender."','".$user_id."','".date('Y-m-d H:i:s')."')";
		$result = mysqli_query($link,$sql);	
		$id = mysqli_insert_id($link);	
		if(mysql_error() == "")				
		
			$returnarr = array("success" => 1, "error" => 0,"id"=>$id);
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function edit_pet_birthdate($id,$birthdate) /**** ADD BIRTHDATE ****/
	{		
		global $link;
		$sql_get_birth = "SELECT birthdate FROM pet_master WHERE id = '".$id."' ";
		$result_get_birth = mysqli_query($link,$sql_get_birth);
		if(mysqli_num_rows($result_get_birth) > 0)
		{
			$sql_delete_vaccination = "DELETE FROM `tbl_pet_vaccination` WHERE `pet_id` = '".$id."'";
			$result = mysqli_query($link,$sql_delete_vaccination);
		}
		$sql="UPDATE pet_master SET birthdate = '".$birthdate."',is_active = 1 WHERE id = '".$id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
		{
			//if(mysqli_affected_rows($link) != 0)
				$returnarr = array("success" => 1, "error" => "0","id"=>$id);
			//else
				//$returnarr = array("success" => 0, "error" => "1");	
		}		
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function edit_pet1($id,$weight)   /**** ADD WEIGHT ****/
	{		
		global $link;
		$sql="UPDATE pet_master SET weight = '".$weight."' WHERE id = '".$id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
		{	
				$returnarr = array("success" => 1, "error" => "0","id"=>$id);
			
		}		
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function post_dog_details_android($pet_id,$user_id,$pet_name,$breed_name,$allergy_name,$image)  
	{		
		global $link;
		if($_SERVER['REQUEST_METHOD']=='POST')
		{		
			$imagename = $pet_id.".png";
			$path = "uploads/pet_pics/$imagename";	 	
			$image1 = "http://www.discovermypet.in/pet/$path";			
			file_put_contents($path,base64_decode($image));	
			
			$im = new Imagick($image1);
			$im->scaleImage(500,0);
			$im->writeImage($path);
			
			
			$path_thub = "uploads/pet_pics/thub/$imagename";
			$image_thub = "http://www.discovermypet.in/pet/$path_thub";			
			file_put_contents($path_thub,base64_decode($image)); 	
			
			
			$im = new Imagick($image_thub);
			$im->scaleImage(300,0);
			$im->writeImage($path_thub);
			
			$sql="UPDATE pet_master SET pet_name = '".$pet_name."',allergy = '".$allergy_name."',image = '".$image1."',thub = '".$image_thub."', breed= '".$breed_name."' WHERE id = '".$pet_id."' ";
			
			/* $sql_allergy = "INSERT into allergy (allergy_name, date_created,pet_id) values ('".$allergy_name."', '".date('Y-m-d H:i:s')."','".$pet_id."')"; */
			
			$result = mysqli_query($link,$sql);
			
			/* $result_allergy = mysqli_query($link,$sql_allergy); */
		
			if(mysql_error() == "")		
			{
				
					$returnarr = array("success" => 1, "error" => "0");
				
			}		
			else
				$returnarr = array("success" => 0, "error" => mysql_error());		
		}
		return $returnarr;
	}
	function get_dog_details($id,$type) /**** SHOW ALLERGY AND BREED ****/
	 {	
		global $link;
		$i = 0;
		$j = 0;
		$sql_user = "select name,city from app_users where id = '".$id."'";
		$sql_pet = "select pet_name from pet_master where user_id = '".$id."'";
		$sql_breed= "select breed_name from tbl_breed where type = '".$type."'";
		$sql_allergy= "select allergy_name from allergy WHERE pet_type='".$type."'";
		
		$result_user = mysqli_query($link,$sql_user);
		$result_pet = mysqli_query($link,$sql_pet);
		$result_breed = mysqli_query($link,$sql_breed);
		$result_allergy = mysqli_query($link,$sql_allergy);
		
		$row_pet = mysqli_fetch_array($result_pet);	
		$row_user = mysqli_fetch_array($result_user);	
		while($row_breed = mysqli_fetch_array($result_breed))
		{
			$app_breed[$i] = array("breed_name" => $row_breed["breed_name"]);
			$i++;
		}
		while($row_allergy = mysqli_fetch_array($result_allergy))
		{
			$app_allergy[$j] = array("allergy_name" => $row_allergy["allergy_name"]);
			$j++;
		}		
		$app_user[0] = array("name" => $row_user["name"],"pet_name" => $row_pet["pet_name"],"city" => $row_user["city"]);		
		$app_list = array("success" => 1,"result" => array($app_user[0]),"breed" =>$app_breed,"allergy" => $app_allergy);
		return $app_list; 
	 }
	 function edit_pet_food($id,$pet_food)   /**** ADD FOOD ****/
	{		
		global $link;
		$sql="UPDATE pet_master SET pet_food = '".$pet_food."' WHERE id = '".$id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
		{
			//if(mysqli_affected_rows($link) != 0)
				$returnarr = array("success" => 1, "error" => "0","id"=>$id);
			//else
				//$returnarr = array("success" => 0, "error" => "1");	
		}		
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	

	
	$possible_url = array("list_pet_of_user","delete_pet","add_pet","edit_pet_birthdate","edit_pet1","post_dog_details_android","get_dog_details","edit_pet_food","get_pet");

	$value = "An error has occurred";
	
	
	if (isset($_POST["action"]) && in_array($_POST["action"], $possible_url))
	{
		
		switch ($_POST["action"])
		{ 
			case "list_pet_of_user":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = list_pet_of_user($_POST["user_id"]);
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
			case "get_pet":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							if(empty($_POST["id"]))
							{
								$value = array("success" => 0, "error" => 1);
								break; 
							}
							$value = get_pet($_POST["id"]);
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
			case "delete_pet":	
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = delete_pet($_POST["user_id"],$_POST["pet_id"]);
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
			case "add_pet":
			
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = add_pet($_POST["pet_type"],$_POST["gender"],$_POST["user_id"]);
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
		
		case "edit_pet_birthdate":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_pet_birthdate($_POST["id"], $_POST["birthdate"]);
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
			case "edit_pet1":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_pet1($_POST["id"], $_POST["weight"]);
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
			case "post_dog_details_android":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = post_dog_details_android($_POST["pet_id"],$_POST["user_id"],$_POST["pet_name"],$_POST["breed_name"],$_POST["allergy_name"],$_POST["image"]);
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
			case "get_dog_details":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_dog_details($_POST["id"],$_POST["type"]); 
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
			case "edit_pet_food":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_pet_food($_POST["id"], $_POST["pet_food"]); 
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