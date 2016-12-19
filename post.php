<?php 
	session_start();
	include_once('config/config.php'); 
	$code = rand(1000, 9999); 
	
	if(!$_POST["name"]=="")
	{
		$dog_name = $_POST["dog_name"];
		//$doggender = $_POST["doggender"];
		$dogbreed = $_POST["dogbreed"];
		$dogage = $_POST["dog_age"];
		$dogmonth = $_POST["dogmonth"];
		$dogdate = $_POST["dogdate"];		
		$doglocation = $_POST["doglocation"];
		 $name = $_POST["name"];
		$mobile = $_POST["mobile"];
		$email = $_POST["email"];
		$password = $_POST["password"];		

		/* $year =  date("Y");		
		$year1 = $year - $dogage; */
		$birthdate = $dogage."/".$dogmonth."/".$dogdate;
		
		/* $user_msg = urlencode("Dear $name, Thanks for registering with us. Your verification code is $code. Kindly use this code to proceed. Thanks,");
		send_sms($user_msg, $mobile); */
			
		$sql_user = "INSERT into app_users(name,mobile,email,password,city)values('".$name."','".$mobile."','".$email."','".$password."','".$doglocation."')";
		$result_user =mysqli_query($con,$sql_user)or die(mysql_error());
		$user_id = mysqli_insert_id($con);
				
		$_SESSION['user_id'] = $user_id;
		$_SESSION['login'] = "1";
		
		$sql_pet = "insert into pet_master(pet_name,pet_type,birthdate,breed,user_id) values ('".$dog_name."','Dog','".$birthdate."','".$dogbreed."','".$user_id."')";
		$result_pet = mysqli_query($con,$sql_pet);
				
		if(mysql_error() == "")		
		{
			
		?>
			<script>
				document.location = "http://discovermypet.in/home.php";
			</script>
		<?php
		}
		else
		{	?>
			<div class="alert alert-danger alert-dismissable">    
			<button type="button" data-dismiss="alert" aria-hidden="true" class="close"><i class="fa fa-times"></i></button> <strong>Erros.</strong></div>
			<?php 
		}
	}
	else
	{
		$dog_name = $_POST["dog_name"];
		$doggender = $_POST["doggender"];
		$dogbreed = $_POST["dogbreed"];
		$dogage = $_POST["dogage"];
		$doglocation = $_POST["doglocation"];
		$email = $_POST["email1"];
		$password = $_POST["password1"];
		
		$sql="SELECT * FROM app_users WHERE email = '".$email."' and password = '".$password."'";
		$result =mysqli_query($con,$sql);
		if(mysqli_num_rows($result) > 0)	
		{
			$result2 = mysqli_fetch_array($result); 
			$_SESSION['user_id'] = $result2['id'];
			$_SESSION['login'] = "1";
			$user_id = $_SESSION['user_id'];
			?>
			<script>
				document.location = "http://discovermypet.in/home.php";
			</script>
		<?php
		}
		else
		{	?>
			<script>
				document.location = "http://discovermypet.in/index.html";
			</script><?php
		}			
	}
	
function send_sms($user_msg, $mobile)
{
global $link;
$sms_url = "http://smslane.com/vendorsms/pushsms.aspx?user=NEVYTE&password=469663&msisdn=$mobile&sid=NEVYTE&msg=$user_msg&fl=0&gwid=2";	
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$sms_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
} 
 
?>