<?php 
	include('config/config.php');
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
	
	$possible_url = array("get_tips_news");

	$value = "An error has occurred";
	
	
	if (isset($_POST["action"]) && in_array($_POST["action"], $possible_url))
	{
		
		switch ($_POST["action"])
		{
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
		}
	}


	//return JSON array
	exit(json_encode($value));
	?>

	<!--localhost/offers/api.php?action=add_project_recordsimage= -->