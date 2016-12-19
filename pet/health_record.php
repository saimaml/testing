<?php 
	include('config/config.php');
	
	function select_pet($user_id,$pet_type)
	{		
		global $link;
		$i = 0;
		$app_info = array();
		$sql = "select id,pet_name,thub, breed,DATE_FORMAT(`birthdate` , '%e %b %Y' )AS birthday from pet_master where user_id = '".$user_id."' and pet_type = '".$pet_type."'and is_active=1";
		$result = mysqli_query($link,$sql);	
		if(mysqli_num_rows($result) != 0)
		{
			while($row = mysqli_fetch_array($result))
			{
				$pet_name = $row["pet_name"];
				$pet_name = ucwords($pet_name);
				
				$app_info[$i]= array("image" => $row["thub"],"id" => $row["id"],"pet_name" => $pet_name,"breed" => $row["breed"],"birthdate" => $row["birthday"]);
				$i++;
			}
			$app_list = array("success" => 1,"result" => $app_info);
			return $app_list;
		}
		else
		{
			$returnarr = array("success" => 0, "error" => 1);		

				return $returnarr;
		}	
	}
	function vaccination_list($pet_id, $user_id)
	{	
		global $link;
		$i = 0;
		$sql_pet_type = "select pet_type from pet_master where id = '".$pet_id."' and user_id ='".$user_id."'";
		$result_pet_type = mysqli_query($link,$sql_pet_type);
		$row_pet_type = mysqli_fetch_array($result_pet_type);
		$pet_type = $row_pet_type["pet_type"];
		
		//Select all vaccination types, durations, duration titles from table for given pet type.
		$sql_vacc_list = "select id, duration_title, duration from tbl_vaccination_master where pet_type = '".$pet_type."'";
		$result_vacc_list = mysqli_query($link,$sql_vacc_list);
		while($row_vacc_list = mysqli_fetch_array($result_vacc_list))
		{
			$duration = $row_vacc_list["duration"];		
			$duration_title = $row_vacc_list["duration_title"];
			$vaccination_id = $row_vacc_list["id"];
			//Select vaccination records for given pet
			$sql_vacc = "select due_date, given_date, id from tbl_pet_vaccination where pet_id = '".$pet_id."' and vaccination_id = '".$vaccination_id."'";
			$result_vacc = mysqli_query($link,$sql_vacc);
			//if no vaccination records found for this pet, we have to insert due dates of vaccination for this pet.
			if(mysqli_num_rows($result_vacc) == 0)
			{
				// Insert vaccination due dates here
				$insert = "insert into tbl_pet_vaccination (pet_id, vaccination_id) values ('".$pet_id."', '".$vaccination_id."')";
				mysqli_query($link,$insert);			
			}
			else // If vaccination record already exists
			{
				$row_vacc = mysqli_fetch_array($result_vacc);
				$pet_vaccination_id = $row_vacc["id"];
				$due_date = $row_vacc["due_date"];
				$given_date = $row_vacc["given_date"];
										
				// If vaccination already given means given date is not empty, then just return green color and other values
				if($given_date != "0000-00-00") 
					$app_user[$i] = array("vaccination_id"=>$vaccination_id,"duration_title" => $duration_title,"given_date" => $given_date, "due_date" => "", "row_color" => "green");
				else if($given_date == "0000-00-00") // If vaccination is not given at all
				{
					//We are finding difference between due date of specific vaccination and current date
					$due_datenew = new DateTime($due_date);
					$current_date = new DateTime(date("Y-m-d"));
					$interval = $current_date->diff($due_datenew);
					$interval = $interval->format('%R%a');
					//If due date is not yet reached, we will return due date , no given date and orange color to show due date is not yet crossed but vaccination not yet given.
					if($interval >= 0)
						$app_user[$i] = array("vaccination_id"=>$vaccination_id,"duration_title" => $duration_title,"given_date" => "", "due_date" => $due_date, "row_color" => "orange");
					else // We will return red color because due date is crossed.
						$app_user[$i] = array("vaccination_id"=>$vaccination_id,"duration_title" => $duration_title,"given_date" => "", "due_date" => $due_date, "row_color" => "red");
				}
			}
			$i++;
		}
		if(empty($app_user))
		{
			$app_list = array("success" => 0,"error"=>"no records found");
			return $app_list; 
		}
		
		$app_list = array("success" => 1,"result" => $app_user);
		return $app_list; 
	}
	function post_weight($vaccination_id,$pet_id,$weight,$type)
	{	
		global $link;
		if($type == "Pound")
		{
			$weight = str_replace('Pound', 'Kg',$weight);	
			$weight  =  $weight * 0.453592 / 1;
				
			$weight = substr($weight,0,4);
			$weight = $weight." Kg"; 
			$sql = "UPDATE tbl_pet_vaccination SET weight = '".$weight."' WHERE vaccination_id = '".$vaccination_id."' and pet_id = '".$pet_id."'";
		}
		else
		{
			$sql = "UPDATE tbl_pet_vaccination SET weight = '".$weight."' WHERE vaccination_id = '".$vaccination_id."' and pet_id = '".$pet_id."'";
		}	
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function post_vacc_date($pet_id,$vaccination_id,$given_date,$next_date)
	{
		global $link;
		$sql_update = "Update tbl_pet_vaccination set given_date = '".$given_date."',due_date = '0000-00-00' WHERE pet_id = '".$pet_id."' and vaccination_id = '".$vaccination_id."'";
		$result = mysqli_query($link,$sql_update);
		
		if($vaccination_id !="6" AND $vaccination_id !="14")
		{
			$vaccination_id = $vaccination_id + 1;
			$sql_vacc_update = "UPDATE tbl_pet_vaccination SET due_date = '".$next_date."' WHERE vaccination_id ='".$vaccination_id."' and pet_id = '".$pet_id."'";
			$result_vacc_update = mysqli_query($link,$sql_vacc_update);
		}	
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => 0);
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;	
	}
	function get_doses_list_andriod($vaccination_id,$pet_id)
	{
		global $link;
		$i=0;
		
		$sql_vaccination = "SELECT duration_title FROM tbl_vaccination_master WHERE id ='".$vaccination_id."'";
		$result_vaccination = mysqli_query($link,$sql_vaccination);
		$row_vaccination = mysqli_fetch_array($result_vaccination);
		
		$sql_weight = "select weight, DATE_FORMAT(due_date,'%d %M %Y') as due_date from tbl_pet_vaccination where vaccination_id = '".$vaccination_id."' and pet_id = '".$pet_id."'";
		$result_weight = mysqli_query($link,$sql_weight);
		$row_weight = mysqli_fetch_array($result_weight);		
		
		$sql = "SELECT id,doses_img,doses_name,DATE_FORMAT(given_date,'%d %M %Y') as given_date FROM tbl_pet_doses WHERE pet_id = '".$pet_id."' and vaccination_id = '".$vaccination_id."'";
		$result = mysqli_query($link,$sql);
		
		//$vaccination_id = $vaccination_id - 1;
		$sql_given = "SELECT id,DATE_FORMAT(given_date,'%d %M %Y') as given_date1,given_date FROM tbl_pet_vaccination WHERE pet_id = '".$pet_id."' order by given_date desc LIMIT 1 ";
		$result_given = mysqli_query($link,$sql_given);
		$row_given = mysqli_fetch_array($result_given);
		$given_date1 = $row_given["given_date1"];			
			
		$vaccination_id = $vaccination_id + 1;
				
		$sql_next = "SELECT DATE_FORMAT(due_date,'%d %M %Y') as due_date FROM tbl_pet_vaccination WHERE vaccination_id = '".$vaccination_id."' and pet_id ='".$pet_id."'";
			$result_next = mysqli_query($link,$sql_next);
			$row_next = mysqli_fetch_array($result_next);
			$next_date = $row_next['due_date'];
		if(mysqli_num_rows($result) > 0)
		{		
			while($row = mysqli_fetch_array($result))
			{
				$app_info[$i] = array("dose_id" =>$row["id"],"doses_img" =>$row["doses_img"],"doses_name" =>$row["doses_name"],"given_date" =>$row["given_date"]);
				$i++;			
			}
			if($row_given["given_date"]!="0000-00-00")
			{
			$app_list = array("success" => "1","result" => $app_info,"duration_title"=>$row_vaccination["duration_title"],"weight"=>$row_weight["weight"],"last_visit"=>$given_date1,"recommended date"=> $row_weight["due_date"],"next_date"=>$next_date);
			}
			else
			{
				if($row_weight["due_date"]==null)
				{
					echo "hii";
					
					$app_list = array("success" => "1","result" => $app_info,"duration_title"=>$row_vaccination["duration_title"],"weight"=>$row_weight["weight"],"last_visit"=>"","recommended date"=> "","next_date"=>"");	
				}
				else
				{
						echo "byee";
					$app_list = array("success" => "1","result" => $app_info,"duration_title"=>$row_vaccination["duration_title"],"weight"=>$row_weight["weight"],"last_visit"=>$given_date,"recommended date"=> $row_weight["due_date"],"next_date"=>$next_date);	
				}
						
			}
		}
		else
		{
			if($row_weight["due_date"]==null)
			{
				$app_list = array("success" => "0", "error" => "no records found","duration_title"=>$row_vaccination["duration_title"],"weight"=>$row_weight["weight"],"last_visit"=>"","recommended date"=> "","next_date"=>"");	
			}
			else
			{
				$app_list = array("success" => "0", "error" => "no records found","duration_title"=>$row_vaccination["duration_title"],"weight"=>$row_weight["weight"],"last_visit"=>$given_date,"recommended date"=> $row_weight["due_date"],"next_date"=>$next_date);	
			}
				
		}
		return $app_list;	
	}
	function doses_list_andriod($vaccination_id,$pet_id,$doses_name,$doses_img,$given_date)
	{
		global $link;
		$date = date('Y-m-d');
		$sql="INSERT INTO tbl_pet_doses(pet_id,vaccination_id,doses_name,given_date) VALUES('".$pet_id."','".$vaccination_id."','".$doses_name."','".$date."')";
		$result = mysqli_query($link,$sql);
		$id = mysqli_insert_id($link);
		$imagename = $id.".png";
		$path = "uploads/dose/$imagename";		
		$img = "http://www.discovermypet.in/pet/$path";		
		file_put_contents($path,base64_decode($doses_img));	
		
		$im = new Imagick($img);
		$im->scaleImage(500,0);
		$im->writeImage($path);  
		
		$sql_update="UPDATE tbl_pet_doses SET doses_img = '".$img."' WHERE id='".$id."' ";
		$result_update = mysqli_query($link,$sql_update);
			
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => 0);
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;	
	}
	function doses_list_andriod_img($vaccination_id,$pet_id,$doses_img)
	{
		global $link;
		$date = date('Y-m-d');
		$sql="INSERT INTO tbl_pet_doses(pet_id,vaccination_id,given_date) VALUES('".$pet_id."','".$vaccination_id."','".$date."')";
		$result = mysqli_query($link,$sql);
		$id = mysqli_insert_id($link);
		$imagename = $id.".png";
		$path = "uploads/dose/$imagename";		
		$img = "http://www.discovermypet.in/pet/$path";		
		file_put_contents($path,base64_decode($doses_img));	
		
		$im = new Imagick($img);
		$im->scaleImage(500,0);
		$im->writeImage($path);  
		
		$sql_update="UPDATE tbl_pet_doses SET doses_img = '".$img."' WHERE id='".$id."' ";
		$result_update = mysqli_query($link,$sql_update);
		
		if(mysql_error() == "")		
		$returnarr = array("success" => 1, "error" => 0);
		else
		$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;	
	}
	function doses_list_andriod_name($vaccination_id,$pet_id,$doses_name)
	{
		global $link;
		$date = date('Y-m-d');
		
		$sql="INSERT INTO tbl_pet_doses(pet_id,vaccination_id,doses_name,given_date) VALUES('".$pet_id."','".$vaccination_id."','".$doses_name."','".$date."')";
		$result = mysqli_query($link,$sql);
		$id = mysqli_insert_id($link);
		
			
		if(mysql_error() == "")		
		$returnarr = array("success" => 1, "error" => 0);
		else
		$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;	
	}
	function edit_dose($dose_id,$dose_img,$dose_name)
	{
		global $link;
		
		$imagename = $dose_id.".png";
		$path = "uploads/dose/$imagename";		
		$img = "http://www.discovermypet.in/pet/$path";		
		file_put_contents($path,base64_decode($dose_img));	
		
		$sql_update="UPDATE tbl_pet_doses SET doses_img = '".$img."',doses_name = '".$dose_name."' WHERE id='".$dose_id."' ";
		$result_update = mysqli_query($link,$sql_update);
		if(mysql_error() == "")		
		$returnarr = array("success" => 1, "error" => 0);
		else
		$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function edit_dewormer($pet_id,$received_dte,$nxt_dte,$brand)
	{		
		global $link;
		$sql="UPDATE tbl_dewormer SET received_date = '".$received_dte."',next_date = '".$nxt_dte."',brand_name  ='".$brand."' WHERE pet_id = '".$pet_id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")	
		{		
			$returnarr = array("success" => 1, "error" => "0");
		}
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function get_dewormer($pet_id)
	{		
		global $link;
		$i = 0;
		$sql = "select pet_id,DATE_FORMAT(received_date,'%d-%m-%Y') as received_date,DATE_FORMAT(next_date,'%d-%m-%Y') as next_date,received_date as received_date_org,next_date as next_date_org, brand_name from tbl_dewormer where pet_id = '".$pet_id."'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		if(mysqli_num_rows($result) > 0)
		{
				$app_info[0] = array("pet_id" => $row["pet_id"],"received_date" => $row["received_date"],"next_date" => $row["next_date"],"brand_name" => $row["brand_name"],"next_date_org"=>$row["next_date_org"],"received_date_org"=>$row["received_date_org"]);
				$app_list = array("result" => $app_info);
				return $app_list;
		}
			else
				$returnarr = array("success" => 0, "error" => "no records found");		
			return $returnarr;
	}
	function add_dewormer($received_dte,$nxt_dte,$pet_id,$brand)
	{
		global $link;
		$sql = "INSERT into tbl_dewormer (received_date,next_date,pet_id,brand_name	) values ('".$received_dte."','".$nxt_dte."','".$pet_id."','".$brand."')";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;		
	}
	function get_dewormer_brand()
	{
		global $link;
		$i=0;
		$sql = "select dewormer_name from tbl_dewormer_brand";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("dewormer_name" => $row["dewormer_name"]);	
			$i++;
		}
			$app_list = array("success" => 1,"result" => $app_info);
			return $app_list;	
	}
	function add_allergy($allergy,$pet_id)
	{		
		global $link;
		$sql = "INSERT into allergy (allergy_name,pet_id, date_created) values ('".$allergy."','".$pet_id."', '".date('Y-m-d H:i:s')."')";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function get_allergy($pet_id)
	{		 
		global $link;
		$i = 0;
		$sql = "select id,allergy_name,date_created from allergy where pet_id = '".$pet_id."'";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result))
			{
				$app_info[$i] = array("allergy_id" => $row["id"],"allergy_name" => $row["allergy_name"],"date_created" => $row["date_created"]);
				$i++;
			}
			$app_list = array("success" => 1,"result" => $app_info);
			return $app_list;
		}
		else
		{
			$sql_pet = "SELECT allergy , date_created FROM pet_master WHERE id = '".$pet_id."'";
			$result_pet =  mysqli_query($link,$sql_pet);
			$row_pet = mysqli_fetch_array($result_pet);
			$app_info[0] = array("allergy_name" => $row_pet["allergy"],"date_created" => $row_pet["date_created"]);
				
			if(empty($app_info))
			{
				$app_list = array("success" => 0, "error" => "no records found");
				return $app_list;
			}
			else
			{
				$app_list = array("success" => 1,"result" => $app_info);
				return $app_list;		
			}			
		}	
	}
	function add_diet($pet_id,$diet)
	{		
		global $link;
		$sql = "INSERT into diet (pet_id,diet_name, date_created) values ('".$pet_id."','".$diet."', '".date('Y-m-d H:i:s')."')";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function get_diet($pet_id)
	{		
		global $link;
		$i = 0;
		$sql = "select id,diet_name,date_created from diet where pet_id = '".$pet_id."'";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("diet_id" => $row["id"],"diet_name" => $row["diet_name"],"date_created" => $row["date_created"]);
			$i++;
		}	
		if(empty($app_info))
		{
			$app_list = array("success" => 0,"error"=>"no records found");
			return $app_list; 
		}
		else
		{
			$app_list = array("success" => 1,"result" => $app_info);
			return $app_list;
		}	
	}
	function weight_graph($pet_id)
	{	
		global $link;
		$i=0;
		 $sql = "SELECT * FROM tbl_pet_vaccination WHERE pet_id='".$pet_id."'order by vaccination_id";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result))
			{
				$weight = str_replace(' Kg', '',$row["weight"]);
				$sql_vaccination = "SELECT * FROM tbl_vaccination_master WHERE id='".$row["vaccination_id"]."'";
				$result_vaccination = mysqli_query($link,$sql_vaccination);
				while($row_vaccination = mysqli_fetch_array($result_vaccination))
				{
					$app_info[$i] = array("title" => $row_vaccination["duration_title"],"weight" => $weight);
					$i++;
				}
			}
			$app_list = array("success" => 1,"result" => $app_info);
			return $app_list;
		}
		else
		{
			$returnarr = array("success" => 0, "error" => "no records found");
			return $returnarr;
		}
			
	}
	function add_medical_details($title,$pet_id)
	{		
		global $link;
		$sql = "INSERT into medical_details (title,pet_id,date_created) values ('".$title."','".$pet_id."', '".date('Y-m-d H:i:s')."')";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function get_medical_details($id)
	{		
		global $link;
		$i = 0;
		$sql = "select id,date_created,title from medical_details where pet_id = '".$id."'";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("id"=>$row["id"],"date1" => $row["date_created"],"title" => $row["title"]);
			$i++;
		}
		if (empty($app_info)) 
		{
			$app_list = array("success" => 0, "error" => "no records found");
			return $app_list;	
		}

		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
	}
	function edit_parasite_control($pet_id,$received_dte,$nxt_dte,$brand)
	{		
		global $link;
		$sql="UPDATE tbl_parasite_control SET received_date = '".$received_dte."',next_date = '".$nxt_dte."',brand_name  ='".$brand."' WHERE pet_id = '".$pet_id."' ";
		
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function get_parasite_control($pet_id)
	{		
		global $link;
		$i = 0;
		$sql = "select pet_id,DATE_FORMAT(received_date,'%d-%m-%Y') as received_date,DATE_FORMAT(next_date,'%d-%m-%Y') as next_date,received_date as received_date_org,next_date as next_date_org,brand_name from tbl_parasite_control where pet_id = '".$pet_id."'";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) > 0 )
		{
			$row = mysqli_fetch_array($result);
			$app_info[$i] = array("pet_id" => $row["pet_id"],"received_date" => $row["received_date"],"next_date" => $row["next_date"],"brand_name" => $row["brand_name"],"next_date_org"=>$row["next_date_org"],"received_date_org"=>$row["received_date_org"]);
			$app_list = array("success" => 1,"result" => $app_info);
			return $app_list;
			
		}
		else
		{
			$app_list = array("success" => 0, "error" => "no records found");
			return $app_list;	
			
		}
	}

	$possible_url = array("select_pet","vaccination_list","post_weight","post_vacc_date","get_doses_list_andriod","doses_list_andriod","edit_dose","edit_dewormer","get_dewormer","get_dewormer_brand","add_allergy","get_allergy","add_diet","add_dewormer","get_diet","weight_graph","add_medical_details","get_medical_details","edit_parasite_control","get_parasite_control");

	$value = "An error has occurred";
	
	
	if (isset($_POST["action"]) && in_array($_POST["action"], $possible_url))
	{
		
		switch ($_POST["action"])
		{
			case "select_pet":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							if(empty($_POST["user_id"]) OR empty($_POST["pet_type"]))
							{
								$value = array("success" => 0, "error" => 1);
								break; 
							}
							$value = select_pet($_POST["user_id"],$_POST["pet_type"]); 
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
			case "vaccination_list":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = vaccination_list($_POST["pet_id"],$_POST["user_id"]);
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
			case "post_weight":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = post_weight($_POST["vaccination_id"],$_POST["pet_id"],$_POST["weight"],$_POST["type"]);
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
			case "post_vacc_date":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = post_vacc_date($_POST["pet_id"],$_POST["vaccination_id"],$_POST["given_date"],$_POST["next_date"]);
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
			case "get_doses_list_andriod":
			if(!empty($_POST["key"]))
			{
				$key = $_POST["key"];
				$txt = Encrypt('myPass123', $key);
				if($txt)
				{			
					$value = get_doses_list_andriod($_POST["vaccination_id"],$_POST["pet_id"]); 
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
			case "doses_list_andriod":
			if(!empty($_POST["key"]))
			{
				$key = $_POST["key"];
				$txt = Encrypt('myPass123', $key);
				if($txt)
				{	
					if(!empty($_POST["doses_img"]) AND !empty ($_POST["doses_name"]))
					{					
						$value = doses_list_andriod($_POST["vaccination_id"],$_POST["pet_id"],$_POST["doses_name"],$_POST["doses_img"],$_POST["given_date"]); 
					}
					elseif(!empty($_POST["doses_img"]))
					{
						$value = doses_list_andriod_img($_POST["vaccination_id"],$_POST["pet_id"],$_POST["doses_img"],$_POST["given_date"]); 
					}
					else
					{					
						$value = doses_list_andriod_name($_POST["vaccination_id"],$_POST["pet_id"],$_POST["doses_name"],$_POST["given_date"]);
					}				
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
			case "edit_dose":
			if(!empty($_POST["key"]))
			{
				$key = $_POST["key"];
				$txt = Encrypt('myPass123', $key);
				if($txt)
				{
					$value = edit_dose($_POST["dose_id"],$_POST["dose_img"],$_POST["dose_name"]); 
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
			case "edit_dewormer":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_dewormer($_POST["pet_id"],$_POST["received_dte"],$_POST["nxt_dte"],$_POST["brand"]);
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
			case "get_dewormer":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_dewormer($_POST["pet_id"]); 
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
			case "add_dewormer":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = add_dewormer($_POST["received_dte"],$_POST["nxt_dte"],$_POST["pet_id"],$_POST["brand"]); 
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
			case "get_dewormer_brand":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_dewormer_brand(); 
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
			case "add_allergy":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = add_allergy($_POST["allergy"],$_POST["pet_id"]);
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
			case "get_allergy":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_allergy($_POST["pet_id"]);
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
			case "add_diet":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = add_diet($_POST["pet_id"],$_POST["diet"]);
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
			case "get_diet":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_diet($_POST["pet_id"]);
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
			case "weight_graph":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = weight_graph($_POST["pet_id"]);
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
			case "add_medical_details":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = add_medical_details($_POST["title"],$_POST["pet_id"]);
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
			case "get_medical_details":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_medical_details($_POST["id"]);
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
			case "edit_parasite_control":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value =edit_parasite_control($_POST["pet_id"],$_POST["received_dte"],$_POST["nxt_dte"],$_POST["brand"]);
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
			case "get_parasite_control":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_parasite_control($_POST["pet_id"]); 
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