<?php 	
	include_once('header_prod.php');
	$sql_main_cat_side = "SELECT id,main_category FROM tbl_product_main_cat";
	$result_main_cat_side = mysqli_query($con,$sql_main_cat_side);	
	
	$sql_weight = "SELECT id,weight_name,weight_range FROM tbl_pet_weight";
	$result_weight = mysqli_query($con,$sql_weight);
	
	
	 
?>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<style>
.list-group-item-success {
    background-color:#E74C3C !important;
   }

.list-group-item {
    padding-bottom: 5px !important;
    padding-top: 5px !important;
}
.list-group.panel > .list-group-item {
  border-bottom-right-radius: 0px;
  border-bottom-left-radius:0px
}
.list-group-submenu {
  margin-left:20px;
}
.list-group-item.list-group-item-success
{
  background-color: #e74c3c;
  color:#fff !important;
  font-weight:bold;
  
}
.list-group-item-success:hover
{
	 background-color: #000 !important;
}
.carousel-caption {
    left: 30%;
    padding-bottom: 0;
    right: 30%;
}
.menu_bg {
    background-image: url("https://www.woofbnb.com/woofshop/skin/frontend/woofbnb/default/images/Bg_Image.png");
    border-bottom-color: #ddd;
    border-bottom-style: solid;
    border-bottom-width: 1px;
    padding-bottom: 0 !important;
    padding-top: 0 !important;
}
</style>
<br/>
	<div class="row">         
			
		<div id="myCarousel" class="carousel slide" data-ride="carousel"> 
  <!-- Indicators -->
  
 <!-- <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>-->
  <div class="carousel-inner">
    <div class="item active"> <img src="https://www.woofbnb.com/woofshop/media/mbimages/b/a/banner_1_1.png" style="width:100%" alt="First slide">
      <div class="container">
        <div class="carousel-caption">
         <!-- <h1>Slide 1</h1>
          <p style="background-color: rgb(0, 0, 0); opacity: 0.56;">Aenean a rutrum nulla. Vestibulum a arcu at nisi tristique pretium.</p>-->
          <!--<p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>-->
        </div>
      </div>
    </div>
    <div class="item"> <img src="https://www.woofbnb.com/woofshop/media/mbimages/s/3/s3.png" style="width:100%" data-src="" alt="Second    slide">
      <div class="container">
        <div class="carousel-caption">
          <!--<h1>Slide 2</h1>
          <p style="background-color: rgb(0, 0, 0); opacity: 0.56;">Lorem ipsum dolor sit amet, consectetur adipiscing elit.  </p>-->
          <!--<p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>-->
        </div>
      </div>
    </div>
    <div class="item"> <img src="https://www.woofbnb.com/woofshop/media/mbimages/s/l/slider.png" style="width:100%" data-src="" alt="Third slide">
      <div class="container">
        <div class="carousel-caption">
          <!--<h1>Slide 3</h1>
          <p style="background-color: rgb(0, 0, 0); opacity: 0.56;">Donec sit amet mi imperdiet mauris viverra accumsan ut at libero.</p>-->
          <!--<p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>-->
        </div>
      </div>
    </div>
  </div>
  <!--<a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>--> </div>
			</div>
			<br/>
		 
 <!-- Header Ends -->        <!-- Blog Begins -->        
