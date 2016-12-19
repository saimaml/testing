<?php 
	$page = "transaction";
	include_once('header_prod.php'); 
	$sql = "SELECT id,date_purchase,is_paid FROM tbl_cart_master WHERE user_id = '1'";
	$result = mysqli_query($con,$sql);	
?>
<section class="blog-outer" id="blog-outer">
	<div class="container shortcodes">  
		<!-- Title & Desc Row Begins --> 
		<div class="row">    
			<div class="col-md-12 header text-center">
				<!-- Title -->   
				<div class="title"> 
					<h2>Transaction <!-- <span>Cart</span>--></h2>
				</div> 
				<nav class="breadcrumbs ">
					<a href="index.php">Home</a>
					<a href="package.php?id=7">Packages</a>
				</nav>
				<!-- Description --> 
				<p class="desc">We ensure quality &amp; support. People love us &amp; we love them.</p>
			</div> 
		</div>           
	</div> 
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-md-offset-1">
			<div data-animation-delay="300" data-animation="fadeInUp" class="blog-inner animated fadeInUp visible">   
					<div class="container blog-status transction">	
						<div class="col-md-2 col-sm-3">	
							Order no
						</div>
						
						<div class="col-md-3 col-sm-2">
							Status
						</div>	
						<div class="col-md-3 col-sm-2">
							Date purchased
						</div>																	
						<div class="col-md-2 col-sm-2">
							Amount
						</div>
						<div class="col-md-2 col-sm-2">
							Action
						</div>
					</div>
					
					<?php  $i=1; while($row = mysqli_fetch_array($result))
						{  
							$sql_product = "SELECT package_id,sum(quantity*rate)as amount,is_paid FROM tbl_cart WHERE cart_master_id = '".$row['id']."'";
							$result_product = mysqli_query($con,$sql_product);
							$row_product = mysqli_fetch_array($result_product);
						 ?>

					<div class="container border-last">	
						<div class="col-md-2 col-sm-3 stau">						
							<!--<img src="images/cart.jpg"/> --><?php echo $i; ?>
						</div>						
						<div class="col-md-3 col-sm-3 stau">
						<?php if($row_product["is_paid"]==1)
									echo "Your Order is Successful";
							  else if($row_product["is_paid"]==2)
									echo "Your Order is failed";
								else
									echo "Your Order is Pending";?>
						</div>
						<div class="col-md-3 col-sm-3 stau">
							<?php echo $row["date_purchase"]; ?>
						</div>						
						<div class="col-md-2 col-sm-2 stau">
							<?php echo $row_product["amount"]; ?>
						</div>
						<div class="col-md-2 col-sm-2 stau">
							<a href="transaction_details.php?id=<?php echo $row["id"]; ?>">View</a>
						</div>
					</div>
					
					<?php  $i++; } ?>
								
			</div>
		</div>
	</div>
	</div>
</section>

	
<?php	
	include_once('footer.php'); 
 ?> 