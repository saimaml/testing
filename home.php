<?php 
	$page = "home";
	include_once('header.php');
	
	$query = "UPDATE tbl_visit SET visit_count = visit_count + 1 WHERE page_name = 'Home'";
	$result_visit = mysqli_query($con,$query);
	$sql = "SELECT id,service_name,website_img FROM service_master WHERE id <> '2' and id <>'1' LIMIT 7";
	$result = mysqli_query($con,$sql);
	
	if (isset($_POST["submit"]))
	{	
		$mobile ="91".$_POST["mobile"];	
	
		if(!empty($mobile)) // phone number is not empty
		{
			if(preg_match('/^\d{12}$/',$mobile)) // phone number is valid
			{		
				$url = "https://play.google.com/store/apps/details?id=discovermypet.navitorhealthcare&hl=en";
				$user_msg =  urlencode("Dear Pet Owner, Download India's First Unique Pet APP 'Discover My Pet' & Experience the Powerful Innovation ".$url."."); 
				send_smss($user_msg, $mobile);		
				?>
				
				<script>			
					alert("SMS sent");					
				</script>
	<?php   }  
			else
			{  ?>
				<script>
				
				</script>
			<?php  }
		} 	
	}
function send_smss($user_msg, $mobile)
 {
	
	$sms_url = "http://smslane.com/vendorsms/pushsms.aspx?user=discovermypet&password=abcdefg@1234&msisdn=$mobile&sid=PETAPP&msg=$user_msg&fl=0&gwid=2";	
	
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$sms_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_exec($ch);
}  
?>

 
    <!--<link href="assets/css/custom.css" rel="stylesheet">-->

    <!-- Owl Carousel Assets -->
    <link href="<?php echo URL ?>owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo URL ?>owl-carousel/owl.theme.css" rel="stylesheet">

    <!-- Prettify -->
    <link href="<?php echo URL ?>assets/js/google-code-prettify/prettify.css" rel="stylesheet">
    

    <!-- Le fav and touch icons -->
   
 <style>
 .v-center {
  height: 100vh;
  width: 100%;
  display: table;
  position: relative;
  text-align: center;
}

.v-center > div {
  display: table-cell;
  vertical-align: middle;
  position: relative;
  top: -10%;
}



.modal-box {
  display: none;
  position: absolute;
  z-index: 1000;
  width: 98%;
  background: white;
  border-bottom: 1px solid #aaa;
  border-radius: 4px;
  box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
  border: 1px solid rgba(0, 0, 0, 0.1);
  background-clip: padding-box;
}
@media (min-width: 32em) {

.modal-box { width: 70%; }
}

.modal-box header,
.modal-box .modal-header {
  padding: 1.25em 1.5em;
  border-bottom: 1px solid #ddd;
}

.modal-box header h3,
.modal-box header h4,
.modal-box .modal-header h3,
.modal-box .modal-header h4 { margin: 0; }

.modal-box .modal-body { padding: 2em 1.5em; }

.modal-box footer,
.modal-box .modal-footer {
  padding: 1em;
  border-top: 1px solid #ddd;
  background: rgba(0, 0, 0, 0.02);
  text-align: right;
}

.modal-overlay {
  opacity: 0;
  filter: alpha(opacity=0);
  position: absolute;
  top: 0;
  left: 0;
  z-index: 900;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.3) !important;
}

a.close {
  line-height: 1;
  font-size: 1.5em;
  position: absolute;
  top: 5%;
  right: 2%;
  text-decoration: none;
  color: #bbb;
}

a.close:hover {
  color: #222;
  -webkit-transition: color 1s ease;
  -moz-transition: color 1s ease;
  transition: color 1s ease;
}
 
 
 .form-control
 {
	 height:60px !important;
 }
 .desc
 {
	 padding: 10px 0 15px !important;
 }
 .italic
 {
	 margin-left:12px;
	 line-height:1.5 !important;
 }
 </style>  

	 
