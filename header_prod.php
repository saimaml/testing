<?php 
	date_default_timezone_set('Asia/Calcutta');
	session_start();
	$session_id = session_id();
	include_once('config/config.php'); 
	include_once('config/constant.php'); 

	
	$sql_main_cat = "SELECT id,main_category FROM tbl_product_main_cat ORDER BY menu_order ASC";
	$result_main_cat = mysqli_query($con,$sql_main_cat);
	
	$sql_cart = "SELECT id FROM tbl_cart WHERE session_id = '$session_id'";
	$result_cart = mysqli_query($con,$sql_cart);
	$cart_count = mysqli_num_rows($result_cart);
	
	
	if(isset($_GET["cat_id"]))
	{		
		$cat_id = $_GET["cat_id"];
		
		$sql_meta = "SELECT meta_title,meta_desc FROM tbl_product_category WHERE id = '$cat_id'";
		$result_meta = mysqli_query($con,$sql_meta);
		$row_meta = mysqli_fetch_array($result_meta); 
		
		$sql_cat = "SELECT c.id as sub_id,m.id as main_id, c.catogories_name, m.main_category FROM tbl_product_category as c,tbl_product_main_cat as m WHERE c.id = '$cat_id' and c.main_id = m.id ";
		$result_cat = mysqli_query($con,$sql_cat);
		$row_cat = mysqli_fetch_array($result_cat);
		
		$sql_product = "SELECT id,plan_name,image,rate FROM tbl_service_plans WHERE category_id = '$cat_id' LIMIT 12";
		$result_product = mysqli_query($con,$sql_product);
	}
	elseif(isset($_REQUEST["id"]))
	{
		$main_id = $_REQUEST["id"];	
		
		$sql_meta = "SELECT meta_title,meta_desc FROM tbl_product_main_cat WHERE id = '$main_id'";	
		$result_meta = mysqli_query($con,$sql_meta);
		$row_meta = mysqli_fetch_array($result_meta); 
		
		$sql_cat = "SELECT c.id as sub_id,m.id as main_id,c.catogories_name,m.main_category FROM tbl_product_category as c,tbl_product_main_cat as m WHERE m.id = '$main_id' and c.main_id = m.id ";
		$result_cat = mysqli_query($con,$sql_cat);
		$row_cat = mysqli_fetch_array($result_cat);
		
		$sql_product = "SELECT id,plan_name,image,rate FROM tbl_service_plans WHERE main_category_id = '$main_id' ";
		$result_product = mysqli_query($con,$sql_product);
	}
	elseif(isset($_GET["weight"]))
	{
		$weight = $_GET["weight"];
		
		$sql_product = "SELECT a.product_id,p.plan_name FROM tbl_product_attribute as a,tbl_service_plans as p WHERE a.weight_id = '$weight' and a.product_id = p.id ";
			
		$result_product = mysqli_query($con,$sql_product);
	}
	
	else
	{			
		$sql_product = "SELECT id,plan_name,image,rate FROM tbl_service_plans LIMIT 12";
		$result_product = mysqli_query($con,$sql_product);		
	}	
	
	
	
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
			$result =mysql_query($sql);
			
			$user_id = mysql_insert_id();
			$_SESSION['user_id'] = $user_id;
			$_SESSION['login'] = "1";
			
			$sql_update= "UPDATE tbl_cart SET user_id = '".$user_id."' WHERE session_id = '".$session_id."'";
			$result_update =mysql_query($sql_update);								
			
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
		}		function clean($string) 		{			$string = str_replace(' ', '-', $string); 			$string = preg_replace("/[^A-Za-z0-9\-]/", '', $string); 			return preg_replace('/-+/', '-', $string); 		} 		 