<section id="blog-outer" class="blog-outer menu_bg">  
	<div class="container">   <!-- Title & Desc Row Begins -->        
	
		<div class="welcome-inner">             
		<div class="row">
			<div class="col-md-12">
			
				<ul class="breadcrumb" style="margin-bottom:15px;">
					<li><a href="<?php echo WEb_URL ?>home.php"><i class="glyphicon glyphicon-home"></i></a></li>
					<?php if(isset($_GET["cat_id"]) OR isset($_REQUEST["id"]))
					{  	?>
					<li><a href="<?php echo WEb_URL ?>product.php">Products</a></li>
					<li><a href="<?php echo WEb_URL ?>product.php?main_id=<?php echo $row_cat["main_id"]; ?>"><?php echo $row_cat["main_category"]; ?></a></li>
					<li class="active"><?php echo $row_cat["catogories_name"]; ?></li>
					<?php }  else  	{  ?>
						<li>Products</li>
					
				<?php	}		?>
				</ul>
			</div><!-- Blog Left Part -->                    
			
			
		</div>
		</div>
		<!-- Title & Desc Row Ends -->               
		<div class="row">       
			<div class="col-md-3">        <!-- Blog Left Part Begins -->        
			<div class="input-group">
				<div class="input-group-btn search-panel">
					<!--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span id="search_concept">Search </span> 
					</button>	-->				
				</div>
				        
				<input type="text" class="form-control search_product" id="product_name" name="name" placeholder="Search term...">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="select_pro();"><span class="fa fa-1x fa-search" style="color:#000;"></span></button>
				</span>
			</div>        
	
			
				<div class="sidebar">                
					<div class="panel panel-default border-hidden categories animated fadeInUp visible" data-animation="fadeInUp" data-animation-delay="300"> 
						<h4>Categories</h4>
						<div id="MainMenu">
  <div class="list-group panel">
   
	<?php while($row_main_cat_side = mysqli_fetch_array($result_main_cat_side))	{
		$main_cat = clean(strtolower($row_main_cat_side["main_category"]));
		$sql_sub_cat_side = "SELECT id,catogories_name FROM tbl_product_category WHERE main_id = '".$row_main_cat_side['id']."'";
		$result_sub_cat_side = mysqli_query($con,$sql_sub_cat_side);						

	?>
    <a href="#demo<?php echo $row_main_cat_side["id"]; ?>" class="list-group-item list-group-item-success" data-toggle="collapse" data-parent="#MainMenu"><?php echo $row_main_cat_side["main_category"]; ?> </a>
	
	<?php if($row_cat["main_id"] ==$row_main_cat_side["id"])
	{  ?>
		 <div class="collapse in" id="demo<?php echo $row_main_cat_side["id"]; ?>">
		<?php while($row_sub_cat_side = mysqli_fetch_array($result_sub_cat_side))
		{   $sub_cat = clean(strtolower($row_sub_cat_side["catogories_name"]));
	?>
			<a href="<?php echo WEb_URL ?><?php echo $main_cat; ?>/<?php echo $sub_cat; ?>/<?php echo $row_sub_cat_side["id"]; ?>/product" class="list-group-item"><?php echo $row_sub_cat_side["catogories_name"]; ?></a>		
		<?php   }		?>
      
     
    </div>
<?php	}
	else
	{   ?>
		 <div class="collapse" id="demo<?php echo $row_main_cat_side["id"]; ?>">
		<?php while($row_sub_cat_side = mysqli_fetch_array($result_sub_cat_side))
		{  $sub_cat = clean(strtolower($row_sub_cat_side["catogories_name"]));   ?>
			<a href="<?php echo WEb_URL ?><?php echo $main_cat; ?>/<?php echo $sub_cat; ?>/<?php echo $row_sub_cat_side["id"]; ?>/product" class="list-group-item"><?php echo $row_sub_cat_side["catogories_name"]; ?></a>		
		<?php   }		?> 
      
     
    </div>
		
	<?php  }   } ?>		
  </div>
</div>					  
					</div>    <!-- Category Ends -->    
                         
					<div class="panel panel-default border-hidden categories animated fadeInUp visible" data-animation="fadeInUp" data-animation-delay="300"> 
						<h4>Weight</h4>     
						<ul>  
						<?php while($row_weight = mysqli_fetch_array($result_weight))
						{ 
							$weight_name = clean(strtolower($row_weight["weight_name"])); 
						?>
					<a href="<?php echo WEb_URL ?><?php echo $weight_name; ?>/<?php echo $row_weight["id"];?>/product"><li><input value="<?php echo $row_weight["id"] ?>" style="margin-right: 3% !important;" type="checkbox"><?php echo $row_weight["weight_name"]. " (".$row_weight["weight_range"]. ")"; ?><i class="flaticon-arrow209"></i></li></a>
						<?php    }		?>
						
						
						</ul> 
					</div> 

 <!-- Archive Begins -->                            
<div class="panel panel-default border-hidden categories animated fadeInUp visible" data-animation="fadeInUp" data-animation-delay="300">  

<!--<h4>WEIGHT</h4>                              
<div data-role="fieldcontain">
	<label for="slider">1.4 Kg</label>
 	<input type="range" name="slider" id="slider" value="0" min="0" max="100"  />
</div> <br>-->
 <h4>price range </h4>                              
<div data-role="fieldcontain">
	<label for="slider">Rs.<span id="valBox">30 </span></label>
 	<input type="range" name="slider" id="slider" value="0" min="0" max="1000" onchange="showVal(this.value);" step="50" />
