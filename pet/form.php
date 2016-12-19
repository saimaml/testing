<html>
Homescreen 
	<form method="post" action="register.php">
	<input type="hidden" name="action" value="homescreen">  <br />	
	Key <input type="text" name="key"/><br/>
	user ID <input type="text" name="user_id">  <br />
	Latitude<input type="text" name="latitude">  <br />	
	Longitude<input type="text" name="longitude">  <br />		
	<input type="submit" name="button"> <br />
	</form>
	
Change password
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="chng_pwd">  <br />	
	Key <input type="text" name="key"/><br/>
	user ID <input type="text" name="user_id">  <br />
	new_pwd <input type="text" name="new_pwd">  <br />
	current_pwd <input type="text" name="current_pwd">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
emergency_call
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="emergency_call">  <br />	
	Key <input type="text" name="key"/><br/>
	user ID <input type="text" name="user_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Get City List
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_city">  <br />	
	Key <input type="text" name="key"/><br/>	
	<input type="submit" name="button"> <br />
	</form>

Welcome Image
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="welcome_image">  <br />
	Key <input type="text" name="key"/><br/>	
	<input type="submit" name="button"> <br />
	</form>
	
Get Tips News
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_tips_news">  <br />
	Key <input type="text" name="key"/><br/>	
	<input type="submit" name="button"> <br />
	</form>

Adverstise

	<form method="post" action="register.php">
	<input type="hidden" name="action" value="adverstise">  <br />
	Key <input type="text" name="key"/><br/>	
	<input type="submit" name="button"> <br />
	</form>

Register1
	<form method="post" action="register.php">
	<input type="hidden" name="action" value="register">  <br />  
	Key <input type="text" name="key"/><br/>	
	Full Name <input type="text" name="name">  <br />	
	Email <input type="text" name="email">  <br />	
	Password <input type="text" name="password">  <br />
	latitude <input type="text" name="latitude">  <br />
	longitude <input type="text" name="longitude">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
<?php
$path = '1.gif';
//$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$imageContent_user = base64_encode($data);
?>		
Facebook Register
	<form method="post" action="register.php">
	<input type="hidden" name="action" value="fb_register">  <br />  
	Key <input type="text" name="key"/><br/>	
	Full Name <input type="text" name="name">  <br />	
	Email <input type="text" name="email">  <br />	
	Image Content: <textarea name="image"><?php echo $imageContent_user; ?></textarea><br>	
	latitude <input type="text" name="latitude">  <br />
	longitude <input type="text" name="longitude">  <br />
	<input type="submit" name="button"> <br />
	</form>
Sign in
	<form method="post" action="register.php">
	<input type="hidden" name="action" value="signin">  <br />
	Key <input type="text" name="key"/><br/>	
	Email <input type="text" name="email">  <br />
	Password <input type="text" name="password">  <br />	registration_id <input type="text" name="registration_id">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
Welcome
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="welcome">  <br />
	Key <input type="text" name="key"/><br/>	
	user id <input type="text" name="user_id">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
	
Send Code After Register
	<form method="post" action="register.php">
	<input type="hidden" name="action" value="send_verification_code">  <br />  
	Key <input type="text" name="key"/><br/>	
	Full Name <input type="text" name="name">  <br />	
	Mobile <input type="text" name="mobile"> <br />
	Email <input type="text" name="email">  <br />	
	
	<input type="submit" name="button"> <br />
	</form>	
	
Resend OTP
	<form method="post" action="register.php">
	<input type="hidden" name="action" value="send_otp">  <br />  
	Key <input type="text" name="key"/><br/>	
	user_id <input type="text" name="user_id">  <br />	
	
	<input type="submit" name="button"> <br />
	</form>	 
	
Verify Registration Code
	<form method="post" action="register.php">
	<input type="hidden" name="action" value="verify_registration">  <br />  	
	Key <input type="text" name="key"/><br/>	
	Mobile <input type="text" name="mobile"> <br />
	Email <input type="text" name="email">  <br />	
	Code <input type="text" name="code">  <br />	
	<input type="submit" name="button"> <br />
	</form>	
	
Get My Info 
	<form method="post" action="my_info.php">
	<input type="hidden" name="action" value="get_my_info">  <br />
	Key <input type="text" name="key"/><br/>	
	User ID<input type="text" name="id">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
<!--Edit My Info 
	<form method="post" action="my_info.php">
	<input type="hidden" name="action" value="edit_my_info">  <br />
	Key <input type="text" name="key"/><br/>	
	User ID<input type="text" name="id">  <br />	
	Latitude<input type="text" name="latitude">  <br />	
	Longitude<input type="text" name="longitude">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
get_location
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_location">  <br />
	Key <input type="text" name="key"/><br/>	
	User ID<input type="text" name="user_id">  <br />	
	
	Latitude<input type="text" name="latitude">  <br />	
	Longitude<input type="text" name="longitude">  <br />		
	<input type="submit" name="button"> <br />
	</form>	-->
	
Edit My Info All 
	<form method="post" action="my_info.php">
	<input type="hidden" name="action" value="edit_my_info_all">  <br />
	Key <input type="text" name="key"/><br/>	
	User ID<input type="text" name="id">  <br />	
	User name<input type="text" name="name">  <br />	
	User email<input type="text" name="email">  <br />	
	User mobile<input type="text" name="mobile">  <br />	

	Latitude<input type="text" name="latitude">  <br />	
	Longitude<input type="text" name="longitude">  <br />		
	<input type="submit" name="button"> <br />
	</form>
	
Add pet
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="add_pet">  <br />
	Key <input type="text" name="key"/><br/>	
	Pet type <input type="text" name="pet_type">  <br />	 
	Gender<input type="text" name="gender">  <br />	
	User id<input type="text" name="user_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>	

