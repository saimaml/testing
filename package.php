<?php 
	include_once('header_prod.php');
	session_start();
	$session_id = session_id();
	
	$id = $_GET["id"];
	$package_id = $_GET["package_id"];
	if(isset( $_GET["package_id"]))
	{
		$sql_id = "SELECT id, service_id FROM tbl_service_plans where id = '$package_id' ";
		$result_id =mysqli_query($con,$sql_id);
		$row_id = mysqli_fetch_array($result_id);
		
		$sql = "SELECT id, service_id, plan_name,description,offer,bullet_title,bullet_points,rate_title,rate FROM tbl_service_plans where service_id = '".$row_id['service_id']."'";		
	}
	else
	{
		$sql_id = "SELECT id, service_id FROM tbl_service_plans where id = '$id' ";
		$result_id =mysqli_query($con,$sql_id);
		$row_id = mysqli_fetch_array($result_id);
		
		$sql = "SELECT id, service_id, plan_name,description,offer,bullet_title,bullet_points,rate_title,rate FROM tbl_service_plans where service_id = '$id' ";
	}
 	$result =mysqli_query($con,$sql);
	//$row = mysql_fetch_array($result);
	
	$sql_service = "SELECT id,service_name,image FROM service_master WHERE id = '$id'";
	$result_service = mysqli_query($con,$sql_service);
	$row_service = mysqli_fetch_array($result_service);	
?>  
<style>
.height
{
	height:690px;
}
</style>
<section class="price-table" id="price-table">
            <div class="container pricing-inner">
                <!-- Title & Desc Row Begins -->
                <div class="row">
					<div class="col-md-4">
						<img src="<?php echo $row_service['image'];  ?>"/>
					</div>
                    <div class="col-md-8 text-center">
                        <!-- Title --> 
                       <div class="title">
					   <?php $sql_name = "SELECT id, service_name FROM service_master where id = '$id' ";
							 $result_name =mysql_query($sql_name);
							 $row_name = mysql_fetch_array($result_name);?>
                            <h2> <?php echo $row_name["service_name"]?>  <span></span></h2>
                        </div>
                        <!-- Description --> 
                        <p class="desc white">We ensure quality &amp; support. People love us &amp; we love them. </p>
						
						<nav class="breadcrumbs ">
							<a href="index.php">Home</a>
						</nav>
							 <!-- Title -->                    
						
                    </div>
                </div>
                <!-- Title & Desc Row Ends -->
                <!-- Price Table Row Begins -->
                <div class="row table-row">
                    <!-- Price Table 1 Begins --> 
					<?php while($row = mysqli_fetch_array($result)){ $str =  $row["bullet_points"]; ?>
                    <div data-animation-delay="400" data-animation="fadeInLeft" class="col-md-4 col-sm-6 col-xs-6 animated fadeInLeft visible height">
                        <!-- Price Table Inner -->
                        <div class="pricing-box">
                            <!-- Price Title -->
                            <div class="pricing-title highlight">
                                <h3 class="text-center uppercase white">
                                    <!-- Icon -->
                                    <i class="fa fa-star-o"></i>
                                    <br>
                                   <?php echo $row["plan_name"]; ?> 
                                </h3>
                            </div>
                            <!-- Price -->	
                            <div class="price text-center">
                                <h6 class="bold"><i class="fa fa-tags"></i><?php echo $row["rate_title"]; ?> </h6>
								<input type="hidden" name="rate" id="rate<?php echo $row["id"]?>" value="<?php echo $row["rate"]?>"><br>
								<!-- <h6 class="bold">Rs.2000/-<span>4 Baths/Month</span></h6> -->
                            </div>
                            <!-- Price Table Features -->
							
                            <ul class="">
							<p><strong> <?php echo $row["bullet_title"]; ?> </strong></p>
                               <?php
								$colors =explode('&*!@',$str);
									foreach ($colors as $value) {?>
									<li> <?php echo $value; ?> </li>									
									
								
								<?php } ?> 
								
                              <!--  <li>Integration with Wordpress</li> -->
                            </ul>
							<div class="container border">
							<div class="row">
								<div class="col-sm-6">
									<?php if($row["offer"]!=0)	{?>		
									<a class="read-more bold" href="#">
										<p class="offer"><?php echo $row["offer"]; ?>%Offer</p>
												<img src="<?php echo URL ?>images/offer_package.png">
												
										</a>
									<?php } ?>
								</div>
								
								<div class="col-sm-6 qty">
									<select class="form-control-1" name="qty" id="qty<?php echo $row["id"]?>">
									<?php
									for($i=1; $i<51; $i++)
									{	
										?>
											<option value="<?php echo $i?>"><?php echo $i?></option>
										<?php
									}
									?>
								</select>
								</div>
							</div>
							</div>
                              
							<p>
								<a class="read-more bold" href="item2.php?package_id=<?php echo $row["id"]?>">Read More 
									<i class="fa fa-sign-out"></i>						
								</a>
							</p>
							
							
                            <!-- Price Table Box Inner Ends -->
							
							<!---Button Start---->
							<div class="container blog-inner-bottom black">
							<div class="row">  
							<!-- Title -->                                                
							                                        
							<!-- Social Icons -->                                                
							<div class="col-md-12 col-sm-7 blog-social text-center btn-pad">
								<a href="#add_to_cart&package_id=<?php echo $row["id"]?>">
									<button class="btn btn-primary" type="button" style="line-height: 2.429;" onclick="addToCart('<?php echo $row["plan_name"]; ?>', <?php echo $row["id"]?>, $('#qty<?php echo $row["id"]?>').val(), $('#rate<?php echo $row["id"]?>').val(), <?php echo $row["service_id"]?>); return false;" >Add Cart</button>
								</a>
							
							</div>    
							</div>          
						</div>
							<!---Button End---->				
							<div id="ajaxDiv<?php echo $row["id"]?>"></div>
							</div>
                    </div>
					<?php } ?>
                    <!-- Price Table 1 Ends -->
                   
                    <!-- Price Table 4 Ends -->				
                </div>
                <!-- Price Table Row Ends -->
            </div>
        </section>
	
