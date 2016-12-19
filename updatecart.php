<?php
session_start();
$session_id = session_id();
include_once('config/config.php'); 

// Retrieve data from Query String

$id = $_GET['id'];
$qty = $_GET['quantity'];
	
// Escape User Input to help prevent SQL Injection
$id = mysqli_real_escape_string($con,$id);
$qty = mysqli_real_escape_string($con,$qty);
	
$query = "UPDATE tbl_cart SET quantity = '".$qty."' where id = '$id'";
$result = mysqli_query($con,$query);

if(mysql_error() == "")
{	
$i = 0;
$sql_tax = "SELECT tax_rate FROM tbl_service_tax";
$result_tax = mysqli_query($con,$sql_tax);
$row_tax = mysqli_fetch_array($result_tax);
	
$query = "select c.id, c.product_id,c.pack_id, c.quantity, c.rate,s.rate_title,s.image, s.plan_name from tbl_cart as c, tbl_service_plans as s where c.product_id = s.id and c.session_id = '".$session_id."' group by c.id ";
$result = mysqli_query($con,$query);

?>

<?php
while($row = mysqli_fetch_array($result))
{
	$sql_pack = "SELECT pack,rate FROM tbl_product_pack WHERE id = '".$row['pack_id']."' ";
	$result_pack =mysqli_query($con,$sql_pack);
	$row_pack = mysqli_fetch_array($result_pack);
	$all_total = $all_total + $row["rate"]*$row["quantity"];
	$tax = $all_total * $row_tax["tax_rate"] / 100;
		?><div class="row border">									
				<div class="col-md-3 col-sm-3 img-cart">
					<a href="#">
						<img class="img-responsive" src="<?php echo $row["image"]; ?>" alt="">
					</a>
				</div>			
				<div class="col-md-6 col-sm-6">										
					<div class="cart-text">
						<h3><a href="#"><?php echo $row["plan_name"]." " .$row_pack["pack"]?></a></h3>
						<p class="cart-txt"><?php echo $row["rate"]?></p>
					</div>										
					<div class="cart-text">
						<div class="row">
							<div class="col-md-4 col-xs-6">
								<div class="quty">Quantity </div>
							</div>
							
							<div class="col-md-4 col-xs-6">
							<select name="qty" id="qty<?php echo $row["id"]?>">
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
							<div class="col-md-4 col-xs-6">
								<a href="#" class="btn btn-primary btn-sm text-light" id="add-to-cart331" onclick="updateCart(<?php echo $row["id"]?>,$('#qty<?php echo $row["id"]?>').val());"> <i class="fa fa-pencil-square-o"></i> Update Cart</a>
								</div>
						</div>											
					</div>
				</div>									
				<div class="col-md-3 col-sm-3 alert">
					<div class="row">     
																
						<div class="col-md-12 col-md-offset-5 col-xs-12 col-sm-12 alert-to">      
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
				<?  $i++; }   	?>	
							
								<div class="container blog-inner-bottom">        
									<div class="row">  
										<!-- Title -->    
										                                
									<!-- Social Icons -->       
										<div class="col-md-6 col-sm-6 blog-social text-right right">  
											<h3>Total : <span class='bold'>Rs.<?php echo $all_total; ?>/-<span style='RTE'></span> </span></h3>
											<h4>Service tax <?php echo $row_tax["tax_rate"]; ?>%</h4> 
										<?php 
										$all_total = $all_total + $tax;
										$query = "select session_id from tbl_cart where session_id = '".$session_id."' and service_id = 2";
										$result = mysqli_query($con,$query);
										if(mysqli_num_rows($result) > 0)
										{
										$sql_shipping = "SELECT shipping,range1 FROM tbl_charges WHERE range1 < $all_total LIMIT 1";
										$result_shipping =mysqli_query($con,$sql_shipping);
										$row_shipping = mysqli_fetch_array($result_shipping);
										$shipping = $row_shipping['shipping'];
										$row_shipping['range1'];
										
 									if($all_total > 1000 )
									{ ?> <h3>Shipping charges Free</h3> <span style="display:none;" style='#$@'><?php echo $amount = $all_total + $shipping;
									
									} else { ?> <h3>Shipping charges Rs.80/-</h3><span style="display:none;" style='#$@'><?php echo $amount = $all_total + $shipping; ?>
									
									<?php } ?><span style='@@#$@'></div> 
										<?php } else { ?><span style="display:none;" style='#$@'><?php echo $amount; ?> <span style='@@#$@'></div> <?php } ?>
									
									</div>  
									
								</div>                             <!-- Bottom Content Ends -->  
								
								

						
<?	} else
					echo "Some error. Please try again!";?>	