Edit pet type
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_pet_type">  <br />
	Key <input type="text" name="key"/><br/>	
	pet id <input type="text" name="pet_id">  <br />
	Pet Type <input type="text" name="pet_type">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Edit pet gender
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_pet_gender">  <br />
	Key <input type="text" name="key"/><br/>	
	pet id <input type="text" name="pet_id">  <br />
	Gender <input type="text" name="gender">  <br />	
	<input type="submit" name="button"> <br />
	</form>	

	
Edit pet
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_pet1">  <br />
	Key <input type="text" name="key"/><br/>	
	pet id <input type="text" name="id">  <br />
	weight <input type="text" name="weight">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Edit pet food
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_pet_food">  <br />
	Key <input type="text" name="key"/><br/>	
	pet id <input type="text" name="id">  <br />
	pet food <input type="text" name="pet_food">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Edit pet birthdate
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_pet_birthdate">  <br />
	Key <input type="text" name="key"/><br/>	
	pet id <input type="text" name="id">  <br />
	birthdate <input type="text" name="birthdate">  <br />	
	<input type="submit" name="button"> <br />
	</form>	
		
Add Dog Details for IOS

	<form method="post" action="api.php" enctype='multipart/form-data'>
	<input type="hidden" name="action" value="post_dog_details_ios">  <br />	
	Key <input type="text" name="key"/><br/>	
	Pet ID<input type="text" name="pet_id">  <br />	
	User ID<input type="text" name="user_id">  <br />	
	Pet Name<input type="text" name="pet_name">  <br />	
	Breed Name<input type="text" name="breed_name">  <br />	
	Allergy Name<input type="text" name="allergy_name">  <br />		
	Please choose an image to upload: <input type="file" name="myFile"><br/>
	<input type="submit" name="button"> <br />
	</form>
	
		
	<?php
/* $imgloc = "1.gif";
$imageContent_user = mysql_escape_string(file_get_contents($imgloc)); */

$path = '1.gif';
//$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$imageContent_user = base64_encode($data);
?>	
Add Dog Details for Android

	<form method="post" action="api.php" enctype='multipart/form-data'>
	<input type="hidden" name="action" value="post_dog_details_android">  <br />
	Key <input type="text" name="key"/><br/>	
	Pet ID<input type="text" name="pet_id">  <br />	
	User ID<input type="text" name="user_id">  <br />		
	Pet Name<input type="text" name="pet_name">  <br />	
	Breed Name<input type="text" name="breed_name">  <br />	
	Allergy Name<input type="text" name="allergy_name">  <br />		
	Image Content: <textarea name="image"><?php echo $imageContent_user; ?></textarea><br>
	<input type="submit" name="button"> <br />
	</form>
	
Medical Records

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_pet">  <br />
	Key <input type="text" name="key"/><br/>	
	pet id <input type="text" name="id">  <br />
	<input type="submit" name="list"> <br />
	</form>
	
Delete pet 

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="delete_pet">  <br />
	Key <input type="text" name="key"/><br/>	
	user id <input type="text" name="user_id">  <br />
	pet id <input type="text" name="pet_id">  <br />
	<input type="submit" name="list"> <br />
	</form>

User Timeline 
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="user_timeline">  <br />
	Key <input type="text" name="key"/><br/>	
	User ID <input type="text" name="user_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Delete Timeline Image
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="delete_timeline_img">  <br />
	Key <input type="text" name="key"/><br/>	
	Timeline ID <input type="text" name="timeline_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	

Most like
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="most_like_order">  <br />	
	Key <input type="text" name="key"/><br/>
	User ID<input type="text" name="user_id">  <br />		
	<input type="submit" name="button"> <br />
	</form>


Timeline profile

	<form method="post" action="api.php">	
	<input type="hidden" name="action" value="timeline_profile">  <br />	
	Key <input type="text" name="key"/><br/>	
	user id <input type="text" name="user_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Add friend

	<form method="post" action="api.php">	
	<input type="hidden" name="action" value="add_friend">  <br />	
	Key <input type="text" name="key"/><br/>	
	user id <input type="text" name="user_id">  <br />	
	friend id <input type="text" name="friend_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Add by breed

	<form method="post" action="api.php">	
	<input type="hidden" name="action" value="add_by_breed">  <br />	
	Key <input type="text" name="key"/><br/>	
	search <input type="text" name="search">  <br />	
	user_id <input type="text" name="user_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Add by addressbook

	<form method="post" action="api.php">	
	<input type="hidden" name="action" value="addressbook">  <br />	
	Key <input type="text" name="key"/><br/>	
	Name <input type="text" name="name">  <br />	
	user_id <input type="text" name="user_id">  <br />	
	Mobile <input type="text" name="mobile">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
	
Near by string

	<form method="post" action="api.php">	
	<input type="hidden" name="action" value="nearby_str">  <br />	
	Key <input type="text" name="key"/><br/>	
	search <input type="text" name="address">  <br />		
	<input type="submit" name="button"> <br />
	</form>
	
Add by username

	<form method="post" action="api.php">	
	<input type="hidden" name="action" value="add_by_username">  <br />	
	Key <input type="text" name="key"/><br/>	
	search <input type="text" name="search">  <br />	
	user_id <input type="text" name="user_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Request

	<form method="post" action="api.php">	
	<input type="hidden" name="action" value="send_request">  <br />	
	Key <input type="text" name="key"/><br/>	
	user_id <input type="text" name="user_id">  <br />
	request user id <input type="text" name="to_user">  <br />		
	<input type="submit" name="button"> <br />
	</form>
	