<!-- HEADER END -->
    <!-- Subscribe Section Begins
	<div id="pageloader">
            <div class="loader-item fa fa-spin colored-border"></div>
        </div>   -->
			
			<!--<section id="product">
     <a href="product.php"> <div class="screenshots">
    <div class="bg-overlay pattern"></div>
	 <div class="container screenshots-inner">
	  <div class="row">
		<div class="col-md-12 text-center">
			
			<div class="title">
				<h2 style="color:#ffffff;"> Buy <span> Products </span></h2>
			</div>
			
			<p class="desc white">Fun Shopping for your Pets made complete easy. To help you take a better pet care, we are now there!</p>
		</div>
	</div>
	</div>
	</div></a>
   </section>-->	
  <!-- <section id="additional">
            <div class="additional-section">
                <div class="bg-overlay pattern"></div>
                <div class="container additional-inner">
                    
                    <div class="row">
                        <div class="col-md-12 text-center">
                          
                            <div class="title">
                                <h2> Best Selling Flea & Tick Control for  <span>Dogs & Cats</span></h2>
                            </div>
                            
                        </div>
                    </div><br><br><br>
                   
                    <div class="row">
                        <div class="col-md-3">
                            <div class="additional-features animated fadeInLeft visible" data-animation="fadeInLeft" data-animation-delay="300">
                                
                                <i><img src="images/image1med.jpg"></i>
                               
                                <div class="additional-content">
                                   <p>Revolution for Cats & Dogs </p>
								    <h5>From $37.95</h5>
									<a href="#" class="btn btn-primary btn-sm text-light">SHOP NOW</a>
                                </div>
                            </div>
                        </div>
                       <div class="col-md-3">
                            <div class="additional-features animated fadeInLeft visible" data-animation="fadeInLeft" data-animation-delay="300">
                              
                                <i><img src="images/image1med1.jpg"></i>
                               
                                <div class="additional-content">
                                   <p>Revolution for Cats & Dogs </p>
								    <h5>From $37.95</h5>
									<a href="#" class="btn btn-primary btn-sm text-light">SHOP NOW</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="additional-features animated fadeInLeft visible" data-animation="fadeInLeft" data-animation-delay="300">
                              
                                <i><img src="images/image1med12.jpg"></i>
                               
                                <div class="additional-content">
                                   <p>Revolution for Cats & Dogs </p>
								    <h5>From $37.95</h5>
									<a href="#" class="btn btn-primary btn-sm text-light">SHOP NOW</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="additional-features animated fadeInLeft visible" data-animation="fadeInLeft" data-animation-delay="300">
                               
                                <i><img src="images/image1med13.jpg"></i>
                                
                                <div class="additional-content">
                                   <p>Revolution for Cats & Dogs </p>
								    <h5>From $37.95</h5>
									<a href="#" class="btn btn-primary btn-sm text-light">SHOP NOW</a>
                                </div>
                            </div>
                        </div>
                    </div>
					
                   
                 
                </div>
            </div>
        </section>-->
				<section id="price-table" class="price-table">
		 <div class="container additional-inner">
		  <div class="row">
                        <div class="col-md-12 text-center">
                            <!-- Title --> 
                            <div class="title">
                                <h2>Buy <span>Pet Products</span></h2>
                            </div>
                            <!-- Description --> 
                            <!--<p class="desc white">We ensure quality &amp; support. People love us &amp; we love them. Here goes some simple dummy text.</p>-->
                        </div>
                    </div>
		   <div class="demo">
        <div class="container">
          <div class="row">
            <div class="span12">
              <div class="owl-demo" class="owl-carousel">
			  <?php $sql_main_cat = "SELECT id,main_category,menu_img FROM tbl_product_main_cat LIMIT 12";
					$result_main_cat = mysqli_query($con,$sql_main_cat);
					while($row_main_cat = mysqli_fetch_array($result_main_cat))
					{  ?>
						 <div class="item">
				<div class="col-sm-12">
                            <div class="col-item">                               
                                    <img src="<?php echo $row_main_cat["menu_img"]; ?>" class="img-responsive" alt="a">
                                <div class="info scroolingtitle">                                    
                                        <div class="price col-md-12">
                                            <h4 class="related"><?php echo $row_main_cat["main_category"]; ?></h4>
                                        </div>                                   
                                    <div class="separator clear-left col-md-12">
                                        <p class="btn-details">
                                            <a href="product.php?main_id=<?php echo $row_main_cat["id"]; ?>" class="btn btn-primary btn-sm text-light">EXPLORE</a></p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                        </div>				
				</div>
				<?php	}  ?>                 
              </div>
            </div>
          </div>
        </div>
		</div> 
	</div>		
