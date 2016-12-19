<?php include_once('header_prod.php');
		$id = $_GET["package_id"];
		
		$sql = "SELECT id, service_id, plan_name,description,offer,bullet_title,bullet_points,rate_title,rate FROM tbl_service_plans where id = '$id' ";
		$result =mysqli_query($con,$sql);
		
  ?>
<!-- HEADER END -->
<?php while($row = mysqli_fetch_array($result)){ $str =  $row["bullet_points"]; ?>
	<section class="blog-outer" id="blog-outer">
			<div class="container shortcodes">  
				<!-- Title & Desc Row Begins --> 
					<div class="row">    
						<div class="col-md-12 header text-center">
                        <!-- Title -->   
						<div class="title"> 
		<?php   $sql_name = "SELECT service_name,image FROM service_master where id = '".$row['service_id']."' ";
				$result_name =mysqli_query($con,$sql_name);
				$row_name = mysqli_fetch_array($result_name);?>
						<h2> <?php echo $row_name["service_name"]?><span></span></h2>
                        </div> 
						<nav class="breadcrumbs ">
							<a href="home.php">Home</a>
							<a href="home.php#unique-home">Packages</a>
							<a href="package.php?id=<?php echo $row["service_id"]?>"><?php echo $row_name["service_name"]?></a>
							<a href="#"><?php echo $row["plan_name"]?></a>
						</nav>
						<!-- Description --> 
                        <p class="desc">We ensure quality &amp; support. People love us &amp; we love them.</p>
						</div> 												
					</div>           
			</div>  

		<div class="container">
			<div class="row">
				<div class="col-md-8">
					
					<div data-animation-delay="300" data-animation="fadeInUp" class="blog-inner animated fadeInUp visible">   
						<div class="container blog-status">
							
								<!-- Image --> 
								<a href="#">								
								
								<div class="row ">
											<div class="col-md-6 col-sm-6">
					<img class="img-responsive" alt="" src=" <?php echo $row_name["image"]?>" style="padding-top:16px; padding-left:16px;">
											</div>											
											<div class="col-md-6 col-sm-6 ">
												<div class="border">
												
													<strong><h4><?php echo $row["plan_name"]; ?></h4> </strong>
													<br>
												</div>
													<p><?php echo $row["description"]; ?></p>
													<br>											
											</div>											
								</div>
								</a>			
								
						</div>                       
					</div>	
					
				</div>		
				<div class="col-md-4">
					<div class="sidebar">  
						<!-- Facebook Sidebar -->    
                        <div data-animation-delay="300" data-animation="fadeInUp" class="sidebar-facebook animated fadeInUp visible"> 
							<div class="row">
								<div class="col-md-8 col-sm-6 ">									
								<h4>
									<?php echo $row["rate_title"]; ?>
									<input type="hidden" name="rate" id="rate<?php echo $row["id"]?>" value="<?php echo $row["rate"]?>"><br></h4>
								</div>
						<!--<div class="col-sm-4">
						<?php if($row["offer"]!=0)	{?>	
						<a class="read-more bold" href="#">	<p class="offer-1"><?php echo $row["offer"]; ?></p><img src="images/offer_package.png"></a><?php } ?>
								</div>-->
								<div class="col-sm-4">
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
							
							<div class="col-md-12 blog-social social-title text-right">
										<a href="#add_to_cart&package_id=<?php echo $row["id"]?>">
									<button class="btn btn-primary" type="button" style="line-height: 2.429;" onclick="addToCart('<?php echo $row["plan_name"]; ?>',<?php echo $row["id"]?>, $('#qty<?php echo $row["id"]?>').val(), $('#rate<?php echo $row["id"]?>').val()); return false;" >Add Cart</button>
								</a>
									</div>    
							</div>
							<ul class="facebook-inner">     
							  <p><strong><?php echo $row["bullet_title"]; ?></strong></p>
							  
							  <?php
								$colors =explode('&*!@',$str);
									foreach ($colors as $value) {?>
								
									<li><i class="fa fa-check"></i><?php echo $value; ?>  </li></br>
								
								<?php } ?> 
							  							
							</ul> 
							<div class="container ">
								<div class="row">  
									<!-- Title --> 
									
									<!-- Social Icons -->   
									
								</div>  
							</div>
							<div class="container ">
								<div class="row">  
									<!-- Title --> 
									
									<!-- Social Icons -->   
									<div class="col-md-12 blog-social social-title text-right">
										<a href="home.php#unique-home">
											<button type="button" class="btn btn-right">Continue Shopping</button>
										</a>
									</div>    
								</div>  
							</div>
							
						</div>  
					</div>          
				</div>
			</div>
</div>
</section>
		
		
    <?php } ?>

			
<!--	<a href="#x" class="overlay" ></a> -->
	
	<?php  $sql = "SELECT id, service_id, plan_name,rate_title,rate FROM tbl_service_plans where id = '$id' ";
	$result =mysqli_query($con,$sql);
	$row = mysqli_fetch_array($result)?>
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
						<img class="img-responsive" alt="" src="<?php URL ?>images/cart.jpg">
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
					<a href="package.php?id=<?php echo $row["service_id"]?>"><button type="submit" id="close" name="Keep_Browsing" class="btn btn-primary-0" >Keep Browsing</button></a>  
					
					
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
function addToCart(package_name ,package_id, quantity, rate){
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
   
   var queryString = "?package_id=" + package_id + "&quantity=" + quantity + "&rate=" + rate;
   
   ajaxRequest.open("GET", "addtocart.php" + queryString, true);
   ajaxRequest.send(null); 
}
//-->
</script>

	<?php include_once('footer.php'); ?>
 
<!-- FOOTER END -->	