Response

	<form method="post" action="api.php">	
	<input type="hidden" name="action" value="frd_req_response">  <br />	
	Key <input type="text" name="key"/><br/>	
	user_id <input type="text" name="user_id">  <br />
	request user id <input type="text" name="friend_id">  <br />		
	is_accept <input type="text" name="is_accept">  <br />		
	
	<input type="submit" name="button"> <br />
	</form>
	
Billing details with checkbox
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="billing_details_wth_chckbox">  <br />
	Key <input type="text" name="key"/><br/>	
	user id <input type="text" name="user_id">  <br />
	first name <input type="text" name="fname">  <br />	
	last name <input type="text" name="lname">  <br />	
	email <input type="text" name="email">  <br />	
	address <input type="text" name="address2">  <br />	
	mobile <input type="text" name="mobile">  <br />	
	city <input type="text" name="city">  <br />	
	state <input type="text" name="state">  <br />	
	country <input type="text" name="country">  <br />	
	pincode <input type="text" name="pincode">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Billing details without checkbox
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="billing_details_wthout_chckbox">  <br />
	Key <input type="text" name="key"/><br/>	
	user id <input type="text" name="user_id">  <br />
	first name <input type="text" name="fname">  <br />	
	last name <input type="text" name="lname">  <br />	
	email <input type="text" name="email">  <br />	
	address <input type="text" name="address2">  <br />	
	mobile <input type="text" name="mobile">  <br />	
	city <input type="text" name="city">  <br />	
	state <input type="text" name="state">  <br />	
	country <input type="text" name="country">  <br />	
	pincode <input type="text" name="pincode">  <br />	
	delivery first name <input type="text" name="d_fname">  <br />	
	delivery last name <input type="text" name="d_lname">  <br />		
	delivery Mobile<input type="text" name="d_mobile">  <br />		
	delivery address <input type="text" name="d_address2">  <br />	
	delivery city <input type="text" name="d_city">  <br />	
	delivery state <input type="text" name="d_state">  <br />	
	delivery country <input type="text" name="d_country">  <br />	
	delivery pincode <input type="text" name="d_pincode">  <br />	
	<input type="submit" name="button"> <br />
	</form>	
	
Get Billing details 
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_billing_details">  <br />
	Key <input type="text" name="key"/><br/>	
	user id <input type="text" name="user_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
<!--Pet document

	<form enctype="multipart/form-data" method="post" action="api.php">
	<input type="hidden" name="action" value="upload_doc">  <br />
	<input type=hidden name=MAX_FILE_SIZE value=150000>
	<input type=hidden name=completed value=1>
	Please choose an image to upload: <input type="file" name="file"><br>
	Pet id<input type="text" name="pet_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>-->
	
Like 

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="post_likes">  <br />	
	Key <input type="text" name="key"/><br/>	
	User ID<input type="text" name="user_id">  <br />
	Timeline ID<input type="text" name="timeline_id">  <br />
	Friend ID<input type="text" name="friend_id">  <br />
	
	<input type="submit" name="button"> <br />
	</form>
	
UnLike 

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="unlike">  <br />	
	Key <input type="text" name="key"/><br/>	
	User ID<input type="text" name="user_id">  <br />
	Timeline ID<input type="text" name="timeline_id">  <br />
	Friend ID<input type="text" name="friend_id">  <br />
	
	<input type="submit" name="button"> <br />
	</form>
	
Comment Details

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="post_comment">  <br />	
	Key <input type="text" name="key"/><br/>	
	user id<input type="text" name="user_id">  <br />
	timeline id<input type="text" name=" timeline_id">  <br />
	Friend id<input type="text" name=" friend_id">  <br />
	comment<input type="text" name="comment">  <br />		
	<input type="submit" name="button"> <br />
	</form>
	
Delete Comment

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="delete_comment">  <br />	
	Key <input type="text" name="key"/><br/>	
	comment id<input type="text" name="comment_id">  <br />		
	<input type="submit" name="button"> <br />
	</form>
	
Edit Comment

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_comment">  <br />	
	Key <input type="text" name="key"/><br/>	
	comment id<input type="text" name="comment_id">  <br />		
	comment <input type="text" name="comment">  <br />		
	<input type="submit" name="button"> <br />
	</form>
	
Notification Details

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="notification_history">  <br />	
	Key <input type="text" name="key"/><br/>	
	user id<input type="text" name="user_id">  <br />
	<input type="submit" name="button"> <br />
	</form>
	

<!--Edit Pride Wall IOS

	<form method="post" action="api.php" enctype="multipart/form-data">
	<input type="hidden" name="action" value="pride_wall_ios">  <br />
	Key <input type="text" name="key"/><br/>	
	post image<input type="file" name="myFile"><br />	
	user id<input type="text" name="user_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>-->
	
	
	<?php
/* $imgloc = "1.gif";
$imageContent_user = mysql_escape_string(file_get_contents($imgloc)); */

$path = '1.gif';
//$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$imageContent_user = base64_encode($data);
?>	
<!--Edit Pride Wall Android

	<form method="post" action="api.php" enctype="multipart/form-data">
	<input type="hidden" name="action" value="pride_wall_android">  <br />
	Key <input type="text" name="key"/><br/>	
	Image Content: <textarea name="image"><?php echo $imageContent_user; ?></textarea><br>
	user id<input type="text" name="user_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>-->

Get Pride Wall

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_pride_wall">  <br />	
	Key <input type="text" name="key"/><br/>	
	User ID<input type="text" name="user_id">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
Dog Walk

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="dog_walk">  <br />	
	Key <input type="text" name="key"/><br/>	
	Pet ID<input type="text" name="pet_ids">  <br />
	K.M<input type="text" name="km">  <br />
	Time <input type="text" name="time">  <br />
	<!--Temp <input type="text" name="temp">  <br />-->
	<input type="submit" name="button"> <br />
	</form>
	
 Dog Walk graph

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="walk_graph">  <br />	
	Key <input type="text" name="key"/><br/>	
	Pet ID<input type="text" name="pet_id">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