<!--	<a href="#x" class="overlay" ></a> -->
	
	<?php  $sql = "SELECT id, service_id, plan_name,rate_title,rate FROM tbl_service_plans where id = '$id' ";
	$result =mysql_query($sql);
	$row = mysql_fetch_array($result)?>
      <div class="" id="add_to_cart" style="display:none">
       
			<div class="row border t-heading">
					<header class="h-text-align-center ">
							<h1 style="text-align: center;">
								<i class="fa fa-check"></i>	
							</h1>
						
							<h2 style="text-align: center;" id="ajaxDiv">Item added to your cart</h2>
					</header>
     		</div>
			
				<div class="row package border">
				<div class="col-sm-2 img_left">
						<img class="img-responsive" alt="" src="<?php echo URL ?>images/cart.jpg">
				</div>				
				<div class="col-sm-5">
						<h4 id="added_item"></h4>
				</div>
				<div class="col-sm-2">
					<p><h3 class="price" id="rate_title"></h3></p>
				</div>	
				<div class="col-sm-2">
					<p><h3 class="price" id="quality"></h3></p>
				</div>			
			</div>
			<div class="row  support border">
			
				<div class="inner package">
						
						<label style="float:right; margin-right:100px;">
								<strong>Total :</strong>
						
						<span class="item-upgrade__savings" id="total"></span></label>
				</div>
			</div>
			<div class="row" style=" padding:20px; ">
					<a href="package.php?id=<?php echo $id; ?>"><button type="submit" id="close" name="Keep_Browsing" class="btn btn-primary-0" >Keep Browsing</button></a>  
					
					
						<?php if(isset($_session["user_id"]))		{?>
					<a href="shopping-cart.php?user_id =<?php echo $_session["user_id"];?>"><button type="submit" name="Keep_Browsing" class="btn btn-primary-0" style="float:right;">Go to checkout</button></a>
					<?php }
					else
					{
						?><a href="shopping-cart.php?session_id=<?php echo $session_id;?>"><button type="submit" name="Keep_Browsing" class="btn btn-primary-0" style="float:right;">Go to checkout</button></a>
					<?php }?>
					
					
			</div>
			
   </div>
<!-- FOOTER -->

<script language="javascript" type="text/javascript">
function addToCart(package_name ,package_id, quantity, rate, service_id){
   var ajaxRequest;  // The variable that makes Ajax possible!
   try{
      ajaxRequest = new XMLHttpRequest();       // Opera 8.0+, Firefox, Safari
   }catch (e){
      
     try{
         ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");  // Internet Explorer Browsers
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
         //var ajaxDisplay = document.getElementById('ajaxDiv' + package_id);
         var current_quantity = ajaxRequest.responseText;
		 
		
		$('#total_quantity').text(current_quantity);
		$('#added_item').text(package_name);
		$('#rate_title').text(rate);
		$('#quality').text(quantity);
		$('#total').text(rate*quantity);
		$("#add_to_cart").dialog({ 
			width: "45%",
			maxWidth: "600px"
		});
		
	}
   }
   
   // Now get the value from user and pass it to
   // server script.
   
   var queryString = "?package_id=" + package_id + "&quantity=" + quantity + "&rate=" + rate + "&service_id=" + service_id;
   
   ajaxRequest.open("GET", "addtocart.php" + queryString, true);
   ajaxRequest.send(null); 
}
//-->
</script>

	<?php include_once('footer.php'); ?>
 
<!-- FOOTER END -->	