</section>
	 <div class="container additional-inner">
		  <div class="row">
                        <div class="col-md-12 text-center">
                            <!-- Title --> 
                            <div class="title">
                               <h2>Best Selling Products for  <span>Dogs & Cats</span></h2>
                            </div>
                            <!-- Description --> 
                            <!--<p class="desc white">We ensure quality &amp; support. People love us &amp; we love them. Here goes some simple dummy text.</p>-->
                        </div>
                    </div>
		   <div id="demo">
        <div class="container">
          <div class="row">
            <div class="span12">
              <div class="owl-demo" class="owl-carousel">
			  <?php $sql_product = "SELECT id,plan_name,image FROM tbl_service_plans WHERE top_selling_act ='1' LIMIT 16";
					$result_product = mysqli_query($con,$sql_product);
					while($row_product = mysqli_fetch_array($result_product))
					{  $img = explode(",",$row_product["image"]);
						?> 
				<div class="item">
				<div class="col-sm-12">
					<div class="col-item">                               
							<img src="<?php echo $img[0]; ?>" class="img-responsive" alt="a"/>
						<div class="info scroolingtitle">                                    
								<div class="price col-md-12">
									<h4 class="related"><?php echo substr($row_product["plan_name"],0,30); ?></h4>
								</div>                                   
							<div class="separator clear-left col-md-12">
								<p class="btn-details">
									<a href="productdetails.php?id=<?php echo $row_product["id"]; ?>" class="btn btn-primary btn-sm text-light">Buy Now</a></p>
							</div>
							<div class="clearfix">
							</div>
						</div>
					</div>
				</div>				
				</div>
				<?php	}  ?>                 
              </div>
            </div>
          </div>
        </div>
		</div> 
	</div>
		<div class="col-md-12 text-center">
                            <!-- Title --> 
                            <div class="title">
                                <h2>Introductory Video To <span>Discover My Pet&trade;</span></h2>
                            </div>
                            <!-- Description --> 
                            <!--<p class="desc white">We ensure quality &amp; support. People love us &amp; we love them. Here goes some simple dummy text.</p>-->
                        </div>
			<div style="background-position: 0px 6.84px;" class="staff" data-stellar-background-ratio=".3">
				<div class="container">
					<div class="row">
					
						<div class="col-md-8 col-md-offset-2">
							<div class="">
							<iframe src="https://player.vimeo.com/video/189284667" width="100%" height="500" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
								<!--<iframe src="https://player.vimeo.com/video/189109822" width="100%" height="500" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>-->
							<!--<p><a href="https://vimeo.com/189109822">Discover My Pet</a> from <a href="https://vimeo.com/user58352114">Discover My Pet</a> on <a href="https://vimeo.com">Vimeo</a>.</p>-->
							</div>
						</div>
					</div>
				</div>
			</div>
		<br>
	
		     <section id="features">
            <div  class="features-section">
                <div class="bg-overlay pattern"></div>
                <div class="container features-inner" style="max-height:910px;">
                    <!-- Title & Desc Row Begins -->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <!-- Title --> 
                            <div class="title">
                                <h2> App <span>Highlights</span></h2>
                            </div>
                            <!-- Description --> 
                            <p class="desc white">Explore & experience unique features and ways to care for your pet through your own “Discover My Pet App &trade;”.</p>
                        </div>
                    </div>
                    <!-- Title & Desc Row Ends -->
                    <div class="row">
                        <!-- FEATURES LEFT -->
                        <div class="col-md-4 col-sm-6 col-xs-12 mobile">
                            <ul class="features-list features-list-left">
                                 <li class="features-list-item animated" data-animation="fadeInLeft" data-animation-delay="500">
									<!-- Icon -->
                                  <i>  <img style="border-radius:50%;" src="<?php echo URL ?>images/app_menu/my_info_painting.png"/></i>
                                    <div class="features-content">
										<!-- Title -->
                                        <h5>My Info</h5> 
										<!-- Text -->
                                        <p class="italic">Add up | Edit | Experience unique services</p>
                                    </div>
                                </li>                            
                               <li class="features-list-item animated" data-animation="fadeInLeft" data-animation-delay="1100">
									<!-- Icon -->
                                   <i>  <img style="border-radius:50%;" src="<?php echo URL ?>images/app_menu/5_buy_product_50.png"/></i>
                                    <div class="features-content">
										<!-- Title -->
                                        <h5>Buy Products</h5>
										<!-- Text -->
                                        <p class="italic"> Range of Products | Order | Cherish !</p>
                                    </div>
                                </li>
								<li class="features-list-item animated" data-animation="fadeInLeft" data-animation-delay="800">
									<!-- Icon -->
                                    <i>  <img style="border-radius:50%;" src="<?php echo URL ?>images/app_menu/3_health_record_70.png"/></i>
                                    <div class="features-content">
										<!-- Title -->
                                        <h5>Digital Health Record</h5>
										<!-- Text -->
                                        <p class="italic">Vaccination | Parasite Prevention | Deworming  </p>
                                    </div>
                                </li>
								<li class="features-list-item animated" data-animation="fadeInLeft" data-animation-delay="800">
									<!-- Icon -->
                                    <i>  <img style="border-radius:50%;" src="<?php echo URL ?>images/app_menu/bell.png"/></i>
                                    <div class="features-content">
										<!-- Title -->
                                        <h5>Reminder Services</h5>
										<!-- Text -->
                                        <p class="italic">Alerts | Reminder services | Fix appointments | Better Pet Health</p>
                                    </div>
                                </li>
								<li class="features-list-item animated" data-animation="fadeInLeft" data-animation-delay="800">
									<!-- Icon -->
                                    <i>  <img style="border-radius:50%;" src="<?php echo URL ?>images/app_menu/v-doctor-final70.png"/></i>
                                    <div class="features-content">
										<!-- Title -->
                                        <h5>Find a vet</h5>
										<!-- Text -->
                                        <p class="italic">Instant Healthcare Search | Geolocation with Google | Reach to Vets in your city </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- FEATURES RIGHT -->
                        <div class="col-md-4 col-md-push-4 col-sm-6 col-xs-12 mobile">
                            <ul class="features-list features-list-right">
                               <li class="features-list-item animated" data-animation="fadeInRight" data-animation-delay="500">
									<!-- Icon -->
                                    <i>  <img style="border-radius:50%;" src="<?php echo URL ?>images/app_menu/2_add_new_pet_70.png"/></i>
                                    <div class="features-content">
										<!-- Title -->
                                        <h5>Add My Pet</h5>
										<!-- Text -->
                                        <p class="italic">Add Pet | Select the breed | Launch your Pet online | Pet's own community</p>
                                    </div>
                                </li>
								<li class="features-list-item animated" data-animation="fadeInRight" data-animation-delay="800">
									<!-- Icon -->
                                   <i> <img style="border-radius:50%;" src="<?php echo URL ?>images/app_menu/4_pet_service_finder_70.png"/></i>
                                    <div class="features-content">
										<!-- Title -->
                                        <h5>Explore Services</h5>
										<!-- Text -->
                                        <p class="italic">Care for your Pet | Uniquely-designed Home services | Cherish companionship </p>
                                    </div>
                                </li>
                              <li class="features-list-item animated" data-animation="fadeInRight" data-animation-delay="1100">
									<!-- Icon -->
                                    <i>  <img style="border-radius:50%;" src="<?php echo URL ?>images/app_menu/Puppy-(3).png"/></i>
                                    <div class="features-content">
										<!-- Title -->
                                        <h5>Pet social Network</h5>
										<!-- Text -->
                                        <p class="italic">Connect | Communicate  | Collaborate <br/> with Pet Owners in your city</span></p>
                                    </div>
                                </li> 
								<li class="features-list-item animated" data-animation="fadeInRight" data-animation-delay="1100">
									<!-- Icon -->
                                    <i>  <img style="border-radius:50%;" src="<?php echo URL ?>images/app_menu/8_dog_walk.png"/></i>
                                    <div class="features-content">
										<!-- Title -->
                                        <h5>Dog Walk Navigator</h5>
										<!-- Text -->
                                        <p class="italic">Wellness | Fitness  | Digital Display </p>
                                    </div>
                                </li>
								<li class="features-list-item animated" data-animation="fadeInRight" data-animation-delay="1100">
									<!-- Icon -->
                                    <i>  <img style="border-radius:50%;" src="<?php echo URL ?>images/app_menu/transaction-history.png"/></i>
                                    <div class="features-content">
										<!-- Title -->
                                        <h5>Transaction History</h5>
										<!-- Text -->
                                        <p class="italic">Check transactions status | Complete ease | Online Shopping | </span></p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- CLOSE UP PHONE IMAGE -->
                        <div class="col-md-4 hidden-xs col-md-pull-4 app-image animated" data-animation="fadeInUp" data-animation-delay="800">
                            <img height="820" src="<?php echo URL ?>images/app-highlight-new.png" alt="" >
                        </div>
                    </div>
                </div>
            </div>
        </section>
		 <section id="screenshots">
            <div class="screenshots">
              <!--  <div class="bg-overlay pattern"></div>-->
                <div class="container screenshots-inner">
                    <!-- Title & Desc Row Begins -->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <!-- Title --> 
                            <div class="title">
                                <h2> Pet <span> Application Screenshots</span></h2>
                            </div>
                            <!-- Description --> 
                            <!--<p class="desc white">We ensure quality & support. People love us & we love them. Here goes some simple dummy text.</p>-->
                        </div>
                    </div>
                    <!-- Title & Desc Row Ends -->					
                    <!-- Screenshots List -->
					<div id="slider1">
						<a class="buttons prev" href="#">&#60;</a>
						<div class="viewport">
							<ul class="overview">
								<li>   <img src="<?php echo URL ?>images/screens/Introduction1.png" alt="" class="" />  </li>
								<li>   <img src="<?php echo URL ?>images/screens/Introduction2.png" alt="" class="" />  </li>
								<li>   <img src="<?php echo URL ?>images/screens/Introduction3.png" alt="" class="" />  </li>
								<li>  <img src="<?php echo URL ?>images/screens/Introduction4.png" alt="" class="" />  </li>
								<li>   <img src="<?php echo URL ?>images/screens/Introduction5.png" alt="" class="" />  </li>
								<li>   <img src="<?php echo URL ?>images/screens/Introduction6.png" alt="" class="" />  </li>
								<li>   <img src="<?php echo URL ?>images/screens/Introduction7.png" alt="" class="" />  </li>
								<li>   <img src="<?php echo URL ?>images/screens/Introduction8.png" alt="" class="" />  </li>
								<li>   <img src="<?php echo URL ?>images/screens/Introduction9.png" alt="" class="" />  </li>
								<li>   <img src="<?php echo URL ?>images/screens/Introduction10.png" alt="" class="" />  </li>
								<li>   <img src="<?php echo URL ?>images/screens/Introduction11.png" alt="" class="" />  </li>
								<li>   <img src="<?php echo URL ?>images/screens/Introduction12.png" alt="" class="" />  </li>
								<li>   <img src="<?php echo URL ?>images/screens/Introduction13.jpg" alt="" class="" />  </li>
							
							</ul>
						</div>
						<a class="buttons next" href="#">&#62;</a>
					</div>	
						
                    <!-- End Screenshots List-->
					
                </div>
            </div>

        </section>    

