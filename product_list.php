<?php 
	include_once('header_prod.php');	
	$con=mysqli_connect("localhost","discover_mypet","RW&RV1ECia*T","discover_mypet"); 
	$sql_main_cat = "SELECT id,main_category FROM tbl_product_main_cat";
	$result_main_cat = mysqli_query($con,$sql_main_cat);

	$sql_product = "SELECT plan_name,image,rate FROM tbl_service_plans LIMIT 12";
	$result_product = mysqli_query($con,$sql_product);
	
?>

<section id="blog-outer" class="blog-outer">  
	<div class="container">   
		<div class="row">         
			<div class="container">
				<img src="images/banner_temp.png">
			</div>
		</div>                <!-- Title & Desc Row Ends -->               
		<div class="row">       
			<div class="col-md-3">        
				<div class="sidebar">     
					<div class="panel panel-default border-hidden categories animated fadeInUp visible" data-animation="fadeInUp" data-animation-delay="300"> 
					<h4>Categories</h4>                         
					<ul class="scrooling"> 
						<?php while($row_main_cat = mysqli_fetch_array($result_main_cat))
						{  ?>
							
							<li onclick="select_cat('<?php echo $row_main_cat["id"]; ?>');"><input style="margin-right: 3% !important;" type="checkbox" id="main_cat" value="<?php echo $row_main_cat["id"]; ?>"><?php echo $row_main_cat["main_category"]; ?><i class="flaticon-arrow209"></i></li>
							
				  <?php } ?>											
					</ul>                   
					</div>                 
					<div class="panel panel-default border-hidden categories animated fadeInUp visible" data-animation="fadeInUp" data-animation-delay="300"> 
						<h4>Size Of Dog</h4>     
						<ul>  
						<?php while($row_main_cat = mysqli_fetch_array($result_main_cat))
						{  ?>
							<li><input value="1" name="brand_ids[]" class="ajax_search" style="margin-right: 3% !important;" type="checkbox">Puppy<i class="flaticon-arrow209"></i></li>
							  <?php } ?>	
						</ul> 
					</div> 
					<div class="panel panel-default border-hidden categories animated fadeInUp visible" data-animation="fadeInUp" data-animation-delay="300">  
						<h4>WEIGHT</h4>                              
						<div data-role="fieldcontain">
							<label for="slider">1.4 Kg</label>
							<input type="range" name="slider" id="slider" value="0" min="0" max="100"  />
						</div> <br>
						<h4>price range </h4>                              
						<div data-role="fieldcontain">
							<label for="slider">Rs.<span id="valBox">370 </span></label>
							<input type="range" name="slider" id="slider" value="0" min="0" max="1000" onchange="showVal(this.value)" step="50" />
						</div> <br>
					</div>
				</div> 
			</div>                
			<div class="col-md-9"> <br>  
				<div class="container">
					<div class="row">         
						<div class="input-group">
						<div class="input-group-btn search-panel">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<span id="search_concept">Filter by</span> <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
							  <li><a href="#contains">Contains</a></li>
							  <li><a href="#its_equal">It's equal</a></li>
							  <li><a href="#greather_than">Greather than ></a></li>
							  <li><a href="#less_than">Less than < </a></li>
							  <li class="divider"></li>
							  <li><a href="#all">Anything</a></li>
							</ul>
						</div>
                <input type="hidden" name="search_param" value="all" id="search_param">         
                <input type="text" class="form-control" name="x" placeholder="Search term...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><span class="fa fa-1x fa-search"></span></button>
                </span>
            </div>
        
	</div>
</div>

 <!-- Blog 1 Image Post-->           
<div class="blog-inner animated" data-animation="fadeInUp" data-animation-delay="300">   
<div class="container" id="livesearch">
<?php while($row_product = mysqli_fetch_array($result_product))
{
$img = explode(",",$row_product["image"]); 	?>
	<div class="col-md-4">
	<div class="additional-features animated fadeInLeft visible" data-animation="fadeInLeft" data-animation-delay="300">
		<!-- Icon --> 
		<i><img height="150" src="<?php echo $img[0] ?>"></i>
		<!-- Content --> 
		<div class="additional-content">
		   <p class="productname"><?php echo substr($row_product["plan_name"],0,25); ?> </p>
			<h5 class="priceprdt"><i class="fa fa-inr" style="color:#000;" aria-hidden="true"></i>
<?php echo $row_product["rate"];?></h5>
			<a href="#" class="btn btn-primary btn-sm text-light"> <i class="fa fa-shopping-cart"></i> Add to Cart</a>
		</div>
	</div>
	</div>
<?php } ?>
</div> 
</div>             
   
 </div>                  

		
 </div>           
 </div>      
 
 </section>   
 <script>
function select_cat(cat_id) {
  
 //  cat_id = document.getElementById("main_cat").value;
  
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
  xmlhttp.open("GET","search.php?q="+cat_id,true);
  xmlhttp.send();
}

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
  xmlhttp.open("GET","search_range.php?q="+price,true);
  xmlhttp.send();
}
</script>

<?php 
	include_once('footer.php');
?>