</div> <br>
</div>

 
 </div>                    </div>                
 <!-- Blog Left Part Ends -->                  
 <!-- Blog Right Part Begins -->                    
	<div class="col-md-9">  
	<!---Search---->
	<?php if(isset($_GET["cat_id"]))  	{  	?>
		<h1 style="font-size:30px;margin-top:0px;"> <?php echo $row_cat["catogories_name"]; ?></h1>
	<?php }  elseif(isset($_REQUEST["id"]))  {  ?>
		<h1 style="font-size:30px;margin-top:0px;"><?php echo $row_cat["main_category"]; ?> </h1>
	<?php  }  else   {  ?>
			<h1 style="font-size:30px;margin-top:0px;">Products</h1>
<?php  }	?>
	<!-- Blog 1 Image Post-->  
	<div class="blog-inner animated" data-animation="fadeInUp" data-animation-delay="300">   
		<div class="container" id="livesearch">
			<div id="effect-1" class="effects clearfix">
			<?php while($row_product = mysqli_fetch_array($result_product))
			{
				$prod_nm = clean(strtolower($row_product["plan_name"])); 
				$img = explode(",",$row_product["image"]); 	?>
				<div class="col-md-4" style="height:350px;">
					<div class="img">
						<center> <img style="height:250px;" id="cart_img<?php echo $row_product["id"] ?>" src="<?php echo $img[0] ?>" alt=""></center>
						<div class="overlay">
							<a href="<?php echo WEb_URL ?><?php echo $prod_nm; ?>/<?php echo $row_product["id"];?>/productdetails" class="expand">+</a> 
						<!-- <a class="close-overlay hidden">x</a> -->
						</div>
					</div>
					<div class="additional-content">
						<p class="productname"><?php echo substr($row_product["plan_name"],0,23); ?>  </p>
						<h5 class="priceprdt"><i class="fa fa-inr" style="color:#000;" aria-hidden="true"></i> <?php echo $row_product["rate"];?></h5>
						<a href="#" class="btn btn-primary btn-sm text-light" id="add-to-cart<?php echo $row_product["id"] ?>" onClick ="addtocart('<?php echo $row_product["id"] ?>');"> <i class="fa fa-shopping-cart" ></i> Add to Cart</a>
					</div>
				</div>	
				<script>
				$(document).ready(function(){
	$('#add-to-cart<?php echo $row_product["id"] ?>').on('click',function(){
		//Scroll to top if cart icon is hidden on top
		$('html, body').animate({
			'scrollTop' : $(".cart_anchor").position().top
		});
		//Select item image and pass to the function
		
		var itemImg = document.getElementById('cart_img<?php echo $row_product["id"] ?>');
		//alert( itemImg);
		flyToElement($(itemImg), $('.cart_anchor'));
	});
});
				</script>
			<?php } ?>			
			</div>
		</div><!-- /.container --> 
	</div>    
	</div> 	
 </div>           
 </div>      
 
 </section>   
 <!-- Blog Ends -->       
 <!-- Download Now Section Begins -->      

 
 <!-- Download Now Section Begins -->   
 <!-- Copyright Section Begins -->   
<section id="copyright" class="copyright">
	<div class="container">
		<!-- Social Media -->
		<div class="row social-media animated" data-animation="fadeInUp" data-animation-delay="400">
			<div class="col-md-12">
				<!-- Icons -->
				<a href="https://www.facebook.com/discovermypet123/" target="_blank"><i class="fa fa-facebook"></i></a>
				<a href="https://twitter.com/Discovermypet_B" target="_blank"><i class="fa fa-twitter"></i></a>
				<a href="https://www.linkedin.com/in/discover-my-pet%E2%84%A2-419a14116?trk=hp-identity-name" target="_blank"><i class="fa fa-linkedin"></i></a>
				<a href="https://www.instagram.com/discovermypet123/?hl=en" target="_blank"><i class="fa fa-instagram"></i></a>
				<a href="https://in.pinterest.com/discovermypet01/?etslf=4376&eq=discover" target="_blank"><i class="fa fa-pinterest"></i></a>
				<!--<a href="#" target="_blank"><i class="fa fa-envelope"></i></a>-->
			</div>
		</div>
		<div class="row">
			<!-- Copyright Title -->
			<div class="col-md-7 text-center">
				<p>&copy; 2016 Discover My Pet. All Right Reserved. </p>
			</div>
			
			 <div class="col-md-5 text-center">
				<p style="color: #fff; width: 95%; text-align:right;">
					<a href="terms_use.php">Terms of Use</a>
					|
					<a href="privacy.php">Privacy Policy</a>
					|
					<a href="disclaimer.php">Disclaimer</a>
					
					|
					<a href="faq.php">FAQ</a>
					|
					<a href="suggestion.php">Suggestions</a>
				</p>
		   
			</div>
		</div>
	</div>
