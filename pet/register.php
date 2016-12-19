<?php 
	include('config/config.php');
	function register($name, $email, $password,$latitude,$longitude)
	{	
		global $link;
		$sql_already = "select email from app_users where email = '".$email."'and is_active =1";
		$result_already = mysqli_query($link,$sql_already);
		$row_already = mysqli_fetch_array($result_already);
		if(mysqli_num_rows($result_already) > 0)
		{
				$returnarr = array("success" => 0, "error" => "Email already registered");
				return $returnarr;
		}
		else
		{
			$j=0;
			if($latitude !='0.0' AND $longitude !='0.0' )
			{			
				$address= getaddress($latitude,$longitude);
				$teststr = explode(", ",$address);
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
			}
			else
			{
				$country = 'India';
				$pincode = '411038';
				$city = 'Pune';
				$address1 = '';
				$address2 = '';			
			}
			$error = "";
			if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false)
			{
				$error = "";
			} 
			else 
			{
				if($email != "")
				$error = "$email is not a valid email address";
			}
			if($error == "")
			{
				$sql = "INSERT into app_users (name, email,password,city,pincode,address1,address2,latitude,longitude,created_date) values ('".$name."', '".$email."', '".$password."','".$city."','".$pincode."','".$address1."','".$address2."','".$latitude."','".$longitude."','".date('Y-m-d')."')";
				
				include_once('email/mail.php');	
				register_mail($name,$email,$password); // For Register mail			
			
				$result = mysqli_query($link,$sql);
				$id = mysqli_insert_id($link);	
				if(mysql_error() == "")				
				
					$returnarr = array("success" => 1, "error" => 0,"id"=>$id);
				else
					$returnarr = array("success" => 0, "error" => mysql_error());		

				return $returnarr;
			}
				else
				$returnarr = array("success" => 0, "error" => $error);

				return $returnarr;
			}
	}
	function fb_register($fb_id,$name,$email,$img,$latitude,$longitude)
	{
		global $link;
		if($email !='null')
		{
			$sql_already = "select id,email,password from app_users where email = '".$email."'and is_active =1";
			$result_already = mysqli_query($link,$sql_already);
			$row_already = mysqli_fetch_array($result_already);
		}
		elseif($fb_id!='')
		{
			$sql_already = "select id,email,password from app_users where fb_id = '".$fb_id."'and is_active =1";
			$result_already = mysqli_query($link,$sql_already);
			$row_already = mysqli_fetch_array($result_already);
		}
		
		if(mysqli_num_rows($result_already) > 0)
		{
			$id = $row_already["id"];
			$password = $row_already["password"];
			
			$sql = "UPDATE app_users SET fb_id ='".$fb_id."' WHERE id = '$id'";
			$result = mysqli_query($link,$sql);
			
			//$returnarr = array("success" => 0, "error" => "Email already registered");
			$returnarr = array("success" => 1, "error" => 0,"id"=>$id,"flag"=>1,"password"=>$password);
			return $returnarr;
		}
		else
		{
			$j=0;
			if($latitude !='0.0' AND $longitude !='0.0' )
			{	
				$address= getaddress($latitude,$longitude);
				$teststr = explode(", ",$address);
				for($i=count($teststr)-1;$i>=0;$i--)
				{
					$test[$j] = $teststr[$i] ;
					$j++;
				}
				$country = $test[0];
				$int = $test[1];
				$pincode = intval(preg_replace('/[^0-9]+/', '', $int), 10);
				$city = $test[2];
				$address1 = $test[3];
				$address2 = $test[4];
			}
			else
			{ 
				$country = 'India';
				$pincode = '411038';
				$city = 'Pune';
				$address1 = '';
				$address2 = '';			
			}
			$password = randomPassword();
				
			$error = "";
			if($error == "")
			{
				$sql = "INSERT into app_users (fb_id,name, email,password,city,pincode,address1,address2,latitude,longitude, created_date) values ('".$fb_id."','".$name."', '".$email."', '".$password."','".$city."','".$pincode."','".$address1."','".$address2."','".$latitude."','".$longitude."','".date('Y-m-d')."')";

				$result = mysqli_query($link,$sql);
				$id = mysqli_insert_id($link);	
				if(mysql_error() == "")				
				
					$returnarr = array("success" => 1, "error" => 0,"id"=>$id,"flag"=>0,"password"=>$password);
				else
					$returnarr = array("success" => 0, "error" => mysql_error());		

				return $returnarr;
			}
				else
				$returnarr = array("success" => 0, "error" => $error);

				return $returnarr;
		}
		
	}
	function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

	function signin($email,$password,$registration_id)
	{	
		global $link;
		$error = "";
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) 
		{
			$error = "";
		} 
		else
		{
			if($email != "")
			$error = "$email is not a valid email address";
		}
		if($error == "")
		{
			$sql = "select id ,email, password from app_users where email = '".$email."' and password = '".$password."' and is_active ='1'" ;
			$result = mysqli_query($link,$sql);
			$row = mysqli_fetch_array($result);
			if(mysqli_num_rows($result) > 0)
			{
				$sql_update = "UPDATE app_users SET gcm_id = '".$registration_id."' WHERE id = '".$row["id"]."'";
				$result_update = mysqli_query($link,$sql_update);
				
				$returnarr = array("success" => 1, "error" => 0,"id"=>$row["id"]);	
			}		
			else
				$returnarr = array("success" => 0, "error" => 1);		
		}
		else
		{
			$returnarr = array("success" => 0, "error" => 1);
		}
		return $returnarr;		
	}
	function send_verification_code($user_id,$mobile)
	{	
		global $link;	
		
		$sql_already = "select mobile from app_users where mobile = '".$mobile."'and is_active =1";
		$result_already = mysqli_query($link,$sql_already);
		$row_already = mysqli_fetch_array($result_already);
		if(mysqli_num_rows($result_already) > 0)
		{
			$returnarr = array("success" => 0, "error" => "Mobile already registered");
			return $returnarr;
		}
		else
		{	
			$code = rand(1000, 9999); 
			//$mobile = "91".$mobile;
				
				$sql_nm = "SELECT name FROM app_users WHERE id = '".$user_id."'";
				$result_nm = mysqli_query($link,$sql_nm);
				$row_nm = mysqli_fetch_array($result_nm);
				$name = $row_nm["name"];
			
				$sql = "UPDATE app_users SET verify_code = '".$code."',mobile= '".$mobile."' WHERE id = '".$user_id."' ";
				mysqli_query($link,$sql);		
				
				if(mysql_error() == "")				
				{
					$user_msg = urlencode("Dear $name, Thanks for registering with us. Your verification code is $code, Kindly use this code to proceed. Thanks.");
					send_sms_otp($user_msg, $mobile);
					$value = array("success" => 1, "error" => 0,"id"=>$user_id);
				}		
				else
				$value = array("success" => 0, "error" => mysql_error());	
				
		
			return $value ;
		}
	}

	function send_otp($user_id)
	{	
		global $link;	
		
		$code = rand(1000, 9999); 
			
		$sql_user = "select name,mobile from app_users where id = '".$user_id."' ";
		$result_user = mysqli_query($link,$sql_user);
		$row_user = mysqli_fetch_array($result_user);
		$name = $row_user["name"];
		$mobile = $row_user["mobile"];
			
		$sql = "UPDATE app_users SET verify_code = '".$code."' WHERE id = '".$user_id."' ";
		mysqli_query($link,$sql);
		if(mysql_error() == "")				
		{
			$user_msg = urlencode("Dear $name, Thanks for registering with us. Your verification code is $code. Kindly use this code to proceed. Thanks,");
			send_sms_otp($user_msg, $mobile);
			$value = array("success" => 1, "error" => 0);
		}		
		else
		$value = array("success" => 0, "error" => mysql_error());	
					
		
		return $value ;
	}
	function verify_registration($user_id,$code)
	{		
		global $link;	
		$i = 0;	
		$sql = "select email from app_users where id = '".$user_id."' and verify_code= '".$code."'";

		$result = mysqli_query($link,$sql);	
		if(mysqli_num_rows($result) == 0)
		{
			$value = array("success" => 0, "error" => "Not verified");
		}
		else
		{
			$sql = "UPDATE app_users SET image ='http://www.discovermypet.in/pet/uploads/socialprofile/default-user-image.png',verify_code = '',is_active ='1' WHERE id = '".$user_id."'";
			mysqli_query($link,$sql);
			$value = array("success" => 1, "error" => 0);
		}	
		return $value ;
	}
	
	function homescreen($user_id,$latitude,$longitude)
	{
		global $link; //flag 1 for coming soon 
		$i=0;		//flag 0 for menu show
		$j=0;
		$k=0;
		$l=0;
		if($latitude != '0.0' and $longitude != '0.0')
		{
			$address= getaddress($latitude,$longitude);
			$teststr = explode(", ",$address);
			for($k=count($teststr)-1;$k>=0;$k--){
				$test[$l] = $teststr[$k] ;
				$l++;
			}
			$country = $test[0];
			$int = $test[1];
			$pincode = intval(preg_replace('/[^0-9]+/', '', $int), 10);
			$city2 = $test[2];
			$address1 = $test[3];
			$address2 = $test[4];	
			
			$sql_loc="UPDATE app_users SET current_city = '".$city2."' WHERE id = '".$user_id."' ";
			$result_loc = mysqli_query($link,$sql_loc);
					
			$sql ="select * from tbl_homescreen order by id";
			$result = mysqli_query($link,$sql);
			$sql_city = "SELECT city_name FROM tbl_city WHERE status = '1'";
			$result_city = mysqli_query($link,$sql_city);
			while($row_city = mysqli_fetch_array($result_city))
			{
				$city[$j] =  $row_city["city_name"];
				$city1 = implode("','",$city);
				$j++;	
			}		
			//$sql_address = "SELECT city FROM app_users WHERE id = '".$user_id."' and current_city IN ('$city1') ";
			
			$sql_address = "SELECT city FROM app_users WHERE id = '".$user_id."' and current_city ='Nagpur'";
		}
		else
		{
			$sql ="select * from tbl_homescreen order by id";
			$result = mysqli_query($link,$sql);
			$sql_city = "SELECT city_name FROM tbl_city WHERE status = '1'";
			$result_city = mysqli_query($link,$sql_city);
			while($row_city = mysqli_fetch_array($result_city))
			{
				$city[$j] =  $row_city["city_name"];
				$city1 = implode("','",$city);
				$j++;	
			}		
			//$sql_address = "SELECT city FROM app_users WHERE id = '".$user_id."' and city IN ('$city1') ";
			$sql_address = "SELECT city FROM app_users WHERE id = '".$user_id."' and current_city ='Nagpur'";
			
		}		
		$result_address = mysqli_query($link,$sql_address);
		if(mysqli_num_rows($result_address) == 0)  // Location is present so buy service showing
		{
			while($row = mysqli_fetch_array($result))
			{
				$app_info[$i] =  array("menu_name" => $row["menu_name"],"menu_img" => $row["menu_img"],"order"=>$i+1);
				$i++;
				}
			$sql_notification ="SELECT who_id FROM tbl_notification WHERE who_id ='".$user_id."'and is_read=0";
			$result_notification = mysqli_query($link,$sql_notification);
			$count = mysqli_num_rows($result_notification);
			if($row_notification = mysqli_fetch_array($result_notification) > 0)
			{
				//$app_list = array("success" => 1,"result" => $app_info,"notification"=>1,"flag"=>"1");
				$app_list = array("success" => 1,"result" => $app_info,"notification"=>$count,"flag"=>"0");
			}
			else
			{
				//$app_list = array("success" => 1,"result" => $app_info,"notification"=>0,"flag"=>"1");
				$app_list = array("success" => 1,"result" => $app_info,"notification"=>0,"flag"=>"0");
			}		
			
		}
		else    // Location is not present so buy service showing
		{
			while($row = mysqli_fetch_array($result))
			{
				$app_info[$i] =  array("menu_name" => $row["menu_name"],"menu_img" => $row["menu_img"],"order"=>$i+1);
				$i++;
				}
			$sql_notification ="SELECT who_id FROM tbl_notification WHERE who_id ='".$user_id."'and is_read=0";
			$result_notification = mysqli_query($link,$sql_notification);
			$count = mysqli_num_rows($result_notification);
			
			if($row_notification = mysqli_fetch_array($result_notification) > 0)
			{
				$app_list = array("success" => 1,"result" => $app_info,"notification"=>$count,"flag"=>"0");
			}
			else
			{
				$app_list = array("success" => 1,"result" => $app_info,"notification"=>0,"flag"=>"0");
			}		
		}	
	/* 	$sql_update = "Update tbl_notification SET is_read=1 WHERE who_id ='".$user_id."'";
		$result_update = mysqli_query($link,$sql_update); */
		
		
		return $app_list;
	}
	function adverstise()
	{
		global $link;
		$i=0;
		$sql ="select * from tbl_advertise";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] =  array("advertise_img" => $row["advertise_img"],"link" => $row["link"],"order"=>$row["order_no"]);
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
	}

	$possible_url = array("register","fb_register","signin","send_verification_code","verify_registration","send_otp","adverstise","homescreen");

	$value = "An error has occurred";
	
	
	if (isset($_POST["action"]) && in_array($_POST["action"], $possible_url))
	{
		
		switch ($_POST["action"])
		{
			case "adverstise":
			$value = adverstise();
			break; 
			case "homescreen":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = homescreen($_POST["user_id"],$_POST["latitude"],$_POST["longitude"]);
						}
						else
						{
							$value = "Sorry..Something went wrong..!!";						
						}
					}
					else
					{
						echo "pass key";
						$value = "Sorry..Something went wrong..!!";
					}		
			break; 			
			case "register":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							if(empty($_POST["name"]) OR empty($_POST["email"]) OR empty($_POST["password"]) OR empty($_POST["latitude"])OR empty($_POST["longitude"]))
							{
								$value = array("success" => 0, "error" => 1);
								break; 
							}
							$value = register($_POST["name"],$_POST["email"],$_POST["password"],$_POST["latitude"],$_POST["longitude"]);
						}
						else
						{
							$value = "Sorry..Something went wrong..!!";						
						}
					}
					else
					{
						echo "pass key";
						$value = "Sorry..Something went wrong..!!";
					}						
			break;
			case "fb_register":
				if(!empty($_POST["key"]))
				{
					$key = $_POST["key"];
					$txt = Encrypt('myPass123', $key);
					if($txt)
					{
						$value = fb_register($_POST["fb_id"],$_POST["name"],$_POST["email"], $_POST["image"], $_POST["latitude"], $_POST["longitude"]);
					}
					else
					{
						$value = "Sorry..Something went wrong..!!";						
					}
				}
				else
				{
					//echo "pass key";
					$value = "Sorry..Something went wrong..!!";
				}			
			break;
			case "signin":
					
					if(!empty($_POST["key"]))
					{
						
						
						$key = $_POST["key"];
						
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
								
							if(empty($_POST["email"]) OR empty($_POST["password"]) OR empty($_POST["registration_id"]))
							{
							$value = array("success" => 0, "error" => 1);
							break; 
						}
						$value = signin($_POST['email'], $_POST['password'], $_POST['registration_id']);
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
			case "chng_pwd":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							if(empty($_POST["user_id"]) OR empty($_POST["new_pwd"]) OR empty($_POST["current_pwd"]))
							{
							$value = array("success" => 0, "error" => 1);
							break; 
						}
						$value = chng_pwd($_POST['user_id'],$_POST['new_pwd'],$_POST['current_pwd']);
						}
						else
						{
							$value = "Sorry..Something went wrong..!!";	
						}
					}
					else
					{
						echo "pass key";
						$value = "Sorry..Something went wrong..!!";
					}				
			break;
			
			case "welcome":		
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = welcome($_POST["user_id"]);
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
			case "send_verification_code":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$mobile = $_POST["mobile"];
							if(preg_match('/^\d{12}$/',$mobile))
							{
								$value = send_verification_code($_POST["user_id"],$_POST["mobile"]); 
							}
							else
							{
								$value = array("success" => 0, "flag" =>1);
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
			case "send_otp":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = send_otp($_POST["user_id"]); 
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
			case "verify_registration":
					
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = verify_registration($_POST["user_id"],$_POST["code"]); 
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