<?php 
	session_start(); 
	$session_id = session_id();
	date_default_timezone_set('Asia/Calcutta');
	
	include_once('config/config.php'); 
	include_once('config/constant.php'); 
	

$sql_main_cat = "SELECT id,main_category FROM tbl_product_main_cat ORDER BY menu_order ASC";
$result_main_cat = mysqli_query($con,$sql_main_cat);
	
$sql_cart = "SELECT id FROM tbl_cart WHERE session_id = '$session_id'";
$result_cart =mysqli_query($con,$sql_cart);
$row_cart= mysqli_fetch_array($result_cart); 
$cart_count = mysqli_num_rows($result_cart); 

	   if(isset($_POST["login"]))
	   {  
   			$email = $_POST["email"];
			$password = $_POST["password"];

			$sql="SELECT * FROM app_users WHERE email = '".$email."' and password = '".$password."'";
			$result =mysqli_query($con,$sql);
			if(mysql_error() == "")	
			{
				$result2 = mysqli_fetch_array($result); 
				$_SESSION['user_id'] = $result2['id'];
				$_SESSION['login'] = "1";
				$user_id = $_SESSION['user_id'];
								
				$sql_update= "UPDATE tbl_cart SET user_id = '".$user_id."' WHERE session_id = '".$session_id."'";
				$result_update =mysqli_query($con,$sql_update);
				
				$sql_update_master= "UPDATE tbl_cart_master SET user_id = '".$user_id."' WHERE session_id = '".$session_id."'";
				$result_update_master =mysqli_query($con,$sql_update_master);
								
				if($cart_count > 0)	
				{  ?>
					<script>
						document.location = "billing-details.php";
					</script>
				<?php }	else
				{   ?>
					<script>
						document.location = "product.php"; 
					</script>
				<?php   }  		
			}
			else
			{?>
			<div class="alert alert-danger alert-dismissable">    
			<button type="button" data-dismiss="alert" aria-hidden="true" class="close"><i class="fa fa-times"></i></button> <strong>Erros: Invalid username and password.</strong></div>
			<?php 
			}
		}
		if(isset($_POST["register"]))
	    {  			
			$code = rand(1000, 9999); 			
			$name = $_POST["name"];
			$mobile = "91".$_POST["mobile"];
			$city = $_POST["city"];
			$email = $_POST["email"];

			$sql = "INSERT into app_users (name,mobile,email,city,verify_code,created_date) values ('".$name."','".$mobile."', '".$email."', '".$city."','".$code."','".date('Y-m-d')."')";
			$result =mysqli_query($con,$sql);
			
			$user_id = mysqli_insert_id();
			$_SESSION['user_id'] = $user_id;
			$_SESSION['login'] = "1";
			
			$sql_update= "UPDATE tbl_cart SET user_id = '".$user_id."' WHERE session_id = '".$session_id."'";
			$result_update =mysqli_query($con,$sql_update);								
			
			$user_msg = urlencode("Dear $name, Website :www.http://discovermypet.in/ Username $email Password : $code. Thanks. Discover My Pet Team.");
			
			send_sms($user_msg, $mobile);		
		   
			if(mysql_error() == "")		
			{
				if($cart_count > 0)	
				{  ?>
					<script>
						document.location = "billing-details.php";
					</script>
				<?php }	else
				{   ?>
					<script>
						document.location = "product.php"; 
					</script>
				<?php   }  		
			}
			else
			{
				?>
			<div class="alert alert-danger alert-dismissable">    
			<button type="button" data-dismiss="alert" aria-hidden="true" class="close"><i class="fa fa-times"></i></button> <strong>Erros.</strong></div>
			<?php 
			}
		}
		function send_sms($user_msg, $mobile)
		{
			$sms_url = "http://smslane.com/vendorsms/pushsms.aspx?user=NEVYTE&password=469663&msisdn=$mobile&sid=NEVYTE&msg=$user_msg&fl=0&gwid=2";	

			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$sms_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_exec($ch);
		} 	
		function clean($string) {  
		$string = str_replace(' ', '-', $string); 
		$string = preg_replace("/[^A-Za-z0-9\-]/", '', $string); 
		return preg_replace('/-+/', '-', $string); 
		}		
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Title and Meta Tags Begins -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta charset="utf-8">
	<!--[if IE]>
	<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
	<![endif]-->
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
	
	<meta name="title" content="Buy Pet Care Products, Pet Supplies Online | App for Pet Owners - Discover My Pet">
	<meta name="description" content="Discover My Pet is leading pet store offering pet care products & supplies online in India. Best app for pet owner, tracking pet health record, reminder system connecting pet care service providers.">	
	
	<title>Discover My Pet</title>
	<link rel="shortcut icon" href="<?php echo URL ?>images/favicon.png">
	<!-- Title and Meta Tags Ends -->
	
	<!-- Google Font Begins -->	
	
	<link href='http/fonts.googleapis.com/MS_12.html' rel='stylesheet' type='text/css'>
	<link href='http/fonts.googleapis.com/MS_11.html' rel='stylesheet' type='text/css'>
	<!-- Google Font Ends -->	
	
	<!-- CSS Begins-->	
			 
	<link href='http/netdna.bootstrapcdn.com/font-awesome/4.1.0/css/MS_13.css' rel='stylesheet' type='text/css'/>
	<link href="<?php echo URL ?>css/flaticon.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo URL ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo URL ?>css/portfolio.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo URL ?>css/animate.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo URL ?>css/prettyPhoto.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo URL ?>css/flexslider.css" rel="stylesheet" type="text/css" />	
	<link href="<?php echo URL ?>css/tweet-carousel.css" rel="stylesheet" type="text/css" />
	
	<!-- Main Style -->
	<link href="<?php echo URL ?>css/style.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo URL ?>css/responsive.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo URL ?>css/model.css" rel="stylesheet" type="text/css">
	<!-- Color Panel -->
	<link href="<?php echo URL ?>css/color_panel.css" rel="stylesheet" type="text/css" />
	
	<!-- Custom CSS -->
	<link href="<?php echo URL ?>dist/styles/landing.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo URL ?>dist/styles/owl.carousel.css">
	
	
	<!--end --->
	
	<!-- Skin Colors -->
	<link href="<?php echo URL ?>css/color-schemes/red.css" id="changeable-colors" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	 <!--<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>	-->
		