</section>
 

 <!-- Copyright Section Ends -->        <!-- Script Begins -->     
 <script type="text/javascript" src="<?php echo URL ?>js/jquery-1.11.0.min.js"></script>	   
 <script type="text/javascript" src="<?php echo URL ?>js/bootstrap.min.js"></script>	    
 <script type="text/javascript" src="<?php echo URL ?>js/bootstrap-hover-dropdown.min.js"></script>   
 <script type="text/javascript" src="<?php echo URL ?>js/bootstrapValidator.min.js"></script>	 
 <script type="text/javascript" src="<?php echo URL ?>js/jquery.sticky.js"></script>	 
 <!-- Slider and Features Canvas -->	
 <script type="text/javascript" src="<?php echo URL ?>js/jquery.flexslider-min.js"></script>       
 <!-- Overlay -->   
 <script type="text/javascript" src="<?php echo URL ?>js/overlay/modernizr.js"></script>
 <!-- Screenshot -->		       
 <script type="text/javascript" src="<?php echo URL ?>js/jquery.flexisel.js"></script>  
 <!-- Portfolio -->     
 <script type="text/javascript" src="<?php echo URL ?>js/jquery.prettyPhoto.js" ></script>  
 <script type="text/javascript" src="<?php echo URL ?>js/jquery.mixitup.min.js"></script>
 <script type="text/javascript" src="<?php echo URL ?>js/jquery.fitvids.js"></script>   
 <script type="text/javascript" src="<?php echo URL ?>js/jquery.easing.1.3.js"></script> 
 
 <!-- Counting Section -->       
 <script type="text/javascript" src="<?php echo URL ?>js/jquery.appear.js"></script>
 <!-- Expertise Circular Progress Bar -->     
 <script type="text/javascript" src="<?php echo URL ?>js/effect.js"></script>  
 
 <!-- Twitter -->      
 <script type="text/javascript" src="<?php echo URL ?>js/tweet/carousel.js"></script>  
 <script type="text/javascript" src="<?php echo URL ?>js/tweet/scripts.js"></script>    
 <script type="text/javascript" src="<?php echo URL ?>js/tweet/tweetie.min.js"></script>   
 <!-- Text Slider -->     
 <script src="<?php echo URL ?>js/jquery.simple-text-rotator.js"></script>   

 <!-- Custom -->	  
 <script type="text/javascript" src="<?php echo URL ?>js/custom.js"></script>	
 <!-- Color -->     
 <script type="text/javascript" src="<?php echo URL ?>js/color-panel.js"></script> 
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script>

function showVal(newVal){
 price = document.getElementById("valBox").innerHTML=newVal;
   if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;
     
    }
  }
  xmlhttp.open("GET","<?php echo WEb_URL; ?>search_range.php?q="+price,true);
  xmlhttp.send();
}

function select_cat(cat_id)
{ 	
   if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;     
    }
  }
  xmlhttp.open("GET","<?php echo WEb_URL; ?>search.php?q="+cat_id,true);
  xmlhttp.send();
}
function select_pro()
{
	product_name = document.getElementById("product_name").value;
	if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;
     
    }
  }
  xmlhttp.open("GET","<?php echo WEb_URL; ?>search_product.php?name="+product_name,true);
  xmlhttp.send();
	
}
function select_weight(weight_id)
{
	if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;     
    }
  }
  xmlhttp.open("GET","<?php echo WEb_URL; ?>search_weight.php?weight_id="+weight_id,true);
  xmlhttp.send();
}

function addtocart(product_id)
{
	 if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("total_quantity").innerHTML=this.responseText;
     
    }
  }
	qty = 1;
  xmlhttp.open("GET","<?php echo WEb_URL; ?>addtocart.php?product_id="+product_id+"&qty="+qty,true);
  xmlhttp.send();
}
$(function() {
    $( ".search_product" ).autocomplete({
	
        source: '<?php echo WEb_URL; ?>select_product.php' 
    });
});

</script> 

 <!-- Script Ends -->    </body>
 

</html>