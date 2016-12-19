<?php 
	include_once('header_prod.php');
	
	$id = $_GET["id"];		
	
	$date = date('Y-m-d h:i:s');
	$sql_update_recent = "UPDATE tbl_service_plans SET recent_view_date = '$date' WHERE id = '$id'";
	$result_update_recent = mysqli_query($con,$sql_update_recent);	
	
	$sql = "SELECT m.id, m.main_category,c.id,c.catogories_name, s.id, plan_name, rate, image, brand_id, stock, description, details FROM tbl_service_plans AS s, tbl_product_main_cat AS m,tbl_product_category as c WHERE s.id = '$id' AND m.id = s.main_category_id and c.id = s.category_id";
	$result = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($result);

	$sql_related = "SELECT id,plan_name,rate,image,brand_id,stock,description,details FROM tbl_service_plans WHERE id != '$id' LIMIT 7";
	$result_related = mysqli_query($con,$sql_related);
	
	$sql_recent1 = "SELECT id,plan_name,rate,image,brand_id,stock,description,details FROM tbl_service_plans WHERE id != '$id' ORDER BY recent_view_date DESC LIMIT 0,4 ";	
	$result_recent1 = mysqli_query($con,$sql_recent1);
	
	$sql_recent2 = "SELECT id,plan_name,rate,image,brand_id,stock,description,details FROM tbl_service_plans WHERE id != '$id' ORDER BY recent_view_date DESC LIMIT 4,4 ";	
	$result_recent2 = mysqli_query($con,$sql_recent2);
	
	$sql_prod_color = "SELECT color_id FROM tbl_product_color WHERE product_id = '$id'";
	$result_prod_color = mysqli_query($con,$sql_prod_color);
	
	$sql_attribute = "SELECT id,weight_id,size_name,price,img FROM tbl_product_attribute WHERE product_id = '$id' and weight_id !='0' order by weight_id";
	$result_attribute = mysqli_query($con,$sql_attribute);
	$result_attribute1 = mysqli_query($con,$sql_attribute);		
	
?>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<style>
.btn span.glyphicon {    			
	opacity: 0;				
}
.btn.active span.glyphicon {				
	opacity: 1;				
}
.btn-group > .btn:first-child:not(:last-child):not(.dropdown-toggle) {
  
   
	}
	.fixbtn {
    background-color: #f8f8f8 !important;
    color: #000 !important;
	}
	.btn.active, .btn:active {
    background-color: #000 !important;
    color: #fff !important;
}
</style>
<section id="welcome">  <!-- Welcome Section Begins -->
	<div class="container welcome-inner">             
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb">
					<li><a href="home"><i class="glyphicon glyphicon-home"></i></a></li>
					<li><a href="product.php">Product</a></li>
					<li><a href="product.php"><?php echo $row["main_category"]; ?></a></li>
					<li class="active"><?php echo $row["catogories_name"]; ?></li>
				</ul>
			</div><!-- Blog Left Part -->                    
			<div class="col-md-12">  
				<h1 style="margin-top:3px !important; font-size: 30px;"><?php echo $row["plan_name"]; ?></h1>
			</div>
			
		</div>
	</div>
</section>

