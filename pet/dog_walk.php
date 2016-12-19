<?php 
	include('config/config.php');
	
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

	$possible_url = array("select_pet","dog_walk","walk_graph");

	$value = "An error has occurred";
	
	
	if (isset($_POST["action"]) && in_array($_POST["action"], $possible_url))
	{
		
		switch ($_POST["action"])
		{			
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
			
			
			
		}
	}


	//return JSON array
	exit(json_encode($value));
	?>

	<!--localhost/offers/api.php?action=add_project_recordsimage= -->