Vaccination

<form method="post" action="api.php">
	<input type="hidden" name="action" value="vaccination_list">  <br />
	Key <input type="text" name="key"/><br/>		
	Pet ID<input type="text" name="pet_id">  <br />	
	User ID<input type="text" name="user_id">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
Doses List

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="doses_list">  <br />
	Key <input type="text" name="key"/><br/>	
	Vaccination id<input type="text" name="vaccination_id">  <br />	
	Pet id<input type="text" name="pet_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>

Doses Details

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_doses_list">  <br />
	Key <input type="text" name="key"/><br/>	
	Vaccination id<input type="text" name="vaccination_id">  <br />	
	Pet id<input type="text" name="pet_id">  <br />	
	Doses id<input type="text" name="doses_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>

<?php

$path = '1.gif';
$data = file_get_contents($path);
$imageContent_user = base64_encode($data);
?>
Doses Details Andriod

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="doses_list_andriod">  <br />
	Key <input type="text" name="key"/><br/>	
	Vaccination id<input type="text" name="vaccination_id">  <br />	
	Pet id<input type="text" name="pet_id">  <br />	
	Doses name<input type="text" name="doses_name">  <br />
	Image Content: <textarea name="doses_img"><?php echo $imageContent_user; ?></textarea><br>
	Given date<input type="text" name="given_date">  <br />	

	<input type="submit" name="button"> <br />
	</form>
	
Post vaccination date 

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="post_vacc_date">  <br />
	Key <input type="text" name="key"/><br/>	
	Vaccination id<input type="text" name="vaccination_id">  <br />	
	Pet id<input type="text" name="pet_id">  <br />	
	Given date<input type="text" name="given_date">  <br />	
	Next date<input type="text" name="next_date">  <br />	

	<input type="submit" name="button"> <br />
	</form>
	
Get Doses Details Andriod

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_doses_list_andriod">  <br />
	Key <input type="text" name="key"/><br/>	
	Vaccination id<input type="text" name="vaccination_id">  <br />	
	Pet id<input type="text" name="pet_id">  <br />		
	
	<input type="submit" name="button"> <br />
	</form>
	
Get Doses Details IOS
	
	<form method="post" action="api.php" enctype="multipart/form-data">
	<input type="hidden" name="action" value="doses_list_ios">  <br />
	Key <input type="text" name="key"/><br/>	
	Vaccination id<input type="text" name="vaccination_id">  <br />	
	Pet id<input type="text" name="pet_id">  <br />
	post image<input type="file" name="myFile"><br />	
	doses_name<input type="text" name="doses_name"><br />	
	given_date<input type="text" name="given_date"><br />	
	user id<input type="text" name="user_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>	
	
Delete Doses Details 

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="delete_dose">  <br />
	Key <input type="text" name="key"/><br/>	
	Dose id<input type="text" name="dose_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>	
	
<?php

$path = '1.gif';
$data = file_get_contents($path);
$imageContent_user = base64_encode($data);
?>
Edit Doses Details Andriod

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_dose">  <br />
	Key <input type="text" name="key"/><br/>	
	Dose id<input type="text" name="dose_id">  <br />	
	Image Content: <textarea name="dose_img"><?php echo $imageContent_user; ?></textarea><br>	
	Dose Name<input type="text" name="dose_name">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Weight details

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="post_weight">  <br />
	Key <input type="text" name="key"/><br/>	
	Vaccination id<input type="text" name="vaccination_id">  <br />	
	Pet id<input type="text" name="pet_id">  <br />	
	Weight<input type="text" name="weight">  <br />	
	Type<input type="text" name="type">  <br />	
	<input type="submit" name="button"> <br />
	</form>

	
Edit Doses Date

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_dose_date">  <br />
	Key <input type="text" name="key"/><br/>	
	Vaccination id<input type="text" name="vaccination_id">  <br />	
	Pet id<input type="text" name="pet_id">  <br />	
	Doses id<input type="text" name="doses_id">  <br />	
	Given date <input type="text" name="given_date">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	


Notes Details

	<form method="post" action="api.php" >
	<input type="hidden" name="action" value="notes_list">  <br />	
	Key <input type="text" name="key"/><br/>	
	Note Title<input type="text" name="note_title">  <br />	
	Note<input type="text" name="note">  <br />
	date<input type="text" name="date">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Timeline Details for IOS

	<form method="post" action="api.php" enctype="multipart/form-data">
	<input type="hidden" name="action" value="add_timeline_ios">  <br />	
	Key <input type="text" name="key"/><br/>	
	Post text<input type="text" name="post_text">  <br />	
	post image<input type="file" name="myFile"> <br />
	post video<input type="file" name="myFile1">  <br />	
	thubnail video<input type="file" name="thub">  <br />	
	user id<input type="text" name="user_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>

<?php
/* $imgloc = "1.gif";
$imageContent_user = mysql_escape_string(file_get_contents($imgloc)); */

$path = '1.gif';
//$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$imageContent_user = base64_encode($data);
?>	
Timeline Details for Android

	<form method="post" action="api.php" enctype="multipart/form-data">
	<input type="hidden" name="action" value="add_timeline_andriod">  <br />
	Key <input type="text" name="key"/><br/>		
	Post text<input type="text" name="post_text">  <br />	
	Image Content: <textarea name="post_img"><?php echo $imageContent_user; ?></textarea><br>
	post video<input type="file" name="myFile">  <br />	
	post thumnail<input type="file" name="myFile1">  <br />	
	user id<input type="text" name="user_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Get Timeline
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_timeline">  <br />
	Key <input type="text" name="key"/><br/>
	timeline id <input type="text" name="id">  <br />
	<input type="submit" name="list"> <br />
	</form>
	