<style>

.dropdown-header >li a
{
	font-size: 14px !important;
}

.navbar-nav>li>.dropdown-menu {
  margin:-2% 20px !important;
   width:90%;
 /* border-top-left-radius: 4px;
  border-top-right-radius: 4px; */
  
}

.navbar-default .navbar-nav>li>a {
  width: 200px;
  font-weight: bold;
}
.mega-dropdown {
  position: static !important;
  display:block;
  /*width: 100%;*/
}

.mega-dropdown-menu {
  padding: 20px 0px;
  
  width: 100%;
  box-shadow: none;
  -webkit-box-shadow: none;
}

.mega-dropdown-menu:before {
  content: "";
  border-bottom: 15px solid #fff;
  border-right: 17px solid transparent;
  border-left: 17px solid transparent;
  position: absolute;
  top: -15px;
  left: 285px;
  z-index: 10;
  display:none !important;
}

.mega-dropdown-menu:after {
  content: "";
  border-bottom: 17px solid #ccc;
  border-right: 19px solid transparent;
  border-left: 19px solid transparent;
  position: absolute;
  top: -17px;
  left: 283px;
  z-index: 8;
  display:none !important;
}

.mega-dropdown-menu > li > ul {
  padding: 0;
  margin: 0;
}

.mega-dropdown-menu > li > ul > li {
  list-style: none;
}

.mega-dropdown-menu > li > ul > li > a {
  display: block;
  padding: 3px 20px;
  
  clear: both;
  font-weight: normal;
  line-height: 1.428571429;
  color: #999;
  white-space: normal;
}