<section id="welcome">  <!-- Welcome Section Begins -->
	<div style="padding-top: 10px !important;" class="container welcome-inner">             
		<div class="row">                    <!-- Blog Left Part -->                    
			<div class="col-md-9">  
				<div class="container blog-status">
					<div class="row"> <!-- Product main -->   
						<div class="col-md-5">
							<div class="app-figure" id="zoom-fig">
							<?php  $img = explode(",",$row["image"]); ?>
							<a id="Zoom-1" class="MagicZoom" href="<?php echo $img[0] ?>"	>
							<img class="cart_img" src="<?php echo $img[0]; ?>" alt=""/>
							</a>
							<div class="selectors">
								<?php 
								if(count($img) > 1)
								{
									for($i=0;$i < count($img);$i++)
									{  ?>
										<a data-zoom-id="Zoom-1" href="<?php echo $img[$i]; ?>" data-image="<?php echo $img[$i]; ?>" >
										<img class="cart_img1" width="65" height="85" srcset="<?php echo $img[$i]; ?>?scale.width=112 2x" src="<?php echo $img[$i]; ?>?scale.width=56"/>
										</a>
								<?php	}	
								}   ?>
														
							</div>
							</div>							 
						</div>								
						<div class="col-md-7 food">
							<!--<div class="row">
								<div class="col-md-12">
									<h1 style="line-height:30px !important;"><?php echo $row["plan_name"]; ?></h1>
								</div>
							</div>-->										
							<div class="row brand1">
								<div class="col-md-12">
									<b>Brand:</b> <a href="#">Solid Gold Pet Products</a>
								</div>													
								<div class="col-md-12">
									<b>Availability:</b> <span> In Stock </span>
								</div>
							</div>												
							<div class="row">
								<div class="col-md-12 product-price">
									<span>Rs.<span id="rate"><?php echo $row["rate"]; ?></span></span>
									<input type="hidden" id="at_id" value="" />
								</div>
							</div>		
						
							<div class="row">
								<div class="col-md-5"> 
									<div class="form-group">
										  <label for="sel1">Quantity:</label>
										  <div style="clear:both;">				  
											  <input id="qty" name="quant[1]" class="form-control input-number" value="1" min="1" max="50" type="number">
										</div>
									</div>
								</div>
								<div class="col-md-7">
								 <label for="sel1">&nbsp;</label>
								<button type="button" class="addcart btn add-to-cart1" onClick ="addtocart('<?php echo $row["id"] ?>');" ><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to Cart</button>									
								</div>													
							</div>
							<?php if(mysqli_num_rows($result_prod_color) > 0) 
							{  ?>
												<div class="row">
								<div class="col-md-12">
									<div class="btn-group" data-toggle="buttons">
										<p class="prdtdetailsubhead">Select Color:</p>
										<?php while($row_prod_color = mysqli_fetch_array($result_prod_color))
										{   
											$color = explode(",",$row_prod_color['color_id']);
											for($i=0;$i<count($color);$i++)
											{
												$sql_color = "SELECT color_nm,color_code FROM tbl_color WHERE id = '$color[$i]'";
												$result_color = mysqli_query($con,$sql_color);
												$row_color = mysqli_fetch_array($result_color);

												?>
												<label class="btn" style=" margin-left: 3px;margin-right: 3px; margin-top: 3px;border: 1px solid #000;padding:0 !important; background-color:<?php echo $row_color['color_code']; ?>;">
												<input type="radio" name="options" id="option<?php echo $color[$i]; ?>" value="<?php echo $color[$i]; ?>" autocomplete="off">
												<span class="glyphicon glyphicon-ok"></span>
												</label>
									<?php   }
										}  ?>
									</div>
								</div>
								</div>
						<?php 	} ?>
						<?php if(mysqli_num_rows($result_attribute) > 0)
						{ 	?>
								<div class="row">								
									<div class="col-md-12">
										<p class="prdtdetailsubhead"> Select Pet's Weight:</p>	
										<div class="btn-group" data-toggle="buttons" style="width:100%">
										<?php while($row_attribute = mysqli_fetch_array($result_attribute))
										{ 
											$sql_weight = "SELECT weight_range FROM tbl_pet_weight WHERE id = '".$row_attribute['weight_id']."'";
											$result_weight = mysqli_query($con,$sql_weight);
											$row_weight = mysqli_fetch_array($result_weight);   ?>
											 <label onclick="select_weight('atr_id<?php echo $row_attribute["id"];  ?>','<?php echo $row_attribute["price"]; ?>','<?php echo $row_attribute["id"];  ?>');" class="btn btn-primary fixbtn" style="margin-right:1%;margin-bottom: 1%;border-radius: 0 !important;">
											<input type="radio" name="options" id="option1" autocomplete="off" checked> <?php echo $row_weight["weight_range"];  ?>  </label>
									<?  }	?>
										 
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<p class="prdtdetailsubhead"> Select Pet's Size:</p>
										<div class="btn-group" data-toggle="buttons" style="width:100%">
											<?php while($row_attribute1 = mysqli_fetch_array($result_attribute1))
											{ ?>
								<label onclick="select_size('atr_id<?php echo $row_attribute["id"];  ?>','<?php echo $row_attribute["price"]; ?>');" class="btn btn-primary size fixbtn" style="margin-right:1%" id="atr_id<?php echo $row_attribute1["id"];  ?>">
													<input type="radio" name="options" id="option1" autocomplete="off" checked> <?php echo $row_attribute1["size_name"];  ?>
												</label>
												<input type="hidden" value="<?php echo $row_attribute1["price"];  ?>" id="price<?php echo $row_attribute1["id"];  ?>"/>
												
												<script>
												function select_weight(atr_id,price,at_id)
												{
													$('.size').removeClass("active");   
													$('#'+ atr_id).addClass("active");   
													document.getElementById("rate").innerHTML=price;
													document.getElementById('at_id').value=at_id;
												}
												</script>
										<?  }	?>
										</div>
									</div>
								</div>
				<?php   }  ?>
								<div class="row">
								<div class="col-md-12">
								<p class="prdtdetailsubhead">Description</p>
								<?php echo $row["description"]; ?>	</div>
								</div>
											
		
						</div>	       
					</div> 
				</div>  