<!--<section id="price-table" class="price-table">-->
			
<!--</section>-->
   
<!-- Buy Product End -->

	<link rel="stylesheet" href="<?php echo URL ?>css/tinycarousel.css" type="text/css" media="screen"/>
	<script type="text/javascript" src="<?php echo URL ?>js/jquery.tinycarousel.js"></script>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$('#slider1').tinycarousel();
		});
	</script>
	
	     <section id="subscribe">
            <div class="subscribe">
                <!--<div class="bg-overlay pattern"></div>-->
                <div class="container subscribe-inner">
                    <!-- Title & Desc Row Begins -->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <!-- Title -->
                            <div class="title">
                                <h2> Download Your <span> App</span></h2>
                            </div>                            
                            <p class="desc">Be a part of pet innovation</p>
                        </div> 
                    </div>
                    <!-- Title & Desc Row Ends -->
                    <!-- Subscribe Row Begins -->
                   <div class="row">
                        <div class="col-md-6 col-md-offset-3 animated" data-animation="fadeInUp" data-animation-delay="300">
                            <p class="form-message1" style="display: none;"></p>
                            <div class="contact-form">
                                <!-- Form Begins- -->
                               <form method="POST" action="#" id="form-id">
							    <div class="form-group subscribe-form-input"> 
							    <input type="text" class="subscribe-form-email form-control form-control-lg" placeholder="Enter your phone number" name="mobile"/> 
							</div>	
						 
									  
							<input type="submit" name="submit" class="subscribe-form-submit js-open-modal btn bg-inverse btn-lg" id="show" value="Get app">
						   </form>
                            </div>
                        </div>
                       </div>
						<div id="send" style="display:none;"><p>SMS sent on your mobile</p></div>					   
					   
						 <div class="row">
							<div class="col-md-12 download-app-btns">
								<span class="ios">
								 <a href="#" title="DMP IOS App" data-toggle="popover" data-trigger="hover" data-content="COMMING SOON.."><img src="<?php echo URL ?>images/app_store.png" class="center-img"></a>
							<script>
							$(document).ready(function(){
								$('[data-toggle="popover"]').popover();   
							});
							</script>
								 <!-- <a target="_blank" class="ios_link" href="#" data-toggle="tooltip" title="Comming Soon!">
									<img src="images/app_store.png" class="center-img">
								  </a>-->
								</span>
								
								
								<span class="android">
								  <a target="_blank" class="android_link" href="https://play.google.com/store/apps/details?id=discovermypet.navitorhealthcare&hl=en">
									<img src="<?php echo URL ?>images/google-play-store.png" class="center-img">
								  </a>
								</span>
								<!-- <p class="desc">Coming soon.</p>-->
							</div>
						 </div>						
                    </div>
                    <!-- Subscribe Row Ends -->
                </div>
            </div>
        </section>   
		


