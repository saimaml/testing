<?php include_once('header_prod.php'); 
 
$id = session_id();
$i=0;
$all_total=0;
	$sql = "SELECT id,product_id,quantity,rate,attribute_id	FROM tbl_cart WHERE session_id = '$id' ";
	$result1 =mysqli_query($con,$sql);
	$result =mysqli_query($con,$sql);
	$item = mysqli_num_rows($result);
	
	while($row1 = mysqli_fetch_array($result1))
	{	
		$all_total = $all_total + $row1["rate"]*$row1["quantity"];
	}	
	
	$sql_tax = "SELECT tax_rate FROM tbl_service_tax";
	$result_tax = mysqli_query($con,$sql_tax);
	$row_tax = mysqli_fetch_array($result_tax);
	
	$tax = $all_total * $row_tax["tax_rate"] / 100;

		?>
<style>
body
{
	color:#000;
}
.spinner {
  width: 100px;
}
.spinner input {
  text-align: right;
}
.input-group-btn-vertical {
  position: relative;
  white-space: nowrap;
  width: 1%;
  vertical-align: middle;
  display: table-cell;
}
.input-group-btn-vertical > .btn {
  display: block;
  float: none;
  width: 100%;
  max-width: 100%;
  padding: 8px;
  margin-left: -1px;
  position: relative;
  border-radius: 0;
}
.input-group-btn-vertical > .btn:first-child {
  border-top-right-radius: 4px;
}
.input-group-btn-vertical > .btn:last-child {
  margin-top: -2px;
  border-bottom-right-radius: 4px;
}
.input-group-btn-vertical i{
  position: absolute;
  top: 0;
  left: 4px;
}
</style>
<script>
(function ($) {
  $('.spinner .btn:first-of-type').on('click', function() {
    $('.spinner input').val( parseInt($('.spinner input').val(), 10) + 1);
  });
  $('.spinner .btn:last-of-type').on('click', function() {
    $('.spinner input').val( parseInt($('.spinner input').val(), 10) - 1);
  });
})(jQuery);

</script>
 
