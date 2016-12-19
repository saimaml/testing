<?php 
	include('config/config.php');
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
	
	
	$possible_url = array("view_cart");

	$value = "An error has occurred";
	
	
	if (isset($_POST["action"]) && in_array($_POST["action"], $possible_url))
	{		
		switch ($_POST["action"])
		{		
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
			
			
		}
	}


	//return JSON array
	exit(json_encode($value));
	?>

	<!--localhost/offers/api.php?action=add_project_recordsimage= -->