<hr></hr>								
          <div class="container">
    <div class="row">
        <div class="row">
            <div class="col-md-9">
                <h3>Recently Viewed and Related Items</h3>
            </div>
            <div class="col-md-3">
                <!-- Controls -->
                <div class="controls pull-right hidden-xs">
                    <a class="left fa fa-chevron-left btn" href="#carousel-example"
                        data-slide="prev"></a><a class="right fa fa-chevron-right btn" href="#carousel-example"
                            data-slide="next"></a>
                </div>
            </div>
        </div>
        <div id="carousel-example" class="carousel slide hidden-xs" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
		
                <div class="item active">
                    <div class="row">
						<?php while($row_recent1 = mysqli_fetch_array($result_recent1))
					{ 	  $img = explode(",",$row_recent1["image"]); ?>				
                        <div class="col-sm-3">
                            <div class="col-item">
                                <div class="photo"> 
                                    <img id="cart_img<?php echo $row_recent1["id"] ?>" src="<?php echo $img[0]; ?>" class="img-responsive" alt="a" />
                                </div>
                                <div class="info">
                                    <div class="row">
                                        <div class="price col-md-12">
                                            <h4 class="related"><?php echo $row_recent1["plan_name"]; ?></h4>
                                            <h4 class="price-text-color"><i class="fa fa-inr" style="color:#219fd1;" aria-hidden="true"></i> <?php echo $row_recent1["rate"]; ?></h4>
                                        </div>
                                       
                                    </div>
                                    <div class="separator clear-left">
                                        <p class="btn-add">
                                            <i class="fa fa-shopping-cart"></i><a href="#" id="add-to-cart<?php echo $row_recent1["id"] ?>" onClick ="addtocart('<?php echo $row_recent1["id"] ?>');" class="hidden-sm">Add to cart</a></p>
                                        <p class="btn-details">
                                            <i class="fa fa-list"></i><a href="productdetails.php?id=<?php echo $row_recent1["id"]; ?>" class="hidden-sm">More </a></p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                        </div>
						<script>
				$(document).ready(function(){
	$('#add-to-cart<?php echo $row_recent1["id"] ?>').on('click',function(){
		//Scroll to top if cart icon is hidden on top
		$('html, body').animate({
			'scrollTop' : $(".cart_anchor").position().top
		});
		//Select item image and pass to the function
		
		var itemImg = document.getElementById('cart_img<?php echo $row_recent1["id"] ?>');
		//alert( itemImg);
		flyToElement($(itemImg), $('.cart_anchor'));
	});
});
				</script>
						                        
                       <?php   }  ?>
                    </div>
                </div>
				
				
                <div class="item">
                                       <div class="row">
					
							<?php while($row_recent2 = mysqli_fetch_array($result_recent2))
					{  $img = explode(",",$row_recent2["image"]);  ?>				
                        <div class="col-sm-3">
                            <div class="col-item">
                                <div class="photo">
                                    <img id="cart_img<?php echo $row_recent2["id"] ?>" src="<?php echo $img[0]; ?>" class="img-responsive" alt="b" />
                                </div>
                                <div class="info">
                                    <div class="row">
                                        <div class="price col-md-12">
                                            <h4 class="related"><?php echo $row_recent2["plan_name"]; ?></h4>
                                            <h4 class="price-text-color"><i class="fa fa-inr" style="color:#219fd1;" aria-hidden="true"></i> <?php echo $row_recent2["rate"]; ?></h4>
                                        </div>
                                       
                                    </div>
                                    <div class="separator clear-left">
                                        <p class="btn-add">
                                            <i class="fa fa-shopping-cart"></i><a id="add-to-cart<?php echo $row_recent2["id"] ?>" onClick ="addtocart('<?php echo $row_recent2["id"] ?>');"href="#" class="hidden-sm">Add to cart</a></p>
                                        <p class="btn-details">
                                            <i class="fa fa-list"></i><a href="productdetails.php?id=<?php echo $row_recent2["id"]; ?>" class="hidden-sm">More </a></p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                        </div>
						         <script>
				$(document).ready(function(){
	$('#add-to-cart<?php echo $row_recent2["id"] ?>').on('click',function(){
		//Scroll to top if cart icon is hidden on top
		$('html, body').animate({
			'scrollTop' : $(".cart_anchor").position().top
		});
		//Select item image and pass to the function
		
		var itemImg = document.getElementById('cart_img<?php echo $row_recent2["id"] ?>');
		//alert( itemImg);
		flyToElement($(itemImg), $('.cart_anchor'));
	});
});
				</script>               
                       <?php   }  ?>
                    </div>
                </div>
				 
            </div>
        </div>
    </div>
   