<!-- HEADER END -->

		<section class="blog-outer" id="blog-outer">
			<div class="container shortcodes">  
				<!-- Title & Desc Row Begins --> 
					<div class="row">    
						<div class="col-md-12 header text-center">
                        <!-- Title -->   
						<div class="title"> 
						<h2>Shopping <span>Cart</span></h2>
                        </div> 
						
						<nav class="breadcrumbs ">
							<a href="index.php">Home</a>
							<a href="package.php?id=7">Packages</a>
						</nav>
						<!-- Description --> 
                        <p class="desc">Thankyou For Shopping With Discover My Pet. Please Visit Us Again!</p>
						</div> 
						
						</div>           
			</div>  
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div data-animation-delay="300" data-animation="fadeInUp" class="blog-inner animated fadeInUp visible">   
						<div class="container blog-status">
							<!-- Blog Date and Title -->     
								<div class="row blog-date"> 
									<div class="col-md-3 col-sm-3 text-center">    
										<span class="bold span-inner">
											<h4>
												<a href="product.php">
													<button class="btn btn-cart" type="button">
														Continue Shopping
													</button>
												</a>
											</h4>
										</span><br> 
										 
									</div>                      
									<div class="col-md-6 col-sm-6 col-sm-6 blog-title">  
										<span>You have <?php echo $item;?> items in your cart</span>						
									</div> 
									
									<div class="col-md-3 col-sm-3 blog-title">  
									<h4>  <?php // if($all_total > 0) { ?>
										<button class="btn btn-cart" type="button" onclick="deleteallCart();" >
												Empty Cart
										</button>
									<?php //} ?>
									</h4>					
									</div>  

								</div>  
				<div id="delete_response">
				<?php 
				
				while($row = mysqli_fetch_array($result))
				{	
					$sql_name = "SELECT plan_name,rate,rate_title,image FROM tbl_service_plans WHERE id = '".$row['product_id']."' ";
					
					$result_name =mysqli_query($con,$sql_name);
					$row_name = mysqli_fetch_array($result_name);
					
					$sql_attribute = "SELECT weight_id,size_name,img FROM tbl_product_attribute WHERE id = '".$row['attribute_id']."' ";
					
					$result_attribute =mysqli_query($con,$sql_attribute);
					$row_attribute = mysqli_fetch_array($result_attribute);
					
					$sql_weight = "SELECT weight_name FROM tbl_pet_weight WHERE id='".$row_attribute['weight_id']."'";
					$result_weight = mysqli_query($con,$sql_weight);
					$row_weight = mysqli_fetch_array($result_weight);
					
					
				?>
					<div class="row blog-inner-bottom" id="delete_response1">									
						<div class="col-md-2 col-sm-3 img-cart">
						<?php $img = explode(",",$row_name["image"]); ?>
							<a href="#">
								<img class="img-responsive" src="<?php echo $img[0]; ?>" alt="">
							</a>
					
						</div>			
						<div class="col-md-8 col-sm-6">										
						<div class="cart-text">
							<h4><a href="#"><?php echo $row_name["plan_name"]."  ".$row_weight["weight_name"]. "  " .$row_attribute["size_name"]?></a></h3>
							<p class="cart-txt">Rs.<?php echo $row["rate"]?></p>
						</div>										
										<div class="cart-text">
											<div class="row">
												<div class="col-md-2 col-xs-6">
													<div class="quty"><b>Quantity</b> </div>
												</div>
												
												<div class="col-md-3 col-xs-6">
												<select class="input-group spinner form-control" name="qty" id="qty<?php echo $row["id"]?>">
												<?php
													for($j=1; $j<51; $j++)
													{	
												?>
													<option value="<?php echo $j?>" <?php if($row["quantity"]== $j) echo "selected";?>><?php echo $j; ?></option>
												<?php
													}
												?>	
												</select>
  
												</div>
												<div class="col-md-7 col-xs-6">
												<a href="#" class="btn btn-primary btn-sm text-light" id="add-to-cart331" onclick="updateCart(<?php echo $row["id"]?>,$('#qty<?php echo $row["id"]?>').val());"> <i class="fa fa-pencil-square-o"></i> Update Cart</a>
												</div>
											</div><br>											
										</div>
									</div>									
									<div class="col-md-2 col-sm-3 alert">
										<div class="row">   																					
											<div class="col-md-12 col-xs-12 col-sm-12 alert-to">      
												<div data-toggle="buttons" class="btn-group include-icon">
													<label class="btn btn-success btn-edit-del" style="width:100% !important;" onclick="deleteFromCart(<?php echo $row["id"]?>);" >
														<input type="radio" value="1" name="includeicon"> 
														<i class="fa fa-times"></i>
													</label>
													<!--<label class="btn btn-default btn-edit-del active" onclick="updateCart(<?php echo $row["id"]?>,$('#qty<?php echo $row["id"]?>').val());">
														<input type="radio" value="0" name="includeicon"> 
														<i class="fa fa-pencil-square-o"></i>
													</label>-->
												</div>        
											</div> 
										</div> 
									</div>
								
								</div>
				<?php    $i++; }?>			
				
								<div class="container blog-inner-bottom">        
									<div class="row">  
										<!-- Title -->    
										                                
									<!-- Social Icons -->       
										<div class="col-md-6 col-sm-6 blog-social text-right right">  
											<h4>Total : <span class="bold">Rs.<?php echo $all_total; ?>/- </span></h4>
											<h4>Service tax <?php echo $row_tax["tax_rate"]; ?>%</h4> 
										<?php 
										//$amount = $all_total;
										$all_total = $all_total + $tax;
										$query = "select session_id from tbl_cart where session_id = '".$session_id."' and service_id = 2";
										$result = mysqli_query($con,$query);
										if(mysqli_num_rows($result) > 0)
										{
										
										$sql_shipping = "SELECT shipping,range1 FROM tbl_charges WHERE range1 < $all_total LIMIT 1";
										$result_shipping =mysqli_query($con,$sql_shipping);
										$row_shipping = mysqli_fetch_array($result_shipping);
										$shipping = $row_shipping['shipping'];										
										
 									if($all_total > 1000 )
									{ ?> <h4>Shipping charges are free</h4> <?php $amount = $all_total + $shipping;
									
									} 
									else if($all_total==0)
									{?><h3></h3><?php }
										else { ?> <h4>Shipping charges Rs. <?php echo $shipping; ?>/-</h4> <?php $amount = $all_total + $shipping; ?>
									
									<?php } 
										}										
										
									?>
									
										</div> 
									</div>                               
								</div>                                <!-- Bottom Content Ends -->  

					</div>			
								<div class="row">  
									<!-- Title --> 
										<div class="col-md-6 col-sm-6 social-title">     
											<h4>
													<a href="product.php">
														<button class="btn btn-primary-0" type="button">Continue Shopping</button>
													</a>
												</h4>
										</div>      
										<!-- Social Icons -->   
									<?php if(isset($_SESSION["user_id"])) {
											if($all_total > 0)
											{?>
										<div class="col-md-6 col-sm-6 blog-social social-title text-right">
											<a href="billing-details.php">
												<button type="button" class="btn btn-check">Checkout</button>
											</a>
										</div>    
									<?php }}  else { if($all_total > 0) {?>
									<div class="col-md-6 col-sm-6 blog-social social-title text-right">
											<a href="#login_form">
												<button class="btn btn-primary-0" type="button">Checkout</button><!--<button type="button" class="btn btn-check">Checkout</button>-->
											</a>
									</div>    <?php }} ?>
								</div>  
								</div>                      
					</div>
									
				</div>			
				
				<div class="col-md-4">
					<div class="sidebar">     
																		
						<!-- Facebook Sidebar -->    
                        <div data-animation-delay="300" data-animation="fadeInUp" class="sidebar-facebook animated fadeInUp visible"> 
							<div class="row">
								<div class="col-md-12 col-sm-6 center">
									<h4 class="font">Your Cart Total</h4>									
									<h4 class="bold" style="font-size:32px;" id="carttotal">Rs.<?php echo $amount; ?>/- </h4>
								</div>
								<?php if(isset($_SESSION["user_id"])) {if($amount>0){	?>
								<div class="col-md-12 col-sm-6 blog-social social-title text-right">
										<a href="billing-details.php">
											<button type="button" class="btn btn-right">Checkout</button>
										</a>
								</div>    
								<?php } } else { if($amount > 0) {	?>
								<div class="col-md-12 col-sm-6 blog-social social-title text-right">
										<a href="#login_form">
											<button type="button" class="btn btn-right">Checkout</button>
										</a>
								</div>    
								<?php }} ?>							
							
							</div>
						</div>
					</div>
				</div> 
			</div> 
		</div> 
		</section>
		
