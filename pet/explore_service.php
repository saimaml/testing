<?php 
	include('config/config.php');
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
	function get_rating($user_id,$service_id,$rating)
	{		
		global $link;
		
		$sql_select = "SELECT id FROM tbl_rating WHERE user_id = '$user_id' and service_id = '$service_id' ";
		$result_select = mysqli_query($link,$sql_select);
		if(mysqli_num_rows($result_select) > 0)
		{
			$row_select = mysqli_fetch_array($result_select);
			$id = $row_select['id'];			
			$sql_update = "UPDATE tbl_rating SET rating = '$rating' WHERE id = '$id'";
			$result_update = mysqli_query($link,$sql_update);
			
		}
		else
		{
			
			$sql = "INSERT into tbl_rating(user_id,service_id,rating) values ('".$user_id."','".$service_id."','".$rating."')";
			$result = mysqli_query($link,$sql);	
			$id = mysqli_insert_id($link);	
		}
		
		if(mysql_error() == "")				
		
			$returnarr = array("success" => 1, "error" => 0,"id"=>$id);
		else
			$returnarr = array("success" => 0, "error" => mysql_error());		

		return $returnarr;
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
	function city_wise_service_master($city_id)
	{
		global $link;
		
		$sql_city_id = "SELECT city_name FROM tbl_city WHERE id = '".$city_id."'";
		$result_city_id = mysqli_query($link,$sql_city_id);
		$row_city_id = mysqli_fetch_array($result_city_id);
		
		//$sql = "SELECT id,service_master,service_img FROM tbl_service_master WHERE city_id = '".$city_id."'";
		$sql = "SELECT id,service_master,service_img FROM tbl_service_master WHERE id !='0' ";
		$result = mysqli_query($link,$sql);
		if(mysqli_num_rows($result) != 0)
		{	
			$i=0;
			while($row = mysqli_fetch_array($result))
			{
				$app_info[$i] = array("id" => $row["id"],"service_master" => $row["service_master"],"service_img" => $row["service_img"]);
				$i++;
			}	
			$app_list = array("success" => 1,"result" => $app_info,"current_city"=>$row_city_id["city_name"]);
		}
		else
			$app_list = array("success" => 0, "error" => 1);
			
		return $app_list;
		
	}

	$possible_url = array("get_service_category_details","get_service_category","get_rating","get_city","city_wise_service_master");

	$value = "An error has occurred";
	
	
	if (isset($_POST["action"]) && in_array($_POST["action"], $possible_url))
	{
		
		switch ($_POST["action"])
		{ 
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
		
	}
	}


	//return JSON array
	exit(json_encode($value));
	?>

	<!--localhost/offers/api.php?action=add_project_recordsimage= -->