Get Timeline Image
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_timeline_img">  <br />
	Key <input type="text" name="key"/><br/>
	timeline id <input type="text" name="timeline_id">  <br />
	<input type="submit" name="list"> <br />
	</form>
	
Get Dewormer date
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_dewormer">  <br />
	Key <input type="text" name="key"/><br/>
	Pet id <input type="text" name="pet_id">  <br />
	<input type="submit" name="list"> <br />
	</form>
	
Add Dewormer date
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="add_dewormer">  <br />
	Key <input type="text" name="key"/><br/>
	Pet id <input type="text" name="pet_id">  <br />
	Received date<input type="text" name="received_dte">  <br />
	Next date<input type="text" name="nxt_dte">  <br />
	Brand<input type="text" name="brand">  <br />
	<input type="submit" name="list"> <br />
	</form>		

Edit Dewormer date
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_dewormer">  <br />
	Key <input type="text" name="key"/><br/>
	Pet id <input type="text" name="pet_id">  <br />
	Received date<input type="text" name="received_dte">  <br />
	Next date<input type="text" name="nxt_dte">  <br />
	Brand<input type="text" name="brand">  <br />
	<input type="submit" name="list"> <br />
	</form>
	
Get Parasite control date
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_parasite_control">  <br />
	Key <input type="text" name="key"/><br/>
	Pet id <input type="text" name="pet_id">  <br />
	<input type="submit" name="list"> <br />
	</form>
	
Add Parasite Control date
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="add_parasite_control">  <br />
	Key <input type="text" name="key"/><br/>
	Pet id <input type="text" name="pet_id">  <br />
	Received date<input type="text" name="received_dte">  <br />
	Next date<input type="text" name="nxt_dte">  <br />
	Brand<input type="text" name="brand">  <br />
	<input type="submit" name="list"> <br />
	</form>	
	
Edit Parasite control date
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_parasite_control">  <br />
	Key <input type="text" name="key"/><br/>
	Pet id <input type="text" name="pet_id">  <br />
	Received date<input type="text" name="received_dte">  <br />
	Next date<input type="text" name="nxt_dte">  <br />
	Brand<input type="text" name="brand">  <br />	
	<input type="submit" name="list"> <br />
	</form>
	
Select your pet
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="select_pet">  <br />
	Key <input type="text" name="key"/><br/>
	user id <input type="text" name="user_id">  <br />
	Pet type<input type="text" name="pet_type">  <br />
	<input type="submit" name="list"> <br />
	</form>
	
Get Timeline Comment
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_timeline_comment_new">  <br />
	Key <input type="text" name="key"/><br/>
	Timeline id <input type="text" name="timeline_id">  <br />
	User id <input type="text" name="user_id">  <br />
	<input type="submit" name="list"> <br />
	</form>
	
My Doctor

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="my_doctor">  <br />
	Key <input type="text" name="key"/><br/>
	user id<input type="text" name="user_id">  <br />	
	Doctor name <input type="text" name="doctor_name">  <br />	
	Contact no<input type="text" name="contact_no">  <br />	
	address<input type="text" name="dr_address">  <br />	
	clinic name<input type="text" name="dr_clinic_name">  <br />	
	time<input type="text" name="dr_time">  <br />	
	time second<input type="text" name="dr_time1">  <br />	
	<input type="submit" name="button"> <br />
	</form>	
Edit My Doctor

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_my_doctor">  <br />
	Key <input type="text" name="key"/><br/>
	user id<input type="text" name="user_id">  <br />	
	Doctor name <input type="text" name="doctor_name">  <br />	
	Contact no<input type="text" name="contact_no">  <br />	
	address<input type="text" name="dr_address">  <br />	
	clinic name<input type="text" name="dr_clinic_name">  <br />	
	time<input type="text" name="dr_time">  <br />	
	time second<input type="text" name="dr_time1">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Edit My Doctor IOS

	<form method="post" action="api.php" enctype="multipart/form-data">
	<input type="hidden" name="action" value="edit_my_doctor_ios">  <br />
	Key <input type="text" name="key"/><br/>
	user id<input type="text" name="user_id">  <br />	
	Doctor name <input type="text" name="doctor_name">  <br />	
	Contact no<input type="text" name="contact_no">  <br />	
	address<input type="text" name="dr_address">  <br />	
	clinic name<input type="text" name="dr_clinic_name">  <br />	
	time<input type="text" name="dr_time">  <br />	
	time second<input type="text" name="dr_time1">  <br />	
	post image<input type="file" name="myFile"> <br />
	<input type="submit" name="button"> <br />
	</form>
	
	
	
Profile
	<?php
/* $imgloc = "1.gif";
$imageContent_user = mysql_escape_string(file_get_contents($imgloc)); */

$path = '1.gif';
//$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$imageContent_user = base64_encode($data);
?>
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="my_profile">  <br />
	user id<input type="text" name="user_id">  <br />	
	Key <input type="text" name="key"/><br/>
	user image<textarea name="image"><?php echo $imageContent_user; ?></textarea><br />
	user name<input type="text" name="username">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Get Profile

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_my_profile">  <br />
	User id<input type="text" name="user_id">  <br />
	Key <input type="text" name="key"/><br/>	
	<input type="submit" name="button"> <br />
	</form>

<!--Tips Details

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_tips">  <br />
	Key <input type="text" name="key"/><br/>
	Tips for<input type="text" name="tip_for">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Tips description Details

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_tips_description">  <br />
		Key <input type="text" name="key"/><br/>
	Tips id<input type="text" name="tip_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>-->
	