</div>
<hr></hr>
 </div>                 <!-- Blog Left Part Ends -->                    <!-- Blog Right Part Begins -->                   
 <div class="col-md-3">  
 <div class="sidebar side food">  
 <h1>You May Also Like</h1>
 <?php while($row_related = mysqli_fetch_array($result_related))
	{ $img = explode(",",$row_related["image"]);  ?>
		<div class="col-md-12">
			<p>
				<div class="col-md-4"> <img src="<?php echo $img[0]; ?>" border="0">
				</div>
				<a href="productdetails.php?id=<?php echo $row_related["id"]; ?>"><div class="col-md-8"> <?php echo $row_related["plan_name"]; ?> <p><h6><i class="fa fa-inr" style="color:#000;" aria-hidden="true"></i> <?php echo $row_related["rate"]; ?></h6></p>
				<p>
				<!--<p class="btn-add">
				<i class="fa fa-shopping-cart"></i><a href="http://www.jquery2dotnet.com" class="hidden-sm"></a></p>--></p>
				</div></a>
			</p>
		</div> 
<?php	}?>
    	
 </div>                    </div>             
		       
 </div>                
                <!-- First Row Ends -->	
            </div>
</section>
	
	<link rel="stylesheet" href="<?php echo URL ?>css/tinycarousel.css" type="text/css" media="screen"/>
	<script type="text/javascript" src="<?php echo URL ?>js/jquery.tinycarousel.js"></script>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$('#slider1').tinycarousel();
		});
	</script>
	
		<script>
$(document).ready(function(){
	$('.add-to-cart1').on('click',function(){
		//Scroll to top if cart icon is hidden on top
		$('html, body').animate({
			'scrollTop' : $(".cart_anchor").position().top
		});
		//Select item image and pass to the function
		
		var itemImg = document.getElementsByClassName('cart_img');
		//alert( itemImg);
		flyToElement($(itemImg), $('.cart_anchor'));
	});
});

function addtocart(product_id)
{
	qty = document.getElementById("qty").value;	
	at_id = document.getElementById("at_id").value;
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
	
  xmlhttp.open("GET","<?php echo WEb_URL; ?>addtocart.php?product_id="+product_id+"&qty="+qty+"&at_id="+at_id,true);
  xmlhttp.send();
}

</script>
 
		
<?php 
	include_once('footer.php');
?>