<!--<section id="pet_shop">
	<a href="service.php?id=1">
		<div class="additional-section">
			<div class="bg-overlay pattern"></div>
			<div class="container additional-inner">
				
				<div class="row">
					<div class="col-md-12 text-center">
						
						<div class="title">
							<h2> Find Pet Shop  <span>In your Area</span></h2>
						</div>
						
						 <p class="page-scroll">
						<a href="service-shop.php" class="btn slide-btn bg-inverse">Click Here</a>
						</p>
						
					</div>
				</div>
				       
			 
			</div>
		</div>
	</a>
 </section>   -->       
        <!-- Demo Video Section 
        <section id="demo-video">
            <div  class="demo-video">
                <div class="bg-overlay pattern"></div>
                <div class="container demo-video-inner text-center">
                    <!-- Title & Desc Row Begins 
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <!-- Title > 
                            <div class="title">
                                <h2> Pet <span>Video</span></h2>
                            </div>
                            <!-- Description  
                            <p class="desc white">Check out this funny guilty compilation video of funny dogs and puppies. Enjoy this video.</p>
                        </div>
                    </div>
                    <!-- Title & Desc Row Ends 
                    <div class="video_bg  animated" data-animated="fadeInUp" data-animation-delay="200">
                        <iframe src="https://www.youtube.com/embed/wsgsQ_1QFBs " width="540" height="305"></iframe>				
                    </div>
                </div>
            </div>
        </section>
        <!-- End Demo Video Section -->
			
		<!-- Counting Section Begins -->
        <section id="counting" class="counting">
           <div class="container counting-inner">
                <!-- Counting Row Begins -->
                <div class="row counting-box title-row animated" data-animation="fadeInUp" data-animation-delay="400">
                    <!-- Counting Box 1 Begins -->
                    <div class="col-md-4 col-sm-4 text-center">
                        <!-- Icon -->
                        <i class="fa fa-cloud-download fa-3x"></i>
                        <!-- Title -->
                        <h3 class="normal">Downloads</h3>
                        <!-- Count Number -->
                        <div class="fact-number" data-perc="1427">
                            <div class="factor"></div>
                        </div>
                    </div>
                    <!-- Counting Table 1 Ends -->
                    <!-- Counting Table 2 Begins --> 
                    <div class="col-md-4 col-sm-4 text-center animated" data-animation="fadeInUp" data-animation-delay="400">
                        <!-- Icon -->
                        <i class="fa fa-shield fa-3x"></i>
                        <!-- Title -->
                        <h3 class="normal">Service Providers</h3>
                        <!-- Count Number -->
                        <div class="fact-number" data-perc="149">
                            <div class="factor"></div>
                        </div>
                    </div>
                    <!-- Counting Table 2 Ends -->
                    <!-- Counting Table 3 Begins --> 
                    <div class="col-md-4 col-sm-4 text-center animated" data-animation="fadeInUp" data-animation-delay="400">
                        <!-- Icon -->
                        <i class="fa fa-thumbs-o-up fa-3x"></i>
                        <!-- Title -->
                        <h3 class="normal">Likes</h3>
                        <!-- Count Number -->
                        <div class="fact-number" data-perc="1865">
                            <div class="factor"></div>
                        </div>
                    </div>
                    <!-- Counting Table 3 Ends -->
                    <!-- Counting Table 4 Ends -->								
                </div>
                <!-- Couting Row Ends -->
            </div>
            <!-- Container Ends -->			
        </section>
        <!-- Counting Section Ends -->	

  <!-- FOOTER -->
    <script src="<?php echo URL ?>owl-carousel/owl.carousel.js"></script>
    <style>
    .owl-demo .item{
        margin: 3px;
    }
    .owl-demo .item img{
        display: block;
        width: 100%;
        height: auto;
    }
    </style>


    <script>
    $(document).ready(function() {

      $(".owl-demo").owlCarousel({
        items : 4,
        lazyLoad : true,
        navigation : true
      });

    });
    </script>