Dog Details

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_dog_details">  <br />
		Key <input type="text" name="key"/><br/>
	User ID<input type="text" name="id">  <br />	
	pet type<input type="text" name="type">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Emergency Details

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_emergency">  <br />
		Key <input type="text" name="key"/><br/>
	Emergency type<input type="text" name="emergency_for">  <br />	
	<input type="submit" name="button"> <br />
	</form>
Emergency Details

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_emergency_details">  <br />
		Key <input type="text" name="key"/><br/>
	Emergency_id <input type="text" name="id">  <br />	
	<input type="submit" name="button"> <br />
	</form>

 Latitude and Longitude
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="latandlong">  <br />	
	Key <input type="text" name="key"/><br/>
	Latitude <input type="text" name="latitude" value="18.5087">  <br />
	Longitude <input type="text" name="longitude" value="73.8125">  <br />
	
	<input type="submit" name="button"> <br />
	</form>

Near by
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="nearby">  <br />	
	Key <input type="text" name="key"/><br/>
	Latitude <input type="text" name="latitude" value="18.5087">  <br />
	Longitude <input type="text" name="longitude" value="73.8125">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Near by sms
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="nearbysms">  <br />	
	Key <input type="text" name="key"/><br/>
	Latitude <input type="text" name="latitude" value="18.5087">  <br />
	Longitude <input type="text" name="longitude" value="73.8125">  <br />	
	user_id <input type="text" name="user_id" >  <br />	
	service_name <input type="text" name="service_name">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Health Record
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="healthrecord">  <br />	
	Key <input type="text" name="key"/><br/>		
	<input type="submit" name="button"> <br />
	</form>
	
service details
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="service_details">  <br />	
	Key <input type="text" name="key"/><br/>
	service_id <input type="text" name="service_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
package details
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_package">  <br />	
	Key <input type="text" name="key"/><br/>
	package_id <input type="text" name="package_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>	
	
Add to cart
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="add_to_cart">  <br />	
	Key <input type="text" name="key"/><br/>
	User ID <input type="text" name="user_id">  <br />	
	Action type (add/edit/delete) <input type="text" name="action_type">  <br />		
	Add Cart<input type="text" name="add_cart" value="{"Order" : [{"ID" : "1",   "quantity" : "3", "type" : "product"},{"ID" : "2","quantity" : "3","type" : "product"}]}"> <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Get Dewormer Brand
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_dewormer_brand">  <br />	
	Key <input type="text" name="key"/><br/>
	<input type="submit" name="button"> <br />
	</form>
	
Get Parasite Brand
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_parasite_brand">  <br />	
	Key <input type="text" name="key"/><br/>	
	<input type="submit" name="button"> <br />
	</form>
	
View cart
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="view_cart">  <br />
	Key <input type="text" name="key"/><br/>		
	user_id <input type="text" name="user_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Delete package from cart
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="delete_package_cart">  <br />	
	Key <input type="text" name="key"/><br/>
	user_id <input type="text" name="user_id">  <br />	
	package_id<input type="text" name="package_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Edit package from cart
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_cart">  <br />
	Key <input type="text" name="key"/><br/>	
	Order id <input type="text" name="order_id">  <br />	
	Edit Cart<input type="text" name="cart" value="({package_id=1;quantity=3;type=package;},{pack_id=2;quantity=3;type=package;},{package_id=2;quantity=5;type=package;})"> <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Doctor details
	<form method="post" action="my_info.php">
	<input type="hidden" name="action" value="get_my_doctor">  <br />	
	Key <input type="text" name="key"/><br/>
	user id <input type="text" name="user_id">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
Near by friend
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="nearbyfrd">  <br />	
	Key <input type="text" name="key"/><br/>
	Latitude <input type="text" name="latitude" value="18.5087">  <br />
	Longitude <input type="text" name="longitude" value="73.8125">  <br />
	user_id <input type="text" name="user_id"/>  <br />
	
	<input type="submit" name="button"> <br />
	</form>
	
	
Search Near by friend

	<form method="post" action="api.php">	
	<input type="hidden" name="action" value="search_nearbyfrd">  <br />	
	Key <input type="text" name="key"/><br/>	
	user_id <input type="text" name="user_id">  <br />		
	search <input type="text" name="search">  <br />		
	<input type="submit" name="button"> <br />
	</form>

forget_pwd
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="forget_pwd">  <br />
	Key <input type="text" name="key"/><br/>
	Email <input type="text" name="email">  <br />
	<input type="submit" name="button"> <br />
	</form>

Add Allergy

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="add_allergy">  <br />
	Key <input type="text" name="key"/><br/>
	Pet id <input type="text" name="pet_id">  <br />
	Allergy name <input type="text" name="allergy">  <br />
	<input type="submit" name="button"> <br />
	</form>

List Allergy
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="list_allergy">  <br />
	Key <input type="text" name="key"/><br/>
	<input type="submit" name="list"> <br />
	</form>

Get Allergy
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_allergy">  <br />
	Key <input type="text" name="key"/><br/>
	Pet id <input type="text" name="pet_id">  <br />
	<input type="submit" name="list"> <br />
	</form>

Get Allergy IOS  
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_allergy_ios">  <br />
	Key <input type="text" name="key"/><br/>
	Pet id <input type="text" name="pet_id">  <br />
	<input type="submit" name="list"> <br />
	</form>

Edit Allergy
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_allergy">  <br />
	Key <input type="text" name="key"/><br/>
	Allergy id <input type="text" name="id">  <br />
	
	Allergy name <input type="text" name="allergy">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
DELETE Allergy
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="delete_allergy">  <br />
	Key <input type="text" name="key"/><br/>
	Allergy id <input type="text" name="id">  <br />
	Pet id <input type="text" name="pet_id">  <br />
	<input type="submit" name="button"> <br />
	</form>