.mega-dropdown-menu > li ul > li > a:hover,
.mega-dropdown-menu > li ul > li > a:focus {
  text-decoration: none;
  color:#E74C3C;
  background-color: #f5f5f5;
  
}
.mega-dropdown-menu ul.nav a
{
	
	font-size: 12px;
}
.dropdown-menu .divider {
    background-color:#000 !important;
	}
.mega-dropdown-menu .dropdown-header {
  color: #E74C3C;
  font-size: 16px;
  font-weight: bold;
}

.mega-dropdown-menu form {
  margin: 3px 20px;
}

.mega-dropdown-menu .form-group {
  margin-bottom: 3px;
}
.dropdown-header {
   
    padding-left: 0px !important;
}
</style>		
    <meta http-equiv="Content-Type" content="text/html" charset=iso-8859-1"></meta></head>
    <body id="home">       
		<!-- End Page Loader-->
        <header id="header">
            <div class="navbar navbar-fixed-top" id="navigation">
                <div class="container">
                    <!-- Navigation Bar -->
                    <div class="navbar-header">
                        <!-- Responsive Menu Button -->
                        <button data-target=".bs-navbar-collapse" data-toggle="collapse" type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span> 
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                        <!-- Logo Image --> 
                        <a href="<?php echo WEb_URL ?>home" class="navbar-brand"><img src="<?php echo URL ?>images/dmp_logo_new_bold200.png" alt="Discover My Pet"></a>
                    </div>
                    <!-- End Navigation Bar -->
                    <!-- Navigation Menu -->
                    <nav id="topnav" role="navigation" class="collapse navbar-collapse bs-navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
						<li><a href="<?php echo WEb_URL ?>home" class="scroll">Home </a></li> 
							<!--<li class="dropdown">
							<a data-delay="10" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="home.php" aria-expanded="true">
							Home  </a> 
							<!-- DropDown Menu Begins -->   
							<!--<ul class="menulist dropdown-menu">  
								<li><a href="about.php">About Us</a></li>
								
							</ul>       
						 DropDown Menu Ends   
							</li>-->
						   
                            <!--<li><a href="#features" class="scroll">App Highlights</a></li>-->
                          
							
				<li class="dropdown mega-dropdown">
          <a href="product" class="dropdown-toggle" data-toggle="dropdown">Buy Products <i class="fa fa-angle-down"></i></a>

