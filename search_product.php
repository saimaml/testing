<?php
include_once('config/config.php'); 

$name=$_GET["name"];
	
// Escape User Input to help prevent SQL Injection
$name = mysqli_real_escape_string($con,$name);

$sql_product = "SELECT id,plan_name,rate,image FROM tbl_service_plans WHERE plan_name LIKE '%".$name."%'";
$result_product = mysqli_query($con,$sql_product);
$num = mysqli_num_rows($result_product);
if($num > 0)
{
	

?>
<div id="effect-1" class="effects clearfix">
<?php
while($row_product = mysqli_fetch_array($result_product))
{
	$img = explode(",",$row_product["image"]); 	?>
	
	<div class="col-md-4">
		<div class="img">
			<center> <img id="cart_img<?php echo $row_product["id"] ?>" src="<?php echo $img[0] ?>" alt=""></center>
			<div class="overlay">
				<a href="productdetails.php?id=<?php echo $row_product["id"];?>" class="expand">+</a>
			<!-- <a class="close-overlay hidden">x</a> -->
			</div>
		</div>
		<div class="additional-content">
			<p class="productname"><?php echo substr($row_product["plan_name"],0,25); ?>  </p>
			<h5 class="priceprdt"><i class="fa fa-inr" style="color:#000;" aria-hidden="true"></i> <?php echo $row_product["rate"];?></h5>
			<a href="#" class="btn btn-primary btn-sm text-light add-to-cart1" onClick ="addtocart('<?php echo $row_product["id"] ?>');"> <i class="fa fa-shopping-cart" ></i> Add to Cart</a>
		</div>
	</div>	
	<script>
	$(document).ready(function(){
	$('.add-to-cart1').on('click',function(){ 
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
<?php } } else {
	echo "No records found";
}?>
</div>