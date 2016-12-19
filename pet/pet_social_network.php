<?php 
	include_once('config/config.php');
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
	function nearbyfrd($origLat,$origLon,$user_id)
	{	
		global $link;
		$i = 0;
		$dist = 1000; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
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

	$possible_url = array("user_timeline","get_timeline_comment_new","post_likes","unlike","get_timeline_img","post_comment","most_like_order","search_nearbyfrd","nearbyfrd","send_request","add_by_username","add_by_breed");

	$value = "An error has occurred";
	
	
	if (isset($_POST["action"]) && in_array($_POST["action"], $possible_url))
	{
		
		switch ($_POST["action"])
		{ 
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
	}
	}


	//return JSON array
	exit(json_encode($value));
	?>

	<!--localhost/offers/api.php?action=add_project_recordsimage= -->