<ul class="dropdown-menu mega-dropdown-menu row">
	
            <li class="col-sm-2">
              <ul>
                <li class="dropdown-header" style="color:#e74c3c;text-transform:uppercase;">Download DMP App</li>
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="item active">
                      <a href="<?php echo WEb_URL ?>home.php#subscribe"><img src="<?php echo URL ?>images/screens/Introduction1.png" class="img-responsive" alt="product 1"></a>
                    
                    </div>                   
                    <div class="item">
						<a href="<?php echo WEb_URL ?>home.php#subscribe"><img src="<?php echo URL ?>images/screens/Introduction2.png" class="img-responsive" alt="product 2"></a>                  
                    </div>                                 
				   <div class="item">
						<a href="<?php echo WEb_URL ?>home.php#subscribe"><img src="<?php echo URL ?>images/screens/Introduction3.png" class="img-responsive" alt="product 3"></a>                   
                    </div>                    
                  </div>
                  <!-- End Carousel Inner -->
                </div>
                <!-- /.carousel
                <li class="divider"></li> -->
                <!--<li><a href="#">View all <i class="fa fa-chevron-right"></i></a></li>-->
              </ul>
            </li>
			<!--<div class="row">-->
			<?php while($row_main_cat = mysqli_fetch_array($result_main_cat)){ 
			$main_cat = clean(strtolower($row_main_cat["main_category"]));
				$sql_sub_cat = "SELECT id,catogories_name FROM tbl_product_category WHERE main_id = '".$row_main_cat['id']."'";
				
				$result_sub_cat = mysqli_query($con,$sql_sub_cat);
				$num = mysqli_num_rows($result_sub_cat);
				if($num > 0)
				{  ?>
			
					<li class="col-sm-2">
              <ul>
                <li class="dropdown-header"><a style="color: #e74c3c;
    font-family: arial;
    font-weight: bold;" href="<?php echo WEb_URL ?><?php echo $main_cat; ?>/<?php echo $row_main_cat["id"]; ?>/product"><?php echo $row_main_cat["main_category"]; ?></a></li>
				<?php while($row_sub_cat = mysqli_fetch_array($result_sub_cat))
				{  
					 $sub_cat = clean(strtolower($row_sub_cat["catogories_name"]));
			?>
					<li><a href="<?php echo WEb_URL ?><?php echo $main_cat; ?>/<?php echo $sub_cat; ?>/<?php echo $row_sub_cat["id"]; ?>/product" style="color:#666666;font-weight:500;"><?php echo $row_sub_cat["catogories_name"]; ?></a></li>
				<?php  }   ?>
             
               
               <li class="divider"></li>
              
              </ul> 
            </li>
			
			<?php	}				}  ?> <!--</div>-->
          </ul> 

        </li>
                            <li><a href="<?php echo WEb_URL ?>service-shop" class="scroll">Services </a></li>
							<li><a class="scroll" href="<?php echo WEb_URL ?>blog">Pet Story </a></li>
							<li><a href="<?php echo WEb_URL ?>animal-activist.php" class="scroll"> </a></li>							
							<li class="dropdown">
								<a data-delay="10" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="true">
								Community<i class="fa fa-angle-down"></i>  </a> 
								<!-- DropDown Menu Begins -->   
								<ul class="menulist dropdown-menu" style=" width:225px !important;">  
									<li><a href="<?php echo WEb_URL ?>animal-activist" style="color:#666666;font-weight:500;">Animal Activists Stories</a></li>
									<li><a href="<?php echo WEb_URL ?>dog-event" style="color:#666666;font-weight:500;">Dog Show</a></li>
									<!--<li><a href="<?php echo WEb_URL ?>breeder" style="color:#666666;font-weight:500;">Know Your Dog</a></li>-->									
								</ul>            
								<!-- DropDown Menu Ends -->    
							</li>
							
							
							
							<!--<li><a href="animal-activist.php" class="scroll">Know your Breed </a></li>
						    <li><a href="career.php" class="scroll">Career</a></li>              -->
                            <?php if(isset($_SESSION['user_id'])){?>
								<li><a href="logout.php" class="scroll">Logout</a></li>
							<?php }else{?>
								<li><a href="#login_form">Login</a></li>
							<?php }?> 

							
		<li><a href="<?php echo WEb_URL ?>shopping-cart.php?session_id=<?php echo $session_id;?>"><button type="button" class="btn btn-primary"> 
		<i class="fa fa-shopping-cart"></i> <span class="badge" id="total_quantity"><?php echo $row_cart['total'];?></span> 	</button></a></li>								
                        </ul>
                    </nav>
                    <!-- End Navigation Menu -->
                </div>
                <!-- End container -->
            </div>
            <!-- Slider Begins-->
            <div class="container">
                <div class="row">
                    <div class="col-md-7 intro-text">
                        <!-- TEXT -->
                        <div class="main">
                            <h1>An <span class="rotate text-color"> <span class="text-small" style="text-transform: lowercase;">e</span>-Volution </span> in Pet WORLD </h1>
                        </div>
                        
                            <!-- Link -->
                            <span class="page-scroll">
                            <a href="about" class="btn slide-btn bg-inverse">About Us</a>
                            </span>
                            <!-- Link -->
                            <span class="page-scroll">
                            <a href="#subscribe" class="btn slide-btn">Download App</a>
                            </span> 
                    </div>
                    <div class="col-md-5">
                        <!-- Screenshots List -->
                        <div id="mobileslider">
                            <div class="mobile-img">
                                <img src="<?php echo URL ?>images/slider/homescreen5.png" alt="" class="img-responsive" />
                            </div>
							<div class="mobile-img">
                                <img src="<?php echo URL ?>images/slider/homescreen6.png" alt="" class="img-responsive" />
                            </div>
							<div class="mobile-img">
                                <img src="<?php echo URL ?>images/slider/homescreen7.png" alt="" class="img-responsive" />
                            </div>
                            <div class="mobile-img">
                                <img src="<?php echo URL ?>images/slider/homescreen8.png" alt="" class="img-responsive" />
                            </div>
                            <div class="mobile-img">
                                <img src="<?php echo URL ?>images/slider/homescreen9.png" alt="" class="img-responsive" />
                            </div>
							
                        </div>
                        <!-- End Screenshots List-->
                    </div>
                </div>
            </div>
            <!-- Slider Ends-->
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></meta></header>
		
			<!-- popup Login Form  -->
  <a href="#x" class="overlay1" id="login_form"></a>
      <div class="popup">
							
				<div class="container">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#login" data-toggle="tab">Login</a></li>		  
						<li><a href="#register" data-toggle="tab">Register</a></li>
					</ul>
					<div class="tab-content">
				
						<div class="tab-pane active" id="login">
						   <form action="" method="POST" role="form">
						 
							<div class="form-group">
								<input type="email" class="form-control" id="email" name="email" placeholder="Email address" required>
							</div>
							<div class="form-group">
								<input type="password" class="form-control" id="password"  name="password" placeholder="Password" required>
							</div>
							<div class="checkbox log_chck">
								<label><input type="checkbox" checked> Remember me</label>
							</div>
					   <button type="submit" name="login" class="btn btn-primary">Login</button>  
					   <!--<a href = "email.php">Forgot password</a>-->
						<a class="close" href="#close"></a>  
						</form>
				</div>
				
				<div class="tab-pane" id="register">          
					<form action="" method="POST" role="form">
					<span id="status"></span>
						<div class="form-group">
							<input type="name" class="form-control" id="name" name="name" placeholder="Name" required>
						</div>
						<div class="form-group">
							<input type="mobile" class="form-control" id="mobile"  name="mobile" placeholder="Mobile Number" required onBlur="checkmobile();">
							
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="city" name="city" placeholder="City" required>
						</div>
						<div class="form-group">
							<input type="email" class="form-control" id="email" name="email" placeholder="Email address" required onBlur="checkemail();">
							
						</div>
						
						<div class="checkbox log_chck">
							<label><input type="checkbox" checked="" value="1" name="term"> I accept DiscoverMyPet's <span class="txt_blue">'Terms of Use', 'Privacy Policy' </span> .</label>
						</div>
					<button type="submit" name="register" class="btn btn-primary">Submit</button>  
					<a class="close" href="#close"></a> 								
					</form> 	
				</div>

			</div><!-- tab content -->
			</div><!-- end of container -->		
					
						
	</div>
<script>
	 function checkemail()
    {
	
	   var email=document.getElementById( "email" ).value;
	
	   if(email)
	   {
	       $.ajax({
			   type: 'post',
			   url: 'checkdata.php',
			   data: {
			   email:email,
			   },
			   success: function (response) {
				   
			  
		       if(response=="OK")	
               {
				    $( '#status' ).html(response);
                  return true;	
               }
               else
               {
				   $( '#status' ).html(response);
					$('#email').val("");
                  return false;	
               }
             }
		   });


	    }
	    else
	    {
		   $( '#status' ).html("");
		   return false;
	    }
	
	}
	function checkmobile()
    {	
	   var mobile=document.getElementById( "mobile" ).value;
	
	   if(mobile)
	   {
	       $.ajax({
			   type: 'post',
			   url: 'checkdata1.php',
			   data: {
			   mobile:mobile,
			   },
			   success: function (response) {
				   

		       if(response=="OK")	
               {
				  $( '#status' ).html(response);
                  return true;	
               }
               else
               {
				    $( '#status' ).html(response);
					//$('#mobile').val("");
                  return false;	
               }
             }
		   });


	    }
	    else
	    {
		   $( '#status' ).html("");
		   return false;
	    }
	
	}
</script>	