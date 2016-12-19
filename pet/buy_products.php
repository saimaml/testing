<?php 
	include('config/config.php');
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
				
				if($row_main_cat["main_category"] == "Pet Food")
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
							$row_weight_nm = mysqli_fetch_array($result_weight_nm);
							
							$attributes[$a] = array("atr_id"=>$row_attribute["id"],"weight_name"=>$row_weight_nm["weight_range"],"size_name"=>$row_attribute["size_name"],"price"=>$row_attribute["price"],"img"=>$row_attribute["img"]);
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
					}
					else
					{
						$app_list = array("success" => 0, "error" => "no records found","charges"=>$app_charge,"service_tax"=>$row_tax["tax_rate"]);
						return $app_list;	
					}
				}
				else
				{
					$a=0;	
					$attributes = array();				
					$sql_attribute = "SELECT id,weight_id,size_name,price,img FROM tbl_product_attribute WHERE product_id = '".$row_product['prod_id']."'";
					$result_attribute = mysqli_query($link,$sql_attribute);				
					while($row_attribute = mysqli_fetch_array($result_attribute))
					{
						$sql_weight_nm = "SELECT weight_range FROM tbl_pet_weight WHERE id = '".$row_attribute['weight_id']."'";
						$result_weight_nm = mysqli_query($link,$sql_weight_nm);
						$row_weight_nm = mysqli_fetch_array($result_weight_nm);
						
						$attributes[$a] = array("atr_id"=>$row_attribute["id"],"weight_name"=>$row_weight_nm["weight_range"],"size_name"=>$row_attribute["size_name"],"price"=>$row_attribute["price"],"img"=>$row_attribute["img"]);
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
					$app_info[$i] = array("id"=>$row_product["prod_id"],"category_id"=>$row_product["category_id"],"category_name"=>$row_product["catogories_name"],"plan_name"=>$row_product["plan_name"],"description"=>$row_product["description"],"rate"=>$row_product["rate"],"original_price"=>$row_product["orignal_price"],"offer"=>$row_product["offer"],"image"=>$image,"color"=>$colors); 
					
					$app_info[$i]["attribute"] = $attributes;		
					$app_info[$i]["plan"] = $plans;												
					$i++;
				}
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
				//$result = mysqli_query($link,$sql);
				
					
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
	function get_address_billing($user_id)
	{
		global $link;
		$i=0;
		$sql = "SELECT * FROM tbl_user_address WHERE user_id = '$user_id'";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_array($result))
		{
			$app_info[$i] = array("id" => $row["id"],"fname" => $row["fname"],"lname" => $row["lname"],"email" => $row["email"],"address2" => $row["address2"],"mobile" => $row["mobile"],"city" => $row["city"],"state" => $row["state"],"country" => $row["country"],"pincode" => $row["pincode"]);
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
	function add_cod($user_id,$address_id,$order_id)
	{
		global $link;
		$sql = "UPDAET tbl_cart_master SET payment_status = 'c',address_id = '$address_id' where user_id = '$user_id' and order_id = '$order_id'";
		$result = mysqli_query($link,$sql);
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
	function add_user_address($user_id,$fname,$lname,$email,$address2,$mobile,$city,$state,$country,$pincode)
	{
		global $link;
		$sql = "INSERT INTO tbl_user_address(fname,lname,email,address2,mobile,city,state,country, pincode,user_id) VALUES ('$fname','$lname','$email','$address2','$mobile','$city','$state','$country','$pincode','$user_id')";
		$result = mysqli_query($link,$sql);
		//$id = mysqli_insert_id($result);
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
	function edit_user_address($id,$user_id,$fname,$lname,$email,$address2,$mobile,$city,$state,$country,$pincode)
	{
		global $link;
		$sql = "UPDATE tbl_user_address SET fname = '$fname',lname = '$lname',email = '$email',address2 = '$address2',mobile = '$mobile',city = '$city',state='$state',country= '$country',pincode='$pincode' WHERE id = '$id'";
		$result = mysqli_query($link,$sql);
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
	$possible_url = array("get_main_category_list","get_product_list","add_to_cart", "update_transaction_status_andriod","add_user_address","get_address_billing","edit_user_address","add_cod");

	$value = "An error has occurred";	
	
	if (isset($_POST["action"]) && in_array($_POST["action"], $possible_url))
	{
		
		switch ($_POST["action"])
		{
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
			case "get_address_billing":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = get_address_billing($_POST["user_id"]);
							
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
			case "add_user_address":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = add_user_address($_POST["user_id"],$_POST["fname"],$_POST["lname"],$_POST["email"],$_POST["address2"],$_POST["mobile"],$_POST["city"],$_POST["state"],$_POST["country"],$_POST["pincode"]);
							
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
			case "edit_user_address":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = edit_user_address($_POST["id"],$_POST["user_id"],$_POST["fname"],$_POST["lname"],$_POST["email"],$_POST["address2"],$_POST["mobile"],$_POST["city"],$_POST["state"],$_POST["country"],$_POST["pincode"]);
							
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
			case "add_cod":
				if(!empty($_POST["key"]))
					{
						$key = $_POST["key"];
						$txt = Encrypt('myPass123', $key);
						if($txt)
						{
							$value = add_cod($_POST["user_id"],$_POST["address_id"],$_POST["order_id"]);
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