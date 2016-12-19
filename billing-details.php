<?php
include_once('header_prod.php'); 
$user_id = $_SESSION['user_id']; 
$all_total=0;

$sql_tax = "SELECT tax_rate FROM tbl_service_tax";
$result_tax = mysqli_query($con,$sql_tax);
$row_tax = mysqli_fetch_array($result_tax);

$sql_total = "SELECT cart_master_id,rate,quantity FROM tbl_cart WHERE session_id = '$session_id'";
$result_total = mysqli_query($con,$sql_total);	
while($row_total = mysqli_fetch_array($result_total))
{
	$cart_master_id =  $row_total["cart_master_id"];
	$all_total = $all_total + $row_total["rate"]*$row_total["quantity"];
}

$tax = $all_total * $row_tax["tax_rate"] / 100;
$all_total = $all_total + $tax;
$sql_shipping = "SELECT shipping,range1 FROM tbl_charges WHERE range1 < $all_total LIMIT 1";
$result_shipping =mysqli_query($con,$sql_shipping);
$row_shipping = mysqli_fetch_array($result_shipping);
$shipping = $row_shipping['shipping'];

$all_total = $all_total + $shipping;

if(!isset($_seesion['user_id']))
{	
	$sql = "SELECT * FROM tbl_cart_master WHERE session_id = '$session_id' and user_id ='".$user_id."'";
	$result = mysqli_query($con,$sql);	
	$row = mysqli_fetch_array($result);
	$user_id = $row["user_id"];
	
	if(isset($_POST["submit"]))
		{		
			$billing_name = $_POST["billing_name"];
			$billing_address = $_POST["billing_address"];
			$billing_city = $_POST["billing_city"];
			$billing_state = $_POST["billing_state"];
			$billing_zip = $_POST["billing_zip"];
			$billing_country = $_POST["billing_country"];
			$billing_tel = $_POST["billing_tel"];
			$billing_email = $_POST["billing_email"];			
					
			$sql = "UPDATE tbl_cart_master SET billing_name = '".$billing_name."',billing_address = '".$billing_address."',billing_city = '".$billing_city."',billing_state = '".$billing_state."',billing_zip = '".$billing_zip."',billing_country = '".$billing_country."',billing_tel = '".$billing_tel."',billing_email = '".$billing_email."',delivery_name = '".$billing_name."',delivery_address = '".$billing_address."',delivery_city = '".$billing_city."',delivery_state = '".$billing_state."',delivery_zip = '".$billing_zip."',delivery_country = '".$billing_country."',delivery_tel = '".$billing_tel."',session_id = '".$session_id."' where user_id = '$user_id' ";
					
			$result = mysqli_query($con,$sql);	

			?>
			<script type="text/javascript">
				window.location = "<?php echo WEb_URL ?>cca/ccavRequestHandler.php"
			</script>
			
						
		<?php   }	
		elseif(isset($_POST["submit1"]))
		{			
			$billing_name = $_POST["billing_name"];
			$billing_address = $_POST["billing_address"];
			$billing_city = $_POST["billing_city"];
			$billing_state = $_POST["billing_state"];
			$billing_zip = $_POST["billing_zip"];
			$billing_country = $_POST["billing_country"];
			$billing_tel = $_POST["billing_tel"];
			$billing_email = $_POST["billing_email"];
			$delivery_name = $_POST["delivery_name"];
			$delivery_address = $_POST["delivery_address"];
			$delivery_city = $_POST["delivery_city"];
			$delivery_state = $_POST["delivery_state"];
			$delivery_zip = $_POST["delivery_zip"];
			$delivery_country = $_POST["delivery_country"];
			$delivery_tel = $_POST["delivery_tel"];
			
			$sql = "UPDATE tbl_cart_master SET billing_name = '".$billing_name."',billing_address = '".$billing_address."',billing_city = '".$billing_city."',billing_state = '".$billing_state."',billing_zip = '".$billing_zip."',billing_country = '".$billing_country."',billing_tel = '".$billing_tel."',billing_email = '".$billing_email."',delivery_name = '".$delivery_name."',delivery_address = '".$delivery_address."',delivery_city = '".$delivery_city."',delivery_state = '".$delivery_state."',delivery_zip = '".$delivery_zip."',delivery_country = '".$delivery_country."',delivery_tel = '".$delivery_tel."' where session_id = '$session_id' ";
			$result = mysqli_query($sql);	
			?>
			<script type="text/javascript">
				window.location = "<?php echo WEb_URL ?>cca/ccavRequestHandler.php"
			</script>
			<?php
		}			
	
 }
 
 ?> 
<script>
$(document).ready(function(){
    $("#hide").click(function(){
        $("#details").hide();
		 $("#details_form").show();
    });
  });
</script>
<script>
$(document).ready(function(){
    $("#same_address").click(function(){
      $("#details_form1").toggle();
      $("#submit").toggle();
    });
  });