<script src="<?php echo URL ?>assets/js/google-code-prettify/prettify.js"></script>
<script src="<?php echo URL ?>assets/js/application.js"></script>

<a href="#x" class="overlay" id="sms_form"></a>
      <div class="popup">
							
				<div class="container">
					<ul class="nav nav-tabs">
					
						<li class="active"><a href="#login" data-toggle="tab">SMS SENT </a></li>
					</ul>
					<div class="tab-content">				
						<div class="tab-pane active" id="login">
						   <form action="" method="POST" role="form">
						 
							 
						
					
					   <!--<a href = "email.php">Forgot password</a>-->
						<a class="close" href="#close"></a>  
						</form>
				</div>	

			</div><!-- tab content -->
			</div><!-- end of container -->		
					
						
	</div>
	
	
	<!-- BEGIN # MODAL LOGIN -->
<div class="modal fade" id="sms-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    	<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" align="center" style="background-color:#E74C3C;">
					<h3 style="color:#fff;font-weight:bold;">SENT SMS</h3>
				</div>
                
                <!-- Begin # DIV Form -->
                <div id="div-forms">
                
                    <!-- Begin # Login Form -->
                    <form id="login-form">
		                <div class="modal-body">
				    		
				    		<p class="center desc" id="sms_sent">We have sent you a SMS with download link.</p>
                          
        		    	</div>
				       
                    </form>
                    <!-- End # Login Form -->
                    
                  
                    
                </div>
                <!-- End # DIV Form -->
                
			</div>
		</div>
	</div>

	<?php include_once('footer.php'); ?>

	
 
<!-- FOOTER END -->