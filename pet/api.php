<?php
	include_once('config/config.php');	
	
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
				$sql = "INSERT into app_users (name, email,password,city,pincode,address1,address2,latitude,longitude, created_date) values ('".$name."', '".$email."', '".$password."','".$city."','".$pincode."','".$address1."','".$address2."','".$latitude."','".$longitude."','".date('Y-m-d')."')";
				
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
	function get_service_category($user_id)
	{
		global $link;
		
		$sql_city = "SELECT city FROM app_users WHERE id = '".$user_id."' ";
		$result_city = mysqli_query($link,$sql_city);
		$row_city = mysqli_fetch_array($result_city);
		
		$sql_city_id = "SELECT id FROM tbl_city WHERE city_name = '".$row_city['city']."'";
		$result_city_id = mysqli_query($link,$sql_city_id);
		$row_city_id = mysqli_fetch_array($result_city_id);
		
		$sql = "SELECT id,service_master,website_img FROM tbl_service_master WHERE city_id = '".$row_city_id['id']."'and id !='0' order by id";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) != 0)
		{	
			$i=0;
			while($row = mysqli_fetch_array($result))
			{
				$app_info[$i] = array("id" => $row["id"],"service_master" => $row["service_master"],"service_img" => $row["website_img"]);
				$i++;
			}	
			$app_list = array("success" => 1,"result" => $app_info,"current_city"=>$row_city['city']);
		}
		else
			$app_list = array("success" => 0, "error" => 1);
			
		return $app_list;
	}
	function city_wise_service_master($city_id)
	{
		global $link;
		
		$sql_city_id = "SELECT city_name FROM tbl_city WHERE id = '".$city_id."'";
		$result_city_id = mysqli_query($link,$sql_city_id);
		$row_city_id = mysqli_fetch_array($result_city_id);
		
		//$sql = "SELECT id,service_master,service_img FROM tbl_service_master WHERE city_id = '".$city_id."'";
		$sql = "SELECT id,service_master,website_img FROM tbl_service_master WHERE id !='0' ";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) != 0)
		{	
			$i=0;
			while($row = mysqli_fetch_array($result))
			{
				$app_info[$i] = array("id" => $row["id"],"service_master" => $row["service_master"],"service_img" => $row["website_img"]);
				$i++;
			}	
			$app_list = array("success" => 1,"result" => $app_info,"current_city"=>$row_city_id["city_name"]);
		}
		else
			$app_list = array("success" => 0, "error" => 1);
			
		return $app_list;
		
	}
	function get_city()
	{
		global $link;
		$sql = "SELECT id,city_name FROM tbl_city";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) != 0)
		{	
			$i=0;
			while($row = mysqli_fetch_array($result))
			{
				$app_info[$i] = array("id" => $row["id"],"city_name" => $row["city_name"]);
				$i++;
			}
			$app_list = array("success" => 1,"result" => $app_info);
		}
		else
			$app_list = array("success" => 0, "error" => 1);
			
		return $app_list;	
	}

	function get_service_category_details($cat_id,$city_name)
	{
		global $link;
		$i=0;
		
		$sql = "SELECT id,name,address1,address2,city,year_of_experience,working_time,phone_no FROM tbl_service_details WHERE service_cat_id = '$cat_id' and city = '$city_name'";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) != 'null')
		{	
			$i=0;
			while($row = mysqli_fetch_array($result))
			{
				$sql_rating = "SELECT avg(rating) as rating FROM `tbl_rating` WHERE service_id = '".$row['id']."'";
				$result_rating = mysqli_query($link,$sql_rating);
				$row_rating = mysqli_fetch_array($result_rating);
				$address =  $row["address1"].",".$row["address2"];
				if($row_rating["rating"] != 0)
				{				
					$app_info[$i] = array("id" => $row["id"],"name" => $row["name"],"address" => $address,"city" => $row["city"],"year_of_experience" => $row["year_of_experience"],"working_time" => "Available","phone_no" => $row["phone_no"],"rating"=> $row_rating["rating"]);
				}
				else 
				{
					$app_info[$i] = array("id" => $row["id"],"name" => $row["name"],"address" => $address,"city" => $row["city"],"year_of_experience" => $row["year_of_experience"],"working_time" => "Available","phone_no" => $row["phone_no"],"rating"=> "0");
				}				
				
				$i++;
			}
			$sql_banner = "SELECT service_img,banner_img FROM tbl_service_master WHERE id = '".$cat_id."'";
			$result_banner = mysqli_query($link,$sql_banner);
			$row_banner = mysqli_fetch_array($result_banner);
			$banner = array();
			
			$banner_img = explode(",",$row_banner["banner_img"]);
			for($m=0;$m<count($banner_img);$m++)
			{
				$banner[] = $banner_img[$m];
			}
				
			//$app_info[$i]["banner"] = $banner;	
			
			$app_list = array("success" => 1,"result" => $app_info,"icon_img"=>$row_banner["service_img"],"banner"=>$banner,"service_detail_img"=>$banner_img[0]);
		}
		else
			$app_list = array("success" => 0, "error" => 1,"service_detail_img"=>"");
			
		return $app_list;
		
	}
	function forget_pwd($email)
	{
		global $link;
		$i = 0;
		$sql = "select email,password from app_users where email = '".$email."'";
		$result = mysqli_query($link,$sql);
		$count=mysqli_num_rows($result);
		if($count>=1)
		{	
			$to = $email;
			$subject = "Forgot password";
			
			$email1 = str_rot13($email);
			$message = "
			<html>
			<head>
			<title>Forgot password</title>
			</head>
			<body style='background-color: #efefef;height: 335px;'>		
			<img style='margin-left: 100px;padding-top: 20px;' src='http://www.discovermypet.in/pet/uploads/dmp_logo.__orange.png'/>
			<div style='background-color: #fff;height: 150px;margin-bottom: -64px;    margin-left: 100px;width: 577px;' >
			<p style='color: rgb(149, 33, 52); font-size: 24px; padding-top: 32px; text-align: center;'>Welcome to DiscoverMyPet</p>
			<p style='font-size: 20px; text-align: center;'>Click here <a href='http://www.discovermypet.in/pet/reset_pwd.php?email=$email1'>Open Link</a> </p>
			</body>
			</html>
			";

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <info@discovermypet.in>' . "\r\n"; 

			mail($to,$subject,$message,$headers);			
		
			return $returnarr = array("success" => 1, "error" => 0);
		}
		else
			echo "Invalid email...";
		return $returnarr = array("success" => 0, "error" => 1);		
	}
	function reset_pwd($password,$email)
	{
		global $link;
			
		$sql = "UPDATE app_users SET password = '".$password."' WHERE email = '".$email."'";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = "Your Password successfully changed";
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;	
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
	function signin($email, $password,$registration_id)
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
	/*function signin($email, $password)
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
		
	} */
	function chng_pwd($user_id,$new_pwd,$current_pwd)
	{
		global $link;
		$sql = "select id ,name from app_users where id = '".$user_id."' and password ='".$current_pwd."'";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) != 0)
		{
			$sql_update = "UPDATE app_users set password = '".$new_pwd."' WHERE id = '".$user_id."'";
			$result_update = mysqli_query($link,$sql_update);
			if(mysql_error() == "")				
			{
				$app_list = array("success" => 1,"error" => 0);
			}
			else
			{
				$app_list = array("success" => 0,"error" => 1);
			}		
		}
		else
			$app_list = array("success" => 0, "error" => "password not match");
			
		return $app_list;
		
	}
	function welcome($user_id)
	{
		global $link;
		$sql = "select id ,name from app_users where id = '".$user_id."' and is_active ='1'";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) != 0)
		{
			$row = mysqli_fetch_array($result);
			$app_info[0] = array("user_id" => $row["id"],"name" => $row["name"]);
			$app_list = array("success" => 1,"result" => $app_info);
		}
		else
			$app_list = array("success" => 0, "error" => 1);
			
		return $app_list;
	}
	function get_tips_news()
	{
		global $link;
		$i=0;
		$sql = "SELECT id,title,description,image,DATE_FORMAT(created_date,'%d-%m-%Y') as created_date FROM tbl_news";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result))
			{
				$short_desc= substr($row["description"],0,25)." more...";
				$url = "http://www.discovermypet.in/blog_details.php?id=".$row["id"];
				
				$app_info[$i] = array("id" => $row["id"],"news_title" => $row["title"],"news_desc" => $row["description"],"desc_short" => $short_desc,"news_img" => $row["image"],"news_link" => $url,"created_date" => $row["created_date"]);
				$i++;
			}
			$app_list = array("success" => 1,"result" => $app_info);
			return $app_list;
		}
		else
		{
			$value = array("success" => 0, "error" => "No News");
			return $value;
		}	
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
	function verify_registration($mobile, $email, $code)
	{		
		global $link;	
		$i = 0;	
		$sql = "select email from app_users where email = '".$email."' and mobile = '".$mobile."' and verify_code= '".$code."'";

		$result = mysqli_query($link,$sql);	
		if(mysqli_num_rows($result) == 0)
		{
			$value = array("success" => 0, "error" => "Not verified");
		}
		else
		{
			$sql = "UPDATE app_users SET image ='http://www.discovermypet.in/pet/uploads/socialprofile/default-user-image.png',verify_code = '',is_active ='1' WHERE email = '".$email."' and mobile= '".$mobile."'";
			mysqli_query($link,$sql);
			$value = array("success" => 1, "error" => 0);
		}	
		return $value ;
	}	
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
	function get_dr_list($search)
	{
		global $link;	
		$i = 0;	
		$sql = "SELECT id,name,city FROM tbl_service_details WHERE name LIKE '%$search%'";
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
		$sql = "SELECT id,name,clinic_name,address1,city,phone_no,year_of_experience,vci_reg_no,dr_time, dr_time1 FROM tbl_service_details WHERE id = '$id'";
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
					$app_info[$i] = array("id" => $row["id"],"name" => $row["name"],"clinic_name" => $row["clinic_name"],"address" => $row["address1"],"city" => $row["city"],"phone_no" => $row["phone_no"],"year_of_experience" => $row["year_of_experience"],"vci_reg_no" => $row["vci_reg_no"],"dr_time1" => $row["dr_time1"],"dr_time" => $row["dr_time"]);			
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
	function edit_my_info($id, $latitude, $longitude)
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

		
		$sql="UPDATE app_users SET address1 = '".$address1."',address2 = '".$address2."',pincode = '".$pincode."',city = '".$city."', latitude = '".$latitude."', longitude = '".$longitude."' WHERE id = '".$id."' ";
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
	function update_transaction_status($order_id,$status)
	{
		global $link;
		$sql_master = "UPDATE tbl_cart_master SET is_paid = '".$status."' WHERE id='".$order_id."'";
		$result_master = mysqli_query($link,$sql_master);
		
		$sql = "UPDATE tbl_cart SET is_paid = '".$status."' WHERE cart_master_id='".$order_id."'";
		$result = mysqli_query($link,$sql);
		
		if(mysql_error() == "")		
		{		
			$returnarr = array("success" => 1, "error" => "0");		
		}		
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function update_transaction_status_andriod($order_id,$status,$str)
	{		
		global $link;
		$data = array();
		
		//echo $new_str = strip_tags($str);
		$new_str = trim($str,"<table><tr></td></tr></head><body></body><center></center>");
		 $data = (explode("<td>",$new_str));
		// print_r ($data);
		//echo $order_id = $data[2];
		 $tracking_id = $data[4];
		 $new_str = trim($tracking_id,"</td></tr><tr>");
		
		 $bank_ref_no = $data[6];
		 $order_status = $data[8];
		 $failure_message = $data[10];
		 $payment_mode = $data[12];
		 $card_name = $data[14];
		 $status_code = $data[16];
		 $status_message = $data[18];
		 $currency = $data[20];
		 $amount  = $data[22];
		
		$billing_name = $data[24];
		$billing_name = trim($billing_name,"</td></tr><tr>");
		
		$billing_address = $data[26];
		$billing_address = trim($billing_address,"</td></tr><tr>");
		
		$billing_city = $data[28];
		$billing_city = trim($billing_city,"</td></tr><tr>");
		
		$billing_state = $data[30];
		$billing_state = trim($billing_state,"</td></tr><tr>");
		
		$billing_zip = $data[32];
		$billing_zip = trim($billing_zip,"</td></tr><tr>");
		
		$billing_country = $data[34];
		$billing_country = trim($billing_country,"</td></tr><tr>");
		
		$billing_tel = $data[36];
		$billing_tel = trim($billing_tel,"</td></tr><tr>");
		
		$billing_email = $data[38];
		$billing_email = trim($billing_email,"</td></tr><tr>");
		
		$delivery_name = $data[40];
		$delivery_name = trim($delivery_name,"</td></tr><tr>");
		
		$delivery_address = $data[42];
		$delivery_address = trim($delivery_address,"</td></tr><tr>");
		
		$delivery_city = $data[44];
		$delivery_city = trim($delivery_city,"</td></tr><tr>");
		
		$delivery_state = $data[46];
		$delivery_state = trim($delivery_state,"</td></tr><tr>");
		
		$delivery_zip = $data[48];
		$delivery_zip = substr($delivery_zip,0, 6); 
			
		$delivery_country = $data[50];
		$delivery_country = trim($delivery_country,"</td></tr><tr>");
		
		$delivery_tel = $data[52];
		$delivery_tel = trim($delivery_tel,"</td></tr><tr>");
		
		$merchant_param1 = $data[54];
			
		$sql_master = "UPDATE tbl_cart_master SET is_paid = '".$status."',billing_name = '".$billing_name."',billing_address = '".$billing_address."',billing_email = '".$billing_email."',billing_tel = '".$billing_tel."',billing_city = '".$billing_city."',billing_country = '".$billing_country."',billing_state = '".$billing_state."', billing_zip ='".$billing_zip."',delivery_name = '".$delivery_name."',delivery_address = '".$delivery_address."',delivery_tel = '".$delivery_tel."',delivery_city = '".$delivery_city."',delivery_state = '".$delivery_state."',delivery_zip = '".$delivery_zip."',delivery_country = '".$delivery_country."',str = '".$str."' WHERE id='".$order_id."'";

		$result_master = mysqli_query($link,$sql_master);
		
		$sql = "UPDATE tbl_cart SET is_paid = '".$status."' WHERE cart_master_id='".$order_id."'";
		$result = mysqli_query($link,$sql);
		
		if($status =="1")
		{
			$user_msg = urlencode("Thank you for placing order at Discover My Pet. Your product shall be dispatched within 5 working days.");
			send_sms_otp($user_msg, $billing_tel);
			
			$admin_mob = "919011855666";
			$user_msg = urlencode("Congratulations, Customer $billing_name has placed an order of Rs. $amount. Kindly deliver the product in time.");
			send_sms_otp($user_msg, $admin_mob); 	
			
			include_once('mail.php');	
			mail_booking($order_id); // For User
			mail_booking1($order_id); // For Admin
			mail_vendor($order_id); // For Vendor
			
		}
		
		if(mysql_error() == "")		
		{		
			$returnarr = array("success" => 1, "error" => "0");		
		}		 
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
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
	function get_rating($user_id,$service_id,$rating)
	{		
		global $link;
		
		//$sql_select = "SELECT id FROM tbl_rating WHERE "
		$sql = "INSERT into tbl_rating(user_id,service_id,rating) values ('".$user_id."','".$service_id."','".$rating."')";
		$result = mysqli_query($link,$sql);	
		$id = mysqli_insert_id($link);	
		if(mysql_error() == "")				
		
			$returnarr = array("success" => 1, "error" => 0,"id"=>$id);
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function edit_pet_type($pet_type, $pet_id) /**** EDIT PET TYPE(TYPE , USERID) ****/
	{		
		global $link;
		$sql="UPDATE pet_master SET pet_type = '".$pet_type."' WHERE id = '".$pet_id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
		{ 
			//if(mysqli_affected_rows($link) != 0)
				$returnarr = array("success" => 1, "error" => "0","id"=>$pet_id);
			//else
				//$returnarr = array("success" => 0, "error" => "1");	
		}		
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
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
	function edit_pet_gender($gender, $pet_id) /**** EDIT PET TYPE(GENDER , USERID) ****/
	{		
		global $link;
		$sql="UPDATE pet_master SET gender = '".$gender."' WHERE id = '".$pet_id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
		{
			//if(mysqli_affected_rows($link) != 0)
				$returnarr = array("success" => 1, "error" => "0","id"=>$pet_id);
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
	 
	  /**** ADD ALLERGY AND BREED ****/
	function post_dog_details_ios($pet_id,$user_id,$pet_name,$breed_name,$allergy_name)  
	{		
		$date = date('d-m-y:H:m:s');
		global $link;
		
		if($_SERVER['REQUEST_METHOD']=='POST')
		{ 
			$temp_name = $_FILES['myFile']['tmp_name'];
			$imagename = $pet_id."_".$date.".png";
			$path = "uploads/pet_pics/$imagename";	 
			move_uploaded_file($temp_name, $path);
			$img = "http://www.discovermypet.in/pet/$path";	
			
			$sql="UPDATE pet_master SET pet_name = '".$pet_name."',allergy = '".$allergy_name."',image = '".$img."', breed= '".$breed_name."',thub = '".$img."' WHERE id = '".$pet_id."' ";
			$result = mysqli_query($link,$sql);
			
			$sql_allergy_select = "SELECT allergy_name FROM allergy WHERE allergy_name = '".$allergy_name."'";
			$result_allergy_select = mysqli_query($link,$sql_allergy_select);
			$row_allergy_select = mysqli_fetch_array($result_allergy_select);
			if(mysqli_num_rows($result_allergy_select) <=0)
			{
				$sql_allergy = "INSERT into allergy (allergy_name, date_created,pet_id) values ('".$allergy_name."', '".date('Y-m-d H:i:s')."','".$pet_id."')";	
				$result_allergy = mysqli_query($link,$sql_allergy);
			}
			
			if(mysql_error() == "")		
			{
				if(mysqli_affected_rows($link) != 0)
					$returnarr = array("success" => 1, "error" => "0");
				else
					$returnarr = array("success" => 0, "error" => "1");	
			}		
			else
				$returnarr = array("success" => 0, "error" => mysql_error());		
		}
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
	function get_trasaction($user_id)
	{
		global $link;
		$i=0;
		$sql = "SELECT product_id,status,price,order_no,order_total,creaed_date FROM tbl_trasaction WHERE user_id = '".$user_id."'";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("product_id" => $row["product_id"],"status" => $row["status"],"price" => $row["price"],"order_no" => $row["order_no"],"order_total" => $row["order_total"],"creaed_date" => $row["creaed_date"]);
			$i++;
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
	function upload_doc($pet_id)
	{
		global $link;
	 $file = $pet_id."-".$_FILES['file']['name'];
	 $file_loc = $_FILES['file']['tmp_name'];
	 $file_size = $_FILES['file']['size'];
	 $file_type = $_FILES['file']['type'];
	 $folder="uploads/";
	 
	 move_uploaded_file($file_loc,$folder.$file);
	 $sql="INSERT INTO pet_document(pet_doc_name,pet_id) VALUES('".$file."','".$pet_id."')";
	 mysqli_query($link,$sql); 
	 if(mysql_error() == "")				
		
			return $returnarr = array("success" => 1, "error" => 0);
		else
			return $returnarr = array("success" => 0, "error" => mysql_error());	
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
	function notes_list($note_title,$note,$date)
	{		
		global $link;
		$sql = "INSERT into notes (note_title, note,date_created) values ('".$note_title."','".$note."','".$date."')";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function list_allergy()
	{		
		global $link;
		$i = 0;
		$sql = "select id, allergy_name from allergy ";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("id" => $row["id"], "allergy_name" => $row["allergy_name"]);
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
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
	function edit_allergy($id, $allergy)
	{		
		global $link;
		$sql="UPDATE allergy SET allergy_name = '".$allergy."' WHERE id = '".$id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function delete_allergy($id,$pet_id)
	{		
		global $link;
		$sql="DELETE  FROM allergy WHERE id = '".$id."' and pet_id = '".$pet_id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function post_likes($user_id,$timeline_id,$friend_id)
	{
		global $link;
		
		$sql_notification = "SELECT gcm_id FROM app_users WHERE id = '".$friend_id."'";
		$result_notification = mysqli_query($link,$sql_notification);
		$row_notification = mysqli_fetch_array($result_notification);
		
		$sql_user_nm = "SELECT name FROM app_users WHERE id = '".$user_id."'";
		$result_user_nm = mysqli_query($link,$sql_user_nm);
		$row_user_nm = mysqli_fetch_array($result_user_nm);
		
		include_once("notification.php");
		
		$user_msg = $row_user_nm["name"]." Liked your photo";
		
		if($user_id != $friend_id)
		{
			sendPushNotificationToGCM($row_notification["gcm_id"], $user_msg);
		}		
		if($user_id == $friend_id)
		{
			$sql = "INSERT into tbl_notification(type,user_id,who_id,timeline_id,created_date) values ('like','".$user_id."','0','".$timeline_id."','".date('Y-m-d H:i:s')."')";
		}
		else
		{
			$sql = "INSERT into tbl_notification(type,user_id,who_id,timeline_id,created_date) values ('like','".$user_id."','".$friend_id."','".$timeline_id."','".date('Y-m-d H:i:s')."')";
		}
		$result = mysqli_query($link,$sql);
		
			
		if(mysql_error() == "")				
		{
			$sql = "select timeline_id from tbl_notification where timeline_id = '".$timeline_id."' and type = 'like'";
			$result = mysqli_query($link,$sql);
			$likes = mysqli_num_rows($result);
			
			$returnarr = array("success" => 1, "error" => 0, "likes" => $likes);
		}
		else
		{
			$returnarr = array("success" => 0, "error" => mysql_error(), "likes" => $likes);		
		}
		return $returnarr;
	}

	function unlike($user_id,$timeline_id,$friend_id)
	{
		global $link;
		if($user_id == $friend_id)
		{
		$sql = "DELETE FROM tbl_notification where user_id='".$user_id."' and timeline_id='".$timeline_id."' and type = 'like'";
		}
		else
		{
			$sql = "DELETE FROM tbl_notification where user_id='".$user_id."' and who_id='".$friend_id."' and timeline_id='".$timeline_id."' and type = 'like'";
		}
		$result = mysqli_query($link,$sql);
		
		if(mysql_error() == "")				
		{
			$sql = "select timeline_id from tbl_notification where timeline_id = '".$timeline_id."' and type = 'like'";
			$result = mysqli_query($link,$sql);
			$likes = mysqli_num_rows($result);
		
			$returnarr = array("success" => 1, "error" => 0, "likes" => $likes);
		}
		else
			$returnarr = array("success" => 0, "error" => mysql_error(), "likes" => $likes);		

		return $returnarr;
	}
	function post_comment($user_id,$timeline_id,$comment,$friend_id)
	{		
		global $link;
		
		include_once("notification.php");
		
		$sql_notification ="SELECT gcm_id FROM app_users WHERE id = '".$friend_id."'";
		$result_notification = mysqli_query($link,$sql_notification);
		$row_notification = mysqli_fetch_array($result_notification);
		
		$sql_user_nm = "SELECT name FROM app_users WHERE id = '".$user_id."'";
		$result_user_nm = mysqli_query($link,$sql_user_nm);
		$row_user_nm = mysqli_fetch_array($result_user_nm);		
		
		$user_msg = $row_user_nm["name"]." Comment on your photo";		
		
		sendPushNotificationToGCM($row_notification["gcm_id"], $user_msg);
		
		if($user_id == $friend_id)
		{
			$sql = "INSERT into 	tbl_notification(type,user_id,timeline_id,who_id,comment,created_date) values ('comment','".$user_id."','".$timeline_id."','0','".$comment."','".date('Y-m-d H:i:s')."')";
		}
		else
		{
			$sql = "INSERT into tbl_notification(type,user_id,timeline_id,who_id,comment,created_date) values ('comment','".$user_id."','".$timeline_id."','".$friend_id."','".$comment."','".date('Y-m-d H:i:s')."')";
		}
		$result = mysqli_query($link,$sql);	
		
		if(mysql_error() == "")				
		{ 
			$sql = "select timeline_id from tbl_notification where timeline_id = '".$timeline_id."' and type = 'comment'";
			$result = mysqli_query($link,$sql);
			$comments = mysqli_num_rows($result);
			$returnarr = array("success" => 1, "error" => 0,"comments" => $comments);
		}
			
		else
			$returnarr = array("success" => 0, "error" => mysql_error(),"comments" => $comments);		

		return $returnarr;
	}
	function get_timeline_comment($timeline_id)
	{	
		global $link;
		$app_info = array();
		$i = 0;
		 $sql = "select id,user_id,comment,created_date from tbl_notification where timeline_id = '".$timeline_id."' and type = 'comment' order by created_date desc ";
		$result = mysqli_query($link,$sql);	
		while($row = mysqli_fetch_array($result))
		{
			$today = new DateTime(date('Y-m-d H:i:s'));
			$pastDate = $today->diff(new DateTime($row["created_date"]));

			
			if($pastDate->m > 1)
			{
				$posted_when = $pastDate->m." month(s) ago";
			}
			else if($pastDate->d > 0)
			{
				$posted_when = $pastDate->d." day(s) ago";
			}
			else
			{
				if($pastDate->h > 1)
					$posted_when = $pastDate->h." hrs ago";
				else
					$posted_when = $pastDate->i." minutes ago";
			}
		
			$sql_user_name = "select id,name,image from app_users where id = '".$row["user_id"]."'";
			$result_user_name = mysqli_query($link,$sql_user_name);
			while($row_user_name= mysqli_fetch_array($result_user_name))
			{
			$app_info[$i] = array("user_id" => $row_user_name["id"],"name" => $row_user_name["name"],"image" => $row_user_name["image"],"comment_id" => $row["id"],"comment" => $row["comment"],"created_date" => $posted_when);
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
	function get_timeline_comment_new($timeline_id,$user_id)
	{	
		global $link;
		$app_info = array();
		$i = 0;
		 $sql = "select id,user_id,comment,created_date from tbl_notification where timeline_id = '".$timeline_id."' and type = 'comment' order by created_date desc ";
		$result = mysqli_query($link,$sql);	
		while($row = mysqli_fetch_array($result))
		{
			$today = new DateTime(date('Y-m-d H:i:s'));
			$pastDate = $today->diff(new DateTime($row["created_date"]));
			
			if($pastDate->m > 1)
			{
				$posted_when = $pastDate->m." month(s) ago";
			}
			else if($pastDate->d > 0)
			{
				$posted_when = $pastDate->d." day(s) ago";
			}
			else
			{
				if($pastDate->h > 1)
					$posted_when = $pastDate->h." hrs ago";
				else
					$posted_when = $pastDate->i." minutes ago";
			}
		
			$sql_user_name = "select id,name,image from app_users where id = '".$row["user_id"]."'";
			$result_user_name = mysqli_query($link,$sql_user_name);
			while($row_user_name= mysqli_fetch_array($result_user_name))
			{
				$name = $row_user_name["name"];
				$name = ucwords($name);
				
				if($user_id == $row_user_name["id"])
				{								
					$app_info[$i] = array("user_id" => $row_user_name["id"],"name" => $name,"image" => $row_user_name["image"],"comment_id" => $row["id"],"comment" => $row["comment"],"created_date" => $posted_when,"flag"=>1);
				}
				else
				{
					$app_info[$i] = array("user_id" => $row_user_name["id"],"name" => $name,"image" => $row_user_name["image"],"comment_id" => $row["id"],"comment" => $row["comment"],"created_date" => $posted_when,"flag"=>0);
				}
				
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
	function most_like_order($user_id)
	{
		global $link;
		$i = 0; 
		$sql_like = "SELECT count(`timeline_id`) as count,timeline_id FROM `tbl_notification` WHERE type='like' group by timeline_id order by count(`timeline_id`) desc LIMIT 4";
		$result_like = mysqli_query($link,$sql_like);
		while($row_like = mysqli_fetch_array($result_like))
		{
			$sql_img = "SELECT id,post_text,post_img,user_id FROM tbl_timeline WHERE id = '".$row_like['timeline_id']."'";
			$result_img = mysqli_query($link,$sql_img);
			$row_img = mysqli_fetch_array($result_img);
			
			$sql_like_status = "SELECT id FROM tbl_notification WHERE timeline_id = '".$row_img['id']."' and who_id = '$user_id'";
			$result_like_status = mysqli_query($link,$sql_like_status);
			$like_status = mysqli_num_rows($result_like_status);
			
			$sql_count_like = "SELECT id FROM tbl_notification WHERE timeline_id = '".$row_img['id']."' and type = 'like'";
			$result_count_like = mysqli_query($link,$sql_count_like);
			$like_count = mysqli_num_rows($result_count_like);
			
			$sql_count_comment = "SELECT id FROM tbl_notification WHERE timeline_id = '".$row_img['id']."' and type = 'comment'";
			$result_count_comment = mysqli_query($link,$sql_count_comment);
			$comment_count = mysqli_num_rows($result_count_comment);
			
			if($like_status > 0)
			{
				$app_info[$i] =  array("timeline_id" =>$row_img["id"],"friend_id" =>$row_img["user_id"],"caption"=>$row_img["post_text"],"image" => $row_img["post_img"],"rank" => $i,"like_status" => 1,"like_count"=>$like_count,"comment_count"=>$comment_count,"flag" => 0);
			$i++;
			}
			else
			{
				$app_info[$i] =  array("timeline_id" =>$row_img["id"],"friend_id" =>$row_img["user_id"],"caption"=>$row_img["post_text"],"image" => $row_img["post_img"],"rank" => $i,"like_status" => 0,"like_count"=>$like_count,"comment_count"=>$comment_count,"flag" => 0);
			$i++;
			}
			 
			
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
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
	function welcome_image()
	{
		global $link, $server_path;
		$i=0;
		$sql ="select animated_image from settings";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] =  array("welcome_image" => $server_path.$row["animated_image"]);
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
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
	function notification_history($user_id)
	{		
		global $link;
		$i=0;
		$j=0;
		$k=0;
		$app_info_blog = array();
		
		$sql_req_res_cnt = "select id FROM tbl_notification WHERE who_id ='".$user_id."'and is_read != '1' and type = 'request' OR type = 'response' order by created_date desc";
		$result_req_res_cnt = mysqli_query($link,$sql_req_res_cnt);
		$req_res_cnt = mysqli_num_rows($result_req_res_cnt);
		
		$sql_lk_cmt_cnt = "select id FROM tbl_notification WHERE who_id ='".$user_id."'and is_read != '1' and type = 'like' OR type = 'comment' order by created_date desc";
		$result_lk_cmt_cnt = mysqli_query($link,$sql_lk_cmt_cnt);
		$lk_cmt_cnt = mysqli_num_rows($result_lk_cmt_cnt);
		
		
		$sql_cnt = "select type FROM tbl_notification WHERE who_id ='".$user_id."'and is_accept <> '2' and is_read != '1' order by created_date desc ";
		$result_cnt = mysqli_query($link,$sql_cnt);
		$count1 = mysqli_num_rows($result_cnt);
				
		$sql_request = "select type,user_id,timeline_id,created_date FROM tbl_notification WHERE who_id ='".$user_id."'and is_accept <> '2'  order by created_date desc ";
		
		$result_request = mysqli_query($link,$sql_request);
		$count1 = mysqli_num_rows($result_request);
		while($row_request = mysqli_fetch_array($result_request))
		{
			$sql_name = "SELECT name,image FROM app_users WHERE id='".$row_request['user_id']."'";
			$result_name = mysqli_query($link,$sql_name);
			$row_name =mysqli_fetch_array($result_name);
			$today = new DateTime(date('Y-m-d H:i:s'));
			$pastDate = $today->diff(new DateTime($row_request["created_date"]));

			if($pastDate->m > 0)
			{
				$posted_when = $pastDate->m." month(s) ago";
			}
			else if($pastDate->d > 0)
			{
				$posted_when = $pastDate->d." day(s) ago";
			}
			else
			{
				if($pastDate->h > 1)
					$posted_when = $pastDate->h." hrs ago";
				else
					$posted_when = $pastDate->i." minutes ago";
			}
			 if($row_request["type"] == "request")
			{
				$sql_frd_acc ="SELECT id FROM tbl_notification WHERE who_id='".$user_id."' and type='request' and is_accept='1' and user_id = '".$row_request["user_id"]."' order by created_date desc";
				$result_frd_acc = mysqli_query($link,$sql_frd_acc);
				if(mysqli_num_rows($result_frd_acc)>0)
				{
					
					$text = "Accepted friend request of ".$row_name["name"];
					$name = ucwords($row_name["name"]);
					$app_info[$i] =  array("Friend_id"=> $row_request["user_id"],"usre_name" => $name,"user_image" => $row_name["image"],"request_status"=>"Accepted","text"=>$text,"time"=> $posted_when,"type"=>$row_request["type"]);
				}
				
				else
				{
					$text = $row_name["name"]." sent friend request";
					$name = ucwords($row_name["name"]);
					$app_info[$i] =  array("Friend_id"=> $row_request["user_id"],"usre_name" => $name,"user_image" => $row_name["image"],"request_status"=>"No Action","text"=>$text,"time"=> $posted_when,"type"=>$row_request["type"]);
				}
				$i++;
			} 
			else if($row_request["type"] == "response") 
			{
				$text = $row_name["name"]. " has accepted your request";
				$name = ucwords($row_name["name"]);
				$app_info[$i] =  array("Friend_id"=> $row_request["user_id"],"usre_name" => $name,"user_image" => $row_name["image"],"text"=>$text,"time"=> $posted_when,"type"=>$row_request["type"]);
				$i++;
			} 
			else if($row_request["type"] == "like")
			{
				$sql_img = "select id,post_img from tbl_timeline where id = '".$row_request["timeline_id"]."'";
				$result_img = mysqli_query($link,$sql_img);
				$row_img = mysqli_fetch_array($result_img);
				
				$sql_comment_cnt = "select comment FROM tbl_notification WHERE timeline_id = '".$row_img["id"]."' and type='comment'";
				$result_comment_cnt = mysqli_query($link,$sql_comment_cnt);		
				$count_cmt = mysqli_num_rows($result_comment_cnt);
				
				$sql_comment1 = "select comment FROM tbl_notification WHERE timeline_id = '".$row_img["id"]."' and type='like'";
				$result_like = mysqli_query($link,$sql_comment1);
			
				$count_like = mysqli_num_rows($result_like);
				$sql_user_like = "select timeline_id FROM tbl_notification WHERE user_id = '".$user_id."' and timeline_id = '".$row_img["id"]."' and type = 'like'";
				$result_user_like = mysqli_query($link,$sql_user_like);
				if(mysqli_num_rows($result_user_like) != 0)
				{
					$name = ucwords($row_name["name"]);
					$app_info_like[$j] =  array("Friend Id"=> $row_request["user_id"],"Name" => $name,"User Image" => $row_name["image"],"Timeline_id" => $row_img["id"],"Post Image" => $row_img["post_img"],"text"=>"Liked your photo","When"=> $posted_when,"type"=>$row_request["type"],"comments"=>$count_cmt,"likes"=>$count_like,"Post Type"=>"image","like_status"=>"1");
				$j++;
				}
				else
				{
					$name = ucwords($row_name["name"]);
					$app_info_like[$j] =  array("Friend Id"=> $row_request["user_id"],"Name" => $name,"User Image" => $row_name["image"],"Timeline_id" => $row_img["id"],"Post Image" => $row_img["post_img"],"text"=>"Liked your photo","When"=> $posted_when,"type"=>$row_request["type"],"comments"=>$count_cmt,"likes"=>$count_like,"Post Type"=>"image","like_status"=>"0");
				$j++;
				}			
			}
			else if($row_request["type"] == "comment")
			{
				$sql_img = "select id,post_img from tbl_timeline where id = '".$row_request["timeline_id"]."'";
				$result_img = mysqli_query($link,$sql_img);
				$row_img = mysqli_fetch_array($result_img);
				
				$sql_comment_cnt = "select comment FROM tbl_notification WHERE timeline_id = '".$row_img["id"]."' and type='comment'";
				$result_comment_cnt = mysqli_query($link,$sql_comment_cnt);		
				$count_cmt = mysqli_num_rows($result_comment_cnt);
				
				$sql_comment1 = "select comment FROM tbl_notification WHERE timeline_id = '".$row_img["id"]."' and type='like'";
				$result_like = mysqli_query($link,$sql_comment1);
			
				$count_like = mysqli_num_rows($result_like);
				
				$sql_user_like = "select timeline_id FROM tbl_notification WHERE user_id = '".$user_id."' and timeline_id = '".$row_img["id"]."' and type = 'like'";
				$result_user_like = mysqli_query($link,$sql_user_like);
				
				if(mysqli_num_rows($result_user_like) != 0)
				{
					$name = ucwords($row_name["name"]);
					$app_info_like[$j] =  array("Friend Id"=> $row_request["user_id"],"Name" => $name,"User Image" => $row_name["image"],"Timeline_id" => $row_img["id"],"Post Image" => $row_img["post_img"],"text"=>"Comment on your photo","When"=> $posted_when,"type"=>$row_request["type"],"comments"=>$count_cmt,"likes"=>$count_like,"Post Type"=>"image","like_status"=>"1");
					$j++;
				}
				else
				{
					$name = ucwords($row_name["name"]);
					$app_info_like[$j] =  array("Friend Id"=> $row_request["user_id"],"Name" => $name,"User Image" => $row_name["image"],"Timeline_id" => $row_img["id"],"Post Image" => $row_img["post_img"],"text"=>"Comment on your photo","When"=> $posted_when,"type"=>$row_request["type"],"comments"=>$count_cmt,"likes"=>$count_like,"Post Type"=>"image","like_status"=>"0");
					$j++;
				}
			}	
			else if($row_request["type"] == "blog")		
			{				
				$sql_title = "select title,image from tbl_news where id = '".$row_request["timeline_id"]."'";
				$result_title = mysqli_query($link,$sql_title);
				$row_title = mysqli_fetch_array($result_title);
				$text = "You have a new Tip";
				$app_info_blog[$k] =  array("text"=>$row_title['title'],"image"=>$row_title['image'],"time"=> $posted_when,"type"=>$row_request["type"]);
				$k++;			
			}
		}	
		if(empty($app_info) and empty ($app_info_like) and empty ($app_info_blog))
		{
			$app_list = array("success" => 1,"requestandresponse" => "no records found" ,"likeandcomment" => "no records found","blog" => "no records found" ,"count" =>$count1,"req_res_cnt"=>$req_res_cnt,"lk_cmt_cnt"=>$lk_cmt_cnt); 
		}
		else if(empty($app_info))
		{
			$app_list = array("success" => 1,"requestandresponse" => "no records found" ,"likeandcomment" => "no records found","blog" => $app_info_blog,"count" =>$count1,"req_res_cnt"=>$req_res_cnt,"lk_cmt_cnt"=>$lk_cmt_cnt);
		}
		else if(empty($app_info_like))
		{
			$app_list = array("success" => 1,"requestandresponse" => $app_info ,"likeandcomment" =>  "no records found","blog" => $app_info_blog ,"count" =>$count1,"req_res_cnt"=>$req_res_cnt,"lk_cmt_cnt"=>$lk_cmt_cnt);
		}
		else if(empty($app_info_blog))
		{
			$app_list = array("success" => 1,"requestandresponse" => $app_info ,"likeandcomment" =>  $app_info_like ,"blog" =>  "no records found" ,"count" =>$count1,"req_res_cnt"=>$req_res_cnt,"lk_cmt_cnt"=>$lk_cmt_cnt);
		}
		else
		{
			$app_list = array("success" => 1,"requestandresponse" => $app_info ,"likeandcomment" =>  $app_info_like , "blog" =>  $app_info_blog ,"count" =>$count1,"req_res_cnt"=>$req_res_cnt,"lk_cmt_cnt"=>$lk_cmt_cnt);
		}
		
		$sql_update = "UPDATE tbl_notification SET is_read = 1 WHERE who_id = '".$user_id."' ";
		$result_update =mysqli_query($link,$sql_update);
		return $app_list;
	} 
	function delete_comment($comment_id)
	{
		global $link;
		$sql = "DELETE FROM tbl_notification WHERE id= $comment_id ";
		$result = mysqli_query($link, $sql);
		if(mysql_error() == "")	
			$returnarr = array("success" => "1", "error" => "0");
		else
			$returnarr = array("success" => "0", "error" => mysql_error());		
		return $returnarr;
	}
	function edit_comment($comment_id,$comment)
	{
		global $link;
		$sql = "UPDATE tbl_notification SET comment = '$comment'  WHERE id= $comment_id ";
		$result = mysqli_query($link, $sql);
		if(mysql_error() == "")	
			$returnarr = array("success" => "1", "error" => "0");
		else
			$returnarr = array("success" => "0", "error" => mysql_error());		
		return $returnarr;
	}
	
	
	 function send_request($user_id,$to_user)
	{
		include_once('notification.php');
		global $link;
		$sql = "SELECT  mobile,gcm_id FROM app_users WHERE id = '".$to_user."'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		$mobile = $row["mobile"];

		$sql_name = "SELECT name FROM app_users WHERE id = '".$user_id."'";
		$result_name = mysqli_query($link,$sql_name);
		$row_name = mysqli_fetch_array($result_name);
		$name = $row_name['name'];
		
		
		$name = ucwords($name);
		
		$user_msg = "A friend request sent by $name Thanks."; 
		send_sms($user_msg,$mobile); 
		
		sendPushNotificationToGCM($row["gcm_id"], $user_msg);
	 
		$sql_update = "INSERT into tbl_notification (type,user_id,who_id, created_date) values ('request','".$user_id."','".$to_user."', '".date('Y-m-d H:i:s')."')";
		$result_update = mysqli_query($link,$sql_update); 
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
		
	} 
	function frd_req_response($user_id,$is_accept,$friend_id)
	{
		global $link;
		include_once("notification.php");
		
		$sql_notification ="SELECT gcm_id FROM app_users WHERE id = '".$friend_id."'";
		$result_notification = mysqli_query($link,$sql_notification);
		$row_notification = mysqli_fetch_array($result_notification);
		
		$sql_user_nm = "SELECT name FROM app_users WHERE id = '".$user_id."'";
		$result_user_nm = mysqli_query($link,$sql_user_nm);
		$row_user_nm = mysqli_fetch_array($result_user_nm);		
		
		$user_msg = $row_user_nm["name"]. " has accepted your request";
		
		sendPushNotificationToGCM($row_notification["gcm_id"], $user_msg);
		
		$sql = "UPDATE tbl_notification SET is_accept = '".$is_accept."' WHERE who_id='".$user_id."' and user_id='".$friend_id."'";
		$result = mysqli_query($link,$sql);
		
		$sql_update = "INSERT into tbl_notification (type,user_id,who_id,is_accept,created_date) values ('response','".$user_id."','".$friend_id."','".$is_accept."', '".date('Y-m-d H:i:s')."')";
		if($is_accept!=2)
		{
			$sql_insert_frd = "INSERT into tbl_friends (user_id,friend_id,friend_date) values ('".$friend_id."','".$user_id."','".date('Y-m-d H:i:s')."')";
		
			$result_update = mysqli_query($link,$sql_update); 
			$result_insert_frd = mysqli_query($link,$sql_insert_frd); 
		}
		else
		{
			$returnarr = array("success" => 0, "error" => "1");		
			return $returnarr;
		}
		
		
		if(mysql_error() == "")		
		{
			
			$returnarr = array("success" => 1, "error" => "0");
		}
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
		
	}

	function notification_today($user_id,$timeline_id)
	{		
		global $link;
		$i = 0;
		$today = date('Y-m-d');
		$sql_like ="select like_date,user_id from tbl_timeline_likes where timeline_owner_id ='".$user_id."'and timeline_id ='".$timeline_id."' and is_read='0' and '".$today."' = CURDATE()";
		$app_info = array();
		$result_like = mysqli_query($link,$sql_like);
		while($row_like = mysqli_fetch_array($result_like))
		{
			$today = new DateTime(date('Y-m-d H:i:s'));
			$pastDate = $today->diff(new DateTime($row_like["like_date"]));

			if($pastDate->d > 1)
			{
				$posted_when = $pastDate->d." days ago";
			}
			else
			{
				if($pastDate->h > 1)
					$posted_when = $pastDate->h." hrs ago";
				else
					$posted_when = $pastDate->m." minutes ago";
			}
		
			$sql_user_name = "select name from app_users where id = '".$row_like["user_id"]."'";
			$sql_img = "select post_img from tbl_timeline where id = '".$timeline_id."'";
			
			$result_user_name = mysqli_query($link,$sql_user_name);
			$result_img = mysqli_query($link,$sql_img);
			
			$row_user_name = mysqli_fetch_array($result_user_name);
			$row_img = mysqli_fetch_array($result_img);
			
			$app_info[$i] =  array("Name" => $row_user_name["name"],"Image" => $row_img["post_img"],"text"=>"like on your photo" ,"time"=> $posted_when);
			$i++;
		}	
		$sql_is_read = "UPDATE tbl_timeline_likes SET is_read = '1' WHERE timeline_owner_id='".$user_id."'and timeline_id='".$timeline_id."' ";
		$result_is_read = mysqli_query($link,$sql_is_read);
		$app_list = array("result" => $app_info);
		return $app_list;
	} 

	function user_timeline($user_id)
	{
		global $link;
		$i=0;
		//$sql_timeline= "select t.id, a.image,t.post_img,t.post_video,t.id,a.id as user_id, t.posted_date, a.name,t.post_text FROM tbl_timeline as t , app_users as a WHERE (t.user_id = '".$user_id."' or t.user_id in (select friend_id FROM tbl_friends WHERE user_id = '".$user_id."' union select user_id FROM tbl_friends WHERE friend_id = '".$user_id."')) and a.id = t.user_id group by t.id order by t.posted_date desc";	
		
		$sql_timeline = "select t.id, a.image,t.post_img,t.post_video,t.id,a.id as user_id, t.posted_date, a.name,t.post_text FROM tbl_timeline as t , app_users as a WHERE t.user_id = a.id order by t.posted_date desc";
		$result_timeline = mysqli_query($link,$sql_timeline);
		
		while($row_timeline = mysqli_fetch_array($result_timeline))
		{
			$name = $row_timeline["name"];
			$name = ucwords($name);
				
			$sql_comment = "select id,comment FROM tbl_notification WHERE timeline_id = '".$row_timeline["id"]."' and type='comment'";
			$result_comment = mysqli_query($link,$sql_comment);
			
			$count_cmt = mysqli_num_rows($result_comment);
			
			$sql_comment1 = "select comment FROM tbl_notification WHERE timeline_id = '".$row_timeline["id"]."' and type='like'";
			$result_like = mysqli_query($link,$sql_comment1);
			
			$count_like = mysqli_num_rows($result_like);
			
			$row_comment = mysqli_fetch_array($result_comment);
			
			 $sql_user_like = "select timeline_id FROM tbl_notification WHERE user_id = '".$user_id."' and timeline_id = '".$row_timeline["id"]."' and type = 'like'";
			$result_user_like = mysqli_query($link,$sql_user_like);
			
			if(trim($row_timeline["post_video"]) == "")
				$post_type = "image";
			else
				$post_type = "video";
			
			$today = new DateTime(date('Y-m-d H:i:s'));
			$pastDate = $today->diff(new DateTime($row_timeline["posted_date"]));
			
			if($pastDate->m > 1)
			{
				$posted_when = $pastDate->m." month(s) ago";
			}
			else if($pastDate->d > 0)
			{
				$posted_when = $pastDate->d." day(s) ago";
			}
			else
			{
				if($pastDate->h > 1)
					$posted_when = $pastDate->h." hrs ago";
				else
					$posted_when = $pastDate->i." min ago";
			}
			
			if(mysqli_num_rows($result_user_like) != 0)
			{
				if($user_id == $row_timeline['user_id'])
				{				
					$app_info[$i] = array("Friend Id" => $row_timeline["user_id"],"User Image" => $row_timeline["image"],"Post Image" => $row_timeline["post_img"],"caption" => $row_timeline["post_text"],"Post Video" => $row_timeline["post_video"],"Name" => $name,"Timeline_id" => $row_timeline["id"],"comments"=>$count_cmt,"likes"=>$count_like,"Post Type"=>$post_type, "When"=>$posted_when,"like_status"=>"1","flag"=>1);
				}
				else
				{
					$app_info[$i] = array("Friend Id" => $row_timeline["user_id"],"User Image" => $row_timeline["image"],"Post Image" => $row_timeline["post_img"],"caption" => $row_timeline["post_text"],"Post Video" => $row_timeline["post_video"],"Name" => $name,"Timeline_id" => $row_timeline["id"],"comments"=>$count_cmt,"likes"=>$count_like,"Post Type"=>$post_type, "When"=>$posted_when,"like_status"=>"1","flag"=>0);
				}
				
				$i++;
			}
			else
			{
				if($user_id == $row_timeline['user_id'])
				{
					$app_info[$i] = array("Friend Id" => $row_timeline["user_id"],"User Image" => $row_timeline["image"],"Post Image" => $row_timeline["post_img"],"caption" => $row_timeline["post_text"],"Post Video" => $row_timeline["post_video"],"Name" => $name,"Timeline_id" => $row_timeline["id"],"comments"=>$count_cmt,"likes"=>$count_like,"Post Type"=>$post_type, "When"=>$posted_when,"like_status"=>"0","flag"=>1);
				}
				else
				{
					$app_info[$i] = array("Friend Id" => $row_timeline["user_id"],"User Image" => $row_timeline["image"],"Post Image" => $row_timeline["post_img"],"caption" => $row_timeline["post_text"],"Post Video" => $row_timeline["post_video"],"Name" => $name,"Timeline_id" => $row_timeline["id"],"comments"=>$count_cmt,"likes"=>$count_like,"Post Type"=>$post_type, "When"=>$posted_when,"like_status"=>"0","flag"=>0);
				}
				$i++;
			}				 
		}
		$sql_notification = "SELECT id FROM tbl_notification WHERE who_id = '".$user_id."' and is_read != '1' ";
		$result_notification = mysqli_query($link,$sql_notification);
		$rows = mysqli_num_rows($result_notification);
		
		if(mysqli_num_rows($result_timeline) == 0)
		{
			$returnarr = array("success" => 0, "error" =>1);	
			return $returnarr;
		}
		else
		{	
			$app_list = array("success" => 1,"result" => $app_info,"count"=>$rows);
			return $app_list;
		}
	}
	function delete_timeline_img($timeline_id)
	{
		global $link;
		$sql_select = "SELECT post_img FROM tbl_timeline WHERE id = '".$timeline_id."'";
		$result_select = mysqli_query($link,$sql_select);
		$row_select = mysqli_fetch_array($result_select);
		$sql_img = "DELETE FROM tbl_timeline WHERE id= $timeline_id ";
		$result_img = mysqli_query($link, $sql_img);
		$sql_comment = "DELETE FROM tbl_notification WHERE timeline_id= $timeline_id ";
		$result_comment = mysqli_query($link, $sql_comment);
		if (file_exists($row_select["post_img"])) 
			{
				unlink($row_select["post_img"]);
				//echo 'File '.$path1.' has been deleted';
			} 
		if(mysql_error() == "")	
		$returnarr = array("success" => "1", "error" => "0");
		else
		$returnarr = array("success" => "0", "error" => mysql_error());		

		return $returnarr;
	}
	function like_status($user_id)
	{
		
		for ($i=0; $i<7; $i++)
	{
		$a[$i] = array( date("Y-m-d", strtotime($i." days ago")));
	}
	return $a;
	}
	function timeline_profile($user_id)
	{
		global $link;
		$i = 0;	
		$j = 0;	
		$k = 0;	
		$breed = 0;	
		$walk = 0;	
		$app_req = array();
		$app_img = array(); 
		$sql_friend ="select count(*)as friend_id from tbl_friends where user_id ='".$user_id."'";
		$result_friend = mysqli_query($link,$sql_friend);
			
		$sql_frd_req ="select r.id,a.name from tbl_frd_request as r,app_users as a where r.to_user ='".$user_id."' and a.id ='".$user_id."'";
		$result_frd_req = mysqli_query($link,$sql_frd_req);
		
		$sql_pet_id = "select id FROM pet_master WHERE user_id = '".$user_id."'";
		$result_pet_id = mysqli_query($link,$sql_pet_id);
		while($row_pet_id = mysqli_fetch_array($result_pet_id))
		{
			$sql_pet_walk = "SELECT sum(km) as km FROM tbl_dog_walk WHERE pet_id = '".$row_pet_id['id']."'";
			$result_pet_walk = mysqli_query($link,$sql_pet_walk);
			$row_pet_walk = mysqli_fetch_array($result_pet_walk);
			$walk = $row_pet_walk["km"];
		}
		
		
		while($row_friend = mysqli_fetch_array($result_friend))
		{
			$sql_user ="select image,name,status from app_users where id ='".$user_id."'";
			$sql_pet_breed ="select breed from pet_master where user_id ='".$user_id."'";
			
			$result_user = mysqli_query($link,$sql_user);
			$result_pet_breed = mysqli_query($link,$sql_pet_breed);
			
			$row_user = mysqli_fetch_array($result_user);
			$row_pet_breed = mysqli_fetch_array($result_pet_breed);
			
			$sql_breed ="select friend_id from tbl_friends where user_id ='".$user_id."'";
			$result_breed = mysqli_query($link,$sql_breed);
			while($row_breed = mysqli_fetch_array($result_breed))
			{
				 $sql_chk_breed ="select count(*)as breed from pet_master where user_id ='".$row_breed["friend_id"]."' and breed='".$row_pet_breed["breed"]."'";
				$result_chk_breed = mysqli_query($link,$sql_chk_breed);
				$row_chk_breed = mysqli_fetch_array($result_chk_breed);
				$breed += $row_chk_breed["breed"];
			}	
				$name = ucwords($row_user["name"]);
				$app_info[$i] =array("name" => $name,"image" => $row_user["image"],"friend"=>$row_friend["friend_id"],"breed"=>$breed,"walk"=>$walk,"status"=>$row_user["status"]);
				$i++;
		}
		$sql_img ="select post_img from tbl_timeline where user_id ='".$user_id."'";
		$result_img = mysqli_query($link,$sql_img);
		
		while($row_img = mysqli_fetch_array($result_img))
		{
			$app_img[$k] =array("Image" => $row_img["post_img"]);
			$k++;
		}
		while($row_frd_req = mysqli_fetch_array($result_frd_req))
		{
			$app_req[$j] =array("ID" => $row_frd_req["id"],"Name" => $row_frd_req["name"]);
			$j++;
		}	
		if(empty($app_img) and empty($app_req))
		{
			$app_list = array("success" => 1,"result" => $app_info,"image"=>"null","Request"=>"null");
			return $app_list;
		}
		elseif(empty($app_img))
		{
			$app_list = array("success" => 1,"result" => $app_info,"image"=>"null","Request"=>$app_req);
			return $app_list;
		}
		elseif(empty($app_req))
		{
			$app_list = array("success" => 1,"result" => $app_info,"image"=>$app_img,"Request"=>"null");
			return $app_list;
		}
		else
		{
			$app_list = array("success" => 1,"result" => $app_info,"image"=>$app_img,"Request"=>$app_req);
			return $app_list;
		}
			
	}

	function my_doctor($user_id,$doctor_name,$contact_no,$dr_address,$dr_clinic_name,$dr_time,$dr_time1)
	{		
		global $link;
		$sql="UPDATE app_users SET doctor_name = '".$doctor_name."',contact_no = '".$contact_no."',dr_address = '".$dr_address."',dr_clinic_name = '".$dr_clinic_name."',dr_time = '".$dr_time."',dr_time1 = '".$dr_time1."' WHERE id = '".$user_id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function emergency_call($user_id)
	{
		global $link;
		 $sql = "SELECT contact_no FROM app_users WHERE id = '".$user_id."'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		
		if(!empty($row["contact_no"]))
		{
			$app_info[0] = array("contact_no" => $row["contact_no"]);
			$app_list = array("success" => 1,"result" => $app_info,"flag"=>1);
		}
		else
		{
			$app_list = array("success" => 0,"flag"=>0);
		}

		
		return $app_list;
	}
	function get_my_doctor($user_id)
	{		
		global $link;
		$i=0;
		$sql="SELECT doctor_name, contact_no, dr_address,dr_clinic_name,dr_time,dr_time1,dr_img,dr_specification,dr_experience,dr_qulification,vci_reg_no from app_users  WHERE id = '".$user_id."' ";
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
				$app_info[$i] = array("doctor_name" => $row["doctor_name"],"contact_no" => $row["contact_no"],"dr_address" => $row["dr_address"],"dr_clinic_name" => $row["dr_clinic_name"],"dr_time" => $row["dr_time"],"dr_time1" => $row["dr_time1"],"dr_img" => $row["dr_img"],"dr_specification" => $row_specilization["specility_name"],"dr_experience" => $row["dr_experience"],"dr_qulification" => $row["dr_qulification"],"vci_reg_no" => $row["vci_reg_no"]);
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
	function edit_my_doctor_ios($user_id,$doctor_name,$contact_no,$dr_address,$dr_clinic_name,$dr_time,$dr_time1,$dr_specification,$dr_experience,$dr_qulification,$vci_reg_no)
	{		
		global $link;
		$image_file = $_FILES['myFile']['tmp_name'];				
		$imagename = $user_id.".png";					
		$path_img = "uploads/$imagename";
					
		move_uploaded_file($image_file, $path_img);			
		
		$img = "http://www.discovermypet.in/pet/$path_img";
		
		$sql_user_name = "SELECT name,dr_sms FROM app_users WHERE id = '$user_id'";
		$result_user_name = mysqli_query($link,$sql_user_name);
		$row_user_name = mysqli_fetch_array($result_user_name);
		$name = $row_user_name["name"];		
		if($row_user_name["dr_sms"]=='0')
		{
			$user_msg = urlencode("Dear Dr. $doctor_name, $name from your reference has registered with DMP application. You will get rewarded for every purchase done by $name. Thanking you DMP Team");
		
			$mobile = '91'.$contact_no;
			send_sms($user_msg, $mobile);		
			
			$sql="UPDATE app_users SET doctor_name = '".$doctor_name."',contact_no = '".$contact_no."',dr_address = '".$dr_address."',dr_clinic_name = '".$dr_clinic_name."',dr_img = '".$img."',dr_time = '".$dr_time."',dr_time1 = '".$dr_time1."',dr_specification = '".$dr_specification."',dr_experience = '".$dr_experience."',dr_qulification = '".$dr_qulification."',vci_reg_no = '".$vci_reg_no."',dr_sms = '1' WHERE id = '".$user_id."'";
		}	
		else
		{
			$sql="UPDATE app_users SET doctor_name = '".$doctor_name."',contact_no = '".$contact_no."',dr_address = '".$dr_address."',dr_clinic_name = '".$dr_clinic_name."',dr_img = '".$img."',dr_time = '".$dr_time."',dr_time1 = '".$dr_time1."',dr_specification = '".$dr_specification."',dr_experience = '".$dr_experience."',dr_qulification = '".$dr_qulification."',vci_reg_no = '".$vci_reg_no."' WHERE id = '".$user_id."' ";
		}
			
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
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
	 function my_profile($user_id, $image,$username)
	{		
		global $link;
		$sql="UPDATE app_users SET image = '".$image."',username = '".$username."' WHERE id = '".$user_id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}

	function get_my_profile($user_id)
	{		
		global $link;
		$sql = "select * from app_users where id = '".$user_id."'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		$app_info[0] = array("id" => $row["id"],"image" => $row["image"],"username" => $row["username"]);
		$app_list = array("result" => $app_info);
		return $app_list;
	}
	/*
	function add_surgery($surgery)
	{		
		$sql = "INSERT into surgery (surgery_name, date_created) values ('".$surgery."', '".date('Y-m-d H:i:s')."')";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function get_surgery($id)
	{		
		$i = 0;
		$sql = "select surgery_name from surgery where id = '".$id."'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		$app_info[0] = array("surgery_name" => $row["surgery_name"]);
		$app_list = array("result" => $app_info);
		return $app_list;
	}
	function edit_surgery($id, $surgery)
	{		
		$sql="UPDATE surgery SET surgery_name = '".$surgery."' WHERE id = '".$id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	} 

	function add_note($note)
	{		
		$sql = "INSERT into note (note_name, date_created) values ('".$note."', '".date('Y-m-d H:i:s')."')";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function get_note($id)
	{		
		$i = 0;
		$sql = "select note_name from note where id = '".$id."'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		$app_info[0] = array("note_name" => $row["note_name"]);
		$app_list = array("result" => $app_info);
		return $app_list;
	}
	function edit_note($id,$note_name)
	{		
		$sql="UPDATE note SET note_name = '".$note_name."' WHERE id = '".$id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}*/
	function edit_diet($id,$diet_name)
	{		
		global $link;
		$sql="UPDATE diet SET diet_name = '".$diet_name."' WHERE id = '".$id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function delete_diet($id,$pet_id)
	{		
		global $link;
		$sql="DELETE FROM diet WHERE id = '".$id."'and pet_id = '".$pet_id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
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
	/* function add_need($need)
	{		
		$sql = "INSERT into need (need_name, date_created) values ('".$need."', '".date('Y-m-d H:i:s')."')";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function get_need($id)
	{		
		$i = 0;
		$sql = "select need_name from need where id = '".$id."'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		$app_info[0] = array("need_name" => $row["need_name"]);
		$app_list = array("result" => $app_info);
		return $app_list;
	}
	function edit_need($id,$need_name)
	{		
		$sql="UPDATE need SET need_name = '".$need_name."' WHERE id = '".$id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function add_insurance($insurance)
	{		
		$sql = "INSERT into insurance (insurance_name, date_created) values ('".$insurance."', '".date('Y-m-d H:i:s')."')";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function get_insurance($id)
	{		
		$i = 0;
		$sql = "select insurance_name from insurance where id = '".$id."'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		$app_info[0] = array("insurance_name" => $row["insurance_name"]);
		$app_list = array("result" => $app_info);
		return $app_list;
	}
	function edit_insurance($id,$insurance_name)
	{		
		$sql="UPDATE insurance SET insurance_name = '".$insurance_name."' WHERE id = '".$id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	 */
	function edit_medical_details($id,$title)
	{		
		global $link;
		$sql="UPDATE medical_details SET title = '".$title."' WHERE id = '".$id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}

	function delete_medical_details($id,$pet_id)
	{		
		global $link;
		$sql="DELETE FROM medical_details  WHERE id = '".$id."'and pet_id ='".$pet_id."' ";
		$result = mysqli_query($link,$sql); 
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	/* function edit_appointment($id,$appointment_name,$date1,$age,$breed,$identification,$medical,$pincode)
	{		
		$sql="UPDATE appointment SET appointment_name = '".$appointment_name."',date1 = '".$date1."',age = '".$age."',breed = '".$breed."',identification = '".$identification."',medical = '".$medical."',pincode = '".$pincode."' WHERE id = '".$id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	} */

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

	/* function add_appointment($name,$date1,$age,$breed,$identification,$medical,$pincode)
	{		
		$sql = "INSERT into appointment (appointment_name, date1,age,breed,identification,medical,pincode,date_created) values ('".$name."','".$date1."','".$age."','".$breed."','".$identification."','".$medical."','".$pincode."', '".date('Y-m-d H:i:s')."')";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function get_appointment($id)
	{		
		$i = 0;
		$sql = "select appointment_name, date1,age,breed,identification,medical,pincode from appointment where id = '".$id."'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		$app_info[0] = array("appointment_name" => $row["appointment_name"],"date1" => $row["date1"],"age" => $row["age"],"breed" => $row["breed"],"identification" => $row["identification"],"medical" => $row["medical"],"pincode" => $row["pincode"]);
		$app_list = array("result" => $app_info);
		return $app_list;
	} */
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
	function get_parasite_brand()
	{
		global $link;
		$i=0;
		$sql = "select brand_name from tbl_parasite_brand";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("brand_name" => $row["brand_name"]);	
			$i++;
		}
			$app_list = array("success" => 1,"result" => $app_info);
			return $app_list;	
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
	 
	function add_parasite_control($received_dte,$nxt_dte,$pet_id,$brand)
	{
		global $link;
		$sql = "INSERT into tbl_parasite_control (received_date,next_date,pet_id,brand_name	) values ('".$received_dte."','".$nxt_dte."','".$pet_id."','".$brand."')";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
		
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


	/* function add_owner($owner_name,$city_area,$email,$phone,$pincode,$gender)
	{		
		$sql = "INSERT into owner (owner_name,city_area,email,phone,pincode,gender,date_created) values ('".$owner_name."','".$city_area."','".$email."','".$phone."','".$pincode."','".$gender."','".date('Y-m-d H:i:s')."')";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	} 
	function get_owner($id)
	{		
		$i = 0;
		$sql = "select owner_name,city_area,email,phone,pincode,gender from owner where id = '".$id."'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		$app_info[0] = array("owner_name" => $row["owner_name"],"city_area" => $row["city_area"],"email" => $row["email"],"phone" => $row["phone"],"pincode" => $row["pincode"],"gender" => $row["gender"]);
		$app_list = array("result" => $app_info);
		return $app_list;
	}
	function edit_owner($id,$owner_name,$city_area,$email,$phone,$pincode,$gender)
	{		
		$sql="UPDATE owner SET owner_name = '".$owner_name."',city_area = '".$city_area."',email = '".$email."',phone = '".$phone."',pincode = '".$pincode."',gender = '".$gender."' WHERE id = '".$id."' ";
		$result = mysqli_query($link,$sql);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}*/

	function add_friend($user_id,$friend_id) 
	{		
		global $link;
		$sql = "INSERT into tbl_friends(user_id,friend_id,friend_date) values ('".$user_id."','".$friend_id."','".date('Y-m-d H:i:s')."')";
		$result = mysqli_query($link,$sql);

		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => 0);
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	/* function get_package($package_id)
	{
		global $link;
		$sql = "SELECT id,plan_name,description,bullet_title,bullet_points,rate_title,rate FROM tbl_service_plans WHERE id = '".$package_id."'"
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result))
			{
				$app_info[$i] = array("id" => $row["id"],"plan_name" => $row["plan_name"],"bullet_title" => $row["bullet_title"]);
				$i++;
				
			}
			$app_list = array("result" => $app_info);
			return $app_list;
		}
			else
				$returnarr = array("success" => 0, "error" => "no records found");		
				return $returnarr;
		
	} */
	function get_product_category_list($main_id)
	{
		global $link;
		$app_info = array();	
		$i = 0;
			
		$sql ="select id,catogories_name FROM tbl_product_category WHERE main_id = '".$main_id."' order by id asc";
		$result = mysqli_query($link, $sql);
		while($row = mysqli_fetch_array($result))
		{		
			$app_info[$i] = array("id" => $row["id"],"catogory_name" => $row["catogories_name"]);
			//$app_list = array("success" => 1,"result" => $app_info);
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
	function get_main_category_list()
	{
		global $link;
		$app_info = array();
		
		$i = 0;
			
		$sql ="select id,main_category FROM tbl_product_main_cat order by id";
		$result = mysqli_query($link, $sql);
		while($row = mysqli_fetch_array($result))
		{		$app_info_sub = array();
			$sql_sub = "SELECT id,catogories_name FROM tbl_product_category WHERE main_id = '".$row["id"]."' order by id";
			$result_sub = mysqli_query($link,$sql_sub);
			$j=0;
			while($row_sub = mysqli_fetch_array($result_sub))
			{
				
				$app_info_sub[$j] = array("sub_id" => $row_sub["id"],"sub_category" => $row_sub["catogories_name"]);
				$j++;
			}
			
			$app_info[$i] = array("main_id" => $row["id"],"main_category" => $row["main_category"],"sub_cat"=> $app_info_sub);
			
			$i++;
			unset($app_info_sub[$j]);
			
		}
		
		if (empty($app_info)) 
		{
			$app_list = array("success" => 0, "error" => "no records found");
			return $app_list;	
		}
		$app_list = array("success" => 1,"result" => $app_info,"city"=>"Pune");
		return $app_list;
	}
	function get_product_list($cat_id,$city)
	{	
		global $link;
		$i=0;		
		$j=0;		
		$plans = array();
		
		$sql_tax = "SELECT tax_rate FROM tbl_service_tax";
		$result_tax = mysqli_query($link,$sql_tax);
		$row_tax = mysqli_fetch_array($result_tax);
	
		$sql_product = "SELECT c.id as category_id,p.main_category_id,c.catogories_name,p.id as prod_id,p.plan_name,p.description,p.rate,p.orignal_price,p.image,p.offer FROM tbl_service_plans as p, tbl_product_category as c WHERE category_id = '".$cat_id."' and c.id = p.category_id";
		
		$result_product = mysqli_query($link,$sql_product);
		
		if(mysqli_num_rows($result_product) > 0)
		{
			$sql_shipping = "SELECT range1,shipping FROM tbl_charges";
			$result_shipping =mysqli_query($link,$sql_shipping);
			while($row_shipping = mysqli_fetch_array($result_shipping))
			{
				$app_charge[$j] = array("range"=>$row_shipping["range1"],"shipping"=>$row_shipping["shipping"]);
				$j++;
			}	
			
			while($row_product = mysqli_fetch_array($result_product))
			{				
				$sql_main_cat = "SELECT main_category FROM tbl_product_main_cat WHERE id = '".$row_product['main_category_id']."'";
				$result_main_cat = mysqli_query($link,$sql_main_cat);
				$row_main_cat = mysqli_fetch_array($result_main_cat);
				
				/* if($row_main_cat["main_category"] == "Pet Food")
				{
					if($city =="Pune")
					{
						$a=0;	
						$attributes = array();				
						$sql_attribute = "SELECT id,weight_id,size_name,price,img FROM tbl_product_attribute WHERE product_id = '".$row_product['prod_id']."'";
						$result_attribute = mysqli_query($link,$sql_attribute);				
						while($row_attribute = mysqli_fetch_array($result_attribute))
						{
							$sql_weight_nm = "SELECT weight_range FROM tbl_pet_weight WHERE id = '".$row_attribute['weight_id']."'";
							$result_weight_nm = mysqli_query($link,$sql_weight_nm);
							if(mysqli_num_rows($result_weight_nm) > 0)
							{
								$row_weight_nm = mysqli_fetch_array($result_weight_nm);
								$weight_nm = $row_weight_nm["weight_range"];
							}
							else
							{
								$weight_nm = "null";
							}
							
							$attributes[$a] = array("atr_id"=>$row_attribute["id"],"weight_name"=>$weight_nm,"size_name"=>$row_attribute["size_name"],"price"=>$row_attribute["price"],"img"=>$row_attribute["img"]);
							$a++;
						}
						$sql_color_id = "SELECT color_id FROM tbl_product_color WHERE product_id = '".$row_product['prod_id']."'";
						$result_color_id = mysqli_query($link,$sql_color_id);
						$row_color_id = mysqli_fetch_array($result_color_id);
						
						$color_id = explode(",",$row_color_id["color_id"]);
						for($m=0;$m<count($color_id);$m++)
						{
							$sql_color = "SELECT color_nm FROM tbl_color WHERE id = '".$color_id[$m]."'";
							$result_color = mysqli_query($link,$sql_color);
							$row_color = mysqli_fetch_array($result_color);
							
							$colors[$m] = $row_color["color_nm"];
						}				
						$clrs = implode(",",$colors);					
						$colors_nm[0] = array("color"=>$clrs);					
						
						$image = explode(",",$row_product["image"]);
						$app_info[$i] = array("id"=>$row_product["prod_id"],"category_id"=>$row_product["category_id"],"category_name"=>$row_product["catogories_name"],"plan_name"=>$row_product["plan_name"],"description"=>$row_product["description"],"rate"=>$row_product["rate"],"original_price"=>$row_product["orignal_price"],"offer"=>$row_product["offer"],"image"=>$image,"color"=>$colors);
						
						$app_info[$i]["attribute"] = $attributes;
						$app_info[$i]["plan"] = $plans;						
										
						$i++;						
					}
					else
					{
						$app_list = array("success" => 0, "error" => "no records found","charges"=>$app_charge,"service_tax"=>$row_tax["tax_rate"]);
						return $app_list;	
					}
				}
				else
				{ */
					$a=0;	
					$attributes = array();				
					$sql_attribute = "SELECT id,weight_id,size_name,price,img FROM tbl_product_attribute WHERE product_id = '".$row_product['prod_id']."'";
					$result_attribute = mysqli_query($link,$sql_attribute);				
					while($row_attribute = mysqli_fetch_array($result_attribute))
					{
						$sql_weight_nm = "SELECT weight_range FROM tbl_pet_weight WHERE id = '".$row_attribute['weight_id']."'";
						$result_weight_nm = mysqli_query($link,$sql_weight_nm);
						if(mysqli_num_rows($result_weight_nm) > 0)
						{
							$row_weight_nm = mysqli_fetch_array($result_weight_nm);
							$weight_nm = $row_weight_nm["weight_range"];
						}
						else
						{
							$weight_nm = "null";
						}
						
						
						$attributes[$a] = array("atr_id"=>$row_attribute["id"],"weight_name"=>$weight_nm,"size_name"=>$row_attribute["size_name"],"price"=>$row_attribute["price"],"img"=>$row_attribute["img"]);
						$a++;
					}
					$sql_color_id = "SELECT color_id FROM tbl_product_color WHERE product_id = '".$row_product['prod_id']."'";
					$result_color_id = mysqli_query($link,$sql_color_id);
					$row_color_id = mysqli_fetch_array($result_color_id);
					
					$color_id = explode(",",$row_color_id["color_id"]);
					for($m=0;$m<count($color_id);$m++)
					{
						$sql_color = "SELECT color_code FROM tbl_color WHERE id = '".$color_id[$m]."'";
						$result_color = mysqli_query($link,$sql_color);
						$row_color = mysqli_fetch_array($result_color);
						
						$colors[$m] = $row_color["color_code"];
					}				
					$clrs = implode(",",$colors);					
					$colors_nm[0] = array("color"=>$clrs);					
					
					$image = explode(",",$row_product["image"]);
					$app_info[$i] = array("id"=>$row_product["prod_id"],"category_id"=>$row_product["category_id"],"category_name"=>$row_product["catogories_name"],"plan_name"=>$row_product["plan_name"],"description"=>$row_product["description"],"rate"=>$row_product["orignal_price"],"original_price"=>$row_product["rate"],"offer"=>$row_product["offer"],"image"=>$image,"color"=>$colors); 
					
					$app_info[$i]["attribute"] = $attributes;		
					$app_info[$i]["plan"] = $plans;					
									
					$i++;
				//}
			}
				$app_list = array("success" => 1,"result" => $app_info,"charges"=>$app_charge,"service_tax"=>$row_tax["tax_rate"]);
				return $app_list;
			
		}
		else
		{
			$app_list = array("success" => 0, "error" => "no records found");
			return $app_list;	
		}				
	}
	/* function get_product_list($cat_id,$city)
	{
		global $link;
		$subquery = "";
		$i = 0;
		$j = 0;  
		$c = 0;  
			
	 	$sql_city = "SELECT id FROM tbl_vendor WHERE city = '".$city."'";
		$result_city = mysqli_query($link,$sql_city);
		while($row_city = mysqli_fetch_array($result_city))
		{
			 $vendor_id = $row_city["id"];
			 
		
		$app_info = array();
		if($cat_id != 0)
				
			//$subquery = " and s.category_id = '".$cat_id."' and vendor_id = '$vendor_id' ";
			$subquery = " and s.category_id = '".$cat_id."' ";
			
			
		$sql = "SELECT  s.id,s.category_id, s.plan_name, s.description, s.bullet_title, s.bullet_points, s.rate, s.rate_title, s.orignal_price, s.offer, s.image, c.catogories_name , min( rate ) FROM tbl_service_plans AS s, tbl_product_category AS c WHERE s.category_id = c.id AND s.service_id =2 $subquery GROUP BY `plan_name` ORDER BY s.category_id, s.id ";
			
			
		//echo $sql ="select s.id,s.category_id, s.plan_name, s.description, s.bullet_title, s.bullet_points, s.rate, s.rate_title, s.orignal_price, s.offer, s.image, c.catogories_name FROM tbl_service_plans as s, tbl_product_category as c where s.category_id = c.id and s.service_id = 2 $subquery order by s.category_id,s.id ";
		$result = mysqli_query($link, $sql);
		while($row = mysqli_fetch_array($result))
		{	$l = 0;   

			$sql_pack_rate = "SELECT id,pack,rate as pack_rate FROM tbl_product_pack WHERE product_id = '".$row['id']."'";
			$result_pack_rate = mysqli_query($link, $sql_pack_rate);
			
			if(mysqli_num_rows($result_pack_rate) > 0)
			{
				$image = explode(",",$row["image"]);
				 for($i=0;$i<count($image);$i++)
				{
					
				} 
				
				$row_pack_rate = mysqli_fetch_array($result_pack_rate);
				$app_info[$i] = array("id" => $row["id"],"category_id" => $row["category_id"],"category_name" => $row["catogories_name"],"plan_name" => $row["plan_name"],"description" => $row["description"],"rate" => $row_pack_rate["pack_rate"],"rate_title" => $row_pack_rate["pack_rate"],"original_price" => $row["rate"],"offer" => $row["offer"],"image"=>$image);
			}
			else
			{
				$image = explode(",",$row["image"]);
				$app_info[$i] = array("id" => $row["id"],"category_id" => $row["category_id"],"category_name" => $row["catogories_name"],"plan_name" => $row["plan_name"],"description" => $row["description"],"rate" => $row["rate"],"rate_title" => $row["rate"],"original_price" => $row["rate"],"offer" => $row["offer"],"image" => $image);
			}
			
			$sql_pack = "SELECT id,pack,rate as pack_rate FROM tbl_product_pack WHERE product_id = '".$row['id']."'";
			$result_pack = mysqli_query($link, $sql_pack);
			$plans = array();
			$k = 0;
			while($row_pack = mysqli_fetch_array($result_pack))
			{
				$plans[$k] = array("pack_id"=>$row_pack["id"],"pack"=>$row_pack["pack"],"pack_rate"=>$row_pack["pack_rate"]); 			
				$l++;		
				$k++;			
			}
			
			$sql_attribute = "SELECT id,weight_id,size_name,price,img FROM tbl_product_attribute WHERE product_id = '".$row['id']."'";
			$result_attribute = mysqli_query($link,$sql_attribute);
			$attribute = array();
			$a = 0;
			while($row_attribute = mysqli_fetch_array($result_attribute))
			{
				
				$img = explode(",",$row_attribute["img"]);
				$imgg = array();
				for($m=0;$m<count($img);$m++)
				{
					$imgg[] = $img[$m] ;
					
				}
				$size_name = explode(",",$row_attribute["size_name"]);
				$attribute_nm = array();
				for($p=0;$p<count($size_name);$p++)
				{
					$attribute_nm[] = $size_name[$p] ;
					
				}
				if($row_attribute["weight_id"]=='1')
				{
					$attribute[$a] = array("attribute"=>'color',"attribute_id"=>$row_attribute["id"],"attribute_name"=>$row_attribute["size_name"],"attribute_price"=>$row_attribute["price"],"attribute_img"=>$row_attribute["img"]);
				}
				else
				{
					$attribute[$a] = array("attribute"=>'size',"attribute_id"=>$row_attribute["id"],"attribute_name"=>$row_attribute["size_name"],"attribute_price"=>$row_attribute["price"],"attribute_img"=>$row_attribute["img"]);
				}
				$a++;
				
			}
			
				
			$app_info[$i]["attribute"] = $attribute;
				
			
			$app_info[$i]["plan"] = $plans;
			$i++;	
		}
		//print_r($app_info);
		//	$c++;
		//}
		if(empty($app_info)) 
		{
			$app_list = array("success" => 0, "error" => "no records found");
			return $app_list;	
		}
		$sql_shipping = "SELECT range1,shipping FROM tbl_charges";
		$result_shipping =mysqli_query($link,$sql_shipping);
		while($row_shipping = mysqli_fetch_array($result_shipping))
		{
			$app_charge[$j] = array("range"=>$row_shipping["range1"],"shipping"=>$row_shipping["shipping"]);
			$j++;
		}	
		$app_list = array("success" => 1,"result" => $app_info,"charges"=>$app_charge);
		return $app_list;
	} */
	function get_product_details($product_id)
	{
		global $link;
		$i=0;
		$j=0;
		$k=0;
		$subquery = "";
		$app_info = array();
		
		$subquery = " and s.id = '".$product_id."' ";
				
		$sql ="select s.id,s.category_id, s.plan_name, s.description, s.bullet_title, s.bullet_points, s.rate, ,s.orignal_price, s.offer, s.image, c.catogories_name FROM tbl_service_plans as s, tbl_product_category as c where s.category_id = c.id and s.service_id = 2 $subquery ";
		$result = mysqli_query($link, $sql);
		while($row = mysqli_fetch_array($result))
		{		
			$new_price = $row["rate"] *  $row["offer"];
			$new_p = $new_price / 100;
			$orignal =  $row["rate"] - $new_p ; 
			$app_info[$i] = array("id" => $row["id"],"category_id" => $row["category_id"],"category_name" => $row["catogories_name"],"plan_name" => $row["plan_name"],"description" => $row["description"],"plan_name" => $row["plan_name"],"rate" => $row["rate"],"rate_title" => $row["rate_title"],"original_price" => $orignal,"offer" => $row["offer"],"image" => $row["image"]);
				
				$i++;
		}
		$sql_pack = "SELECT id,pack,rate as pack_rate FROM tbl_product_pack WHERE product_id = '".$product_id."'";
		$result_pack = mysqli_query($link, $sql_pack);
		while($row_pack = mysqli_fetch_array($result_pack))
		{
			$app_info_pack[$i] = array("pack_id"=>$row_pack["id"],"pack"=>$row_pack["pack"],"pack_rate"=>$row_pack["pack_rate"]);
			
				$i++;
		}
		$sql_shipping = "SELECT range1,shipping FROM tbl_charges";
		$result_shipping =mysqli_query($link,$sql_shipping);
		while($row_shipping = mysqli_fetch_array($result_shipping))
		{
			$app_charge[$k] = array("range"=>$row_shipping["range1"],"shipping"=>$row_shipping["shipping"]);
			$k++;
		}	
		if (empty($app_info)) 
		{
			$app_list = array("success" => 0, "error" => "no records found","charges"=>$app_charge);
			return $app_list;	
		}
		elseif(empty($app_info_pack))
		{
		
			$app_null=array("error"=>"0");
			$app_list = array("success" => 1,"result" => $app_info,"pack"=>$app_null,"type"=>"product","charges"=>$app_charge);
			return $app_list;
		}
		else
		{
			//$arra =  array("error"=>0,$app_info_pack);
			$app_list = array("success" => 1,"result" => $app_info,"pack"=>$app_info_pack,"type"=>"product","charges"=>$app_charge);
			return $app_list;
		}	
	}

	function get_package($package_id)
	{
		global $link;
		$i=0;
		$j=0;
		$k=0;
		$sql ="select id,plan_name,description,offer,bullet_title,bullet_points,rate_title,rate FROM tbl_service_plans  WHERE id = '".$package_id."'";
		$result = mysqli_query($link, $sql);
		while($row = mysqli_fetch_array($result))
		{
			$arrPets[$i] = explode('&*!@' ,$row["bullet_points"]);		
			$app_info[$j] = array("bullet_points" => $arrPets[$j]);
			
			$app_info[$i][$j] = array("id" => $row["id"],"plan_name" => $row["plan_name"],"description" => $row["description"],"offer" => $row["offer"],"bullet_title" => $row["bullet_title"],"rate_title"=> $row["rate_title"],"rate"=> $row["rate"],"type"=>"package");
			$i++; 		
			$j++; 			
		}
		$sql_shipping = "SELECT range1,shipping FROM tbl_charges";
		$result_shipping =mysqli_query($link,$sql_shipping);
		while($row_shipping = mysqli_fetch_array($result_shipping))
		{
			$app_charge[$k] = array("range"=>$row_shipping["range1"],"shipping"=>$row_shipping["shipping"]);
			$k++;
		}
		if (empty($app_info)) 
		{
			
			$app_list = array("success" => 0, "error" => "no records found");
			return $app_list;	
		}
		$app_list = array("success" => 1,"result" => $app_info,"charges"=>$app_charge);
		return $app_list;
	}


	function add_to_cart($add_cart,$user_id)
	{
		global $link;
		$date = date('Y-m-d H:i:s');
		$sql_master = "Insert into tbl_cart_master (user_id,date_purchase) VALUES('".$user_id."','".$date."') ";
		$result_master = mysqli_query($link,$sql_master);
		$cart_master_id = mysqli_insert_id($link);
		$arr = json_decode($add_cart,true);
		//$rate =0;
		$orders = $arr['Order'];
		for($i=0;$i<sizeof($orders);$i++)
		{	
			$id = $arr['Order'][$i]['ID'];
			$quantity =$arr['Order'][$i]['quantity'];
			$type = $arr['Order'][$i]['type'];		 
			$pack_id = $arr['Order'][$i]['pack_id'];		 
			$attribute_id = $arr['Order'][$i]['attribute_id'];		 
		//	$rate = $arr['Order'][$i]['rate'];		 
			$color = $arr['Order'][$i]['color'];		 
		 
		if($type=="product")
			{
				if($attribute_id =="null")
				{
					$sql_select = "SELECT rate FROM tbl_service_plans WHERE id = '$id'";
					$result_select = mysqli_query($link,$sql_select);
					$row = mysqli_fetch_array($result_select);	
					$rate = $row["rate"];
				}
				else
				{
					$sql_select = "SELECT price FROM tbl_product_attribute WHERE id = '$attribute_id'";
					$result_select = mysqli_query($link,$sql_select);
					$row = mysqli_fetch_array($result_select);		
					$rate = $row["price"];
				}
				
				$sql = "INSERT into tbl_cart (product_id,quantity,type,cart_master_id,rate,user_id,attribute_id) VALUES('$id','$quantity','$type','$cart_master_id','$rate','$user_id','$attribute_id')"; 
								
				$result = mysqli_query($link,$sql);
			}
			else
			{
				$sql_select = "SELECT * FROM tbl_service_plans WHERE id = '$id'";
				$result_select = mysqli_query($link,$sql_select);
				$row = mysqli_fetch_array($result_select);		

				$sql = "INSERT into tbl_cart (package_id,quantity,type,cart_master_id,rate,user_id) VALUES('$id','$quantity','$type','$cart_master_id','".$row['rate']."','$user_id')"; 
				$result = mysqli_query($link,$sql);
				
			}
		}
		if(mysql_error()=="")
		{
			$returnarr = array("success" => 1, "error" => 0,"order_id"=>$cart_master_id);	
		}
		else
		{
			$returnarr = array("success" => 0, "error" =>1);	
		}
		return $returnarr;
	}
	function billing_details_wthout_chckbox($user_id,$fname,$lname,$email,$address2,$mobile,$city,$state,$country,$pincode,$d_fname,$d_lname,$d_mobile,$d_address2,$d_city,$d_state,$d_pincode)
	{		
		$name = $fname." ".$lname;
		$d_name = $d_fname." ".$d_lname;
		global $link;
		$sql = "INSERT into tbl_cart_master(user_id,billing_name,billing_email,billing_tel,billing_city,billing_address,billing_country,billing_state,billing_zip,delivery_name,delivery_address,	delivery_tel,delivery_city,delivery_state,delivery_zip,delivery_country) VALUES('".$user_id."','".$name."','".$email."','".$mobile."','".$city."','".$address2."','".$country."','".$state."','".$pincode."','".$d_name."','".$d_address2."','".$d_mobile."','".$d_city."','".$d_state."','".$d_pincode."','".$d_pincode."')";
		$result = mysqli_query($link,$sql);
		$cart_id = mysqli_insert_id($link);
		if(mysql_error() == "")	
		$returnarr = array("success" => "1", "error" => "0");
		else
		$returnarr = array("success" => "0", "error" => mysql_error());		

		return $returnarr;
	}
	function get_billing_details($user_id)
	{
		global $link;
		$sql = "SELECT billing_name,billing_email,billing_tel,billing_country,billing_address,billing_zip,billing_state,billing_city,delivery_name,delivery_state,delivery_address,delivery_tel,delivery_city,delivery_zip,delivery_country FROM tbl_cart_master WHERE user_id = '".$user_id."'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		
		$app_info[0] = array("billing_name"=>$row["billing_name"],"billing_email"=>$row["billing_email"],"billing_tel"=>$row["billing_tel"],"billing_country"=>$row["billing_country"],"billing_address"=>$row["billing_address"],"billing_zip"=>$row["billing_zip"],"billing_state"=>$row["billing_state"],"billing_city"=>$row["billing_city"],"delivery_name"=>$row["delivery_name"],"delivery_state"=>$row["delivery_state"],"delivery_address"=>$row["delivery_address"],"delivery_tel"=>$row["delivery_tel"],"delivery_city"=>$row["delivery_city"],"delivery_zip"=>$row["delivery_zip"],"delivery_country"=>$row["delivery_country"]);
		if(mysqli_num_rows($result) > 0)
		{
			if($row["billing_name"]==null)
			{
				$returnarr = array("success" => 0, "error" => "1");		 
				return $returnarr;
			}
			else
			{
				$app_list = array("result" => $app_info);
				return $app_list;
			}
			
		}
		else
		{
			$returnarr = array("success" => 0, "error" => "1");		 
			return $returnarr;
		}
	}
	function billing_details_wth_chckbox($user_id,$fname,$lname,$email,$address2,$mobile,$city,$state,$country,$pincode)
	{
		$name = $fname." ".$lname;
		
		global $link;
		$sql = "INSERT into tbl_cart_master(user_id,billing_name,billing_email,billing_address,billing_tel,billing_city,billing_state,billing_country,billing_zip,delivery_name,delivery_address,	delivery_city,delivery_state,delivery_zip) VALUES('".$user_id."','".$name."','".$email."','".$address2."','".$mobile."','".$city."','".$state."','".$country."','".$pincode."','".$name."','".$address2."','".$city."','".$state."','".$pincode."')";
		$result = mysqli_query($link,$sql);
		$cart_id = mysqli_insert_id($link);
		if(mysql_error() == "")	
		$returnarr = array("success" => "1", "error" => "0");
		else
		$returnarr = array("success" => "0", "error" => mysql_error());		

		return $returnarr;
	}
	function view_cart($user_id)
	{
		$i=0;	
		$k=0;
		$l=0;
		$c=0;
		
		global $link;
		$sql_order = "SELECT id,DATE_FORMAT(date_purchase,'%d-%m-%Y') as date_purchase,is_paid, payment_status FROM tbl_cart_master WHERE user_id = '".$user_id."' order by date_purchase desc";	
		$result_order = mysqli_query($link,$sql_order);
		
		while($row_order = mysqli_fetch_array($result_order))
		{  
			$total_all=0;
					
			$sql_cart = "SELECT product_id,package_id,pack_id,quantity,rate,attribute_id FROM tbl_cart WHERE cart_master_id = '".$row_order['id']."'";	
			$result_cart = mysqli_query($link, $sql_cart);
			$plans = array();		
			$attribute = array();		
			$j=0;
			$app_info_plan = array();
			while($row_cart = mysqli_fetch_array($result_cart))
			{	
				$total=0;	
				if(($row_cart['product_id'])!=0)
				{
					$sql_package_name = "SELECT plan_name,category_id,description,rate,rate_title,orignal_price,offer,image FROM tbl_service_plans WHERE id = '".$row_cart['product_id']."'";	
					$result_package_name = mysqli_query($link, $sql_package_name);
					$row_package_name = mysqli_fetch_array($result_package_name);
						
					$sql_category = "SELECT catogories_name FROM tbl_product_category WHERE id = '".$row_package_name['category_id']."'";
					$result_category = mysqli_query($link,$sql_category);
					$row_category = mysqli_fetch_array($result_category);
					
					$sql_attribute = "SELECT weight_id,size_name FROM tbl_product_attribute WHERE id ='".$row_cart['attribute_id']."'";
					$result_attribute = mysqli_query($link,$sql_attribute);
					$row_attribute = mysqli_fetch_array($result_attribute);
						
						$total += $row_cart["quantity"]*$row_package_name["rate"];
						$total_all = $total_all + $total;
						
						$app_info_plan[$j] = array("type"=>"product","id" => $row_cart["product_id"],"pack_id"=>$row_cart["pack_id"],"category_id" => $row_package_name["category_id"],"category_name" => $row_category["catogories_name"],"plan_name" => $row_package_name["plan_name"],"description" => $row_package_name["description"],"rate" => $row_package_name["rate"],"rate_title" => $row_package_name["rate_title"],"offer" => $row_package_name["offer"],"orignal_price" => $row_package_name["orignal_price"],"image" => $row_package_name["image"],"quantity" => $row_cart["quantity"],"attribute_name" => $row_attribute["size_name"],"total"=>$total); 				
							
						$app_info_plan[$j]["plan"] = $plans;					
							 
				}
					
				$j++;			
			}		
		//	print_r($app_info_plan);
			 if(empty($app_info_plan))
			{
				$app_list = array("success" => 0, "error" => "no records found");
				return $app_list;	
			}
			else
			{		
				if($row_order["is_paid"]==1)
				{
					$app_info[$i] = array("id" => $row_order["id"],"all_total"=>$total_all,"order_status"=>"successful","date_purchase"=>$row_order["date_purchase"],"order_detaile"=>$app_info_plan,"status"=>$row_order["payment_status"]);
										
				}
				else if($row_order["is_paid"]==0)
				{
					//continue;
					 $app_info[$i] = array("id" => $row_order["id"],"all_total"=>$total_all,"order_status"=>"pending","date_purchase"=>$row_order["date_purchase"],"order_detaile"=>$app_info_plan,"status"=>$row_order["payment_status"]);	
						 
				}
				else
				{
					
					$app_info[$i] = array("id" => $row_order["id"],"all_total"=>$total_all,"order_status"=>"failed","date_purchase"=>$row_order["date_purchase"],"order_detaile"=>$app_info_plan,"status"=>$row_order["payment_status"]);	
						
				}					
			}
			$i++; 
			unset($app_info_plan);
		}
		$sql_shipping = "SELECT range1,shipping FROM tbl_charges";
		$result_shipping =mysqli_query($link,$sql_shipping);
		
		$sql_tax = "SELECT tax_rate FROM tbl_service_tax";
		$result_tax = mysqli_query($link,$sql_tax);
		$row_tax = mysqli_fetch_array($result_tax);
		
		while($row_shipping = mysqli_fetch_array($result_shipping))
		{
			$app_charge[$c] = array("range"=>$row_shipping["range1"],"shipping"=>$row_shipping["shipping"]);
			$c++;
		}
		if(empty($app_info))
		{	
			$app_list = array("success" => 0, "error" => "no records found");
			return $app_list;	
		}
		else
		{
			$app_list = array("success" => 1,"result" => $app_info,"charges"=>$app_charge,"service_tax"=>$row_tax["tax_rate"]);
			return $app_list;
		}
	}
	function delete_package_cart($user_id,$package_id)
	{
		global $link;
		$sql = "DELETE FROM `tbl_cart` WHERE `user_id`= $user_id and `package_id`= $package_id";
		$result = mysqli_query($link, $sql);
		if(mysql_error() == "")	
		$returnarr = array("success" => "1", "error" => "0");
		else
		$returnarr = array("success" => "0", "error" => mysql_error());		

		return $returnarr;
	}
	function edit_cart($order_id,$add_cart,$user_id)
	{
		global $link;
		
		$sql_del = "DELETE FROM tbl_cart WHERE cart_master_id='".$order_id."'";
		$result_del = mysqli_query($link,$sql_del);
		
		$arr = json_decode($add_cart,true);
		$orders = $arr['Order'];
		for($i=0;$i<sizeof($orders);$i++)
		{	
			$id = $arr['Order'][$i]['ID'];
			$quantity =$arr['Order'][$i]['quantity'];
			$type = $arr['Order'][$i]['type'];		 

		if($type=="product")
			{
				$sql_select = "SELECT * FROM tbl_product_pack WHERE id = '$id'";
				$result_select = mysqli_query($link,$sql_select);
				$row = mysqli_fetch_array($result_select);		
							
				$sql = "INSERT into tbl_cart (pack_id,quantity,type,cart_master_id,rate,user_id) VALUES('$id','$quantity','$type','$order_id','".$row['rate']."','$user_id')"; 
				$result = mysqli_query($link,$sql);
			}
			else
			{
				$sql_select = "SELECT * FROM tbl_service_plans WHERE id = '$id'";
				$result_select = mysqli_query($link,$sql_select);
				$row = mysqli_fetch_array($result_select);		

				$sql = "INSERT into tbl_cart (package_id,quantity,type,cart_master_id,rate,user_id) VALUES('$id','$quantity','$type','$order_id','".$row['rate']."','$user_id')"; 
				$result = mysqli_query($link,$sql);			
			}
		}
		if(mysql_error()=="")
		{
			$returnarr = array("success" => 1, "error" => 0,"order_id"=>$order_id);	
		}
		else
		{
			$returnarr = array("success" => 0, "error" =>1);	
		}
		return $returnarr;
	}
	function delete_cart($OrderID)
	{
		global $link;
		$sql_del_master = "DELETE FROM tbl_cart_master WHERE id='".$OrderID."'";
		$result_del_master = mysqli_query($link,$sql_del_master);
		
		$sql_del = "DELETE FROM tbl_cart WHERE cart_master_id='".$OrderID."'";
		$result_del = mysqli_query($link,$sql_del);
		if(mysql_error()=="")
		{
			$returnarr = array("success" => 1, "error" => 0);	
		}
		else
		{
			$returnarr = array("success" => 0, "error" =>1);	
		}
		return $returnarr;
		
	}
	function add_timeline_video_ios($post_userid)
	{	
		global $link;
		$returnarr = array();
		$post_userid;
		if($_SERVER['REQUEST_METHOD']=='POST')
		{			
			$sql="INSERT INTO tbl_timeline(posted_date) VALUES('".date('Y-m-d H:i:s')."')";
			$result = mysqli_query($link , $sql);
			$timeline_id = mysqli_insert_id($link);		
			
			 if(!empty($_FILES['myFile1']['tmp_name'])) 
			 {
				$video_file = $_FILES['myFile1']['tmp_name'];
				$thub = $_FILES['thub']['tmp_name'];
				
				$videoname = $timeline_id.".mp4";
				$thubnail_name = $timeline_id.".png";
				
				$path = "uploads/timeline/$videoname";	
				$path1 = "uploads/timeline/$thubnail_name";
			
				move_uploaded_file($video_file, $path);
				move_uploaded_file($thub, $path1);
				
				$video = "http://www.discovermypet.in/pet/$path";	
				$thub_img = "http://www.discovermypet.in/pet/$path1";	
			
				$sql_update="UPDATE tbl_timeline SET user_id = '".$post_userid."',post_img = '".$thub_img."', post_video = '".$video."'WHERE id='".$timeline_id."' ";
				$result_update = mysqli_query($link,$sql_update);
			}
			else
			{	
			
				$image_file = $_FILES['myFile']['tmp_name'];			
				
					
				$imagename = $timeline_id.".png";					
				$path_img = "uploads/timeline/$imagename";	
							
				if(move_uploaded_file($image_file, $path_img))
				{				
					$img = "http://www.discovermypet.in/pet/$path_img";
					
					/* $im = new Imagick($img);
					$im->scaleImage(0,150);
					$im->writeImage($path_img);
					 */
				$sql_update="UPDATE tbl_timeline SET user_id = '".$post_userid."',post_img = '".$img."' WHERE id='".$timeline_id."' ";
				$result_update = mysqli_query($link,$sql_update);
				}
				else
				{
					$returnarr = array("success" => 0, "error" => 1);	
					return $returnarr;
				}
			}
		}
		else
		{
			echo "Error";
		}
				if(mysql_error() == "")				

				$returnarr = array("success" => 1, "error" => 0);
				else
				$returnarr = array("success" => 0, "error" => mysql_error());		

				return $returnarr;
	}


	function add_timeline_img_andriod($post_img,$post_userid,$post_text)
	{		
		global $link; 
		if($_SERVER['REQUEST_METHOD']=='POST')
		{		
			$sql="INSERT INTO tbl_timeline(post_text,posted_date) VALUES('".$post_text."','".date('Y-m-d H:i:s')."')";
			$result = mysqli_query($link,$sql);
			$timeline_id = mysqli_insert_id($link);
			$imagename = $timeline_id.".png";
			$path = "uploads/timeline/$imagename";		
			$img = "http://www.discovermypet.in/pet/$path";		
			file_put_contents($path,base64_decode($post_img));	
			
			/* $im = new Imagick($img);
			$im->scaleImage(300,0);
			$im->writeImage($path); */
			
			$sql_update="UPDATE tbl_timeline SET user_id = '".$post_userid."', post_img = '".$img."' WHERE id='".$timeline_id."' ";
			$result_update = mysqli_query($link,$sql_update);
			}
			else
			{
				echo "Error";
			}
				if(mysql_error() == "")				

				$returnarr = array("success" => 1, "error" => 0);
				else
				$returnarr = array("success" => 0, "error" => mysql_error());		

				return $returnarr;
	}
	function add_timeline_video_andriod($post_userid)
	{		
		global $link;
		$returnarr = array();
		$post_userid;
		if($_SERVER['REQUEST_METHOD']=='POST')
		{			
			$sql="INSERT INTO tbl_timeline(posted_date) VALUES('".date('Y-m-d H:i:s')."')";
			$result = mysqli_query($link , $sql);
			$timeline_id = mysqli_insert_id($link);		
			
			 if(!empty($_FILES['myFile']['tmp_name'])) 
			 {
				$video_file = $_FILES['myFile']['tmp_name'];
				//$thub = $_FILES['thub']['tmp_name'];
				
				$videoname = $timeline_id.".mp4";
				//$thubnail_name = $timeline_id.".png";
				
				$path = "uploads/timeline/$videoname";	
				//$path1 = "uploads/timeline/$thubnail_name";
			
				move_uploaded_file($video_file, $path);
			//	move_uploaded_file($thub, $path1);
				
				$video = "http://www.discovermypet.in/pet/$path";	
			//	$thub_img = "http://discovermypet.in/pet/$path1";	
			
				$sql_update="UPDATE tbl_timeline SET user_id = '".$post_userid."', post_video = '".$video."'WHERE id='".$timeline_id."' ";
				$result_update = mysqli_query($link,$sql_update);
			}
			else
			{	
			
				$image_file = $_FILES['myFile']['tmp_name'];				
				$imagename = $timeline_id.".png";					
				$path_img = "uploads/timeline/$imagename";	
							
				move_uploaded_file($image_file, $path_img);			
				
				$img = "http://www.discovermypet.in/pet/$path_img";
					
				$sql_update="UPDATE tbl_timeline SET user_id = '".$post_userid."',post_img = '".$img."' WHERE id='".$timeline_id."' ";
				$result_update = mysqli_query($link,$sql_update);
			}
		}
		else
		{
			echo "Error";
		}
				if(mysql_error() == "")				

				$returnarr = array("success" => 1, "error" => 0);
				else
				$returnarr = array("success" => 0, "error" => mysql_error());		

				return $returnarr;
	}
	function dog_walk($pet_ids, $km,$time)
	{	
		global $link;	
		$arrPets = explode(',' ,$pet_ids);	
		for($i = 0; $i<count($arrPets); $i++) 
		{
			$sql = "INSERT into tbl_dog_walk(pet_id,km,time,date_created) values ('".$arrPets[$i]."','".$km."','".$time."','".date('Y-m-d H:i:s')."')";
			$result = mysqli_query($link,$sql);
		}
		
		if(mysql_error() == "")				
		
			$returnarr = array("success" => 1, "error" => 0);
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
	}
	function get_dog_walk($pet_id)
	{		
		global $link;
		$i = 0;
		$sql = "select km,date_created,time from tbl_dog_walk WHERE pet_id = '".$pet_id."'";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_array($result))
			{
				$app_info[$i] = array("date" => $row["date_created"],"time" => $row["time"],"km" => $row["km"]);
				$i++;
				
			}
			$app_list = array("success" => 1,"result" => $app_info);
			return $app_list;
		}
			else
				$returnarr = array("success" => 0, "error" => "no records found");		
				return $returnarr;	
	}

	function get_timeline($id)
	{		
		global $link;
		$i = 0;
		$sql = "select user_id,post_text,post_img,post_video,user_id,posted_date from tbl_timeline where id = '".$id."'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		
		$sql_user = "select name,image from app_users where id = '".$row["user_id"]."'";
		$result_user = mysqli_query($link,$sql_user);
		$row_user = mysqli_fetch_array($result_user);
		
		$app_info[0] = array("id" => $row["user_id"],"User name" => $row_user["name"],"User image" => $row_user["image"],"post_text" => $row["post_text"],"post_img" => $row["post_img"],"post_video" => $row["post_video"],"user_id" => $row["user_id"],"posted_date" => $row["posted_date"]);
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
	}

	function get_timeline_img($timeline_id)
	{		
		global $link;
		$i = 0;
		 $sql = "select id,post_img,user_id,posted_date from tbl_timeline where id = '".$timeline_id."'";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
		 $sql_user_name = "select id,name,image from app_users where id = '".$row["user_id"]."'";
			$result_user_name = mysqli_query($link,$sql_user_name);
			$row_user_name = mysqli_fetch_array($result_user_name);
			
			$sql_comment = "select comment FROM tbl_notification WHERE timeline_id = '".$timeline_id."' and type='comment'";
			$result_comment = mysqli_query($link,$sql_comment);
			
			$count_cmt = mysqli_num_rows($result_comment);
			
			$sql_like = "select id FROM tbl_notification WHERE timeline_id =  '".$timeline_id."' and type='like'";
			$result_like = mysqli_query($link,$sql_like);
			
			$count_like = mysqli_num_rows($result_like);
			
			$today = new DateTime(date('Y-m-d H:i:s'));
			$pastDate = $today->diff(new DateTime($row["posted_date"]));

			if($pastDate->m > 1)
			{
				$posted_when = $pastDate->m." month(s) ago";
			}
			else if($pastDate->d > 0)
			{
				$posted_when = $pastDate->d." day(s) ago";
			}
			else
			{
				if($pastDate->h > 1)
					$posted_when = $pastDate->h." hrs ago";
				else
					$posted_when = $pastDate->i." minutes ago";
			}
					
			$sql_user_like = "select timeline_id FROM tbl_notification WHERE user_id = '".$row["user_id"]."' and timeline_id = '".$timeline_id."' and type = 'like'";
			$result_user_like = mysqli_query($link,$sql_user_like);
			if(mysqli_num_rows($result_user_like) != 0)
			{
				$name = ucwords($row_user_name["name"]);
				$app_info[$i] = array("id" => $row["id"],"user name" =>$name ,"user image" => $row_user_name["image"],"post_img" => $row["post_img"],"user_id" => $row["user_id"],"comment"=>$count_cmt,"like"=>$count_like,"like_status"=>"1","When"=>$posted_when);
				$i++;
			}
			else
			{
				$name = ucwords($row_user_name["name"]);
				$app_info[$i] = array("id" => $row["id"],"user name" => $name,"user image" => $row_user_name["image"],"post_img" => $row["post_img"],"user_id" => $row["user_id"],"comment"=>$count_cmt,"like"=>$count_like,"like_status"=>"0","When"=>$posted_when);
				$i++;
			}		
		}
		if (empty($app_info)) 
		{
			$app_list = array("success" => 0, "error" => "no records found");
			return $app_list;	
		}

		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
	}

	function get_pride_wall($user_id)
	{		
		global $link;
		$i = 0; 
		$sql_like = "SELECT count(`timeline_id`) as count,timeline_id FROM `tbl_notification` WHERE type='like' group by timeline_id order by count(`timeline_id`) desc LIMIT 5";
		$result_like = mysqli_query($link,$sql_like);
		while($row_like = mysqli_fetch_array($result_like))
		{
			$sql_img = "SELECT post_img,user_id FROM tbl_timeline WHERE id = '".$row_like['timeline_id']."'";
			$result_img = mysqli_query($link,$sql_img);
			$row_img = mysqli_fetch_array($result_img);
			$sql_name = "SELECT name FROM app_users WHERE id = '".$row_img['user_id']."'";
			$result_name = mysqli_query($link,$sql_name);
			$row_name = mysqli_fetch_array($result_name);
			 
			$app_info[$i] = array("pride_wall_img" => $row_img["post_img"],"username" => $row_name["name"]);
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
		
	}
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
		/* if (!$app_info)
		{
			$returnarr = array("success" => 0, "error" => "1");
			return $returnarr;
		}  */
		}
		else
		{
			$returnarr = array("success" => 0, "error" => 1);		

				return $returnarr;
		}	
	}
	/* function list_surgery()
	{		
		$i = 0;
		$sql = "select id, surgery_name from surgery";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("id" => $row["id"], "surgery_name" => $row["surgery_name"]);
			$i++;
		}
		$app_list = array("result" => $app_info);
		return $app_list;
	} */
	/* function list_note()
	{		
		$i = 0;
		$sql = "select id, note_name from note";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("id" => $row["id"], "note_name" => $row["note_name"]);
			$i++;
		}
		$app_list = array("result" => $app_info);
		return $app_list;
	} */
	function list_diet()
	{		
		global $link;
		$i = 0;
		$sql = "select id, diet_name,date_created from diet";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("id" => $row["id"], "diet_name" => $row["diet_name"], "date_created" => $row["date_created"]);
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
	function list_need()
	{		
		global $link;
		$i = 0;
		$sql = "select id, need_name from need";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("id" => $row["id"], "need_name" => $row["need_name"]);
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
	}
	/* function list_insurance()
	{		
		$i = 0;
		$sql = "select id, insurance_name from insurance";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("id" => $row["id"], "insurance_name" => $row["insurance_name"]);
			$i++;
		}
		$app_list = array("result" => $app_info);
		return $app_list;
	} */
	function list_medical_details()
	{		
		global $link;
		$i = 0;
		$sql = "select id, date1,title from medical_details";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("id" => $row["id"], "date1" => $row["date1"], "title" => $row["title"]);
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
	}

	function list_pet()
	{		
		global $link;
		$i = 0;
		$app_info = array();
		$sql = "SELECT id, image, pet_name, weight, gender, pet_type, pet_food, breed,birthdate, DATE_FORMAT(`birthdate` , '%e %b %Y' )AS birthday FROM pet_master";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("id" => $row["id"], "pet_name" => $row["pet_name"], "weight" => $row["weight"], "gender" => $row["gender"], "pet_type" => $row["pet_type"], "pet_food" => $row["pet_food"], "breed" => $row["breed"], "birthdate" => $row["birthdate"], "birthday" => $row["birthday"], "image" => $row["image"]);
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
	}

	function list_pet_of_user($user_id)
	{		
		global $link;
		$i = 0;
		$app_info = array();
		$sql = "SELECT id, thub, pet_name, weight, gender, pet_type, pet_food, breed,birthdate, DATE_FORMAT(`birthdate` , '%e %b %Y' )AS birthday FROM pet_master where user_id = '".$user_id."' and is_active = 1 ";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$pet_name = $row["pet_name"];
			$pet_name = ucwords($pet_name);
			
			$app_info[$i] = array("id" => $row["id"], "pet_name" => $pet_name,"gender" => $row["gender"], "pet_type" => $row["pet_type"], "pet_food" => $row["pet_food"],"birthday" => $row["birthday"], "image" => $row["thub"]);
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

	function latandlong($latitude,$longitude)
	{
		global $link;
		$app_info = array();
		$i = 0;
		$geolocation = $latitude.','.$longitude;
		$request = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.$geolocation.'&sensor=false'; 
		$file_contents = file_get_contents($request);
		$json_decode = json_decode($file_contents);
		if(isset($json_decode->results[0])) 
		{		
			
			foreach($json_decode->results[0]->address_components as $addressComponet) {
				if(in_array('postal_code', $addressComponet->types)) {
						 $postal_code = $addressComponet->long_name; 
						break;
				}
			}
		$sql = "select id,name from tbl_service_details WHERE pincode='$postal_code'";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("id" => $row["id"], "name" => $row["name"]);
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
		
		}
	  
	}
	/* function near($latitude,$longitude)
	{
		$i = 0;
		$sql = "SELECT * FROM near_location" ;
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("id" => $row["id"], "lat" => $row["lat"], "long" => $row["long"]);
			$i++;
		}
		$app_list = array("result" => $app_info);
		return $app_list;
		 
	} */

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
	function nearbysms($origLat,$origLon,$user_id,$service_name)
	{	
		global $link;
		$i = 0;
		$sql_user = "SELECT name,address1,mobile FROM app_users where id=$user_id";
		$result_user = mysqli_query($link,$sql_user);
		$row_user = mysqli_fetch_array($result_user);
		$dist = 3; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
		$query = "SELECT id, doctor_name,address,contact_no, latitude, longitude, 3956 * 2 * 
		ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
		+COS($origLat*pi()/180 )*COS(latitude*pi()/180)
		*POWER(SIN(($origLon-longitude)*pi()/180/2),2))) 
		as distance FROM near_location WHERE 
		longitude between ($origLon-$dist/cos(radians($origLat))*69) 
		and ($origLon+$dist/cos(radians($origLat))*69) 
		and latitude between ($origLat-($dist/69)) 
		and ($origLat+($dist/69)) 
		having distance < $dist ORDER BY distance limit 1"; 
		$result = mysqli_query($link,$query) or die(mysql_error());
		$row = mysqli_fetch_assoc($result);
		 $app_info[0] = array("doctor_id" => $row["id"],"images" => "null","doctor_name" => $row["doctor_name"], "distance" => $row["distance"], "latitude" => $row["latitude"], "longitude" => $row["longitude"]);
		$app_list = array("success" => 1,"error"=>0);
		if(mysqli_num_rows($result) > 0)	
		{	
			$user_msg = urlencode("Dear '".$row_user['name']."', Thanks for sending request to Discovermypet app services. Details you request are as below.
				Service name : $service_name 
				Contact person :  '".$row['doctor_name']."
				Address :'".$row["address"]."'
				Mobile no :'".$row["contact_no"]."'");
				send_sms($user_msg,$row["contact_no"]);
			$user_msg =urlencode("Dear '".$row['doctor_name'].", Someone has enquire for services details are as below.
			   Name :'".$row_user['name']."
			   Mobile no :'".$row_user['mobile']."'");
			   send_sms($user_msg, $row_user['mobile']);
		}
		return $app_list;
	}
	 function addressbook($user_id,$name,$mobile)
	{
		$url = "https://play.google.com/store/apps/details?id=discovermypet.navitorhealthcare&hl=en";
		global $link;
		$date = date("Y-m-d h:i:s");
		$sql ="select name FROM app_users WHERE id ='".$user_id."'";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) > 0)	
		{	
		
			$sql_frd_id = "SELECT id FROM app_users WHERE mobile = '".$mobile."'";
			$result_frd_id = mysqli_query($link,$sql_frd_id);
			$row_frd_id = mysqli_fetch_array($result_frd_id);
			$friend_id = $row_frd_id["id"];
			
			$sql_frd = "SELECT id FROM tbl_friends WHERE user_id = '".$user_id."' and friend_id = '".$friend_id."'";
			$result_frd = mysqli_query($link,$sql_frd);		
			if(mysqli_num_rows($result_frd) > 0)	
			{
				$returnarr = array("success" => 0, "error" =>"Already friend");
				return $returnarr;		
			}
			else
			{
				$sql_frd_req = "SELECT id FROM tbl_notification WHERE  user_id = '".$user_id."' and who_id = '".$friend_id."' and type='request'";
				$result_frd_req =mysqli_query($link,$sql_frd_req);
				/* if(mysqli_num_rows($result_frd_req) > 0)	
				{
					$returnarr = array("success" => 0, "error" =>"Already friend request send");
					return $returnarr;	
				}
				else
				{			 */
					$row = mysqli_fetch_assoc($result);			
					// $user_msg =urlencode("Dear '".$row['name'].", send a friend  request on Discovermypet.");

					 $user_msg =urlencode("Dear '".$name."' For your lovely pets 'Discover my pet' is there! Download this App '".$url."'.");
					send_sms($user_msg, $mobile);
					
					$sql_insert = "INSERT into tbl_notification(type,user_id,who_id,created_date) VALUES ('request','".$user_id."','".$friend_id."','".$date."')";
					$resuly_insert =mysqli_query($link,$sql_insert);
							
					$returnarr = array("success" => 1, "error" => 0);
					return $returnarr;
				//}
			}			
		}
		else
		{  
			$name = ucwords($name);
			$user_msg = urlencode("'".$name."' Send a friend request to you  Thanks,");
			send_sms($user_msg,$mobile); 
			$returnarr = array("success" => 1, "error" => 0);
			return $returnarr;
		}
		
	}
	function healthrecord()
	{
		global $link;
		$i=0;
		$j=0;
		$sql ="select id , service_name,image,type FROM service_master WHERE id !='7' order by id  LIMIT 7  ";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("id" => $row["id"],"service_name" => $row["service_name"],"image" => $row["image"],"type"=> $row["type"]);
			$i++;
		}	if (empty($app_info)) 
		{
			$app_list = array("success" => 0, "error" => "no records found");
			return $app_list;	
		}
		$sql_shipping = "SELECT range1,shipping FROM tbl_charges";
		$result_shipping =mysqli_query($link,$sql_shipping);
		while($row_shipping = mysqli_fetch_array($result_shipping))
		{
			$app_charge[$j] = array("range"=>$row_shipping["range1"],"shipping"=>$row_shipping["shipping"]);
			$j++;
		}
		$app_list = array("success" => 1,"result" => $app_info,"charges"=>$app_charge); 
		return $app_list;
	}
	function service_details($service_id)
	{
		global $link;
		$i=0;
		$j=0;
		
		$sql_master_img = "select id,image,service_name FROM service_master WHERE id ='".$service_id."'";
		$result_master_img = mysqli_query($link,$sql_master_img);
		$row_master_img = mysqli_fetch_array($result_master_img);
			
		$sql ="select id,plan_name,image,description,offer,bullet_title,bullet_points,rate_title,rate FROM tbl_service_plans  WHERE service_id = '".$service_id."'";
		$result = mysqli_query($link, $sql);
		while($row = mysqli_fetch_array($result))
		{
			$bullet_points = substr($row["bullet_points"],0,150);
			$arrPets[$i] = explode('&*!@' ,$bullet_points);		
			$app_info[$j] = array("bullet_points" => $arrPets[$j]);
			
		  $app_info[$i][$j] = array("id" => $row["id"],"plan_name" => $row["plan_name"],"image" => $row_master_img["image"],"description" => $row["description"],"offer" => $row["offer"],"bullet_title" => $row["bullet_title"],"rate_title"=> $row["rate_title"],"rate"=> $row["rate"]);
			$i++; 		
			$j++; 			
		}
		if (empty($app_info)) 
		{		
			$app_list = array("success" => 0, "error" => "no records found");
			return $app_list;	
		}
		$app_list = array("success" => 1,"result" => $app_info,"service_heading"=>$row_master_img["service_name"]);
		return $app_list;
		
	}

	function nearbyfrd($origLat,$origLon,$user_id)
	{	
		global $link;
		$i = 0;
		$dist = 5000; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
		$query = "SELECT id, name,address1,address2,mobile,image, latitude, longitude, 3956 * 2 * 
		ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
		+COS($origLat*pi()/180 )*COS(latitude*pi()/180)
		*POWER(SIN(($origLon-longitude)*pi()/180/2),2))) 
		as distance FROM app_users WHERE is_active = '1'  and id != '".$user_id."' and
		longitude between ($origLon-$dist/cos(radians($origLat))*69) 
		and ($origLon+$dist/cos(radians($origLat))*69) 
		and latitude between ($origLat-($dist/69)) 
		and ($origLat+($dist/69)) 
		having distance < $dist ORDER BY distance limit 100"; 
		$result = mysqli_query($link,$query) or die(mysql_error());
		while($row = mysqli_fetch_assoc($result)) 
		{
			$sql_frd = "SELECT * FROM `tbl_friends` WHERE user_id ='".$user_id."' AND `friend_id` ='".$row['id']."'";
			$result_frd = mysqli_query($link,$sql_frd);
			if(mysqli_num_rows($result_frd) != 0)
			{
				continue; 
			}
			else
			{
				$sql_frd_req = "SELECT * FROM `tbl_notification` WHERE user_id ='".$user_id."' AND who_id='".$row['id']."'";
				$result_frd_req = mysqli_query($link,$sql_frd_req);
				if(mysqli_num_rows($result_frd_req) != 0)
				{
					$name = ucwords($row["name"]);
					$app_info[$i] = array("id" => $row["id"],"friend_name" =>$name , "image" => $row["image"], "address" => $row["address2"], "mobile" => $row["mobile"], "latitude" => $row["latitude"], "longitude" => $row["longitude"],"request"=>1); 		
					$i++;
				}
				else
				{
					$name = ucwords($row["name"]);
					$app_info[$i] = array("id" => $row["id"],"friend_name" => $name, "image" => $row["image"], "address" => $row["address2"], "mobile" => $row["mobile"], "latitude" => $row["latitude"], "longitude" => $row["longitude"],"request"=>0); 		
					$i++;
				}
			}
			
		}
		if (empty($app_info)) 
		{		
			$app_list = array("success" => 0, "error" => "no records found");
			return $app_list;	
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
		
	}
	function search_nearbyfrd($user_id,$search)
	{
		global $link;
	//	$app_info =array;
		$url = "http://maps.google.com/maps/api/geocode/json?address=$search&sensor=false&region=India";
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
		$query = "SELECT id, name,address1,address2,mobile,image, latitude, longitude, 3956 * 2 * 
		ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
		+COS($origLat*pi()/180 )*COS(latitude*pi()/180)
		*POWER(SIN(($origLon-longitude)*pi()/180/2),2))) 
		as distance FROM app_users WHERE is_active = '1' and id != '".$user_id."' and
		longitude between ($origLon-$dist/cos(radians($origLat))*69) 
		and ($origLon+$dist/cos(radians($origLat))*69) 
		and latitude between ($origLat-($dist/69)) 
		and ($origLat+($dist/69)) 
		having distance < $dist ORDER BY distance limit 100"; 
		$result = mysqli_query($link,$query) or die(mysql_error());
		while($row = mysqli_fetch_assoc($result)) 
		{
			$sql_frd = "SELECT * FROM `tbl_friends` WHERE user_id ='".$user_id."' AND `friend_id` ='".$row['id']."'";
			$result_frd = mysqli_query($link,$sql_frd);
			if(mysqli_num_rows($result_frd) != 0)
			{
				continue; 
			}
			else
			{
				$sql_frd_req = "SELECT * FROM `tbl_notification` WHERE user_id ='".$user_id."' AND who_id='".$row['id']."'";
				$result_frd_req = mysqli_query($link,$sql_frd_req);
				if(mysqli_num_rows($result_frd_req) != 0)
				{
					$name = ucwords($row["name"]);
					$app_info[$i] = array("id" => $row["id"],"friend_name" => $name, "image" => $row["image"], "address" => $row["address2"], "mobile" => $row["mobile"], "latitude" => $row["latitude"], "longitude" => $row["longitude"],"request"=>1); 		
					$i++;
				}
				else
				{
					$name = ucwords($row["name"]);
					$app_info[$i] = array("id" => $row["id"],"friend_name" =>$name , "image" => $row["image"], "address" => $row["address2"], "mobile" => $row["mobile"], "latitude" => $row["latitude"], "longitude" => $row["longitude"],"request"=>0); 		
					$i++;
				}
			}
			
		}
		if (empty($app_info)) 
		{		
			$app_list = array("success" => 0, "error" => "no records found");
			return $app_list;	
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
	}

	function nearbyhome($origLat,$origLon)
	{	
		global $link;
		$i = 0;
		$dist = 3; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
		$query = "SELECT id,name, latitude, longitude, 3956 * 2 * 
		ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
		+COS($origLat*pi()/180 )*COS(latitude*pi()/180)
		*POWER(SIN(($origLon-longitude)*pi()/180/2),2))) 
		as distance FROM app_users WHERE 
		longitude between ($origLon-$dist/cos(radians($origLat))*69) 
		and ($origLon+$dist/cos(radians($origLat))*69) 
		and latitude between ($origLat-($dist/69)) 
		and ($origLat+($dist/69)) 
		having distance < $dist ORDER BY distance limit 100"; 
		$result = mysqli_query($link,$query) or die(mysql_error());
		while($row = mysqli_fetch_assoc($result)) 
		{
			 $app_info[$i] = array("ID" => $row["id"],"Doctor_name" => $row["name"], "distance" => $row["distance"], "latitude" => $row["latitude"], "longitude" => $row["longitude"]); 
			
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;

	}
	function nearbyinsurance($origLat,$origLon)
	{	
		global $link;
		$i = 0;
		$dist = 3; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
		$query = "SELECT id,name, latitude, longitude, 3956 * 2 * 
		ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
		+COS($origLat*pi()/180 )*COS(latitude*pi()/180)
		*POWER(SIN(($origLon-longitude)*pi()/180/2),2))) 
		as distance FROM app_users WHERE 
		longitude between ($origLon-$dist/cos(radians($origLat))*69) 
		and ($origLon+$dist/cos(radians($origLat))*69) 
		and latitude between ($origLat-($dist/69)) 
		and ($origLat+($dist/69)) 
		having distance < $dist ORDER BY distance limit 100"; 
		$result = mysqli_query($link,$query) or die(mysql_error());
		while($row = mysqli_fetch_assoc($result)) 
		{
			 $app_info[$i] = array("id" => $row["id"],"Doctor_name" => $row["name"], "distance" => $row["distance"], "latitude" => $row["latitude"], "longitude" => $row["longitude"]); 
			
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;

	}
	function nearbyhostel($origLat,$origLon)
	{	
		global $link;
		$i = 0;
		$dist = 3; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
		$query = "SELECT id,name, latitude, longitude, 3956 * 2 * 
		ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
		+COS($origLat*pi()/180 )*COS(latitude*pi()/180)
		*POWER(SIN(($origLon-longitude)*pi()/180/2),2))) 
		as distance FROM app_users WHERE 
		longitude between ($origLon-$dist/cos(radians($origLat))*69) 
		and ($origLon+$dist/cos(radians($origLat))*69) 
		and latitude between ($origLat-($dist/69)) 
		and ($origLat+($dist/69)) 
		having distance < $dist ORDER BY distance limit 100"; 
		$result = mysqli_query($link,$query) or die(mysql_error());
		while($row = mysqli_fetch_assoc($result)) 
		{
			 $app_info[$i] = array("ID" => $row["id"],"Doctor_name" => $row["name"], "distance" => $row["distance"], "latitude" => $row["latitude"], "longitude" => $row["longitude"]); 
			
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;

	}
	function nearbyadaption($origLat,$origLon)
	{	
		global $link;
		$i = 0;
		$dist = 3; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
		$query = "SELECT id,name, latitude, longitude, 3956 * 2 * 
		ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
		+COS($origLat*pi()/180 )*COS(latitude*pi()/180)
		*POWER(SIN(($origLon-longitude)*pi()/180/2),2))) 
		as distance FROM app_users WHERE 
		longitude between ($origLon-$dist/cos(radians($origLat))*69) 
		and ($origLon+$dist/cos(radians($origLat))*69) 
		and latitude between ($origLat-($dist/69)) 
		and ($origLat+($dist/69)) 
		having distance < $dist ORDER BY distance limit 100"; 
		$result = mysqli_query($link,$query) or die(mysql_error());
		while($row = mysqli_fetch_assoc($result)) 
		{
			 $app_info[$i] = array("ID" => $row["id"], "Doctor_name" => $row["name"], "distance" => $row["distance"], "latitude" => $row["latitude"], "longitude" => $row["longitude"]); 
			
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;

	}
	function nearbyambulance($origLat,$origLon)
	{	
		global $link;
		$i = 0;
		$dist = 3; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
		$query = "SELECT id,name, latitude, longitude, 3956 * 2 * 
		ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
		+COS($origLat*pi()/180 )*COS(latitude*pi()/180)
		*POWER(SIN(($origLon-longitude)*pi()/180/2),2))) 
		as distance FROM app_users WHERE 
		longitude between ($origLon-$dist/cos(radians($origLat))*69) 
		and ($origLon+$dist/cos(radians($origLat))*69) 
		and latitude between ($origLat-($dist/69)) 
		and ($origLat+($dist/69)) 
		having distance < $dist ORDER BY distance limit 100"; 
		$result = mysqli_query($link,$query) or die(mysql_error());
		while($row = mysqli_fetch_assoc($result)) 
		{
			 $app_info[$i] = array("ID" => $row["id"],"Doctor_name" => $row["name"], "distance" => $row["distance"], "latitude" => $row["latitude"], "longitude" => $row["longitude"]); 
			
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;

	}
	function nearbyday($origLat,$origLon)
	{	
		global $link;
		$i = 0;
		$dist = 3; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
		$query = "SELECT id,name, latitude, longitude, 3956 * 2 * 
		ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
		+COS($origLat*pi()/180 )*COS(latitude*pi()/180)
		*POWER(SIN(($origLon-longitude)*pi()/180/2),2))) 
		as distance FROM app_users WHERE 
		longitude between ($origLon-$dist/cos(radians($origLat))*69) 
		and ($origLon+$dist/cos(radians($origLat))*69) 
		and latitude between ($origLat-($dist/69)) 
		and ($origLat+($dist/69)) 
		having distance < $dist ORDER BY distance limit 100"; 
		$result = mysqli_query($link,$query) or die(mysql_error());
		while($row = mysqli_fetch_assoc($result)) 
		{
			 $app_info[$i] = array("id" => $row["id"],"Doctor_name" => $row["name"], "distance" => $row["distance"], "latitude" => $row["latitude"], "longitude" => $row["longitude"]); 
			
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;

	}
	function nearbygrooming($origLat,$origLon)
	{	
		global $link;
		$i = 0;
		$dist = 3; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
		$query = "SELECT id,name, latitude, longitude, 3956 * 2 * 
		ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
		+COS($origLat*pi()/180 )*COS(latitude*pi()/180)
		*POWER(SIN(($origLon-longitude)*pi()/180/2),2))) 
		as distance FROM app_users WHERE 
		longitude between ($origLon-$dist/cos(radians($origLat))*69) 
		and ($origLon+$dist/cos(radians($origLat))*69) 
		and latitude between ($origLat-($dist/69)) 
		and ($origLat+($dist/69)) 
		having distance < $dist ORDER BY distance limit 100"; 
		$result = mysqli_query($link,$query) or die(mysql_error());
		while($row = mysqli_fetch_assoc($result)) 
		{
			 $app_info[$i] = array("ID" => $row["id"],"Doctor_name" => $row["name"], "distance" => $row["distance"], "latitude" => $row["latitude"], "longitude" => $row["longitude"]); 
			
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;

	}

	function get_emergency_details($id)
	{	
		global $link;
		$sql = "select id,emergency_title,emergency_description from tbl_emergency where id = '".$id."'";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) > 0)	
		{		
			while($row = mysqli_fetch_assoc($result)) 
			{
				//print_r (explode(" ",$row["emergency_description"],3));
				$returnarr = array("success" => 1, "error" => 0,"emergency_title" => $row["emergency_title"],"emergency_description" => $row["emergency_description"]);
			}
		}
		else
			$returnarr = array("success" => 0, "error" => 1);

		return $returnarr;
	}
	function get_tips($tip_for)
	{		
		global $link;
		$i = 0;	
		$sql = "select id,tip_for,main_title from tbl_tips_master where tip_for = '".$tip_for."' ";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$j = 0;
			$app_info[$i] = array("main_title" => $row["main_title"]);
			$sql_question = "select tip_id,question,answer from tbl_tips where tip_matser_id = '".$row['id']."' ";
			$result_question = mysqli_query($link,$sql_question);
			while($row_question = mysqli_fetch_array($result_question))
			{
				//$ans= substr($row_question["answer"],0,25);
				$app_info[$i][$j] = array("tip_id" => $row_question["tip_id"],"question" => $row_question["question"], "answer" =>$row_question["answer"]);
				$j++;
			}		
			$i++;
		}
		$app_list = array("success" => 1,"result" =>$app_info);
		return $app_list;
	}
	function get_tips_description($tip_id)
	{
		global $link;
		$i = 0;
		$sql = "select tip_id,answer,tip_matser_id from tbl_tips where tip_id = '".$tip_id."'";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$sql_main = "select main_title from tbl_tips_master where id = '".$row['tip_matser_id']."'";	
			$result_main = mysqli_query($link,$sql_main);
			$row_main = mysqli_fetch_array($result_main);
			$app_info[$i] = array("main_title" => $row_main["main_title"], "answer" =>$row["answer"]);
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
	}
	function get_emergency($emergency_for)
	{		
		global $link;
		$i = 0;
		$sql = "select id,emergency_title from tbl_emergency WHERE emergency_for = '".$emergency_for."'";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("id" => $row["id"], "emergency_title" => $row["emergency_title"]);
			$i++;
		}
		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
	}

	function add_by_breed($search, $user_id)
	{		
		global $link;
		$i = 0;
		$sql = "SELECT a.name,p.breed, a.image, a.id FROM `pet_master` as p, app_users as a WHERE p.user_id = a.id and p.`breed` like '%".$search."%'";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$sql_frd = "SELECT * FROM `tbl_friends` WHERE user_id ='".$user_id."' AND `friend_id` ='".$row['id']."'";
			$result_frd = mysqli_query($link,$sql_frd);
			if(mysqli_num_rows($result_frd) != 0)
			{
				continue;
			}
			else
			{
				 $sql_frd_req = "SELECT * FROM tbl_notification WHERE user_id ='".$user_id."' AND who_id='".$row['id']."'";
				$result_frd_req = mysqli_query($link,$sql_frd_req);
				if(mysqli_num_rows($result_frd_req) != 0)
				{
				$app_info[$i] = array("id" => $row["id"],"username" => $row["name"],"breed" => $row["breed"] ,"image" => $row["image"],"request"=>1);
				$i++;
				}
				else
				{
			$app_info[$i] = array("id" => $row["id"],"username" => $row["name"],"breed" => $row["breed"] ,"image" => $row["image"],"request"=>0);
			$i++;
		}
			}
		}
		if (empty($app_info)) 
		{
			$app_list = array("success" => 0, "error" => "no records found");
			return $app_list;	
		}

		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
	}

	function add_by_username($search , $user_id)
	{		
		global $link;
		$i = 0;
		$sql = "SELECT a.name, a.image, a.id FROM app_users as a WHERE a.`name` like '%".$search."%' and id <> '".$user_id."' and is_active = '1' order by name ";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result)) 
		{
			$sql_frd = "SELECT * FROM `tbl_friends` WHERE user_id ='".$user_id."' AND `friend_id` ='".$row['id']."'";
			$result_frd = mysqli_query($link,$sql_frd);
			if(mysqli_num_rows($result_frd) != 0)
			{
				continue;
			}
			else
			{
				$sql_frd_req = "SELECT * FROM `tbl_notification` WHERE user_id ='".$user_id."' AND who_id='".$row['id']."'";
				$result_frd_req = mysqli_query($link,$sql_frd_req);
				if(mysqli_num_rows($result_frd_req) != 0)
				{
				$app_info[$i] = array("id" => $row["id"],"username" => $row["name"],"image" => $row["image"],"request"=>1);
				$i++;
				}
				else
				{
					$app_info[$i] = array("id" => $row["id"],"username" => $row["name"], "image" => $row["image"],"request"=>0);
					$i++;
				}
			}
		}
		if (empty($app_info)) 
		{
			$app_list = array("success" => 0, "error" => "no records found");
			return $app_list;	
		}

		$app_list = array("success" => 1,"result" => $app_info);
		return $app_list;
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
	 
		
	 //This api will return results of all vaccination types, durations and due date and given date records for given pet.
	/*  function vaccination_list($pet_id, $user_id)
	 {	
		global $link;
		$i = 0;
		$app_user = array();
		// Select pet type and birthdate from table
		$sql_user_birth = "select pet_type, birthdate from pet_master where id = '".$pet_id."' and user_id ='".$user_id."'";
		$result_user_birth = mysqli_query($link,$sql_user_birth);
		$row_user_birth = mysqli_fetch_array($result_user_birth);
		$pet_type = $row_user_birth["pet_type"];
		$birthdate = $row_user_birth["birthdate"];
		//Select all vaccination types, durations, duration titles from table for given pet type.
		$sql_user = "select id, duration_title, duration from tbl_vaccination_master where pet_type = '".$pet_type."'";
		$result_user = mysqli_query($link,$sql_user);
		while($row_user = mysqli_fetch_array($result_user))
		{
			$duration = $row_user["duration"];		
			$duration_title = $row_user["duration_title"];
			$vaccination_id = $row_user["id"];
			//Select vaccination records for given pet
			$sql_user1 = "select due_date, given_date, id from tbl_pet_vaccination where pet_id = '".$pet_id."' and vaccination_id = '".$vaccination_id."'";
			$result_user1 = mysqli_query($link,$sql_user1);
			//if no vaccination records found for this pet, we have to insert due dates of vaccination for this pet.
			if(mysqli_num_rows($result_user1) == 0)
			{
				// Here we are adding duration to the birth date of pet so all vaccination dates can be set.
				$due_date = strtotime("+".$duration." months", strtotime($birthdate));
				$due_date = date("Y-m-d",$due_date);
				
				// Insert vaccination due dates here
				$insert = "insert into tbl_pet_vaccination (pet_id, vaccination_id, due_date) values ('".$pet_id."', '".$vaccination_id."', '".$due_date."')";
				mysqli_query($link,$insert);
				
				//We are finding difference between due date of specific vaccination and current date
				$due_datenew = new DateTime($due_date);
				$current_date = new DateTime(date("Y-m-d"));
				$interval = $current_date->diff($due_datenew);
				$interval = $interval->format('%R%a');
				//If due date is not yet reached, we will return due date , no given date and orange color to show due date is not yet crossed but vaccination not yet given.
				if($interval >= 0)
					$app_user[$i] = array("vaccination_id"=>$vaccination_id,"duration_title" => $duration_title, "given_date" => "", "due_date" => $due_date, "row_color" => "orange");
				else // We will return red color because due date is crossed.
					$app_user[$i] = array("vaccination_id"=>$vaccination_id,"duration_title" => $duration_title, "given_date" => "", "due_date" => $due_date, "row_color" => "red");
			}
			else // If vaccination record already exists
			{
				$row_user1 = mysqli_fetch_array($result_user1);
				$pet_vaccination_id = $row_user1["id"];
				$due_date = $row_user1["due_date"];
				$given_date = $row_user1["given_date"];
				// If for some reason, due date is empty, we have to set it
				if($due_date == "0000-00-00")
				{
					// Here we are adding duration to the birth date of pet so all vaccination dates can be set.
					$due_date = strtotime("+".$duration." months", strtotime($birthdate));
					$due_date = date("Y-m-d",$due_date);
					// Set due date
					$update = "update tbl_pet_vaccination set due_date = '".$due_date."' where id = '".$pet_vaccination_id."'";
					mysqli_query($link,$update);
				}
				
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
	 } */
	 function doses_list($vaccination_id,$pet_id)
	{	
		global $link;
		$i = 0; 	
		$j = 0; 	
		$sql_weight = "select weight from tbl_pet_vaccination where vaccination_id = '".$vaccination_id."' and pet_id = '".$pet_id."'";
		$result_weight = mysqli_query($link,$sql_weight);
		$row_weight = mysqli_fetch_array($result_weight);		
		
		$sql= "select d.id ,d.title ,d.sub_title,v.duration_title FROM tbl_doses_master as d , tbl_vaccination_master as v where d.vaccination_id = '".$vaccination_id."' and v.id ='".$vaccination_id."'";
		$sql_given_date= "SELECT DATE_FORMAT(given_date,'%d %M %y') as given_date FROM tbl_pet_doses WHERE vaccination_id = '".$vaccination_id."'ORDER BY given_date DESC LIMIT 1 ";

		 $sql_due_date= "select DATE_FORMAT(due_date,'%d %M %y') as due_date,DATE_FORMAT(given_date,'%d %M %y') as given_date FROM tbl_pet_vaccination where vaccination_id = '".$vaccination_id."' and pet_id = '".$pet_id."'";
		$sql_already_insert = "select due_date , given_date FROM tbl_pet_doses where vaccination_id = '".$vaccination_id."' and pet_id = '".$pet_id."'";
		
		$result = mysqli_query($link,$sql);
		$result_due_date = mysqli_query($link,$sql_due_date);
		$result_given_date = mysqli_query($link,$sql_given_date);
		$result_already_insert = mysqli_query($link,$sql_already_insert);
		$row_due_date = mysqli_fetch_array($result_due_date);
		$row_given_date = mysqli_fetch_array($result_given_date);
		$given_date = $row_given_date["given_date"];
		$sql_vaccination_given_update = "UPDATE tbl_pet_vaccination SET given_date = '".$given_date."' WHERE vaccination_id = '".$vaccination_id."'and pet_id = '".$pet_id."' ";
		 $result_vaccination_given_update = mysqli_query($link,$sql_vaccination_given_update);
		$row_already_insert = mysqli_fetch_array($result_already_insert);
		$due_date=$row_already_insert["due_date"];

			while($row = mysqli_fetch_array($result))
			{			
				if(mysqli_num_rows($result_already_insert) == 0)
				{
					$insert = "insert into tbl_pet_doses (pet_id, vaccination_id,doses_id, due_date) values ('".$pet_id."', '".$vaccination_id."', '".$row["id"]."', '".$row_due_date["due_date"]."')";
					mysqli_query($link,$insert);
					$app_info[$i] = array("doses_id"=>$row["id"],"duration_title" => $row["duration_title"],"title" => $row["title"],"sub_title" => $row["sub_title"],"due_date" => $row_due_date["due_date"]);
				}
				else
				{
					$sql_given= "SELECT given_date FROM tbl_pet_doses WHERE vaccination_id = '".$vaccination_id."' and doses_id = '".$row['id']."'";				
					
											
					$result_given = mysqli_query($link,$sql_given);
					while($row_given = mysqli_fetch_array($result_given))
					{
						if($row_given["given_date"] =="0000-00-00")
						{
							$due_datenew = new DateTime($due_date);
							$current_date = new DateTime(date("Y-m-d"));
							$interval = $current_date->diff($due_datenew);
							$interval = $interval->format('%R%a');
							//If due date is not yet reached, we will return due date , no given date and orange color to show due date is not yet crossed but vaccination not yet given.
							if($interval >= 0)
								$app_info[$i] = array("doses_id"=>$row["id"],"duration_title" => $row["duration_title"],"title" => $row["title"],"sub_title" => $row["sub_title"],"due_date" => $row_due_date["due_date"],"flag"=>"0","color"=>"orange");
							else
								$app_info[$i] = array("doses_id"=>$row["id"],"duration_title" => $row["duration_title"],"title" => $row["title"],"sub_title" => $row["sub_title"],"due_date" => $row_due_date["due_date"],"flag"=>"0","color"=>"red");
						}
						else
						{
							$app_info[$i] = array("doses_id"=>$row["id"],"duration_title" => $row["duration_title"],"title" => $row["title"],"sub_title" => $row["sub_title"],"flag"=>"1","given_date"=>$given_date,"color"=>"green");
						}
					$j++;
						
					}		
					
				}
				
				$i++;
			}
		$sql_last_visit = "SELECT given_date FROM tbl_pet_doses WHERE pet_id='".$pet_id."'and vaccination_id='".$vaccination_id."' order by given_date desc LIMIT 1";
		$result_last_visit = mysqli_query($link,$sql_last_visit);
		$row_last_visit = mysqli_fetch_array($result_last_visit);
			
					
		if (empty($app_info)) 
		{
			$app_list = array("success" => "0", "error" => "no records found");
			
		}
		else
		{
			if($row_last_visit["given_date"]=="0000-00-00")
			{
				$sql_birth = "SELECT birthdate FROM pet_master WHERE id = '".$pet_id."'";
				$result_birth = mysqli_query($link,$sql_birth);
				$row_birth = mysqli_fetch_array($result_birth);
				$app_list = array("success" => 1,"result" => $app_info,"weight" => $row_weight["weight"],"last visit"=>$row_birth["birthdate"],"recommended date"=> $row_due_date["due_date"]);
			//return $app_list;
			}
			else
			{
				$app_list = array("success" => 1,"result" => $app_info,"weight" => $row_weight["weight"],"last visit"=>$row_last_visit["given_date"],"recommended date"=> $row_due_date["due_date"]);
			}
		}
		return $app_list;	
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
	function doses_list_ios($pet_id,$vaccination_id,$given_date)
	{
		global $link;
		//$date = date('Y-m-d');
		$sql="INSERT INTO tbl_pet_doses(pet_id,vaccination_id,given_date) VALUES('".$pet_id."','".$vaccination_id."','".$given_date."')";
		$result = mysqli_query($link,$sql);
		$id = mysqli_insert_id($link);
		
		if($_SERVER['REQUEST_METHOD']=='POST')
		{	
			$temp_name = $_FILES['myFile']['tmp_name'];
			$imagename = $id.".png";
			
			$path = "uploads/dose/$imagename";		
			$img = "http://www.discovermypet.in/pet/$path";			
			
			move_uploaded_file($temp_name, $path);		

			$sql_update="UPDATE tbl_pet_doses SET doses_img = '".$img."' WHERE id='".$id."' ";
			$result_update = mysqli_query($link,$sql_update);
		}
		if(mysql_error() == "")		
		$returnarr = array("success" => 1, "error" => 0);
		else
		$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;	
	}
	function doses_list_ios_name($vaccination_id,$pet_id,$doses_name,$given_date)
	{
		global $link;
			
		$sql="INSERT INTO tbl_pet_doses(pet_id,vaccination_id,doses_name,given_date) VALUES('".$pet_id."','".$vaccination_id."','".$doses_name."','".$given_date."')";
		$result = mysqli_query($link,$sql);
		$id = mysqli_insert_id($link);	
		
		if (!empty($_FILES["myfile"]["tmp_name"])) 	
		{
			$imagename = $id.".png";
			
			$path = "uploads/dose/$imagename";		
			$img = "http://www.discovermypet.in/pet/$path";			
			
			move_uploaded_file($temp_name, $path);		

			$sql_update="UPDATE tbl_pet_doses SET doses_img = '".$img."' WHERE id='".$id."' ";
			$result_update = mysqli_query($link,$sql_update);
		}
		
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
		$sql_given = "SELECT id,DATE_FORMAT(given_date,'%d %M %Y') as given_date FROM tbl_pet_vaccination WHERE pet_id = '".$pet_id."' order by given_date desc LIMIT 1 ";
		$result_given = mysqli_query($link,$sql_given);
		$row_given = mysqli_fetch_array($result_given);
		$given_date = $row_given["given_date"];
			
		 $vaccination_id = $vaccination_id + 1;
				
		 $sql_next = "SELECT DATE_FORMAT(due_date,'%d %M %Y') as due_date FROM tbl_pet_vaccination WHERE vaccination_id = '".$vaccination_id."' and pet_id ='".$pet_id."'";
			$result_next = mysqli_query($link,$sql_next);
			$row_next = mysqli_fetch_array($result_next);
			$next_date = $row_next['due_date'];
		if(mysqli_num_rows($result) > 0)
		{		
			while($row = mysqli_fetch_array($result))
			{
				$app_info[$i] = array("dose_id" =>$row["id"],"doses_img" =>$row["doses_img"],"doses_name" =>$row["doses_name"],"given_date" =>$row["given_date"],"given_date" =>$row["given_date"]);
				$i++;			
			}
			if($given_date=="0000-00-00")
			{
			$app_list = array("success" => "1","result" => $app_info,"duration_title"=>$row_vaccination["duration_title"],"weight"=>$row_weight["weight"],"last_visit"=>$given_date,"recommended date"=> "","next_date"=>"");
			}
			else
			{
				if($row_weight["due_date"]==null)
				{
					$app_list = array("success" => "1","result" => $app_info,"duration_title"=>$row_vaccination["duration_title"],"weight"=>$row_weight["weight"],"last_visit"=>"","recommended date"=> "","next_date"=>"");	
				}
				else
				{
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
	function delete_dose($dose_id)
	{
		global $link;
		$sql = "DELETE FROM tbl_pet_doses WHERE id = '".$dose_id."'";
		$result = mysqli_query($link,$sql);
		if(mysql_error() =="")
			$returnarr = array("success" => "1","error" => "0");
		else
			$returnarr = array("success" => "0","error" => "1");
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
	function get_doses_list($vaccination_id,$pet_id,$doses_id)
	{		
		global $link;
		$i = 0;
		$j = 0;
		$app_info_faq = array();	
		$sql = "select id,title,sub_title,description from tbl_doses_master where vaccination_id = '".$vaccination_id."' and id = '".$doses_id."'";
		$sql_due_date = "select due_date , given_date from tbl_pet_doses where vaccination_id = '".$vaccination_id."' and doses_id = '".$doses_id."' and pet_id = '".$pet_id."'"; 
		
		$result = mysqli_query($link,$sql);
		
		$result_due_date = mysqli_query($link,$sql_due_date);
		$row_due_date = mysqli_fetch_array($result_due_date);
		$due_date = $row_due_date["due_date"];
		$given_date = $row_due_date["given_date"];

		while($row = mysqli_fetch_array($result))
		{
			if($given_date=="0000-00-00")
			{
				$app_info[$i] = array("doses_id" => $row["id"],"title" => $row["title"],"sub_title" => $row["sub_title"],"description" => $row["description"],"due_date" =>$due_date);
				$i++;			
			}
			else
			{
				$app_info[$i] = array("doses_id" => $row["id"],"title" => $row["title"],"sub_title" => $row["sub_title"],"description" => $row["description"],"given_date" =>$given_date);
				$i++;		
			}	
			$sql_faq = "select question,answer from tbl_doses_faq where vaccination_id = '".$vaccination_id."'";
			$result_faq = mysqli_query($link,$sql_faq);
			while($row_faq = mysqli_fetch_array($result_faq))
			{
				$app_info_faq[$j] = array("question" => $row_faq["question"],"answer" => $row_faq["answer"]);
				$j++;
			}
		}
		if (empty($app_info_faq) and empty($app_info) ) 
		{
			$app_list = array("success" => 1,"result" => "no records found","faq"=>"no records found");
		}
		else
		{
			$app_list = array("success" => 1,"result" => $app_info,"faq"=>$app_info_faq);
		}	
		return $app_list;
	}
	function edit_dose_date($vaccination_id,$pet_id,$doses_id,$given_date)
	{	
		global $link;
		$sql = "UPDATE tbl_pet_doses SET given_date = '".$given_date."',due_date = '0000-00-00' WHERE vaccination_id = '".$vaccination_id."' and pet_id = '".$pet_id."' and doses_id = '".$doses_id."'";
		$result = mysqli_query($link,$sql);
		
		$sql_vaccination = "UPDATE tbl_pet_vaccination SET given_date = '".$given_date."',due_date = '0000-00-00' WHERE vaccination_id = '".$vaccination_id."' and pet_id = '".$pet_id."'";
		$result_vaccination = mysqli_query($link,$sql_vaccination);
		if(mysql_error() == "")		
			$returnarr = array("success" => 1, "error" => "0");
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
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
	function pride_wall_ios($user_id)
	{
		global $link;
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$month =  date('M');
			$year =  date('Y');
			
			$temp_name = $_FILES['myFile']['tmp_name'];
			$imagename = $user_id."_".$month."_".$year.".png";
			//$imagename = $user_id.".png";
			$path = "uploads/pride_wall/$imagename";	
			move_uploaded_file($temp_name, $path);
			$img = "http://www.discovermypet.in/pet/$path";	

			$sql_already_insert = "select * from tbl_social_profile where user_id = '".$user_id."'";
			$result_already_insert = mysqli_query($link,$sql_already_insert);
			if(mysqli_num_rows($result_already_insert) == 0)
			{			 
				$insert = "insert into tbl_social_profile (pride_wall_img, user_id,date_created) values ('".$img."', '".$user_id."','".date('Y-m-d H:i:s')."')";
				mysqli_query($link,$insert);

				if(mysql_error() == "")		
					$returnarr = array("success" => 1, "error" => "0");
				else
					$returnarr = array("success" => 0, "error" => mysql_error());
			}
			else
			{
				$sql = "UPDATE tbl_social_profile SET pride_wall_img = '".$img."' WHERE user_id = '".$user_id."'";
				$result = mysqli_query($link,$sql);
				if(mysql_error() == "")		
					$returnarr = array("success" => 1, "error" => "0");
				else
					$returnarr = array("success" => 0, "error" => mysql_error());		
			}
		}
		return $returnarr;
	}
	function pride_wall_android($user_id,$image)  
	{		
		global $link;
		if($_SERVER['REQUEST_METHOD']=='POST')
		{		
			$imagename = $user_id.".png";
			$path = "uploads/pride_wall/$imagename";		
			$img = "http://www.discovermypet.in/pet/$path";		
			file_put_contents($path,base64_decode($image));	
			
			$sql_already_insert = "select * from tbl_social_profile where user_id = '".$user_id."'";
			$result_already_insert = mysqli_query($link,$sql_already_insert);
			if(mysqli_num_rows($result_already_insert) == 0)
			{			 
				$insert = "insert into tbl_social_profile (pride_wall_img, user_id,date_created) values ('".$img."', '".$user_id."','".date('Y-m-d H:i:s')."')";
				mysqli_query($link,$insert);

				if(mysql_error() == "")		
					$returnarr = array("success" => 1, "error" => "0");
				else
					$returnarr = array("success" => 0, "error" => mysql_error());
			}
			else
			{
				$sql = "UPDATE tbl_social_profile SET pride_wall_img = '".$img."' WHERE user_id = '".$user_id."'";
				$result = mysqli_query($link,$sql);
				if(mysql_error() == "")		
					$returnarr = array("success" => 1, "error" => "0");
				else
					$returnarr = array("success" => 0, "error" => mysql_error());		
			}
		}
		return $returnarr;
	}
	function post_social_profile_status($user_id,$status)
	{		
		global $link;
		$sql = "UPDATE app_users SET status = '".$status."' WHERE id = '".$user_id."'";
		$result = mysqli_query($link,$sql);
			if(mysql_error() == "")		
				$returnarr = array("success" => 1, "error" => "0");
			else
				$returnarr = array("success" => 0, "error" => mysql_error());		
		
		return $returnarr;

	}
	function post_social_profile_name($user_id,$user_name)
	{	
		global $link;
		$sql = "UPDATE app_users SET name = '".$user_name."' WHERE id = '".$user_id."'";
		$result = mysqli_query($link,$sql);
			if(mysql_error() == "")		
				$returnarr = array("success" => 1, "error" => "0");
			else
				$returnarr = array("success" => 0, "error" => mysql_error());		
		
		return $returnarr;
	}

	function post_social_profile_image_android($user_id,$image)  
	{		
		global $link;
		if($_SERVER['REQUEST_METHOD']=='POST')
		{	
			if($image !="null")
			{
				$imagename = $user_id.".png";
				$path = "uploads/socialprofile/$imagename";		
				$img = "http://www.discovermypet.in/pet/$path";		
				file_put_contents($path,base64_decode($image));	
				
				$im = new Imagick($img);
				$im->scaleImage(500,0);
				$im->writeImage($path);
				
				
				$path_thub = "uploads/socialprofile/thub/$imagename";
				$image_thub = "http://www.discovermypet.in/pet/$path_thub";			
				file_put_contents($path_thub,base64_decode($image)); 		
			
				$im = new Imagick($image_thub);
				$im->scaleImage(300,0);
				$im->writeImage($path_thub); 
				
				$sql_user="UPDATE app_users SET image = '".$img."' WHERE id = '".$user_id."' ";
				$result_user = mysqli_query($link,$sql_user);
			}
			else
			{
				$sql_user="UPDATE app_users SET image ='http://www.discovermypet.in/pet/uploads/socialprofile/default-user-image.png' WHERE id = '".$user_id."' ";
				$result_user = mysqli_query($link,$sql_user);
			}
			
				
			if(mysql_error() == "")		
			{
				$returnarr = array("success" => 1, "error" => "0");
			}		
			else
				$returnarr = array("success" => 0, "error" => mysql_error());		
		}
		return $returnarr;
	}
	function post_social_profile_image_ios($user_id)  
	{		
		$date = date('d-m-y:H:m:s');
		global $link;
		$returnarr = array();
		if($_SERVER['REQUEST_METHOD']=='POST') 
		{	
			/* $sql_img = "SELECT image FROM app_users WHERE id='".$user_id."'";
			$result_img = mysqli_query($link,$sql_img);
			$row_img = mysqli_fetch_array($result_img);
			
			$path = $row_img["image"];	
			$pop = explode('/',$path);
			$first = array_pop($pop);
			
			$path1 ="uploads/socialprofile/".$first;

			if (file_exists($path1))
			{
				unlink($path1);
				//echo 'File '.$path1.' has been deleted';
			} 
			else
			{
				//echo 'Could not delete '.$path1.', file does not exist';
			} */
			$temp_name = $_FILES['myFile']['tmp_name'];	
			$imagename = $user_id."_".$date.".png";
			$path = "uploads/socialprofile/$imagename";	
			
			move_uploaded_file($temp_name, $path);
			$img = "http://www.discovermypet.in/pet/$path";	
			$sql = "UPDATE app_users SET image = '".$img."' WHERE id = '".$user_id."'";
			$result = mysqli_query($link,$sql);
				if(mysql_error() == "")		
					$returnarr = array("success" => 1, "error" => "0");
				else
					$returnarr = array("success" => 0, "error" => mysql_error());		
		}
		return $returnarr;
	}
	function get_social_profile($user_id)
	{	
		global $link;
		$sql = "SELECT id,name,status,image FROM app_users WHERE id='".$user_id."'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_array($result);
		$app_info[0] = array("user_id" => $row["id"],"name" => $row["name"],"status" => $row["status"],"image" => $row["image"]);
		$app_list = array("result" => $app_info);
		return $app_list;
			
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
	function walk_graph($pet_id)
	{	
		global $link;
		$j=0;	
			
		 $sql ="SELECT `km`,date_created,DATE_FORMAT( `date_created` , ' %a' ) AS day,SUM(`km`)FROM `tbl_dog_walk` WHERE `pet_id` = '".$pet_id."' and `date_created` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP BY `date_created` order by `date_created` desc ";
		$result = mysqli_query($link,$sql);
		for ($i=1; $i<7; $i++)
		{
			$a[$i] = array( date("Y-m-d", strtotime($i." days ago")));
		
			while($row = mysqli_fetch_array($result))
			{	
				/* print_r ($a[$i]);
				echo $row["date_created"] ;
				if($a[$i] == $row["date_created"])
				{
					
					$app_info[$j] = array("date" => $row["day"],"dat" => $row["date_created"],"km" => $row["SUM(`km`)"]);
					$j++;			
				}
				else
				{
					
					$app_info[$j] = array("date" => "0","dat" => "0");
					$j++;
				} */
				$app_info[$j] = array("date" => $row["day"],"dat" => $row["date_created"],"km" => $row["SUM(`km`)"]);
					$j++;	
			}
		}
		$sql_max ="SELECT id, MAX( km ) as max_walk FROM tbl_dog_walk WHERE `pet_id` = '".$pet_id."'  and `date_created` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
		$result_max = mysqli_query($link,$sql_max);
		$row_max = mysqli_fetch_array($result_max);
		
		$sql_min ="SELECT id, MIN( km ) as min_walk FROM tbl_dog_walk WHERE `pet_id` = '".$pet_id."' and `date_created` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
		$result_min = mysqli_query($link,$sql_min);
		$row_min = mysqli_fetch_array($result_min);
		if(empty($app_info))
		{
			$app_list = array("success" => 0, "error" => "no records found");
			return $app_list;
		}
		else
		{
			$app_list = array("success" => 1,"result" => $app_info ,"max_walk" =>$row_max["max_walk"],"min_walk" =>$row_min["min_walk"]);
			return $app_list;
		}
			
	}

	$possible_url = array("register","signin","post_likes","post_weight","dog_walk","get_dog_walk","upload_doc","get_pride_wall","pride_wall_ios","edit_dose_date","get_my_profile","my_profile","my_doctor","get_my_doctor","edit_my_doctor_ios","edit_my_doctor_andriod","doses_list","get_location","edit_my_info_all","post_dog_details_android","post_dog_details_ios","nearby","nearbyfrd","search_nearbyfrd","nearbysms","get_parasite_control","edit_parasite_control","add_dewormer","add_parasite_control","get_dewormer","edit_dewormer","select_pet","edit_my_info","get_my_info","get_tips_description","get_dog_details","get_timeline_comment","get_timeline","post_comment","get_faq_list","get_tips","get_doses_list","get_emergency","get_vaccination_list","get_emergency_details","add_allergy","add_surgery","add_note","add_diet","add_need","add_insurance","add_medical_details","add_appointment","add_owner","add_pet","edit_pet_type", "edit_pet_gender","list_allergy","list_surgery","list_note","list_diet","list_need","list_insurance","list_medical_details","list_appointment","list_owner","list_pet","list_pet_of_user","get_allergy","get_surgery","get_note","get_diet","get_need","get_insurance","get_medical_details","get_appointment","get_owner","get_pet","edit_allergy","delete_allergy","edit_surgery","edit_note","edit_diet","delete_diet","edit_need","edit_insurance","edit_medical_details","delete_medical_details","edit_appointment","edit_owner","edit_pet1","forget_pwd","pwd_save","edit_pet_food","edit_pet_birthdate","reset_pwd","latandlong","notes_list","add_timeline_ios","add_timeline_andriod", "send_verification_code","send_otp", "verify_registration", "vaccination_list","notification_history","notification_today","unlike","add_by_breed","add_by_username","add_friend","timeline_profile","get_timeline_img","most_like_order","adverstise","homescreen","user_timeline","post_social_profile_android","post_social_profile_ios","get_social_profile","nearbyhome","nearbygrooming","nearbyday","nearbyadaption","nearbyambulance","nearbyhostel","nearbyinsurance","nearby_str","weight_graph","walk_graph","send_request","frd_req_response","addressbook","healthrecord","service_details","get_package","add_to_cart","welcome","like_status", "welcome_image","view_cart","delete_package_cart","billing_details_wth_chckbox","billing_details_wthout_chckbox", "get_product_category_list","get_main_category_list", "get_product_list", "get_product_details","delete_pet","update_transaction_status","update_transaction_status_andriod","get_dewormer_brand","get_parasite_brand","get_billing_details","fb_register","get_tips_news","delete_comment","get_timeline_comment_new","delete_timeline_img","edit_comment","doses_list_andriod","get_doses_list_andriod","delete_dose","edit_dose","post_vacc_date","chng_pwd","doses_list_ios","emergency_call","get_specility","get_service_category","get_service_category_details","get_city","city_wise_service_master","get_rating","get_dr_list","get_drlist");

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
			case "welcome_image":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = welcome_image();
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
							if(empty($_POST["name"]) OR empty($_POST["email"]) OR empty($_POST["password"]) OR empty($_POST["latitude"])OR empty($_POST["longitude"]) )
							{
								$value = array("success" => 0, "error" => 1);
								break; 
							}
							$value = register($_POST["name"],$_POST["email"], $_POST["password"], $_POST["latitude"], $_POST["longitude"]);
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
						$value = fb_register($_POST["name"],$_POST["email"], $_POST["image"], $_POST["latitude"], $_POST["longitude"]);
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
							$value = verify_registration($_POST["mobile"],$_POST["email"],$_POST["code"]); 
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
			case "edit_pet_type":
			
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_pet_type($_POST["pet_type"],$_POST["pet_id"]);
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
			case "edit_pet_gender":
			
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_pet_gender($_POST["gender"],$_POST["pet_id"]);
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
			case "post_dog_details_ios":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{ 
							$value =  post_dog_details_ios($_POST["pet_id"],$_POST["user_id"],$_POST["pet_name"],$_POST["breed_name"],$_POST["allergy_name"]);
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
			case "add_surgery":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = add_surgery($_POST["surgery"]);
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
			case "add_note":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = add_note($_POST["note"]);
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
			case "add_need":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = add_need($_POST["need"]);
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
			case "add_insurance":
			$value = add_insurance($_POST["insurance"]);
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
			case "add_appointment":
			$value = add_appointment($_POST["name"],$_POST["date1"],$_POST["age"],$_POST["breed"],$_POST["identification"],$_POST["medical"],$_POST["pincode"]);
			break;
			case "add_owner":
			$value = add_owner($_POST["owner_name"],$_POST["city_area"],$_POST["email"],$_POST["phone"],$_POST["pincode"],$_POST["gender"]);
			break;		
			case "add_timeline_ios":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$post_text = "";
							$post_img = "";
							$post_video = "";
							$post_userid = ""; 
							if(empty($_POST["post_text"]) AND empty($_POST["user_id"]))
							{
								$value = array("success" => 0, "error" => 1);
								break; 
							}		 
							 if(isset($_POST["user_id"]))
							{
								$post_text = $_POST["post_text"];
								$post_userid = $_POST["user_id"];
								$value = add_timeline_video_ios($post_userid);
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
			case "add_timeline_andriod":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$post_text = "";
							$post_img = "";
							$post_video = "";
							$post_userid = ""; 
							if(empty($_POST["post_text"]) AND empty($_POST["post_img"]) AND empty($_POST["post_video"])AND empty($_POST["thumbnail"]) AND empty($_POST["user_id"]))
							{
								$value = array("success" => 0, "error" => 1);
								break; 
							}		 
													
							if(isset($_POST["post_img"]))
							{
								$post_img = $_POST["post_img"];
								$post_text = $_POST["post_text"];
								$post_userid = $_POST["user_id"];
								$value = add_timeline_img_andriod($post_img,$post_userid,$post_text);
							}	
							else 
							{
								$post_userid = $_POST["user_id"];
								//$post_text = $_POST["post_text"];
								$value = add_timeline_video_andriod($post_userid);
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
			case "post_social_profile_android":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$user_name = "";
							$status = "";		 
							if(empty($_POST["user_name"]) AND empty($_POST["status"]) AND empty($_POST["image"]))
							{
								//echo "please check image";  
								$value = array("success" => 0, "error" => 1);
								break; 
							}		 
							if(isset($_POST["user_id"]))
								$user_id = $_POST["user_id"];	
							if(isset($_POST["user_name"]))
							{
								$user_id = $_POST["user_id"];	
								$user_name = $_POST["user_name"];
								$value = post_social_profile_name($user_id,$user_name);
							}
							if(isset($_POST["status"]))
							{
								$user_id = $_POST["user_id"];	
								$status = $_POST["status"];	
								$value = post_social_profile_status($user_id,$status);
							}
							if(isset($_POST["image"]))
							{
								$user_id = $_POST["user_id"];	
								$image = $_POST["image"];
								$value = post_social_profile_image_android($user_id,$image);
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
			case "post_social_profile_ios":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$user_name = "";
							$status = "";		 
							if(empty($_POST["user_name"]) AND empty($_POST["status"]) AND empty($_POST["user_id"]))
							{
								//echo "please check image";  
								$value = array("success" => 0, "error" => 1);
								break; 
							}		 
							if(isset($_POST["user_id"]))
								$user_id = $_POST["user_id"];	
							if(isset($_POST["user_name"]))
							{
								$user_id = $_POST["user_id"];	
								$user_name = $_POST["user_name"];
								$value = post_social_profile_name($user_id,$user_name);
							}
							if(isset($_POST["status"]))
							{
								$user_id = $_POST["user_id"];	
								$status = $_POST["status"];	
								$value = post_social_profile_status($user_id,$status);
							}
							else
							{
								$user_id = $_POST["user_id"];	
								$value = post_social_profile_image_ios($user_id);
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
			case "list_allergy":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = list_allergy();
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
			case "list_surgery":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = list_surgery();
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
			case "list_note":
			$value = list_note();
			break;
			case "list_diet":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = list_diet();
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
			case "list_need":
			$value = list_need();
			break;
			case "list_insurance":
			$value = list_insurance();
			break;
			case "list_medical_details":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
								$value = list_medical_details();
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
			case "list_appointment":
			$value = list_appointment();
			break;
			case "list_owner":
			$value = list_owner();
			break;
			case "list_pet":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = list_pet();
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
			case "get_surgery":
			$value = get_surgery($_POST["id"]);
			break;
			case "get_note":
			$value = get_note($_POST["id"]);
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
			case "get_need":
			$value = get_need($_POST["id"]);
			break;
			case "get_insurance":
			$value = get_insurance($_POST["id"]);
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
			case "get_appointment":
			$value = get_appointment($_POST["id"]);
			break;
			case "get_owner":
			$value = get_owner($_POST["id"]);
			break;		
			case "edit_allergy":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_allergy($_POST["id"], $_POST["allergy"]);
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
			case "delete_allergy":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = delete_allergy($_POST["id"],$_POST["pet_id"]);
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
			case "edit_surgery":
			$value = edit_surgery($_POST["id"], $_POST["surgery"]);
			break;
			case "edit_note":
			$value = edit_note($_POST["id"], $_POST["note_name"]);
			break;
			case "edit_diet":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_diet($_POST["id"], $_POST["diet_name"]);
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
			case "delete_diet":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = delete_diet($_POST["id"],$_POST["pet_id"]);
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
			case "edit_need":
			$value = edit_need($_POST["id"], $_POST["need_name"]);
			break;
			case "edit_insurance":
			$value = edit_insurance($_POST["id"], $_POST["insurance_name"]);
			break;
			case "edit_medical_details":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_medical_details($_POST["id"], $_POST["title"]);
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
			case "delete_medical_details":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = delete_medical_details($_POST["id"],$_POST["pet_id"]);
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
			case "edit_appointment":
			$value = edit_appointment($_POST["id"], $_POST["appointment_name"], $_POST["date1"], $_POST["age"], $_POST["breed"], $_POST["identification"], $_POST["medical"], $_POST["pincode"]);
			break;
			case "edit_owner":
			$value = edit_owner($_POST["id"], $_POST["owner_name"], $_POST["city_area"], $_POST["email"], $_POST["phone"], $_POST["pincode"], $_POST["gender"]);
			break;
			case "forget_pwd":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = forget_pwd($_POST["email"]);
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
			case "reset_pwd":
			$value = reset_pwd($_POST["password"],$_POST["email"]); 
			break;
			case "latandlong":
			$value = latandlong($_POST["latitude"],$_POST["longitude"]); 
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
			case "nearbyfrd":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = nearbyfrd($_POST["latitude"],$_POST["longitude"],$_POST["user_id"]); 
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
			case "search_nearbyfrd":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = search_nearbyfrd($_POST["user_id"],$_POST["search"]); 
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
			case "nearbysms":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = nearbysms($_POST["latitude"],$_POST["longitude"],$_POST["user_id"],$_POST["service_name"]);
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
			case "nearbyhome":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = nearbyhome($_POST["latitude"],$_POST["longitude"]); 
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
			case "nearbygrooming":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = nearbygrooming($_POST["latitude"],$_POST["longitude"]);  
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
			case "nearbyday":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = nearbyday($_POST["latitude"],$_POST["longitude"]); 
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
			case "nearbyadaption":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = nearbyadaption($_POST["latitude"],$_POST["longitude"]); 
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
			case "nearbyambulance":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = nearbyambulance($_POST["latitude"],$_POST["longitude"]); 
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
			case "nearbyhostel":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = nearbyhostel($_POST["latitude"],$_POST["longitude"]); 
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
			case "nearbyinsurance":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = nearbyinsurance($_POST["latitude"],$_POST["longitude"]); 
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
			case "get_emergency_details":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
						$value = get_emergency_details($_POST["id"]); 
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
			case "get_emergency":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_emergency($_POST["emergency_for"]); 
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
			case "get_tips":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_tips($_POST["tip_for"]); 
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
			case "get_timeline":
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
			$value = get_timeline($_POST["id"]); 
			break;
			case "get_timeline_img":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_timeline_img($_POST["timeline_id"]); 
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
			case "get_timeline_comment":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_timeline_comment($_POST["timeline_id"]); 
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
			case "get_timeline_comment_new":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_timeline_comment_new($_POST["timeline_id"],$_POST["user_id"]); 
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
			case "delete_timeline_img":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = delete_timeline_img($_POST["timeline_id"]); 
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
			/* case "get_vaccination_list":
			$value = get_vaccination_list($_POST["pet_type"]); 
			break; */
			case "get_doses_list":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_doses_list($_POST["vaccination_id"],$_POST["pet_id"],$_POST["doses_id"]); 
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
			case "doses_list":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = doses_list($_POST["vaccination_id"],$_POST["pet_id"]); 
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
			case "doses_list_ios":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							if(empty($_POST["vaccination_id"]) AND empty($_POST["pet_id"]))
							{
								$value = array("success" => 0, "error" => 1);
								break; 
							}	
							 elseif(!empty($_POST["doses_name"]))
							{					
								$value = doses_list_ios_name($_POST["vaccination_id"],$_POST["pet_id"],$_POST["doses_name"],$_POST["given_date"]);
							}	 
							else
							{
								$vaccination_id = $_POST["vaccination_id"];
								$pet_id = $_POST["pet_id"];							
								$given_date = $_POST["given_date"];
								
								$value = doses_list_ios($pet_id,$vaccination_id,$given_date);
							}						
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
			case "delete_dose":
			if(!empty($_POST["key"]))
			{
				$key = $_POST["key"];
				$txt = Encrypt('myPass123', $key);
				if($txt)
				{			
					$value = delete_dose($_POST["dose_id"]); 
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
			case "get_faq_list":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_faq_list($_POST["vaccination_id"],$_POST["doses_id"],$_POST["id"]); 
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
			case "notes_list":
			
			$value = notes_list($_POST["note_title"],$_POST["note"],$_POST["date"]); 
			break;
			case "post_comment":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = post_comment($_POST["user_id"],$_POST["timeline_id"],$_POST["comment"],$_POST["friend_id"]); 
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
			case "get_tips_description":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_tips_description($_POST["tip_id"]); 
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
			case "get_location":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_location($_POST["user_id"],$_POST["latitude"],$_POST["longitude"]); 
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
			case "add_parasite_control":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value =add_parasite_control($_POST["received_dte"],$_POST["nxt_dte"],$_POST["pet_id"],$_POST["brand"]); 
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
			case "get_parasite_brand":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_parasite_brand(); 
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
			case "my_doctor":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = my_doctor($_POST["user_id"],$_POST["doctor_name"],$_POST["contact_no"],$_POST["dr_address"],$_POST["dr_clinic_name"],$_POST["dr_time"],$_POST["dr_time1"]);
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
			case "edit_my_doctor_ios":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_my_doctor_ios($_POST["user_id"],$_POST["doctor_name"],$_POST["contact_no"],$_POST["dr_address"],$_POST["dr_clinic_name"],$_POST["dr_time"],$_POST["dr_time1"],$_POST["dr_specification"],$_POST["dr_experience"],$_POST["dr_qulification"],$_POST["vci_reg_no"]);
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
			case "my_profile":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = my_profile($_POST["user_id"],$_POST["image"],$_POST["username"]);
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
			case "get_my_profile":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_my_profile($_POST["user_id"]);
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
			case "edit_dose_date":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_dose_date($_POST["vaccination_id"],$_POST["pet_id"],$_POST["doses_id"],$_POST["given_date"]);
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
			case "pride_wall_ios":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = pride_wall_ios($_POST["user_id"]); 
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
			case "get_pride_wall":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_pride_wall($_POST["user_id"]);
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
			case "upload_doc":
			$value = upload_doc($_POST["pet_id"]);
			break;
			case "dog_walk":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = dog_walk($_POST["pet_ids"],$_POST["km"],$_POST["time"]);
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
			case "get_dog_walk":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_dog_walk($_POST["pet_id"]);
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
			case "post_likes":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = post_likes($_POST["user_id"],$_POST["timeline_id"],$_POST["friend_id"]);
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
			case "unlike":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = unlike($_POST["user_id"],$_POST["timeline_id"],$_POST["friend_id"]);
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
			case "notification_history":
						if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = notification_history($_POST["user_id"]);
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
			case "notification_today":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = notification_today($_POST["user_id"],$_POST["timeline_id"]);
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
			case "add_by_breed":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = add_by_breed($_POST["search"],$_POST["user_id"]);
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
			case "add_by_username":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = add_by_username($_POST["search"],$_POST["user_id"]);
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
			case "add_friend":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = add_friend($_POST["user_id"],$_POST["friend_id"]);
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
			case "timeline_profile":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = timeline_profile($_POST["user_id"]);
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
			case "like_status":
			$value = like_status($_POST["user_id"]);
			break;
			case "most_like_order":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = most_like_order($_POST["user_id"]);		
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
			case "user_timeline":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = user_timeline($_POST["user_id"]);
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
			case "get_social_profile":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_social_profile($_POST["user_id"]);
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
			case "walk_graph":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = walk_graph($_POST["pet_id"]);
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
			case "send_request":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = send_request($_POST["user_id"],$_POST["to_user"]);
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
			case "frd_req_response":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = frd_req_response($_POST["user_id"] , $_POST["is_accept"], $_POST["friend_id"]);
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
			case "addressbook":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = addressbook($_POST["user_id"],$_POST["name"],$_POST["mobile"]);
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
			case "healthrecord":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = healthrecord();
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
			case "service_details":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = service_details($_POST["service_id"]);
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
			case "get_package":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_package($_POST["package_id"]);
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
			case "add_to_cart":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							if($_POST["action_type"]=="add")
							{	
								$value = add_to_cart($_POST["add_cart"],$_POST["user_id"]);						
							}
							elseif($_POST["action_type"]=="edit")
							{
								$value = edit_cart($_POST["OrderID"],$_POST["add_cart"],$_POST["user_id"]);
							}	
							else
							{
								$value = delete_cart($_POST["OrderID"]);
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
			case "view_cart":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = view_cart($_POST["user_id"]);
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
			case "delete_package_cart":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = delete_package_cart($_POST["user_id"],$_POST["package_id"]);
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
			case "billing_details_wth_chckbox":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = billing_details_wth_chckbox($_POST["user_id"],$_POST["fname"],$_POST["lname"],$_POST["email"],$_POST["address2"],$_POST["mobile"],$_POST["city"],$_POST["state"],$_POST["country"],$_POST["pincode"]);
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
			case "get_billing_details":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_billing_details($_POST["user_id"]);
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
			case "billing_details_wthout_chckbox":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = billing_details_wthout_chckbox($_POST["user_id"],$_POST["fname"],$_POST["lname"],$_POST["email"],$_POST["address2"],$_POST["mobile"],$_POST["city"],$_POST["state"],$_POST["country"],$_POST["pincode"],$_POST["d_fname"],$_POST["d_lname"],$_POST["d_mobile"],$_POST["d_address2"],$_POST["d_city"],$_POST["d_state"],$_POST["d_pincode"]);
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
			case "get_product_category_list":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$main_id = $_POST["cat_id"];							
							$value = get_product_category_list($main_id);
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
			case "get_main_category_list":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{					
							$value = get_main_category_list();
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
			case "get_product_list":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$cat_id = 0;
							if(isset($_POST["cat_id"]))
								$cat_id = $_POST["cat_id"];				
							$value = get_product_list($cat_id,$_POST["city"]);
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
			case "get_product_details":
					if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_product_details($_POST["product_id"]);
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
			case "update_transaction_status":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = update_transaction_status($_POST["order_id"],$_POST["status"]);
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
			case "update_transaction_status_andriod":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = update_transaction_status_andriod($_POST["order_id"],$_POST["status"],$_POST["str"]);
							
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
			case "get_tips_news":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_tips_news();
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
			case "delete_comment":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = delete_comment($_POST["comment_id"]);
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
			case "edit_comment":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_comment($_POST["comment_id"],$_POST["comment"]);
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
			case "emergency_call":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = emergency_call($_POST["user_id"]);
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
			case "get_service_category":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_service_category($_POST["user_id"]);
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
			case "get_city":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_city();
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
			case "city_wise_service_master":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = city_wise_service_master($_POST["city_id"]);
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
			case "get_service_category_details":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_service_category_details($_POST["cat_id"],$_POST["city_name"]);
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
			case "get_rating":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_rating($_POST["user_id"],$_POST["service_id"],$_POST["rating"]);
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