Add surgery

	<form method="post" action="api.php">
	<input type="hidden" name="action" value="add_surgery">  <br />
	Key <input type="text" name="key"/><br/>
	Surgery <input type="text" name="surgery">  <br />
	<input type="submit" name="button"> <br />
	</form>

List surgery
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="list_surgery">  <br />
	Key <input type="text" name="key"/><br/>
	<input type="submit" name="list"> <br />
	</form>

Get surgery
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_surgery">  <br />
	Key <input type="text" name="key"/><br/>
	surgery <input type="text" name="id">  <br />
	<input type="submit" name="list"> <br />
	</form>
	
Edit surgery
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_surgery">  <br />
	Key <input type="text" name="key"/><br/>
	surgery id <input type="text" name="id">  <br />
	surgery name <input type="text" name="surgery">  <br />
	<input type="submit" name="button"> <br />
	</form>

Add Note
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="add_note">  <br />
	Key <input type="text" name="key"/><br/>
	Note <input type="text" name="note">  <br />
	<input type="submit" name="button"> <br />
	</form>

List Note
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="list_note">  <br />
	Key <input type="text" name="key"/><br/>
	<input type="submit" name="list"> <br />
	</form>

Get Note
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_note">  <br />
	Key <input type="text" name="key"/><br/>
	Note <input type="text" name="id">  <br />
	<input type="submit" name="list"> <br />
	</form>
	
Edit Note
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_note">  <br />
	Key <input type="text" name="key"/><br/>
	Note id <input type="text" name="id">  <br />
	Note name <input type="text" name="note_name">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
Add diet
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="add_diet">  <br />
	Key <input type="text" name="key"/><br/>
	Pet id <input type="text" name="pet_id">  <br />
	Diet <input type="text" name="diet">  <br />
	<input type="submit" name="button"> <br />
	</form>

List diet
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="list_diet">  <br />
	Key <input type="text" name="key"/><br/>
	<input type="submit" name="list"> <br />
	</form>

Get diet
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_diet">  <br />
	Key <input type="text" name="key"/><br/>
	pet ID <input type="text" name="pet_id">  <br />
	<input type="submit" name="list"> <br />
	</form>

Edit diet
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_diet">  <br />
	Key <input type="text" name="key"/><br/>
	diet id <input type="text" name="id">  <br />
	diet name <input type="text" name="diet_name">  <br />
	<input type="submit" name="button"> <br />
	</form>

Delete diet
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="delete_diet">  <br />
	Key <input type="text" name="key"/><br/>
	diet id <input type="text" name="id">  <br />
	pet id <input type="text" name="pet_id">  <br />
	diet name <input type="text" name="diet_name">  <br />
	<input type="submit" name="button"> <br />
	</form>

Weight graph
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="weight_graph">  <br />
	Key <input type="text" name="key"/><br/>
	Pet id <input type="text" name="pet_id">  <br />
	<input type="submit" name="button"> <br />
	</form>

Add need
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="add_need">  <br />
	Key <input type="text" name="key"/><br/>
	Need <input type="text" name="need">  <br />
	<input type="submit" name="button"> <br />
	</form>

List need
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="list_need">  <br />
	Key <input type="text" name="key"/><br/>
	<input type="submit" name="list"> <br />
	</form>

Get need
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_need">  <br />
	Key <input type="text" name="key"/><br/>
	need <input type="text" name="id">  <br />
	<input type="submit" name="list"> <br />
	</form>

Edit need
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_need">  <br />
	Key <input type="text" name="key"/><br/>
	need id <input type="text" name="id">  <br />
	need name <input type="text" name="need_name">  <br />
	<input type="submit" name="button"> <br />
	</form>

Add medical_details
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="add_medical_details">  <br />
	Key <input type="text" name="key"/><br/>
	Title <input type="text" name="title">  <br />
	Pet ID <input type="text" name="pet_id">  <br />
	<input type="submit" name="button"> <br />
	</form>

List medical_details
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="list_medical_details">  <br />
	Key <input type="text" name="key"/><br/>
	<input type="submit" name="list"> <br />
	</form>

Get medical_details
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_medical_details">  <br />
	Key <input type="text" name="key"/><br/>
	medical <input type="text" name="id">  <br />
	<input type="submit" name="list"> <br />
	</form>

Edit medical_details
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_medical_details">  <br />
	Key <input type="text" name="key"/><br/>
	medical id <input type="text" name="id">  <br />
	date <input type="text" name="date1">  <br />
	title <input type="radio" name="title" value="tablet">tablet 
	<input type="radio" name="title" value="liquid">liquid<br>
	weight <input type="text" name="weight">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
Delete medical_details
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="delete_medical_details">  <br />
	Key <input type="text" name="key"/><br/>
	medical id <input type="text" name="id">  <br />
	Pet ID <input type="text" name="pet_id">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
Add appointment
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="add_appointment">  <br />
	Key <input type="text" name="key"/><br/>
	Name <input type="text" name="name">  <br />
	Date <input type="text" name="date1">  <br />
	Age <input type="text" name="age">  <br />
	Breed <input type="text" name="breed">  <br />
	Identification <input type="text" name="identification">  <br />
	Medical <input type="text" name="medical">  <br />
	Pincode <input type="text" name="pincode">  <br />
	<input type="submit" name="button"> <br />
	</form>

List appointment
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="list_appointment">  <br />
	Key <input type="text" name="key"/><br/>
	<input type="submit" name="list"> <br />
	</form>

Get appointment
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_appointment">  <br />
	Key <input type="text" name="key"/><br/>
	appointment <input type="text" name="id">  <br />
	<input type="submit" name="list"> <br />
	</form>
	
