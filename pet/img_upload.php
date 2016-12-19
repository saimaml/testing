<?php
include('config/config.php');
function add_timeline_video_ios($post_userid)
{	
	global $link;
	$returnarr = array();
	$post_userid;
	
	
		
			$image_file = $_FILES['myFile']['tmp_name'];			
			
				
			$imagename = "abc.png";


			
			$path_img = "http://dmpamz.s3-website.ap-south-1.amazonaws.com/images/$imagename";	
						
			if(file_put_contents($image_file, $path_img))
			{				
				$img = "$path_img";
				
			
			$sql_update="UPDATE tbl_timeline SET user_id = '".$post_userid."',post_img = '".$img."' WHERE id='".$timeline_id."' ";
			$result_update = mysqli_query($link,$sql_update);
				$returnarr = array("success" => 1, "error" => 0);	
				return $returnarr;
			}
			else
			{
				$returnarr = array("success" => 0, "error" => 1);	
				return $returnarr;
			}
}	

$possible_url = array("add_timeline_ios");

$value = "An error has occurred";


if (isset($_POST["action"]) && in_array($_POST["action"], $possible_url))
{
	
	switch ($_POST["action"])
	{
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
		
	}
}


//return JSON array
exit(json_encode($value));
?>

<!--localhost/offers/api.php?action=add_project_recordsimage= -->