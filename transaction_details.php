<?php 
	$page = "transaction";
	include_once('header_prod.php'); 
	$id = $_GET["id"];
	
	$sql = "SELECT package_id,quantity,rate,pack_id FROM tbl_cart WHERE cart_master_id = '$id'";
	$result = mysqli_query($con,$sql);	
?>
<style>
.bold
{
	font-weight:bold !important;
	margin-left:70px;
}
.charge
{
	font-weight:bold !important;
	float:right;
	margin-right: 100px;
}
.total
{
	font-weight:bold !important;
	float:right;
	margin-right: 100px;
}
.btn-primary1 {
    width: 10% !important;
}
</style>
<section class="blog-outer" id="blog-outer">
	<div class="container shortcodes">  
		<!-- Title & Desc Row Begins --> 
		<div class="row">    
			<div class="col-md-12 header text-center">
				<!-- Title -->   
				<div class="title"> 
					<h2>Transaction <span>Details</span></h2>
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
			<div class="col-md-6 col-md-offset-1">
				<div data-animation-delay="300" data-animation="fadeInUp" class="blog-inner animated fadeInUp visible">
					<?php  $sql_order = "SELECT id,date_purchase FROM tbl_cart_master WHERE id = '$id'";
							$result_order = mysqli_query($con,$sql_order); 
							$row_order = mysqli_fetch_array($result_order);
					?>
						<span class="bold">Order no : </span><span><?php echo $row_order["id"]; ?></span>
						<span class="bold">Date Purchased : </span><span><?php echo $row_order["date_purchase"]; ?></span>
					
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
			<div data-animation-delay="300" data-animation="fadeInUp" class="blog-inner animated fadeInUp visible">   
					<div class="container blog-status transction">	
						<div class="col-md-5 col-sm-3">	
								Product Description
						</div>	
						<div class="col-md-2 col-sm-3">	
								Pack
						</div>						
										
						<div class="col-md-2 col-sm-2">
							Price
						</div>
						<div class="col-md-1 col-sm-2">
							Quantity
						</div>
										
						<div class="col-md-2 col-sm-2">
							Order Total
						</div>
					</div>
					<?php while($row = mysqli_fetch_array($result))
							{
								$sql_product = "SELECT plan_name,rate FROM tbl_service_plans WHERE id ='".$row["package_id"]."'";
								$result_product =mysqli_query($con,$sql_product);
								$row_product = mysqli_fetch_array($result_product);
								
								$sql_pack = "SELECT pack FROM tbl_product_pack WHERE product_id='".$row["package_id"]."'";
								$result_pack = mysqli_query($con,$sql_pack);
								$row_pack = mysqli_fetch_array($result_pack);
								
							?>
					<div class="container border-last">	
						<div class="col-md-5 col-sm-3">
							<img src="images/cart.jpg"> <?php echo $row_product["plan_name"];?>
						</div>		
						<div class="col-md-2 col-sm-3 stau">
							<?php echo $row_pack["pack"];?>
						</div>						
						
						<div class="col-md-2 col-sm-2 stau">
							Rs.<?php echo $row_product["rate"];?>
						</div>
						<div class="col-md-1 col-sm-2 stau">
							<?php echo $row["quantity"];?>
						</div>					
						
						<div class="col-md-2 col-sm-2 stau">
							<?php $amt=$row_product["rate"]*$row["quantity"]; echo $amt; ?>
						</div>
					</div>					
				<?php $all_total = $all_total + $amt;}  ?>
				<div class="row">
					
					<?php 
						$sql_shipping = "SELECT shipping,range1 FROM tbl_charges WHERE range1 < $all_total LIMIT 1";
						$result_shipping =mysqli_query($con,$sql_shipping);
						$row_shipping = mysqli_fetch_array($result_shipping);
						$shipping = $row_shipping['shipping']; ?>
												
							<div class="charge">Shipping Charges <span>Rs.<?php echo $shipping; ?></span></div>
												
				</div>
				<div class="row">
					<div class="total">Total <span>Rs.<?php echo $all_total + $shipping ; ?></span>/-</div>
				</div>
			</div>
			<div class="row">
				<form method="POST" action="print.php">
					<input type="hidden" name="cart_master_id" value="<?php echo $id; ?>"/>
					<button class="btn btn-primary1">Print</button>
				</form> 
			</div>
		</div>
	</div>
</section>
	
<?php	
	include_once('footer.php'); 
 ?> 