</script>
<!-- HEADER END -->
<section class="blog-outer" id="blog-outer">
	<div class="container shortcodes">  
		<!-- Title & Desc Row Begins --> 
			<div class="row">    
				<div class="col-md-12 header text-center">
				<!-- Title -->   
				<div class="title"> 
				<h2>Check<span>  out </span></h2>
				</div> 
				<nav class="breadcrumbs ">
					<a href="index.php">Home</a>
					<a href="shopping-cart.php">Shopping Cart</a>
				</nav>
				<!-- Description --> 
				<p class="desc">We ensure quality &amp; support.</p>
				</div> 
			</div>           
	</div>  
<div class="container">
		<div class="row">
			<div class="col-md-7 col-md-offset-1">
					<div data-animation-delay="300" data-animation="fadeInUp" class="blog-inner animated fadeInUp visible">   
					<div class="container billing-details">
							<!-- Blog Date and Title -->     
							<div class="row blog-date"> 
												 
								<div class="col-md-9 blog-title">  
									<span>Billing Details</span>									
								</div> 
								<!--<div class="col-md-3">  
									<a href="#">
										<button class="btn btn-edit" id="hide" type="button">Edit</button>
									</a>									
								</div> -->
							</div>           
							   
							<!--<div class="row blog-date" id="details"> 
												 
								<div class="col-md-12 blog-title">  
									<p class="desc"><?php echo $row['fname']." ".$row['lname']; ?><br><?php echo $row['address1']." ".$row['address2']; ?><br>
									<?php echo $row['city']." ".$row['state']." ".$row['pincode']; ?></br><?php echo $row['country']?></p>
								</div> 
								<div class="col-md-12 checkbox">
									<label><input type="checkbox" onclick="add_delivery('<?php echo $row["fname"]; ?>','<?php echo $row["lname"]; ?>','<?php echo $row["city"]; ?>','<?php echo $row["state"]; ?>','<?php echo $row["address1"]; ?>','<?php echo $row["address2"]; ?>','<?php echo $user_id; ?>');">Same as Above</label>
								</div>
							</div>  -->    

							<div class="form" id="details_form">
														
								<form class="form-horizontal" role="form" method="POST"  action="<?php echo WEb_URL ?>cca/ccavRequestHandler.php">
								
								<!--<form class="form-horizontal" role="form" method="POST"  action="">-->
									<input type="hidden" name="currency" value="INR"/>
									<input type="hidden" name="order_id" value="123654789"/>
									<input type="hidden" name="merchant_id" value="94446"/>
									
									<input type="hidden" name="tid" value="<?php echo $cart_master_id ?>"/>
									<input type="hidden" name="amount" value="<?php echo trim($all_total); ?>"/>
									
									<input type="hidden" name="redirect_url" value="<?php echo WEb_URL ?>cca/ccavResponseHandler.php"/>
									<input type="hidden" name="cancel_url" value="<?php echo WEb_URL ?>cca/ccavResponseHandler.php"/>
									<input type="hidden" name="language" value="EN"/>
									  <div class="form-group">
										<div class="col-sm-12">
										  <input type="text" name="billing_name" class="form-control" id="billing_name" placeholder="Enter Name *" required value="<?php echo $row['billing_name'];?>">
										</div>										
									  </div>
									  
									  <div class="form-group">
										<div class="col-sm-12">
											<select class="form-control" required name="billing_country" id="billing_country">
											  <option>India</option>
											  <option>Japan</option>
											  <option>Iraq</option>
											  <option>Kosovo</option>
											</select>
										</div>
									</div>
									 
									   <div class="form-group">
										<div class="col-sm-12">
										  <input type="text"  name="billing_address" class="form-control" id="billing_address" placeholder="Enter Address *" required value="<?php echo $row['billing_address'];?>">
										</div>
									  </div>
									   <div class="form-group">
										<div class="col-sm-6">
										  <input type="text" name="billing_tel" class="form-control" id="billing_tel" placeholder="Enter Mobile Number" required value="<?php echo $row['billing_tel'];?>">
										</div>
										<div class="col-sm-6">
										  <input type="email" name="billing_email" class="form-control" id="billing_email" placeholder="Enter Email" required value="<?php echo $row['billing_email'];?>">
										</div>
									  </div>								  
									
									  <div class="form-group">
										<div class="col-sm-4">
										  <input type="text" name="billing_city" class="form-control" id="billing_city" placeholder="City *" required value="<?php echo $row['billing_city'];?>">
										</div>
										
										<div class="col-sm-4">
											<select class="form-control" name="billing_state" id="billing_state" >
											  <option>Maharshtra</option>
											  <option>Gujrat</option>
											  <option>Rajstan</option>
											  <option>Panjab</option>
											</select>
										</div>
										
										<div class="col-sm-4">
										  <input type="text" class="form-control" name="billing_zip" id="billing_zip" placeholder="Zipcode" required value="<?php echo $row['billing_zip'];?>"/>
										</div>
									  </div>
									   <div class="form-group">
											<div class="col-sm-4">
												<button type="submit" onclick="save($('#name').val());" name="submit" id="submit" class="btn btn-primary1">Save and continue <i class="flaticon-arrow209"></i></button>
											</div>											
										</div>								
								  </div>								
							<!-- Blog Status -->  
						
						</div>                       
					</div>
					
					<div data-animation-delay="300" data-animation="fadeInUp" class="blog-inner animated fadeInUp visible">   
						<div class="container billing-details" id="view">
							<!-- Blog Date and Title -->     
								<div class="row blog-date"> 
								                     
									<div class="col-md-4 blog-title">  
										<span>Delivery Address</span>
										
									</div>
									<div class="col-sm-4">
										<input type="checkbox" checked id="same_address"/>Same as above
									</div>
									
								</div>           
							<!-- Blog Status -->  
							
							<!-- Blog Date and Title -->     
								<div style="display:none;" class="row blog-date"> 
								                     
									<div class="col-md-12 blog-title" id="details1">  
										<p class="desc" id="showing"><?php echo $row['d_fname']." ".$row['d_lname']; ?><br><?php echo $row['d_address1']." ".$row['d_address2']; ?><br>
										<?php echo $row['d_city']." ".$row['d_state']." ".$row['d_pincode']; ?></br><?php echo $row['d_country']?></p>
									</div> 
									
								</div>  
							<div style="display:none;" id="details_form1" class="form-horizontal">								
									  <div class="form-group">
										<div class="col-sm-12">
										  <input type="text" name="delivery_name" class="form-control" id="delivery_name" placeholder="Enter Name *" value="<?php echo $row['delivery_name'];?>"/>
										</div>																			
									  </div>
									  
									  <div class="form-group">
										<div class="col-sm-12">
											<select class="form-control" name="delivery_country" id="delivery_country">
											  <option>India</option>
											  <option>Japan</option>
											  <option>Iraq</option>
											  <option>Kosovo</option>
											</select>
										</div>
									</div>
									 
									   <div class="form-group">
										<div class="col-sm-12">
										  <input type="text"  name="delivery_address" class="form-control" id="delivery_address" placeholder="Enter Address Line 1 *" value="<?php echo $row['delivery_address'];?>"/>
										</div>
									  </div>
									   <div class="form-group">
										<div class="col-sm-12">
										  <input type="text" name="delivery_tel" class="form-control" id="delivery_tel" placeholder="Enter Mobile Number" value="<?php echo $row['delivery_tel'];?>"/>
										</div>
									  </div>								  
									
									  <div class="form-group">
										<div class="col-sm-4">
										  <input type="text" name="delivery_city" class="form-control" id="delivery_city" placeholder="City *" value="<?php echo $row['delivery_city'];?>"/>
										</div>
										<div class="col-sm-4">
										  <select class="form-control" name="delivery_state" id="delivery_state" >
											  <option>Maharshtra</option>
											  <option>Gujrat</option>
											  <option>Rajstan</option>
											  <option>Panjab</option>
											</select>
										</div>
										
										<div class="col-sm-4">
										  <input type="text" class="form-control" name="delivery_zip" placeholder="Zipcode" value="<?php echo $row['delivery_zip'];?>"/>
										</div>
									  </div>
									  <div class="form-group">
											<div class="col-sm-4">
												<button type="submit" onclick="save($('#name').val());" name="submit1" class="btn btn-primary1">Save and continue <i class="flaticon-arrow209"></i></button>
											</div>											
										</div>								  
								</form>
								  </div>								
							<!-- Blog Status -->  
						
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
									<h4 class="bold" style="font-size:32px;">Rs.<?php echo $all_total; ?>/- </h4>
								</div>
								
								<div class="col-md-12 col-sm-6 blog-social social-title text-right">
										<a href="<?php echo WEb_URL ?>cca/ccavRequestHandler.php">
											<button type="button" class="btn btn-right">Checkout</button>
										</a>
								</div>    
							
							</div>
						</div>
					</div>
				</div> 
			</div>
		</div> 
</section>
		
		
<script language="javascript" type="text/javascript">
function add_delivery(fname ,lname ,city,state,address1,address2,user_id){
   var ajaxRequest;  // The variable that makes Ajax possible!
   try{
   
      ajaxRequest = new XMLHttpRequest();
   }catch (e){
      
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
          var ajaxDisplay = document.getElementById('showing');
         ajaxDisplay.innerHTML = ajaxRequest.responseText;  
      }
   }
 
   var queryString = "?fname=" + fname + "&lname=" + lname + "&city=" + city + "&state=" + state + "&address1=" + address1 + "&address2=" + address2 +"&user_id=" + user_id ;
   
   ajaxRequest.open("GET","add_delivery.php" + queryString, true);
   ajaxRequest.send(null); 
}   
</script>
 <!-- FOOTER -->

	<?php include_once('footer.php'); ?>
 
<!-- FOOTER END -->		
	