<script language="javascript" type="text/javascript">
function updateCart(id,qty){
   var ajaxRequest;  // The variable that makes Ajax possible!
   try{
   
      // Opera 8.0+, Firefox, Safari
      ajaxRequest = new XMLHttpRequest();
   }catch (e){
      
      // Internet Explorer Browsers
      try{
         ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
      }catch (e) {
         
         try{
            ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
         }catch (e){
         
            // Something went wrong
            alert("Your browser broke!");
            return false;
         }
      }
   }  
 
   ajaxRequest.onreadystatechange = function(){
   
      if(ajaxRequest.readyState == 4){
         var ajaxDisplay = document.getElementById('delete_response');
		
         var str = ajaxRequest.responseText; 		 
		 var startindex = str.indexOf("@'>"); 
		 var endindex = str.indexOf("<span style='@@#$@'></div>"); 		
		 var length = endindex - startindex;		 
		 var totalamount = str.substring(startindex+3,endindex); 
		 $('#carttotal').text(totalamount);
		 ajaxDisplay.innerHTML = str;
      }
   }
   
   
   var queryString = "?id=" + id + "&quantity=" + qty;
   
   ajaxRequest.open("GET", "updatecart.php" + queryString, true);
   ajaxRequest.send(null); 
}

function deleteFromCart(id){
   var ajaxRequest;  // The variable that makes Ajax possible!
   try{
   
      // Opera 8.0+, Firefox, Safari
      ajaxRequest = new XMLHttpRequest();
   }catch (e){
      
      // Internet Explorer Browsers
      try{
         ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
      }catch (e) {
         
         try{
            ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
         }catch (e){
         
            // Something went wrong
            alert("Your browser broke!");
            return false;
         }
      }
   }
  
   ajaxRequest.onreadystatechange = function(){
   if(ajaxRequest.readyState == 4){
         var ajaxDisplay = document.getElementById('delete_response');
		
         var str = ajaxRequest.responseText; 		 
		 var startindex = str.indexOf("@'>"); 
		 var endindex = str.indexOf("<span style='@@#$@'></div>"); 		
		 var length = endindex - startindex;		 
		 var totalamount = str.substring(startindex+3,endindex); 
		 $('#carttotal').text(totalamount);
		 ajaxDisplay.innerHTML = str;
      }
   }
   
   
   var queryString = "?id=" + id ;
   
   ajaxRequest.open("GET", "deletefromcart.php" + queryString, true);
   ajaxRequest.send(null); 
}


function deleteallCart(){
   var ajaxRequest;  // The variable that makes Ajax possible!
   try{
   
      // Opera 8.0+, Firefox, Safari
      ajaxRequest = new XMLHttpRequest();
   }catch (e){
      
      // Internet Explorer Browsers
      try{
         ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
      }catch (e) {
         
         try{
            ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
         }catch (e){
         
            // Something went wrong
            alert("Your browser broke!");
            return false;
         }
      }
   }
  
   ajaxRequest.onreadystatechange = function(){
   
      if(ajaxRequest.readyState == 4){
         var ajaxDisplay = document.getElementById('delete_response');
		  var str = ajaxRequest.responseText; 		 
		 var startindex = str.indexOf("@'>");  		
		 var endindex = str.indexOf("<span style='@@#$@'></div>"); 		 
		 var length = endindex - startindex;		 
		 var totalamount = str.substring(startindex+3,endindex); 
		 $('#carttotal').text(totalamount);
		 ajaxDisplay.innerHTML = str;
		 $('#total_quantity').text(0);
        // ajaxDisplay.innerHTML = ajaxRequest.responseText; 
      }
   }     
   ajaxRequest.open("GET", "deleteallcart.php", true);
   ajaxRequest.send(null); 
}
//-->
</script>
<!-- FOOTER -->

	<?php include_once('footer.php'); ?>
 
<!-- FOOTER END -->		