Edit appointment
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_appointment">  <br />
	Key <input type="text" name="key"/><br/>
	appointment id <input type="text" name="id">  <br />
	Name <input type="text" name="appointment_name">  <br />
	Date <input type="text" name="date1">  <br />
	Age <input type="text" name="age">  <br />
	Breed <input type="text" name="breed">  <br />
	Identification <input type="text" name="identification">  <br />
	Medical <input type="text" name="medical">  <br />
	Pincode <input type="text" name="pincode">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
Add owner
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="add_owner">  <br />
	Key <input type="text" name="key"/><br/>
	Name <input type="text" name="owner_name">  <br />
	city_area <input type="text" name="city_area">  <br />
	owner email id <input type="text" name="email">  <br />
	owner phone no <input type="text" name="phone">  <br />
	Pincode <input type="text" name="pincode">  <br />
	gender <input type="radio" name="gender" value="male">male 
	<input type="radio" name="gender" value="female">female<br>
	<input type="submit" name="button"> <br />
	</form>

List owner
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="list_owner">  <br />
	Key <input type="text" name="key"/><br/>	
	<input type="submit" name="list"> <br />
	</form>

Get owner
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_owner">  <br />
	Key <input type="text" name="key"/><br/>	
	owner <input type="text" name="id">  <br />
	<input type="submit" name="list"> <br />
	</form>
	
Edit owner
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="edit_owner">  <br />
	Key <input type="text" name="key"/><br/>	
	owner id <input type="text" name="id">  <br />
	Name <input type="text" name="owner_name">  <br />
	city_area <input type="text" name="city_area">  <br />
	owner email id <input type="text" name="email">  <br />
	owner phone no <input type="text" name="phone">  <br />
	Pincode <input type="text" name="pincode">  <br />
	gender <input type="radio" name="gender" value="male">male 
	<input type="radio" name="gender" value="female">female<br>
	<input type="submit" name="button"> <br />
	</form>

List pet
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="list_pet">  <br />
	Key <input type="text" name="key"/><br/>	
	<input type="submit" name="list"> <br />
	</form>
	
List pet of User
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="list_pet_of_user">  <br />
	Key <input type="text" name="key"/><br/>	
	<input type="text" name="user_id" value="">  <br />
	<input type="submit" name="list"> <br />
	</form>

Social Profile
	<form method="post" action="api.php" enctype="multipart/form-data">
	<input type="hidden" name="action" value="social_profile">  <br />
	Key <input type="text" name="key"/><br/>	
	Please choose an image to upload: <input type="file" name="myFile"><br>
	user id <input type="text" name="user_id">  <br />
	user Name <input type="text" name="user_name">  <br />
	status <input type="text" name="status">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
Social Profile Image IOS
	<form method="post" action="api.php" enctype="multipart/form-data">
	<input type="hidden" name="action" value="post_social_profile_ios">  <br />
	Key <input type="text" name="key"/><br/>	
	Please choose an image to upload: <input type="file" name="myFile"><br>
	user id <input type="text" name="user_id">  <br />
	<input type="submit" name="button"> <br />
	</form>	
	
Post Social Profile Status
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="post_social_profile_android">  <br />
	Key <input type="text" name="key"/><br/>	
	user id <input type="text" name="user_id">  <br />	
	status<input type="text" name="status">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
Post Social Profile Name
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="post_social_profile_android">  <br />
	Key <input type="text" name="key"/><br/>	
	user id <input type="text" name="user_id">  <br />	
	Name <input type="text" name="user_name">  <br />
	<input type="submit" name="button"> <br />
	</form>
	
	
<?php
/* $imgloc = "1.gif";
$imageContent_user = mysql_escape_string(file_get_contents($imgloc)); */

$path = '1.gif';
//$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$imageContent_user = base64_encode($data);
?>	
Social Profile Android
	<form method="post" action="api.php" enctype="multipart/form-data">
	<input type="hidden" name="action" value="post_social_profile_android">  <br />
	Key <input type="text" name="key"/><br/>	
	Image Content: <textarea name="image"><?php echo $imageContent_user; ?></textarea><br>
	user id <input type="text" name="user_id">  <br />
	<input type="submit" name="button"> <br />
	</form>		
	
	
Get Social Profile
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_social_profile">  <br />
	Key <input type="text" name="key"/><br/>	
	user id <input type="text" name="user_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>

	
Get Product Main Category List
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_main_category_list">  <br />
	Key <input type="text" name="key"/><br/>	
	
	<input type="submit" name="button"> <br />
	</form>
	
Get Product Category List
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_product_category_list">  <br />
	Key <input type="text" name="key"/><br/>	
	Category id <input type="text" name="cat_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
	
Get Product List
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_product_list">  <br />
	Key <input type="text" name="key"/><br/>	
	Category id <input type="text" name="cat_id">  <br />	
	City <input type="text" name="city">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Get Product Details
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_product_details">  <br />
	Key <input type="text" name="key"/><br/>	
	Product id <input type="text" name="product_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>	
	
Get Service Details
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_service_category_details">  <br />
	Key <input type="text" name="key"/><br/>	
	category id <input type="text" name="cat_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>	
Get Transaction 
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_trasaction">  <br />
	Key <input type="text" name="key"/><br/>	
	User id <input type="text" name="user_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>
	
Update Transaction details andriod
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="update_transaction_status_andriod">  <br />	
	Key <input type="text" name="key"/><br/>	
	Order id <input type="text" name="order_id">  <br />	
	status <input type="text" name="status">  <br />		
	str<input type="text" name="str" >  <br />	
	<input type="submit" name="button"> <br />
	</form>

Get Transaction Details
	<form method="post" action="api.php">
	<input type="hidden" name="action" value="get_trasaction_details">  <br />
	Key <input type="text" name="key"/><br/>	
	User id <input type="text" name="cart_id">  <br />	
	<input type="submit" name="button"> <br />
	</form>

</html>