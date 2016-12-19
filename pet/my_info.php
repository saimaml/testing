<?php 
	include_once('config/config.php');
	function get_my_info($id)
	{	
		global $link;	 
		$i = 0;
		$sql = "select * from app_users where id = '".$id."' and is_active ='1'";
		$result = mysqli_query($link,$sql);
		
		if(mysqli_num_rows($result) != 0)
		{		
			$row = mysqli_fetch_array($result);
			if(!empty( $row["mobile"]))
			{
				$mobile = $row["mobile"];
				$mobile = substr($mobile, 2);  
				 
				$name = ucwords($row["name"]);
				 
				$app_info[0] = array("name" => $name,"email" => $row["email"],"mobile" => $mobile,"address1" => $row["address1"],"address2" => $row["address2"],"city" => $row["city"],"pincode" => $row["pincode"],"latitude" => $row["latitude"],"longitude" => $row["longitude"]);
			}
			else
			{
				$app_info[0] = array("name" => $row["name"],"email" => $row["email"],"mobile" => "","address1" => $row["address1"],"address2" => $row["address2"],"city" => $row["city"],"pincode" => $row["pincode"],"latitude" => $row["latitude"],"longitude" => $row["longitude"]);
			}
			
		$app_list = array("success" => 1,"result" => $app_info);
		}
		else
			$app_list = array("success" => 0, "error" => 1);
			
		return $app_list;
	}
	function edit_my_info_all($id,$name,$email,$mobile,$latitude, $longitude)
	{		
		global $link;
		$j=0;
			$address= getaddress($latitude,$longitude);
			$teststr = explode(",",$address);
			for($i=count($teststr)-1;$i>=0;$i--){
				$test[$j] = $teststr[$i] ;
				$j++;
			}
			$country = $test[0];
			$int = $test[1];
			$pincode = intval(preg_replace('/[^0-9]+/', '', $int), 10);
			$city = $test[2];
			$address1 = $test[3];
			$address2 = $test[4];
			$mobile = "91".$mobile;

		$sql="UPDATE app_users SET name = '".$name."',email = '".$email."',mobile = '".$mobile."',address1 = '".$address1."',address2 = '".$address2."',pincode = '".$pincode."',city = '".$city."', latitude = '".$latitude."', longitude = '".$longitude."' WHERE id = '".$id."' ";
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
	function edit_my_doctor_andriod($user_id,$doctor_name,$contact_no,$dr_address,$dr_clinic_name,$dr_time,$dr_time1,$dr_img,$dr_specification,$dr_experience,$dr_qulification,$vci_reg_no)
	{		
		global $link;
		$imagename = $user_id.".png";
		$path = "uploads/$imagename";		
		$img = "http://www.discovermypet.in/pet/$path";		
		file_put_contents($path,base64_decode($dr_img));		
		$sql="UPDATE app_users SET doctor_name = '".$doctor_name."',contact_no = '".$contact_no."',dr_address = '".$dr_address."',dr_clinic_name = '".$dr_clinic_name."',dr_img = '".$img."',dr_time = '".$dr_time."',dr_time1 = '".$dr_time1."',dr_specification = '".$dr_specification."',dr_experience = '".$dr_experience."',dr_qulification = '".$dr_qulification."',vci_reg_no = '".$vci_reg_no."' WHERE id = '".$user_id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function get_dr_list($search)
	{
		global $link;	
		$i = 0;	
		$sql = "SELECT id,name,city FROM tbl_service_details WHERE id='0' and name LIKE '%$search%'";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) != 0)
		{		
			while($row = mysqli_fetch_array($result))
			{
				$app_info[$i] = array("id" => $row["id"],"name" => $row["name"],"city" => $row["city"]);				
				$i++;
			}
			$app_list = array("success" => 1,"result" => $app_info);
		}
		else
		{
			$app_list = array("success" => 0, "error" => 1);
		}
		return $app_list;
		
	}
	function get_drlist($id)
	{
		global $link;	
		$i = 0;	
		$sql = "SELECT id,name,clinic_name,address1,city,phone_no,year_of_experience,vci_reg_no,working_time, working_time1 FROM tbl_service_details WHERE id = '$id'";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) != 0)
		{		
			while($row = mysqli_fetch_array($result))
			{
				if($row["clinic_name"]=="null")
				{
					
				}
				else
				{
					$app_info[$i] = array("id" => $row["id"],"name" => $row["name"],"clinic_name" => $row["clinic_name"],"address" => $row["address1"],"city" => $row["city"],"phone_no" => $row["phone_no"],"year_of_experience" => $row["year_of_experience"],"vci_reg_no" => $row["vci_reg_no"],"dr_time1" => $row["working_time1"],"dr_time" => $row["working_time"]);			
				}
					
				$i++;
			}
			$app_list = array("success" => 1,"result" => $app_info);
		}
		else
		{
			$app_list = array("success" => 0, "error" => 1);
		}
		return $app_list;
	}
	function get_specility()
	{
		global $link;
		$sql = "SELECT id,specility_name FROM tbl_dr_specility";
		$result = mysqli_query($link,$sql);
		
		if(mysqli_num_rows($result) != 0)
		{	
			$i=0;
			while($row = mysqli_fetch_array($result))
			{
				$app_info[$i] = array("id" => $row["id"],"specility_name" => $row["specility_name"]);
				$i++;
			}
			
			$app_list = array("success" => 1,"result" => $app_info);
		}
		else
			$app_list = array("success" => 0, "error" => 1);
			
		return $app_list;
	}
	function get_my_doctor($user_id)
	{		
		global $link;
		$i=0;
		$sql="SELECT doctor_name,contact_no,dr_address,dr_clinic_name,dr_time,dr_time1,dr_img,dr_specification,dr_experience,dr_qulification,vci_reg_no from app_users  WHERE id = '".$user_id."' ";
		$result = mysqli_query($link,$sql);
		
		while($row = mysqli_fetch_array($result))
		{
			$sql_specialization = "SELECT specility_name FROM tbl_dr_specility WHERE id = '".$row['dr_specification']."'";
			$result_specilization = mysqli_query($link,$sql_specialization);
			$row_specilization = mysqli_fetch_array($result_specilization);
			if($row["doctor_name"] =="")
			{
				$app_list = array("success" => 0, "error" => "no records found");
				return $app_list; 		
			}
			else
			{
				$app_info[$i] = array("doctor_name" => $row["doctor_name"],"contact_no" => $row["contact_no"],"dr_address" => $row["dr_address"],"dr_clinic_name" => $row["dr_clinic_name"],"dr_time" => $row["dr_time"],"dr_time1" => $row["dr_time1"],"dr_img" => $row["dr_img"],"dr_specification" =>$row_specilization["specility_name"],"dr_experience" => $row["dr_experience"],"dr_qulification" => $row["dr_qulification"],"vci_reg_no" => $row["vci_reg_no"]);
				$i++;
			}
			
		}
		
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
	$possible_url = array("get_my_info","edit_my_info_all","edit_my_doctor_andriod","get_dr_list","get_drlist","get_specility","get_my_doctor");

	$value = "An error has occurred";
	
	
	if (isset($_POST["action"]) && in_array($_POST["action"], $possible_url))
	{
		
		switch ($_POST["action"])
		{
			case "edit_my_info":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_my_info($_POST["id"],$_POST["latitude"],$_POST["longitude"]); 
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
			case "get_my_info":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_my_info($_POST["id"]); 
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
			case "edit_my_info_all":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_my_info_all($_POST["id"],$_POST["name"],$_POST["email"],$_POST["mobile"],$_POST["latitude"],$_POST["longitude"]); 
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
			case "edit_my_doctor_andriod":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_my_doctor_andriod($_POST["user_id"],$_POST["doctor_name"],$_POST["contact_no"],$_POST["dr_address"],$_POST["dr_clinic_name"],$_POST["dr_time"],$_POST["dr_time1"],$_POST["dr_img"],$_POST["dr_specification"],$_POST["dr_experience"],$_POST["dr_qulification"],$_POST["vci_reg_no"]);
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
			case "get_dr_list":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_dr_list($_POST["search"]); 
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
			case "get_drlist":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_drlist($_POST["id"]); 
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
			case "get_specility":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_specility();
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
			case "get_my_doctor":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_my_doctor($_POST["user_id"]);
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