?>
<!DOCTYPE html>
<html lang="en">    
<!-- Mirrored from zozothemes.com/html/layer/new-variants/image-bg/demo3/blog-left-sidebar.html by HTTrack Website Copier/3.x [XR&CO'2005], Mon, 17 Oct 2016 09:39:43 GMT -->
<head>   
     <!-- Title and Meta Tags Begins -->       
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />   
	<meta charset="utf-8"> 
	<!--[if IE]> <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>  <![endif]-->
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />   
	<meta name="title" content="<?php echo $row_meta['meta_title']; ?>">
	<meta name="description" content="<?php echo $row_meta['meta_desc']; ?>">
   

    
 <title>Discover My Pet</title>        <link rel="shortcut icon" href="<?php echo URL ?>images/favicon.png">      
 <!-- Title and Meta Tags Ends -->        <!-- Google Font Begins -->	     
<style>
.thumbnail {
    position:relative;
    overflow:hidden;
}
 
.caption {
    position:absolute;
    top:0;
    right:0;
    background:rgba(66, 139, 202, 0.75);
    width:100%;
    height:100%;
    padding:2%;
    display: none;
    text-align:center;
    color:#fff !important;
    z-index:2;
}
.dropdown-menu .divider {
    background-color: #000;
	}
</style>

<script>
$(document).ready(function() {
    $("[rel='tooltip']").tooltip();    
 
    $('.thumbnail').hover(
        function(){
            $(this).find('.caption').slideDown(250); //.fadeIn(250)
        },
        function(){
            $(this).find('.caption').slideUp(250); //.fadeOut(205)
        }
    ); 
});

</script> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> 
 <script type="text/javascript" src="<?php echo URL ?>js/codex-fly.js"></script> 
 <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700italic,700,900,900italic' rel='stylesheet' type='text/css'/>  
 <link href='http://fonts.googleapis.com/css?family=Raleway:400,700,600,500,300,200,100,800,900' rel='stylesheet' type='text/css'/>   
 <!-- Google Font Ends -->		        <!-- CSS Begins-->	     
 <link href='../../../../../../netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'/>    
 <link href="<?php echo URL ?>css/flaticon.css" rel="stylesheet" type="text/css" />    
 <link href="<?php echo URL ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
 <link href="<?php echo URL ?>css/portfolio.css" rel="stylesheet" type="text/css" />     
 <link href="<?php echo URL ?>css/animate.min.css" rel="stylesheet" type="text/css"/> 
 <link href="<?php echo URL ?>css/prettyPhoto.css" rel="stylesheet" type="text/css" />  
 <link href="<?php echo URL ?>css/flexslider.css" rel="stylesheet" type="text/css" />  
 <link href="<?php echo URL ?>css/tweet-carousel.css" rel="stylesheet" type="text/css" />  
 <link rel="stylesheet" href="<?php echo URL ?>css/simpletextrotator.css">  
	
 <!-- Main Style -->    
 <link href="<?php echo URL ?>css/style.css" rel="stylesheet" type="text/css" />    
 <link href="<?php echo URL ?>css/responsive.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>
 <!-- Color Panel -->
 <link href="<?php echo URL ?>css/color_panel.css" rel="stylesheet" type="text/css" /> 
 <!-- Skin Colors --> 

  
<link href="<?php echo URL ?>css/color-schemes/red.css" id="changeable-colors" rel="stylesheet" type="text/css" />  
<link href="<?php echo URL ?>magiczoomplus/magiczoomplus.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo URL ?>css/model.css" rel="stylesheet" type="text/css"> 
<script src="<?php echo URL ?>magiczoomplus/magiczoomplus.js" type="text/javascript"></script>	
  <style>
@import url(http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css);
.col-item
{
    border: 1px solid #E1E1E1;
    border-radius: 5px;
    background: #FFF;
}
.related{
font-size: 16px !important;
}
.col-item .photo img
{
    margin: 0 auto;
    width: 100%;
}
.productdetails
{
padding:0% 0% 4%;
}
.h6, h6 {
  
    font-weight: bold;
}
.brand1 {
    padding-bottom:0px;
    padding-left: 0;
    padding-right: 0;
    padding-top: 18px;
}
.img-icon {
    float: right;
    margin-bottom: 10px;
    margin-left: 0;
    margin-right: 0;
    margin-top: 10px;
    max-height: 170px;
    overflow-x: auto;
    overflow-y: auto;
    padding-bottom: 0;
    padding-left: 0;
    padding-right: 0;
    padding-top: 0;
    width: 100%;
}

.col-item .info
{
    padding: 10px;
    border-radius: 0 0 5px 5px;
    margin-top: 1px;
}

.col-item:hover .info {
    background-color: #F5F5DC;
}
.col-item .price
{
    /*width: 50%;*/
    float: left;
    margin-top: 5px;
}

.col-item .price h5
{
    line-height: 20px;
    margin: 0;
}

.price-text-color
{
    color: #219FD1;
}

.col-item .info .rating
{
    color: #777;
}

.col-item .rating
{
    /*width: 50%;*/
    float: left;
    font-size:8px;
    text-align: right;
    line-height: 52px;
    margin-bottom: 10px;
    height: 52px;
}

.col-item .separator
{
    border-top: 1px solid #E1E1E1;
}

.clear-left
{
    clear: left;
}

.col-item .separator p
{
    line-height: 20px;
    margin-bottom: 0;
    margin-top: 10px;
    text-align: center;
}

.col-item .separator p i
{
    margin-right: 5px;
}
.col-item .btn-add
{
    width: 50%;
    float: left;
}

.col-item .btn-add
{
    border-right: 1px solid #E1E1E1;
}

.col-item .btn-details
{
    width: 50%;
    float: left;
    padding-left: 10px;
}
.controls
{
    margin-top: 20px;
}
[data-slide="prev"]
{
    margin-right: 10px;
}
/***Mega DropDown***/
.dropdown-header >li a
{
	font-size: 14px !important;
}

.navbar-nav>li>.dropdown-menu {
  margin:-2% 20px !important;
  width:90%;
 /*  border-top-left-radius: 4px;
  border-top-right-radius: 4px;*/
  
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
 
 </head> 
 <body id="home">    
 <header>     <!-- Header Begins -->
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
 <a href="home.php" class="navbar-brand"><img src="<?php echo URL ?>images/dmp_logo_new_bold200.png" alt="Layer App Landing Page"></a>  
 </div>                    <!-- End Navigation Bar -->                    <!-- Navigation Menu -->    
 <nav id="topnav" role="navigation" class="collapse navbar-collapse bs-navbar-collapse">       
 <ul class="nav navbar-nav navbar-right">     
<li><a href="<?php echo WEb_URL ?>home" class="scroll">Home </a></li>        
 <!--<li><a href="product.php" class="scroll">Buy Products</a></li> -->   
 <li class="dropdown mega-dropdown">
          <a href="product.php" class="dropdown-toggle" data-toggle="dropdown">Buy Products <i class="fa fa-angle-down"></i></a>

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
               <li class="dropdown-header"><a style="color: #e74c3c;font-family: arial;font-weight: bold;" href="<?php echo WEb_URL ?><?php echo $main_cat; ?>/<?php echo $row_main_cat["id"]; ?>/product"><?php echo $row_main_cat["main_category"]; ?></a></li>
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
    
 <li><a href="<?php echo WEb_URL ?>service-shop" class="scroll">Services</a></li>        
 
<li><a href="<?php echo WEb_URL ?>blog" class="scroll">Pet Story </a></li>  
<li class="dropdown">
<a data-delay="10" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false">
Community<i class="fa fa-angle-down"></i>  </a> 
<!-- DropDown Menu Begins -->   
<ul class="menulist dropdown-menu" style=" width:225px !important;">  
<li><a href="<?php echo WEb_URL ?>animal-activist" style="color:#666666;font-weight:500;">Animal Activists Stories</a></li>
<li><a href="<?php echo WEb_URL ?>dog-event" style="color:#666666;font-weight:500;">Dog Show</a></li>									
<!--<li><a href="<?php echo WEb_URL ?>breeder" style="color:#666666;font-weight:500;">Know Your Dog</a></li>	-->								
</ul>            
<!-- DropDown Menu Ends -->    
</li> 
   <?php if(isset($_SESSION['user_id'])){?>
								<li><a href="logout.php" class="scroll">Logout</a></li>
							<?php }else{?>
								<li><a href="#login_form">Login</a></li>
							<?php }?> 
<li><a href="<?php echo WEb_URL ?>shopping-cart.php?session_id=<?php echo $session_id;?>"><button type="button" class="btn btn-primary cart_anchor"><i class="fa fa-shopping-cart"></i> <span class="badge" id="total_quantity"><?php echo $cart_count; ?></span></button></a></li>
</ul>                    
 </nav>                    <!-- End Navigation Menu -->    
 </div>                <!-- End container -->           
 </div>        
 </header> 
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
								<label style="color:#000;"><input type="checkbox" checked> Remember me</label>
							</div>
					   <button type="submit" name="login" class="btn btn-primary col-md-12">Login</button>  
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
							<input type="mobile" class="form-control" id="mobile"  name="mobile" placeholder="Mobile Number" required onblur="checkmobile();">
							
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="city" name="city" placeholder="City" required>
						</div>
						<div class="form-group">
							<input type="email" class="form-control" id="email" name="email" placeholder="Email address" required onblur="checkemail();">
							
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